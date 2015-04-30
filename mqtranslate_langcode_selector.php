<?php
/*
Plugin Name: mqtranslate langcode widget selector
Plugin URI: http://funkydrop.net/
Version: 1.0
Author: Koldo Gonzalez
Author URI: http://funkydrop.net/
Description: Language widget selector that displays the lang code.
License: GPL
*/

///////////////////////////////////////////////////////////////////
//                             HOOKS
//////////////////////////////////////////////////////////////////

function mqtrans_langcode_selector_widget_init() {
	register_widget('mqTranslateLangCodeWidget');
}
add_action('widgets_init','mqtrans_langcode_selector_widget_init');

///////////////////////////////////////////////////////////////////////
//                         PRINT WIDGET      
//////////////////////////////////////////////////////////////////////
function qtrans_generateLangCodeSelect($id='') {
	
	global $q_config;
	if(is_404()) $url = get_option('home');
	else $url = '';
	if($id=='') $id = 'mqtranslate';
	$id .= '-chooser';
		
	echo '<ul class="qtrans_language_chooser" id="'.$id.'">';
	foreach( qtrans_getSortedLanguages() as $language ) {
		$url = mqtrans_langcode_selector_get_url($url, $language);
		$classes = array('lang-'.$language, 'lang-code');
		if($language == $q_config['language'])
			$classes[] = 'active';
		echo '<li class="'. implode(' ', $classes) .'"><a href="'. $url .'"';
		// set hreflang
		echo ' hreflang="'.$language.'" title="'.$q_config['language_name'][$language].'"';
		$selector = $language;
		$selector = apply_filters( 'lang-code-selector-content', $selector );
		echo '>'.$selector.'</span></a></li>';
	}
	echo "</ul><div class=\"qtrans_widget_end\"></div>";
}

/**
 *  Function to get the url of a post
 *  
 *  IF qtranslate slug detected, it makes use of the class to get the URL
 */
function mqtrans_langcode_selector_get_url($url, $lang){
	
	// qtranslate slug compatibility
	if (function_exists('is_plugin_active') && is_plugin_active('qtranslate-slug/qtranslate-slug.php')){
		global $qtranslate_slug;
		return $qtranslate_slug->get_current_url($lang);
	}
	elseif(function_exists('qtranxf_convertURL')){
		return qtranxf_convertURL($url, $lang);
	}
	// Default behaviour
	else{
		return qtrans_convertURL($url, $lang);
	}
}


///////////////////////////////////////////////////////////////////////
//              WIDGET OPTIONS (ADMIN INTERFACE)      
//////////////////////////////////////////////////////////////////////

class mqTranslateLangCodeWidget extends WP_Widget {
	function mqTranslateLangCodeWidget() {
		$widget_ops = array('classname' => 'widget_langcode_mqtranslate', 'description' => __('Lang code selector for mqtranslate.','mqtranslate_langcode_selector') );
		$this->WP_Widget('mqtranslate_langcode_selector', __('mqTranslate Language Code Chooser','mqtranslate_langcode_selector'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);

		echo $before_widget;
		$title = empty($instance['title']) ? __('Language', 'mqtranslate_langcode_selector') : apply_filters('widget_title', $instance['title']);
		$hide_title = empty($instance['hide-title']) ? false : 'on';

		if($hide_title!='on') { echo $before_title . $title . $after_title; };
		qtrans_generateLangCodeSelect($this->id);
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		if(isset($new_instance['hide-title'])) $instance['hide-title'] = $new_instance['hide-title'];
		$instance['type'] = $new_instance['type'];

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'hide-title' => false) );
		$title = $instance['title'];
		$hide_title = $instance['hide-title'];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mqtranslate_langcode_selector'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('hide-title'); ?>"><?php _e('Hide Title:', 'mqtranslate_langcode_selector'); ?> <input type="checkbox" id="<?php echo $this->get_field_id('hide-title'); ?>" name="<?php echo $this->get_field_name('hide-title'); ?>" <?php echo ($hide_title=='on')?'checked="checked"':''; ?>/></label></p>
		<?php
	}
}
?>