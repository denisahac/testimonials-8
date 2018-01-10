<?php
/**
* Fired during plugin uninstallation.
*
* This class defines all code necessary to run during the plugin's uninstallation.
*
* @since      1.0
* @package    Testimonials_8
* @subpackage Testimonials_8/includes
* @author     Den Isahac <den.isahac@gmail.com>
*/
class Testimonials_8_Uninstaller {
	
	/**
	 * Drop the database table created using plugin activation.
	 *
	 * @since 1.0
	 */
	public static function uninstall() {
		global $wpdb;

		$table_testimonials = $wpdb->prefix . 'testimonials';

		// drop the testimonials table
		$wpdb->query("DROP TABLE IF EXISTS $table_testimonials");
	}
}