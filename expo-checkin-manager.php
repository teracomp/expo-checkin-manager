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
 * Description:       Wordpress Admin plugin panel to support Check-in App
 * Version:           1.1.0
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

function my_plugin_create_db() {

	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'expo_checkin_tmp';
	
	$sql = "CREATE TABLE $table_name (
		id int(11) NOT NULL,
		userid int(11) DEFAULT NULL,
		form_id int(11) DEFAULT NULL,
		gf_lead_id int(11) DEFAULT NULL,
		seqnbr int(11) DEFAULT NULL,
		group_name varchar(255) DEFAULT NULL,
		group_total int(11) DEFAULT NULL,
		regtype varchar(40) DEFAULT NULL,
		regreason varchar(40) DEFAULT NULL,
		payment_status varchar(40) DEFAULT NULL,
		source varchar(255) DEFAULT NULL,
		firstname varchar(60) DEFAULT NULL,
		lastname varchar(60) DEFAULT NULL,
		email varchar(255) DEFAULT NULL,
		address varchar(255) DEFAULT NULL,
		city varchar(60) DEFAULT NULL,
		state varchar(30) DEFAULT NULL,
		zip varchar(20) DEFAULT NULL,
		phone varchar(30) DEFAULT NULL,
		precon varchar(255) DEFAULT NULL,
		spouse_firstname varchar(60) DEFAULT NULL,
		spouse_lastname varchar(60) DEFAULT NULL,
		spouse_email varchar(255) DEFAULT NULL,
		spouse_precon varchar(255) DEFAULT NULL,
		checkedin char(3) DEFAULT NULL,
		notes text,
		edited tinyint(4) DEFAULT NULL,
		data_sync datetime DEFAULT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}


register_activation_hook( __FILE__, 'activate_expo_checkin_manager' );
register_activation_hook( __FILE__, 'my_plugin_create_db' );

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
