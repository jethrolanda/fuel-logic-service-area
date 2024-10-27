<?php
namespace Fuel_Logic_Service_Area\Shortcodes;


class Zipcode_Check_Form {


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
		$atts = shortcode_atts( array(
			'success' => '',
			'no_service' => '',
		), $atts );

		ob_start();
			\Fuel_Logic_Service_Area\get_template( 'zipcode-form.php', array(
//				'form_url' => sanitize_url( $atts['success'] ),
			) );
		return ob_get_clean();
	}


}
