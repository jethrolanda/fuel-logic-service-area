<?php

namespace Fuel_Logic_Service_Area;

/**
 * Enqueue scripts.
 *
 * Enqueue script as javascript and style sheets.
 *
 * @since  1.0.0
 */
function enqueue_scripts()
{

	wp_register_style('fuel-logic-service-area', plugins_url('assets/css/fuel-logic.css', \Fuel_Logic_Service_Area\Fuel_Logic_Service_Area()->file), array(), \Fuel_Logic_Service_Area\Fuel_Logic_Service_Area()->version);
	wp_register_script('fuel-logic-service-area', plugins_url('assets/js/fuel-logic.js', \Fuel_Logic_Service_Area\Fuel_Logic_Service_Area()->file), array(), \Fuel_Logic_Service_Area\Fuel_Logic_Service_Area()->version, true);

	wp_enqueue_style('fuel-logic-service-area');
	wp_enqueue_script('fuel-logic-service-area');
}
add_action('wp_enqueue_scripts', 'Fuel_Logic_Service_Area\enqueue_scripts');


/**
 * Zipcode check form handler.
 *
 * Handler for when the zipcode check form is submitted.
 */
function zipcode_check_form_handler()
{

	if (! isset($_POST['_wpnonce'], $_POST['zipcode'], $_POST['action'])) {
		return;
	}

	if ($_POST['action'] !== 'zipcode_check') {
		return;
	}

	if (! wp_verify_nonce($_POST['_wpnonce'], 'fl_zipcode_check')) {
		return;
	}

	// Check zipcode
	if (! verify_zipcode($_POST['zipcode'])) {
		wp_safe_redirect(get_permalink(get_option('fuel_logic_page_no_service', '')));
	} else {
		$url = get_permalink(get_option('fuel_logic_page_order_form', ''));
		wp_safe_redirect(add_query_arg('zipcode', absint($_POST['zipcode']), $url));
	}
}

add_action('wp', '\Fuel_Logic_Service_Area\zipcode_check_form_handler');


/**
 * Verify zipcode.
 *
 * Check if a zipcode is in a serviceable area.
 *
 * @param string $zipcode Zipcode to check.
 * @return bool False when not in a serviceable area.
 */
function verify_zipcode($zipcode)
{
	$excluded_areas = get_option('fuel_logic_not_serviceable_area', '');

	// Filter zipcodes and states from the list
	preg_match_all('/[0-9]+/im', $excluded_areas, $excluded_zipcodes);
	preg_match_all('/[a-zA-Z][^0-9\n\r]+/im', $excluded_areas, $excluded_states);

	// Matches a zipcode directly
	if (in_array($zipcode, $excluded_zipcodes[0])) {
		return false;
	}

	// Search in states
	$state_zipcodes = require_once plugin_dir_path(__FILE__) . './../state-zipcodes.php';
	foreach ($excluded_states[0] as $state) {

		$key_based_on_code = false;
		$key_based_on_title = false;

		if (is_array($state_zipcodes)) {
			$key_based_on_code =  array_search($state, array_column($state_zipcodes, 'code'));
			$key_based_on_title = array_search($state, array_column($state_zipcodes, 'title'));
		}


		if ($key_based_on_code !== false) {
			$a = $state_zipcodes[$key_based_on_code];
			if ($zipcode >= $a['min'] && $zipcode <= $a['max']) {
				return false;
			}
		}

		if ($key_based_on_title !== false) {
			$a = $state_zipcodes[$key_based_on_title];
			if ($zipcode >= $a['min'] && $zipcode <= $a['max']) {
				return false;
			}
		}
	}

	// Only return true when found in state list
	foreach ($state_zipcodes as $k => $a) {
		if ($zipcode >= $a['min'] && $zipcode <= $a['max']) {
			return true;
		}
	}

	return false;
}
