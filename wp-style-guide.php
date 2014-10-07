<?php
/**
 * WP Style Guide: creates a style guide for designers and their clients.
 *
 * Loosely based on the WordPress Plugin Boilerplate by Tom McFarlin
 *
 * @package 	WP Style Guide
 * @author    	Slushman <chris@slushman.com>
 * @copyright 	Copyright (c) 2014, Slushman
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

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/**
 * Includes the plugin class file
 */
require_once( plugin_dir_path( __FILE__ ) . 'classes/class-wp-style-guide.php' );

/**
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 * Activations errors are saved as a plugin option
 */
register_activation_hook( __FILE__, array( 'Slushman_WP_Style_Guide', 	'activate' ) );
register_deactivation_hook( __FILE__, array( 'Slushman_WP_Style_Guide', 'deactivate' ) );

/**
 * Loads the plugin instance when plugins are loaded
 */
add_action( 'plugins_loaded', array( 'Slushman_WP_Style_Guide', 'get_instance' ) );



/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/**
 * Includes the admin file and loads the instance of it when the plugins are loaded.
 */
/*if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'classes/class-admin-wpsg.php' );

	add_action( 'plugins_loaded', array( 'WP_Style_Guide_Admin', 'get_instance' ) );

} // admin check*/
