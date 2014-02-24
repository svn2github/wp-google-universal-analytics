<?php
/*
Plugin Name: Google Universal Analytics
Plugin URI: http://wordpress.org/extend/plugins/google-universal-analytics/
Description: Adds <a href="http://www.google.com/analytics/">Google Analytics</a> tracking code on all pages.
Version: 2.0
Author: Audrius Dobilinskas
Author URI: http://onlineads.lt/
*/

if (!defined('WP_CONTENT_URL'))
      define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
if (!defined('WP_CONTENT_DIR'))
      define('WP_CONTENT_DIR', ABSPATH.'wp-content');
if (!defined('WP_PLUGIN_URL'))
      define('WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins');
if (!defined('WP_PLUGIN_DIR'))
      define('WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins');

function deactive_google_universal_analytics() {
  delete_option('web_property_id');
  delete_option('in_footer');
  delete_option('plugin_switch');
  delete_option('track_links');
  //classic_options
  delete_option('classic_property_id');
  delete_option('classic_in_footer');
  delete_option('classic_plugin_switch');
}


function admin_menu_google_universal_analytics() {

 
 global  $settings_page, $settings_page1, $instructions_page;
  
  $settings_page	=	add_menu_page( 'Google Universal Analytics', 'Google Universal Analytics', 'manage_options', 'google_universal_analytics', 'options_page_google_universal_analytics' );
  add_submenu_page('google_universal_analytics','','','manage_options','google_universal_analytics','options_page_google_universal_analytics');
 $settings_page1	=	 add_submenu_page( 'google_universal_analytics', 'Settings', 'Settings', 'manage_options', 'google_universal_analytics', 'options_page_google_universal_analytics' );
 $instructions_page	=	 add_submenu_page( 'google_universal_analytics', 'Classic Analytics', 'Classic Analytics', 'manage_options', 'classic_analytics', 'classic_analytics_page_google_universal_analytics' );
  
}

function options_page_google_universal_analytics() {
  include(WP_PLUGIN_DIR.'/google-universal-analytics/options.php');  
}
function classic_analytics_page_google_universal_analytics() {
  include(WP_PLUGIN_DIR.'/google-universal-analytics/classic/classic-analytics.php');  
}

function google_universal_analytics() {
  require 'tracking-code.php';
}

function google_classic_analytics() {
  $classic_property_id	=	get_option('classic_property_id');
  $classic_analytics_code	=	"<script type='text/javascript'>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '$classic_property_id']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";
echo $classic_analytics_code;
}
function google_universal_analytics_scripts($hook){
		global  $settings_page, $settings_page1, $instructions_page;
		
		if($hook != $settings_page && $hook != $settings_page1 && $hook != $instructions_page )
		return;
		
		
		//register styles
		wp_register_style( 'bootstrap-css', plugins_url( 'google-universal-analytics/bootstrap/css/bootstrap.min.css' , dirname(__FILE__) ) );
		wp_register_style( 'bootstrap-switch-css', plugins_url( 'google-universal-analytics/bootstrap/css/bootstrap-switch.min.css' , dirname(__FILE__) ) );
		wp_register_style( 'main-css', plugins_url( 'google-universal-analytics/assets/main.css' , dirname(__FILE__) ) );
		
		//register scripts
		wp_register_script( 'google-js', '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', array(), '', true );
		wp_register_script( 'bootstrap-js', plugins_url( 'google-universal-analytics/bootstrap/js/bootstrap.min.js' , dirname(__FILE__) ), array('google-js'), '', true );
		wp_register_script( 'bootstrap-switch-js', plugins_url( 'google-universal-analytics/bootstrap/js/bootstrap-switch.min.js' , dirname(__FILE__) ) , array('bootstrap-js'),'',true );
		wp_register_script( 'main-js', plugins_url( 'google-universal-analytics/assets/main.js' , dirname(__FILE__) ) , array('google-js'),'',true );
		
		
		//enqueue styles
		wp_enqueue_style( 'bootstrap-css' );
		wp_enqueue_style( 'bootstrap-switch-css' );
		wp_enqueue_style( 'main-css' );
		
		//enqueue scripts
		wp_enqueue_script( 'google-js' );
		wp_enqueue_script( 'bootstrap-js' );
		wp_enqueue_script( 'bootstrap-switch-js' );
		wp_enqueue_script( 'main-js' );
}


register_deactivation_hook(__FILE__, 'deactive_google_universal_analytics');

if (is_admin()) {
  add_action('admin_enqueue_scripts', 'google_universal_analytics_scripts');		
  add_action('admin_menu', 'admin_menu_google_universal_analytics');
}

if (!is_admin() && get_option('plugin_switch')=='on') {
	if(get_option('in_footer')=='on'){
  		add_action('wp_footer', 'google_universal_analytics');
	}else{
		add_action('wp_head', 'google_universal_analytics');
	}
}

if (!is_admin() && get_option('classic_plugin_switch')=='on') {
	if(get_option('classic_in_footer')=='on'){
  		add_action('wp_footer', 'google_classic_analytics');
	}else{
		add_action('wp_head', 'google_classic_analytics');
	}
}


function save_google_universal_analytics_settings() {
	// The $_REQUEST contains all the data sent via ajax
	if ( isset($_REQUEST) ) {
		$property_id = $_REQUEST['property_id'];
		$in_footer = $_REQUEST['in_footer'];
		$plugin_switch = $_REQUEST['plugin_switch'];
		$track_links = $_REQUEST['track_links'];
		
		
		update_option('web_property_id', $property_id);
  		update_option('in_footer', $in_footer);
 		update_option('plugin_switch', $plugin_switch);
		update_option('track_links', $track_links);
	}
	// Always die in functions echoing ajax content
   die();
}

function save_google_classic_analytics_settings() {
	// The $_REQUEST contains all the data sent via ajax
	if ( isset($_REQUEST) ) {
		$classic_property_id = $_REQUEST['classic_property_id'];
		$classic_in_footer = $_REQUEST['classic_in_footer'];
		$classic_plugin_switch = $_REQUEST['classic_plugin_switch'];
		
		
		update_option('classic_property_id', $classic_property_id);
  		update_option('classic_in_footer', $classic_in_footer);
 		update_option('classic_plugin_switch', $classic_plugin_switch);
	}
	// Always die in functions echoing ajax content
   die();
}

add_action( 'wp_ajax_save_google_universal_analytics_settings', 'save_google_universal_analytics_settings' );
add_action( 'wp_ajax_save_google_classic_analytics_settings', 'save_google_classic_analytics_settings' );



?>