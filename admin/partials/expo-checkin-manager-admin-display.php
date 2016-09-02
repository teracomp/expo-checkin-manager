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

    <form method="post" name="expo_manager_options" action="options.php">
		<?php	
            // /*
            // * Grab all value if already set
            // *
            // */
            $options = get_option($this->plugin_name);
    
            /*
            * Set up hidden fields
            *
            */
            settings_fields($this->plugin_name);
            do_settings_sections($this->plugin_name);
		?>
            <h2><?php esc_attr_e( 'Main Features', $this->plugin_name ); ?></h2>
        
<article>
            <ol>
                <li>Export list of registrants, sponsors and speakers from Gravity Forms registration form to Check-In ready CSV file</li>
                <li>Import lists from various external sources (CSV files)
                    <ul>
                        <li>Append these records to the appropriate registration form</li>
                        <li>Map columns from CSV to form fields</li>
                    </ul>
                </li>
                <li>Add/Edit Records</li>
                <li>Generate reports: predefined &amp; custom</li>
                <li>Configure on-site conference page</li>
            </ol>
</article>
<!--        <p class="submit"><?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?></p> -->

    </form>
</div>

