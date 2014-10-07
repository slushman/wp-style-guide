<?php
/**
 * WP Style Guide
 *
 * This is a class handling the public-facing portions of the plugin.
 *
 * @package   WP Style Guide
 * @author    Slushman <chris@slushman.com>
 * @copyright Copyright (c) 2014, Slushman
 * @license   GPL-2.0+
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link      http://slushman.com/plugins/wp-style-guide
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) { die; }

if ( !class_exists( 'Slushman_WP_Style_Guide' ) ) {

	class Slushman_WP_Style_Guide {

/**
 * Holds the instance of this class.
 *
 * @access 	protected
 * @since  	0.1
 * @var    	object
 */
		protected static $instance = NULL;

/**
 * The internationalization domain
 *
 * @access 	private
 * @since 	0.1
 * @var 	string
 */
		protected $i18n = '';

/**
 * The name of the plugin
 *
 * @access 	protected
 * @since   0.1
 * @var     string
 */
		protected $name = '';

/**
 * Plugin version, used for cache-busting of style and script file references.
 *
 * @access 	protected
 * @since   0.1
 * @var     string
 */
		protected $version = '';

/**
 * Plugin constructor
 *
 * @access 	public
 * @since  	0.1
 * 
 * @return 	void
 */
		public function __construct() {

			$this->i18n 	= 'wp-style-guide';
			$this->name 	= 'WP Style Guide';
			$this->version 	= '0.1';

			// Load plugin text domain
			add_action( 'init', 				array( $this, 'load_plugin_textdomain' ) );

			// Activate plugin when new blog is added
			add_action( 'wpmu_new_blog', 		array( $this, 'activate_new_site' ) );

			// Load public-facing style sheet and JavaScript.
			add_action( 'wp_enqueue_scripts', 	array( $this, 'enqueue_styles' ) );
			add_action( 'wp_enqueue_scripts', 	array( $this, 'enqueue_scripts' ) );

			// Add Style Guide page
			add_action( 'init', 				array( $this, 'create_page' ) );

			// Register shortcodes
			add_action( 'init', 				array( $this, 'register_shortcodes' ) );

			// Add page parts
			add_action( 'style_guide_page', 	array( $this, 'add_intro' ) );
			add_action( 'style_guide_page', 	array( $this, 'add_toc' ) );
			add_action( 'style_guide_page', 	array( $this, 'add_structural' ) );
			add_action( 'style_guide_page', 	array( $this, 'add_semantic' ) );
			add_action( 'style_guide_page', 	array( $this, 'add_lists' ) );
			add_action( 'style_guide_page', 	array( $this, 'add_tables' ) );
			add_action( 'style_guide_page', 	array( $this, 'add_forms_and_fields' ) );
			add_action( 'style_guide_page', 	array( $this, 'add_buttons' ) );
			add_action( 'style_guide_page', 	array( $this, 'add_media' ) );
			add_action( 'style_guide_page', 	array( $this, 'add_widgets' ) );

			// Register Style Guide sidebar
			add_action( 'wp_loaded', 			array( $this, 'register_sidebar' ) );
			add_action( 'wp_loaded', 			array( $this, 'add_widgets_to_sidebar' ) );

			add_action( 'wp_footer', 			array( $this, 'show_my_sidebars' ) );

		} // __construct()



/* ==========================================================================
   Activation & Deactivation Methods
   ========================================================================== */

/**
 * Fired when the plugin is activated.
 *
 * @access 	public
 * @since 	0.1
 *
 * @param 	bool 		$network_wide		True if WPMU superadmin uses
 *                               			"Network Activate" action, false if
 *                               			WPMU is disabled or plugin is
 *                               			activated on an individual blog.
 *
 * @uses 	is_multisite()
 * @uses 	get_blog_ids()
 * @uses 	switch_to_blog()
 * @uses 	single_activate()
 *
 * @return 	void
 */
		public static function activate( $network_wide ) {

			if ( function_exists( 'is_multisite' ) && is_multisite() ) {

				if ( $network_wide  ) {

					// Get all blog ids
					$blog_ids = self::get_blog_ids();

					foreach ( $blog_ids as $blog_id ) {

						switch_to_blog( $blog_id );
						self::single_activate();
					
					} // foreach loop

					restore_current_blog();

				} else {

					self::single_activate();
				
				} // network check

			} else {
				
				self::single_activate();
			
			} // multisite check

		} // activate()

/**
 * Fired when the plugin is deactivated.
 *
 * @access 	public
 * @since 	0.1
 *
 * @param 	bool 		$network_wide 		True if WPMU superadmin uses
 *                                			"Network Deactivate" action, false if
 *                                			WPMU is disabled or plugin is
 *                                			deactivated on an individual blog.
 *
 * @uses 	is_multisite()
 * @uses 	get_blog_ids()
 * @uses 	switch_to_blog()
 * @uses 	single_deactivate()
 * @uses 	restore_current_blog()
 *
 * @return 	void
 */
		public static function deactivate( $network_wide ) {

			if ( function_exists( 'is_multisite' ) && is_multisite() ) {

				if ( $network_wide ) {

					// Get all blog ids
					$blog_ids = self::get_blog_ids();

					foreach ( $blog_ids as $blog_id ) {

						switch_to_blog( $blog_id );
						self::single_deactivate();

					} // foreach loop

					restore_current_blog();

				} else {
				
					self::single_deactivate();
				
				} // network check

			} else {
			
				self::single_deactivate();
			
			} // multisite check

		} // deactivate()

/**
 * Fired when a new site is activated with a WPMU environment.
 *
 * @access 	public
 * @since 	0.1
 *
 * @uses 	did_action()
 * @uses 	switch_to_blog()
 * @uses 	single_activate()
 * @uses 	restore_current_blog()
 *
 * @param    int    	$blog_id    	ID of the new blog.
 */
		public function activate_new_site( $blog_id ) {

			if ( 1 !== did_action( 'wpmu_new_blog' ) ) { return; }

			switch_to_blog( $blog_id );

			self::single_activate();
			
			restore_current_blog();

		} // activate_new_site()

/**
 * Get all blog ids of blogs in the current network that are:
 * - not archived
 * - not spam
 * - not deleted
 *
 * @access 	private
 * @since 	0.1
 *
 * @global 	$wpdb
 * 
 * @uses 	get_col()
 *
 * @return   array|false    The blog ids, false if no matches.
 */
		private static function get_blog_ids() {

			global $wpdb;

			// get an array of blog ids
			$sql = "SELECT blog_id FROM $wpdb->blogs
				WHERE archived = '0' AND spam = '0'
				AND deleted = '0'";

			return $wpdb->get_col( $sql );

		} // get_blog_ids()

/**
 * Fired for each blog when the plugin is activated.
 *
 * @access 	private
 * @since 	0.1
 *
 * @uses 	add_action()
 *
 * @return 	void
 */
		private static function single_activate() {

			// @TODO: Define activation functionality here

		} // single_activate()

/**
 * Fired for each blog when the plugin is deactivated.
 *
 * @access 	private
 * @since 	0.1
 */
		private static function single_deactivate() {

			// @TODO: Define deactivation functionality here

		} // single_deactivate()



/* ==========================================================================
   WP Plugin Methods
   ========================================================================== */

/**
 * Registers and enqueues the front-end style sheets
 *
 * @access 	public
 * @since 	0.1
 * 
 * @uses 	wp_enqueue_style()
 * @uses 	plugins_url()
 * 
 * @return 	void
 */		
		public function enqueue_styles() {

			wp_enqueue_style( $this->i18n . '-plugin-styles', plugins_url( 'css/public.css', dirname( __FILE__ ) ), array(), $this->version );

		} // enqueue_styles()

/**
 * Registers and enqueues the front-end scripts
 *
 * @access 	public
 * @since 	0.1
 * 
 * @uses 	wp_enqueue_script()
 * @uses 	plugins_url()
 * 
 * @return 	void
 */	
		public function enqueue_scripts() {
	
			wp_enqueue_script( $this->i18n .'-public-script', plugins_url( 'js/public.min.js', dirname( __FILE__ ) ), array( 'jquery' ), $this->version, TRUE );
			
		} // enqueue_scripts()

/**
 * Load the plugin text domain for translation.
 *
 * @access 	public
 * @since 	0.1
 *
 * @uses 	apply_filters()
 * @uses 	get_locale()
 * @uses 	load_textdomain()
 * @uses 	trailingslashit()
 * @uses 	load_plugin_textdomain()
 * @uses 	plugin_dir_path()
 *
 * @return 	void
 */
		public function load_plugin_textdomain() {

			$locale = apply_filters( 'plugin_locale', get_locale(), $this->i18n );

			load_textdomain( $this->i18n, trailingslashit( WP_LANG_DIR ) . $this->i18n . '/' . $this->i18n . '-' . $locale . '.mo' );
			load_plugin_textdomain( $this->i18n, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

		} // load_plugin_textdomain()

/**
 * Registers shortcodes with WordPress
 *
 * @uses 	add_shortcode()
 * 
 * @return 	void
 */
		public function register_shortcodes() {

			add_shortcode( 'wpstyleguide', array( $this, 'create_shortcode' ) );

		} // register_shortcodes()

/**
 * Register style guide sidebar with WordPress
 *
 * @uses 	add_shortcode()
 * 
 * @return 	void
 */
		public function register_sidebar() {

			$args['name']			= __( 'Style Guide', $this->i18n );
			$args['id']				= 'slushman-wp-style-guide';
			$args['description']	= 'This sidebar is only for the style guide page.';
			$args['class']			= '';
			$args['before_widget']	= '<li id="%1$s" class="widget %2$s">';
			$args['after_widget']	= '</li>';
			$args['before_title']	= '<h2 class="widgettitle">';
			$args['after_title']	= '</h2>';

			register_sidebar( $args );

		} // register_sidebar()

		function show_my_sidebars() {

			$sw = get_option( 'sidebars_widgets' );
			print '<pre>' . htmlspecialchars( print_r( $sw, TRUE ) ) . '</pre>';
		
		}



/* ==========================================================================
   Add Methods
   ========================================================================== */  

/**
 * Adds the introduction at the top of the page.
 *
 * @access 	public
 * @since  	0.1
 *
 * @return  void 
 */
   		public function add_intro() {

			echo '<p class="guide_desc">This page is a guide the mark-up styles used on this site.</p>';

   		} // add_intro()

/**
 * Adds the table of contents.
 *
 * @access 	public
 * @since  	0.1
 *
 * @return  void 
 */
   		public function add_toc() {

   			$output = '<h2 class="toc_header">Table of Contents</h2>';
   			$groups = array( 'headers', 'structural', 'semantic', 'lists', 'tables', 'forms_and_fields', 'buttons', 'media', 'widgets' );

			foreach ( $groups as $group ) {

				$capped = ucwords( str_replace( '_', ' ', $group ) );
				$output .= '<a href="#' . $group . '"><h4>' . $capped . '</h4></a>';

			} // $items foreach loop

   			echo $output;

   		} // add_toc()

/**
 * Adds the header tags
 *
 * @access 	public
 * @since 	0.1
 * 
 * @return 	void
 */
   		public function add_headers() {

   			$i = 0;

			$items[$i]['example'] 	= '<h1>First-level header</h1>';
			$items[$i]['desc'] 		= 'For the most important elements, like page and post titles.';
			$i++;

			$items[$i]['example'] 	= '<h2>Second-level header</h2>';
			$items[$i]['desc'] 		= 'For items like sub-headers.';
			$i++;

			$items[$i]['example'] 	= '<h3>Third-level header</h3>';
			$items[$i]['desc'] 		= 'For page-level headers lower in the hierarchy than the h2.';
			$i++;

			$items[$i]['example'] 	= '<h4>Fourth-level header</h4>';
			$items[$i]['desc'] 		= 'For page-level headers lower in the hierarchy than the h3.';
			$i++;

			$items[$i]['example'] 	= '<h5>Fifth-level header</h5>';
			$items[$i]['desc'] 		= 'For page-level headers lower in the hierarchy than the h4.';
			$i++;

			$items[$i]['example'] 	= '<h6>Sixth-level header</h6>';
			$items[$i]['desc'] 		= 'For page-level headers lower in the hierarchy than the h5.';
			$i++;

			$output		= '';
			$output		.= '<div class="style_section' . $this->get_spacer() . '" id="headers">';
			$output		.= '<span class="backtotoplink"><a href="#">Back to top</a></span>';
			$output		.= '<h2 class="section_title">Headers</h2>';
			$output		.= '<p class="section_description">Header elements have a hierarchy, the top being the h1, or Header 1. Most of the time, headers should be used for things like titles, subheaders, or section titles.</p>';

			foreach ( $items as $item ) {

				$output	.= $item['example'];
				$output	.= '<p>' . $item['desc'] . '</p>';

			} // foreach loop

			echo $output;

   		} // add_headers()

/**
 * Adds structural HTML tags
 *
 * @access 	public
 * @since 	0.1
 * 
 * @return 	void
 */
   		public function add_structural() {

   			$i = 0;

			$items[$i]['title']		= 'Blockquotes';
			$items[$i]['desc']		= 'Represents a section that is being quoted from another source.';
			$items[$i]['example']	= '<blockquote cite="http://www.worldwildlife.org/who/index.html">For 50 years, WWF has been protecting the future of nature. The world\'s leading conservation organization, WWF works in 100 countries and is supported by 1.2 million members in the United States and close to 5 million globally.</blockquote>';
			$i++;
			
			$items[$i]['title']		= 'Bold / Embolden';
			$items[$i]['desc']		= 'Conveys extra importance or a keyword (product name in a review, etc). Should be used as a last resort.';
			$items[$i]['example']	= 'It was the <b>curtains</b> she liked.';
			$i++;
			
			$items[$i]['title']		= 'Code';
			$items[$i]['desc']		= 'Used to demonstrate fragments of computer code.';
			$items[$i]['example']	= '<code>$var = $x . $y * 3;</code>';
			$i++;			
			
			$items[$i]['title']		= 'Horizontal rule';
			$items[$i]['desc']		= 'Represents a break in the reading, usually denotes going to another subject or a scene change.';
			$items[$i]['example']	= '<p>Amanda was certain Jeff was not telling the truth. The document she just found in his desk proved he could not be trusted. But he had just left with her son and she was frozen with indecision.</p><hr><p>Jeff drove calmly through the winding streets of the Dallas suburb. The sun was still high enough in the sky that he had no use for the visors and folded his up against the ceiling of the car.</p>';
			$i++;
			
			$items[$i]['title']		= 'Italics';
			$items[$i]['desc']		= 'Used for offsetting text, possibly to change the mood or voicing.';
			$items[$i]['example']	= '<i>This</i> should be in italics.';
			$i++;
			
			$items[$i]['title']		= 'Links';
			$items[$i]['desc']		= 'Links can lead to other pages on the site, another section on the current page, or any other location on the web.';
			$items[$i]['example']	= '<a href="http://slushman.com">External Link (to another site)</a> or <a href="#headers">Internal Link (an anchor on this page)</a>';
			$i++;
			
			$items[$i]['title']		= 'Paragraph, default alignment';
			$items[$i]['desc']		= 'Blocks of text. Many times the p tags are added by WordPress automatically.';
			$items[$i]['example']	= '<p>This text is inside a paragraph. I have nothing important to say here, so I plan to type until I get annoyed with myself and how ridiculous this is while typing this out for you to read on the screen. Yeah, I can be finished now.</p>';
			$i++;
			
			$items[$i]['title']		= 'Paragraph, justified';
			$items[$i]['desc']		= 'Blocks of text. Many times the p tags are added by WordPress automatically.';
			$items[$i]['example']	= '<p style="text-align: justify;">This text is inside a paragraph. I have nothing important to say here, so I plan to type until I get annoyed with myself and how ridiculous this is while typing this out for you to read on the screen. Yeah, I can be finished now.</p>';
			$i++;
			
			$items[$i]['title']		= 'Paragraph, center alignment';
			$items[$i]['desc']		= 'Blocks of text. Many times the p tags are added by WordPress automatically.';
			$items[$i]['example']	= '<p style="text-align: center;">This text is inside a paragraph. I have nothing important to say here, so I plan to type until I get annoyed with myself and how ridiculous this is while typing this out for you to read on the screen. Yeah, I can be finished now.</p>';
			$i++;
			
			$items[$i]['title']		= 'Paragraph, left alignment';
			$items[$i]['desc']		= 'Blocks of text. Many times the p tags are added by WordPress automatically.';
			$items[$i]['example']	= '<p style="text-align: left;">This text is inside a paragraph. I have nothing important to say here, so I plan to type until I get annoyed with myself and how ridiculous this is while typing this out for you to read on the screen. Yeah, I can be finished now.</p>';
			$i++;
			
			$items[$i]['title']		= 'Paragraph, right alignment';
			$items[$i]['desc']		= 'Blocks of text. Many times the p tags are added by WordPress automatically.';
			$items[$i]['example']	= '<p style="text-align: right;">This text is inside a paragraph. I have nothing important to say here, so I plan to type until I get annoyed with myself and how ridiculous this is while typing this out for you to read on the screen. Yeah, I can be finished now.</p>';
			$i++;
			
			$items[$i]['title']		= 'Subscript';
			$items[$i]['desc']		= 'Used for subscripts, where the text appears half a character below the baseline - like chemical formulas.';
			$items[$i]['example']	= 'The doctor advised I drink 10 glasses of h<sub>2</sub>0 per day.';
			$i++;
			
			$items[$i]['title']		= 'Superscript';
			$items[$i]['desc']		= 'Used for superscripts, where the text appear half a character above the baseline - like footnotes or mathematic notation.';
			$items[$i]['example']	= 'The anomoly occured as many as log<sup>8</sup> times per day.';
			$i++;

   			$output 	= '';
			$output		.= '<div class="style_section' . $this->get_spacer() . '" id="structural">';
			$output		.= '<span class="backtotoplink"><a href="#">Back to top</a></span>';
			$output		.= '<h2 class="section_title">Structural Tags</h2>';
			$output		.= '<p class="section_description">Structural tags describe the layout of a page.</p>';

			foreach ( $items as $item ) {

				$output .= '<div class="style_item">';
				$output .= '<h3 class="item_title">' . $item['title'] . '</h3>';
				$output .= '<p class="item_description">' . $item['desc'] . '</p>';
				$output .= '<span class="item_example">' . $item['example'] . '</span>';
				$output .= '</div><!-- End of style item -->';

			} // foreach loop

			echo $output;

   		} // add_structural()

/**
 * Adds semantic HTML tags
 *
 * @access 	public
 * @since 	0.1
 * 
 * @return 	void
 */
   		public function add_semantic() {

   			$i = 0;

			$items[$i]['title']		= 'Abbreviation';
			$items[$i]['desc']		= 'For any abbreviation, acronym, initialism, etc. Text in the title attribute will appear in the mouseover text.';
			$items[$i]['example']	= 'The shuttle was launched by <abbr title="National Aeronautics and Space Administration">NASA</abbr>.';
			$i++;
			
			$items[$i]['title']		= 'Address';
			$items[$i]['desc']		= 'Used for the formatting addresses.';
			$items[$i]['example']	= '<address>Acme Corp<br />PO Box 12345<br />Nashville, TN 37212</address>';
			$i++;
			
			$items[$i]['title']		= 'Citation';
			$items[$i]['desc']		= 'Used for the titles of a work.';
			$items[$i]['example']	= '<cite>Black</cite>, The Circle Trilogy, by Ted Dekker.';
			$i++;
			
			$items[$i]['title']		= 'Definition';
			$items[$i]['desc']		= 'Highlight the first use of a term. Use the title attribute to describe/define the term.';
			$items[$i]['example']	= 'Walter <dfn title="said nothing">acquiesced</dfn> to Phyllis though her statement was inaccurate.';
			$i++;
			
			$items[$i]['title']		= 'Deleted Text';
			$items[$i]['desc']		= 'Shows deleted or retracted text, usually followed by the updated or corrected text. Has a datetime attribute for timestamping the change.';
			$items[$i]['example']	= 'He won <del datetime="2012-02-05">7</del><ins datetime="2014-02-05">2</ins> world titles.';
			$i++;
			
			$items[$i]['title']		= 'Emphasis';
			$items[$i]['desc']		= 'Something pronounced differently for stressing importance.';
			$items[$i]['example']	= 'This is just an <em>example</em> of emphasis.';
			$i++;
			
			$items[$i]['title']		= 'Inline Quotes';
			$items[$i]['desc']		= 'Used for quoting inline, rather than setting the quote apart like a blockquote.';
			$items[$i]['example']	= 'The signs were all there.<q>This is impossible,</q>stated the detective.';
			$i++;
			
			$items[$i]['title']		= 'Inserted Text';
			$items[$i]['desc']		= 'Shows corrected or updated text, usually alongside the deleted or retracted text. Has a datetime attribute for timestamping the change.';
			$items[$i]['example']	= 'He won <del datetime="2012-02-05">7</del><ins datetime="2014-02-05">2</ins> world titles.';
			$i++;
			
			$items[$i]['title']		= 'Keyboard Entry';
			$items[$i]['desc']		= 'Defines keyboard input.';
			$items[$i]['example']	= 'When you reach the screen, enter <kbd>kbsfv7y)(&yhskn</kbd> and you will be logged in.';
			$i++;
			
			$items[$i]['title']		= 'Marked / Highlighted Text';
			$items[$i]['desc']		= 'For text marked or highlighted for reference purposes. When used in a quotation it indicates a highlight not originally present but added to bring the reader’s attention to that part of the text. When used in the main prose of a document, it indicates a part of the document that has been highlighted due to its relevance to the user’s current activity';
			$items[$i]['example']	= 'I kept trying to reiterate that the <mark>jewels</mark> were what were stolen.';
			$i++;
			
			$items[$i]['title']		= 'Pre-formatted text';
			$items[$i]['desc']		= 'Represents a block of pre-formatted text, in which structure is represented by typographic conventions rather than by elements. Such examples are an e-mail (with paragraphs indicated by blank lines, lists indicated by lines prefixed with a bullet), fragments of computer code (with structure indicated according to the conventions of that language) or displaying ASCII art.';
			$items[$i]['example']	= '<pre>Text in a pre element
			is displayed in a fixed-width
			font, and it preserves
			both	  spaces and
			line breaks</pre>';
			$i++;
			
			$items[$i]['title']		= 'Sample Output';
			$items[$i]['desc']		= 'Represents output from a computer program.';
			$items[$i]['example']	= 'We kept getting the error message <samp>Headers already sent.</samp>';
			$i++;
			
			$items[$i]['title']		= 'Small Print';
			$items[$i]['desc']		= 'Small print is mostly used for copyright notices, disclaimers, cattributions, etc. Anything considered "the fine print".';
			$items[$i]['example']	= '<small>All rights reserved.</small>';
			$i++;
			
			$items[$i]['title']		= 'Strikethrough';
			$items[$i]['desc']		= 'Used for content no longer accurate or relevant.';
			$items[$i]['example']	= 'His performance was <s>legendary</s> a complete disaster!';
			$i++;			
			
			$items[$i]['title']		= 'Strong';
			$items[$i]['desc']		= 'Denotes strong importance.';
			$items[$i]['example']	= 'I said <strong>do not</strong> hit your brother!';
			$i++;
			
			$items[$i]['title']		= 'Time';
			$items[$i]['desc']		= 'Represents time on a 24-hour clock or a date on the Gregorian calendar, optionally with a time-zone offset. Use the datetime attribute for specifying the date and time (more specifically than the text inside the time tag).';
			$items[$i]['example']	= 'Livingstone, born in <time datetime="1813-03-19">1813</time>, came on board late in the journey.';
			$i++;
			
			$items[$i]['title']		= 'Variable';
			$items[$i]['desc']		= 'Denote a variable in a mathematical expression or programming context, but can also be used to indicate a placeholder where the contents should be replaced with your own value.';
			$items[$i]['example']	= 'We determined the Towers of Hanoi problem would be solved in <var>n</var> moves, based on the number of disks.';
			$i++;

   			$output 	= '';
			$output		.= '<div class="style_section' . $this->get_spacer() . '" id="semantic">';
			$output		.= '<span class="backtotoplink"><a href="#">Back to top</a></span>';
			$output		.= '<h2 class="section_title">Semantic Tags</h2>';
			$output		.= '<p class="section_description">Semantic tags clearly describe the meaning of information to both the browser and the developer.</p>';

			foreach ( $items as $item ) {

				$output .= '<div class="style_item">';
				$output .= '<h3 class="item_title">' . $item['title'] . '</h3>';
				$output .= '<p class="item_description">' . $item['desc'] . '</p>';
				$output .= '<span class="item_example">' . $item['example'] . '</span>';
				$output .= '</div><!-- End of style item -->';

			} // foreach loop

			echo $output;

   		} // add_semantic()

/**
 * Adds HTML lists
 *
 * @access 	public
 * @since 	0.1
 * 
 * @return 	void
 */
   		public function add_lists() {

   			$i = 0;

			$items[$i]['title']		= 'List, Definition';
			$items[$i]['desc']		= 'For lists of terms (use the dt tag) and their descriptions (use the dd tag), although it can be used anywhere a parent/child relationship needs to be represented.';
			$items[$i]['example']	= '<dl><dt>Ratio</dt><dd>A relationship between two numbers of the same kind</dd><dt>Fraction</dt><dd>Represents a part of a whole or, more generally, any number of equal parts</dd></dl>';
			$i++;

			$items[$i]['title']		= 'List, Dialog';
			$items[$i]['desc']		= 'For marking dialog.';
			$items[$i]['example']	= '<dialog><dt> Costello</dt>
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

			$items[$i]['title']		= 'List, Ordered';
			$items[$i]['desc']		= 'A list with a definte order, like an outline.';
			$items[$i]['example']	= '<ol><li>Type the item</li><li>Type the second item<ol><li>Leave out extra spaces</li><li>Add indentation</li></ol></li><li>Type the third item</li></ol>';
			$i++;

			$items[$i]['title']		= 'List, Unordered';
			$items[$i]['desc']		= 'A list without a defined order.';
			$items[$i]['example']	= '<ul><li>Bob</li><li>Sam<ul><li>Sally</li><li>Samantha</li></ul></li><li>Jessica</li></ul>';
			$i++;

   			$output		= '';
			$output		.= '<div class="style_section' . $this->get_spacer() . '" id="lists">';
			$output		.= '<span class="backtotoplink"><a href="#">Back to top</a></span>';
			$output		.= '<h2 class="section_title">Lists</h2>';
			$output		.= '<p class="section_description">Lists help organize data. They can be ordered or unordered and they can be nested.</p>';

			foreach ( $items as $item ) {

				$output .= '<div class="style_item">';
				$output .= '<h3 class="item_title">' . $item['title'] . '</h3>';
				$output .= '<p class="item_description">' . $item['desc'] . '</p>';
				$output .= '<span class="item_example">' . $item['example'] . '</span>';
				$output .= '</div><!-- End of style item -->';

			} // foreach loop

			echo $output;

   		} // add_lists()

/**
 * Adds HTML tables
 *
 * @access 	public
 * @since 	0.1
 * 
 * @return 	void
 */
   		public function add_tables() {

   			$i = 0;

			$items[$i]['title']	= 'Table';
			$items[$i]['desc']	= '';
			$items[$i]['example']	= '<table><thead><tr><th>Column 1</th><th>Column 2</th></tr></thead><tbody><tr><td>Row 1, Col 1</td><td>Row 1, Col 2</td></tr><tr><td>Row 2, Col 1</td><td>Row 2, Col 1</td></tr><tr><td>Row 3, Col 1</td><td>Row 3, Col 1</td></tr></tbody></table>';
			$i++;

   			$output		= '';
			$output		.= '<div class="style_section' . $this->get_spacer() . '" id="tables">';
			$output		.= '<span class="backtotoplink"><a href="#">Back to top</a></span>';
			$output		.= '<h2 class="section_title">Tables</h2>';
			$output		.= '<p class="section_description">Tables should be used when displaying tabular data. The thead, tfoot and tbody elements enable you to group rows within each a table.<br /><br />If you use these elements, you must use every element. They should appear in this order: thead, tfoot and tbody, so that browsers can render the foot before receiving all the data. You must use these tags within the table element.</p>';

			foreach ( $items as $item ) {

				$output .= '<div class="style_item">';
				$output .= '<h3 class="item_title">' . $item['title'] . '</h3>';
				$output .= '<p class="item_description">' . $item['desc'] . '</p>';
				$output .= '<span class="item_example">' . $item['example'] . '</span>';
				$output .= '</div><!-- End of style item -->';

			} // foreach loop

			echo $output;

   		} // add_tables()

/**
 * Adds forms and fields types
 *
 * @access 	public
 * @since 	0.1
 * 
 * @return 	void
 */
   		public function add_forms_and_fields() {

   			$i = 0;

			$items[$i]['title'] 	= 'Form and Fields';
			$items[$i]['desc'] 		= '';
			$items[$i]['example']	= '
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

   			$output		= '';
			$output		.= '<div class="style_section' . $this->get_spacer() . '" id="forms_and_fields">';
			$output		.= '<span class="backtotoplink"><a href="#">Back to top</a></span>';
			$output		.= '<h2 class="section_title">Forms and Fields</h2>';
			$output		.= '<p class="section_description">Forms can be used when you wish to collect data from users. The fieldset element enables you to group related fields within a form, like a set of checkboxes, and each one should contain a corresponding legend. The label element ensures field descriptions are associated with their corresponding form widgets.</p>';

			foreach ( $items as $item ) {

				$output .= '<div class="style_item">';
				$output .= '<h3 class="item_title">' . $item['title'] . '</h3>';
				$output .= '<p class="item_description">' . $item['desc'] . '</p>';
				$output .= '<span class="item_example">' . $item['example'] . '</span>';
				$output .= '</div><!-- End of style item -->';

			} // foreach loop

			echo $output;

   		} // add_forms_and_fields()

/**
 * Adds various types of buttons
 *
 * @access 	public
 * @since 	0.1
 * 
 * @return 	void
 */
   		public function add_buttons() {

   			$i = 0;

			$items[$i]['title']		= 'Buttons';
			$items[$i]['desc']		= '';
			$items[$i]['example']	= '
				<p><input class="button submit" type="submit" value="Submit" /></p>
				<p><input class="button search" type="submit" value="Search" /></p>
				<p><input class="button" type="submit" value="Post Comment" /></p>
				<p><input class="button" type="button" value="Preview" /></p>
				<p><a href="#">Cancel</a></p>';
			$i++;

   			$output		= '';
			$output		.= '<div class="style_section' . $this->get_spacer() . '" id="buttons">';
			$output		.= '<span class="backtotoplink"><a href="#">Back to top</a></span>';
			$output		.= '<h2 class="section_title">Buttons</h2>';
			$output		.= '<p class="section_description">Buttons are mostly used with forms.</p>';

			foreach ( $items as $item ) {

				$output .= '<div class="style_item">';
				$output .= '<h3 class="item_title">' . $item['title'] . '</h3>';
				$output .= '<p class="item_description">' . $item['desc'] . '</p>';
				$output .= '<span class="item_example">' . $item['example'] . '</span>';
				$output .= '</div><!-- End of style item -->';

			} // foreach loop

			echo $output;

   		} // add_buttons()

/**
 * Adds various types of media
 *
 * @access 	public
 * @since 	0.1
 * 
 * @return 	void
 */
   		public function add_media() {

   			$i = 0;

			$items[$i]['title']		= 'Figure, image';
			$items[$i]['desc']		= 'Specifies self-contained content, like illustrations, diagrams, photos, code listings, etc.';
			$items[$i]['example']	= '<figure><img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="Figure test picture" /></figure>';
			$i++;

			$items[$i]['title']		= 'Figure, image with caption';
			$items[$i]['desc']		= 'Specifies self-contained content, like illustrations, diagrams, photos, code listings, etc.';
			$items[$i]['example']	= '<figure><img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="Figure test picture" /><figcaption><cite><a href="http://www.flickr.com/photos/vespa_freak/7733798164/">Wheels 2</a></cite> by Mike Kuusela</figcaption></figure>';
			$i++;

			$items[$i]['title']		= 'Image, align left';
			$items[$i]['desc']		= '';
			$items[$i]['example']	= '<img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="align left picture" class="alignleft" />';
			$i++;

			$items[$i]['title']		= 'Image, align center';
			$items[$i]['desc']		= '';
			$items[$i]['example']	= '<img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="align center picture" class="aligncenter" />';
			$i++;

			$items[$i]['title']		= 'Image, align right';
			$items[$i]['desc']		= '';
			$items[$i]['example']	= '<img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="align right picture" class="alignright" />';
			$i++;

			$items[$i]['title']		= 'Image, no alignment';
			$items[$i]['desc']		= '';
			$items[$i]['example']	= '<img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="image with caption picture" class="alignnone" />';
			$i++;

			$items[$i]['title']		= 'Image, align left, with caption';
			$items[$i]['desc']		= '';
			$items[$i]['example']	= '<div class="wp-caption alignleft" style="width:500px;"><img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="align left picture" class="" /><p class="wp-caption-text">This is a caption.</p></div>This text will surround the picture and should appear on the left.';
			$i++;

			$items[$i]['title']		= 'Image, align center, with caption';
			$items[$i]['desc']		= '';
			$items[$i]['example']	= '<div class="wp-caption aligncenter" style="width:500px;"><img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="align center picture" class="" /><p class="wp-caption-text">This is a caption.</p></div>This text will surround the picture and should appear under the photo.';
			$i++;

			$items[$i]['title']		= 'Image, align right, with caption';
			$items[$i]['desc']		= '';
			$items[$i]['example']	= '<div class="wp-caption alignright" style="width:500px;"><img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="align right picture" class="" /><p class="wp-caption-text">This is a caption.</p></div>This text will surround the picture and should appear on the right.';
			$i++;

			$items[$i]['title']		= 'Image, no alignment, with caption';
			$items[$i]['desc']		= '';
			$items[$i]['example']	= '<div class="wp-caption alignnone"><img src="' . plugin_dir_url( __FILE__ ) . 'images/figure_test_picture.jpg" alt="image with caption picture" /><p class="wp-caption-text">This is a caption.</p></div>';
			$i++;


			$items[$i]['title']		= 'Video';
			$items[$i]['desc']		= '';
			$items[$i]['example']	= '';
			$i++;

			$items[$i]['title']		= 'Audio player';
			$items[$i]['desc']		= '';
			$items[$i]['example']	= '';
			$i++;

   			$output		= '';
			$output		.= '<div class="style_section' . $this->get_spacer() . '" id="media">';
			$output		.= '<span class="backtotoplink"><a href="#">Back to top</a></span>';
			$output		.= '<h2 class="section_title">Media</h2>';
			$output		.= '<p class="section_description"></p>';

			foreach ( $items as $item ) {

				$output .= '<div class="style_item">';
				$output .= '<h3 class="item_title">' . $item['title'] . '</h3>';
				$output .= '<p class="item_description">' . $item['desc'] . '</p>';
				$output .= '<span class="item_example">' . $item['example'] . '</span>';
				$output .= '</div><!-- End of style item -->';

			} // foreach loop

			echo $output;

   		} // add_media()

/**
 * Adds a sidebar and all default WordPress widgets
 *
 * @access 	public
 * @since 	0.1
 * 
 * @return 	void
 */
   		public function add_widgets() {

   			the_widget( 'WP_Widget_Archives' );
   			the_widget( 'WP_Widget_Calendar' );
   			the_widget( 'WP_Widget_Categories' );
   			the_widget( 'WP_Widget_Links' );
   			the_widget( 'WP_Widget_Meta' );
   			the_widget( 'WP_Widget_Pages' );
   			the_widget( 'WP_Widget_Recent_Comments' );
   			the_widget( 'WP_Widget_Recent_Posts' );
   			the_widget( 'WP_Widget_RSS' );
   			the_widget( 'WP_Widget_Search' );
   			the_widget( 'WP_Widget_Tag_Cloud' );
   			the_widget( 'WP_Widget_Text' );
   			the_widget( 'WP_Nav_Menu_Widget' );

   		} // add_widgets()

/**
 * Adds a sidebar and all default WordPress widgets
 *
 * @access 	public
 * @since 	0.1
 * 
 * @return 	void
 */
   		public function add_widgets_to_sidebar() {

   			the_widget( 'WP_Widget_Archives' );
   			the_widget( 'WP_Widget_Calendar' );
   			the_widget( 'WP_Widget_Categories' );
   			the_widget( 'WP_Widget_Links' );
   			the_widget( 'WP_Widget_Meta' );
   			the_widget( 'WP_Widget_Pages' );
   			the_widget( 'WP_Widget_Recent_Comments' );
   			the_widget( 'WP_Widget_Recent_Posts' );
   			the_widget( 'WP_Widget_RSS' );
   			the_widget( 'WP_Widget_Search' );
   			the_widget( 'WP_Widget_Tag_Cloud' );
   			the_widget( 'WP_Widget_Text' );
   			the_widget( 'WP_Nav_Menu_Widget' );

   		} // add_widgets_to_sidebar()   		

/* ==========================================================================
   Create Methods
   ========================================================================== */ 

/**
 * Creates comments on the style guide page
 * 
 * @param 	int 		$page_ID 		The ID of the page
 *
 * @uses 	wp_insert_comment()
 * 
 * @return 	void
 */
		function create_comments( $page_ID ) {

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

				} // comment 3 ID check

			} // comment 2 ID check

			$comment['comment_post_ID'] 		= $page_ID;
			$comment['comment_author'] 			= 'Commenter 5';
			$comment['comment_author_email']	= 'test@slushman.com';
			$comment['comment_author_url']		= 'http://slushman.com';
			$comment['comment_content']	 		= 'Fifth comment!';
			$comment['comment_parent']	  		= 0;

			$comment_5_ID = wp_insert_comment( $comment );

		} // create_comments()

/**
 * Populates shortcode [wpstyleguide]
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
		function create_shortcode( $atts ) {
	
			ob_start();

			do_action( 'style_guide_page' );

			$output = ob_get_contents();
			
			ob_end_clean();
			
			return $output;
		
		} // create_shortcode()

/**
 * Inserts the "Style Guide" page
 *
 * @uses 	get_page_by_title()
 * @uses 	wp_insert_post()
 * @uses 	add_comments()
 * 
 * @return 	void
 */
		function create_page() {

			$post['post_content']   = '[wpstyleguide]';
			$post['post_name']		= 'style-guide';
			$post['post_title']		= 'Style Guide';
			$post['post_status']	= 'publish';
			$post['post_type']		= 'page';
			$post['ping_status']	= 'closed';
			$post['comment_status'] = 'closed';

			$check = get_page_by_title( $post['post_title'] );

			if ( ! empty( $check->ID ) ) { return; }

			$page_ID = wp_insert_post( $post );

			if ( ! $page_ID ) { return; }

			$this->create_comments( $page_ID );

		} // create_page()


/* ==========================================================================
   Get Methods
   ========================================================================== */

/**
 * Return an instance of this class.
 *
 * @access 	public
 * @since 	0.1
 *
 * @return 	object 		A single instance of this class.
 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {

				self::$instance = new self;
			
			}

			return self::$instance;
		
		} // get_instance()

/**
 * Returns the plugin slug.
 *
 * @access 	public
 * @since 	0.1
 *
 * @return 	string 		The plugin slug class variable
 */
		public function get_i18n() {

			return $this->i18n;

		} // get_i18n()

/**
 * Returns the plugin name.
 *
 * @access 	public
 * @since 	0.1
 *
 * @return 	string 		The plugin name class variable
 */
		public function get_name() {

			return $this->name;

		} // get_name()

/**
 * Returns a class name or not
 *
 * @access 	public
 * @since 	0.1
 *
 * @uses 	is_user_logged_in()
 * 
 * @return 	string 		Either a class name or nothing.
 */
		public function get_spacer() {

			return ( is_user_logged_in() ? ' top_spacer' : '' );

		} // get_spacer()

/**
 * Returns current plugin version.
 *
 * @access 	public
 * @since 	0.1
 *
 * @return 	string 		The plugin version class variable
 */
		public function get_version() {

			return $this->version;

		} // get_version()



/* ==========================================================================
   Plugin Methods
   ========================================================================== */



	} // class

} // class check

?>