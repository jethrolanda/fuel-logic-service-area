<?php

namespace Fuel_Logic_Service_Area;


class Fuel_Logic_Service_Area
{

	public $version = '1.0.0';

	public $file = __FILE__;

	private static  $instance;


	/**
	 * Constructor.
	 *
	 * @since  1.0.0
	 */
	public function __construct()
	{
		add_action('init', array($this, 'create_block_blocks_block_init'));
	}


	/**
	 * Registers the block using the metadata loaded from the `block.json` file.
	 * Behind the scenes, it registers also all assets so they can be enqueued
	 * through the block editor in the corresponding context.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	public function create_block_blocks_block_init()
	{
		register_block_type(BLOCKS_ROOT_DIR . 'build/fuel_logic_zipcode_form');
		register_block_type(BLOCKS_ROOT_DIR . 'build/fuel_logic_map');
		register_block_type(BLOCKS_ROOT_DIR . 'build/fuel_logic_order_form');
		register_block_type(BLOCKS_ROOT_DIR . 'build/fuel_logic_zipcode');
	}

	/**
	 * Instance.
	 *
	 * An global instance of the class. Used to retrieve the instance
	 * to use on other files/plugins/themes.
	 *
	 * @since  1.0.0
	 * @return  object Instance of the class.
	 */
	public static  function instance()
	{

		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Initialize plugin parts.
	 *
	 * @since  1.0.0
	 */
	public function init()
	{

		// Load textdomain
		$this->load_textdomain();

		// Include files
		$this->includes();

		// Add shortcodes
		$this->add_shortcodes();

		// Admin
		if (is_admin()) {
			$this->admin = new \Fuel_Logic_Service_Area\Admin\Admin();
			$this->admin->init();
		}
	}


	/**
	 * Textdomain.
	 *
	 * Load the textdomain based on WP language.
	 *
	 * @since  1.0.0
	 */
	public function load_textdomain()
	{

		$locale = apply_filters('plugin_locale', get_locale(), 'fuel-logic-service-area');

		// Load textdomain
		load_textdomain('fuel-logic-service-area', WP_LANG_DIR . '/fuel-logic-service-area/fuel-logic-service-area-' . $locale . '.mo');
		load_plugin_textdomain('fuel-logic-service-area', false, basename(dirname(__FILE__)) . '/languages');
	}


	/**
	 * Include files.
	 *
	 * Include/require plugin files/classes.
	 *
	 * @since  1.0.0
	 */
	public function includes()
	{

		require_once plugin_dir_path($this->file) . 'fuel-logic-service-area.php';
		require_once plugin_dir_path($this->file) . 'includes/admin/admin.php';
		require_once plugin_dir_path($this->file) . 'includes/core-functions.php';
		require_once plugin_dir_path($this->file) . 'includes/template-functions.php';
		require_once plugin_dir_path($this->file) . 'includes/shortcodes/zipcode-check-form.php';
		require_once plugin_dir_path($this->file) . 'includes/shortcodes/map.php';
		require_once plugin_dir_path($this->file) . 'includes/shortcodes/fuel-order-form.php';
		require_once plugin_dir_path($this->file) . 'includes/shortcodes/zipcode.php';
	}


	/**
	 * Add shortcodes
	 *
	 * Add the shortcodes to WordPress with their callbacks to be initialised.
	 *
	 * @since  1.0.0
	 */
	public function add_shortcodes()
	{

		add_shortcode('fuel_logic_zipcode_form', array(new \Fuel_Logic_Service_Area\Shortcodes\Zipcode_Check_Form(), 'output'));
		add_shortcode('fuel_logic_map', array(new \Fuel_Logic_Service_Area\Shortcodes\Map(), 'output'));
		add_shortcode('fuel_logic_order_form', array(new \Fuel_Logic_Service_Area\Shortcodes\Fuel_Order_Form(), 'output'));
		add_shortcode('fuel_logic_zipcode', array(new \Fuel_Logic_Service_Area\Shortcodes\Zipcode(), 'output'));
	}
}

/**
 * The main function responsible for returning the Fuel_Logic_Service_Area object.
 *
 * Use this function like you would a global variable, except without needing to declare the global.
 *
 * Example: <?php Fuel_Logic_Service_Area()->method_name(); ?>
 *
 * @since 1.0.0
 *
 * @return Fuel_Logic_Service_Area Return the singleton Fuel_Logic_Service_Area object.
 */
function Fuel_Logic_Service_Area()
{
	return Fuel_Logic_Service_Area::instance();
}
Fuel_Logic_Service_Area()->init();
