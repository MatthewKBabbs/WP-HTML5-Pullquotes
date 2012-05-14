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

add_action('admin_menu', 'html5_pullquotes_menu');

function html5_pullquotes_menu() {
	add_theme_page('HTML5 Pullquotes', 'HTML5 Pullquotes', 'manage_options', 'html5-pullquotes', 'html5_pullquotes_settings_page');
}
// html5_pullquotes_options_page() displays the content for the plugin's settings page
function html5_pullquotes_settings_page() {
	if (!current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
?>
<div class="wrap">
	<h2>HTML5 Pullquotes plugin</h2>
	<form action="options.php" method="post">
		<?php settings_fields('html5_pullquotes_plugin_options'); ?>
		<?php do_settings_sections('html5_pullquotes_plugin'); ?>
		<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
</div>
<?php
}

// add the admin settings and such
add_action('admin_init', 'html5_pullquotes_admin_init');
function html5_pullquotes_admin_init(){
	register_setting( 'html5_pullquotes_plugin_options', 'html5_pullquotes_plugin_options', 'html5_pullquotes_plugin_options_validate' );
	add_settings_section('plugin_styles', 'Pullquote Styles', 'plugin_styles_section_callback', 'html5_pullquotes_plugin');
	add_settings_section('legacy_compatibility', 'Legacy Compatibility', 'legacy_compatibility_section_callback', 'html5_pullquotes_plugin');
}

// Callback to provide descriptive text for plugin_styles section
function plugin_styles_section_callback() {
	echo '<p>Main description of this section here.</p>';
}
// Callback to provide descriptive text for legacy_compatibility section
function legacy_compatibility_section_callback() {
	echo '<p>Enable compatibility with legacy browsers IE6 and IE7. It&rsquo;s recommended to check your site logs before enabling this, as many sites have very few visits from such old browsers!</p>';
}

/* Options:
		* Inject pullquote styles into my theme
			* Font-family [Should this be implied?]
			* font-size [imply line-height based on font-size]
			* borders	[default margins & padding to sensible values]
			* background-colour
		* Force compatibility with old versions of Internet Explorer
*/
?>
