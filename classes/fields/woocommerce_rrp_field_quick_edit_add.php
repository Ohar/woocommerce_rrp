<?

// QUICK EDIT

// Add field to the quick edit

class WoocommerceRrpFieldQuickEditAdd {

    function __construct($field) {
        $this->field = $field;
        add_action( 'woocommerce_product_quick_edit_start', array(&$this, '_add_field') );
    }
		
    public function _add_field($product) {
			$field = $this->field;
			?>
			
			<div class="<?=$field['id']?>_block">
				<label class="alignleft">
						<span class="title"><?=$field['label']?></span>
						<span class="input-text-wrap">
							<input type="<?=$field['type']?>" name="<?=$field['id']?>" class="text <?=$field['id']?>" placeholder="<?=$field['placeholder']?>" value=""
							<?
							if ($field['attributes']) {								
								foreach ($field['attributes'] as $key => $value) {
									echo " $key='$value' ";
								}
							}
							?>
							>
						</span>
				</label>
			</div>
			<br class="clear">
			
			<script>
			
			jQuery(function(){
				jQuery('#the-list').on('click', '.editinline', function(){

						/**
						 * Extract metadata and put it as the value for the custom field form
						 */
						inlineEditPost.revert();

						var post_id = jQuery(this).closest('tr').attr('id');

						post_id = post_id.replace("post-", "");

						var $field_inline_data = jQuery('#<?=$field['id']?>_inline_' + post_id),
								$wc_inline_data    = jQuery('#woocommerce_inline_' + post_id );

						jQuery('input[name="<?=$field['id']?>"]', '.inline-edit-row').val($field_inline_data.find("#<?=$field['id']?>").text());


						/**
						 * Only show custom field for appropriate types of products (simple)
						 */
						var product_type = $wc_inline_data.find('.product_type').text();

						if (product_type=='simple') {
								jQuery('.<?=$field['id']?>_block', '.inline-edit-row').show();
						} else {
								jQuery('.<?=$field['id']?>_block', '.inline-edit-row').hide();
						}

				});
			});
			
			</script>
			
			<?
		}
}

