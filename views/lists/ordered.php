<?php
/**
 * Ordered List.
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Ordered List', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'A list with a definte order, like a procedure.', 'wp-style-guide' );

	?></p>
	<span class="item-example">
		<ol>
			<li><?php esc_html_e( 'Type the item', 'wp-style-guide' ); ?></li>
			<li><?php esc_html_e( 'Type the second item', 'wp-style-guide' ); ?>
				<ol>
					<li><?php esc_html_e( 'Leave out extra spaces', 'wp-style-guide' ); ?></li>
					<li><?php esc_html_e( 'Add indentation', 'wp-style-guide' ); ?></li>
				</ol>
			</li>
			<li><?php esc_html_e( 'Type the third item', 'wp-style-guide' ); ?></li>
		</ol>
	</span>
</div><!-- End of style item -->
