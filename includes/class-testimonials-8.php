<?php
require_once plugin_dir_path(__FILE__) . 'class-testimonials-8-list.php';

/**
 * TODO
 *
 * @since 1.0
 */
 class Testimonials_8 {
 	// class instance
	static $instance;

	// customer WP_List_Table object
	public $testimonials;

 	/**
 	 * TODO
 	 *
 	 * @since 1.0
 	 */
 	function __construct() {
 		add_filter('set-screen-option', [__CLASS__, 'set_screen'], 10, 3);
 		add_action('admin_menu', [$this, 'menu']);
 	}

 	/**
 	 * Setter for screen option.
 	 *
 	 * @param $status
 	 * @param $option
 	 * @param $value
 	 * @return $value The value.
 	 */
 	public static function set_screen( $status, $option, $value ) {
		return $value;
	}

	/**
	 * Menu for the plugin.
	 */
	public function menu() {

		$hook = add_menu_page(
			__('Testimonials 8', 'wpt8'),
			__('Testimonial', 'wpt8'),
			'manage_options',
			'class-testimonial-8-list',
			[ $this, 'plugin_settings_page' ],
			'dashicons-format-quote',
			20
		);

		add_action( "load-$hook", [ $this, 'screen_option' ] );

	}

	/**
	 * Screen options.
	 */
	public function screen_option() {

		$option = 'per_page';
		$args   = [
			'label'   => __('Number of items per page', 'wpt8'),
			'default' => 5,
			'option'  => 'testimonials_per_page'
		];

		add_screen_option( $option, $args );

		$this->testimonials = new Testimonials_8_List();
	}


	/**
	* Plugin settings page
	*/
	public function plugin_settings_page() {
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php _e('Testimonials', 'wpt8'); ?></h1>
			<form method="post">
				<?php
				$this->testimonials->prepare_items();
				$this->testimonials->display(); ?>
			</form>
			<br class="clear">
		</div>
	<?php
	}

	/** 
	 * Singleton instance.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}