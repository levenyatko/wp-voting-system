<?php
	/**
	 * Plugin Name:  WP Voting System
	 * Description:  Voting system for your WordPress website.
	 * Version:      1.0.0
	 * Author:       Daria Levchenko
	 * Author URI:   https://github.com/levenyatko
	 * Requires PHP: 7.4
	 * Text Domain:  wp-voting-system
	 *
	 * License:      GNU General Public License v2.0 or later
	 * License URI:  http://www.gnu.org/licenses/gpl-2.0.html
	 *
	 * @package WP_Voting_System
	 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'WP_VS_PLUGIN_URL' ) ) {
	define( 'WP_VS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'WP_VS_PLUGIN_DIR' ) ) {
	define( 'WP_VS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

require_once __DIR__ . '/includes/class-autoloader.php';

if ( class_exists( 'WP_Voting_System\Autoloader' ) ) {
	$wpvs_autoloader = new WP_Voting_System\Autoloader();
	$wpvs_autoloader->register();
}

new WP_Voting_System\WPVS_Plugin( __FILE__ );
