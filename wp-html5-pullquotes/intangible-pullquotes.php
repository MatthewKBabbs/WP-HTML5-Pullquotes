<?php
/*
Plugin Name: Intangible-Pullquotes
Plugin URI: http://intangiblestyle.com/lab/intangible-pullquotes-wordpress-plugin/
Description: Create pullquotes in WordPress posts without duplicte content, using HTML5.
Version: 0.1
Author: Matthew K Babbs
Author URI: http://intangiblestyle.com/
License: GPLv2
*/
?>

<?php
/*  Copyright 2012  Matthew K Babbs  (email : matthew@intangiblestyle.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
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
// Plugin itself
// Add data-pullquote attribute to TinyMCE
function istyle_data-pullquote_attributes($initArray) {
	// Comma separated string of additional tags
	// Command separated string of attributes for additional tags
	$ext = 'p[data-pullquote],li[data-pullquote],div[data-pullquote],span[data-pullquote]';
	if ( isset( $initArray['extended_valid_elements'] ) ) {
		$initArray['extended_valid_elements'] .= ',' . $ext;
	} else {
		$initArray['extended_valid_elements'] = $ext;
	}
	return $initArray;
}
add_filter('tiny_mce_before_init', 'istyle_data-pullquote_attributes');

// add styles to TinyMCE: http://codex.wordpress.org/Plugin_API/Filter_Reference/mce_css
/*
function plugin_mce_css( $mce_css ) {
	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= plugins_url( 'editor.css', __FILE__ );

	return $mce_css;
}
add_filter( 'mce_css', 'plugin_mce_css' );
*/

// wp_enqueue_style to add css file with default styling for pullquotes
?>