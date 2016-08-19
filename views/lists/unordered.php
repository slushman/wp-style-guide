<?php
/**
 * Unordered List.
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Unordered List', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'A list without a defined order.', 'wp-style-guide' );

	?></p>
	<span class="item-example">
		<ul>
			<li>Gandolf</li>
			<li>The Shirelings
				<ul>
					<li>Samwise Gamgee</li>
					<li>Frodo Baggins</li>
				</ul>
			</li>
			<li>Aragorn</li>
		</ul>
	</span>
</div><!-- End of style item -->
