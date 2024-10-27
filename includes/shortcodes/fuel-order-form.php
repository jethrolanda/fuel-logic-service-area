<?php
namespace Fuel_Logic_Service_Area\Shortcodes;


class Fuel_Order_Form {


	/**
	 * Constructor.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {

	}


	/**
	 * Output shortcode content.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $atts
	 * @param  string $content
	 */
	public function output( $atts, $content ) {
		ob_start();
			\Fuel_Logic_Service_Area\get_template( 'fuel-order-form.php' );
		return ob_get_clean();
	}


}
