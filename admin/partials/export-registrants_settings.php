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
        	<li>Select form
            	<ol>
                	<li>Currently works for DC Regional ONLY</li>
                </ol>
            </li>
            <li>Create Registrants CSV File
            	<ol>
                	<li>Some entries can have up to 10 registrants</li>
                    <li>File saved in [plugin]/admin/uploads</li>
                    <li>Currently hard-wired to DC Regional</li> 
                </ol>
            </li>
            <li>Output: 
            	<ol>
		            <li>Show total leaders (a leader is defined as any form that has more than 1 registrant)</li>
                    <li>Show Total registrants</li>
                    <li>Show link to file that was created</li>
                </ol>
            </li>
        </ol>

		<fieldset>
        	<h4>Select Form Entries to Export (only those with registrants are shown here):</h4>
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
            <label class="ecm-inline-button" for="<?php echo $this->plugin_name; ?>[csv_filename]">Filename for CSV Export file: 
                <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-csv-filename" name="<?php echo $this->plugin_name; ?>[csv_filename]" value="<?php if(!empty($csv_filename)) echo $csv_filename; ?>"/>
            <?php submit_button(__('Save Filename', $this->plugin_name), 'primary','submit', TRUE); ?>
            </label>
        </fieldset>
    </form>

<!--
<form action="<?php echo admin_url( 'admin-ajax.php' ) ?>" method="post">
		<input type='hidden' name='action' value='post_type_search_callback'> 
        <?php
            wp_nonce_field( 'post_type_search_callback', 'my_nonce_field' ); 
		?>
            <input type='submit' value='click me'>
            <button id="button1">Ajax Me</button>
            <label for="chkbox1">
	            <input type="checkbox" id="chkbox1" name="<?php $this->plugin_name; ?>[chkbox1]" value="Some Value" /> Checkbox 1
			</label>
</form>

--> 	<form method="post" name="reg_data">
    
		<?php 	
            settings_fields($this->plugin_name); 

            // react to button click
            __( submit_button('Create Registrants CSV File', 'primary', 'submit_reg_data', TRUE)); 
			
        ?>
	</form>
	<?php
			if ( isset( $_REQUEST['submit_reg_data'] ) ) {
				do_action('exm_show_reg_data');
			}
	?>


 </div>
 