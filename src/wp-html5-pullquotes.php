<?php
/*
Plugin Name: WP-HTML5-Pullquotes
Plugin URI: http://intangiblestyle.com/lab/intangible-pullquotes-wordpress-plugin/
Description: Create pullquotes in WordPress posts without duplicte content, using HTML5.
Version: 0.2
Author: Matthew K Babbs
Author URI: http://intangiblestyle.com/
License: GPL3
*/

/*  Copyright 2012  Matthew K Babbs  (email : matthew@intangiblestyle.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 3, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php
// Plugin admin code
$html5_pullquotes_admin = plugins_url('settings.php', __FILE__);
include 'settings.php';

// Register the action to create default options on plugin activation
register_activation_hook( __FILE__, 'html5_pullquotes_options_init' );

// Add data-pullquote attribute to TinyMCE
function istyle_data_pullquote_attributes($initArray) {
	$ext = 'p[data-pullquote],li[data-pullquote],ul[data-pullquote],ol[data-pullquote],div[data-pullquote],span[data-pullquote]';
	if (isset( $initArray['extended_valid_elements'])) {
		$initArray['extended_valid_elements'] .= ',' . $ext;
	} else {
		$initArray['extended_valid_elements'] = $ext;
	}
	return $initArray;
}
add_filter('tiny_mce_before_init', 'istyle_data_pullquote_attributes');

// Define function to pull it all together, and add it to the wp_enqueue_scripts hook
function html5_pullquotes() {
	// Collect options
	$html5_pullquotes_options = get_option('html5_pullquotes_plugin_options');

	// Register styles & script for theme
	wp_register_style( 'html5-pullquote-styles', plugins_url('pullquote-styles.php?css=theme.css', __FILE__) );
	wp_register_script('html5-pullquotes-legacy-compatibility', plugins_url('html5-pullquote-legacy-support.js', __FILE__), array('jquery'), false, true);

	// If injecting styles:
	// 1: add styles to display in TinyMCE editor
	// 2: enqueue style to display in theme
	if($html5_pullquotes_options['inject_pullquote_styles'] == true) {
		add_filter( 'mce_css', 'istyle_data_pullquote_mce_css' );
		wp_enqueue_style( 'html5-pullquote-styles' );
	}

	// If forcing legacy compatiblity, enqueue script
	if($html5_pullquotes_options['force_legacy_compatibility'] == true) {
		wp_enqueue_script('html5-pullquotes-legacy-compatibility');
	}
}
add_action( 'wp_enqueue_scripts', 'html5_pullquotes');


// Function to add styles to display in TinyMCE visual editor
function istyle_data_pullquote_mce_css($mce_css) {
	if (!empty($mce_css)) {
		$mce_css .= ',';
	}
	$mce_css .= plugins_url('pullquote-styles.php?css=editor.css', __FILE__);
	return $mce_css;
}

?>
