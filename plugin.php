<?php
/**
 * Plugin Name: 	Fuel Logic Service Area
 * Plugin URI:
 * Description:     Display a form and serviceable area.
 * Version: 		1.0.0
 * Author:
 * Author URI:
 * Text Domain: 	fuel-logic-service-area
 */

/**
 * This plugin was build with the help of WP Plugin Generator.
 * https://wpplugingenerator.com
 *
 * WP Plugin Generator is build by Jeroen Sormani (http://jeroensormani.com)
 */

/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

/**
 * Display PHP 7.0 required notice.
 *
 * Display a notice when the required PHP version is not met.
 *
 * @since  1.0.0
 */
function fl_php_version_notices() {

	?><div class='updated'>
		<p><?php echo sprintf( __( 'Fuel Logic Service Area requires PHP 7 or higher and your current PHP version is %s. Please (contact your host to) update your PHP version.', 'fuel-logic-service-area' ), PHP_VERSION ); ?></p>
	</div><?php

}

if ( version_compare( PHP_VERSION, '7', 'lt' ) ) {
	add_action( 'admin_notices', 'fl_php_version_notices' );
	return;
}


define( 'FUEL LOGIC SERVICE AREA_FILE', __FILE__ );
require 'fuel-logic-service-area.php';
