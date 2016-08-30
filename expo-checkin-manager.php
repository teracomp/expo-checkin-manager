<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://exponential.org
 * @since             1.0.0
 * @package           Expo_Checkin_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Exponential Check-In Manager
 * Plugin URI:        https://github.com/teracomp/expo-checkin-manager
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Dave Phillips
 * Author URI:        https://exponential.org
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       expo-checkin-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-expo-checkin-manager-activator.php
 */
function activate_expo_checkin_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-expo-checkin-manager-activator.php';
	Expo_Checkin_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-expo-checkin-manager-deactivator.php
 */
function deactivate_expo_checkin_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-expo-checkin-manager-deactivator.php';
	Expo_Checkin_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_expo_checkin_manager' );
register_deactivation_hook( __FILE__, 'deactivate_expo_checkin_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-expo-checkin-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_expo_checkin_manager() {

	$plugin = new Expo_Checkin_Manager();
	$plugin->run();

}
run_expo_checkin_manager();
