<?php

/**
 * Partial of the add-edit settings page
 *
 * @link       http://teracomp.net
 * @since      1.0.0
 *
 * @package    Expo_Checkin_Manager
 * @subpackage Expo_Checkin_Manager/admin/partials
 */
?>
<!-- <div id="add-edit-records" class="wrap ecim-metaboxes hidden"> -->
<div id="add-edit-records" class="wrap">
	<h2><?php esc_attr_e( 'Add/Edit Records', $this->plugin_name ); ?></h2>

    <ol>
        <li>Create process to add new registrants without the form. The GFAPI exposes this. Building the interface is the trick.</li>
        <li>Create process to list current registrants
            <ol>
                <li>Show group leaders with link to "show group"</li>
                <li>Create Edit link and process to edit individual records</li>
                <li>Create Delete link (with confirmation)</li>
            </ol>
        </li>
        <li>Create process to search for a registrant by name, email, phone, etc.</li>
    </ol>
 </div>