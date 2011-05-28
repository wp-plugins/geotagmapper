<?php
/*
Plugin Name: Geotagmapper
Plugin URI: http://1manfactory.com/gtm
Description: Geotagmapper adds geographical identification metadata (latitude and longitude) to the HTML header. You only have to specify an address.
Version: 1.5
Author: Juergen Schulze, 1manfactory@gmail.com
Author URI: http://1manfactory.com
License: GPL2
*/

/*  Copyright 2011  Juergen Schulze  (email : 1manfactory@gmail.com)

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

DEFINE("GTMDEBUG", "false");	# don't delete the quote signs!!

function my_plugin_admin_menu(){
	$page=add_submenu_page("options-general.php", __('Geotagmapper Settings', 'geotagmapper'), "Geotagmapper", 9, basename(__FILE__), 'my_plugin_options');
	add_action('admin_print_scripts-' . $page, 'my_plugin_admin_styles');
}

function my_plugin_admin_styles() {
	wp_enqueue_script('myPluginScript');
}

function geotagmapper_ping(){
  $curl_handle=@curl_init();
  @curl_setopt($curl_handle,CURLOPT_URL,'http://geourl.org/ping/?p=' . get_option('home'));
  @curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
  @curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
  $buffer = @curl_exec($curl_handle);
  @curl_close($curl_handle);
  return $buffer;
}

function my_plugin_options(){

	if ($_GET['updated'] == true) {
	  $buffer = geotagmapper_ping();
		if (empty($buffer)){
			print '<div class="error"><p><b>Click to inform <a href="http://geourl.org/ping/?p='.get_bloginfo('url').'" target="_blank">geourl.org</a></b> to update.</p></div>';
		} else {
			print '<div class="updated"><p>'.__('Check your', 'geotagmapper').'&nbsp;<a href="http://geourl.org/near?p='.get_bloginfo('url').'" target="_blank">'.__('neighbours', 'geotagmapper').'</a>&nbsp;'.__('or your', 'geotagmapper').'&nbsp;<a href="http://geourl.org/ping/?p='.get_bloginfo('url').'" target="_blank">'.__('status', 'geotagmapper').'</a>.</p></div>';
		}
	}
	print '<div class="wrap">
	<h2>'.__('Geotagmapper Settings', 'geotagmapper').'</h2>
	<form method="post" action="options.php" id="my_plugin_form">';
	wp_nonce_field('update-options');
	print '<input type="hidden" name="action" value="update" />
	<input type="hidden" name="geotagmapper_output_type" value="json" />
	<input type="hidden" name="page_options" value="geotagmapper_place_on_search,geotagmapper_place_on_tag,geotagmapper_place_on_category,geotagmapper_place_on_single_page,geotagmapper_place_on_single_post,geotagmapper_place_on_front,geotagmapper_street,geotagmapper_lat,geotagmapper_lng,geotagmapper_zip,geotagmapper_country,geotagmapper_state,geotagmapper_city,geotagmapper_country_code,geotagmapper_subcountry_code,geotagmapper_track" />
	<table class="form-table">
	<tr>
		<th scope="row" valign="top">'.__('Fill in as many information as possible', 'geotagmapper').'.</th>
		<td colspan="2">
			<label for="geotagmapper_country">'.__('Country', 'geotagmapper').':</label><br />
			<input size="50" type="text" id="geotagmapper_country" name="geotagmapper_country" value="'.get_option('geotagmapper_country').'" /><br />

			<label for="geotagmapper_state">'.__('State', 'geotagmapper').':</label><br />
			<input size="50" type="text" id="geotagmapper_state" name="geotagmapper_state" value="'.get_option('geotagmapper_state').'" /><br />

			<label for="geotagmapper_city">'.__('City', 'geotagmapper').':</label><br />
			<input size="50" type="text" id="geotagmapper_city" name="geotagmapper_city" value="'.get_option('geotagmapper_city').'" /><br />

			<label for="geotagmapper_street">'.__('Street', 'geotagmapper').':</label><br />
			<input size="50" type="text" id="geotagmapper_street" name="geotagmapper_street" value="'.get_option('geotagmapper_street').'" /><br />

			<label for="geotagmapper_zip">'.__('Zip Code', 'geotagmapper').':</label><br />
			<input size="50" type="text" id="geotagmapper_zip" name="geotagmapper_zip" value="'.get_option('geotagmapper_zip').'" /><br />

			<br />

			<label for="geotagmapper_lat"><a href="#" onclick="geotagmapperDetect(\''. WP_PLUGIN_URL .'/geotagmapper/proxy.php\', gtmdebug='.GTMDEBUG.');return false;">'.__('Get data', 'geotagmapper').'</a>&nbsp;'.__('from Google maps.', 'geotagmapper').'</label><br />

			<br />

			'.__('Latitude', 'geotagmapper').': <input size="20" type="text" id="geotagmapper_lat" name="geotagmapper_lat" value="'.get_option('geotagmapper_lat').'" />&nbsp;'.__('Longitude', 'geotagmapper').': <input size="20" type="text" id="geotagmapper_lng" name="geotagmapper_lng" value="'.get_option('geotagmapper_lng').'" /><br />
			<br />
			<label for="geotagmapper_country_code">'.__('ISO 3166-1/2 Codes for the representation of names of countries and their subdivisions', 'geotagmapper').'</label><br />
			<input size="2" maxlength="2" type="text" id="geotagmapper_country_code" name="geotagmapper_country_code" value="'.get_option('geotagmapper_country_code').'" />-<input size="2" maxlength="2" type="text" id="geotagmapper_subcountry_code" name="geotagmapper_subcountry_code" value="'.get_option('geotagmapper_subcountry_code').'" />&nbsp;<a href="http://www.unece.org/cefact/locode/service/sublocat.htm" target="_blank">'.__('Pick up', 'geotagmapper').'</a>&nbsp;'.__('the value for the second field', 'geotagmapper').'.<br />

			<br />	
			<label for="geotagmapper_zip">'.__('Insert Geodata into header of', 'geotagmapper').'</label><br />
			<input type="checkbox" id="geotagmapper_place_on_front" name="geotagmapper_place_on_front" '.my_plugin_optionselected(get_option('geotagmapper_place_on_front')).' />&nbsp;'.__('Front page', 'geotagmapper').'&nbsp;&nbsp;
			<input type="checkbox" id="geotagmapper_place_on_single_post" name="geotagmapper_place_on_single_post" '.my_plugin_optionselected(get_option('geotagmapper_place_on_single_post')).' />&nbsp;'.__('Single post', 'geotagmapper').'&nbsp;&nbsp;
			<input type="checkbox" id="geotagmapper_place_on_single_page" name="geotagmapper_place_on_single_page" '.my_plugin_optionselected(get_option('geotagmapper_place_on_single_page')).' />&nbsp;'.__('Single page', 'geotagmapper').'&nbsp;&nbsp;
			<input type="checkbox" id="geotagmapper_place_on_category" name="geotagmapper_place_on_category" '.my_plugin_optionselected(get_option('geotagmapper_place_on_category')).' />&nbsp;'.__('Category archive', 'geotagmapper').'&nbsp;&nbsp;
			<input type="checkbox" id="geotagmapper_place_on_tag" name="geotagmapper_place_on_tag" '.my_plugin_optionselected(get_option('geotagmapper_place_on_tag')).' />&nbsp;'.__('Tag Archive', 'geotagmapper').'&nbsp;&nbsp;
			<input type="checkbox" id="geotagmapper_place_on_search" name="geotagmapper_place_on_search" '.my_plugin_optionselected(get_option('geotagmapper_place_on_search')).' />&nbsp;'.__('Search results', 'geotagmapper').'

			<br /><br />
			'.__('Or use the code', 'geotagmapper').':
			<pre>
			&lt;?php
			if (function_exists(\'geotagmapper_meta_print\')) geotagmapper_meta_print();
			?&gt;
			</pre>
			'.__('to place the Geodata anywhere in the header', 'geotagmapper').'.
		</td>
	</tr>
	</table>
	<p class="submit"><input type="submit" name="submit" value="'.__('Save Changes', 'geotagmapper').'" /></p>
	</form>

<div class="postbox-container" style="width:100%;">

	<div class="metabox-holder">
		<div class="meta-box-sortables">
			<div class="postbox">
				<div class="handlediv"><br /></div>
					<h3 class="hndle">'.__('Infobox ', 'OldPostSpinner').'</h3>
					<div class="inside" style="padding:10px; padding-top:0;">';
					require_once('whatsup.php');
					print'
				</div>
			</div>
		</div>
	</div>
	
</div>
	
	</div>
	';
}

function geotagmapper_meta(){
	if (get_option('geotagmapper_place_on_front') && is_front_page()) $printmeta=true;
	if (get_option('geotagmapper_place_on_single_post') && is_single()) $printmeta=true;
	if (get_option('geotagmapper_place_on_single_page') && is_page()) $printmeta=true;
	if (get_option('geotagmapper_place_on_category') && is_category()) $printmeta=true;
	if (get_option('geotagmapper_place_on_tag') && is_tag()) $printmeta=true;
	if (get_option('geotagmapper_place_on_search') && is_search()) $printmeta=true;
	if ($printmeta) geotagmapper_meta_print();
}

function geotagmapper_meta_print() {
	print '
	<!-- inserted by geotagmapper (Juergen Schulze, 1manfactory.com) start -->
	<meta name="city" content="'.get_option('geotagmapper_city').'" />
	<meta name="country" content="'.get_option('geotagmapper_country').'" />
	<meta name="state" content="'.get_option('geotagmapper_state').'" />
	<meta name="zipcode" content="'.get_option('geotagmapper_zip').'" />
	<meta name="geo.position" content="'.get_option('geotagmapper_lat').';'.get_option('geotagmapper_lng').'" />
	<meta name="geo.placename" content="'.get_option('geotagmapper_city').'" />
	<meta name="geo.region" content="'.get_option('geotagmapper_country_code').'-'.get_option('geotagmapper_subcountry_code').'" />
	<meta name="ICBM" content="'.get_option('geotagmapper_lat').';'.get_option('geotagmapper_lng').'" />
	<!-- inserted by geotagmapper end -->
	';
}

function my_plugin_admin_init() {
	wp_register_script('myPluginScript', WP_PLUGIN_URL . '/geotagmapper/geotagmapper.js');
	wp_register_script('myPluginScript', WP_PLUGIN_URL . '/geotagmapper/json2.js');
}

function my_plugin_optionselected($checkValue) {
	if($checkValue) {
		return 'checked';
	}
	return '';
}

function geotagmapper_uninstall() {
	# delete all data stored
	delete_option('geotagmapper_place_on_front');
	delete_option('geotagmapper_place_on_single_post');
	delete_option('geotagmapper_place_on_single_page');
	delete_option('geotagmapper_place_on_category');
	delete_option('geotagmapper_place_on_tag');
	delete_option('geotagmapper_place_on_search');
	delete_option('geotagmapper_country');
	delete_option('geotagmapper_state');
	delete_option('geotagmapper_zip');
	delete_option('geotagmapper_lat');
	delete_option('geotagmapper_lng');
	delete_option('geotagmapper_city');
	delete_option('geotagmapper_country_code');
	delete_option('geotagmapper_subcountry_code');
}

function geotagmapper_debug() {
	# only run debug on localhost
	if ($_SERVER["HTTP_HOST"]=="localhost" && defined("GTMDEBUG") && GTMDEBUG==true) return true;
}

function geotagmapper_set_lang_file() {
	# set the language file
	$currentLocale = get_locale();
	if(!empty($currentLocale)) {
		$moFile = dirname(__FILE__) . "/lang/" . $currentLocale . ".mo";
		if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('geotagmapper', $moFile);
	}
}

geotagmapper_set_lang_file();
add_action('admin_init', 'my_plugin_admin_init');
add_action('admin_menu', 'my_plugin_admin_menu');
add_action('publish_post', 'geotagmapper_ping');
add_action('admin_menu', 'my_plugin_admin_menu');
add_action('wp_head', 'geotagmapper_meta');
register_uninstall_hook(__FILE__, 'geotagmapper_uninstall');

?>