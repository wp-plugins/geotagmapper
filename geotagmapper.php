<?php
/*
Plugin Name: Geotagmapper
Plugin URI: http://wordpress.org/extend/plugins/geotagmapper/
Description: Geotagmapper adds geographical identification metadata (latitude and longitude) to the HTML header.You only have to specify your address.
Version: 1.1
Author: J&uuml;rgen Schulze
Author URI: http://1manfactory.com
*/

DEFINE("DEBUG", "false");	# set "true" or "false", quotation marks needed

function my_plugin_admin_menu(){
	$page=add_submenu_page("options-general.php", "Geotagmapper Settings", "Geotagmapper", 9, basename(__FILE__), 'my_plugin_options');
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
			print '<div class="updated"><p>Check your <a href="http://geourl.org/near?p='.get_bloginfo('url').'" target="_blank">neighbours</a> or your <a href="http://geourl.org/ping/?p='.get_bloginfo('url').'" target="_blank">status</a>.</p></div>';
		}
	}
	print '<div class="wrap">
	<h2>Geotagmapper Settings</h2>
	<form method="post" action="options.php" id="my_plugin_form">';
	wp_nonce_field('update-options');
	print '<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="geotagmapper_street,geotagmapper_lat,geotagmapper_lng,geotagmapper_zip,geotagmapper_country,geotagmapper_state,geotagmapper_city,geotagmapper_country_code,geotagmapper_subcountry_code,geotagmapper_track" />
	<table class="form-table">
	<tr>
		<th scope="row" valign="top">Fill in as many information as possible.</th>
		<td colspan="2">
			<label for="geotagmapper_country">Country:</label><br />
			<input size="50" type="text" id="geotagmapper_country" name="geotagmapper_country" value="'.get_option('geotagmapper_country').'" /><br />

			<label for="geotagmapper_state">State:</label><br />
			<input size="50" type="text" id="geotagmapper_state" name="geotagmapper_state" value="'.get_option('geotagmapper_state').'" /><br />

			<label for="geotagmapper_city">City:</label><br />
			<input size="50" type="text" id="geotagmapper_city" name="geotagmapper_city" value="'.get_option('geotagmapper_city').'" /><br />

			<label for="geotagmapper_street">Street:</label><br />
			<input size="50" type="text" id="geotagmapper_street" name="geotagmapper_street" value="'.get_option('geotagmapper_street').'" /><br />

			<label for="geotagmapper_zip">Zip code:</label><br />
			<input size="50" type="text" id="geotagmapper_zip" name="geotagmapper_zip" value="'.get_option('geotagmapper_zip').'" /><br />

			<br />

			<label for="geotagmapper_lat"><a href="#" onclick="geotagmapperDetect(\''. WP_PLUGIN_URL .'/geotagmapper/proxy.php\', debug='.DEBUG.');return false;">Get data</a> from Google maps.</label><br />

			<br />

			Latitude: <input size="20" type="text" id="geotagmapper_lat" name="geotagmapper_lat" value="'.get_option('geotagmapper_lat').'" /> Longitude: <input size="20" type="text" id="geotagmapper_lng" name="geotagmapper_lng" value="'.get_option('geotagmapper_lng').'" /><br />
			<br />
			<label for="geotagmapper_country_code">ISO 3166-1/2 Codes for the representation of names of countries and their subdivisions</label><br />
			<input size="2" maxlength="2" type="text" id="geotagmapper_country_code" name="geotagmapper_country_code" value="'.get_option('geotagmapper_country_code').'" />-<input size="2" maxlength="2" type="text" id="geotagmapper_subcountry_code" name="geotagmapper_subcountry_code" value="'.get_option('geotagmapper_subcountry_code').'" /><a href="http://www.unece.org/cefact/locode/service/sublocat.htm" target="_blank">Pick up</a> the value for the second field.<br />

		</td>
	</tr>
	</table>
	<p class="submit"><input type="submit" name="submit" value="';
	_e('Save Changes');
	print '" /></p>
	</form>
	</div>
	';
}

function geotagmapper_meta(){
	print '
	<!-- inserted by geotagmapper start -->
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
}

add_action('admin_init', 'my_plugin_admin_init');
add_action('admin_menu', 'my_plugin_admin_menu');
add_action('publish_post', 'geotagmapper_ping');
add_action('admin_menu', 'my_plugin_admin_menu');
add_action('wp_head', 'geotagmapper_meta');
?>