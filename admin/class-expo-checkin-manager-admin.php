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
		wp_enqueue_style( 'wp-color-picker' ); // for use in creating style for conference forms
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/expo-checkin-manager-admin.css', array( 'wp-color-picker' ), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_media();   // Enqueues all scripts, styles, settings, and templates necessary to use all media JavaScript APIs.
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/expo-checkin-manager-admin.js', array( 'jquery', 'wp-color-picker', 'media-upload'  ), $this->version, false );
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
		add_submenu_page($this->plugin_name, 'Update Entries', 'Update Entries', 'manage_options', $this->plugin_name.'-update', array($this, 'display_plugin_update_page'));
		add_submenu_page($this->plugin_name, 'Add/Edit Regs', 'Add/Edit Regs', 'manage_options', $this->plugin_name.'-addedit', array($this, 'display_plugin_addedit_page'));
		add_submenu_page($this->plugin_name, 'Reports', 'Reports', 'manage_options', $this->plugin_name.'-reports', array($this, 'display_plugin_reports_page'));
		add_submenu_page($this->plugin_name, 'Conf Config', 'Conf Config', 'manage_options', $this->plugin_name.'-config', array($this, 'display_plugin_config_page'));
//		add_submenu_page($this->plugin_name, 'Settings', 'Settings', 'manage_options', $this->plugin_name.'-settings', array($this, 'display_plugin_settings_page'));


	}
	
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
	
	public function display_plugin_update_page() {
		include_once( 'partials/update-entries.php' );
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

	// ajax call to set the current form
	// updates the options table, then calls the local set_current_form method
	public function set_curr_form_callback() {
		if ( isset( $_REQUEST['form_id'] ) ){
			$form_id = $_REQUEST['form_id'];
			$options = get_option( $this->plugin_name );
			$options['import_to_form'] = $form_id;
			update_option( $this->plugin_name, $options );
			$this->set_current_form( $form_id );
		}
		echo 'set curr form id: ' . $form_id;
		wp_die();	// required by ajax
	}
	
	// set the form for this instance
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
	
	// powerful method that gets the appropriate field id based on the label provided
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

	// create a list of Gravity Forms installed on this system
	public function get_gf_forms_list() {

		$ans = array();
		$forms = GFAPI::get_forms();   // get_forms() returns active forms

		$search_criteria['status'] = 'active';		// active entries only
		$search_criteria['field_filters'][] = array( 'key' => 'payment_status', 'operator'=>'contains', 'value'=>'paid');		// paid or unpaid (not case sensitive)
	
		foreach ( $forms as $frm ) { 			
			$total_entries = GFAPI::count_entries( $frm['id'], $search_criteria );
//			$pagesize = array( 'offset'=>0, 'page_size'=>$total_entries );
//			$entries = GFAPI::get_entries( $frm['id'], $search_criteria, null, $pagesize );
//			$total_registrants = 0;
//			foreach ( $entries as $entry) {
//				$total_registrants += $this->count_regs_per_entry( $entry ); // get the details per entry
//			}
			$ans[ $frm['id'] ] = $frm['title'] . ' (' . $total_entries.' active entries)';	// build a key=>value array
		}
		return $ans;
	}

	// very specific csv importer
	// expects appropriate column names that will match the tmp database table
	// once the file is parsed into the database, calls the method to create entries
	// the tmp db table is probably not required, but it makes it easy to troubleshoot
	public function import_csv_processor() {
		global $wpdb;

		// our temp database table	
		$dbtable = $wpdb->prefix . 'expo_checkin_tmp';

		$filename = $_FILES['csv_import_file']['name'];		

		$theOptions = get_option($this->plugin_name);
		$groupName         = ''; // $theOptions['import_group_name']; --> group_name is a column in the sheet being imported
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
		
		$strAnswer = $this->create_entries_from_db();
		$strAnswer .= '<h3>Imported ' . $filename . '. found ' . $group_total . ' records for form_id: ' . $form_id . '</h3>';

		echo $strAnswer;
		
		wp_die();	// required by ajax
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
	
	// workhorse method that transforms data in the tmp db into entries
	// uses the current form instance for this object
	// only uploads records that have not been imported by looking WHERE data_sync IS NULL
	public function create_entries_from_db() {
		global $wpdb;
		date_default_timezone_set('America/New_York');

//		$options = get_option( $this->plugin_name );
//		$form_id = $options['import_to_form'];

		$form_id = $this->cform['id'];	// get the current form id

		$regreason = 'Imported';	
		$dbtable = $wpdb->prefix . 'expo_checkin_tmp';
		
		$sql = "SELECT * FROM $dbtable WHERE data_sync IS NULL";
		$ans = $wpdb->get_results( $sql );
		$cnt_to_add = count($ans);
		$cnt_entries_added = 0;

		
		// get_field_number looks up the appropriate field for the current Gravity Forms form	
		foreach ( $ans as $tmpdb ) {
			$currdatetime = date('Y/m/d H:i:s', time());
			$newEntry = array(
				'form_id' => $form_id,
				'payment_status' => $tmpdb->payment_status,
				'payment_method' => 'Offline',
				$this->get_field_number('group_name')    => $tmpdb->group_name,
				$this->get_field_number('regtype')       => $tmpdb->regtype,
				$this->get_field_number('source')        => $tmpdb->source . ' at ' .$currdatetime,
				$this->get_field_number('regreason')     => $regreason,
				$this->get_field_number('reg1notes')     => $tmpdb->notes,
				$this->get_field_number('reg1firstname') => $tmpdb->firstname,
				$this->get_field_number('reg1lastname')  => $tmpdb->lastname,
				$this->get_field_number('reg1address')   => $tmpdb->address,
				$this->get_field_number('reg1city')      => $tmpdb->city,
				$this->get_field_number('reg1state')     => $tmpdb->state,
				$this->get_field_number('reg1zip')       => $tmpdb->zip,
				$this->get_field_number('reg1email')     => $tmpdb->email,
				$this->get_field_number('reg1phone')     => $tmpdb->phone,
				$this->get_field_number('reg1precon')    => $tmpdb->precon,
				$this->get_field_number('reg2firstname') => $tmpdb->spouse_firstname,
				$this->get_field_number('reg2lastname')  => $tmpdb->spouse_lastname,
				$this->get_field_number('reg2email')     => $tmpdb->spouse_email,
				$this->get_field_number('reg2precon')    => $tmpdb->spouse_precon,
			);
			$lid = GFAPI::add_entry( $newEntry );
			if ( $lid > 0 ) {
				$data = array( 'data_sync'=> $currdatetime );
				$where = array( 'id' => $tmpdb->id );
				$response = $wpdb->update( $dbtable, $data, $where );
				$cnt_entries_added++;
			}
		}

		$strAnswer = '<h3>Found: '.$cnt_to_add .' in the temp database staging table.</h3>';
		$strAnswer .= '<h3>Added: '.$cnt_entries_added.' Entries</h3>';
		
		return $strAnswer;

	}

	// respond to ajax request to update the filename from export-registrants_settings.php
	public function set_export_filename_callback() {
		$newName = $_REQUEST['csv_filename'];
		$options = get_option( $this->plugin_name );
		$options['csv_filename'] = sanitize_file_name($newName);
		$ans = update_option( $this->plugin_name, $options );
		
		if ( $ans ) {
			$response = '<h3 class="alert alert-success">CSV Filename saved as ' . $newName . '</h3>';
		} else {
			$response = '<h3 class="alert alert-warning">Update Failed for ' . $newName . '! Please refresh the page and try again!</h3>';
		}
		
		echo $response;
		
		wp_die();	// required by ajax
	}

	public function set_export_entry_id_callback() {
		$newEntryID = $_REQUEST['entry_id'];
		$options = get_option( $this->plugin_name );
		$options['last_export_entry_id'] = intval( $newEntryID );
		$ans = update_option( $this->plugin_name, $options );

		if ( $ans ) {
			$response = '<h3 class="alert alert-success">Start Entry ID saved as ' . $newEntryID . '</h3>';
		} else {
			$response = '<h3 class="alert alert-warning">Failed to set Entry ID to ' . $newEntryID . '! Please refresh the page and try again!</h3>';
		}
		
		echo $response;
		
		wp_die();	// required by ajax
		
	}

	// respond to ajax request to export entries from export-registrants_settings.php
	public function export_entries_callback() {		
		$response = 'this is the callback for export entries';		
		$ans = $this->export_entries();
	
		if ( $ans ) {
			$response = $ans;
		} else {
			$response = '<h3 class="alert alert-warning">Export Failed! Please refresh the page and try again!</h3>';
		}		
		echo $response;		
		wp_die();	// required by ajax
	}

	// count the horizontal regs per entry -- total_ind_regs is empty for imported participants
	private function count_regs_per_entry($entry) {
		$cnt=0;
		for ( $i=1; $i<=10; $i++ ) {
			if ( $entry[$this->get_field_number('reg'.$i.'firstname')] <> '' ) {
				$cnt++;
			}
		}
		return $cnt;
	}
	public function export_entries() {
		global $wpdb;
		// get the entry id from the last import. export only the new records
		$options = get_option( $this->plugin_name );
		$form_id                = $options['import_to_form'];
		$last_export_entry_id   = $options['last_export_entry_id'];	
        $csv_filename           = $options['csv_filename'];
		$max_lead_id = 0;	
		
		// define search_criteria for count_entries and get_entries methods
		$search_criteria['status'] = 'active';		// active entries only
		$search_criteria['field_filters'][] = array( 'key' => 'payment_status', 'operator'=>'contains', 'value'=>'paid');		// paid or unpaid (not case sensitive)
		
		$total_entries = GFAPI::count_entries($form_id, $search_criteria );
		$total_registrants = 0;	// running total of registrants
		$page_size = 50;			// Gravity Forms suggests this can be as high as 200
		$pages = ceil( $total_entries / $page_size );	// manage one page at a time
		$sorting = null;			// no need to sort
		
	
		for ( $i=0; $i<$pages; $i++) {
			$paging = array( 'offset' => $i*$page_size, 'page_size' => $page_size );		// get ALL entries for this form
			$entries = GFAPI::get_entries( $form_id, $search_criteria, $sorting, $paging );

			foreach( $entries as $entry ) {
				
				if ( intval($entry['id']) > $last_export_entry_id ) {		// only export those we want
					$lead_id = $entry['id'];								// keep track in the checkin database for updating later
					if ( $lead_id > $max_lead_id ) {
						$max_lead_id = $lead_id;
					}
						
					$seqnbr = 1;
			
					$group_total = $this->count_regs_per_entry($entry);		// this method counts all regs for the entry			

					// grab first and last name here in case we have an undefined group
					$firstname = $entry[$this->get_field_number('reg'.$seqnbr.'firstname')];
					$lastname = $entry[$this->get_field_number('reg'.$seqnbr.'lastname')];
					$group_name = $entry[$this->get_field_number('group_name')];
					if ( strlen($group_name) === 0 && $group_total > 3 ) {			// if there are more than 3, we have an undefine group
						$group_name = $firstname . ' ' . $lastname . ' Group';
					}
					$regtype = $entry[$this->get_field_number('regtype')];
					if ( $regtype === '' ) {
						$regtype = 'Registrant';
					}
					$paid = $entry['payment_status'];
					$source = $entry[$this->get_field_number('source')];
					
					// reg metadata
					$reg = new Registrant( $lead_id );
					$reg->gf_lead_id     = $lead_id;
					$reg->paid           = $paid;	
					$reg->group_name     = $group_name;
					$reg->form_id        = $form_id;
					$reg->group_total    = $group_total;
					$reg->regtype        = $regtype;
					$reg->datasource     = $source;

					// reg individual data
					$reg->seqnbr      = $seqnbr;
					$reg->firstname   = $firstname;
					$reg->lastname    = $lastname;
					$reg->email       = $entry[$this->get_field_number('reg'.$seqnbr.'email')];
					$reg->address     = $entry[$this->get_field_number('reg'.$seqnbr.'address')];
					$reg->city        = $entry[$this->get_field_number('reg'.$seqnbr.'city')];
					$reg->state       = $entry[$this->get_field_number('reg'.$seqnbr.'state')];
					$reg->zip         = $entry[$this->get_field_number('reg'.$seqnbr.'zip')];
					$reg->phone       = $entry[$this->get_field_number('reg'.$seqnbr.'phone')];
					$reg->precon      = $entry[$this->get_field_number('reg'.$seqnbr.'precon')];
					$reg->checkedin   = $entry[$this->get_field_number('reg'.$seqnbr.'checkedin')];
						if ( strlen($reg->checkedin) === 0 ) { $reg->checkedin = 'No'; }
					$reg->notes       = $entry[$this->get_field_number('reg'.$seqnbr.'notes')];
					
					$ar[] = $reg;
					$total_registrants++;

					if ( $group_total > 1 ) {
						// find all of the members of $lead_id's group and add them
						for ( $seqnbr=2; $seqnbr<=$group_total; $seqnbr++ ) {
							$reg = new Registrant( $lead_id );
							$reg->gf_lead_id 	= $lead_id;
							$reg->form_id		= $form_id;
							$reg->seqnbr 		= $seqnbr;
							$reg->group_name    = $group_name;
							$reg->group_total 	= $group_total;
							$reg->regtype 		= $regtype;
							$reg->firstname		= $entry[$this->get_field_number('reg'.$seqnbr.'firstname')];
							$reg->lastname 		= $entry[$this->get_field_number('reg'.$seqnbr.'lastname')];
							$reg->email         = $entry[$this->get_field_number('reg'.$seqnbr.'email')];
							$reg->address       = $entry[$this->get_field_number('reg'.$seqnbr.'address')];
							$reg->city          = $entry[$this->get_field_number('reg'.$seqnbr.'city')];
							$reg->state         = $entry[$this->get_field_number('reg'.$seqnbr.'state')];
							$reg->zip           = $entry[$this->get_field_number('reg'.$seqnbr.'zip')];
							$reg->phone         = $entry[$this->get_field_number('reg'.$seqnbr.'phone')];
							$reg->precon        = $entry[$this->get_field_number('reg'.$seqnbr.'precon')];
							$reg->checkedin     = $entry[$this->get_field_number('reg'.$seqnbr.'checkedin')];
								if ( strlen($reg->checkedin) === 0 ) { $reg->checkedin = 'No'; }
							$reg->notes         = $entry[$this->get_field_number('reg'.$seqnbr.'notes')];
							$reg->paid          = $paid;	
							$reg->datasource    = $source;
							$ar[] = $reg;
							$total_registrants++;
						}
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
		}
		
		fclose($out);
		$last_export_entry_id = $max_lead_id;

		$csvlink = '<a href="'.$public_file.'">Link to file</a>';
		$data .= '<h3>Total Registrants Exported: '.$total_registrants.'</h3>';
		$data .= '<h2>Download here: '.$csvlink.'</h2>';
		$data .= '<h4>Last Export Entry ID: ' . $last_export_entry_id.'</h4>';
		
		$options['last_export_entry_id'] = $last_export_entry_id;
	    update_option($this->plugin_name, $options);

		return $data;
		   
	}

	// legacy method ... not used
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
