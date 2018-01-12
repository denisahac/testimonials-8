<?php
/**
 * Register custom post type `testimonial_8`.
 *
 * @since 1.0
 */

class Testimonial_8_Post_Type {

	/**
	 * Class initialization method.
	 *
	 * @since 1.0
	 */
	function __construct() {
		add_action('init', [$this, 'create']);
		add_action('add_meta_boxes_testimonial_8', [$this, 'meta_boxes']);
		add_action('save_post', [$this, 'save_meta'], 10, 2);
		add_filter( 'enter_title_here', [$this, 'change_title_text']);
		add_filter('manage_testimonial_8_posts_columns', [$this, 'custom_header_columns']);
		add_action('manage_testimonial_8_posts_custom_column', [$this, 'custom_columns'], 10, 2);

		add_filter( 'manage_edit-testimonial_8_sortable_columns', [$this, 'sortable_columns']);
	}

	/**
	 * Register the custom post type `testimonial_8` using the `register_post_type` method.
	 *
	 * @since 1.0
	 */
	function create() {
		register_post_type(
			'testimonial_8',

			array(
				'label' => __('Testimonials', 'wpt8'),
				'labels' => array(
					'name' => __('Testimonials', 'wpt8'),
					'singular_name' => __('Testimonial', 'wpt8'),
					'add_new' => __('Add New', 'wpt8'),
					'add_new_item' => __('Add New Testimonial', 'wpt8'),
					'edit_item' => __('Edit Testimonial', 'wpt8'),
					'new_item' => __('New Testimonial', 'wpt8'),
					'view_item' => __('View Testimonial', 'wpt8'),
					'view_items' => __('View Testimonials', 'wpt8'),
					'search_items' => __('Seach Testimonials', 'wpt8'),
					'not_found' => __('No testimonials found', 'wpt8'),
					'not_found_in_trash' => __('No testimonials found in Trash', 'wpt8'),
					'parent_item_colon' => __('Parent Testimonial', 'wpt8'),
					'all_items' => __('All Testimonials', 'wpt8'),
					'archives' => __('Testimonial Archive', 'wpt8'),
					'attributes' => __('Testimonial Attributes', 'wpt8'),
					'insert_into_item' => __('Insert into testimonial', 'wpt8'),
					'uploaded_to_this_item' => __('Uploaded to this testimonial', 'wpt8'),
					'featured_image' => __('Author Image', 'wpt8'),
					'set_featured_image' => __('Set author image', 'wpt8'),
					'remove_featured_image' => __('Remove author image', 'wpt8'),
					'use_featured_image' => __('Use as author image', 'wpt8'),
					'filter_items_list' => __('Must change from filter_items_list', 'wpt8'),
					'items_list_navigation' => __('Must change from items_list_navigation', 'wpt8'),
					'items_list' => __('Must change from items_list', 'wpt8')
				),

				'description' => __('What your previous clients\'s says about your company and services.', 'wpt8'),

				// Implies exclude_from_search: true, publicly_queryable: false, show_in_nav_menus: false, and show_ui: false. 
				'public' => false,

				'show_ui' => true,

				'show_menu' => false,

				'show_in_admin_bar' => true,

				// 20 - below pages
				'menu_position' => 20, 

				'menu_icon' => 'dashicons-format-quote',

				'hierarchical' => false,

				'supports' => array(
					'title',
					'editor',
					'thumbnail'
				),

				'has_archive' => false,

				'rewrite' => false,

				'query_var' => false,

				'show_in_rest' => true
			)
		);
	}

	/**
	 * Custom meta boxes for our `testimonial_8` post type.
	 *
	 * @since 1.0
	 *
	 * @param WP_Post $post The current post object.
	 */
	function meta_boxes($testimonial) {
		add_meta_box('testimonial_8-company', __('Company', 'wpt8'), [$this, 'company_meta'], 'testimonial_8', 'side');
		add_meta_box('testimonial_8-rating', __('Rating', 'wpt8'), [$this, 'rating_meta'], 'testimonial_8', 'side');
	}

	/** 
	 * HTML output for company meta box in New and Edit Testimonial pages.
	 *
	 * @since 1.0
	 */
	function company_meta() {
		global $post;

		// Nonce to verify the data. ?>
		<input 
			id="testimonial_8_company_nonce" 
			type="hidden" 
			name="testimonial_8_company_nonce"
			value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>"/>
		<?php

		// get company meta data if available.
		$company = get_post_meta($post->ID, 'company', true);

		// output the field. ?>
		<textarea class="wpt8-textarea" name="company"><?php echo esc_attr($company); ?></textarea>

		<?php
	}

	/** 
	 * HTML output for rating meta box in New and Edit Testimonial pages.
	 *
	 * @since 1.0
	 */
	function rating_meta() {
		global $post;

		// Nonce to verify the data. ?>
		<input 
			id="testimonial_8_rating_nonce" 
			type="hidden" 
			name="testimonial_8_rating_nonce"
			value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>"/>
		<?php

		// get rating meta data if available.
		$rating = get_post_meta($post->ID, 'rating', true);

		$rating = !empty($rating) ? $rating : 0;

		// output the field. ?>
		
		<div class="wpt8-rate js-wpt8-rate" data-rateyo-rating="<?php echo esc_attr($rating); ?>"></div>
		
		<input type="hidden" class="js-wpt8-rating" name="rating" value="<?php echo esc_attr($rating); ?>"/>
		<?php
	}

	/**
	 * Save custom meta data information.
	 *
	 * @since 1.0
	 *
	 * @param int $id The testimonial ID.
	 * @param WP_Post $testimonial The tesimonial post object.
	 */
	function save_meta($id, $testimonial) {

		// verify nonces for company and rating meta boxes.
		
		// if(!$this->verify_meta('testimonial_8_company_nonce') || !$this->verify_meta('testimonial_8_rating_nonce')) {
		// 	return;
		// }

		// check if the current user can edit the `testimonial` post type.
		if(!current_user_can('edit_post', $id)) return;

		$post_type = get_post_type($id);

		// if this isn't a `testimonial` post type, don't proceed.
		if('testimonial_8' != $post_type) return;

		// Update the `testimonial` metadata.
		if ( isset( $_POST['company'] ) ) {
        update_post_meta( $id, 'company', sanitize_text_field( $_POST['company'] ) );
    }

    if ( isset( $_POST['rating'] ) ) {
        update_post_meta( $id, 'rating', sanitize_text_field( $_POST['rating'] ) );
    }
	}

	/**
	 * Verify nonce for custom meta box.
	 *
	 * @since 1.0
	 * @access private
	 *
	 * @param string $field The name of the input field to verify.
	 * @return boolean
	 */
	private function verify_meta($field) {
		return wp_verify_nonce($_POST[$field], plugin_basename(__FILE__));
	}

	
	/**
	 * Change placeholder text title for `testimonial` post type.
	 *
	 * @since 1.0
	 * @see https://www.templatemonster.com/help/wordpress-how-to-replace-enter-title-here-placeholder-text.html
	 *
	 * @param string $title The placeholder title text.
	 * @return strin $title The modified placeholder text.
	 */
	function change_title_text($title){
	   $screen = get_current_screen();

	   if('testimonial_8' == $screen->post_type ) {
	      $title = __('Author name', 'wpt8');
	   }

	   return $title;
	}

	/**
	 * Display additional column on the browse page.
	 *
	 * @since 1.0
	 *
	 * @param string $column The column name.
	 * @param int $testimonial_id The testimonial ID.
	 */
	function custom_columns($column, $testimonial_id) {
		switch ($column) {
			case 'photo': ?>

			<a 
				class="wpt8-photo-link"
				href="<?php printf('%s/post.php?post=%d&action=%s', admin_url(), get_the_ID($testimonial_id), 'edit'); ?>" 
				title="<?php the_title(); ?>"
				aria-label="<?php printf('%s “%s”', __('Edit', 'wpt8'), trim(get_the_title())); ?>">
				<?php the_post_thumbnail(array(44, 44), array('class' => 'wpt8-photo')); ?>
			</a>

			<?php
				
				break;

			case 'company':
				echo esc_attr(get_post_meta($testimonial_id, 'company', true));
				break;

			case 'content':
				echo get_the_content($testimonial_id);
				break;

			case 'rating': 

				$rating = get_post_meta($testimonial_id, 'rating', true);
				$rating = !empty($rating) ? $rating : 0; ?>
				
				<div class="wpt8-rate js-wpt8-rate" title="<?php printf('%.1f %s', esc_attr($rating), __('Stars', 'wpt8')); ?>" data-rateyo-rating="<?php echo esc_attr($rating); ?>" data-rateyo-read-only="true"></div>

				<?php
				break;
		}
	}

	/**
	 * Set additional table headers for the custom column.
	 *
	 * @since 1.0
	 *
	 * @param array $columns The list of columns.
	 * @return array $columns The modified columns (i.e. added new)
	 */
	function custom_header_columns($columns) {
		unset($columns['title']);
		unset($columns['date']);

		$columns['photo'] = __('Photo', 'wpt8');
		$columns['title'] = __('Author', 'wpt8');
		$columns['company'] = __('Company', 'wpt8');
		
		if($_REQUEST['mode'] == 'list' ) :
			$columns['content'] = __('Testimonial', 'wpt8');
		endif;

		$columns['rating'] = __('Rating', 'wpt8');
		$columns['date'] = __('Date', 'wpt8');

		return $columns;
	}

	/**
	 * Define the additional sortable columns
	 *
	 * @since 1.0
	 * @see https://www.ractoon.com/2016/11/wordpress-custom-sortable-admin-columns-for-custom-posts/
	 *
	 * @param array $columns The list of columns.
	 * @return array $columns The modified columns (i.e. added new)
	 */
	function sortable_columns( $columns ) {
	  $columns['company'] = 'company';
	  $columns['rating'] = 'rating';

	  return $columns;
	}
}