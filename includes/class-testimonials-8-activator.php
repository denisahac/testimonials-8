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

require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-testimonial-8-post-type.php';

class Testimonials_8_Activator {
	
	/**
	 * Access field for testimonial post type.
	 * 
	 * @since 1.0
	 * @access private
	 */
	private $testimonial;

	/**
	 * Class constructor; used for class instantiation.
	 *
	 * @since 1.0
	 */
	function __construct() {
		$this->testimonial = new Testimonial_8_Post_Type();
		$this->activate();
	}

	/**
	 * Create our custom post type `testimonial`.
	 *
	 * @since 1.0
	 */
	private function activate() {
		// $this->testimonial->flush_rewrite();
	}
}