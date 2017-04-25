<?php
/**
 * Sofort.com Gateway
 *
 * @package WordPress
 * @subpackage Woocommmerce
 * @author Sven Wagener & MarketPress
 * @copyright 2015, Awesome UG
 * @link http://awesome.ug
 * @license http://www.opensource.org/licenses/gpl-2.0.php GPL License
 *
 * Copyright 2015 (very@awesome.ug)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// No direct access is allowed
if( !defined( 'ABSPATH' ) )
	exit;

if( !class_exists( 'WooCommerce_Sofortueberweisung' ) ) :

	/**
	 * Handles the actual gateway (SOFORT Banking)
	 *
	 * Adds admin options, frontend fields
	 * and handles payment processing
	 *
	 * @since   1.0
	 */
	class WooCommerce_Sofortueberweisung extends WC_Payment_Gateway
	{
		/**
		 * Initialize the Gateway
		 *
		 * @since 1.0.0
		 */
		public function __construct()
		{
			global $woocommerce;

			$this->id = 'sofortgateway';
			$this->icon = apply_filters( 'woogate_sofortgateway_icon', WOOGATE_URLPATH . '/images/sofortgateway.png' );
			$this->has_fields = FALSE;
			$this->callback = str_replace( 'https:', 'http:', add_query_arg( 'wc-api', 'WooCommerce_Sofortueberweisung', home_url( '/' ) ) );

			// Load the form fields.
			$this->init_form_fields();

			// Load the settings.
			$this->init_settings();

			$this->title = $this->settings[ 'title' ];
			$this->description = $this->settings[ 'description' ];
			$this->configkey = $this->settings[ 'configkey' ];
			$this->notify_email = $this->settings[ 'notify_email' ];
			$this->trust_pending = $this->settings[ 'trust_pending' ];
			$this->debug = $this->settings[ 'debug' ];

			if( $this->debug == 'yes' ):
				if( class_exists( 'WC_Logger' ) ):
					$this->log = new WC_Logger();
				else:
					$this->log = $woocommerce->logger();
				endif;
			endif;

			// Payment listener/API hook
			add_action( 'woocommerce_api_' . strtolower( get_class( $this ) ), array( &$this, 'payment_listener' ) );

			/* 1.6.6 */
			add_action( 'woocommerce_update_options_payment_gateways', array( &$this, 'process_admin_options' ) );
			/* 2.0.0 */
			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array(
				$this,
				'process_admin_options'
			) );
		}

		/**
		 * Add all form fields
		 *
		 * @since 1.0.0
		 */
		public function init_form_fields()
		{
			$this->form_fields = array(
				'enabled'       => array(
					'title'   => __( 'Enable/Disable', 'woogate' ),
					'type'    => 'checkbox',
					'label'   => __( 'Enable SOFORT Banking', 'woogate' ),
					'default' => 'yes'
				),
				'title'         => array(
					'title'       => __( 'Title', 'woogate' ),
					'type'        => 'text',
					'description' => __( 'This controls the title which the user sees during checkout.', 'woogate' ),
					'default'     => __( 'SOFORT Banking', 'woogate' )
				),
				'description'   => array(
					'title'       => __( 'Description', 'woogate' ),
					'type'        => 'textarea',
					'description' => __( 'This controls the description which the user sees during checkout.', 'woogate' ),
					'default'     => __( 'You can pay with your SOFORT Banking-enabled bank account.', 'woogate' )
				),
				'configkey'     => array(
					'title'       => __( 'Config Key', 'woogate' ),
					'type'        => 'text',
					'description' => __( 'You need to enter your configkey or userid:projektid:apikey', 'woogate' ),
					'default'     => ''
				),
				'notify_email'  => array(
					'title'       => __( 'Notification email', 'woogate' ),
					'type'        => 'text',
					'description' => __( 'Enter your email address if you would like to receive status changes for payments.', 'woogate' ),
					'default'     => ''
				),
				'trust_pending' => array(
					'title'   => __( 'Trust pending payments', 'woogate' ),
					'type'    => 'checkbox',
					'label'   => __( 'Accept payments from sofort.com with the status "pending" or "untraceable" (untraceable for users without sofort banking account) and complete order.', 'woogate' ),
					'default' => 'no'
				),
				'debug'         => array(
					'title'   => __( 'Debug', 'woogate' ),
					'type'    => 'checkbox',
					'label'   => __( 'If you experience problems enable logging which will be logged in WordPress Admin > WooCommerce > System Status > Logs.', 'woogate' ),
					'default' => 'no'
				)
			);
		}

		/**
		 * Add an options panel to the Woocommerce settings
		 *
		 * @since 1.0.0
		 */
		public function admin_options()
		{
			?>
			<h3><?php _e( 'SOFORT Banking', 'woogate' ); ?></h3>
			<p><?php _e( 'WooCommerce SOFORT Banking integrates SOFORT Banking from sofort.com into your WooCommerce store.', 'woogate' ); ?></p>
			<?php
			echo '<table class="form-table">';
			$this->generate_settings_html();
			echo '</table>';
		}

		/**
		 * Check the response from Sofort.com
		 *
		 * @since 1.0.0
		 *
		 * @uses  woocommerce_mail_template()
		 * @uses  woocommerce_mail()
		 * @uses  update_post_meta()
		 */
		public function payment_listener()
		{
			require_once( WOOGATE_ABSPATH . 'library/sofortLib.php' );

			$api = new SofortLib_Notification();
			$api->getNotification();

			$txn_id = $api->getTransactionId();

			$data = new SofortLib_TransactionData( $this->configkey );
			$data->setTransaction( $txn_id );
			$data->sendRequest();

			$reason = $data->getStatusReason();
			$order_id = $data->getUserVariable( 0 );
			$first_name = $data->getUserVariable( 1 );
			$last_name = $data->getUserVariable( 2 );
			$email = $data->getUserVariable( 3 );
			$order_key = $data->getUserVariable( 4 );
			$status = $data->getStatus();

			$order = new WC_Order( $order_id );

			if( $this->debug == 'yes' )
			{
				$this->log->add( 'sofortgateway', 'Payment Listener: Updating status for order #' . $order_id . ' to "' . $status . '" with reason "' . $reason . '" by sofort.com' );
			}

			if( $order->order_key !== $order_key )
			{
				wp_die( 'Invalid Request' );
			}

			switch ( $status )
			{
				case 'pending':
					if( 'yes' == $this->trust_pending )
					{
						if( $order->status == 'completed' )
						{
							exit;
						}

						$order->add_order_note( __( 'Payment via SOFORT Banking completed', 'woogate' ) );
						$order->payment_complete();

						update_post_meta( $order_id, 'Payer email address', $email );
						update_post_meta( $order_id, 'Transaction ID', $txn_id );
						update_post_meta( $order_id, 'Payer first name', $first_name );
						update_post_meta( $order_id, 'Payer last name', $last_name );
					}else
					{
						$order->update_status( 'pending', sprintf( __( 'Payment %s via SOFORT Banking.', 'woogate' ), strtolower( $status ) ) );
					}
					break;

				case 'untraceable':
					if( 'yes' == $this->trust_pending )
					{
						if( $order->status == 'completed' )
						{
							exit;
						}

						$order->add_order_note( __( 'Payment via SOFORT Banking completed', 'woogate' ) );
						$order->payment_complete();

						update_post_meta( $order_id, 'Payer email address', $email );
						update_post_meta( $order_id, 'Transaction ID', $txn_id );
						update_post_meta( $order_id, 'Payer first name', $first_name );
						update_post_meta( $order_id, 'Payer last name', $last_name );
					}else
					{
						$order->update_status( 'pending', sprintf( __( 'Payment %s via SOFORT Banking.', 'woogate' ), strtolower( $status ) ) );
					}
					break;

				case 'loss':
					$order->update_status( 'failed', sprintf( __( 'Payment failed via SOFORT Banking (%s).', 'woogate' ), strtolower( $reason ) ) );
					break;

				case 'refunded':
					$order->update_status( 'refunded', sprintf( __( 'Payment %s via SOFORT Banking.', 'woogate' ), strtolower( $status ) ) );

					$message = woocommerce_mail_template( __( 'Order refunded/reversed', 'woogate' ), sprintf( __( 'Order #%s has been marked as refunded - : %s', 'woogate' ), $order->get_order_number(), $reason ) );

					wc_mail( get_option( 'woocommerce_new_order_email_recipient' ), sprintf( __( 'Payment for order #%s refunded/reversed', 'woogate' ), $order->get_order_number() ), $message );
					break;

				case 'received':
					if( $reason == 'consumer_protection' )
					{

						$order->update_status( 'refunded', sprintf( __( 'Payment %s via SOFORT Banking (%s).', 'woogate' ), strtolower( $status ), $reason ) );
					}
					elseif( $reason == 'credited' )
					{
						$order->update_status( 'on-hold', __( 'Awaiting Sofort.com payment.', 'woocommerce-barzahlen' ) );

						if( $order->status == 'completed' )
						{
							exit;
						}

						$order->add_order_note( __( 'Payment via SOFORT Banking completed', 'woogate' ) );
						$order->payment_complete();

						update_post_meta( $order_id, 'Payer email address', $email );
						update_post_meta( $order_id, 'Transaction ID', $txn_id );
						update_post_meta( $order_id, 'Payer first name', $first_name );
						update_post_meta( $order_id, 'Payer last name', $last_name );
					}
					break;

				default :
					// nothing here on purpose
					break;
			}
		}

		/**
		 * Even though we don't really have any fields
		 * we still need to output something, otherwise
		 * we get a fatal error
		 *
		 * @since 1.0.0
		 *
		 * @uses  wpautop()
		 * @uses  wptexturize()
		 */
		public function payment_fields()
		{
			$description = $this->get_description();

			if( ! empty( $description ) )
			{
				echo wpautop( wptexturize( $description ) );
			}
		}

		/**
		 * Process the payment
		 *
		 * Does not really do anything, except redirect the user.
		 * Order processing is done in self::payment_listener()
		 *
		 * @since 1.0.0
		 *
		 * @param $order_id   int     Internal WP post ID
		 *
		 * @uses  add_query_arg()
		 * @uses  get_permalink()
		 * @uses  get_option()
		 * @return array
		 */
		public function process_payment( $order_id )
		{
			require_once( WOOGATE_ABSPATH . 'library/sofortLib.php' );

			$order = wc_get_order( $order_id );

			if( $this->debug == 'yes' )
			{
				$this->log->add( 'sofortgateway', 'Generating payment link for order #' . $order->get_order_number() . '. Notify URL: ' . $this->callback );
			}

			$api = new SofortLib_Multipay( $this->configkey );

			$payment_amount = (float) number_format( $order->order_total, 2, '.', '' );
			$payment_reason[ 0 ] = apply_filters( 'woogate_sofort_transaction_reason_1', sprintf( __( 'Order %s - %s', 'woogate' ), $order->get_order_number(), get_bloginfo( 'name' ) ) );
			$payment_reason[ 1 ] = apply_filters( 'woogate_sofort_transaction_reason_2', '' );

			$api->setAmount( $payment_amount, get_woocommerce_currency() );
			$api->setReason( $payment_reason[ 0 ], $payment_reason[ 1 ] );

			$api->setNotificationUrl( $this->callback );

			$return_url = $this->get_return_url( $order );
			$api->setSuccessUrl( $return_url );

			if( $this->debug == 'yes' )
			{
				$this->log->add( 'sofortgateway', 'Return URL for order #' . $order->get_order_number() . ': ' . $return_url );
			}

			$api->addUserVariable( $order->id );
			$api->addUserVariable( $order->billing_first_name );
			$api->addUserVariable( $order->billing_last_name );
			$api->addUserVariable( $order->billing_email );
			$api->addUserVariable( $order->order_key );

			$cancel_order_url = $order->get_cancel_order_url();
			$api->setAbortUrl( $cancel_order_url );

			if( !empty( $this->notify_email ) )
			{
				$api->setNotificationEmail( $this->notify_email );
			}

			$api->setSofortueberweisung();
			$api->sendRequest();

			if( $api->isError() )
			{
				if( $this->debug == 'yes' )
				{
					$this->log->add( 'sofortgateway', 'Link generation error for order #' . $order->get_order_number() . '. Error: ' . $api->getError() );
				}

				wc_add_notice( sprintf( __( 'SOFORT Banking could not get contacted. Please contact the site admin at %s or choose another payment method.', 'woogate' ), get_option( 'admin_email' ) ), 'error' );

				return array(
					'result'   => 'error',
					'redirect' => $order->get_checkout_payment_url( TRUE )
				);
			}
			else
			{
				return array(
					'result'   => 'success',
					'redirect' =>$api->getPaymentUrl()
				);
			}
		}
	}
endif;

/**
 * Add to the gateways array
 *
 * Can't be part of the class as this function basically
 * registers the gateway
 *
 * @since 1.0.0
 * @param array $methods Holds all registered gateway options
 * @return array $methods
 */
function woogate_add_payment_gateway( $methods )
{
	$methods[] = 'WooCommerce_Sofortueberweisung';

	return $methods;
}

add_filter( 'woocommerce_payment_gateways', 'woogate_add_payment_gateway' );