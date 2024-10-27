<?php
namespace Fuel_Logic_Service_Area\Admin;


class Settings {


	/**
	 * Constructor.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {

		// Register settings sections
		add_action( 'admin_init', array( $this, 'register_sections' ) );

		// Register settings
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// Add to menu
		add_action( 'admin_menu', array( $this, 'add_to_menu' ) );

	}


	/**
	 * Register setting sections.
	 *
	 * @since  1.0.0
	 */
	public function register_sections() {

		add_settings_section( 'fuel-logic-service-area_settings_section', '', '__return_false', 'fuel-logic-service-area_settings_page' );

	}


	/**
	 * Register settings.
	 *
	 * @since  1.0.0
	 */
	public function register_settings() {

		register_setting( 'fuel-logic-service-area_settings_section', 'fuel_logic_google_maps_api_key', array( $this, 'sanitize_value' ) );
		add_settings_field( 'fuel_logic_google_maps_api_key', 'Google Maps API key', array( $this, 'form_input_text' ), 'fuel-logic-service-area_settings_page', 'fuel-logic-service-area_settings_section', $args = array(
			'label_for'     => 'fuel_logic_google_maps_api_key',
			'id'            => 'fuel_logic_google_maps_api_key',
			'description'   => 'Enter your <a href="https://developers.google.com/maps/documentation/embed/get-api-key" target="_blank">Google Maps API key</a>',
			'default_value' => '',
			'placeholder'   => '',
			'title'         => 'Google Maps API key',
		) );

		register_setting( 'fuel-logic-service-area_settings_section', 'fuel_logic_not_serviceable_area', 'sanitize_textarea_field' );
		add_settings_field( 'fuel_logic_not_serviceable_area', 'Not serviceable area', array( $this, 'form_input_textarea' ), 'fuel-logic-service-area_settings_page', 'fuel-logic-service-area_settings_section', $args = array(
			'label_for'     => 'fuel_logic_not_serviceable_area',
			'id'            => 'fuel_logic_not_serviceable_area',
			'description'   => 'Enter a comma or newline separated list of zipcodes, state names or state codes',
			'default_value' => '',
			'placeholder'   => '',
			'title'         => 'Serviceable area',
		) );


		$pages = array(
			array(
				'id'          => 'no_service',
				'title'       => 'No Service area',
				'description' => __( 'The page to display when not servicing the entered area.', 'fuel-logic-service-area' ),
			),
			array(
				'id'          => 'order_form',
				'title'       => 'Serviceable area',
				'description' => __( 'The page to show when the area is serviceable', 'fuel-logic-service-area' ),
			),
		);

		foreach ( $pages as $page ) {
			register_setting( 'fuel-logic-service-area_settings_section', 'fuel_logic_page_' . $page['id'], array( $this, 'sanitize_value' ) );
			add_settings_field( $page['id'], $page['title'], array( $this, 'form_input_page_select' ), 'fuel-logic-service-area_settings_page', 'fuel-logic-service-area_settings_section', array(
				'label_for'     => 'fuel_logic_page_' . $page['id'],
				'id'            => 'fuel_logic_page_' . $page['id'],
				'description'   => $page['description'],
				'default_value' => '',
				'placeholder'   => '',
				'title'         => $page['title'],
			) );
		}

		add_settings_field( 'fuel-logic-shortcode-description', 'Shortcodes', array( $this, 'description' ), 'fuel-logic-service-area_settings_page', 'fuel-logic-service-area_settings_section', array(
			'label_for'     => 'fuel-logic-shortcode-description',
			'id'            => 'fuel-logic-shortcode-description',
			'description'   => __( 'The following shortcodes are added by the plugin:', 'fuel-logic-service-area' ) . '<br/><br/>' .
							   __( '<code>[fuel_logic_zipcode_form]</code> - Form for zipcode check', 'fuel-logic-service-area' ) . '<br/>' .
							   __( '<code>[fuel_logic_map]</code> - Map output based on entered zipcode. To be used on the the \'serviceable area\' page', 'fuel-logic-service-area' ) . '<br/>' .
							   __( '<code>[fuel_logic_order_form]</code> - The fuel order form from hsforms. To be used on the \'serviceable area\' page', 'fuel-logic-service-area' ) . '<br/>' .
							   __( '<code>[fuel_logic_zipcode]</code> - Zipcode to output on the \'serviceable area\' page', 'fuel-logic-service-area' ) . '<br/>',
			'default_value' => '',
			'title'         => __( '', 'fuel-logic-service-area' ),
		) );


	}


	/**
	 * Add to admin menu.
	 *
	 * @since  1.0.0
	 */
	public function add_to_menu() {

		add_options_page( 'Fuel Logic Service Area settings', 'Fuel Logic Service Area', 'manage_options', 'fuel-logic-service-area', array( $this, 'output' ) );

	}


	/**
	 * Output settings.
	 *
	 * The HTML that is outputted on the settings page.
	 *
	 * @since  1.0.0
	 */
	public function output() {

		?><div class="wrap">

			<h1>Fuel Logic Service Area</h1><?php
			settings_errors( "fuel-logic-service-area_settings_page" );

			?><form action="options.php" method="post"><?php
				settings_fields( "fuel-logic-service-area_settings_section" ); // Nonce fields

				do_settings_sections( "fuel-logic-service-area_settings_page" );
				submit_button();

			?></form>

		</div><?php

	}


	/**
	 * Text input field HTML.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args
	 */
	public function form_input_text( $args = array() ) {

		$default_value = isset( $args['default_value'] ) ? $args['default_value'] : null;
		$value = get_option( $args['id'], $default_value );

		?><input type="text" class="regular-text" id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['id'] ); ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>" /><?php

		$this->description( $args );
	}


	/**
	 * Textarea field HTML.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args
	 */
	public function form_input_textarea( $args = array() ) {

		$default_value = isset( $args['default_value'] ) ? $args['default_value'] : null;
		$value = get_option( $args['id'], $default_value );
		error_log( print_r( $value, 1 ) );
		?><textarea class="large-text code" rows="10" cols="50" id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['id'] ); ?>" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"><?php echo esc_textarea( $value ); ?></textarea><?php

		$this->description( $args );
	}

	/**
	 * Page select field HTML.
	 *
	 * @since  1.0.0
	 *
	 * @param array $args
	 */
	public function form_input_page_select( $args = array() ) {
		echo wp_dropdown_pages(
			array(
				'name'              => $args['id'],
				'echo'              => 0,
				'show_option_none'  => __( '&mdash; Select &mdash;' ),
				'option_none_value' => '0',
				'selected'          => get_option( $args['id'] ),
			)
		);

		$url = get_permalink( get_option( $args['id'] ) );
		if ( get_option( $args['id'] ) ) {
			echo '<a href="' . esc_url( $url ) . '" target="_blank">' . __( 'View page', 'fuel-logic-service-area' ) . '</a>';
		}

		$this->description( $args );
	}


	/**
	 * Radio field HTML.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args
	 */
	public function form_input_radio( $args = array() ) {

		$options       = isset( $args['options'] ) ? $args['options'] : null;
		$default_value = isset( $args['default_value'] ) ? $args['default_value'] : null;
		$value         = get_option( $args['id'], $default_value );
		$title         = isset( $args['title'] ) ? $args['title'] : '';

		if ( ! is_null( $options ) ) :

			?><fieldset><?php

				foreach ( $options as $k => $v ) :

					$key = sanitize_key( str_replace( ' ', '-', $v ) );
					?><label>
						<input type="radio" class="radio-input" id="<?php echo esc_attr( $args['id'] . '-' . $key ); ?>" name="<?php echo esc_attr( $args['id'] ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( in_array( $key, (array) $value ) ); ?> />
						<span class="radio-input-label"><?php echo wp_kses_post( $v ); ?></span>
					</label><br/><?php

				endforeach;

			?></fieldset><?php

		else :

			?><label>
				<input type="radio" class="" id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['id'] ); ?>" value="1" <?php checked( $value ); ?> />
				<span class="radio-input-label"><?php echo wp_kses_post( $title ); ?></span>
			</label><?php

		endif;

	}


	/**
	 * Checkbox field HTML.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args
	 */
	public function form_input_checkbox( $args = array() ) {

		$options       = isset( $args['options'] ) ? $args['options'] : null;
		$default_value = isset( $args['default_value'] ) ? $args['default_value'] : null;
		$value         = get_option( $args['id'], $default_value );
		$title         = isset( $args['title'] ) ? $args['title'] : '';

		if ( ! is_null( $options ) ) :

			?><fieldset><?php

				foreach ( $options as $k => $v ) :

					$key = sanitize_key( str_replace( ' ', '-', $v ) );
					?><label>
						<input type="checkbox" class="checkbox-input" id="<?php echo esc_attr( $args['id'] . '-' . $key ); ?>" name="<?php echo esc_attr( $args['id'] ); ?>[]" value="<?php echo esc_attr( $key ); ?>" <?php checked( in_array( $key, (array) $value ) ); ?> />
						<span class="checkbox-input-label"><?php echo wp_kses_post( $v ); ?></span>
					</label><br/><?php

				endforeach;

			?></fieldset><?php

		else :

			?><label>
				<input type="checkbox" class="" id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['id'] ); ?>" value="1" <?php checked( $value ); ?> />
				<span class="checkbox-input-label"><?php echo wp_kses_post( $title ); ?></span>
			</label><?php

		endif;
	}


	/**
	 * Select/dropdown field HTML.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args
	 */
	public function form_input_select( $args = array() ) {

		$options = $args['options'];
		$default_value = isset( $args['default_value'] ) ? $args['default_value'] : null;
		$value = get_option( $args['id'], $default_value );

		?><select class="" id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['id'] ); ?>"><?php
			foreach ( $options as $k => $v ) :
				$key = sanitize_key( $v );
				?><option value="<?php echo esc_attr( $key ); ?>" <?php selected( $value, $key ); ?>><?php echo esc_html( $v ); ?></option><?php
			endforeach;
		?></select><?php

	}


	/**
	 * Output description.
	 *
	 * @param array $args List of setting arguments.
	 */
	public function description( $args = array() ) {
		if ( ! empty( $args['description'] ) ) {
			?><p class="description"><?php echo wp_kses_post( $args['description'] ); ?></p><?php
		}
	}


	/**
	 * Sanitize values.
	 *
	 * Sanitize setting values. If its an array it will auto-sanitize each key/value accordingly.
	 *
	 * @since  1.0.0
	 *
	 * @param  string|array $value Value being saved.
	 * @return  string|array Sanitized value
	 */
	public function sanitize_value( $value ) {

		if ( is_array( $value ) ) {
			foreach ( $value as $k => $v ) {
				$value[ sanitize_key( $k ) ] = $this->sanitize_value( $v );
			}
		} else {
			$value = sanitize_text_field( $value );
		}

		return $value;
	}


}
