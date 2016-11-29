<?

defined( 'ABSPATH' ) or die( '' );

// PRODUCT PAGE

// Save Fields

class WoocommerceRrpFieldGeneralSave {

    function __construct($field) {
        $this->field = $field;
        add_action( 'woocommerce_process_product_meta', array(&$this, '_save_field') );
    }
		
    public function _save_field($post_id) {
			$field_id = $this->field['id'];
			update_post_meta( $post_id, $field_id, esc_attr( $_POST[$field_id] ) );
		}
}
