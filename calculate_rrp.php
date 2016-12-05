<?

defined( 'ABSPATH' ) or die( '' );

function calculate_rrp ($buy_price, $params) {
	$costs = $buy_price + $params['ads_cost'] + $params['shipping_cost'] + $params['package_cost'];
	
	$costs_min_profit = $costs + $params['min_profit'];	
	$costs_desired_profit = add_back_percents($costs, $params['desired_profit']);
	
	$costs_with_profit = max(array($costs_min_profit, $costs_desired_profit));	
	
	$rrp = add_back_percents($costs_with_profit, $params['tax_rate']);	
	
	$rrp_ceiled = ceil($rrp / 10) * 10;
	
	return $rrp_ceiled;
}

function add_back_percents ($val, $percents) {	
	return round($val / (1 - $percents / 100));
}