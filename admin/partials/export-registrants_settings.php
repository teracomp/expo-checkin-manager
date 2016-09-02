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
            /*
            * Set up hidden fields
            *
            */
            settings_fields($this->plugin_name);
            do_settings_sections($this->plugin_name);
		?>

        <ol>
            <li>Show total leaders and total registrants</li>
            <li>Create link to CSV file (file saved in [plugin]/admin/uploads</li>
        </ol>
 
        <fieldset>
            <label for="<?php echo $this->plugin_name; ?>[csv_filename]">Filename for CSV Export file: 
                <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-csv-filename" name="<?php echo $this->plugin_name; ?>[csv_filename]" value="<?php if(!empty($csv_filename)) echo $csv_filename; ?>"/>
            </label>
        </fieldset>

        <p class="submit"><?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?></p>        

    </form>

 	<form method="post" name="reg_data">
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
 