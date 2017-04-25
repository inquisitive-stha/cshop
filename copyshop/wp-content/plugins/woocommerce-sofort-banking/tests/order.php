<?php

/**
 * Sofortüberweisung Unittests for WordPress
 *
 * @package WordPress-Unittests/WooCommerce/SofortBanking
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

require_once( 'wp-testsuite/testsuite.php' );

class WooSofort extends WooCommerce_Tests
{
	/**
	 * Construct
	 */
	public function init()
	{
		$this->shop_url = '/shop/';
		$this->cart_url = '/cart/';
		$this->checkout_url = '/checkout/';
	}

	/**
	 * Method testSofort
	 *
	 * @test
	 */
	public function testOrder()
	{
		$this->add_to_cart( array( 70 ) );

		$customer_data = array(
			'first_name' => 'Max',
			'last_name' => 'Mustermann',
			'company' => 'Musterfirma',
			'email' => 'support@awesome.ug',
			'phone' => '110',
			'address_1' => 'Musterweg 1',
			'address_2' => '',
			'postcode' => '66666',
			'city' => 'Musterstadt',
		);

		$this->checkout( $customer_data, 'sofortgateway' );
		$this->pay();
	}

	public function pay()
	{
		sleep( $this->std_sleep + 4 );

		$this->byId( "MultipaysSessionSenderBankCode" )->value( "88888888" );
		$this->byXPath( "//button[@type='submit']" )->click();

		$this->byId( "BackendFormLOGINNAMEUSERID" )->value( "123456789" );
		$this->byId( "BackendFormUSERPIN" )->value( "qwertzuiop" );

		$this->byXPath( "//button[@type='submit']" )->click();
		$this->byId( "MultipaysSessionSenderAccountNumberTechnical12345678-99" )->click();

		$this->byXPath( "//button[@type='submit']" )->click();
		$this->byId( "BackendFormTan" )->value( "12345" );

		$this->byXPath( "//button[@type='submit']" )->click();
		$this->byName( "data[Wizard][submit]" )->click();

		sleep( $this->std_sleep + 5 );

		$order_id = $this->byCssSelector( '.order_details .order strong' )->text();
		$this->assertTrue( is_numeric( $order_id ) );
	}
}
