<?php
/**
 * Superscript
 *
 * NOTE: the example content does not need translation.
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Superscript', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Used for superscripts, where the text appear half a character above the baseline - like footnotes or mathematic notation.', 'wp-style-guide' );

	?></p>
	<span class="item-example">
		<p><?php

			$allowed['sup'] = array();

			echo wp_kses(
				__( 'The anomoly occured as many as log<sup>8</sup> times per day.', 'wp-style-guide' ),
				$allowed
			);

		?></span>
</div><!-- End of style item -->
