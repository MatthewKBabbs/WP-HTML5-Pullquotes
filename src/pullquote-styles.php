<?php
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
/*
Pullquote Style Generator
This file outputs CSS!
*/

// Tell the browser what we're sending
header('content-type: text/css');

// Fetch settings data
$pullquote_style_settings = get_option('html5_pullquotes_plugin_options');

// Choose rules based on GET param (theme | editor | default-empty)
switch ($_GET['css']) {
	case 'theme' :
		// CSS rules for theme
		$css_rules = '[data-pullquote]:before {\n'.
			'	/* Reset metrics. */\n'.
			'	padding: 0;\n'.
			'	border: none;\n'.
			'\n'.
			'	/* Content */\n'.
			'	content: attr(data-pullquote);\n'.
			'\n'.
			'	/* Pull out to the right, modular scale based margins. */\n'.
			'	float: right;\n'.
			'	width: 320px;\n'.
			'	margin: 12px -140px 24px 36px;\n'.
			'\n'.
			'	/* Baseline correction */\n'.
			'	position: relative;\n'.
			'	top: 5px;\n'.
			'\n'.
			'	/* Typography (30px line-height equals 25% incremental leading) */\n'.
			'	font-size: 23px;\n'.
			'	line-height: 30px;\n'.
			'}\n';

	case 'editor' :
		// CSS rules for TinyMCE editor
		$css_rules= '';
	
	default :
		// 404? Blank file?
		$css_rules = '';
}

// Output CSS rules so they'll be sent to browser
echo $css_rules;
?>
