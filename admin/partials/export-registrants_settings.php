<?php

/**
 * Partial of the export-registrants settings page
 *
 * @link       http://teracomp.net
 * @since      1.0.0
 *
 * @package    Expo_Checkin_Manager
 * @subpackage Expo_Checkin_Manager/admin/partials
 */
?>

<!-- <div id="export-reg" class="wrap ecim-metaboxes hidden"> -->
<div id="export-reg" class="wrap">

	<h2><?php esc_attr_e( 'Export Registrants to CSV', $this->plugin_name ); ?></h2>
    
    <form id="frm_export_sheet" action="<?php echo admin_url( 'admin-ajax.php' ) ?>" method="post">
		<?php	
            // /*
            // * Grab all value if already set
            // *
            // */
            $options = get_option($this->plugin_name);
    
            $csv_filename = $options['csv_filename'];
			$import_to_form = $options['import_to_form'];  // TODO: rename this option as current_form
			$last_export_entry_id = $options['last_export_entry_id'];		// start from where we left off
			$gfList = apply_filters( 'exm_get_gf_forms_list' );

            /*
            * Set up hidden fields
            *
            */
            wp_nonce_field( 'export_csv', 'export_nonce_field' ); 
            settings_fields($this->plugin_name);
		?>
        <h3>Use this page to generate a CSV file for all entries from a selected form.</h3>
        <ol>
        	<li>Select form</li>
			<li>Enter a filename</li>
            <li>Accept the last entry id or change the number to a known starting point</li>
            <li>Create Registrants CSV File
            	<ol>
                	<li>Some entries can have up to 10 registrants</li>
                    <li>File saved in [plugin]/admin/uploads</li>
                </ol>
            </li>
            <li>Download CSV File for Checkin App</li>
        </ol>

       	<h4>1. Select Form Entries to Export:</h4>
		<fieldset>
            <ul>
            <?php
                foreach( $gfList as $key=>$value ) {
            ?>            
                <li>
                    <label for="<?php echo $this->plugin_name; ?>-import-to-form-<?php echo $key?>">
                        <input class="gflist" type="radio" <?php checked( $options['import_to_form'], $key ); ?>
                        	id="<?php echo $this->plugin_name; ?>-import-to-form-<?php echo $key?>" 
                        	name="<?php echo $this->plugin_name; ?>[import_to_form]" 
                            value="<?php echo $key ?>">
                        &nbsp;<?php echo $value; ?>
                    </label>
                </li>
            <?php
                }
            ?>
            </ul>        
        </fieldset>

        <fieldset>
            <label class="ecm-inline-button" for="export_csv_filename"><strong>2. Filename for CSV Export file:</strong> 
                <input type="text"  
                	id="export_csv_filename" 
                    value="<?php if(!empty($csv_filename)) echo $csv_filename; ?>"/>
            </label>
            <div id="export_csv_filename_status"></div>
        </fieldset>

        <fieldset>
        	<div class="ecm-group">
	            <span class="ecm-left ecm-group-tweak-top ecm-group-pad-right"><strong>3. Last Entry ID Exported:</strong></span>
                <input class="ecm-left" type="text"  size="8"
                	id="last_export_entry_id" 
                    value="<?php if(!empty($last_export_entry_id)) echo $last_export_entry_id; ?>"/>
	            <span class="ecm-left ecm-group-tweak-top ecm-group-pad-left" id="last_export_ok" style="display:none;">
                	<button type="button" id="last_export_ok_btn">Set</button>
                </span>
            </div>
        </fieldset>
        
        <h4>4. Create Registrants CSV File</h4>

        <fieldset>
        	<input type='hidden' name='action' value='export_csv'> 
            <input id="export_csv_btn" class="button-primary" type='button' value='Create File'>
        </fieldset>

		<div id="export_waiting" style="display:none;">
            <img src="<?php echo plugin_dir_url( __FILE__ );?>images/loading_bar2s.gif" width="265" height="97" alt="please wait..."/>
        </div>

    	<div id="export_csv_results"></div>
	</form>

    <h2>Expected Output</h2>
    <ol>
        <li>Total registrants</li>
        <li>Link to file that was created</li>
    </ol>
	
 </div>
 