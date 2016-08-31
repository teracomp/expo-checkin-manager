<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://exponential.org
 * @since      1.0.0
 *
 * @package    Expo_Checkin_Manager
 * @subpackage Expo_Checkin_Manager/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
 
 	<h2 class="nav-tab-wrapper">
		<a href="#expo-main" class="nav-tab nav-tab-active"><?php _e( 'Main', $this->plugin_name );?></a>
		<a href="#export-reg" class="nav-tab"><?php _e( 'Export', $this->plugin_name );?></a>
		<a href="#import-sheets" class="nav-tab"><?php _e( 'Import', $this->plugin_name );?></a>
		<a href="#add-edit-records" class="nav-tab"><?php _e( 'Add/Edit', $this->plugin_name );?></a>
		<a href="#expo-reports" class="nav-tab"><?php _e( 'Reports', $this->plugin_name );?></a>
		<a href="#config-conf-page" class="nav-tab"><?php _e( 'Config Conf Page', $this->plugin_name );?></a>
	</h2>
 	
    <form method="post" name="expo_manager_options" action="options.php">
		<?php
            // /*
            // * Grab all value if already set
            // *
            // */
            $options = get_option($this->plugin_name);
    
            // panel name
            $var1 = $options['var1'];
            
            /*
            * Set up hidden fields
            *
            */
            settings_fields($this->plugin_name);
            do_settings_sections($this->plugin_name);
    
    
             // Include tabs partials
            require_once('expo-main_settings.php');				// #expo-main, Main
            require_once('export-registrants_settings.php');		// #export-reg, Export			
            require_once('import-sheets_settings.php');			// #import-sheets, Import			
            require_once('add-edit-records_settings.php');		// #add-edit-records, Add/Edit			
            require_once('expo-reports_settings.php');			// #reports, Reports
            require_once('config-conf-page_settings.php');		// #config-conf-page, Config Conf Page
        ?>

        <p class="submit">
            <?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>
        </p>
        
    </form>
</div>

