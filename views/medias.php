<?php
/**
 * HTML Media
 */

if ( empty( $medias ) ) { return; }

?><section class="style-section" id="media">
	<h2 class="section-title"><?php esc_html_e( 'Media', 'wp-style-guide' ); ?> <a class="backtotoplink" href="#"><?php esc_html_e( 'Back to top', 'wp-style-guide' ); ?></a></h2>
	<p class="section-description"></p><?php

	foreach ( $medias as $media ) {

		include wp_style_guide_get_template( $media, 'media' );

	} // foreach loop

?></section><!-- .style-section -->
