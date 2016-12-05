<?

// https://www.skyverge.com/blog/add-custom-bulk-action/

defined( 'ABSPATH' ) or die( '' );

include_once(plugin_dir_path( __FILE__ ) .'get_rrp_param.php');

if (!class_exists('Woocommerce_RRP_Add_Set_Price_To_RRP_Btn_To_Bulk_Edit')) {
 
	class Woocommerce_RRP_Add_Set_Price_To_RRP_Btn_To_Bulk_Edit {
		
		public function __construct() {
			
			if(is_admin()) {
				// admin actions/filters
				add_action('admin_footer-edit.php', array(&$this, 'woocommerce_rrp_add_bulk_admin_footer'));
				add_action('load-edit.php',         array(&$this, 'woocommerce_rrp_add_bulk_on_edit'));
				add_action('admin_notices',         array(&$this, 'woocommerce_rrp_add_bulk_admin_notices'));
			}
		}
		
		
		/**
		 * Step 1: add the custom Bulk Action to the select menus
		 */
		function woocommerce_rrp_add_bulk_admin_footer() {
			global $post_type;
			
			if($post_type == 'product') {
				?>
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery('<option>').val('set_price_to_rrp').text('<?php _e('Set price to RRP')?>').appendTo("select[name='action']");
							jQuery('<option>').val('set_price_to_rrp').text('<?php _e('Set price to RRP')?>').appendTo("select[name='action2']");
						});
					</script>
				<?php
	    	}
		}
		
		
		/**
		 * Step 2: handle the custom Bulk Action
		 * 
		 * Based on the post http://wordpress.stackexchange.com/questions/29822/custom-bulk-action
		 */
		function woocommerce_rrp_add_bulk_on_edit() {
			global $typenow;
			$post_type = $typenow;
			
			if($post_type == 'product') {
				
				// get the action
				$wp_list_table = _get_list_table('WP_Posts_List_Table');  // depending on your resource type this could be WP_Users_List_Table, WP_Comments_List_Table, etc
				$action = $wp_list_table->current_action();
				
				$allowed_actions = array("set_price_to_rrp");
				if(!in_array($action, $allowed_actions)) return;
				
				// security check
				check_admin_referer('bulk-posts');
				
				// make sure ids are submitted.  depending on the resource type, this may be 'media' or 'ids'
				if(isset($_REQUEST['post'])) {
					$post_ids = array_map('intval', $_REQUEST['post']);
				}
				
				if(empty($post_ids)) return;
				
				// this is based on wp-admin/edit.php
				$sendback = remove_query_arg( array('price_setted_to_rrp', 'untrashed', 'deleted', 'ids'), wp_get_referer() );
				if ( ! $sendback )
					$sendback = admin_url( "edit.php?post_type=$post_type" );
				
				$pagenum = $wp_list_table->get_pagenum();
				$sendback = add_query_arg( 'paged', $pagenum, $sendback );
				
				switch($action) {
					case 'set_price_to_rrp':
						
						// if we set up user permissions/capabilities, the code might look like:
						//if ( !current_user_can($post_type_object->cap->export_post, $post_id) )
						//	wp_die( __('You are not allowed to export this post.') );
						
						$price_setted_to_rrp = 0;
						foreach( $post_ids as $post_id ) {
							
							$buy_price = get_post_meta($post_id, 'buy_price', true);
							$rrp_calc_params = array(
								'ads_cost'       => get_rrp_param($post_id, 'ads_cost'),	
								'shipping_cost'  => get_rrp_param($post_id, 'shipping_cost'),	
								'package_cost'   => get_rrp_param($post_id, 'package_cost'),	
								'min_profit'     => get_rrp_param($post_id, 'min_profit'),	
								'desired_profit' => get_rrp_param($post_id, 'desired_profit'),	
								'tax_rate'       => get_rrp_param($post_id, 'tax_rate'),
							);							
							
							$caluculated_rrp = calculate_rrp($buy_price, $rrp_calc_params);
							
							update_post_meta( $post_id, '_regular_price', $caluculated_rrp );
			
							$price_setted_to_rrp++;
						}
						
						$sendback = add_query_arg( array('price_setted_to_rrp' => $price_setted_to_rrp, 'ids' => join(',', $post_ids) ), $sendback );
					break;
					
					default: return;
				}
				
				$sendback = remove_query_arg( array('action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status',  'post', 'bulk_edit', 'post_view'), $sendback );
				
				wp_redirect($sendback);
				exit();
			}
		}
		
		
		/**
		 * Step 3: display an admin notice on the Posts page after exporting
		 */
		function woocommerce_rrp_add_bulk_admin_notices() {
			global $post_type, $pagenow;
			
			if($pagenow == 'edit.php' && $post_type == 'product' && isset($_REQUEST['price_setted_to_rrp']) && (int) $_REQUEST['price_setted_to_rrp']) {
				$message = sprintf( _n( 'Product price setted to RRP.', '%s product prices setted to RRP.', $_REQUEST['price_setted_to_rrp'] ), number_format_i18n( $_REQUEST['price_setted_to_rrp'] ) );
				echo "<div class=\"updated\"><p>{$message}</p></div>";
			}
		}
		
		function perform_export($post_id) {
			// do whatever work needs to be done
			return true;
		}
	}
}

new Woocommerce_RRP_Add_Set_Price_To_RRP_Btn_To_Bulk_Edit();