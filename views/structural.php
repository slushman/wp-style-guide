<?php
/**
 * The structural tags content
 */

if ( empty( $structurals ) ) { return; }

?><section class="style-section" id="structural">
	<h2 class="section-title"><?php esc_html_e( 'Structural Tags', 'wp-style-guide' ); ?> <a class="backtotoplink" href="#"><?php esc_html_e( 'Back to top', 'wp-style-guide' ); ?></a></h2>
	<p class="section-description"><?php esc_html_e( 'Structural tags describe the layout of a page.', 'wp-style-guide' ); ?></p><?php

	foreach ( $structurals as $structural ) {

		include wp_style_guide_get_template( $structural, 'structural' );

	} // foreach loop

?></section><!-- .style-section -->
