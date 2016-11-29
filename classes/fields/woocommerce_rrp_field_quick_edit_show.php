<?

defined( 'ABSPATH' ) or die( '' );

// QUICK EDIT

// Show field data at the quick edit

class WoocommerceRrpFieldQuickEditShow {

    function __construct($field) {
        $this->field = $field;
        add_action( 'manage_product_posts_custom_column', array(&$this, '_show_field'), 99, 2 );
    }
		
    public function _show_field($column, $post_id) {
			$field = $this->field;
			
			switch ( $column ) {
				case 'name' : ?>
						<div class="hidden <?=$field['id']?>_inline" id="<?=$field['id']?>_inline_<? echo $post_id; ?>">
								<div id="<?=$field['id']?>"><? echo get_post_meta($post_id, $field['id'], true); ?></div>
						</div>
						<?

						break;

				default :
						break;
			}
		}
}

