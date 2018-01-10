<?php
/**
 * Construct the HTML for our top level menu.
 *
 * @since 1.0
 */
function wpt8_add_menu() {
	// add top level menu
	add_menu_page(
		__('Testimonials 8', 'wpt8'),
		__('Testimonials', 'wpt8'),
		'manage_options',
		'testimonials',
		'wpt8_options_page_html',
		'dashicons-format-quote',
		20
	);
}
add_action('admin_menu', 'wpt8_add_menu');

function wpt8_options_page_html() {
	if(!current_user_can('manage_options')) {
		return;
	}
	?>

	<div class="wrap">
	  <h1>Hello</h1>
	</div>
	<?php 
}