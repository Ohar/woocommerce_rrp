<?

defined( 'ABSPATH' ) or die( '' );

include_once(plugin_dir_path( __FILE__ ) .'calculate_rrp.php');
include_once(plugin_dir_path( __FILE__ ) .'get_rrp_param.php');

/* Заголовок колонки */
add_filter('manage_product_posts_columns', 'woocommerce_rrp_product_table_head', 10, 1);
function woocommerce_rrp_product_table_head( $columns ) {
    $columns['buy_price']  = __( 'Buy Price', 'woocommerce_rrp' );
    $columns['rrp']  = __( 'RRP', 'woocommerce_rrp' );
		
    return $columns;
}

/* Содержание колонки */
add_action( 'manage_product_posts_custom_column', 'woocommerce_rrp_add_column_buy_price', 10, 2 );
function woocommerce_rrp_add_column_buy_price( $column, $post_id ) {
    if ( $column == 'buy_price' ) {
			$buy_price = round(get_post_meta( $post_id, 'buy_price', true ));
			?>
			<p style="text-align:right">
				<?=$buy_price?>&nbsp;<?=get_woocommerce_currency_symbol()?>
			</p>
			<?
    }
		
    if ( $column == 'rrp' ) {
			$buy_price = get_post_meta( $post_id, 'buy_price', true );
	
			$rrp_calc_params = array(
				'ads_cost'       => get_rrp_param($post_id, 'ads_cost'),	
				'shipping_cost'  => get_rrp_param($post_id, 'shipping_cost'),	
				'package_cost'   => get_rrp_param($post_id, 'package_cost'),	
				'min_profit'     => get_rrp_param($post_id, 'min_profit'),	
				'desired_profit' => get_rrp_param($post_id, 'desired_profit'),	
				'tax_rate'       => get_rrp_param($post_id, 'tax_rate'),
			);
	
			$calculated_rrp = calculate_rrp($buy_price, $rrp_calc_params);
			?>
			<p style="text-align:right">
				<?=$calculated_rrp?>&nbsp;<?=get_woocommerce_currency_symbol()?>
			</p>
			<?
    }
}
