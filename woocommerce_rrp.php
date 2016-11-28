<?
/*
Plugin Name: WooCommerce RRP calculator
Plugin URI: https://github.com/Ohar/woocommerce_rrp
Description: Plugin adds custom fields WooCommerce products and calculate RRP based on it.
Author: Pavel Lysenko aka Ohar
Author URI: http://ohar.name/
Contributors: ohar
Version: 0.0.2
License: MIT
Text Domain: woocommerce_rrp
Domain Path: /languages
*/

// Inspired by 
// 1. http://www.remicorson.com/mastering-woocommerce-products-custom-fields/
// 2. http://stackoverflow.com/questions/27262032/add-custom-product-field-on-quick-edit-option-on-the-product-listing-of-a-woocom


include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_bulk_edit_save.php');
include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_bulk_edit_show.php');
include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_general_add.php');
include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_general_save.php');
include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_quick_edit_add.php');
include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_quick_edit_show.php');
include_once(plugin_dir_path( __FILE__ ) .'classes/fields/woocommerce_rrp_field_quick_edit_save.php');

include_once(plugin_dir_path( __FILE__ ) .'register-menu.php');

$field_list = array(
	array(
		'id' => 'buy_price',
		'label' => __( 'Buy Price', 'woocommerce_rrp' ),
		'placeholder' => '0',
		'description' => __( 'Price of buying product from vendor', 'woocommerce_rrp' ),
		'type' => 'number',
		'attributes' => array(
			'step' 	=> '1',
			'min'	  => '0'
		)
	),
	array(
		'id' => 'package_price',
		'label' => __( 'Package Price', 'woocommerce_rrp' ),
		'placeholder' => '0',
		'description' => __( 'Price of package material', 'woocommerce_rrp' ),
		'type' => 'number',
		'attributes' => array(
			'step' 	=> '1',
			'min'	  => '0'
		)
	),
	array(
		'id' => 'shipping_price',
		'label' => __( 'Shipping Price', 'woocommerce_rrp' ),
		'placeholder' => '0',
		'description' => __( 'Price of shipping', 'woocommerce_rrp' ),
		'type' => 'number',
		'attributes' => array(
			'step' 	=> '1',
			'min'	  => '0'
		)
	),
	array(
		'id' => 'min_profit',
		'label' => __( 'Minimal Profit', 'woocommerce_rrp' ),
		'placeholder' => '0',
		'description' => __( 'Minimal Profit', 'woocommerce_rrp' ),
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
	