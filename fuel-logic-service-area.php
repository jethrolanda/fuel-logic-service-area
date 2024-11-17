<?php

/**
 * Plugin Name: Fuel logic Service Area
 * Description: FL Service ara.
 * Version: 1.0
 * Author: Xammis
 * Author URI: https://xammis.com/
 * Text Domain: fuel-logic-service-area
 * Domain Path: /languages/
 * Requires at least: 5.7
 * Requires PHP: 7.2
 */

defined('ABSPATH') || exit;

// Path Constants ======================================================================================================

define('FLSA_PLUGIN_URL',             plugins_url() . '/fuel-logic-service-area/');
define('FLSA_PLUGIN_DIR',             plugin_dir_path(__FILE__));
define('FLSA_CSS_ROOT_URL',           FLSA_PLUGIN_URL . 'css/');
define('FLSA_JS_ROOT_URL',            FLSA_PLUGIN_URL . 'js/');
define('FLSA_TEMPLATES_ROOT_URL',     FLSA_PLUGIN_URL . 'templates/');
define('FLSA_TEMPLATES_ROOT_DIR',     FLSA_PLUGIN_DIR . 'templates/');
define('FLSA_BLOCKS_ROOT_URL',        FLSA_PLUGIN_URL . 'blocks/');
define('FLSA_BLOCKS_ROOT_DIR',        FLSA_PLUGIN_DIR . 'blocks/');

// Require autoloader
require_once 'inc/autoloader.php';

// State Zipcodes
require_once 'inc/state-zipcodes.php';

// Run
require_once 'fuel-logic-service-area.plugin.php';
$GLOBALS['flsa'] = new Fuel_Logic_Service_Area();
