<?php
/**
 * Partial of the update entries page
 *
 * @link       http://teracomp.net
 * @since      1.0.0
 *
 * @package    Expo_Checkin_Manager
 * @subpackage Expo_Checkin_Manager/admin/partials
 */
?>
<div id="update-entries" class="wrap">
    <form id="frm_update_entries" action="<?php echo admin_url( 'admin-ajax.php' ) ?>" method="post" enctype="multipart/form-data">
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
            wp_nonce_field( 'update_entries', 'my_nonce_field' ); 
            settings_fields($this->plugin_name); 

        ?>

        <h2><?php esc_attr_e( '2. Update Selected Gravity Forms Entries by Importing Checkin App CSV', $this->plugin_name ); ?></h2>
        <h3>Process</h3>
        <p>When the conference is over, we'll import the checkin data back to the database by:</p>
		<ol>
            <li>Select the target form</li>
            <li>Choose a file for updating</li>
            <li>Update Entries</li>
        </ol>
        <p>The csv file will have the form_id and the lead_id as part of the key fields for updating data.</p>

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

       	<h4>Step 2: Select csv File</h4>
        <fieldset>
        	<input class="button-primary" type='file' name='csv_update_file' id='csv_update_file' accept='.csv'>
        </fieldset>

        <h4>Step 3: Update Entries</h4>
        <fieldset>
        	<input type='hidden' name='action' value='update_entries'> 
            <input disabled id="update_entries_btn" class="button-primary" type='submit' value='Update Entries'>
        </fieldset>

    
    </form>

    <div id="update_waiting" style="display:none;">
        <img src="<?php echo plugin_dir_url( __FILE__ );?>images/loading_bar2s.gif" width="265" height="97" alt="please wait..."/>
    </div>
    
    <div id="update_results" style="max-height:640px;overflow:scroll;"></div>
    

</div>
