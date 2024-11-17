<?php
if (!defined('ABSPATH')) {
	exit;
}
// Exit if accessed directly


class Fuel_Logic_Service_Area
{

	/*
    |------------------------------------------------------------------------------------------------------------------
    | Class Members
    |------------------------------------------------------------------------------------------------------------------
     */
	private static $_instance;

	public $scripts;
	public $blocks;
	public $ajax;
	public $shortcode;

	const VERSION = '1.0';

	/*
  |------------------------------------------------------------------------------------------------------------------
  | Mesc Functions
  |------------------------------------------------------------------------------------------------------------------
  */

	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{

		$this->scripts = FLSA\Plugin\Scripts::instance();
		$this->blocks = FLSA\Plugin\Blocks::instance();
		$this->ajax = FLSA\Plugin\Ajax::instance();
		$this->shortcode = FLSA\Plugin\Shortcode::instance();

		// Register Activation Hook
		register_activation_hook(FLSA_PLUGIN_DIR . 'fuel-logic-service-area.php', array($this, 'activate'));

		// Register Deactivation Hook
		register_deactivation_hook(FLSA_PLUGIN_DIR . 'fuel-logic-service-area.php', array($this, 'deactivate'));
	}

	/**
	 * Singleton Pattern.
	 *
	 * @since 1.0.0
	 */
	public static function instance()
	{

		if (!self::$_instance instanceof self) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}


	/**
	 * Trigger on activation
	 *
	 * @since 1.0.0
	 */
	public function activate() {}

	/**
	 * Trigger on deactivation
	 *
	 * @since 1.0.0
	 */
	public function deactivate() {}
}
