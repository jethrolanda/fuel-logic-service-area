<?php

namespace Fuel_Logic_Service_Area\Shortcodes;


class Map
{


	/**
	 * Constructor.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {}


	/**
	 * Output shortcode content.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $atts
	 * @param  string $content
	 */
	public function output($atts, $content)
	{
		if (isset($_GET['zipcode'])) {
			ob_start();
			\Fuel_Logic_Service_Area\get_template('map.php', array(
				'google_api_key' => get_option('fuel_logic_google_maps_api_key', ''),
				'signature' => '',
				'url' => add_query_arg(array(
					'key' => get_option('fuel_logic_google_maps_api_key', ''),
					'q' => absint($_GET['zipcode']),
				), 'https://www.google.com/maps/embed/v1/place'),
			));
			return ob_get_clean();
		}
	}
}
