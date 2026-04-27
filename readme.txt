=== Monetize Me ===
Contributors: shahalom, microsolutions
Tags: ads, adsense, advertising, ad manager, banner ads, multisite, monetization
Requires at least: 5.8
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 2.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A flexible advertisement management plugin with Multisite support, including centralized taxonomy synchronization across subsites.

== Description ==

**Monetize Me** is a lightweight and developer-friendly advertisement management plugin for WordPress. It allows you to manage ads, organize them using taxonomies, and display them dynamically using shortcodes, PHP functions, or Gutenberg blocks.

The plugin is optimized for **WordPress Multisite**, enabling Network Administrators to centrally manage and synchronize taxonomy terms (`adcategory`, `adsponsor`) across subsites.

= Core Features =

* Custom Post Type for Ads
* Taxonomies:
  - Ad Categories (`adcategory`)
  - Ad Sponsors (`adsponsor`)
* Display ads using:
  - Shortcodes
  - PHP functions
  - Gutenberg block
* Random ad display by category/group
* Lightweight and extensible architecture

= Multisite Features =

When network activated:

* Dedicated Network Admin settings page
* Copy taxonomy terms across subsites
* Bulk subsite selection
* Duplicate-safe copying (slug-based detection)
* Summary report (copied / skipped / failed)

== Installation ==

1. Upload the plugin to `/wp-content/plugins/`
2. Activate the plugin through the Plugins menu

= Multisite Installation =

1. Network Activate the plugin
2. Go to **Network Admin → Monetize Me**
3. Use the available tools

== Frequently Asked Questions ==

= Does this plugin support WordPress Multisite? =
Yes. When network activated, it provides a Network Admin panel for centralized control.

= Where are the Network settings? =
Go to: Network Admin → Monetize Me

= Can I copy taxonomy terms between subsites? =
Yes. You can copy all terms of `adcategory` and `adsponsor` from one site to selected subsites.

= What happens if a term already exists? =
Terms are matched by slug. Existing terms are skipped automatically.

= Can I copy to multiple subsites at once? =
Yes.

= Who can access this feature? =
Only Network Administrators.

= Will existing terms be overwritten? =
No. Existing terms are never modified.

= Does it copy ads as well? =
No. Only taxonomy terms are copied.

== Screenshots ==

1. Ad management interface
2. Taxonomy management (Categories & Sponsors)
3. Network Admin settings page
4. Term copy interface

== Usage ==

= Shortcode Usage =

Display ad by ID:

[monetize_me id="123"]

Display ads by category:

[monetize_me adcategory="sidebar"]

Display multiple ads:

[monetize_me adcategory="homepage" limit="3"]

= PHP Usage =

<?php echo monetize_me_display_ad( [ 'adcategory' => 'homepage' ] ); ?>

= Multisite Term Synchronization =

1. Go to **Network Admin → Monetize Me**
2. Select Source Site
3. Select Destination Subsites
4. Click "Copy Terms"

The plugin will:

* Copy `adcategory` terms
* Copy `adsponsor` terms
* Skip duplicates by slug

== Changelog ==

= 2.0.1 =
* NEW: Network Admin settings page for Multisite environments.
* NEW: Copy taxonomy terms (`adcategory`, `adsponsor`) from a source site to selected subsites.
* NEW: Bulk subsite selection for term synchronization.
* IMPROVED: Duplicate detection using term slug (skip existing terms).
* IMPROVED: Operation summary showing copied, skipped, and failed counts.
* SECURITY: Restrict term synchronization tools to Network Admin only.

= 2.0.0 =
* Added a centralized Ad_Service class used by shortcode, widget, block, and renderer layers
* Added cache-aware ad queries with automatic cache purging on ad save, delete, and taxonomy changes
* Added public helper API functions: monetize_me_get_ad(), monetize_me_get_random_ads(), monetize_me_render_ad(), mm_get_ad(), mm_get_random_ad(), and mm_render_ad()
* Added internal filters and actions for query arguments and rendered output
* Preserved backward compatibility for existing shortcode, widget, block, and Renderer::render() usage

= 1.9.0 =
* Major internal refactor for maintainability
* Added modern plugin bootstrap structure
* Removed runtime rewrite flushing
* Improved shortcode normalization and rendering
* Fixed widget slug handling bug
* Modernized block registration structure
* Added safer uninstall behavior
* Updated readme and repository packaging

= 1.0.1 =
* Revert back the ad sponsor taxonomy

= 1.0.0 =
* Recreated the plugin by removing legacy width and height taxonomies
* Added Ad Category taxonomy
* Added Gutenberg block support

== Upgrade Notice ==

= 2.0.1 =
Adds Multisite Network Admin tools and taxonomy synchronization. Recommended update for all multisite installations.

== License ==

This plugin is licensed under the GPLv2 or later.

