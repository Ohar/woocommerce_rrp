<?

// BULK EDIT

// Save field to the bulk edit

class WoocommerceRrpFieldBulkEditSave {

    function __construct($field) {
        $this->field = $field;
        add_action( 'woocommerce_product_bulk_edit_save', array(&$this, '_save_field') );
    }
		
    static function get_numerics($str) {
			preg_match_all('/\d+/', $str, $matches);
			return implode('', $matches[0]);
    }
		
    public function _save_field($product) {
			$field = $this->field;
			
			if ($product->is_type('simple')) {
				$post_id = $product->id;
				
				if ( isset( $_REQUEST[$field['id']] ) && isset( $_REQUEST['change_'.$field['id']] )) {
					$field_input = trim(esc_attr( $_REQUEST[$field['id']] ));
					$change_field = trim(esc_attr( $_REQUEST['change_'.$field['id']] ));
					$old_field = get_post_meta($post_id, $field['id'], true); 
					$new_field = $field_input;
					
					switch ( $change_field ) {
						case '1' :
								$new_field = ceil($field_input);
								update_post_meta( $post_id, $field['id'], wc_clean( $new_field ) );
								break;
						case '2' :
								if (strpos($field_input, '%') === false) {
									$new_field = $old_field + $field_input;
								} else {
									$num = $this->get_numerics($field_input);
									$new_field = $old_field * (1 + $num / 100);
								}
								
								$new_field = ceil($new_field);
								update_post_meta( $post_id, $field['id'], wc_clean( $new_field ) );
								break;
								
						case '3' :
								if (strpos($field_input, '%') === false) {
									$new_field = $old_field - $field_input;
								} else {
									$num = $this->get_numerics($field_input);
									$new_field = $old_field * (1 - $num / 100);
								}
								
								$new_field = ceil($new_field);
								update_post_meta( $post_id, $field['id'], wc_clean( $new_field ) );
								break;

						default :
								break;
					}
				}
			}
		}
}

