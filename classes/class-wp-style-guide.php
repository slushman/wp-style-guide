<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link 		http://example.com
 * @since 		1.0.0
 *
 * @package 	WP_Style_Guide
 * @subpackage 	WP_Style_Guide/classes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since 		1.0.0
 * @package 	WP_Style_Guide
 * @subpackage 	WP_Style_Guide/classes
 * @author 		Chris Wilcoxson <chris@slushman.com>
 * http://example.com
 */
class WP_Style_Guide {

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WP_Style_Guide 	$_instance 		Instance singleton.
	 */
	protected static $_instance;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WP_Style_Guide_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->load_dependencies();
		$this->set_locale();
		$this->define_public_hooks();
		$this->define_template_hooks();
		$this->define_shortcode_hooks();

	} // __construct()

	/**
	 * Creates an instance of the sanitizer and the loader, which will be used to
	 * register the hooks with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$this->loader = new WP_Style_Guide_Loader();

		/**
		 * The class responsible for all global functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/global-functions.php';

	} // load_dependencies()

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WP_Style_Guide_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WP_Style_Guide_i18n();

		$this->loader->action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	} // set_locale()

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WP_Style_Guide_Public();

		$this->loader->action( 'wp_enqueue_scripts', 	$plugin_public, 'enqueue_styles' );
		$this->loader->action( 'wp_loaded', 			$plugin_public, 'register_sidebar' );
		$this->loader->action( 'init', 					$plugin_public, 'create_styleguide_page' );

	} // define_public_hooks()

	/**
	 * Register all of the hooks related to the processing shortcodes.
	 *
	 * Creates an action hook and shortcode using the same function.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_shortcode_hooks() {

		$shortcodes = array( 'wpstyleguide' );

		foreach ( $shortcodes as $shortcode ) {

			$class_name 	= 'WP_Style_Guide_Shortcode_' . $shortcode;
			$shortcode_obj 	= new $class_name();
			$function 		= strtolower( $shortcode );

			$this->loader->shortcode( $function, $shortcode_obj, 'shortcode_' . $function );
			$this->loader->action( $function, $shortcode_obj, 'shortcode_' . $function );

		}

	} // define_shortcode_hooks()

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_template_hooks() {

		$plugin_templates = new WP_Style_Guide_Templates();

		$this->loader->action( 'wp-style-guide-output',	$plugin_templates, 'add_intro', 5 );
		$this->loader->action( 'wp-style-guide-output',	$plugin_templates, 'add_toc', 10 );
		$this->loader->action( 'wp-style-guide-output',	$plugin_templates, 'add_headers', 15 );
		$this->loader->action( 'wp-style-guide-output',	$plugin_templates, 'add_structural', 20 );
		$this->loader->action( 'wp-style-guide-output',	$plugin_templates, 'add_semantic', 25 );
		$this->loader->action( 'wp-style-guide-output',	$plugin_templates, 'add_lists', 30 );
		$this->loader->action( 'wp-style-guide-output',	$plugin_templates, 'add_tables', 35 );
		$this->loader->action( 'wp-style-guide-output',	$plugin_templates, 'add_forms_and_fields', 40 );
		$this->loader->action( 'wp-style-guide-output',	$plugin_templates, 'add_buttons', 45 );
		$this->loader->action( 'wp-style-guide-output',	$plugin_templates, 'add_media', 50 );
		$this->loader->action( 'wp-style-guide-output',	$plugin_templates, 'add_widgets', 55 );

	} // define_template_hooks()

	/**
	 * Get instance of main class
	 *
	 * @since 		1.0.0
	 * @return 		WP_Style_Guide
	 */
	public static function get_instance() {

		if ( empty( self::$_instance ) ) {

			self::$_instance = new self;

		}

		return self::$_instance;

	} // get_instance()

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		$this->loader->run();

	} // run()

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 *
	 * @return    WP_Style_Guide_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {

		return $this->loader;

	} // get_loader()

} // class
