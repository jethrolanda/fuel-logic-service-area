<?php
namespace Fuel_Logic_Service_Area\Admin;


class Admin {

	public $settings = null;


	/**
	 * Constructor.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {
		
	}


	/**
	 * Initialize admin parts.
	 *
	 * @since  1.0.0
	 */
	public function init() {
		
		// Include files
		$this->includes();

		// Settings
		$this->settings = new \Fuel_Logic_Service_Area\Admin\Settings();


	}


	/**
	 * Include files.
	 *
	 * Include/require plugin files/classes.
	 *
	 * @since  1.0.0
	 */
	public function includes() {
				
		require_once plugin_dir_path( \Fuel_Logic_Service_Area\Fuel_Logic_Service_Area()->file ) . 'includes/admin/settings.php';		

	}


}