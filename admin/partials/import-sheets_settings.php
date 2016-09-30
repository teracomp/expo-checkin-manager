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
    
        <h2><?php esc_attr_e( '1. Import Sheets into Selected Gravity Forms Entries (i.e., Groups, Sponsors, Speakers, Specials)', $this->plugin_name ); ?></h2>
		<ol>
            <li>Select the target form</li>
            <li>Select file to import (verify the header column names are valid)</li>
            <li>If valid, Import the file as Entries for the applicable form</li>
        </ol>
		<h3>Valid Column Names</h3>
        <p>When preparing your import files, use any of the following columns:</p>
        <p style="margin-left:2em;">group_name, group_total, regtype, regreason, payment_status, source, <br />
        	firstname, lastname, email, address, city, state, zip, phone, precon, <br />
            spouse_firstname, spouse_lastname, spouse_email, spouse_precon, notes</p>
        <p>This simplifies the entire process! </p>
        <hr />
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
        	<input class="button-primary" type='file' name='csv_import_file' id='csv_import_file' accept='.csv'>
        </fieldset>
	
    	<div id="importMsg"></div>

<!--        <fieldset>
        	<?php if ( $last_import_count > 0 ) { ?>
	            <label>Ready to create <?php if(!empty($last_import_count)) echo $last_import_count; ?> entries.</label>
			<?php } else { ?>
				<label>Please select a file first!</label>
            <?php } ?>
        </fieldset>-->

        <h4>Step 3: Import the file</h4>
        <fieldset>
        	<input type='hidden' name='action' value='import_csv'> 
            <input disabled id="import_csv_sheet_btn" class="button-primary" type='submit' value='Import File'>
        </fieldset>

    
    </form>
    
    <div id="import_results"></div>
    
</div>
