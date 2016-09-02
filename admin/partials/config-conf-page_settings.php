<?php

/**
 * Partial of the config-conf-page settings page
 *
 * @link       http://teracomp.net
 * @since      1.0.0
 *
 * @package    Expo_Checkin_Manager
 * @subpackage Expo_Checkin_Manager/admin/partials
 */
?>

<!-- <div id="config-conf-page" class="wrap ecim-metaboxes hidden"> -->
<div id="config-conf-page" class="wrap">

	<h2><?php esc_attr_e( 'Conference Checkin Configuration Manager', $this->plugin_name ); ?></h2>

    <ol>
        <li>Create a new conference page</li>
        <li>Edit/update conference page fields:
            <ol>
                <li>Title</li>
                <li>Location</li>
                <li>Dates</li>
                <li>Details</li>
                <li>Main image</li>
                <li>List of preconferences available</li>
            </ol>
        </li>
        <li>Create link for Check-In App to use
            <ol>
                <li>Generate id (or slug) for Check-In App</li>
                <li>Modify Check-In app to parse parameters</li>
            </ol>
        </li>
        <li>Probably other things here that I haven't considered</li>
    </ol>
 </div>