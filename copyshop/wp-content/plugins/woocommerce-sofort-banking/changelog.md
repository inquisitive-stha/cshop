# Changelog

## 1.1.18
* Added "untraceable" payments to payment listener for users without sofort banking account
* Added filter for payment reasons
* Adding reasons, coming from sofort.com also to log
* Changed note where to find logs in configuration

## 1.1.17
- Reworked Payment process - JS Redirection is not needed anymore
- Setting Order "On-Hold" after payment was credited. Order mail will not be send out if customer stops payment process.

## 1.1.16
- Removed deprecated woocommerce_mail function
- Added Status update to on-hold on payment processing
- Making the payment method description filterable

## 1.1.15
- Changed from Rheinschmiede to Awesome UG

## 1.1.14
- fix Notice: WC_Shortcode_Checkout-> output was called with a parameter or argument that is deprecated since version 2.1

## 1.1.13
- Fixed Fatal error if WooCommerce was not installed before

## 1.1.12
- Removed unnecessary check in admin options

## 1.1.11
- Checking if array key is existing, before accessing it

## 1.1.10
- Fixed wrong error message
- Fixed missing hungarian currency
- Extended log entries on failing request
- Trust pending payments set on off, better trust on payment listener

## 1.1.9
- Added currency check to show for showing problems with currencies to user
- Removed setting of $this->enabled


## 1.1.8
- Replaced get_option( 'woocommerce_currency' ) with get_woocommerce_currency()
- Added and updated german translations
- Fixed link to options page

## 1.1.7
- Fix wc_enqueue_js check

## 1.1.6

- WooCommerce 2.1 ready

## 1.1.5

- Added JavaScript redirection after placing order

## 1.1.4

- Support sequencial order numbers

## 1.1.3

- Updater

## 1.1.1

- Pass correct gateway IPN to sofort

## 1.1

- Fixed the callback/IPN - new callback is ?wc-api=WooCommerce_Sofortueberweisung

## 1.0

- First Release