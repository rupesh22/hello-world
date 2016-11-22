<?php
/**
 * WooCommerce API Client Class
 *
 * @version 2.0.0
 * @license GPL 3 or later http://www.gnu.org/licenses/gpl.html
 */

$dir = dirname( __FILE__ ) . '/woocommerce-api/';

// base class
 if( ! class_exists( 'WC_API_Client' ) ) {
require_once( $dir . 'class-wc-api-client.php' );
}
// plumbing
 if( ! class_exists( 'WC_API_Client_Authentication' ) ) {
require_once( $dir . 'class-wc-api-client-authentication.php' );
}
 if( ! class_exists( 'WC_API_Client_HTTP_Request' ) ) {
require_once( $dir . 'class-wc-api-client-http-request.php' );
}
// exceptions
 if( ! class_exists( 'WC_API_Client_Exception' ) ) {
require_once( $dir . '/exceptions/class-wc-api-client-exception.php' );
}
 if( ! class_exists( 'WC_API_Client_HTTP_Exception' ) ) {
require_once( $dir . '/exceptions/class-wc-api-client-http-exception.php' );
}
// resources
 if( ! class_exists( 'WC_API_Client_Resource' ) ) {
require_once( $dir . '/resources/abstract-wc-api-client-resource.php' );
}
 if( ! class_exists( 'WC_API_Client_Resource_Coupons' ) ) {
require_once( $dir . '/resources/class-wc-api-client-resource-coupons.php' );
}
 if( ! class_exists( 'WC_API_Client_Resource_Custom' ) ) {
require_once( $dir . '/resources/class-wc-api-client-resource-custom.php' );
}
 if( ! class_exists( 'WC_API_Client_Resource_Customers' ) ) {
require_once( $dir . '/resources/class-wc-api-client-resource-customers.php' );
}
 if( ! class_exists( 'WC_API_Client_Resource_Index' ) ) {
require_once( $dir . '/resources/class-wc-api-client-resource-index.php' );
}
 if( ! class_exists( 'WC_API_Client_Resource_Orders' ) ) {
require_once( $dir . '/resources/class-wc-api-client-resource-orders.php' );
}
 if( ! class_exists( 'WC_API_Client_Resource_Order_Notes' ) ) {
require_once( $dir . '/resources/class-wc-api-client-resource-order-notes.php' );
}
 if( ! class_exists( 'WC_API_Client_Resource_Order_Refunds' ) ) {
require_once( $dir . '/resources/class-wc-api-client-resource-order-refunds.php' );
}
 if( ! class_exists( 'WC_API_Client_Resource_Products' ) ) {
require_once( $dir . '/resources/class-wc-api-client-resource-products.php' );}
 
 if( ! class_exists( 'WC_API_Client_Resource_Reports' ) ) {
require_once( $dir . '/resources/class-wc-api-client-resource-reports.php' );
}
 if( ! class_exists( 'WC_API_Client_Resource_Webhooks' ) ) {
require_once( $dir . '/resources/class-wc-api-client-resource-webhooks.php' );
}
