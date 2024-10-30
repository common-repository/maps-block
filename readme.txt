=== Maps Block ===
Contributors: wedoplugins
Tags: maps, map block, google maps, google maps block, block, gutenberg, block editor, block library, blocks,
Requires at least: 5.1
Tested up to: 5.4
Requires PHP: 5.6
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Stable tag: 1.2.6

Maps Block for new WordPress Block Editor allow you to add Google Maps to your website and customize it.

== Description ==

Maps Block for new WordPress Block Editor allow you to add Google Maps to your website and customize it.

You can add as many maps as you want, and each map can be configured separately.

**Features**

* specify latitude and longitude coordinates and zoom for map,
* add as many markers as you need,
* use custom map styles, generated with [https://mapstyle.withgoogle.com/](https://mapstyle.withgoogle.com/) or [https://snazzymaps.com/](https://snazzymaps.com/),
* customize map height and alignment,
* ready to use out of the box - just put your Google maps API key in options page and create your map,
* create unlimited number of maps and customize each of it separately,

To use maps on your website, you'll need an API key which can be generated here:
[https://developers.google.com/maps/documentation/javascript/get-api-key](https://developers.google.com/maps/documentation/javascript/get-api-key)

== Installation ==

1. Install the plugin through the WordPress plugins screen directly or upload the plugin files to the "/wp-content/plugins/maps-block" directory.
2. Activate the plugin through the "Plugins" screen in WordPress
3. Go to Block Editor and type /maps to use this block.

== Changelog ==

= 1.2.6 =
* compatibility with WP 5.4 confirmed
* custom block collection registered

= 1.2.5 =
* REST API fetch path fixed
* JS fetch function now used through @wordpress/api-fetch package

= 1.2.4 =
* Blocks Summary page updated

= 1.2.3 =
* Blocks Summary page updated

= 1.2.2 =
* fixed SSL issue

= 1.2.1 =
* Removed unused localize script function,

= 1.2.0 =
* JavaScript code fully rebuilt on React, no more jQuery,
* Blocks Summary page style & script improved,
* AJAX replaced with custom REST endpoint,
* license changed from GPL2+ to GPLv3,
* block code improved

= 1.1.1 =
* Dependencies bug fixed

= 1.1.0 =
* Map style JSON field and rendering improved.

= 1.0.0 =
* Initial release.

== Screenshots ==

1. Set custom coordinates for map and each of markers separately
2. Customize your map styles
3. Add your API key easily through plugin options page