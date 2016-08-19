<?php
/**
 * Abbreviation
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Abbreviation', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'For any abbreviation, acronym, initialism, etc. Text in the title attribute will appear in the mouseover text.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['abbr'] = array( 'title' => array() );

		echo wp_kses(
			__( 'The space shuttle was launched by <abbr title="National Aeronautics and Space Administration">NASA</abbr>.', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
