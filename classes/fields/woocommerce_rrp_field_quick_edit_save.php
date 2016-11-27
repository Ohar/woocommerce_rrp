<?

// QUICK EDIT

// Save field to the quick edit

class WoocommerceRrpFieldQuickEditSave {

    function __construct($field) {
        $this->field = $field;
        add_action( 'woocommerce_product_quick_edit_save', array(&$this, '_save_field'), 10, 1 );
    }
		
    public function _save_field($product) {
			$field = $this->field;
			
			if ($product->is_type('simple')) {
				$post_id = $product->id;
				if ( isset( $_REQUEST[$field['id']] ) ) {
					$field_value = ceil(trim(esc_attr( $_REQUEST[$field['id']] )));
					update_post_meta( $post_id, $field['id'], wc_clean( $field_value ) );
				}
			}
		}
}

