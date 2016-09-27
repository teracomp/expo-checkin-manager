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
    <form id="frm_import_sheet" action="<?php echo admin_url( 'admin-ajax.php' ) ?>" method="post" enctype="multipart/form-data">
        <?php	
            // /*
            // * Grab all value if already set
            // */
            $options = get_option($this->plugin_name);
			$import_to_form    = $options['import_to_form'];
            $last_import_count  = $options['last_import_count'];
			$last_import_count = apply_filters('exm_count_tmp_records', $v);

			// get list of valid gravity forms
			$gfList = apply_filters( 'exm_get_gf_forms_list' );

            /*
            * Set up hidden fields
            */
            wp_nonce_field( 'import_csv', 'my_nonce_field' ); 
            settings_fields($this->plugin_name); 

        ?>

        <h2><?php esc_attr_e( '2. Update Selected Gravity Forms Entries by Importing Checkin App CSV', $this->plugin_name ); ?></h2>
        <h3>Process</h3>
        <p>When the conference is over, we'll import the checkin data back to the database by:</p>
		<ol>
            <li>Select the target form</li>
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

       	<h4>Step 1: Select Form</h4>
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
        
        <h4><em>Working on this functionality</em></h4>
<!--
       	<h4>Step 2: Select csv File</h4>
        <fieldset>
        	<input class="button-primary" type='file' name='csv_update_file' id='csv_update_file' accept='.csv'>
        </fieldset>

        <h4>Step 3: Update Entries</h4>
        <fieldset>
        	<input type='hidden' name='action' value='import_csv'> 
            <input disabled id="update_entries_btn" class="button-primary" type='submit' value='Update Entries'>
        </fieldset>

    
-->    </form>
    
    <div id="update_results"></div>
    

</div>
