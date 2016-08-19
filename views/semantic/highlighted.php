<?php
/**
 * Marked / Highlighted Text
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Marked / Highlighted Text', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'For text marked or highlighted for reference purposes. When used in a quotation it indicates a highlight not originally present but added to bring the reader’s attention to that part of the text. When used in the main prose of a document, it indicates a part of the document that has been highlighted due to its relevance to the user’s current activity', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['mark'] = array();

		echo wp_kses(
			__( 'I kept trying to reiterate that the <mark>jewels</mark> were what were stolen.', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
