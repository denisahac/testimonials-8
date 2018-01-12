<?php
/**
 * @package Testimonials_8
 * @since 1.0
 */
/*
Plugin Name: Testimonials 8
Plugin URI: https://github.com/denisahac/testimonials-8
Description: Testimonials plugin for WordPress.
Version: 1.0
Author: Den Isahac
Author URI: http://denisahac.xyz
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: wpt8
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path(__FILE__) . 'functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-testimonial-8-post-type.php';

$testimonial_8 = new Testimonial_8_Post_Type();

/**
 * Plugin activation function.
 *
 * @since 1.0
 */
function wpt8_activate() {
	wpt8_rewrite_flush_rules();
}
register_activation_hook(__FILE__, 'wpt8_activate');

/**
 * Initizlize plugin.
 *
 * @see includes/class-testimonial-8.php
 * @see functions.php
 */
function wpt8_init() {
	// require_once plugin_dir_path(__FILE__) . 'includes/class-testimonials-8.php';
	// Testimonials_8::get_instance();
	require_once plugin_dir_path(__FILE__) . 'functions.php';
}
add_action( 'plugins_loaded', 'wpt8_init');