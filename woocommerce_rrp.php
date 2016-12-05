<?
/*
Plugin Name: WooCommerce RRP calculator
Plugin URI: https://github.com/Ohar/woocommerce_rrp
Description: Plugin adds custom fields WooCommerce products and calculate RRP based on it.
Author: Pavel Lysenko aka Ohar
Author URI: http://ohar.name/
Contributors: ohar
Version: 1.0.4
License: MIT
Text Domain: woocommerce_rrp
Domain Path: /languages
*/

// Inspired by 
// 1. http://www.remicorson.com/mastering-woocommerce-products-custom-fields/
// 2. http://stackoverflow.com/questions/27262032/add-custom-product-field-on-quick-edit-option-on-the-product-listing-of-a-woocom

defined( 'ABSPATH' ) or die( '' );

include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_bulk_edit_save.php');
include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_bulk_edit_show.php');
include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_general_add.php');
include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_general_save.php');
include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_quick_edit_add.php');
include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_quick_edit_show.php');
include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_quick_edit_save.php');

include_once(plugin_dir_path( __FILE__ ) .'options.php');
include_once(plugin_dir_path( __FILE__ ) .'add_calculated_rrp_to_product.php');
include_once(plugin_dir_path( __FILE__ ) .'add_table_column.php');
include_once(plugin_dir_path( __FILE__ ) .'add_calculate_rrp_btn_to_bulk_edit.php');

$field_list = array(
	array(
		'id' => 'buy_price',
		'label' => __( 'Buy Price', 'woocommerce_rrp' ).', '.get_woocommerce_currency_symbol(),
		'placeholder' => '0',
		'description' => __( 'Cost of buying product from vendor', 'woocommerce_rrp' ),
		'type' => 'number',
		'attributes' => array(
			'step' 	=> '1',
			'min'	  => '0'
		)
	),
	array(
		'id' => 'package_cost',
		'label' => __( 'Package Cost', 'woocommerce_rrp' ).', '.get_woocommerce_currency_symbol(),
		'placeholder' => get_option('package_cost'),
		'description' => __( 'Cost of package material for this specific product', 'woocommerce_rrp' ),
		'type' => 'number',
		'attributes' => array(
			'step' 	=> '1',
			'min'	  => '0'
		)
	),
	array(
		'id' => 'shipping_cost',
		'label' => __( 'Shipping Cost', 'woocommerce_rrp' ).', '.get_woocommerce_currency_symbol(),
		'placeholder' => get_option('shipping_cost'),
		'description' => __( 'Cost of shipping for this specific product', 'woocommerce_rrp' ),
		'type' => 'number',
		'attributes' => array(
			'step' 	=> '1',
			'min'	  => '0'
		)
	),
	array(
		'id' => 'ads_cost',
		'label' => __( 'Ads Cost', 'woocommerce_rrp' ).', '.get_woocommerce_currency_symbol(),
		'placeholder' => get_option('ads_cost'),
		'description' => __( 'Cost of advertising for this specific product', 'woocommerce_rrp' ),
		'type' => 'number',
		'attributes' => array(
			'step' 	=> '1',
			'min'	  => '0'
		)
	),
	array(
		'id' => 'tax_rate',
		'label' => __( 'Tax Rate, %', 'woocommerce_rrp' ),
		'placeholder' => get_option('tax_rate'),
		'description' => __( 'Tax rate on the result price', 'woocommerce_rrp' ),
		'type' => 'number',
		'attributes' => array(
			'step' 	=> '1',
			'min'	  => '0',
			'max'	  => '100'
		)
	),
	array(
		'id' => 'min_profit',
		'label' => __( 'Minimal Profit', 'woocommerce_rrp' ).', '.get_woocommerce_currency_symbol(),
		'placeholder' => get_option('min_profit'),
		'description' => __( 'Minimal profit for this specific product, ₽', 'woocommerce_rrp' ),
		'type' => 'number',
		'attributes' => array(
			'step' 	=> '1',
			'min'	  => '0'
		)
	),
	array(
		'id' => 'desired_profit',
		'label' => __( 'Desired Profit, %', 'woocommerce_rrp' ),
		'placeholder' => get_option('desired_profit'),
		'description' => __( 'Desired profit for this specific product, % from price', 'woocommerce_rrp' ),
		'type' => 'number',
		'attributes' => array(
			'step' 	=> '1',
			'min'	  => '0'
		)
	),
);

foreach ($field_list as $field) {
	new WoocommerceRrpFieldGeneralAdd ($field);
	new WoocommerceRrpFieldGeneralSave ($field);
	new WoocommerceRrpFieldBulkEditShow ($field);
	new WoocommerceRrpFieldBulkEditSave ($field);
	new WoocommerceRrpFieldQuickEditAdd ($field);
	new WoocommerceRrpFieldQuickEditShow ($field);
	new WoocommerceRrpFieldQuickEditSave ($field);
}
