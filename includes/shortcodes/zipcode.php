<?php

namespace Fuel_Logic_Service_Area\Shortcodes;


use function Fuel_Logic_Service_Area\verify_zipcode;

class Zipcode
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
			$zip = absint($_GET['zipcode']);

			if (! verify_zipcode($zip)) {
				return '';
			}

			return $zip;
		}
	}
}
