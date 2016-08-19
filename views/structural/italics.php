<?php
/**
 * Italics
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Italics', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Used for offsetting text, possibly to change the mood or voicing.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['i'] = array();

		echo wp_kses( __( '<i>This</i> should be in italics.', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
