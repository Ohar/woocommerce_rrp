<?

defined( 'ABSPATH' ) or die( '' );

function calculate_rrp ($buy_price, $params) {
	$costs = $buy_price + $params['ads_cost'] + $params['shipping_cost'] + $params['package_cost'];	
	
	$min_profit_costs = $costs + $params['min_profit'];	
	$min_profit_percents = $params['tax_rate'];	
	
	$desired_profit_costs = $costs;	
	$desired_profit_percents = $params['desired_profit'] + $params['tax_rate'];	
		
	$rrp_min_profit = add_back_percents($min_profit_costs, $min_profit_percents);	
	$rrp_desired_profit = add_back_percents($desired_profit_costs, $desired_profit_percents);	
	
	$rrp = max(array($rrp_min_profit, $rrp_desired_profit));
	
	$rrp_ceiled = ceil($rrp / 10) * 10;
	
	return $rrp_ceiled;
}

function add_back_percents ($val, $percents) {	
	return round($val / (1 - $percents / 100));
}