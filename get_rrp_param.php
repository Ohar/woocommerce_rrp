<?

defined( 'ABSPATH' ) or die( '' );

function get_rrp_param ($product_id, $prop_id) {
	$prop_meta = get_post_meta($product_id, $prop_id, true);
	$prop_options = get_option($prop_id);
	$prop = $prop_meta === '' ? $prop_options : $prop_meta;
	return $prop;
}
