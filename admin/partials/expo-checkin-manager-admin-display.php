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
 
 	<h3>Main features:</h3>
    <ol>
    	<li>Export list from Gravity Forms registration form to Check-In ready CSV file</li>
    	<li>Import lists from various external sources (CSV files)
        	<ul>
            	<li>Append these records to the appropriate registration form</li>
                <li>Map columns from CSV to form fields</li>
            </ul>
        </li>
        <li>Add/Edit Records</li>
        <li>Generate predefined reports</li>
        <li>Create custom reports</li>
        <li>Configure on-site conference page</li>
    </ol>
 </div>
 