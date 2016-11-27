<?

// L10N

add_action( 'plugins_loaded', 'woocommerce_rrp_field_load_l10n' );

function woocommerce_rrp_field_load_l10n() {
	load_plugin_textdomain( 'woocommerce_rrp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

