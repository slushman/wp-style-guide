<?php
/**
 * WP Style Guide: creates a style guide for designers and their clients.
 *
 * @package 	WP Style Guide
 * @author    	Slushman <chris@slushman.com>
 * @copyright 	Copyright (c) 2016, Slushman
 * @license   	GPL-2.0+
 * @license   	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link      	http://slushman.com/plugins/wp-style-guide
 * @version   	0.1
 *
 * @wordpress-plugin
 * Plugin Name: 		WP Style Guide
 * Plugin URI: 			http://slushman.com/plugins/wp-style-guide
 * Description: 		Creates a style guide for designers and their clients.
 * Version: 			0.1
 * Author: 				Slushman
 * Author URI: 			http://slushman.com
 * Text Domain: 		wp-style-guide
 * Domain Path: 		/languages
 * Github Plugin URI: 	https://github.com/slushman/wp-style-guide
 *
 * @todo 	Add WP photo gallery - maybe multiple columns layouts
 * @todo 	Add navigation - older/newer, post navi, numbered, etc
 * @todo 	Add breadcrumbs, jetpack breadcrumbs, Yoast Breadcrumbs, etc
 * @todo  	Add sidebar with all default WP widgets
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Define constants
 */
define( 'WPSTYLEGUIDE_VERSION', '1.0.0' );
define( 'WPSTYLEGUIDE_SLUG', 'wp-style-guide' );
define( 'WPSTYLEGUIDE_FILE', plugin_basename( __FILE__ ) );

/**
 * Activation/Deactivation Hooks
 */
register_activation_hook( __FILE__, array( 'WP_Style_Guide_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP_Style_Guide_Deactivator', 'deactivate' ) );

/**
 * Autoloader function
 *
 * Will search both plugin root and includes folder for class
 *
 * @param string $class_name
 */
if ( ! function_exists( 'wp_style_guide_autoloader' ) ) :

	function wp_style_guide_autoloader( $class_name ) {

		$class_name = str_replace( 'WP_Style_Guide_', '', $class_name );
		$lower 		= strtolower( $class_name );
		$file      	= 'class-' . str_replace( '_', '-', $lower ) . '.php';
		$base_path 	= plugin_dir_path( __FILE__ );
		$paths[] 	= $base_path . $file;
		$paths[] 	= $base_path . 'classes/' . $file;

		/**
		 * wp_style_guide_autoloader_paths filter
		 */
		$paths = apply_filters( 'wp-style-guide-autoloader-paths', $paths );

		foreach ( $paths as $path ) :

			if ( is_readable( $path ) && file_exists( $path ) ) {

				require_once( $path );
				return;

			}

		endforeach;

	} // wp_style_guide_autoloader()

endif;

spl_autoload_register( 'wp_style_guide_autoloader' );

if ( ! function_exists( 'wp_style_guide' ) ) :

	/**
	 * Function wrapper to get instance of plugin
	 *
	 * @return WP_Style_Guide
	 */
	function wp_style_guide() {

		return WP_Style_Guide::get_instance();

	} // wp_style_guide()

endif;

if ( ! function_exists( 'wp_style_guide_init' ) ) :

	/**
	 * Function to initialize plugin
	 */
	function wp_style_guide_init() {

		wp_style_guide()->run();

	}

	add_action( 'plugins_loaded', 'wp_style_guide_init' );

endif;
