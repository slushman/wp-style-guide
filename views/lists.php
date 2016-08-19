<?php
/**
 * HTML Lists
 */

if ( empty( $lists ) ) { return; }

?><section class="style-section" id="lists">
	<h2 class="section-title"><?php esc_html_e( 'Lists', 'wp-style-guide' ); ?> <a class="backtotoplink" href="#"><?php esc_html_e( 'Back to top', 'wp-style-guide' ); ?></a></h2>
	<p class="section-description"><?php esc_html_e( 'Lists help organize data. They can be ordered or unordered and they can be nested.', 'wp-style-guide' ); ?></p><?php

	foreach ( $lists as $list ) {

		include wp_style_guide_get_template( $list, 'lists' );

	} // foreach loop

?></section><!-- .style-section -->
