<?

defined( 'ABSPATH' ) or die( '' );

function woocommerce_rrp_register_setting() {
	register_setting( 'woocommerce_rrp_options', 'my_option_name' ); 
}

add_action( 'admin_init', 'woocommerce_rrp_register_setting' );
