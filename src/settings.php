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
		<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" class="button-primary" />
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

	add_settings_field('inject_pullquote_styles', 'Inject pullquote styles into my theme', 'inject_pullquote_styles_callback', 'html5_pullquotes_plugin', 'plugin_styles');
	add_settings_field('pullquote_font_size','Pullquote font-size','pullquote_font_size_callback','html5_pullquotes_plugin','plugin_styles');
}

// Callback to provide descriptive text for plugin_styles section
function plugin_styles_section_callback() {
	echo '<p>Main description of this section here.</p>';
}
// Callback to provide descriptive text for legacy_compatibility section
function legacy_compatibility_section_callback() {
	echo '<p>Enable compatibility with legacy browsers IE6 and IE7. It&rsquo;s recommended to check your site logs before enabling this, as many sites have very few visits from such old browsers!</p>';
}

// Callback to display input for inject_pullquote_styles settings field
function inject_pullquote_styles_callback() {
					$options = get_option('html5_pullquotes_plugin_options');
					echo "<input name='html5_pullquotes_plugin_options[inject_pullquote_styles]' type='checkbox' value='1' ";
					echo (checked($options['inject_pullquote_styles'],true,false));
					echo " />";
					if (!isset($options['inject_pullquote_styles'])) {
						echo "Option not found!";
					} else {
						echo 'Option found; value is: \''.$options['inject_pullquote_styles'].'\'.';
					}
}
// Callback to display input for plugin_font_size settings field
function pullquote_font_size_callback() {
	$options = get_option('html5_pullquotes_plugin_options');
	echo "<input name='html5_pullquotes_plugin_options[pullquote_font_size]' size='25' type='text' value='";
	echo $options['pullquote_font_size'];
	echo "' />";
}

// Validate plugin options
function html5_pullquotes_plugin_options_validate($input) {
	// 1: validate font-size setting
	$newinput['pullquote_font_size'] = trim($input['pullquote_font_size']);
	if (preg_match('/^[a-z0-9]{1,25}$/i', $newinput['pullquote_font_size'])) {
		$valid_input['pullquote_font_size'] = $newinput['pullquote_font_size'];
	}
	// 2: validate checkbox setting
	if (isset($input['inject_pullquote_styles']) && ($input['inject_pullquote_styles'] == true)) {
		$valid_input['inject_pullquote_styles'] = true;
	}
	// Last: return array with all valid inputs
	return $valid_input;
}
/* Options:
		* Inject pullquote styles into my theme
			* Font-family [Should this be implied?]
			* font-size [imply line-height based on font-size]
			* borders	[default margins & padding to sensible values]
			* background-colour
		* Force compatibility with old versions of Internet Explorer
		
	Process:
		* on_activate -> set defaults
			register_activation_hook( __FILE__, 'myplugin_activate' );
		* when saving -> set new values
		* on deactivate -> delete values?
*/
?>
