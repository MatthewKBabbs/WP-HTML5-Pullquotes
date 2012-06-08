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

// Add plugin to the Wordpress Admin menus
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
	add_settings_field('pullquote_font_size', 'Pullquote font-size', 'pullquote_font_size_callback', 'html5_pullquotes_plugin', 'plugin_styles');
	add_settings_field('show_horiz_borders', 'Show top and bottom borders', 'show_horiz_borders_callback', 'html5_pullquotes_plugin', 'plugin_styles');
	add_settings_field('show_vert_borders', 'Show left and right borders', 'show_vert_borders_callback', 'html5_pullquotes_plugin', 'plugin_styles');
	add_settings_field('border_style', 'Pullquote border-style', 'border_style_callback', 'html5_pullquotes_plugin', 'plugin_styles');
	add_settings_field('border_width', 'Pullquote border-width', 'border_width_callback', 'html5_pullquotes_plugin', 'plugin_styles');
	add_settings_field('border_color', 'Pullquote border-color', 'border_color_callback', 'html5_pullquotes_plugin', 'plugin_styles');
	add_settings_field('background_color', 'Pullquote background-color', 'background_color_callback', 'html5_pullquotes_plugin', 'plugin_styles');
	add_settings_field('force_legacy_compatibility', 'Enable compatibility with legacy browsers', 'force_legacy_compatibility_callback', 'html5_pullquotes_plugin', 'legacy_compatibility');
}

// Callback to provide descriptive text for plugin_styles section
function plugin_styles_section_callback() {
	echo '<p>Choose how pullquotes should be styled. Always keep style injection enabled unless your theme provides its own styles for HTML5 pullquotes.</p>';
}
// Callback to provide descriptive text for legacy_compatibility section
function legacy_compatibility_section_callback() {
	echo '<p>Enable pullquote display in legacy browsers IE6 and IE7. It&rsquo;s recommended to check your site logs before enabling this, as many sites have very few visits from such old browsers! This setting will add extra JavaScript files to your theme, so visitors may also see the site taking a few seconds longer to load.</p>';
}

// Callbacks to display input for settings fields
function inject_pullquote_styles_callback() {
					$options = get_option('html5_pullquotes_plugin_options');
					echo "<input name='html5_pullquotes_plugin_options[inject_pullquote_styles]' type='checkbox' value='1' ";
					echo (checked($options['inject_pullquote_styles'],true,false));
					echo " />";
}
function pullquote_font_size_callback() {
	$options = get_option('html5_pullquotes_plugin_options');
	echo "<input name='html5_pullquotes_plugin_options[pullquote_font_size]' size='25' type='text' value='";
	echo $options['pullquote_font_size'];
	echo "' />";
}
function show_horiz_borders_callback() {
	$options = get_option('html5_pullquotes_plugin_options');
	echo "<input name='html5_pullquotes_plugin_options[show_horiz_borders]' type='checkbox' value='1' ";
	echo (checked($options['show_horiz_borders'],true,false));
	echo " />";
}
function show_vert_borders_callback() {
	$options = get_option('html5_pullquotes_plugin_options');
	echo "<input name='html5_pullquotes_plugin_options[show_vert_borders]' type='checkbox' value='1' ";
	echo (checked($options['show_vert_borders'],true,false));
	echo " />";
}
function border_style_callback() {
	$options = get_option('html5_pullquotes_plugin_options');
	$possible_values = array('none', 'dotted', 'dashed', 'solid', 'double', 'groove', 'ridge', 'inset', 'outset');
	if (!isset($options['border_style'])) {
		$options['border_style'] = 'solid';
	}
	echo "<select name='html5_pullquotes_plugin_options[border_style]' >";
	foreach ($possible_values as $i) {
		echo "<option value=\"".$i."\"";
		if ($i == $options['border_style']) {
			echo " selected=\"selected\" ";
		}
		echo ">".$i."</option>";
	}
	echo "</select>";
}
function border_width_callback() {
	$options = get_option('html5_pullquotes_plugin_options');
	echo "<input name='html5_pullquotes_plugin_options[border_width]' size='25' type='text' value='";
	echo $options['border_width'];
	echo "' />";
}
function border_color_callback() {
	$options = get_option('html5_pullquotes_plugin_options');
	echo "<input name='html5_pullquotes_plugin_options[border_color]' size='25' type='text' value='";
	echo $options['border_color'];
	echo "' />";
}
function background_color_callback() {
	$options = get_option('html5_pullquotes_plugin_options');
	echo "<input name='html5_pullquotes_plugin_options[background_color]' size='25' type='text' value='";
	echo $options['background_color'];
	echo "' />";
}
function force_legacy_compatibility_callback() {
	$options = get_option('html5_pullquotes_plugin_options');
	echo "<input name='html5_pullquotes_plugin_options[force_legacy_compatibility]' type='checkbox' value='1' ";
	echo (checked($options['force_legacy_compatibility'],true,false));
	echo " />";
}

// Validate plugin options
function html5_pullquotes_plugin_options_validate($input) {
	// 0: validate inject_pullquote_styles setting
	if (isset($input['inject_pullquote_styles']) && ($input['inject_pullquote_styles'] == true)) {
		$valid_input['inject_pullquote_styles'] = true;
	}
	else $valid_input['inject_pullquote_styles'] = false;
	// 1: validate font-size setting
	$newinput['pullquote_font_size'] = trim($input['pullquote_font_size']);
	if (preg_match('/^[a-z0-9]{1,25}$/i', $newinput['pullquote_font_size'])) {
		$valid_input['pullquote_font_size'] = $newinput['pullquote_font_size'];
	}
	// 2: validate show_horiz_borders
	if (isset($input['show_horiz_borders']) && ($input['show_horiz_borders'] == true)) {
		$valid_input['show_horiz_borders'] = true;
	}
	else $valid_input['show_horiz_borders'] = false;
	// 3: validate show_vert_borders
	if (isset($input['show_vert_borders']) && ($input['show_vert_borders'] == true)) {
		$valid_input['show_vert_borders'] = true;
	}
	else $valid_input['show_vert_borders'] = false;
	// 4: validate border_style
	//$valid_border_styles = array('none', 'dotted', 'dashed', 'solid', 'double', 'groove', 'ridge', 'inset', 'outset');
	$newinput['border_style'] = trim($input['border_style']);
	if (preg_match('/^[a-z]{4,6}$/i', $newinput['border_style'])) {
		$valid_input['border_style'] = $newinput['border_style'];
	}
	// 5: validate border_width
	$newinput['border_width'] = trim($input['border_width']);
	if (preg_match('/^[a-z0-9]{0,25}$/i', $newinput['border_width'])) {
		$valid_input['border_width'] = $newinput['border_width'];
	}
	// 6: validate border_color
	$newinput['border_color'] = trim($input['border_color']);
	if (preg_match('/^[a-z]{0,25}$/i', $newinput['border_color'])) {
		$valid_input['border_color'] = $newinput['border_color'];
	}
	// 7: validate background_color
	$newinput['background_color'] = trim($input['background_color']);
	if (preg_match('/^[a-z]{0,25}$/i', $newinput['background_color'])) {
		$valid_input['background_color'] = $newinput['background_color'];
	}
	// 8: validate force_legacy_compatibility
	if (isset($input['force_legacy_compatibility']) && ($input['force_legacy_compatibility'] == true)) {
		$valid_input['force_legacy_compatibility'] = true;
	}
	else $valid_input['force_legacy_compatibility'] = false;
	// Last: return array with all valid inputs
	return $valid_input;
}
?>
