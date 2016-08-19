<?php
/**
 * The table of contents
 */

?><h2 class="toc-header"><?php esc_html_e( 'Table of Contents', 'wp-style-guide' ); ?></h2>
	<ul><?php

	foreach ( $groups as $group ) {

		$capped = ucwords( str_replace( '_', ' ', $group ) );
		?><li><a href="#<?php echo esc_attr( $group ); ?>"><?php echo esc_html( $capped ); ?></a></li><?php

	} // $items foreach loop

	?></ul>
</section><!-- .top-section -->
