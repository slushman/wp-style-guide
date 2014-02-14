<?php

/*
Plugin Name: WP Style Guide
Plugin URI: http://slushman.com/plugins/wp-style-guide
Description: Creates a style guide for designers and their clients.
Version: 0.1
Text Domain: wp-style-guide
Domain Path: /languages
Author: Slushman
Author URI: http://slushman.com
License: GPLv2

**************************************************************************

  Copyright (C) 2014 Slushman

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General License for more details.

  You should have received a copy of the GNU General License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

**************************************************************************

*/

if ( !class_exists( 'Slushman_WP_Style_Guide' ) ) { //Start Class

	class Slushman_WP_Style_Guide {
  
		public static $instance;

/**
 * Constructor
 */ 
		function __construct() {
	
			self::$instance = $this;

			// Include the config file
			require_once( plugin_dir_path( __FILE__ ) . 'inc/config.php' );

			// Runs when plugin is activated
			register_activation_hook( __FILE__, array( $this, 'install' ) );

			// Save an errors from the plugin activation
			add_action( 'activated_plugin', array( $this, 'save_activation_error' ) );

			// Enqueue stylesheets
			add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ) );

			// Create shortcode [wpstyleguide]
			add_shortcode( 'wpstyleguide', array( $this, 'shortcode' ) );

			// i18n
			add_action( 'init', array( $this, 'i18n_init' ) );

		} // End of __construct()

/**
 * Creates the plugin settings
 *
 * Creates an array containing each setting and sets the default values to blank.
 * Then saves the array in the plugin option.
 *
 * @since   0.1
 * 
 * @uses	settings_init
 */ 
		function install() {

			$this->create_style_page();

		} // End of install()

		function save_activation_error() {
		
			update_option( 'plugin_error',  ob_get_contents() );
		
		} // End of save_activation_error()



/* ==========================================================================
   Internationalization and Localization
   ========================================================================== */

		function i18n_init() {

			load_plugin_textdomain( $this->constants['i18n'], false, basename( dirname( __FILE__ ) ) . '/languages' );

		} // End of i18n_init()



/* ==========================================================================
   Styles and Scripts
   ========================================================================== */		
		
/**
 * Registers all the styles and enqueues the public-facing style
 *
 * @uses	wp_register_style
 * @uses	plugins_url
 * @uses	wp_enqueue_style
 */
		function add_styles() {
			
			wp_register_style( $this->constants['slug'], plugins_url( 'css/style.css', __FILE__ ) );
			wp_enqueue_style( $this->constants['slug'] );
			
		} // End of add_styles()



/* ==========================================================================
   Plugin Functions
   ========================================================================== */

/**
 * [create_style_page description]
 * @return [type] [description]
 */
		function create_style_page() {

			$post['post_content']   = '[wpstyleguide]';
			$post['post_name']		= 'style-guide';
			$post['post_title']		= 'Style Guide';
			$post['post_status']	= 'publish';
			$post['post_type']		= 'page';
			$post['ping_status']	= 'closed';
			$post['comment_status'] = 'closed';

			

			$check = get_page_by_title( $post['post_title'] );

			if ( empty( $check->ID ) ) {

				$page_ID = wp_insert_post( $post );

				if ( $page_ID ) {

					$this->add_comments( $page_ID );

				} // End of $page_ID check

			} // End of ID check

		} // End of create_style_page()


		function add_comments( $page_ID ) {

			$comment['comment_post_ID'] 		= $page_ID;
			$comment['comment_author'] 			= 'Commenter 1';
			$comment['comment_author_email']	= 'test@slushman.com';
			$comment['comment_author_url']		= 'http://slushman.com';
			$comment['comment_content']	 		= 'First comment!';
			$comment['comment_parent']	  		= 0;

			$comment_1_ID = wp_insert_comment( $comment );

			$comment['comment_post_ID'] 		= $page_ID;
			$comment['comment_author'] 			= 'Commenter 2';
			$comment['comment_author_email']	= 'test@slushman.com';
			$comment['comment_author_url']		= 'http://slushman.com';
			$comment['comment_content']	 		= 'Second comment!';
			$comment['comment_parent']	  		= 0;

			$comment_2_ID = wp_insert_comment( $comment );

			if ( $comment_2_ID ) {

				$comment['comment_post_ID'] 		= $page_ID;
				$comment['comment_author'] 			= 'Commenter 3';
				$comment['comment_author_email']	= 'test@slushman.com';
				$comment['comment_author_url']		= 'http://slushman.com';
				$comment['comment_content']	 		= 'First nested comment for comment 2.';
				$comment['comment_parent']	  		= $comment_2_ID;

				$comment_3_ID = wp_insert_comment( $comment );

				if ( $comment_3_ID ) {

					$comment['comment_post_ID'] 		= $page_ID;
					$comment['comment_author'] 			= 'Commenter 4';
					$comment['comment_author_email']	= 'test@slushman.com';
		   			$comment['comment_author_url']		= 'http://slushman.com';
					$comment['comment_content']	 		= 'Nexted comment for the nested comment on comment 2.';
					$comment['comment_parent']	  		= $comment_3_ID;

					$comment_4_ID = wp_insert_comment( $comment );

				} // End of comment 3 ID check

			} // End of comment 2 ID check

			$comment['comment_post_ID'] 		= $page_ID;
			$comment['comment_author'] 			= 'Commenter 5';
			$comment['comment_author_email']	= 'test@slushman.com';
			$comment['comment_author_url']		= 'http://slushman.com';
			$comment['comment_content']	 		= 'Fifth comment!';
			$comment['comment_parent']	  		= 0;

			$comment_5_ID = wp_insert_comment( $comment );

		} // End of add_comments()

/**
 * [create_style_page description]
 * @return [type] [description]
 */
		function style_guide_page() {

			$i = 0;

			$styles['setup']['desc']	= 'Put your basic settings here - like base font size, base grid sizes, base line height, columns sizes, etc.';
			//$styles['colors']['desc']	= 'An exhaustive list of all the colors used on this site.';
			$styles['headers']['desc']	= 'Header elements have a hierarchy, the top being the h1, or Header 1. Most of the time, headers should be used for things like titles, subheaders, or section titles.';
			$styles['tags']['desc']		= '';
			$styles['lists']['desc']	= '';
			$styles['tables']['desc'] 	= 'Tables should be used when displaying tabular data. The thead, tfoot and tbody elements enable you to group rows within each a table.<br /><br />If you use these elements, you must use every element. They should appear in this order: thead, tfoot and tbody, so that browsers can render the foot before receiving all the data. You must use these tags within the table element.';
			$styles['forms']['desc']	= 'Forms can be used when you wish to collect data from users. The fieldset element enables you to group related fields within a form, like a set of checkboxes, and each one should contain a corresponding legend. The label element ensures field descriptions are associated with their corresponding form widgets.';
			$styles['media']['desc']	= '';
			$styles['patterns']['desc']	= '';
			$styles['buttons']['desc']	= '';

/***************

Setup

****************/


			$styles['setup'][$i]['title']		= 'Base Font Size';
			$styles['setup'][$i]['desc']		= 'The font size the rest of the site bases its measurements from. Equal to 1 em;';
			$styles['setup'][$i]['example']		= 'font-size: 16px;';
			$i++;

/*
			$styles['setup'][$i]['title']		= 'Base Grid Size';
			$styles['setup'][$i]['desc']		= 'The font size the rest of the site bases its measurements from. Equal to 1 em;';
			$styles['setup'][$i]['example']		= 'font-size: 16px;';
			$i++;
*/

			$styles['setup'][$i]['title']		= 'Base Line Height';
			$styles['setup'][$i]['desc']		= 'The line-height used for most of the site.';
			$styles['setup'][$i]['example']		= 'line-height: 1.5;';
			$i++;

/*
			$styles['setup'][$i]['title']		= '';
			$styles['setup'][$i]['desc']		= '';
			$styles['setup'][$i]['example']		= '';
			$i++;
*/

/***************

Colors

****************/

/*
			$styles['colors'][$i]['title']		= '';
			$styles['colors'][$i]['desc']		= '';
			$styles['colors'][$i]['example']	= '';
			$i++;
*/

/***************

Headers

****************/

			$styles['headers'][$i]['title']		= '';
			$styles['headers'][$i]['desc']		= '';
			$styles['headers'][$i]['example']	= '
				<h1>First-level header</h1>
					<p>For the most important elements, like page and post titles.</p>
				<h2>Second-level header</h2>
					<p>For items like sub-headers.</p>
				<h3>Third-level header</h3>
					<p>For page-level headers lower in the hierarchy than the h2.</p>
				<h4>Fourth-level header</h4>
					<p>For page-level headers lower in the hierarchy than the h3.</p>
				<h5>Fifth-level header</h5>
					<p>For page-level headers lower in the hierarchy than the h4.</p>
				<h6>Sixth-level header</h6>
					<p>For page-level headers lower in the hierarchy than the h5.</p>';
			$i++;

/***************

Tags

****************/

			$styles['tags'][$i]['title']	= 'Abbreviation';
			$styles['tags'][$i]['desc']		= 'For any abbreviation, acronym, initialism, etc. Text in the title attribute will appear in the mouseover text.';
			$styles['tags'][$i]['example']	= 'The shuttle was launched by <abbr title="National Aeronautics and Space Administration">NASA</abbr>.';
			$i++;

			$styles['tags'][$i]['title']	= 'Address';
			$styles['tags'][$i]['desc']		= 'Used for the formatting addresses.';
			$styles['tags'][$i]['example']	= '<address>Acme Corp<br />PO Box 12345<br />Nashville, TN 37212</address>';
			$i++;

			$styles['tags'][$i]['title']	= 'Blockquotes';
			$styles['tags'][$i]['desc']		= 'Represents a section that is being quoted from another source.';
			$styles['tags'][$i]['example']	= '<blockquote cite="http://www.worldwildlife.org/who/index.html">For 50 years, WWF has been protecting the future of nature. The world\'s leading conservation organization, WWF works in 100 countries and is supported by 1.2 million members in the United States and close to 5 million globally.</blockquote>';
			$i++;

			$styles['tags'][$i]['title']	= 'Bold / Embolden';
			$styles['tags'][$i]['desc']		= 'Conveys extra importance or a keyword (product name in a review, etc). Should be used as a last resort.';
			$styles['tags'][$i]['example']	= 'It was the <b>curtains</b> she liked.';
			$i++;

			$styles['tags'][$i]['title']	= 'Citation';
			$styles['tags'][$i]['desc']		= 'Used for the titles of a work.';
			$styles['tags'][$i]['example']	= '<cite>Black</cite>, The Circle Trilogy, by Ted Dekker.';
			$i++;

			$styles['tags'][$i]['title']	= 'Code';
			$styles['tags'][$i]['desc']		= 'Used to demonstrate fragments of computer code.';
			$styles['tags'][$i]['example']	= '<code>$var = $x . $y * 3;</code>';
			$i++;

			$styles['tags'][$i]['title']	= 'Definition';
			$styles['tags'][$i]['desc']		= 'Highlight the first use of a term. Use the title attribute to describe/define the term.';
			$styles['tags'][$i]['example']	= 'Walter <dfn title="said nothing">acquiesced</dfn> to Phyllis though her statement was inaccurate.';
			$i++;

			$styles['tags'][$i]['title']	= 'Deleted Text';
			$styles['tags'][$i]['desc']		= 'Shows deleted or retracted text, usually followed by the updated or corrected text. Has a datetime attribute for timestamping the change.';
			$styles['tags'][$i]['example']	= 'He won <del datetime="2012-02-05">7</del><ins datetime="2014-02-05">2</ins> world titles.';
			$i++;

			$styles['tags'][$i]['title']	= 'Emphasis';
			$styles['tags'][$i]['desc']		= 'Something pronounced differently for stressing importance.';
			$styles['tags'][$i]['example']	= 'This is just an <em>example</em> of emphasis.';
			$i++;

			$styles['tags'][$i]['title']	= 'Horizontal rule';
			$styles['tags'][$i]['desc']		= 'Represents a break in the reading, usually denotes going to another subject or a scene change.';
			$styles['tags'][$i]['example']	= '<p>Amanda was certain Jeff was not telling the truth. The document she just found in his desk proved he could not be trusted. But he had just left with her son and she was frozen with indecision.</p><hr><p>Jeff drove calmly through the winding streets of the Dallas suburb. The sun was still high enough in the sky that he had no use for the visors and folded his up against the ceiling of the car.</p>';
			$i++;

			$styles['tags'][$i]['title']	= 'Inline Quotes';
			$styles['tags'][$i]['desc']		= 'Used for quoting inline, rather than setting the quote apart like a blockquote.';
			$styles['tags'][$i]['example']	= 'The signs were all there.<q>This is impossible,</q>stated the detective.';
			$i++;

			$styles['tags'][$i]['title']	= 'Inserted Text';
			$styles['tags'][$i]['desc']		= 'Shows corrected or updated text, usually alongside the deleted or retracted text. Has a datetime attribute for timestamping the change.';
			$styles['tags'][$i]['example']	= 'He won <del datetime="2012-02-05">7</del><ins datetime="2014-02-05">2</ins> world titles.';
			$i++;

			$styles['tags'][$i]['title']	= 'Italics';
			$styles['tags'][$i]['desc']		= 'Used for offsetting text, possibly to change the mood or voicing.';
			$styles['tags'][$i]['example']	= '<i>This</i> should be in italics.';
			$i++;

			$styles['tags'][$i]['title']	= 'Keyboard Entry';
			$styles['tags'][$i]['desc']		= 'Defines keyboard input.';
			$styles['tags'][$i]['example']	= 'When you reach the screen, enter <kbd>kbsfv7y)(&yhskn</kbd> and you will be logged in.';
			$i++;

			$styles['tags'][$i]['title']	= 'Links';
			$styles['tags'][$i]['desc']		= 'Links can lead to other pages on the site, another section on the current page, or any other location on the web.';
			$styles['tags'][$i]['example']	= '<a href="http://slushman.com">External Link (to another site)</a> or <a href="#headers">Internal Link (an anchor on this page)</a>';
			$i++;

			$styles['tags'][$i]['title']	= 'Marked / Highlighted Text';
			$styles['tags'][$i]['desc']		= 'For text marked or highlighted for reference purposes. When used in a quotation it indicates a highlight not originally present but added to bring the reader’s attention to that part of the text. When used in the main prose of a document, it indicates a part of the document that has been highlighted due to its relevance to the user’s current activity';
			$styles['tags'][$i]['example']	= 'I kept trying to reiterate that the <mark>jewels</mark> were what were stolen.';
			$i++;

			$styles['tags'][$i]['title']	= 'Paragraph, default alignment';
			$styles['tags'][$i]['desc']		= 'Blocks of text. Many times the p tags are added by WordPress automatically.';
			$styles['tags'][$i]['example']	= '<p>This text is inside a paragraph. I have nothing important to say here, so I plan to type until I get annoyed with myself and how ridiculous this is while typing this out for you to read on the screen. Yeah, I can be finished now.</p>';
			$i++;

			$styles['tags'][$i]['title']	= 'Paragraph, justified';
			$styles['tags'][$i]['desc']		= 'Blocks of text. Many times the p tags are added by WordPress automatically.';
			$styles['tags'][$i]['example']	= '<p style="text-align: justify;">This text is inside a paragraph. I have nothing important to say here, so I plan to type until I get annoyed with myself and how ridiculous this is while typing this out for you to read on the screen. Yeah, I can be finished now.</p>';
			$i++;

			$styles['tags'][$i]['title']	= 'Paragraph, center alignment';
			$styles['tags'][$i]['desc']		= 'Blocks of text. Many times the p tags are added by WordPress automatically.';
			$styles['tags'][$i]['example']	= '<p style="text-align: center;">This text is inside a paragraph. I have nothing important to say here, so I plan to type until I get annoyed with myself and how ridiculous this is while typing this out for you to read on the screen. Yeah, I can be finished now.</p>';
			$i++;

			$styles['tags'][$i]['title']	= 'Paragraph, left alignment';
			$styles['tags'][$i]['desc']		= 'Blocks of text. Many times the p tags are added by WordPress automatically.';
			$styles['tags'][$i]['example']	= '<p style="text-align: left;">This text is inside a paragraph. I have nothing important to say here, so I plan to type until I get annoyed with myself and how ridiculous this is while typing this out for you to read on the screen. Yeah, I can be finished now.</p>';
			$i++;

			$styles['tags'][$i]['title']	= 'Paragraph, right alignment';
			$styles['tags'][$i]['desc']		= 'Blocks of text. Many times the p tags are added by WordPress automatically.';
			$styles['tags'][$i]['example']	= '<p style="text-align: right;">This text is inside a paragraph. I have nothing important to say here, so I plan to type until I get annoyed with myself and how ridiculous this is while typing this out for you to read on the screen. Yeah, I can be finished now.</p>';
			$i++;

			$styles['tags'][$i]['title']	= 'Pre-formatted text';
			$styles['tags'][$i]['desc']		= 'Represents a block of pre-formatted text, in which structure is represented by typographic conventions rather than by elements. Such examples are an e-mail (with paragraphs indicated by blank lines, lists indicated by lines prefixed with a bullet), fragments of computer code (with structure indicated according to the conventions of that language) or displaying ASCII art.';
			$styles['tags'][$i]['example']	= '<pre>Text in a pre element
is displayed in a fixed-width
font, and it preserves
both	  spaces and
line breaks</pre>';
			$i++;

			$styles['tags'][$i]['title']	= 'Sample Output';
			$styles['tags'][$i]['desc']		= 'Represents output from a computer program.';
			$styles['tags'][$i]['example']	= 'We kept getting the error message <samp>Headers already sent.</samp>';
			$i++;

			$styles['tags'][$i]['title']	= 'Small Print';
			$styles['tags'][$i]['desc']		= 'Small print is mostly used for copyright notices, disclaimers, cattributions, etc. Anything considered "the fine print".';
			$styles['tags'][$i]['example']	= '<small>All rights reserved.</small>';
			$i++;

			$styles['tags'][$i]['title']	= 'Strikethrough';
			$styles['tags'][$i]['desc']		= 'Used for content no longer accurate or relevant.';
			$styles['tags'][$i]['example']	= 'His performance was <s>legendary</s> a complete disaster!';
			$i++;			

			$styles['tags'][$i]['title']	= 'Strong';
			$styles['tags'][$i]['desc']		= 'Denotes strong importance.';
			$styles['tags'][$i]['example']	= 'I said <strong>do not</strong> hit your brother!';
			$i++;

			$styles['tags'][$i]['title']	= 'Subscript';
			$styles['tags'][$i]['desc']		= 'Used for subscripts, where the text appears half a character below the baseline - like chemical formulas.';
			$styles['tags'][$i]['example']	= 'The doctor advised I drink 10 glasses of h<sub>2</sub>0 per day.';
			$i++;

			$styles['tags'][$i]['title']	= 'Superscript';
			$styles['tags'][$i]['desc']		= 'Used for superscripts, where the text appear half a character above the baseline - like footnotes or mathematic notation.';
			$styles['tags'][$i]['example']	= 'The anomoly occured as many as log<sup>8</sup> times per day.';
			$i++;

			$styles['tags'][$i]['title']	= 'Time';
			$styles['tags'][$i]['desc']		= 'Represents time on a 24-hour clock or a date on the Gregorian calendar, optionally with a time-zone offset. Use the datetime attribute for specifying the date and time (more specifically than the text inside the time tag).';
			$styles['tags'][$i]['example']	= 'Livingstone, born in <time datetime="1813-03-19">1813</time>, came on board late in the journey.';
			$i++;

			$styles['tags'][$i]['title']	= 'Variable';
			$styles['tags'][$i]['desc']		= 'Denote a variable in a mathematical expression or programming context, but can also be used to indicate a placeholder where the contents should be replaced with your own value.';
			$styles['tags'][$i]['example']	= 'We determined the Towers of Hanoi problem would be solved in <var>n</var> moves, based on the number of disks.';
			$i++;

/***************

Lists

****************/

			$styles['lists'][$i]['title']		= 'List, Definition';
			$styles['lists'][$i]['desc']		= 'For lists of terms (use the dt tag) and their descriptions (use the dd tag), although it can be used anywhere a parent/child relationship needs to be represented.';
			$styles['lists'][$i]['example']		= '<dl><dt>Ratio</dt><dd>A relationship between two numbers of the same kind</dd><dt>Fraction</dt><dd>Represents a part of a whole or, more generally, any number of equal parts</dd></dl>';
			$i++;

			$styles['lists'][$i]['title']		= 'List, Dialog';
			$styles['lists'][$i]['desc']		= 'For marking dialog.';
			$styles['lists'][$i]['example']		= '<dialog><dt> Costello</dt>
							<dd> Look, you gotta first baseman?</dd>
							<dt> Abbott</dt>
							<dd> Certainly.</dd>
							<dt> Costello</dt>
							<dd> Who\'s playing first?</dd>
							<dt> Abbott</dt>
							<dd> That\'s right.</dd>
							<dt> Costello</dt>
							<dd> When you pay off the first baseman every month, who gets the money?</dd>
							<dt> Abbott</dt>
							<dd> Every dollar of it.</dd></dialog>';
			$i++;

			$styles['lists'][$i]['title']		= 'List, Ordered';
			$styles['lists'][$i]['desc']		= 'A list with a definte order, like an outline.';
			$styles['lists'][$i]['example']		= '<ol><li>Type the item</li><li>Type the second item<ol><li>Leave out extra spaces</li><li>Add indentation</li></ol></li><li>Type the third item</li></ol>';
			$i++;

			$styles['lists'][$i]['title']		= 'List, Unordered';
			$styles['lists'][$i]['desc']		= 'A list without a defined order.';
			$styles['lists'][$i]['example']		= '<ul><li>Bob</li><li>Sam<ul><li>Sally</li><li>Samantha</li></ul></li><li>Jessica</li></ul>';
			$i++;

/***************

Tables

****************/

			$styles['tables'][$i]['title']		= '';
			$styles['tables'][$i]['desc']		= '';
			$styles['tables'][$i]['example']	= '<table><thead><tr><th>Column 1</th><th>Column 2</th></tr></thead><tbody><tr><td>Row 1, Col 1</td><td>Row 1, Col 2</td></tr><tr><td>Row 2, Col 1</td><td>Row 2, Col 1</td></tr><tr><td>Row 3, Col 1</td><td>Row 3, Col 1</td></tr></tbody></table>';
			$i++;

/***************

Forms and Fields

****************/

			$styles['forms'][$i]['title'] 		= '';
			$styles['forms'][$i]['desc'] 		= '';
			$styles['forms'][$i]['example']		= '
				<form action="#">
					<label for="text">Text Input <abbr title="Required">*</abbr></label>
					<input id="text" class="text" type="text"/>
					<span class="description">Description of this field</span>

					<label for="password">Password<abbr title="Required">*</abbr></label>
					<input id="password" class="text" type="password"/>
					<span class="description">Description of this field</span>

					<label for="url">Web Address<abbr title="Required">*</abbr></label>
					<input id="url" class="text" type="url"/>
					<span class="description">Description of this field</span>

					<label for="email">Email Address<abbr title="Required">*</abbr></label>
					<input id="email" class="text" type="email"/>
					<span class="description">Description of this field</span>

					<label for="search">Search<abbr title="Required">*</abbr></label>
					<input id="search" class="text" type="search"/><input id="search_button" class="search button" type="submit" value="Search" />
					<span class="description">Description of this field</span>

					<label for="search">Textarea<abbr title="Required">*</abbr></label>
					<textarea id="textarea" rows="8" cols="48"></textarea>
					<span class="description">Description of this field</span>

					<label for="checkbox">Single Checkbox</label>
					<label for="checkbox" class="check">
					<input id="checkbox" type="checkbox" class="checkbox"/> Label</label>

					<label for="select">Select</label>
					<select id="select">
						<optgroup label="Option Group">
							<option>Option One</option>
							<option>Option Two</option>
							<option>Option Three</option>
						</optgroup>
					</select>
					<span class="description">Description of this field</span>

					<fieldset class="options">
					<legend>Checkbox Group Legend <abbr title="Required">*</abbr></legend>
					<ul>
						<li><label for="checkbox1"><input id="checkbox1" name="checkbox" type="checkbox" checked="checked" /> Choice A</label></li>
						<li><label for="checkbox2"><input id="checkbox2" name="checkbox" type="checkbox" /> Choice B</label></li>
						<li><label for="checkbox3"><input id="checkbox3" name="checkbox" type="checkbox" /> Choice C</label></li>
					</ul>
					</fieldset>

					<fieldset class="options">
					<legend>Radio Legend<abbr title="Required">*</abbr></legend>
					<ul>
						<li><label for="radio1"><input id="radio1" name="radio" type="radio" class="radio" checked="checked" /> Option 1</label></li>
						<li><label for="radio2"><input id="radio2" name="radio" type="radio" class="radio" /> Option 2</label></li>
					</ul>
					</fieldset>
				</form>';
			$i++;

/***************

Media

****************/

			$styles['media'][$i]['title']		= 'Figure, image';
			$styles['media'][$i]['desc']		= 'Specifies self-contained content, like illustrations, diagrams, photos, code listings, etc.';
			$styles['media'][$i]['example']		= '<figure><img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="Figure test picture" /></figure>';
			$i++;

			$styles['media'][$i]['title']		= 'Figure, image with caption';
			$styles['media'][$i]['desc']		= 'Specifies self-contained content, like illustrations, diagrams, photos, code listings, etc.';
			$styles['media'][$i]['example']		= '<figure><img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="Figure test picture" /><figcaption><cite><a href="http://www.flickr.com/photos/vespa_freak/7733798164/">Wheels 2</a></cite> by Mike Kuusela</figcaption></figure>';
			$i++;

			$styles['media'][$i]['title']		= 'Image, align left';
			$styles['media'][$i]['desc']		= '';
			$styles['media'][$i]['example']		= '<img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="align left picture" class="alignleft" />';
			$i++;

			$styles['media'][$i]['title']		= 'Image, align center';
			$styles['media'][$i]['desc']		= '';
			$styles['media'][$i]['example']		= '<img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="align center picture" class="aligncenter" />';
			$i++;

			$styles['media'][$i]['title']		= 'Image, align right';
			$styles['media'][$i]['desc']		= '';
			$styles['media'][$i]['example']		= '<img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="align right picture" class="alignright" />';
			$i++;

			$styles['media'][$i]['title']		= 'Image, no alignment';
			$styles['media'][$i]['desc']		= '';
			$styles['media'][$i]['example']		= '<img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="image with caption picture" class="alignnone" />';
			$i++;

			$styles['media'][$i]['title']		= 'Image, align left, with caption';
			$styles['media'][$i]['desc']		= '';
			$styles['media'][$i]['example']		= '<div class="wp-caption alignleft" style="width:500px;"><img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="align left picture" class="" /><p class="wp-caption-text">This is a caption.</p></div>This text will surround the picture and should appear on the left.';
			$i++;

			$styles['media'][$i]['title']		= 'Image, align center, with caption';
			$styles['media'][$i]['desc']		= '';
			$styles['media'][$i]['example']		= '<div class="wp-caption aligncenter" style="width:500px;"><img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="align center picture" class="" /><p class="wp-caption-text">This is a caption.</p></div>This text will surround the picture and should appear under the photo.';
			$i++;

			$styles['media'][$i]['title']		= 'Image, align right, with caption';
			$styles['media'][$i]['desc']		= '';
			$styles['media'][$i]['example']		= '<div class="wp-caption alignright" style="width:500px;"><img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="align right picture" class="" /><p class="wp-caption-text">This is a caption.</p></div>This text will surround the picture and should appear on the right.';
			$i++;

			$styles['media'][$i]['title']		= 'Image, no alignment, with caption';
			$styles['media'][$i]['desc']		= '';
			$styles['media'][$i]['example']		= '<div class="wp-caption alignnone"><img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="image with caption picture" /><p class="wp-caption-text">This is a caption.</p></div>';
			$i++;

/*
			$styles['media'][$i]['title']		= 'Video';
			$styles['media'][$i]['desc']		= '';
			$styles['media'][$i]['example']		= '';
			$i++;

			$styles['media'][$i]['title']		= 'Audio player';
			$styles['media'][$i]['desc']		= '';
			$styles['media'][$i]['example']		= '';
			$i++;
*/

/***************

Patterns

****************/

/*
			$styles['patterns'][$i]['title']	= 'Post Navigations';
			$styles['patterns'][$i]['desc']		= 'The Older Posts/Newer Posts links at the bottom of a posts page.';
			$styles['patterns'][$i]['example']	= '';
			$i++;

			$styles['patterns'][$i]['title']	= 'Breadcrumbs';
			$styles['patterns'][$i]['desc']		= 'A naviagation aid allowing users to keep track of their current location on the site and the parent pages leading back to the index.';
			$styles['patterns'][$i]['example']	= '';
			$i++;

*/
			$styles['patterns'][$i]['title']	= 'Comments';
			$styles['patterns'][$i]['desc']		= 'Comment areas for posts and pages.';
			$styles['patterns'][$i]['example']	= 'See the bottom of this page for the <a href="#comments">example</a>.';
			$i++;

/*
			$styles['patterns'][$i]['title']	= 'Logo';
			$styles['patterns'][$i]['desc']		= 'The logo used for this site.';
			$styles['patterns'][$i]['example']	= '';
			$i++;
			
			$styles['patterns'][$i]['title']	= 'Default Custom Avatar';
			$styles['patterns'][$i]['desc']		= 'The default avatar used for comments, if not one fo the default WordPress options.';
			$styles['patterns'][$i]['example']	= '';
			$i++;
			
			$styles['patterns'][$i]['title']	= '';
			$styles['patterns'][$i]['desc']		= '';
			$styles['patterns'][$i]['example']	= '';
			$i++;

*/

/***************

Buttons

****************/

			$styles['buttons'][$i]['title']		= '';
			$styles['buttons'][$i]['desc']		= '';
			$styles['buttons'][$i]['example']	= '
				<p><input class="button submit" type="submit" value="Submit" /></p>
				<p><input class="button search" type="submit" value="Search" /></p>
				<p><input class="button" type="submit" value="Post Comment" /></p>
				<p><input class="button" type="button" value="Preview" /></p>
				<p><a href="#">Cancel</a></p>';
			$i++;

			$return = '<p class="guide_desc">This page is a guide the mark-up styles used on this site.</p>';

			$return = '<h2 class="toc_header">Table of Contents</h2>';

			foreach ( $styles as $style => $data ) {

				$capstylename = ucwords( str_replace( '_', ' ', $style ) );

				$return .= '<a href="#' . $style . '"><h4>' . $capstylename . '</h4></a>';

			} // End of $styles foreach loop

			foreach ( $styles as $style => $items ) {

				$capstylename 		= ucwords( str_replace( '_', ' ', $style ) );
				$spacer 		= ( is_user_logged_in() ? ' top_spacer' : '' );

				$return .= '<div class="style_section' . $spacer . '" id="' . $style . '">';
				$return .= '<span class="backtotoplink"><a href="#">Back to top</a></span>';
				$return .= '<h2 class="section_title">' . $capstylename . '</h2>';
				$return .= '<p class="section_description">' . $items['desc'] . '</p>';

				foreach ( $items as $itemkey => $itemdata ) {

					if ( is_int( $itemkey ) ) {

						$return .= '<div class="style_item">';
						$return .= '<h3 class="item_title">' . $itemdata['title'] . '</h3>';
						$return .= '<p class="item_description">' . $itemdata['desc'] . '</p>';
						$return .= '<span class="item_example">' . $itemdata['example'] . '</span>';
						$return .= '</div><!-- End of style item -->';

					} // End of int check

				} // End of $items foreach loop

				$return .= '</div><!-- End of style section -->';

			} // End of $styles foreach loop

			return $return;

		} // End of style_guide_page()

/**
 * Creates shortcode [wpstyleguide]
 *
 * @param   array   $atts	   The attrbiutes from the shortcode
 * 
 * @uses	ob_start
 * @uses	
 * @uses	ob_get_contents
 * @uses	ob_end_clean
 *
 * @return  mixed   $output	 Output of the buffer
 */
		function shortcode( $atts ) {
		
			ob_start();

			echo $this->style_guide_page();
			
			$output = ob_get_contents();
			
			ob_end_clean();
			
			return $output;
		
		} // End of shortcode()






	} // End of Slushman_WP_Style_Guide class

} // End of class_exists check

$slushman_wp_style_guide = new Slushman_WP_Style_Guide();

?>