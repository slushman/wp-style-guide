<?php
/**
 * Inserted Text
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Inserted Text', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Shows corrected or updated text, usually alongside the deleted or retracted text. Has a datetime attribute for timestamping the change.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['del'] = array( 'datetime' => array() );
		$allowed['ins'] = array( 'datetime' => array() );

		echo wp_kses(
			__( 'He won <del datetime="2012-02-05">7</del><ins datetime="2014-02-05">2</ins> world titles.', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
