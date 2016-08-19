<?php
/**
 * Citation
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Citation', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Defines the title of a work.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['cite'] = array( 'title' => array() );

		echo wp_kses(
			__( '<cite>Black</cite>, The Circle Trilogy, by Ted Dekker.', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
