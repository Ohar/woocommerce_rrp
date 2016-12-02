<?

defined( 'ABSPATH' ) or die( '' );

function calculate_rrp ($buy_price, $params) {
	$costs = $buy_price + $params['ads_cost'] + $params['shipping_cost'] + $params['package_cost'];
	
	$costs_min_profit = $costs + $params['min_profit'];
	$costs_desired_profit = $costs + calc_percents($costs, $params['desired_profit']);
	$costs_to_get_max = array($costs_min_profit, $costs_desired_profit);
	
	$costs_with_profit = max($costs_to_get_max);
	$tax = calc_percents($costs_with_profit, $params['tax_rate']);
	
	$rrp = $costs_with_profit + $tax;
	$rrp_ceiled = ceil($rrp / 10) * 10;
	
	return $rrp_ceiled;
}

function calc_percents ($val, $percents) {	
	return round($val * $percents / 100);
}
