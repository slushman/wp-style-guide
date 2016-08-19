<?php
/**
 * Definition
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Definition', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Highlight the first use of a term. Use the title attribute to describe/define the term.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['dfn'] = array( 'title' => array() );

		echo wp_kses(
			__( 'Walter <dfn title="said nothing">acquiesced</dfn> to Phyllis though her statement was inaccurate.', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
