<?php
/**
 * Address
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Address', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Used for defining the contact information for the owner of the document or article.', 'wp-style-guide' );

	?></p>
	<span class="item-example"><?php

		$allowed['address'] = array();
		$allowed['br'] 		= array();

		echo wp_kses(
			__( '<address>Acme Corp	<br />PO Box 12345 <br />Nashville, TN 37212</address>', 'wp-style-guide' ), $allowed );

	?></span>
</div><!-- End of style item -->
