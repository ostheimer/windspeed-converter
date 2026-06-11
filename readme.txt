=== Windspeed Converter ===
Contributors: helpstring
Tags: windspeed, converter, beaufort, knots, weather
Requires at least: 5.0
Tested up to: 6.9
Stable tag: 1.4.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

The Windspeed Converter gives you the possibility to insert a converter via widget or shortcode into your site.

== Description ==

The user has to write one of five values and the plugin calculates the others. Supported units: km/h, mph, Beaufort, m/s, and knots.

#### Shortcode
* You can add the Windspeed Converter via shortcode `[windspeed_converter]`
* If you want to hide the backlink use the shortcode `[windspeed_converter link="false"]`
* You can selectively disable fields, e.g. `[windspeed_converter beaufort="false"]`

#### Widget
* Just insert the widget in the chosen sidebar, type a title and activate the wanted options

#### Languages
The plugin ships with translations for all 24 official languages of the European Union: Bulgarian, Croatian, Czech, Danish, Dutch, English, Estonian, Finnish, French, German, Greek, Hungarian, Irish, Italian, Latvian, Lithuanian, Maltese, Polish, Portuguese, Romanian, Slovak, Slovenian, Spanish and Swedish.

#### Try the demo
See the [Windspeed Converter site](https://www.ostheimer.at/wordpress-plugins/windspeed-converter/ "Windspeed Converter site") for a test run!

== Installation ==

1. Upload the "wind-speed-converter" folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add the Windspeed Converter to your widget enabled space
4. If you need to insert it in a post or page, use the shortcode `[windspeed_converter]`

== Screenshots ==

1. The Windspeed Converter on the frontend with a live conversion (100 km/h)

== Frequently Asked Questions ==

= Is the plugin available in my language? =

Very likely, yes. Translations for all 24 official EU languages are bundled with the plugin and are picked up automatically based on your site language setting.

= How can I display the Windspeed Converter on the Frontend? =

You can add the shortcode `[windspeed_converter]` in a post or page so that the Windspeed Converter will be displayed on that page.

= Can I hide certain fields? =

Yes, use the shortcode attributes to disable specific fields. For example: `[windspeed_converter beaufort="false" ms="false"]`

== Changelog ==

= 1.4.0 =
* Added translations for all 24 official EU languages (Bulgarian, Croatian, Czech, Danish, Dutch, Estonian, Finnish, French, German, Greek, Hungarian, Irish, Italian, Latvian, Lithuanian, Maltese, Polish, Portuguese, Romanian, Slovak, Slovenian, Spanish, Swedish)
* Added .pot translation template for translators
* Re-added load_plugin_textdomain() so the bundled translations are actually loaded (required because no language packs exist on translate.wordpress.org)
* Improved German translation wording

= 1.3.0 =
* Fixed all issues reported by the WordPress Plugin Review Team
* Added proper GPL license declarations in readme.txt and plugin header
* Fixed text domain to match plugin slug (wind-speed-converter)
* Added proper output escaping for all dynamic content
* Replaced deprecated path constants with WordPress functions (plugin_dir_url, plugin_dir_path)
* Added unique function/class prefixes (wsconv_)
* Added direct file access protection (ABSPATH check)
* Removed WordPress trademark from plugin name
* Updated readme.txt to WordPress standards
* Removed screenshot files from plugin directory (moved to SVN assets)
* Improved widget form with proper sanitization and escaping
* Updated minimum requirements to WordPress 5.0 and PHP 7.4

= 1.2.2 =
* Updates for widget

= 1.2.1 =
* CSS fix

= 1.2 =
* CSS fix

= 1.1 =
* Tested Up 5.1

= 1.0.1 =
* Minor Bugfix Release

= 1.0.0 =
* Initial Release
