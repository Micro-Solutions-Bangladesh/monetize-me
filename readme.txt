=== Monetize Me ===
Author: Micro Solutions Bangladesh
Author URI: https://mcqacademy.com/author/shahalom/
Contributors: shahalom
Donate link: http://microsolutionsbd.com/donate/
Tags: monetize website, Ad Management, manage adsense script, manage monetize script, monetize me
Requires at least: 5.0
Tested up to: 5.3
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Monetize Me plugin will help webmaster to manage monetize scripts and display using shortcodes and widgets.

== Description ==
Monetize Me plugin will help webmaster to manage monetize scripts. The plugin also offers shortcode ([mmps]) and widget (Show Advertisment) to enable webmaster  display the advertisment in website.

Pleas use "Advertisements Sponsor", "Advertisements Width", and "Advertisements Height" taxonomies to categories you monetize scripts. Then use this information in the shortcode to display your required monetize scripts.

The shortcode [mmps] offers the following attributes to manage your scripts:

    1. id: comes from the slug of the script post. with this 'id' attribute all other attribute will not work. because with this 'id' attribute you are telling an specific ad that you have created.

    2. width: comes from the "Advertisements Width" taxonomy. Width of the advertisment need to be mention in the 'width' attribute. default value for 'width' attribute is 'responsive'.

    3. height: comes from the "Advertisements Height" taxonomy. Height of the advertisment need to be mention in the 'width' attribute. default value for 'height' attribute is 'responsive'.

    4. class: left, right, and center are allowed values for the 'class' attribute to mention the alignment of the advertisment. default value is 'left'.

    5. stype: comes from the "Advertisements Sponsor" taxonomy. stype need a slug of a sponsor. default is 'adsense'

    6. type: comes from the "Ad Type" field of "General Setting" box. mix, link, text, img, feed, and article are allowed values for the 'type' attribute.

    7. limit: how many ads to be serve matching required attribute. any mumber are allowed but 0.

    8. wrapper: default value is 1 to wrap your advertisemet script in a div. use 0 to not use any html div wrapper.

Hope the screenshots shows few good way - how to create monetization post and use those anywhere in the site using shortcode or widgets.



== Installation ==
Standard installation required.

1. After downloading the 'monetize-me.zip' file extract/uncompress it.
2. Upload the Downloaded uncompress package to the '/wp-content/plugins/' directory.
2. Activate the plugin using the Plugin Tab in your Wordpress Dashboard.
3. You will find a menu item called 'Ads' in the admin left sidebar.

== Changelog ==
= 1.0.1 =
* Revert back the ad sponsor taxonomy

= 1.0.0 =
* Recreating the plugin by deleting `Add Width` and `Add Height` taxonomy
* Creating new taxonomy `Add Category`
* Adding block for gutenberg

= 0.0.9 =
* Add two more options for the advertisment type

= 0.0.8 =
* Disable Rich Editor for Ad Post Type

= 0.0.7 =
* Display specific number of ads mentioned in the widget or in the limit attribute of shortcode

= 0.0.6 =
* Stable plugin released

== Upgrade Notice ==
N/A

== Frequently Asked Questions ==

= Where can I find the admin page of the plugin? =
A menu item (called "Ads") appears on the left sidebar in admin. You will also get different links to manage ads script, ad width, ad height, and ad sponsors.

= What is the shortcode offered by this plugin =
This plugin offered only shortcode called [mmps] with few attributes. The shortcode attributes are:

    1. id: slug of any ad can be provide in the id attribute. with this 'id' attribute all other attribute will not work. because with this 'id' attribute you are telling an specific ad that you have created.

    2. width: width of the advertisment need to be mention in the 'width' attribute. default value for 'width' attribute is 'responsive'.

    3. height: height of the advertisment need to be mention in the 'width' attribute. default value for 'height' attribute is 'responsive'.

    4. class: left, right, and center are allowed values for the 'class' attribute to mention the alignment of the advertisment. default value is 'left'.

    5. stype: stype need a slug of a sponsor. default is 'adsense'

    6. type: mix, link, text, img, feed, and article are allowed values for the 'type' attribute.

    7. limit: how many ads to be serve matching required attribute. any mumber are allowed but 0.

    8. wrapper: default value is 1 to wrap your advertisemet script in a div. use 0 to not use any html div wrapper.

= Do I need a backup of my website to use this plugin? =
It's not mandatory task because we do not make any update or delete operation out of any functionality for this plugin.

= Does this plugin work with all wordpress versions? =
This version works with WordPress 4.0 and better. If you're using an older version, please check for the legacy releases.

= My question isn't answered here =
Somehow we overlooked your question, We apologize for this. Please visit contact us page of <a href="http://microsolutionsbd.com/contact-us/">Micro Solution Bangladesh</a> for your query.

= What's new in the latest version? =
Please check the changelog in the readme.txt file exist in the plugin folder.

== Screenshots ==
1.use-scortcode-in-content.png
2.screenshot-2.png
3.screenshot-3.png
4.screenshot-4.png
5.screenshot-5.png
6.screenshot-6.png
