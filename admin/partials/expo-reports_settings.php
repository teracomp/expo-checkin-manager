<?php

/**
 * Partial of the expo-reports settings page
 *
 * @link       http://teracomp.net
 * @since      1.0.0
 *
 * @package    Expo_Checkin_Manager
 * @subpackage Expo_Checkin_Manager/admin/partials
 */
?>

<!-- <div id="expo-reports" class="wrap ecim-metaboxes hidden"> -->
<div id="expo-reports" class="wrap">

	<h2><?php esc_attr_e( 'Reports', $this->plugin_name ); ?></h2>

    <ol>
    	<li>Create list of predefined reports
        	<ul>
            	<li>Link to run report for display</li>
            </ul>
        </li>
        <li>Create Interface for Custom Reports
        	<ol>
            	<li>Create process to save custom reports</li>
                <li>Create process to update custom reports</li>
                <li>Create process to delete custom reports</li>
            </ol>
        </li>
    </ol>
 </div>
