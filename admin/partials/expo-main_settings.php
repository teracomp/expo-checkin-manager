<?php

/**
 * Partial of the main settings page
 *
 * @link       http://teracomp.net
 * @since      1.0.0
 *
 * @package    Expo_Checkin_Manager
 * @subpackage Expo_Checkin_Manager/admin/partials
 */
?>

<div id="expo-main" class="wrap ecim-metaboxes">

	<h2><?php esc_attr_e( 'Main Features', $this->plugin_name ); ?></h2>

    <ol>
    	<li>Export list from Gravity Forms registration form to Check-In ready CSV file</li>
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
 </div>
 