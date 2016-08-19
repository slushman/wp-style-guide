<?php
/**
 * Definition List.
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Definition List', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'For lists of terms (use the dt tag) and their descriptions (use the dd tag), although it can be used anywhere a parent/child relationship needs to be represented.', 'wp-style-guide' );

	?></p>
	<span class="item-example">
		<dl>
			<dt><?php esc_html_e( 'Ratio', 'wp-style-guide' ); ?></dt>
				<dd><?php esc_html_e( 'A relationship between two numbers of the same kind', 'wp-style-guide' ); ?></dd>
			<dt><?php esc_html_e( 'Fraction', 'wp-style-guide' ); ?></dt>
				<dd><?php esc_html_e( 'Represents a part of a whole or, more generally, any number of equal parts', 'wp-style-guide' ); ?></dd>
		</dl>
	</span>
</div><!-- End of style item -->
