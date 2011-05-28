=== Geotagmapper ===
Contributors: 1manfactory
Donate link: http://1manfactory.com/donate 
Tags: geo, map, karte, blogmap, geotagmapper, blogkarte, google maps, maps, coordinates, google map, google, mashup, mapping, geocms, geographic, georss, location, geocoding
Requires at least: 2.5
Tested up to: 3.1.3
Stable tag: 1.5.1

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

= 1.5.1 (28.05.2011) =
* Test wird Wordpress 3.1.3 -> ok
* Bugfix: "Fatal error: Cannot redeclare my_plugin_options()"

= 1.5 (25.02.2011) =
* test with Wordpress 3.1 -> ok
* translations

= 1.4 (03.07.2010) =
* now multilanguage
* added German

= 1.3 (18.06.2010) =
* tested with Wordpress 3.0 ok
* Switched from XML to JSON data import

= 1.2 (16.06.2010) =

* ability to insert geodata in frontpage, pages or posts only
* creating function to place data manually into templates

== Frequently Asked Questions ==

= How can I manually place the Geodata in headers? =

Use the function "geotagmapper_meta_print". E.g. place this code inside your template file(s)
`<?php if (function_exists('geotagmapper_meta_print')) geotagmapper_meta_print(); ?>`

= What is the plugin page?  =

[Geotagmapper](http://1manfactory.com/gtm "Geotagmapper")

= Do you have other plugins?  =

Check out my other [Wordpress Plugins](http://wordpress.org/extend/plugins/profile/1manfactory)

= Where do I post my feedback? =

Post it at the plugin page: [Geotagmapper](http://1manfactory.com/gtm "Geotagmapper")

= How can I support you? =

That is nice of you. Donation link: http://1manfactory.com/donate

== Screenshots ==

1. Step 1
2. Step 2
3. Step 3
4. Step 4

== Upgrade Notice ==

Just do a normal upgrade.

== To do ==

More translations. Does someone wants to help?