<?php
/**
 * HTML Table
 */

?><section class="style-section" id="table">
	<h2 class="section-title"><?php esc_html_e( 'Table', 'wp-style-guide' ); ?> <a class="backtotoplink" href="#"><?php esc_html_e( 'Back to top', 'wp-style-guide' ); ?></a></h2>
	<p class="section-description"><?php esc_html_e( 'Tables should be used when displaying tabular data. The thead, tfoot and tbody elements enable you to group rows within each a table. If you use these elements, you must use every element. They should appear in this order: thead, tfoot and tbody, so that browsers can render the foot before receiving all the data. You must use these tags within the table element.', 'wp-style-guide' ); ?></p>
	<span class="item-example">
		<table>
			<thead>
				<tr>
					<th><?php esc_html_e( 'Column 1', 'wp-style-guide' ); ?></th>
					<th><?php esc_html_e( 'Column 2', 'wp-style-guide' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php esc_html_e( 'Row 1, Col 1', 'wp-style-guide' ); ?></td>
					<td><?php esc_html_e( 'Row 1, Col 2', 'wp-style-guide' ); ?></td>
				</tr>
				<tr>
					<td><?php esc_html_e( 'Row 2, Col 1', 'wp-style-guide' ); ?></td>
					<td><?php esc_html_e( 'Row 2, Col 2', 'wp-style-guide' ); ?></td>
				</tr>
				<tr>
					<td><?php esc_html_e( 'Row 3, Col 1', 'wp-style-guide' ); ?></td>
					<td><?php esc_html_e( 'Row 3, Col 2', 'wp-style-guide' ); ?></td>
				</tr>
			</tbody>
		</table>
	</span>
</section><!-- .style-section -->
