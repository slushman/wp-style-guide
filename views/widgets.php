<?php
/**
 * WordPress Widgets
 */
?><section class="style-section" id="widgets">
	<h2 class="section-title"><?php esc_html_e( 'Widgets', 'wp-style-guide' ); ?> <a class="backtotoplink" href="#"><?php esc_html_e( 'Back to top', 'wp-style-guide' ); ?></a></h2>
	<p class="section-description"><?php esc_html_e( 'These are the default widgets included with WordPress.', 'wp-style-guide' ); ?></p>
	<span class="item-example"><?php

		the_widget( 'WP_Widget_Archives' );
		the_widget( 'WP_Widget_Calendar', array( 'title' => 'Calendar' ) );
		the_widget( 'WP_Widget_Categories' );
		the_widget( 'WP_Widget_Meta' );
		the_widget( 'WP_Widget_Pages' );
		the_widget( 'WP_Widget_Recent_Comments' );
		the_widget( 'WP_Widget_Recent_Posts' );
		the_widget( 'WP_Widget_RSS', array( 'title' => 'Slushman Design', 'url' => 'http://slushman.com/feed/', 'items' => 3 ) );
		the_widget( 'WP_Widget_Search' );
		the_widget( 'WP_Widget_Tag_Cloud' );
		the_widget( 'WP_Widget_Text', array( 'title' => 'Text Widget', 'text' => 'This is a text widget.' ) );

	?></span>
</section><!-- .style-section -->
