<?

defined( 'ABSPATH' ) or die( '' );

include_once(plugin_dir_path( __FILE__ ) .'calculate_rrp.php');

if ( is_admin() ){
	add_action('admin_init', 'woocommerce_rrp_register_settings');
	add_action('admin_menu', 'woocommerce_rrp_register_submenu_page');
}

function woocommerce_rrp_register_settings() {
  register_setting( 'woocommerce_rrp_settings', 'package_cost' );
  register_setting( 'woocommerce_rrp_settings', 'shipping_cost' );
  register_setting( 'woocommerce_rrp_settings', 'ads_cost' );
  register_setting( 'woocommerce_rrp_settings', 'tax_rate' );
  register_setting( 'woocommerce_rrp_settings', 'min_profit' );
  register_setting( 'woocommerce_rrp_settings', 'desired_profit');
}

function woocommerce_rrp_register_submenu_page() {
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
	
	<form method="post" 
	      action="options.php">
	
		<?
		
		settings_fields( 'woocommerce_rrp_settings' );
		?>
		
		<h1><?=__( 'Recommended Retail Price', 'woocommerce_rrp' )?></h1>
		<h2><?=__( 'RRP Calculation Params', 'woocommerce_rrp' )?></h2>
		<h3><?=__( 'Costs', 'woocommerce_rrp' )?></h3>
		
		<table class="form-table">
			<tr>
				<th>
					<label for="package_cost"><?=__( 'Package Cost', 'woocommerce_rrp' )?></label>
				</th>
				<td>
					<input type="number"
								 value="<?=esc_attr(get_option('package_cost'))?>" 
								 id="package_cost" 
								 name="package_cost" 
								 placeholder="0" 
								 step="1"
								 min="0">
					<?=get_woocommerce_currency_symbol()?>
				</td>
			</tr>
			<tr>
				<th>
					<label for="shipping_cost"><?=__( 'Shipping Cost', 'woocommerce_rrp' )?></label>
				</th>
				<td>
					<input type="number" 
								 value="<?=esc_attr(get_option('shipping_cost'))?>" 
								 id="shipping_cost" 
								 name="shipping_cost" 
								 placeholder="0" 
								 step="1"
								 min="0">
					<?=get_woocommerce_currency_symbol()?>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ads_cost"><?=__( 'Ads Cost', 'woocommerce_rrp' )?></label>
				</th>
				<td>
					<input type="number"
								 value="<?=esc_attr(get_option('ads_cost'))?>" 
								 id="ads_cost" 
								 name="ads_cost" 
								 placeholder="0" 
								 step="1"
								 min="0">
					<?=get_woocommerce_currency_symbol()?>
				</td>
			</tr>
		</table>
		
		<h3><?=__( 'Taxes', 'woocommerce_rrp' )?></h3>
		
		<table class="form-table">
			<tr>
				<th>
					<label for="tax_rate"><?=__( 'Tax Rate', 'woocommerce_rrp' )?></label>
				</th>
				<td>
					<input type="number"
								 value="<?=esc_attr(get_option('tax_rate'))?>" 
								 id="tax_rate" 
								 name="tax_rate" 
								 placeholder="0" 
								 step="1"
								 min="0"
								 max="100">%
				</td>
			</tr>
		</table>
		
		<h3><?=__( 'Profits', 'woocommerce_rrp' )?></h3>
		
		<table class="form-table">
			<tr>
				<th>
					<label for="min_profit"><?=__( 'Min Profit', 'woocommerce_rrp' )?></label>
				</th>
				<td>
					<input type="number"
								 value="<?=esc_attr(get_option('min_profit'))?>" 
								 id="min_profit" 
								 name="min_profit" 
								 placeholder="0" 
								 step="1"
								 min="0">
					<?=get_woocommerce_currency_symbol()?>
				</td>
			</tr>
			<tr>
				<th>
					<label for="desired_profit"><?=__( 'Desired Profit', 'woocommerce_rrp' )?></label>
				</th>
				<td>
					<input type="number"
								 value="<?=esc_attr(get_option('desired_profit'))?>" 
								 id="desired_profit" 
								 name="desired_profit" 
								 placeholder="0" 
								 step="1"
								 min="0">%
				</td>
			</tr>
		</table>
		
		<? submit_button(); ?>	
	</form>
	
	<?
	$buy_price_examples = array(0, 1000, 2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000);
	$rrp_calc_params = array(
		'ads_cost'       => get_option('ads_cost'),	
		'shipping_cost'  => get_option('shipping_cost'),	
		'package_cost'   => get_option('package_cost'),	
		'min_profit'     => get_option('min_profit'),	
		'desired_profit' => get_option('desired_profit'),	
		'tax_rate'       => get_option('tax_rate'),	
	);
	?>
	
	<h2><?=__( 'RRP Examples for different buy prices', 'woocommerce_rrp' )?></h2>
	<table class="widefat">
		<tr>
			<th><?=__( 'Buy Price', 'woocommerce_rrp' )?></th>
			<? 
			foreach ($buy_price_examples as $buy_price) {
				?>
					<td><?=$buy_price?></td>
				<?
			}
			?>
		</tr>
		<tr>
			<th><?=__( 'RRP', 'woocommerce_rrp' )?></th>
			<? 
			foreach ($buy_price_examples as $buy_price) {
				?>
					<td><?=calculate_rrp($buy_price, $rrp_calc_params)?></td>
				<?
			}
			?>
		</tr>
	</table>
	<?
}
