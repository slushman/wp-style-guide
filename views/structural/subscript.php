<?php
/**
 * Subscript
 *
 * NOTE: the example content does not need translation.
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Subscript', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Used for subscripts, where the text appears half a character below the baseline - like chemical formulas.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['sub'] = array();

		echo wp_kses(
			__( 'The doctor advised I drink 10 glasses of h<sub>2</sub>0 per day.', 'wp-style-guide' ),
			$allowed
		);

	?></span>
</div><!-- End of style item -->
