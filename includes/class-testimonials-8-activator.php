<?php
/**
* Fired during plugin activation.
*
* This class defines all code necessary to run during the plugin's activation.
*
* @since      1.0
* @package    Testimonials_8
* @subpackage Testimonials_8/includes
* @author     Den Isahac <den.isahac@gmail.com>
*/
class Testimonials_8_Activator {
	
	/**
	 * Create the database tables necessary for the plugin.
	 *
	 * @since 1.0
	 */
	public static function activate() {
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$charset_collate = $wpdb->get_charset_collate();

		// create the `testimonials` table
		$table_testimonials = $wpdb->prefix . 'testimonials';
		$sql = "CREATE TABLE IF NOT EXISTS $table_testimonials (
			id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			author VARCHAR(25) NOT NULL,
			company VARCHAR(30),
			testimonial VARCHAR(250) NOT NULL,
			rating DECIMAL
		)";

		dbDelta($sql);
	}
}