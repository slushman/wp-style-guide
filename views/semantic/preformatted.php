<?php
/**
 * Pre-formatted Text
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Pre-formatted Text', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Represents a block of pre-formatted text, in which structure is represented by typographic conventions rather than by elements. Such examples are an e-mail (with paragraphs indicated by blank lines, lists indicated by lines prefixed with a bullet), fragments of computer code (with structure indicated according to the conventions of that language) or displaying ASCII art.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['pre'] = array();

		echo wp_kses(
			__( '<pre>Text in a pre element
			is displayed in a fixed-width
			font, and it preserves
			both	  tabs, spaces and
			line breaks</pre>', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
