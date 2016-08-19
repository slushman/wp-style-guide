<?php
/**
 * HTML Forms
 */

?><section class="style-section" id="forms_and_fields">
	<h2 class="section-title"><?php esc_html_e( 'Forms and Fields', 'wp-style-guide' ); ?> <a class="backtotoplink" href="#"><?php esc_html_e( 'Back to top', 'wp-style-guide' ); ?></a></h2>
	<p class="section-description"><?php esc_html_e( 'Forms can be used when you wish to collect data from users. The fieldset element enables you to group related fields within a form, like a set of checkboxes, and each one should contain a corresponding legend. The label element ensures field descriptions are associated with their corresponding form widgets.', 'wp-style-guide' ); ?></p>
	<span class="item-example">
		<form action="#">
			<p><label for="text"><?php esc_html_e( 'Text Input', 'wp-style-guide' ); ?> <abbr title="Required">*</abbr></label>
			<input id="text" class="text" type="text"/>
			<span class="description"><?php esc_html_e( 'Description of this field', 'wp-style-guide' ); ?></span></p>

			<p><label for="password"><?php esc_html_e( 'Password', 'wp-style-guide' ); ?><abbr title="Required">*</abbr></label>
			<input id="password" class="text" type="password"/>
			<span class="description"><?php esc_html_e( 'Description of this field', 'wp-style-guide' ); ?></span></p>

			<p><label for="url"><?php esc_html_e( 'Web Address', 'wp-style-guide' ); ?><abbr title="Required">*</abbr></label>
			<input id="url" class="text" type="url"/>
			<span class="description"><?php esc_html_e( 'Description of this field', 'wp-style-guide' ); ?></span></p>

			<p><label for="email"><?php esc_html_e( 'Email Address', 'wp-style-guide' ); ?><abbr title="Required">*</abbr></label>
			<input id="email" class="text" type="email"/>
			<span class="description"><?php esc_html_e( 'Description of this field', 'wp-style-guide' ); ?></span></p>

			<p><label for="search"><?php esc_html_e( 'Search', 'wp-style-guide' ); ?><abbr title="Required">*</abbr></label>
			<input id="search" class="text" type="search"/><input id="search_button" class="search button" type="submit" value="Search" />
			<span class="description"><?php esc_html_e( 'Description of this field', 'wp-style-guide' ); ?></span></p>

			<p><label for="search"><?php esc_html_e( 'Textarea', 'wp-style-guide' ); ?><abbr title="Required">*</abbr></label>
			<textarea id="textarea" rows="8" cols="48"></textarea>
			<span class="description"><?php esc_html_e( 'Description of this field', 'wp-style-guide' ); ?></span></p>

			<p><label for="checkbox"><?php esc_html_e( 'Single Checkbox', 'wp-style-guide' ); ?></label>
			<label for="checkbox" class="check">
			<input id="checkbox" type="checkbox" class="checkbox"/> <?php esc_html_e( 'Label', 'wp-style-guide' ); ?></label></p>

			<p><label for="select"><?php esc_html_e( 'Select', 'wp-style-guide' ); ?></label>
			<select id="select">
				<optgroup label="Option Group">
					<option><?php esc_html_e( 'Option One', 'wp-style-guide' ); ?></option>
					<option><?php esc_html_e( 'Option Two', 'wp-style-guide' ); ?></option>
					<option><?php esc_html_e( 'Option Three', 'wp-style-guide' ); ?></option>
				</optgroup>
			</select>
			<span class="description"><?php esc_html_e( 'Description of this field', 'wp-style-guide' ); ?></span></p>

			<fieldset class="options">
			<legend><?php esc_html_e( 'Checkbox Group Legend', 'wp-style-guide' ); ?> <abbr title="Required">*</abbr></legend>
			<ul>
				<li><label for="checkbox1"><input id="checkbox1" name="checkbox" type="checkbox" checked="checked" /> <?php esc_html_e( 'Choice A', 'wp-style-guide' ); ?></label></li>
				<li><label for="checkbox2"><input id="checkbox2" name="checkbox" type="checkbox" /> <?php esc_html_e( 'Choice B', 'wp-style-guide' ); ?></label></li>
				<li><label for="checkbox3"><input id="checkbox3" name="checkbox" type="checkbox" /> <?php esc_html_e( 'Choice C', 'wp-style-guide' ); ?></label></li>
			</ul>
			</fieldset>

			<fieldset class="options">
			<legend><?php esc_html_e( 'Radio Legend', 'wp-style-guide' ); ?><abbr title="Required">*</abbr></legend>
			<ul>
				<li><label for="radio1"><input id="radio1" name="radio" type="radio" class="radio" checked="checked" /> <?php esc_html_e( 'Option 1', 'wp-style-guide' ); ?></label></li>
				<li><label for="radio2"><input id="radio2" name="radio" type="radio" class="radio" /> <?php esc_html_e( 'Option 2', 'wp-style-guide' ); ?></label></li>
			</ul>
			</fieldset>
		</form>
	</span>
</section><!-- .style-section -->
