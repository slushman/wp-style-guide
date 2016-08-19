<?php
/**
 * Deleted Text
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Deleted Text', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Shows deleted or retracted text, usually followed by the updated or corrected text. Has a datetime attribute for timestamping the change.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['del'] = array( 'datetime' => array() );
		$allowed['ins'] = array( 'datetime' => array() );

		echo wp_kses(
			__( 'He won <del datetime="2012-02-05">7</del> <ins datetime="2014-02-05">2</ins> world titles.', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
