<?php

/**
 * Partial of the expo-settings page
 *
 * @link       http://teracomp.net
 * @since      1.0.0
 *
 * @package    Expo_Checkin_Manager
 * @subpackage Expo_Checkin_Manager/admin/partials
 */
?>

<!-- <div id="expo-settings" class="wrap ecim-metaboxes hidden"> -->
<div id="expo-settings" class="wrap">

	<h2><?php esc_attr_e( 'Exponential Checkin Manager Settings', $this->plugin_name ); ?></h2>

    <ol>
    	<li>Choose Active Forms
        	<ol>
            	<li>Show list of Gravity Forms installed (checkbox list)</li>
                <li>Choose which ones are managed by this tool (checked)</li>
                <li>If they're managed, show mapping configs (link to mapping)</li>
                <li>If no mapping configs, prompt to create a config (link to create new map)</li>
            </ol>
        </li>
        <li>Show Column to Field Mapping
        	<ol>
            	<li>Based on selected form</li>
                <li>Save New Settings Map</li>
                <li>Save As... form mapping</li>
                <li>Delete form mapping</li>
            </ol>
        </li>
    </ol>

<?php
 
	// get options
	$options = get_option($this->plugin_name);
	
	// get list of valid gravity forms
	$gfList = apply_filters( 'exm_get_gf_forms_list' );

?>
    <form method="post" name="expo_manager_options" action="<?php echo admin_url( 'admin-ajax.php' ) ?>">
		<?php 
			settings_fields($this->plugin_name); 
		?>
        
		<fieldset>
        	<h4>Select Form:</h4>
            <ul>
            <?php
                foreach( $gfList as $key=>$value ) {
            ?>            
                <li>
                    <label for="<?php echo $this->plugin_name; ?>-import-to-form-<?php echo $key?>">
                        <input class="gflist" type="radio" <?php checked( $options['import_to_form'], $key ); ?>
                        	id="<?php echo $this->plugin_name; ?>-import-to-form-<?php echo $key?>" 
                        	name="<?php echo $this->plugin_name; ?>[import_to_form]" value="<?php echo $key ?>">
                        &nbsp;<?php echo $value; ?>
                    </label>
                </li>
            <?php
                }
            ?>
            </ul>        
        </fieldset>
	</form>


</div> <!-- .wrap -->
