=== Plugin Name ===
Contributors: rufein
Donate link: http://funkydrop.net/
Tags: qtranslate, mqtranslate, widget, selector, language, switcher, qtranslate slug, qts 
Requires at least: 4.0
Tested up to: 4.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin that creates a widget with a language switcher with language codes. It's compatible with qtranslate and mqtranslate plugin.

== Description ==

Extension of the mqtranslate plugin that creates a widget that displays a language selector with language codes. For example, if you have got a site in 3 different
languages (Deutsch, english, spanish), the widget will display: de | en | es

The plugin is compatible with Qtrasnlate Slug {qts}.

It also has got the following filters:

*   'lang-code-selector-content' => This filter allows alter the content of each idiom.	


== Installation ==

* Install plugin either via the WordPress.org plugin directory, or by uploading the files to your server.
* Activate the module.

== Frequently Asked Questions ==

= How can i change the content of the switcher? =

Yes. It's posible change the content of the selector. You only have to add a filter in the functions.php in your theme or add the code in yoyr custom plugin.

For example:

add_filter( 'lang-code-selector-content', 'test_lang_code_selector_content' ); 

function test_lang_code_selector_content( $lang_code ){ 
	global $q_config;
	$link_flag_url =  dirname(plugins_url()) . '/' . $q_config['flag_location'] . $q_config['flag'][$lang_code];
    $link_flag = "<img widht=\"18\" height=\"12\" src=\"$link_flag_url\" alt=\"$lang_code\" />";
    return $lang_code . $link_flag ;
}


= How do i contribute to this plugin? =

I've open a project in my github profile. Feel free to fork and change the code.

== Screenshots ==

== Changelog ==

= 1.0 =

* Compatibylity with qransalte slug
* Added filter: 'lang-code-selector-content'
* Realeased plugin.


== Upgrade Notice ==


== Arbitrary section ==


