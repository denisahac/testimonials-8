<?php 
if(!defined('WP_List_Table')) {
	require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

/**
 * WP list table for listing testimonials.
 *
 * @since 1.0
 */
class Testimonials_8_List extends WP_List_Table {

	/**
	 * Class instantiation.
	 *
	 * @since 1.0
	 */
	function __construct() {
		parent::__construct(
			array(
				'singular' => __('Testimonial', 'wpt8'),
				'plural' => __('Testimonials', 'wpt8'),
				'ajax' => false 
			)
		);
	}

	/**
	 * Retrieve testimonials from the database
	 *
	 * @param int $per_page
	 * @param int $page_number
	 *
	 * @return mixed
	 */
	public static function get_testimonials($per_page = 5, $page_number = 1) {
		global $wpdb;

		$table_testimonials = $wpdb->prefix . 'testimonials';
		$sql = "SELECT * FROM $table_testimonials";

		if ( ! empty( $_REQUEST['orderby'] ) ) {
	    $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
	    $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
	  }

	  $sql .= " LIMIT $per_page";
	  $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


	  $result = $wpdb->get_results( $sql, 'ARRAY_A' );

	  return $result;
	}

	/**
	 * Delete testimonial by ID.
	 *
	 * @param int $id Testimonial ID.
	 */
	public static function delete_testimonial($id) {
		global $wpdb;

		$wpdb->delete(
	    "{$wpdb->prefix}testimonials",
	    [ 'id' => $id ],
	    [ '%d' ]
	  );
	}

	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
	  global $wpdb;

	  $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}testimonials";

	  return $wpdb->get_var($sql);
	}

	/**
	 * Message to be displayed when there are no items
	 *
	 * @since 3.1.0
	 * @access public
	 */
	public function no_items() {
		_e('No testimonials found.', 'wpt8');
	}

	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	function column_author( $item ) {

	  // create a nonce
	  $delete_nonce = wp_create_nonce('sp_delete_testimonial');

	  $title = '<strong>' . $item['author'] . '</strong>';

	  $actions = [
	    'delete' => sprintf( '<a href="?page=%s&action=%s&testimonial=%s&_wpnonce=%s">%s</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce, __('Delete', 'wpt8') )
	  ];

	  return $title . $this->row_actions($actions);
	}

	/**
	 * Render a column when no column specific method exists.
	 *
	 * @param array $item
	 * @param string $column_name
	 *
	 * @return mixed
	 */
	protected function column_default( $item, $column_name ) {
	  switch ( $column_name ) {
	    case 'company':
	    case 'testimonial':
	    case 'rating':
	      return $item[ $column_name ];
	    default:
	      return print_r( $item, true ); //Show the whole array for troubleshooting purposes
	  }
	}

	/**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @return string
	 */
	function column_cb( $item ) {
	  return sprintf(
	    '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
	  );
	}

	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
	  $columns = [
	    'cb'      => '<input type="checkbox" />',
	    'author'    => __( 'Author', 'wpt8' ),
	    'company'    => __( 'Company', 'wpt8' ),
	    'testimonial'    => __( 'Testimonial', 'wpt8' ),
	    'rating'    => __( 'Rating', 'wpt8' )
	  ];

	  return $columns;
	}

	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
	  $sortable_columns = array(
	    'author' => array( 'author', true ),
	    'company' => array( 'company', true ),
	    'rating' => array( 'rating', true )
	  );

	  return $sortable_columns;
	}

	/**
	 * Returns an associative array containing the bulk action
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
	  $actions = [
	    'bulk-delete' => __('Delete', 'wpt8')
	  ];

	  return $actions;
	}

	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {

	  $this->_column_headers = $this->get_column_info();

	  /** Process bulk action */
	  $this->process_bulk_action();

	  $per_page     = $this->get_items_per_page( 'testimonials_per_page', 5 );
	  $current_page = $this->get_pagenum();
	  $total_items  = self::record_count();

	  $this->set_pagination_args( [
	    'total_items' => $total_items, //WE have to calculate the total number of items
	    'per_page'    => $per_page //WE have to determine how many items to show on a page
	  ] );


	  $this->items = self::get_testimonials( $per_page, $current_page );
	}

	/**
	 * TODO
	 */
	public function process_bulk_action() {

	  //Detect when a bulk action is being triggered...
	  if ( 'delete' === $this->current_action() ) {

	    // In our file that handles the request, verify the nonce.
	    $nonce = esc_attr( $_REQUEST['_wpnonce'] );

	    if ( ! wp_verify_nonce( $nonce, 'sp_delete_testimonial' ) ) {
	      die('Error deleting testimonial');
	    }
	    else {
	      self::delete_testimonial( absint( $_GET['testimonial'] ) );

	      wp_redirect( esc_url( add_query_arg() ) );
	      exit;
	    }

	  }

	  // If the delete bulk action is triggered
	  if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
	       || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
	  ) {

	    $delete_ids = esc_sql( $_POST['bulk-delete'] );

	    // loop over the array of record IDs and delete them
	    foreach ( $delete_ids as $id ) {
	      self::delete_testimonial( $id );

	    }

	    wp_redirect( esc_url( add_query_arg() ) );
	    exit;
	  }
	}
}