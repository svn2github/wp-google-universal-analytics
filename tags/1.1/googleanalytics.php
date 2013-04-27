<?php
/*
Plugin Name: Google Universal Analytics
Plugin URI: http://wordpress.org/extend/plugins/google-universal-analytics/
Description: Adds <a href="http://www.google.com/analytics/">Google Universal Analytics</a> tracking code on all pages.
Version: 1.1
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
  add_option('web_property_id', 'UA-23710779-8');
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

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $web_property_id ?>', '<?php bloginfo('url'); ?>');
  ga('send', 'pageview');

</script>
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