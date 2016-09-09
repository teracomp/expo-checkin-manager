<?php
/**
 * Partial of the import-sheets settings page
 *
 * @link       http://teracomp.net
 * @since      1.0.0
 *
 * @package    Expo_Checkin_Manager
 * @subpackage Expo_Checkin_Manager/admin/partials
 */
?>
<div id="import-sheets" class="wrap">
    <form method="post" name="expo_manager_options" action="options.php">
        <?php	
            // /*
            // * Grab all value if already set
            // */
            $options = get_option($this->plugin_name);
			$last_import_header = $options['last_import_header'];
			$last_import_header = implode(", ", $last_import_header );

			$header_rows_count = $options['header_rows_count'];
			$import_group_name = $options['import_group_name'];
			$import_to_form    = $options['import_to_form'];
            $last_import_count  = $options['last_import_count'];
			$last_import_count = apply_filters('exm_count_tmp_records', $v);
			if ( $last_import_count == 0 ) {
				$last_import_count = 'unk';
			}

			// get list of valid gravity forms
			$gfList = apply_filters( 'exm_get_gf_forms_list' );

            /*
            * Set up hidden fields
            */
            settings_fields($this->plugin_name);
            do_settings_sections($this->plugin_name);
        ?>
    
        <h2><?php esc_attr_e( '1. Import Sheets (Groups, Sponsors, Speakers, Special) into Selected Gravity Forms Entries', $this->plugin_name ); ?></h2>
        <h3>Process</h3>
        <p>Tranforming a signup sheet into Gravity Forms entries requires this process:</p>
		<ol>
        	<li>Select the target form</li>
            <li>Each form needs to have a mapping template and there are at least 3 different sets of logic involved. 
            Since each entry can have no more than 10 registrants, we work with multiples of 10 when importing group sheets.
            </li>
            <li>Indicate the number of header rows in the csv file (default: 1)</li>
            <li>Provide a group name if there is none in the data (default: first person on the list)</li>
            <li>Choose the file to import</li>
            <li>Import the Sheet</li>
        </ol>
        <p>The "Last Import Header" is currently shown for development, but provides a clue that the import was successful.</p>
        <p>The Import Count indicates how many records were last imported. This should become the current operation.</p>

		<fieldset>
        	<h4>Select Form:</h4>
            <ul>
            <?php
                foreach( $gfList as $key=>$value ) {
            ?>            
                <li>
                    <label for="<?php echo $this->plugin_name; ?>-import-to-form-<?php echo $key?>">
                        <input type="radio" <?php checked( $options['import_to_form'], $key ); ?>
                        	id="<?php echo $this->plugin_name; ?>-import-to-form-<?php echo $key?>" 
                        	name="<?php echo $this->plugin_name; ?>[import_to_form]" value="<?php echo $key ?>">
                        &nbsp;<?php echo $value; ?>
                    </label>
                </li>
            <?php
                }
            ?>
            </ul>        
        </fieldset>


        <fieldset>
            <label for="<?php echo $this->plugin_name; ?>[header_rows_count]">Number of Header Rows: 
                <input type="text" id="<?php echo $this->plugin_name; ?>-header_rows_count" name="<?php echo $this->plugin_name; ?>[header_rows_count]" value="<?php if(!empty($header_rows_count)) echo $header_rows_count; ?>"/>
            </label>
        </fieldset>

        <fieldset>
            <label for="<?php echo $this->plugin_name; ?>[import_group_name]">Group Name: 
                <input type="text" id="<?php echo $this->plugin_name; ?>-import_group_name" name="<?php echo $this->plugin_name; ?>[import_group_name]" value="<?php if(!empty($import_group_name)) echo $import_group_name; ?>"/>
            </label>
        </fieldset>

<!--    
        <fieldset>
            <input type="hidden" id="<?php echo $this->plugin_name; ?>-last_import_count" name="<?php echo $this->plugin_name; ?>[last_import_count]" value="<?php if(!empty($last_import_count)) echo $last_import_count; ?>"/>
            <label for="<?php echo $this->plugin_name; ?>[last_import_count]">Last Import Count: <?php if(!empty($last_import_count)) echo $last_import_count; ?></label>
        </fieldset>
-->
            <?php submit_button(__('Save Settings', $this->plugin_name), 'primary','submit', TRUE); ?>

	</form>
    <form id="frmGetImportFile" name="frmGetImportFile" action="<?php echo admin_url( 'admin-ajax.php' ) ?>" method="post" enctype="multipart/form-data">
        <?php 
            wp_nonce_field( 'submit_content', 'my_nonce_field' ); 
            settings_fields($this->plugin_name); 
        ?>
        <fieldset>
            <label for="<?php echo $this->plugin_name; ?>[last_import_header]">Last Import Header: 
                <input type="text" class="wide-text" id="<?php echo $this->plugin_name; ?>-last_import_header" name="<?php echo $this->plugin_name; ?>[last_import_header]" value="<?php if(!empty($last_import_header)) echo $last_import_header; ?>"/>
            </label>
        </fieldset>
        <fieldset>
            <input type="hidden" id="<?php echo $this->plugin_name; ?>-last_import_count" name="<?php echo $this->plugin_name; ?>[last_import_count]" value="<?php if(!empty($last_import_count)) echo $last_import_count; ?>"/>
            <label for="<?php echo $this->plugin_name; ?>[last_import_count]">Ready for Import Count: <?php if(!empty($last_import_count)) echo $last_import_count; ?></label>
        </fieldset>
        <p><input type='file' name='csv_import_file' id='csv_import_file' accept='.csv'></p>
	
<!--    	<input type='hidden' name='action' value='post_type_search_callback'> 
        <?php
            wp_nonce_field( 'post_type_search_callback', 'my_nonce_field' ); 
		?>           
            <button id="button1">Ajax Me</button>
-->

        <p>
        	<input type='hidden' name='action' value='submit_content'> 
            <input type='submit' value='Import Sheet'>
        </p>
    </form>
    

        <h2><?php esc_attr_e( '2. Update Selected Gravity Forms Entries by Importing Checkin App CSV', $this->plugin_name ); ?></h2>
        <h3>Process</h3>
        <p>When the conference is over, we'll import the checkin data back to the database by:</p>
		<ol>
            <li>Choose the file to import</li>
            <li>Import the Sheet</li>
        </ol>
        <p>The csv file will have the form_id and the lead_id as part of the key fields for updating data.</p>
        <p>The code will use Gravity Forms API methods:</p>
        	<ol>
            	<li>get_entries(form_id). Returns all the entries for a given form.</li>
            	<li>get_entry(entry_id). Returns one entry based on entry_id (which is the lead_id)</li>
                <li>update_entry( array( field_id, value )). Allows us to update the entry by targeting the specific form field.</li>
            </ol>

	<article>
        <h3>Requirements</h3>
        <ol>
            <li>Import lists from various external sources (CSV files) to appropriate Registrants form
                <ol>
                    <li><span class="check-done">Select file to import</span></li>
                    <li><span class="check-done">Upload sheet to tmp database on-site</span></li>
                    <li><span class="check-deleted">Show preview of data</span></li>
                    <li>Select destination form</li>
                    <li>Show mapping presets based on form</li>
                    <li>Add New Registrants (gf_lead_id is NULL)</li>
                    <li>Update Existing Registrants</li>
                    <li>Append records as form entries</li>
                </ol>
            </li>
            <li>Create mapping process of CSV to Gravity Forms form (might make this it's own submenu)
                <ol>
                    <li>Allow configuration to be saved per form</li>
                    <li>Allow user to modify and save as new configuration</li>
                    <li>Might be better to have this mapping functionality on a "Settings" submenu</li>
                </ol>
            </li>
            <li>Click Import Data button
            	<ul>
                	<li><span class="check-done">Import to plugin database table</span></li>
                    <li>Redesign the UX with bootstrap Add-on style so the import button is next to the filename</li>
                </ul>
            </li>
            <li>Display Results of Import (x number of records)</li>
        </ol>
    
        <h3>Development Steps</h3>
        <ol>
            <li><span class="check-done">Select file to import and upload to server</span></li>
            <li><span class="check-done">Parse data</span>
                <ol>
                    <li><span class="check-done">Get header row: List CSV fields from header row</span></li>
                    <li><span class="check-done">Get data rows</span></li>
                    <li><span class="check-done">Add data to expo_checkin_tmp database table</span></li>
                </ol>
            </li>
            <li>Get list of active Gravity Forms (did this for my.personalcalling.org...similar process). 
            Actually found the GFAPI (Gravity Forms API) is well documented, though quite large.
            Easily list the forms...building the UX is a different story.
            Need to master AJAX for dynamically working on these pages. Be great if I could get AngularJS to work!
                <ol>
                    <li>Show list of forms (key: id)</li>
                    <li>Show list of fields for mapping</li>
                </ol>
            </li>
            <li>Create Mapping Process
                <ol>
                    <li>Replace hard-coded values in DC Regional form with plugin options values</li>
                    <li>Develop interface to show available fields</li>
                    <li>Develop interface to managing Mapping Templates (save, edit, delete, duplicate)</li>
                </ol>
            </li>
            <li>Create data preview process</li>
            <li>Create import process</li>
            <li>Create results of import process</li>
        </ol>
    </article>


</div>
