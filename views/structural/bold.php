<?php
/**
 * Bold
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Bold / Embolden', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Conveys extra importance or a keyword (product name in a review, etc). Should be used as a last resort.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['b'] = array();

		echo wp_kses( __( 'It was the <b>curtains</b> she liked.', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
