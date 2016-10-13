=== Plugin Name ===
Contributors: (this should be a list of wordpress.org userid's)
Donate link: https://exponential.org
Tags: comments, spam
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 1.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Wordpress Admin plugin panel to support Check-in App

== Description ==

### Main features:

1.  Export list from Gravity Forms registration form to Check-In ready CSV file
2.  Import lists from various external sources (CSV files)
    *   Append these records to the appropriate registration form
    *   Map columns from CSV to form fields
3.  Add/Edit Records
4.  Generate predefined reports
5.  Create custom reports
6.  Configure on-site conference page

== Installation ==

1. Upload `expo-checkin-manager.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('plugin_name_hook'); ?>` in your templates

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0.0 =
* Initial boilerplate

= 1.0.5 =
* Import and Export working well

= 1.1.0 =
* Added Update function
* Added animated "Loading" gif to prompt the user to wait