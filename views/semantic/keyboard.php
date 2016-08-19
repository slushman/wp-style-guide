<?php
/**
 * Keyboard Entry
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Keyboard Entry', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Defines keyboard input.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['kbd'] = array();

		echo wp_kses(
			__( 'When you reach the screen, enter <kbd>kbsfv7y)(&yhskn</kbd> and you will be logged in.', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
