<?php
/**
 * Small Print
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Small Print', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Small print is mostly used for copyright notices, disclaimers, cattributions, etc. Anything considered "the fine print".', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['samp'] = array();

		echo wp_kses(
			__( 'Copyright ABC Corp. <small>All rights reserved.</small>', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
