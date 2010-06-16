=== Geotagmapper ===
Contributors: Juergen Schulze  (1manfactory.com)
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ESLEBR77J67A2
Tags: geo, map, karte, blogmap, geotagmapper, blogkarte, google maps, maps, coordinates, google map, google, mashup, mapping, geocms, geographic, georss, location, geocoding
Requires at least: 2.5
Tested up to: 2.9.2
Stable tag: "trunk"

Description: Geotagmapper adds geographical identification metadata (latitude and longitude) to the HTML header. You only have to specify an address.

== Description ==

Geotagmapper adds geographical identification metadata (latitude and longitude) to the HTML header.You only have to specify your address.

Check out my other [Wordpress Plugins](http://wordpress.org/extend/plugins/profile/1manfactory)

== Installation ==

1. Copy complete folder to '/wp-content/plugins/' or upload from wordpress.org
2. Activate in Plugins menu
3. Enter your address in Settings/Geotagmapper
4. Retrieve coordinates from Google by pressing "get" link.
5. Save changes
6. Check inside <HTML><HEAD></HEAD></HTML> of your webpage

== Remove plugin ==

1. Deactivate plugin through the 'Plugins' menu in WordPress
2. Delete plugin through the 'Plugins' menu in WordPress

It's best to use the build in delete function of wordpress. That way all the stored data will be removed and no orphaned data will stay.

== Changelog ==

= 1.2 (16.06.2010) =
* ability to insert geodata in frontpage, pages or posts only
* creating function to place data manually into templates

== Frequently Asked Questions ==

= How can I manually place the Geodata in headers? =

Use the function "geotagmapper_meta_print". E.g. place this code inside your template file(s)
`<?php if (function_exists('geotagmapper_meta_print')) geotagmapper_meta_print(); ?>`

= What is the plugin page?  =

[Geotagmapper](http://1manfactory.com/wordpress-plugin-geotagmapper-customize-geo-information-inside-header-automatically/ "Geotagmapper")

= Do you have other plugins?  =

Check out my other [Wordpress Plugins](http://wordpress.org/extend/plugins/profile/1manfactory)

= Where do I post my feedback? =

Post it at the plugin page: [Geotagmapper](http://1manfactory.com/wordpress-plugin-geotagmapper-customize-geo-information-inside-header-automatically/ "Geotagmapper")

= How can I support you? =

That is nice of you. Donation link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ESLEBR77J67A2

== Screenshots ==

1. Step 1
2. Step 2
3. Step 3
4. Step 4

== Upgrade Notice ==

Just do a normal upgrade.

== To do ==

More translations. Does someone wants to help?