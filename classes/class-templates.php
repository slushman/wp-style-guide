<?php
/**
 * Template-related functions
 *
 * @link 		http://example.com
 * @since 		1.0.0
 *
 * @package		WP_Style_Guide
 * @subpackage 	WP_Style_Guide/classes
 * @author 		Chris Wilcoxson <chris@slushman.com>
 */

if ( ! function_exists( 'wp_style_guide_templates' ) ) {

	/**
	 * Public API for adding and removing temmplates.
	 *
	 * @return 		object 			Instance of the templates class
	 */
	function wp_style_guide_templates() {

		return WP_Style_Guide_Templates::this();

	} // wp_style_guide_templates()

} // check

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
 * Defines the methods for creating the templates.
 *
 * @package 	WP_Style_Guide
 * @subpackage 	WP_Style_Guide/classes
 *
 */
class WP_Style_Guide_Templates {

	/**
	 * Private static reference to this class
	 * Useful for removing actions declared here.
	 *
	 * @var 	object 		$_this
 	 */
	private static $_this;

	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$options    The plugin options.
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		self::$_this = $this;

	} // __construct()

	/**
	 * Adds the introduction at the top of the page.
	 */
	public function add_intro() {

		include wp_style_guide_get_template( 'intro' );

	} // add_intro()

	/**
	 * Adds the table of contents.
	 */
	public function add_toc() {

		$groups = array( 'headers', 'structural', 'semantic', 'lists', 'tables', 'forms_and_fields', 'buttons', 'media', 'widgets', 'theme-specific' );
		$groups = apply_filters( 'wp-style-guide-toc-groups', $groups );

		include wp_style_guide_get_template( 'table-of-contents' );

	} // add_toc()

	/**
	 * Adds the header tags
	 */
	public function add_headers() {

		include wp_style_guide_get_template( 'headers' );

	} // add_headers()

	/**
	 * Adds structural HTML tags
	 */
	public function add_structural() {

		$structurals = array( 'blockquote', 'bold', 'code', 'hr', 'italics', 'links', 'paragraph', 'paragraph-justified', 'paragraph-left', 'paragraph-center', 'paragraph-right', 'subscript', 'superscript' );
		$structurals = apply_filters( 'wp-style-guide-structurals', $structurals );

		include wp_style_guide_get_template( 'structural' );

	} // add_structural()

	/**
	 * Adds semantic HTML tags
	 */
	public function add_semantic() {

		$semantics = array( 'abbreviation', 'address', 'citation', 'definition', 'deleted', 'emphasis', 'inline', 'inserted', 'keyboard', 'highlighted', 'preformatted', 'sample', 'small', 'strikethrough', 'strong', 'time', 'variable' );
		$semantics = apply_filters( 'wp-style-guide-semantics', $semantics );

		include wp_style_guide_get_template( 'semantic' );

	} // add_semantic()

	/**
	 * Adds HTML lists
	 */
	public function add_lists() {

		$lists = array( 'definition', 'dialog', 'ordered', 'unordered' );
		$lists = apply_filters( 'wp-style-guide-lists', $lists );

		include wp_style_guide_get_template( 'lists' );

	} // add_lists()

	/**
	 * Adds HTML tables
	 */
	 public function add_tables() {

		include wp_style_guide_get_template( 'tables' );

	 } // add_tables()

	/**
	 * Adds forms and fields types
	 */
	public function add_forms_and_fields() {

		include wp_style_guide_get_template( 'forms' );

	} // add_forms_and_fields()

	/**
	 * Adds various types of buttons
	 */
	public function add_buttons() {

		include wp_style_guide_get_template( 'buttons' );

	} // add_buttons()

	/**
	 * Adds various types of media
	 */
	public function add_media() {

		$medias = array( 'figure', 'figure-caption', 'image', 'image-left', 'image-center', 'image-right', 'caption', 'caption-left', 'caption-center', 'caption-right', 'video', 'audio' );
		$medias = apply_filters( 'wp-style-guide-medias', $medias );

		include wp_style_guide_get_template( 'medias' );

	} // add_media()

	/**
	 * Adds a sidebar and all default WordPress widgets
	 */
	public function add_widgets() {

		include wp_style_guide_get_template( 'widgets' );

	} // add_widgets()

	/**
	 * Returns a reference to this class. Used for removing
	 * actions and/or filters declared here.
	 *
	 * @see  	http://hardcorewp.com/2012/enabling-action-and-filter-hook-removal-from-class-based-wordpress-plugins/
	 * @return 	object 		This class
	 */
	static function this() {

		return self::$_this;

	} // this()

} // class
