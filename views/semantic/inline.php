<?php
/**
 * Inline Quotes
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Inline Quotes', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Used for quoting inline, rather than setting the quote apart like a blockquote.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['q'] = array();

		echo wp_kses(
			__( 'The signs were all there.<q>This is impossible,</q>stated the detective.', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
