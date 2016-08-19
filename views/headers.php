<?php
/**
 * The headers
 */

if ( empty( $headers ) ) { return; }

?><section class="style-section" id="headers">
	<h2 class="section-title"><?php esc_html_e( 'Headers', 'wp-style-guide' ); ?><a class="backtotoplink" href="#"><?php esc_html_e( 'Back to top', 'wp-style-guide' ); ?></a></h2>
	<p class="section-description"><?php esc_html_e( 'Header elements follow a nested a hierarchy, like a outline. The top header is the h1, or Header 1, and there is only one h1 per page. The other headers are nested inside each other, so an h2 can only have h3s under it and h3s can only have h4s under it. Most of the time, headers are used for content like titles, subheaders, or section titles.', 'wp-style-guide' ); ?></p>
	<dl>
		<dt><h1><?php esc_html_e( 'First-level Header', 'wp-style-guide' ); ?></h1></dt>
			<dd><?php esc_html_e( 'For the most important elements, like page and post titles.', 'wp-style-guide' ); ?></dd>
		<dt><h2><?php esc_html_e( 'Second-level Header', 'wp-style-guide' ); ?></h2></dt>
			<dd><?php esc_html_e( 'For content like sub-headers.', 'wp-style-guide' ); ?></dd>
		<dt><h3><?php esc_html_e( 'Third-level Header', 'wp-style-guide' ); ?></h3></dt>
			<dd><?php esc_html_e( 'For content headers lower in the hierarchy than the h2.', 'wp-style-guide' ); ?></dd>
		<dt><h4><?php esc_html_e( 'Fourth-level Header', 'wp-style-guide' ); ?></h4></dt>
			<dd><?php esc_html_e( 'For content headers lower in the hierarchy than the h3.', 'wp-style-guide' ); ?></dd>
		<dt><h5><?php esc_html_e( 'Fifth-level Header', 'wp-style-guide' ); ?></h5></dt>
			<dd><?php esc_html_e( 'For content headers lower in the hierarchy than the h4.', 'wp-style-guide' ); ?></dd>
		<dt><h6><?php esc_html_e( 'Sixth-level Header', 'wp-style-guide' ); ?></h6></dt>
			<dd><?php esc_html_e( 'For content headers lower in the hierarchy than the h5.', 'wp-style-guide' ); ?></dd>
	</dl>
</section><!-- .style-section -->
