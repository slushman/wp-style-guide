<?php
/**
 * The semantic tags content
 */

if ( empty( $semantics ) ) { return; }

?><section class="style-section" id="semantic">
	<h2 class="section-title"><?php esc_html_e( 'Semantic Tags', 'wp-style-guide' ); ?> <a class="backtotoplink" href="#"><?php esc_html_e( 'Back to top', 'wp-style-guide' ); ?></a></h2>
	<p class="section-description"><?php esc_html_e( 'Semantic tags clearly describe the meaning of information to both the browser and the developer.', 'wp-style-guide' ); ?></p><?php

	foreach ( $semantics as $semantic ) {

		include wp_style_guide_get_template( $semantic, 'semantic' );

	} // foreach loop

?></section><!-- .style-section -->
