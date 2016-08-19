<?php
/**
 * Time
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Time', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Represents time on a 24-hour clock or a date on the Gregorian calendar, optionally with a time-zone offset. Use the datetime attribute for specifying the date and time (more specifically than the text inside the time tag).', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['time'] = array( 'datetime' => array() );

		echo wp_kses(
			__( 'Livingstone, born in <time datetime="1813-03-19">1813</time>, came on board late in the journey.', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
