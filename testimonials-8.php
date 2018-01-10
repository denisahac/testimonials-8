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

/**
 * Plugin activation function.
 *
 * @see includes/class-testimonials-8-activator.php
 */
function wpt8_activate() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-testimonials-8-activator.php';
	Testimonials_8_Activator::activate();
}
register_activation_hook(__FILE__, 'wpt8_activate');

/**
 * Initizlize plugin.
 *
 * @see functions.php
 */
function wpt8_init() {
	require_once plugin_dir_path(__FILE__) . 'functions.php';
}
wpt8_init();