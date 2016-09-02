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
            $last_import_count  = $options['last_import_count'];
			$last_import_header = $options['last_import_header'];
			$last_import_header = implode(", ", $last_import_header );
			if ( $last_import_count == 0 ) {
				$newcount = apply_filters('exm_count_tmp_records', $v);

				if ( $newcount <> 0 ) {
					$last_import_count = $newcount;
				} else {
					$last_import_count = 'unk';
				}					
			}
            /*
            * Set up hidden fields
            */
            settings_fields($this->plugin_name);
            do_settings_sections($this->plugin_name);
        ?>
    
        <h2><?php esc_attr_e( 'Import Sheets into Selected Gravity Forms Form', $this->plugin_name ); ?></h2>
<!--    
        <fieldset>
            <input type="hidden" id="<?php echo $this->plugin_name; ?>-last_import_count" name="<?php echo $this->plugin_name; ?>[last_import_count]" value="<?php if(!empty($last_import_count)) echo $last_import_count; ?>"/>
            <label for="<?php echo $this->plugin_name; ?>[last_import_count]">Last Import Count: <?php if(!empty($last_import_count)) echo $last_import_count; ?></label>
        </fieldset>
-->
	</form>

	<article>
        <h3>Requirements</h3>
        <ol>
            <li>Create mapping process of CSV to Gravity Forms form
                <ol>
                    <li>Allow configuration to be saved per form</li>
                    <li>Allow user to modify and save as new configuration</li>
                </ol>
            </li>
            <li>Select file to import</li>
            <li>Show preview of data</li>
            <li>Click Import Data button</li>
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

    <form action="<?php echo admin_url( 'admin-ajax.php' ) ?>" method="post" enctype="multipart/form-data">
        <?php 
            $options = get_option($this->plugin_name);
            $last_import_count = $options['last_import_count'];
			if ( $last_import_count == 0 ) {
				$newcount = apply_filters('exm_count_tmp_records', $v);

				if ( $newcount <> 0 ) {
					$last_import_count = $newcount;
				} else {
					$last_import_count = 'unk';
				}
			}
			
            wp_nonce_field( 'submit_content', 'my_nonce_field' ); 
            settings_fields($this->plugin_name); 
        ?>
        <fieldset>
            <label for="<?php echo $this->plugin_name; ?>[last_import_header]">Last Import Header: 
                <input type="text" readonly class="wide-text" id="<?php echo $this->plugin_name; ?>-last_import_header" name="<?php echo $this->plugin_name; ?>[last_import_header]" value="<?php if(!empty($last_import_header)) echo $last_import_header; ?>"/>
            </label>
        </fieldset>
        <fieldset>
            <input type="hidden" id="<?php echo $this->plugin_name; ?>-last_import_count" name="<?php echo $this->plugin_name; ?>[last_import_count]" value="<?php if(!empty($last_import_count)) echo $last_import_count; ?>"/>
            <label for="<?php echo $this->plugin_name; ?>[last_import_count]">Last Import Count: <?php if(!empty($last_import_count)) echo $last_import_count; ?></label>
        </fieldset>
        <p><input type='file' name='csv_import_file' accept='.csv'></p>
        <p>
        	<input type='hidden' name='action' value='submit_content'> 
            <input type='submit' value='Get Sheet'>
        </p>
    </form>
</div>
