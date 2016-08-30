<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://exponential.org
 * @since      1.0.0
 *
 * @package    Expo_Checkin_Manager
 * @subpackage Expo_Checkin_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Expo_Checkin_Manager
 * @subpackage Expo_Checkin_Manager/admin
 * @author     Dave Phillips <davep@exponential.org>
 */
class Expo_Checkin_Manager_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->expo_checkin_options = get_option($this->plugin_name);	// todo: handle options

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Expo_Checkin_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Expo_Checkin_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( 'settings_page_expo-checkin-manager' == get_current_screen()->id ) {
			wp_enqueue_style( 'wp-color-picker' ); // for use in creating style for conference forms
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/expo-checkin-manager-admin.css', array( 'wp-color-picker' ), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Expo_Checkin_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Expo_Checkin_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( 'settings_page_expo-checkin-manager' == get_current_screen()->id ) {
			wp_enqueue_media();   // Enqueues all scripts, styles, settings, and templates necessary to use all media JavaScript APIs.
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/expo-checkin-manager-admin.js', array( 'jquery', 'wp-color-picker', 'media-upload'  ), $this->version, false );
		}
	}
	
	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 * @since    1.0.0
	 */
	 
	public function add_plugin_admin_menu() {
		/*
		 * Add a settings page for this plugin to the Settings menu.
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 */
		add_options_page( 'Expo Checkin Manager', 'Expo Checkin', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
		);
	}
	
	/**
	 * Add settings action link to the plugins page.
	 * @since    1.0.0
	 */ 
	public function add_action_links( $links ) {
		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/
	   $settings_link = array(
		'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );
	
	}
	
	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	 
	public function display_plugin_setup_page() {
		include_once( 'partials/expo-checkin-manager-admin-display.php' );
	}
	
	public function options_update() {
    	register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
 	}
	
	public function validate($input) {
		// All $inputs from our form in an array named $this->plugin_name[option] (no quotes when declaring on the form)        
		$valid = array();
		return $valid; 
	}

	public function show_registrant_data() {
		global $wpdb;
		
		$post_table = $wpdb->prefix . 'posts';

//		$sql = "SELECT post_title FROM $wpdb->posts WHERE id=2463";
//		$ans = $wpdb->get_var( $sql );
//		echo '<h4>get_var just show $ans: '.$ans.'</h4><h5>'.$sql.'</h5>';
//	
//		$sql = "SELECT post_date_gmt, post_title, ID, post_date FROM $wpdb->posts WHERE id=2463";
//		$ans = $wpdb->get_col( $sql, 1 );
//		echo '<h4>get_col returns an array $ans[] that you control with an offset: '.$ans[0].'</h4><h5>'.$sql.'</h5>';
//		
//		$sql = "SELECT ID, post_title FROM $wpdb->posts WHERE post_type='dlm_download'";
//		$results = $wpdb->get_results( $sql );
//		echo '<h4>Got '.count( $results ).' rows</h4>';
	
	
		
		$sql = "SELECT download_id, cnt, post_title FROM vwDownloadCounts ORDER BY cnt DESC";
		$results = $wpdb->get_results( $sql );
	
		echo '<h3>Top 10 Downloads</h3>';
		echo '<ol>';
		for ( $i=0; $i<10; $i++ ) {
			echo '<li>['.$results[$i]->cnt.']: '.$results[$i]->post_title.'</li>';
		}
		
//		foreach( $results as $download ) {
//			echo '<li>'.$download->post_title.'</li>';	
//		}

		echo '</ol>';
	
		$sql = "SELECT count(*) cnt FROM `vwUniqueDownloads`";
		$cnt_all = $wpdb->get_var( $sql );	
		echo '<h4>Total downloads: '.$cnt_all.'</h4>';
   
	}




}
