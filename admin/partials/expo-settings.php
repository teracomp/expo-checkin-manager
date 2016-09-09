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
 </div>

 <?php
$form_id = 16;
$group_or_individual = 'Group Registrations';		// 114  radio button on the form
$group_total = 10;  // 119
$group_name = 'The Phillips Group';  // 152
$regtype = 'Registrant';		// 199
$source = 'Google Sheet';	// 201
$payment_status = 'Paid';
$payment_method = 'Offline';

$newEntry = array(
    'form_id' => $form_id,
    'payment_status' => $payment_status,
    'payment_method' => $payment_method,
	'152' => $group_name,
	'199' => $regtype,
	'201' => $source,
	'119' => $group_total,
	'114' => $group_or_individual,
    '20' => 'Dave',
    '22' => 'Phillips',
    '26' => '1301 Leeward Rd',
    '27' => 'Anderson',
    '36' => 'South Carolina',
    '28' => '29625',
    '6' => 'davep@newlife4me.org',
    '7' => '(111) 222-3333',
    '11' => 'From Addition to Multiplication',
    '41' => 'Curtis',
    '42' => 'Hunnicutt',
    '43' => 'chunnicutt74@gmail.com',
    '46' => 'Church Planting',
    '48' => 'Rick',
    '49' => 'Schaffner',
    '50' => 'rick@inewlife.org',
    '51' => 'Church Planting',
    '53' => 'Chad',
    '54' => 'Wiggins',
    '55' => 'chad@inewlife.org',
    '56' => 'Church Planting',
    '57' => 'Josh',
    '58' => 'Hilson',
    '59' => 'josh@inewlife.org',
    '60' => 'Church Planting',
    '63' => 'Tyler',
    '64' => 'Gagnon',
    '65' => 'tylergagnon654@gmail.com',
    '66' => 'None',
    '68' => 'Jordan',
    '69' => 'Ryskamp',
    '70' => 'jordan@inewlife.org',
    '71' => 'None',
    '73' => 'Willie',
    '74' => 'Titus',
    '75' => 'willie.titus@yahoo.com',
    '76' => 'Church Planting',
    '78' => 'Roberto',
    '79' => 'Hinds',
    '80' => 'Hindsight8@me.com',
    '81' => 'Church Planting',
    '83' => 'Hanna',
    '84' => 'Oberlin',
    '85' => 'hannah@wejourney.church',
    '86' => 'None',
);
echo '<pre>';
print_r( $newEntry );
echo '</pre>';

$lid = GFAPI::add_entry( $newEntry );
echo '<h4>Added entry: '.$lid.'</h4>';

$link = get_site_url().'/wp-admin/admin.php?page=gf_entries&view=entry&id='.$form_id.'&lid='.$lid;
echo '<p>Link: '.$link.'</p>';
echo '<p>Click here to see the entry: <a href="'.$link.'">Link to Entry</a>';

$entry = GFAPI::get_entry( $lid );
echo '<pre>';
print_r( $entry );
echo '</pre>';




?>
