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
    
    <form method="post" name="expo_manager_options" action="options.php">
		<?php	
            // /*
            // * Grab all value if already set
            // *
            // */
            $options = get_option($this->plugin_name);
    
            $csv_filename = $options['csv_filename'];
			$export_entries_form    = $options['import_to_form'];  // TODO: save the option as export_entries_form
			
			$gfList = apply_filters( 'exm_get_gf_forms_list' );

            /*
            * Set up hidden fields
            *
            */
            settings_fields($this->plugin_name);
            do_settings_sections($this->plugin_name);
		?>
        <h3>Use this page to generate a CSV file for all entries from a selected form.</h3>
        <ol>
        	<li>Select form (currently works for DC Regional ONLY</li>
			<li>Enter a filename</li>
            <li>Save settings</li>
            <li>Create Registrants CSV File
            	<ol>
                	<li>Some entries can have up to 10 registrants</li>
                    <li>File saved in [plugin]/admin/uploads</li>
                </ol>
            </li>
        </ol>

		<fieldset>
        	<h4>1. Select Form Entries to Export (only those with registrants are shown here):</h4>
            <ul>
            <?php
                foreach( $gfList as $key=>$value ) {
            ?>            
                <li>
                    <label for="<?php echo $this->plugin_name; ?>-export_entries_form-<?php echo $key?>">
                        <input type="radio" <?php checked( $options['import_to_form'], $key ); ?> id="<?php echo $this->plugin_name; ?>-export_entries_form-<?php echo $key?>" name="<?php echo $this->plugin_name; ?>[export_entries_form]" value="<?php echo $key ?>">
                        &nbsp;<?php echo $value; ?>
                    </label>
                </li>
            <?php
                }
            ?>
            </ul>        
        </fieldset>

        <fieldset>
            <label class="ecm-inline-button" for="<?php echo $this->plugin_name; ?>[csv_filename]"><strong>2. Filename for CSV Export file:</strong> 
                <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-csv-filename" name="<?php echo $this->plugin_name; ?>[csv_filename]" value="<?php if(!empty($csv_filename)) echo $csv_filename; ?>"/>
            </label>
        </fieldset>
        
        <fieldset>
            <?php submit_button(__('3. Save Settings', $this->plugin_name), 'primary','submit', TRUE); ?>        
        </fieldset>
    </form>

    <form method="post" name="reg_data">    
		<?php 	
            settings_fields($this->plugin_name); 

            // react to button click
            __( submit_button('4. Create Registrants CSV File', 'primary', 'submit_export_entries', TRUE)); 		
        ?>
	</form>
	<?php
			if ( isset( $_REQUEST['submit_export_entries'] ) ) {
				do_action('exm_export_entries');
			}
	?>

    <h2>Expected Output</h2>
    <ol>
        <li>Show total leaders (a leader is defined as any form that has more than 1 registrant)</li>
        <li>Show Total registrants</li>
        <li>Show link to file that was created</li>
    </ol>
	
 </div>
 