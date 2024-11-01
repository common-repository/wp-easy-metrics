<?php
/*
Plugin Name: WP Easy Metrics
Plugin URI: https://wpeasymetrics.com/
Description: Adds Google Analytics tracking code to your site easily
Author: RedLettuce Plugins
Author URI: https://redlettuce.com/
Version: 1.0.3
License: GPLv2
*/

if ( ! defined( 'ABSPATH' ) )
	exit;

function wp_easy_metrics_menu() {
	add_options_page('WP Easy Metrics Settings', 'WP Easy Metrics', 'administrator', 'wp-easy-metrics-settings', 'wp_easy_metrics_settings_page');
}
add_action('admin_menu', 'wp_easy_metrics_menu');

function wp_easy_metrics_settings_page() { ?>
<div class="wrap">
<h2>WP Easy Metrics Settings</h2>
<p>This plugin will added the tracking code as required by Google Analytics to the head of your website on every page.</p>
<form method="post" action="options.php">
    <?php settings_fields( 'wp-easy-metrics-settings' ); ?>
    <?php do_settings_sections( 'wp-easy-metrics-settings' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Your Google Analytics ID</th>
        <td><input type="text" name="wp_easy_metrics_tracking_id" value="<?php echo esc_attr( get_option('wp_easy_metrics_tracking_id') ); ?>" /> Just add your Google Analytics ID, i.e.: UA-12345678-1<br />
        You can find your Google Analytics ID in the <a href="https://analytics.google.com/" target="new">admin section at Google Analytics</a>
        <td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
<p>Look out for more plugins from us soon. Join our mailing list <a href="https://wpeasymetrics.com/">for further updates.</a></p>
</div>
<?php }

function wp_easy_metrics_deactivation() {
    delete_option( 'wp_easy_metrics_tracking_id' );
}
register_deactivation_hook( __FILE__, 'wp_easy_metrics_deactivation' );

function wp_easy_metrics_settings() {
	register_setting( 'wp-easy-metrics-settings', 'wp_easy_metrics_tracking_id' );
}
add_action( 'admin_init', 'wp_easy_metrics_settings' );

function wp_easy_metrics() { ?>
<!-- Tracking code added by WP Easy Metrics plugin -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo esc_attr( get_option('wp_easy_metrics_tracking_id') ); ?>', 'auto');
  ga('send', 'pageview');
</script>
<!-- End WP Easy Metrics plugin -->
<?php
}
add_action( 'wp_head', 'wp_easy_metrics', 10 );
