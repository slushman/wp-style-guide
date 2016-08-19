<?php
/**
 * Variable
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Variable', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Denote a variable in a mathematical expression or programming context, but can also be used to indicate a placeholder where the contents should be replaced with your own value.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['var'] = array();

		echo wp_kses(
			__( 'We determined the Towers of Hanoi problem would be solved in <var>n</var> moves, based on the number of disks.', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
