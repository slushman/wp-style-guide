<?php
/**
 * Strong
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Strong', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Denotes importance.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['strong'] = array();

		echo wp_kses(
			__( 'I said <strong>do not</strong> hit your brother!', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
