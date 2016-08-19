<?php
/**
 * Emphasis
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Emphasis', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Something pronounced differently for stressing importance.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['em'] = array();

		echo wp_kses(
			__( 'This is just an <em>example</em> of emphasis.', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
