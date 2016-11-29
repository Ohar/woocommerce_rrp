<?

defined( 'ABSPATH' ) or die( '' );

// PRODUCT PAGE

// Add Fields

class WoocommerceRrpFieldGeneralAdd {

    function __construct($field) {
        $this->field = $field;
        add_action( 'woocommerce_product_options_general_product_data', array(&$this, '_add_field') );
    }
		
    public function _add_field() {
			global $woocommerce, $post;

			echo '<div class="options_group">';

			woocommerce_wp_text_input(
				array(
					'id'                => $this->field['id'],
					'label'             => $this->field['label'],
					'placeholder'       => $this->field['placeholder'],
					'desc_tip'          => 'true',
					'description'       => $this->field['description'],
					'type'              => $this->field['type'],
					'custom_attributes' => $this->field['attributes']
				)
			);

			echo '</div>';
		}
}

