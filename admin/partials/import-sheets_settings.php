<?php

/**
 * Partial of the import-sheets settings page
 *
 * @link       http://teracomp.net
 * @since      1.0.0
 *
 * @package    Expo_Checkin_Manager
 * @subpackage Expo_Checkin_Manager/admin/partials
 */
?>

<div id="import-sheets" class="wrap ecim-metaboxes hidden">

	<h2><?php esc_attr_e( 'Import Sheets Page', $this->plugin_name ); ?></h2>

    <ol>
    	<li>Define mapping of CSV to Gravity Forms form</li>
        <li>List CSV fields from header row</li>
        <li>Show form fields in selected Gravity Forms form</li>
        <li>Show preview of data</li>
        <li>Import data</li>
    </ol>
 </div>