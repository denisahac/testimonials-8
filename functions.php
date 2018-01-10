<?php

exit();

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
	  <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg_options"
            settings_fields('wporg_options');
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections('wporg');
            // output save settings button
            submit_button('Save Settings');
            ?>
        </form>
	</div>
	<?php 
}