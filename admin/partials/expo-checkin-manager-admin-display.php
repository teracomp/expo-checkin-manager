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
                <li>Import lists from various external sources (CSV files) to appropriate Registrants form
                	<ol>
                    	<li><span class="check-done">Upload sheet to tmp database on-site</span></li>
                        <li><span class="check-done">Select destination form</span></li>
                    	<li><span class="check-done">Add New Registrants from import</span></li>
                        <li>Update Existing Registrants</li>
                    </ol>
                </li>
                <li><span class="check-done">Export list of registrants, sponsors and speakers from Gravity Forms Entries 
                	to csv-formatted file for the Exponential Checkin application database.</span></li>
                <li>Add/Edit Entries (need to discuss this feature)</li>
                <li>Generate reports (need input here), probably a group of predefined &amp; custom. Thinking about moving this to a shortcode for a page
                	with controlled access. Conceptually, the reports submenu is where we define the reports, the shortcode is where they are displayed.</li>
                <li>Configure on-site conference page. Thinking about moving this to a shortcode for a page with controlled access.</li>
            </ol>
            <p>This "main" page might be a good place for summary of registrants by form. 
            Basically a list of Events (applicable form names) with totals for registrants, sponsors and speakers (regtype). Just a thought.</p>
		</article>
<!--        <p class="submit"><?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?></p> -->

    </form>
</div>

