<?php
/**
 * Figures
 */

?><div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Figure, image', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Specifies self-contained content, like illustrations, diagrams, photos, code listings, etc.', 'wp-style-guide' );

	?></p>
	<span class="item-example">
		<figure>
			<img src="<?php echo esc_url( plugin_dir_url( WPSTYLEGUIDE_FILE ) . 'assets/images/figure_test_picture.jpg' ); ?>" alt="Figure test picture" />
		</figure>
	</span>
</div><!-- End of style item -->
<div class="style-item">
	<h3 class="item-title"><?php esc_html_e( 'Figure, image with caption', 'wp-style-guide' ); ?></h3>
	<p class="item-description"><?php

		esc_html_e( 'Specifies self-contained content, like illustrations, diagrams, photos, code listings, etc.', 'wp-style-guide' );

	?></p>
	<span class="item-example">
		<figure>
			<img src="<?php echo esc_url( plugin_dir_url( WPSTYLEGUIDE_FILE ) . 'assets/images/figure_test_picture.jpg' ); ?>" alt="Figure test picture" />
			<figcaption>
				<cite>
					<a href="http://www.flickr.com/photos/vespa_freak/7733798164/"><?php

						esc_html_e( 'Wheels 2', 'wp-style-guide' );

					?></a>
				</cite> <?php esc_html_e( 'by Mike Kuusela', 'wp-style-guide' ); ?></figcaption>
		</figure>
	</span>
</div><!-- End of style item -->
