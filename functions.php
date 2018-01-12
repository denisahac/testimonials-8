<?php 
/**
 * functions.php equivalent for WP plugins.
 *
 * @since 1.0
 */

add_theme_support('post-thumbnails', array('testimonials_8'));

/**
 * Flush rewrite for our custom post type.
 * 
 * @since 1.0
 */
function wpt8_rewrite_flush_rules() {
	flush_rewrite_rules();
}

/**
 * Custom stylesheet and javascript
 *
 * @since 1.0
 */
function wpt8_enqueu_scripts() {
	// wp_enqueue_script('rater', plugin_dir_url(__FILE__) . 'assets/js/libs/rater.min.js', array('jquery'), '1.0', true);
	wp_enqueue_style('rateyo', '//cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css', array(), '2.3.2', 'screen');
	wp_enqueue_script('rateyo', '//cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js', array('jquery'), '2.3.2', true);
	wp_enqueue_style('app', plugin_dir_url(__FILE__) . 'assets/css/app.css', array(), '1.0', 'screen');
	wp_enqueue_script('app', plugin_dir_url(__FILE__) . 'assets/js/app.js', array(), '1.0', true);
}
add_action('admin_enqueue_scripts', 'wpt8_enqueu_scripts');
