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
	 * The options for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $eci_options   Options for this plugin.
	 */
	private $eci_options;

	/**
	 * current Gravity Form in use
	 */
	private $cform;

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
		$this->eci_options = get_option($this->plugin_name);	// todo: handle options
		$this->set_current_form();
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

//		if ( 'settings_page_expo-checkin-manager' == get_current_screen()->id ) {
			wp_enqueue_style( 'wp-color-picker' ); // for use in creating style for conference forms
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/expo-checkin-manager-admin.css', array( 'wp-color-picker' ), $this->version, 'all' );
//		}
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
//		if ( 'settings_page_expo-checkin-manager' == get_current_screen()->id ) {
			wp_enqueue_media();   // Enqueues all scripts, styles, settings, and templates necessary to use all media JavaScript APIs.
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/expo-checkin-manager-admin.js', array( 'jquery', 'wp-color-picker', 'media-upload'  ), $this->version, false );
//		}
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
//		add_options_page( 'Expo Checkin Manager', 'Expo Checkin', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page') );
		add_menu_page( 'Exponential Events Checkin Manager', 'Expo Checkin', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'), 'dashicons-id', $position );
		add_submenu_page($this->plugin_name, 'Import Sheets', 'Import Sheets', 'manage_options', $this->plugin_name.'-import', array($this, 'display_plugin_import_page'));
		add_submenu_page($this->plugin_name, 'Export Data', 'Export Data', 'manage_options', $this->plugin_name.'-export', array($this, 'display_plugin_export_page'));
		add_submenu_page($this->plugin_name, 'Add/Edit Regs', 'Add/Edit Regs', 'manage_options', $this->plugin_name.'-addedit', array($this, 'display_plugin_addedit_page'));
		add_submenu_page($this->plugin_name, 'Reports', 'Reports', 'manage_options', $this->plugin_name.'-reports', array($this, 'display_plugin_reports_page'));
		add_submenu_page($this->plugin_name, 'Conf Config', 'Conf Config', 'manage_options', $this->plugin_name.'-config', array($this, 'display_plugin_config_page'));
		add_submenu_page($this->plugin_name, 'Settings', 'Settings', 'manage_options', $this->plugin_name.'-settings', array($this, 'display_plugin_settings_page'));


	}
	
	/**
	 * Add settings action link to the plugins page.
	 * @since    1.0.0
	 */ 
//	public function add_action_links( $links ) {
//		/*
//		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
//		*/
//	   $settings_link = array( '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>' );
//
//	   return array_merge(  $settings_link, $links );
//	
//	}
//	
	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	 
	public function display_plugin_setup_page() {
		include_once( 'partials/expo-checkin-manager-admin-display.php' );
	}

	public function display_plugin_export_page() {
		include_once( 'partials/export-registrants_settings.php' );
	}
	
	public function display_plugin_import_page() {
		include_once( 'partials/import-sheets_settings.php' );
	}
	
	public function display_plugin_addedit_page() {
		include_once( 'partials/add-edit-records_settings.php' );
	}
		
	public function display_plugin_reports_page() {
		include_once( 'partials/expo-reports_settings.php' );
	}
	
	public function display_plugin_config_page() {
		include_once( 'partials/config-conf-page_settings.php' );
	}
	
	public function display_plugin_settings_page() {
		include_once( 'partials/expo-settings.php' );
	}
	
	public function options_update() {
    	register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
 	}
	
	public function validate($input) {
		// All $inputs from our form in an array named $this->plugin_name[option] (no quotes when declaring on the form)        
		$valid = array();
		
		$options = get_option( $this->plugin_name );
		
		if ( $input['csv_filename'] ) {  
			$valid['csv_filename'] = sanitize_file_name( $input['csv_filename'] );
		} else {
			$valid['csv_filename'] = $options['csv_filename'];
		}
		
		if ( $input['header_rows_count'] ) {
			$valid['header_rows_count'] = intval( $input['header_rows_count'] );
		} else {
			 $valid['header_rows_count'] = $options['header_rows_count'];
		}
		
		if ( $input['import_group_name'] ) {
			$valid['import_group_name'] = sanitize_text_field( $input['import_group_name'] );
		} else {
			 $valid['import_group_name'] = $options['import_group_name'];
		}
		
		if ( $input['last_import_count'] ) {
			 $valid['last_import_count'] = $input['last_import_count'];
		} else {
			 $valid['last_import_count'] = $options['last_import_count'];
		}
		
		if ( $input['last_import_header'] ) {
			$valid['last_import_header'] = $input['last_import_header'];
		} else {
			 $valid['last_import_header'] = $options['last_import_header'];
		}
		
		if ( $input['import_to_form'] ) {
			$valid['import_to_form'] = sanitize_text_field( $input['import_to_form'] );			
		} else {
			 $valid['import_to_form'] = $options['import_to_form'];
		}
		
		if ( $input['last_export_entry_id'] ) {
			 $valid['last_export_entry_id'] = $input['last_export_entry_id'];
		} else {
			 $valid['last_export_entry_id'] = $options['last_export_entry_id'];
		}

		if ( isset($input['import_one_group']) ) {
			if ( $input['import_one_group'] ) {
				$valid['import_one_group'] =  'on' ;
			} else {
				$valid['import_one_group'] =  'off' ;
			}
		} else {
				$valid['import_one_group'] =  'off' ;
		}
	
		
		return $valid; 
	}
	
	public function get_reg_count( $entries ) {
		$regs = 0;
		foreach( $entries as $e ) {
			$regs += intval( $e[19] ) + intval( $e[119] );
		}
		return $regs;
	}
	
	public function get_form_fields_callback() {
		$form_id = $_REQUEST['form_id'];
		$label = $_REQUEST['text'];
		
		if ( $label === '' ) {
			$label = 'Form Fields';
		}

		$options = get_option( $this->plugin_name );
		if ( $form_id === '0' ) {	
			$form_id = $options['import_to_form'];
		} else {
			$options['import_to_form'] = $form_id;
		    update_option($this->plugin_name, $options);
		}
		
		$this->set_current_form( $form_id );

//		$form = GFAPI::get_form( $form_id );
		
		$fieldList = '<h3>'.$label.' (form_id: '.$form_id.')</h3>';
		$fieldList .= '<ul>';
			foreach ( $this->cform['fields'] as $fld ) {
				if ( $fld['adminLabel'] <> '' ) {
					$lbl = $fld['adminLabel'];
				} else {
					$lbl = $fld['label'];					
				}				
				$fieldList .= '<li>' . $fld['id']. ': '.$lbl.'</li>';	 
			}
		$fieldList .= '</ul>';

		echo $fieldList;

		wp_die();	// required by ajax
	}

	public function get_dbtable_columns_callback() {
		global $wpdb;
		$tbl = $_REQUEST['tablename'];
		// our temp database table	
		$dbtable = $wpdb->prefix . $tbl;

		$dbColumns = '<h3>Columns for db table: '.$tbl.'</h3>';
		$dbColumns .= '<ul>';
			foreach ( $wpdb->get_col( "DESC " . $dbtable, 0 ) as $column_name ) {
				$dbColumns .= '<li>' . $column_name.'</li>';	 
			}
		$dbColumns .= '</ul>';

		echo $dbColumns;

		wp_die();	// required by ajax
	}

	public function set_current_form( $form_id = 0 ){
		if ( $form_id === 0 ) {
			$options = get_option( $this->plugin_name );	
			if ( $options['import_to_form'] ) {
				$form_id = $options['import_to_form'];
			}
		}
		$this->cform = GFAPI::get_form( $form_id );
		return true;
	}
	
	public function get_field_number( $label ) {
		$nbr = 0;
		foreach( $this->cform['fields'] as $fld ) {
			if ( $fld['adminLabel'] === $label ) {
				$nbr = $fld['id'];
				break;
			} elseif ( $fld['label'] === $label ) {
				$nbr = $fld['id'];
				break;
			}
		}
		return $nbr;	
	}

	
	public function get_gf_forms_list() {

		$ans = array();
		$forms = GFAPI::get_forms();   // get_forms() returns active forms
	
		foreach ( $forms as $frm ) { 			
			$search_criteria = array( 'status' => 'active' );
			$search_criteria['field_filters'][] = array("key" => 'payment_status', value => 'Paid');
			$total_entries = GFAPI::count_entries( $frm['id'], $search_criteria );
			$total_registrants = 0;
			$ans[ $frm['id'] ] = $frm['title'] . ' | ' . $total_entries.' entries | '.$total_registrants. ' registrants)';	// build a key=>value array
		}
		return $ans;
	}

	public function import_csv_processor() {
		global $wpdb;

		// our temp database table	
		$dbtable = $wpdb->prefix . 'expo_checkin_tmp';

		$filename = $_FILES['csv_import_file']['name'];		

		$theOptions = get_option($this->plugin_name);
		$groupName         = $theOptions['import_group_name'];
		$import_to_form    = $theOptions['import_to_form'];

		$default_payment_status = 'Paid'; 		// *** HARD-CODE ALERT :: however, it's probably valid *** //
		$default_reg_type = 'Registrant';

		if ( isset( $theOptions['header_rows_count'] ) ) {
			$header_rows_count = intval( $theOptions['header_rows_count'] );
		} else {
			$header_rows_count = 1;
		}	
		
		$csv_content = file_get_contents(  $_FILES['csv_import_file']['tmp_name'] );		// i have to use this method to detect the \n or \r (crazy)
		$csv_with_tabs = preg_replace("/[\n\r]/","\t",$csv_content);		// convert the \n or \r to \t

		$all_data = array();
		$registrants = array();
		$rows = split( "\t", $csv_with_tabs );		// convert these as rows 
		
		// now we have to look for " marks
		$delimiter = ",";
		$enclosure = '"';
		foreach( $rows as $row) {
			$all_data[] = str_getcsv( $row, $delimiter, $enclosure );
//			$all_data[] = split(",", $row);			// build all the data

		}
	
		$hdr_offset = $header_rows_count - 1;
		if ( $hdr_offset < 0 ) {
			$hdr_offset = 0;
		}
		$hdr_row = $all_data[ $hdr_offset ];	// get the header row
		for ($i=1; $i<count($all_data); $i++ ) {			// build the registrants array
			$registrants[] = $all_data[$i];
		}
		
		$form_id = $import_to_form;

		$curruserid = wp_get_current_user()->id;	
		$delwhere = array( 'userid'=>$curruserid );
		$del_response = $wpdb->delete( $dbtable, $delwhere );
	
	
	
		// array of fields
		$ar_fields = array();
			
		// here's the data
		foreach ( $hdr_row as $h ) {
			$ar_fields[] = $h;
		}
	
		$seqnbr = 1;
		foreach ( $registrants as $reg ){
			$ar_values = array();
			foreach ($reg as $fld ) {
				$ar_values[] = $fld;
			}
			$data = array();
			for ( $i=0; $i<count($ar_fields); $i++ ) {
				$data[$ar_fields[$i]] = $ar_values[$i];
			}
			
			$data['payment_status'] = ( $data['payment_status'] <> '' ) ? $data['payment_status'] : $default_payment_status;
			$data['group_name'] = ( $data['group_name'] <> '' ) ? $data['group_name'] : $groupName;			
			$data['regtype'] = ( $data['regtype'] <> '' ) ? $data['regtype'] : $default_reg_type;			
			$data['checkedin'] = ( $data['checkedin'] <> '' ) ? $data['checkedin'] : 'No';			
			$data['userid'] = $curruserid;
			$data['form_id'] = $form_id;
			$data['source'] = ( $data['source'] <> '' ) ? $filename.': '.$data['source'] : $filename;
			
			// only insert records that have a first and last name. otherwise, this is a blank row for some reason
			if ( $data['firstname'] <> '' && $data['lastname'] <> '' ) {
				if ( $data['seqnbr'] === '' ) {
					$data['seqnbr'] = $seqnbr++;
				}
				$ans = $wpdb->insert( $dbtable, $data );
			} 
		}
		$sql = "SELECT count(*) FROM $dbtable WHERE userid=$curruserid AND form_id=$form_id";
		$group_total = $wpdb->get_var( $sql );


		
		$data = array( 'group_total' => $group_total );
		$where = array( 'userid'=>$curruserid, 'form_id'=>$form_id );
		$r = $wpdb->update( $dbtable, $data, $where );
		

 		$theOptions['last_import_count']  = $group_total;
		$theOptions['last_import_header'] = $hdr_row ; 
	    update_option($this->plugin_name, $theOptions);
		
		$url = admin_url() . 'admin.php?page='.$this->plugin_name.'-import';
		wp_redirect( $url );
		exit;
	}
	
	/**
	 * apply_filters( 'exm_count_tmp_records', $v )
	 */
	public function count_tmp_records($v) {
		global $wpdb;

		// our temp database table
		$dbtable = $wpdb->prefix . 'expo_checkin_tmp';
		$curruserid = wp_get_current_user()->id;
		$options = get_option( $this->plugin_name );
		$form_id = $options['import_to_form']; //16;

		$sql = "SELECT count(*) FROM $dbtable WHERE userid=$curruserid AND form_id=$form_id";
//		echo 'sql: ' . $sql;
		$v = $wpdb->get_var( $sql );
//		echo '<h4>Answer: '.$v.'</h4>';
		return $v;
	}
	
	public function create_entries_from_db() {
		global $wpdb;
		date_default_timezone_set('America/New_York');

		$options = get_option( $this->plugin_name );
		$form_id = $options['import_to_form']; //16;

		$regreason = 'Imported';		// 114  radio button on the form		
		$dbtable = $wpdb->prefix . 'expo_checkin_tmp';
		
		$sql = "SELECT * FROM $dbtable WHERE data_sync IS NULL";
		$ans = $wpdb->get_results( $sql );
		$cnt_to_add = count($ans);
		$cnt_entries_added = 0;

		
		// live database	
		foreach ( $ans as $tmpdb ) {
			$currdatetime = date('Y/m/d H:i:s', time());
			$newEntry = array(
				'form_id' => $tmpdb->form_id,
				'payment_status' => $tmpdb->payment_status,
				'payment_method' => 'Offline',
				'149' => $tmpdb->group_name,
				'150' => $tmpdb->regtype,
				'152' => $tmpdb->source . ' at ' .$currdatetime,
				'151' => $regreason,
				'153' => $tmpdb->notes,
				'20' => $tmpdb->firstname,
				'22' => $tmpdb->lastname,
				'26' => $tmpdb->address,
				'27' => $tmpdb->city,
				'36' => $tmpdb->state,
				'28' => $tmpdb->zip,
				'6' => $tmpdb->email,
				'7' => $tmpdb->phone,
				'11' => $tmpdb->precon,
				'41' => $tmpdb->spouse_firstname,
				'42' => $tmpdb->spouse_lastname,
				'43' => $tmpdb->spouse_email,
				'46' => $tmpdb->spouse_precon,
				'153' => $tmpdb->notes,
			);
			$lid = GFAPI::add_entry( $newEntry );
			if ( $lid > 0 ) {
				$data = array( 'data_sync'=> $currdatetime );
				$where = array( 'id' => $tmpdb->id );
				$response = $wpdb->update( $dbtable, $data, $where );
				$cnt_entries_added++;
			}
		}

		echo '<h3>Found: '.$cnt_to_add .'</h3>';
		echo '<h3>Added: '.$cnt_entries_added.'</h3>';

	}

	public function export_entries() {
		global $wpdb;
		// get the entry id from the last import. export only the new records
		$options = get_option( $this->plugin_name );
		$form_id = $options['import_to_form']; //16;

		$expo_dc_form_lead_ids = '19, 119';
		$payment_status = 'Paid';
		$entry_status = 'active';

        $options = get_option($this->plugin_name);
        $csv_filename = $options['csv_filename'];
		if ( $options['last_export_entry_id'] ) {
			$last_export_entry_id = $options['last_export_entry_id'];
		} else {
			$last_export_entry_id = 0;			
		}

		$rg_lead        = $wpdb->prefix . 'rg_lead';
		$rg_lead_detail = $wpdb->prefix . 'rg_lead_detail';

		/**
		 * grab all the detail records in one recordset...we'll look through this a bunch
		 */
		$sql = "SELECT `lead_id`, `field_number`, `value` field_value FROM `$rg_lead_detail` WHERE `form_id`=$form_id ORDER BY `lead_id`, `field_number`";
		$details = $wpdb->get_results( $sql );

//		echo '<h4>SQL Details</h4>';
//		echo $sql;
		
		/**
		 * these are the lead registrants -- process these and look for their team members
		 **/
		$sql = "SELECT a.id lead_id, payment_status, payment_method, 
			(SELECT d.value FROM $rg_lead_detail d WHERE d.lead_id=a.id AND field_number IN ($expo_dc_form_lead_ids)) cnt 
			FROM `$rg_lead` a 
			WHERE a.form_id=$form_id AND a.status='$entry_status' AND a.payment_status IS NOT NULL
			AND a.id > $last_export_entry_id";

//			WHERE a.form_id=$form_id AND a.payment_status='$payment_status' AND a.status='$entry_status'";
		
//		echo '<h4>SQL Leads</h4>';
//		echo $sql;
			
		
		$lead_registrants = $wpdb->get_results( $sql );
		
		$total_lead_registrants = count( $lead_registrants );
		$total_registrants=0;
		
		if ( $total_lead_registrants > 0 ) {

			$arRegFieldNumbers[10] = array();
			
			// primary registrant fields: (20,22,6,26,27,36,28,7,11,132,142)

			$rreg = new RegFieldNumbers();
			$rreg->regtype      = 199;
			$rreg->regreason    = 200;
			$rreg->source       = 201;
			$rreg->seqnbr       = 1;
			$rreg->group_name	= 152;
			$rreg->total_ind_regs = 19;
			$rreg->total_grp_regs = 119;
			$rreg->firstname    = 20;
			$rreg->lastname     = 22;
			$rreg->email        = 6;
			$rreg->address      = 26;
			$rreg->city         = 27;
			$rreg->state        = 36;
			$rreg->zip          = 28;
			$rreg->phone        = 7;
			$rreg->precon       = 11;
			$rreg->checkedin    = 132;
			$rreg->notes        = 142;
			$arRegFieldNumbers[0] = $rreg;

			// second record fields: (41,42,43,46,133,143)
			$rreg = new RegFieldNumbers();
			$rreg->seqnbr 		= 2;
			$rreg->firstname 	= 41;
			$rreg->lastname 	= 42;
			$rreg->email 		= 43;
		//	$rreg->address 		= 26;
		//	$rreg->city			= 27;
		//	$rreg->state 		= 36;
		//	$rreg->zip 			= 28;
		//	$rreg->phone 		= 7;
			$rreg->precon 		= 46;
			$rreg->checkedin 	= 133;
			$rreg->notes 		= 143;
			$arRegFieldNumbers[1] = $rreg;
		
			// third record fields: (48,49,50,51,134,144)
			$rreg = new RegFieldNumbers();
			$rreg->seqnbr 		= 3;
			$rreg->firstname 	= 48;
			$rreg->lastname 	= 49;
			$rreg->email 		= 50;
		//	$rreg->address 		= 26;
		//	$rreg->city			= 27;
		//	$rreg->state 		= 36;
		//	$rreg->zip 			= 28;
		//	$rreg->phone 		= 7;
			$rreg->precon 		= 51;
			$rreg->checkedin 	= 134;
			$rreg->notes 		= 144;
			$arRegFieldNumbers[2] = $rreg;
			
			// 4th registrants fields: (53,54,55,56,135,145)
			$rreg = new RegFieldNumbers();
			$rreg->seqnbr 		= 4;
			$rreg->firstname 	= 53;
			$rreg->lastname 	= 54;
			$rreg->email 		= 55;
		//	$rreg->address 		= 26;
		//	$rreg->city			= 27;
		//	$rreg->state 		= 36;
		//	$rreg->zip 			= 28;
		//	$rreg->phone 		= 7;
			$rreg->precon 		= 56;
			$rreg->checkedin 	= 135;
			$rreg->notes 		= 145;
			$arRegFieldNumbers[3] = $rreg;
		
			// 5th registrants fields: (57,58,59,60,136,146)
			$rreg = new RegFieldNumbers();
			$rreg->seqnbr 		= 5;
			$rreg->firstname 	= 57;
			$rreg->lastname 	= 58;
			$rreg->email 		= 59;
		//	$rreg->address 		= 26;
		//	$rreg->city			= 27;
		//	$rreg->state 		= 36;
		//	$rreg->zip 			= 28;
		//	$rreg->phone 		= 7;
			$rreg->precon 		= 60;
			$rreg->checkedin 	= 136;
			$rreg->notes 		= 146;
			$arRegFieldNumbers[4] = $rreg;
		
			// 6th registrants fields: (63,64,65,66,137,147)
			$rreg = new RegFieldNumbers();
			$rreg->seqnbr 		= 6;
			$rreg->firstname 	= 63;
			$rreg->lastname 	= 64;
			$rreg->email 		= 65;
		//	$rreg->address 		= 26;
		//	$rreg->city			= 27;
		//	$rreg->state 		= 36;
		//	$rreg->zip 			= 28;
		//	$rreg->phone 		= 7;
			$rreg->precon 		= 66;
			$rreg->checkedin 	= 137;
			$rreg->notes 		= 147;
			$arRegFieldNumbers[5] = $rreg;
		
			// 7th registrants fields: (68,69,70,71,138,148)
			$rreg = new RegFieldNumbers();
			$rreg->seqnbr 		= 7;
			$rreg->firstname 	= 68;
			$rreg->lastname 	= 69;
			$rreg->email 		= 70;
		//	$rreg->address 		= 26;
		//	$rreg->city			= 27;
		//	$rreg->state 		= 36;
		//	$rreg->zip 			= 28;
		//	$rreg->phone 		= 7;
			$rreg->precon 		= 71;
			$rreg->checkedin 	= 138;
			$rreg->notes 		= 148;
			$arRegFieldNumbers[6] = $rreg;
		
			// 8th registrants fields: (73,74,75,76,139,149)
			$rreg = new RegFieldNumbers();
			$rreg->seqnbr 		= 8;
			$rreg->firstname 	= 73;
			$rreg->lastname 	= 74;
			$rreg->email 		= 75;
		//	$rreg->address 		= 26;
		//	$rreg->city			= 27;
		//	$rreg->state 		= 36;
		//	$rreg->zip 			= 28;
		//	$rreg->phone 		= 7;
			$rreg->precon 		= 76;
			$rreg->checkedin 	= 139;
			$rreg->notes 		= 149;
			$arRegFieldNumbers[7] = $rreg;
		
			// 9th registrants fields: (78,79,80,81,140,150)
			$rreg = new RegFieldNumbers();
			$rreg->seqnbr 		= 9;
			$rreg->firstname 	= 78;
			$rreg->lastname 	= 79;
			$rreg->email 		= 80;
		//	$rreg->address 		= 26;
		//	$rreg->city			= 27;
		//	$rreg->state 		= 36;
		//	$rreg->zip 			= 28;
		//	$rreg->phone 		= 7;
			$rreg->precon 		= 81;
			$rreg->checkedin 	= 140;
			$rreg->notes 		= 159;
			$arRegFieldNumbers[8] = $rreg;
		
			// 10th registrants fields: (83,84,85,86,141,151)
			$rreg = new RegFieldNumbers();
			$rreg->seqnbr 		= 10;
			$rreg->firstname 	= 83;
			$rreg->lastname 	= 84;
			$rreg->email 		= 85;
		//	$rreg->address 		= 26;
		//	$rreg->city			= 27;
		//	$rreg->state 		= 36;
		//	$rreg->zip 			= 28;
		//	$rreg->phone 		= 7;
			$rreg->precon 		= 86;
			$rreg->checkedin 	= 141;
			$rreg->notes 		= 151;
			$arRegFieldNumbers[9] = $rreg;

			$ar = array();
			
		// get new entries for the current form
//		$newEntries = GFAPI::get_entries( $this->cform['id'], $search_criteria );
			
			foreach ( $lead_registrants as $row ) {
				$cnt = intval($row->cnt);
				$lead_id = $row->lead_id;
				
				$grp_count = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->total_grp_regs );
				$ind_count = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->total_ind_regs );
				$group_total = intval($grp_count) + intval($ind_count); 
				$group_name = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->group_name );
				
				// add the lead to the array
				$reg = new Registrant( $lead_id );
				$reg->gf_lead_id     = $lead_id;
				$reg->payment_status = $row->payment_status; // direct from the query
				$reg->payment_method = $row->payment_method;
				$reg->group_name     = $group_name;
				$reg->form_id        = $form_id;
				$reg->seqnbr         = 1;
				$reg->group_total    = $cnt;
				$reg->regtype        = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->regtype );
				$reg->regreason      = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->regreason );
				$reg->source         = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->source );

				if ( $cnt > 1 ) {		// handle online registrations for multiple people -- more than one on this entry
					$reg->regtype 	= 'Group Lead';
					if ( $reg->group_name === '' ) {	// most likely blank, but making sure before resetting it
						$group_name = 
							$this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->firstname ) . ' ' . 
							$this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->lastname  );
						$reg->group_name = $group_name;
					}
				}  elseif ( $group_name === '' ) {
					$reg->regtype = 'Registrant';
				}
//				elseif ( $group_name <> '' ) {	// in this case the registrant is part of a group
//					if ( $reg->regtype <> 'Speaker' || $reg->regtype <> 'Sponsor' ) {
//						$reg->regtype = 'Group Member';
//					}
//				} else {							// otherwise, this is an individual registration
//					$reg->regtype 	= 'Individual';
//					$reg->group_name = '';
//				}
				
				$reg->firstname   = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->firstname, 'TBD' );
				$reg->lastname    = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->lastname, 'TBD' );
				$reg->email       = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->email, 'TBD' );
				$reg->address     = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->address );
				$reg->city        = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->city );
				$reg->state       = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->state );
				$reg->zip         = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->zip );
				$reg->phone       = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->phone );
				$reg->precon      = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->precon );
				$reg->checkedin   = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->checkedin, 'No' );
				$reg->notes       = $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[0]->notes );
				$reg->paid        = $row->payment_status;
				$reg->datasource  = $reg->source;
				$ar[] = $reg;
				$total_registrants++;

				if ( $cnt > 1 ) {
					// find all of the members of $lead_id's group and add them
					for ( $i=2; $i<=$cnt; $i++ ) {
						$reg = new Registrant( $lead_id );
						$reg->gf_lead_id 	= $lead_id;
						$reg->form_id		= $form_id;
						$reg->seqnbr 		= $i;
						$reg->group_name    = $group_name;
						$reg->group_total 	= $cnt;
						$reg->regtype 		= 'Group Member';
						$reg->firstname		= $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[$i-1]->firstname, 'TBD' );
						$reg->lastname 		= $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[$i-1]->lastname, 'TBD' );
						$reg->email			= $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[$i-1]->email, 'TBD' );
						$reg->address		= $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[$i-1]->address );
						$reg->city 			= $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[$i-1]->city );
						$reg->state			= $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[$i-1]->state );
						$reg->zip 			= $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[$i-1]->zip );
						$reg->phone			= $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[$i-1]->phone );
						$reg->precon 		= $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[$i-1]->precon );
						$reg->checkedin		= $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[$i-1]->checkedin, 'No' );
						$reg->notes			= $this->find_reg_item( $details, $lead_id, $arRegFieldNumbers[$i-1]->notes );
						$reg->paid          = $row->payment_status;
						$reg->datasource    = $reg->source;
						$ar[] = $reg;
						$total_registrants++;
					}
				}
			}
		}

		$arFieldLabels = array( 'form_id', 'gf_lead_id', 'seqnbr', 'group_name', 'group_total', 'regtype', 'firstname', 'lastname',
			'email', 'address', 'city', 'state', 'zip', 'phone', 'precon', 'checkedin', 'notes', 'status', 'source');
	
		date_default_timezone_set('America/New_York');
		$filename = $csv_filename."_".date("Y-m-d_H-i",time()).'.csv';

		$outfile = plugin_dir_path( __FILE__ ) . 'uploads/'.$filename;  // put the file in /admin/uploads
		$public_file = esc_url( get_site_url() ) . '/wp-content/plugins/expo-checkin-manager/admin/uploads/'.$filename;
//		echo '<h3>File URL: ' . $public_file. '</h3>';

		$out = fopen( $outfile, "a" ); 
		fputcsv( $out, $arFieldLabels);
		foreach( $ar as $a ) {
			$arfields = array( $a->form_id, $a->gf_lead_id, $a->seqnbr, $a->group_name, $a->group_total, $a->regtype, $a->firstname, $a->lastname, 
				$a->email, $a->address, $a->city, $a->state, $a->zip, $a->phone, $a->precon, $a->checkedin, $a->notes, $a->paid, $a->datasource );
			fputcsv($out, $arfields, $delimiter = ",", $enclosure = '"');
			$last_export_entry_id = $a->gf_lead_id;
		}
		
		fclose($out);

		$csvlink = '<a href="'.$public_file.'">Link to file</a>';
		$data = '<h2>Lead Registrants: '.$total_lead_registrants.'</h2>';
		$data .= '<h2>All Registrants: '.$total_registrants.'</h2>';
		$data .= '<h3>'.$csvlink.'</h3>';
		$data .= '<h3>Last Export Entry ID: ' . $last_export_entry_id.'</h3>';
		
		$options['last_export_entry_id'] = $last_export_entry_id;
	    update_option($this->plugin_name, $options);


//		$data .= '<ol>';
//		foreach( $ar as $reg ) {
//			$data .= '<li>'.$reg->gf_lead_id.' '.$reg->firstname.' '.$reg->lastname.' group_total: '.$reg->group_total.'</li>';
//		}
//		$data .= '</ol>';
//
		echo $data;
		
		return true;
   
	}

	private function find_reg_item( $details, $lead_id, $field_number, $default_value='' ) {
		$v = $default_value;
		
		foreach( $details as $row ) {
			if ( $row->lead_id == $lead_id && $row->field_number == $field_number ) {
				return( $row->field_value );
			}
		}
		return ( $v );
	}




}
