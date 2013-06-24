<?php
/*
Plugin Name: Google Universal Analytics
Plugin URI: http://wordpress.org/extend/plugins/google-universal-analytics/
Description: Adds <a href="http://www.google.com/analytics/">Google Analytics</a> tracking code on all pages.
Version: 1.2
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

function activate_google_universal_analytics() {
  add_option('web_property_id', 'Paste your Google Universal Analytics tracking code here...');
}

function deactive_google_universal_analytics() {
  delete_option('web_property_id');
}

function admin_init_google_universal_analytics() {
  register_setting('google_universal_analytics', 'web_property_id');
}

function admin_menu_google_universal_analytics() {
  add_options_page('Google Universal Analytics', 'Google Universal Analytics', 'manage_options', 'google_universal_analytics', 'options_page_google_universal_analytics');
}

function options_page_google_universal_analytics() {
  include(WP_PLUGIN_DIR.'/google-universal-analytics/options.php');  
}

function google_universal_analytics() {
  $web_property_id = get_option('web_property_id');
?>

<!-- Google Universal Analytics plugin for WordPress -->
<?php echo $web_property_id ?>

<?php
}

register_activation_hook(__FILE__, 'activate_google_universal_analytics');
register_deactivation_hook(__FILE__, 'deactive_google_universal_analytics');

if (is_admin()) {
  add_action('admin_init', 'admin_init_google_universal_analytics');
  add_action('admin_menu', 'admin_menu_google_universal_analytics');
}

if (!is_admin()) {
  add_action('wp_head', 'google_universal_analytics');
}

?>