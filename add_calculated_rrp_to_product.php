<?

defined( 'ABSPATH' ) or die( '' );

include_once(plugin_dir_path( __FILE__ ) .'calculate_rrp.php');
include_once(plugin_dir_path( __FILE__ ) .'get_rrp_param.php');

add_action( 'woocommerce_product_options_general_product_data', 'woocommerce_rrp_add_calculated_rrp_to_product', 99);

function woocommerce_rrp_add_calculated_rrp_to_product () {
	global $woocommerce, $post;
	
	$post_id = $post->ID;
	$buy_price = get_post_meta($post_id, 'buy_price', true);
	
	$rrp_calc_params = array(
		'ads_cost'       => get_rrp_param($post_id, 'ads_cost'),	
		'shipping_cost'  => get_rrp_param($post_id, 'shipping_cost'),	
		'package_cost'   => get_rrp_param($post_id, 'package_cost'),	
		'min_profit'     => get_rrp_param($post_id, 'min_profit'),	
		'desired_profit' => get_rrp_param($post_id, 'desired_profit'),	
		'tax_rate'       => get_rrp_param($post_id, 'tax_rate'),
	);
	
	?>
	<div class="options_group">
		<p class="form-field">
			<label for="calculated_rrp"><?=__( 'RRP, ₽', 'woocommerce_rrp' )?></label>
			<input class="short" 
			       id="calculated_rrp" 
			       value="<?=calculate_rrp($buy_price, $rrp_calc_params)?>" 
			       readonly>
		</p>
	</div>
	<?
}