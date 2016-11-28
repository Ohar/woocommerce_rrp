<?

add_action('admin_menu', 'wpdocs_register_my_custom_submenu_page');

function wpdocs_register_my_custom_submenu_page() {
	add_submenu_page(
		'woocommerce', 
		__( 'RRP', 'woocommerce_rrp' ), 
		__( 'RRP', 'woocommerce_rrp' ),
		'manage_woocommerce', 
		'woocommerce_rrp', 
		'woocommerce_rrp_show_menu_page'
	);
}

function woocommerce_rrp_show_menu_page() {
	?>
	
	<h1><?=__( 'Recommended Retail Price', 'woocommerce_rrp' )?></h1>
	<h2><?=__( 'Common Params', 'woocommerce_rrp' )?></h2>
	
	<table class="form-table">
		<tr>
			<th>
				<label for="package_cost"><?=__( 'Package Cost', 'woocommerce_rrp' )?></label>
			</th>
			<td>
				<input type="number" 
				       id="package_cost" 
				       name="package_cost" 
				       placeholder="0" 
				       step="1"
				       min="0">
			</td>
		</tr>
		<tr>
			<th>
				<label for="shipping_cost"><?=__( 'Shipping Cost', 'woocommerce_rrp' )?></label>
			</th>
			<td>
				<input type="number" 
				       id="shipping_cost" 
				       name="shipping_cost" 
				       placeholder="0" 
				       step="1"
				       min="0">
			</td>
		</tr>
		<tr>
			<th>
				<label for="ads_cost"><?=__( 'Ads Cost', 'woocommerce_rrp' )?></label>
			</th>
			<td>
				<input type="number"
				       id="ads_cost" 
				       name="ads_cost" 
				       placeholder="0" 
				       step="1"
				       min="0">
			</td>
		</tr>
		<tr>
			<th>
				<label for="tax_rate"><?=__( 'Tax Rate', 'woocommerce_rrp' )?></label>
			</th>
			<td>
				<input type="number"
				       id="tax_rate" 
				       name="tax_rate" 
				       placeholder="0" 
				       step="1"
				       min="0"
				       max="100">%
			</td>
		</tr>
		<tr>
			<th>
				<label for="min_profit"><?=__( 'Min Profit', 'woocommerce_rrp' )?></label>
			</th>
			<td>
				<input type="number"
				       id="min_profit" 
				       name="min_profit" 
				       placeholder="0" 
				       step="1"
				       min="0">
			</td>
		</tr>
	</table>
	
	<p class="submit">	
		<button class="button-primary"><?=__( 'Save changes', 'woocommerce_rrp' )?></button>
	</p>
	
	
	
	
	
	
	<?
}
	