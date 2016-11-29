<?

defined( 'ABSPATH' ) or die( '' );

// BULK EDIT

// Add field to the bulk edit

class WoocommerceRrpFieldBulkEditShow {

    function __construct($field) {
        $this->field = $field;
        add_action( 'woocommerce_product_bulk_edit_start', array(&$this, '_add_field') );
    }
		
    public function _add_field() {
			$field = $this->field;
			?>
			<div class="inline-edit-group">
					<label class="alignleft">
						<span class="title"><?=$field['label']?></span>
						<span class="input-text-wrap">
							<select class="change_<?=$field['id']?> change_to" name="change_<?=$field['id']?>">
							<?
								$options = array(
									'' 	=> __( '— No change —', 'woocommerce' ),
									'1' => __( 'Change to:', 'woocommerce' ),
									'2' => __( 'Increase by (fixed amount or %):', 'woocommerce' ),
									'3' => __( 'Decrease by (fixed amount or %):', 'woocommerce' ),
								);
								foreach ( $options as $key => $value ) {
									echo '<option value="' . esc_attr( $key ) . '">' . $value . '</option>';
								}
							?>
							</select>
						</span>
					</label>
					<label class="change-input">
						<input type="text" name="<?=$field['id']?>" class="text <?=$field['id']?>" placeholder="<?=$field['placeholder']?>" value="" />
					</label>
			</div>
			
			<style>
			 #woocommerce-fields-bulk.inline-edit-col .<?=$field['id']?> {
				box-sizing: border-box;
				width: calc(100% - 1rem);
				margin-left: 0;
			}
			</style>
			<?
		}
}

