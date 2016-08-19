<?php
/**
 * Sample Output
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Sample Output', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Represents output from a computer program.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['samp'] = array();

		echo wp_kses(
			__( 'We kept getting the error message <samp>Headers already sent.</samp>', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
