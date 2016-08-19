<?php
/**
 * Strikethrough
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Strikethrough', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Used for content no longer accurate or relevant.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['s'] = array();

		echo wp_kses(
			__( 'His performance was <s>legendary</s> a complete disaster!', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
