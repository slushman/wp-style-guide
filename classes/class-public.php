<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link 		http://example.com
 * @since 		1.0.0
 *
 * @package 	WP_Style_Guide
 * @subpackage 	WP_Style_Guide/classes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package 	WP_Style_Guide
 * @subpackage 	WP_Style_Guide/classes
 * @author 		Chris Wilcoxson <chris@slushman.com>
 */
class WP_Style_Guide_Public {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {} // __construct()

	/**
	 * Creates comments on the style guide page
	 *
	 * @param 		int 		$page_id 		The page ID.
	 */
	private function create_styleguide_comments( $page_ID ) {

		if ( empty( $page_ID ) ) {  return; }

		$comment['comment_post_ID'] 		= $page_ID;
		$comment['comment_author'] 			= 'Commenter 1';
		$comment['comment_author_email']	= 'test@slushman.com';
		$comment['comment_author_url']		= 'http://slushman.com';
		$comment['comment_content']	 		= 'First comment!';
		$comment['comment_parent']	  		= 0;

		$comment_1_ID = wp_insert_comment( $comment );

		$comment['comment_post_ID'] 		= $page_ID;
		$comment['comment_author'] 			= 'Commenter 2';
		$comment['comment_author_email']	= 'test@slushman.com';
		$comment['comment_author_url']		= 'http://slushman.com';
		$comment['comment_content']	 		= 'Second comment!';
		$comment['comment_parent']	  		= 0;

		$comment_2_ID = wp_insert_comment( $comment );

		if ( $comment_2_ID ) {

			$comment['comment_post_ID'] 		= $page_ID;
			$comment['comment_author'] 			= 'Commenter 3';
			$comment['comment_author_email']	= 'test@slushman.com';
			$comment['comment_author_url']		= 'http://slushman.com';
			$comment['comment_content']	 		= 'First nested comment for comment 2.';
			$comment['comment_parent']	  		= $comment_2_ID;

			$comment_3_ID = wp_insert_comment( $comment );

			if ( $comment_3_ID ) {

				$comment['comment_post_ID'] 		= $page_ID;
				$comment['comment_author'] 			= 'Commenter 4';
				$comment['comment_author_email']	= 'test@slushman.com';
	   			$comment['comment_author_url']		= 'http://slushman.com';
				$comment['comment_content']	 		= 'Nexted comment for the nested comment on comment 2.';
				$comment['comment_parent']	  		= $comment_3_ID;

				$comment_4_ID = wp_insert_comment( $comment );

			} // comment 3 ID check

		} // comment 2 ID check

		$comment['comment_post_ID'] 		= $page_ID;
		$comment['comment_author'] 			= 'Commenter 5';
		$comment['comment_author_email']	= 'test@slushman.com';
		$comment['comment_author_url']		= 'http://slushman.com';
		$comment['comment_content']	 		= 'Fifth comment!';
		$comment['comment_parent']	  		= 0;

		$comment_5_ID = wp_insert_comment( $comment );

	} // create_comments()

	/**
	 * Inserts the "Style Guide" page
	 *
	 * @return 		int 		$page_ID 		The page ID.
	 */
	public function create_styleguide_page() {

		$post['comment_status'] = 'closed';
		$post['page_template']	= 'full-width';
		$post['ping_status']	= 'closed';
		$post['post_content']   = '[wpstyleguide]';
		$post['post_name']		= 'style-guide';
		$post['post_status']	= 'publish';
		$post['post_title']		= __( 'Style Guide', 'wp-style-guide' );
		$post['post_type']		= 'page';
		$check 					= get_page_by_title( $post['post_title'] );

		if ( ! empty( $check->ID ) ) { return; }

		$page_ID = wp_insert_post( $post );

		if ( ! $page_ID ) { return; }

		$this->create_styleguide_comments( $page_ID );

		return $page_ID;

	} // create_styleguide_page()

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( WPSTYLEGUIDE_SLUG, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/wp-style-guide-public.css', array(), WPSTYLEGUIDE_VERSION, 'all' );

	} // enqueue_styles()

	/**
	 * Registers a sidebar.
	 */
	public function register_sidebar() {

		$args['name']			= __( 'Style Guide', 'wp-style-guide' );
		$args['id']				= 'wp-style-guide';
		$args['description']	= __( 'This sidebar is only for the style guide page.', 'wp-style-guide' );
		$args['class']			= 'wp-style-guide';
		$args['before_widget']	= '<li id="%1$s" class="widget %2$s">';
		$args['after_widget']	= '</li>';
		$args['before_title']	= '<h2 class="widgettitle">';
		$args['after_title']	= '</h2>';

		register_sidebar( $args );

	} // register_sidebar()

} // class
