<?php

/**
 * Class for creating a shortcode.
 */

class WP_Style_Guide_Shortcode_wpstyleguide {

	/**
	 * Constructor.
	 */
	public function __construct(){}

	/**
	 * Returns the output of the wp-style-guide-output action hook.
	 *
	 * @hooked 		add_shortcode
	 * @param 		array 		$atts 			Shortcode attributes
	 * @param 		mixed 		$content 		The page content
	 * @return 		mixed 						The shortcode output.
	 */
	public function shortcode_wpstyleguide( $atts, $content = null ) {

		$defaults 	= array();
		$atts 		= shortcode_atts( $defaults, $atts );

		ob_start();

		do_action( 'wp-style-guide-output' );

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	} // shortcode_wpstyleguide()

} // class
