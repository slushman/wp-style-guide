/**
 * WordPress plugin-specific gulp file.
 *
 * Instructions
 *
 * In command line, cd into the project directory and run these commands:
 * npm init
 * sudo npm install --save-dev gulp gulp-util gulp-load-plugins browser-sync
 * sudo npm install --save-dev gulp-sourcemaps gulp-autoprefixer gulp-line-ending-corrector gulp-filter gulp-merge-media-queries gulp-cssnano gulp-sass gulp-concat gulp-uglify gulp-notify gulp-imagemin gulp-rename gulp-wp-pot gulp-sort fs path merge-stream gulp-wp-pot
 *
 * Implements:
 * 		1. Live reloads browser with BrowserSync.
 * 		2. CSS: Sass to CSS conversion, error catching, Autoprixing, Sourcemaps,
 * 			 CSS minification, and Merge Media Queries.
 * 		3. JS: Concatenates & uglifies Vendor and Custom JS files.
 * 		4. Images: Minifies PNG, JPEG, GIF and SVG images.
 * 		5. Watches files for changes in CSS or JS.
 * 		6. Watches files for changes in PHP.
 * 		7. Corrects the line endings.
 *      8. InjectCSS instead of browser page reload.
 *      9. Generates .pot file for i18n and l10n.
 *
 * @since 1.0.0
 * @author Ahmad Awais (@mrahmadawais) and Chris Wilcoxson (@slushman)
 */

/**
 * Project Configuration for gulp tasks.
 */
var project = {
	'name': 'wp-style-guide',
	'url': 'themes.dev',
	'i18n': {
		'domain': 'wp-style-guide',
		'destFile': 'wp-style-guide.pot',
		'package': 'WP_Style_Guide',
		'bugReport': 'http://www.dccmarketing.com/contact',
		'translator': 'Chris Wilcoxson <chrisw@dccmarketing.com>',
		'lastTranslator': 'DCC Marketing <web@dccmarketing.com>',
		'path': './assets/languages',
	}
};

var images = {
	'source': './images/*.{png,jpg,gif,svg}',
	'dest': './images/'
}

var watch = {
	'styles': {
		'dest': './assets/css/',
		'source': './src/sass/**/*.scss',
		'task' : 'styles'
	},
	'php': './*.php'
}

var tasks = [];

var zipFiles 	= [ './**',
					'!node_modules/**/*',
					'!src/**/*',
					'!.git/**/*',
					'!node_modules',
					'!src',
					'!.git',
					'!*.zip' ];

/**
 * Browsers you care about for autoprefixing.
 */
const AUTOPREFIXER_BROWSERS = [
	'last 2 version',
	'> 1%',
	'ie >= 9',
	'ie_mob >= 10',
	'ff >= 30',
	'chrome >= 34',
	'safari >= 7',
	'opera >= 23',
	'ios >= 7',
	'android >= 4',
	'bb >= 10'
];

/**
* Load gulp plugins and assing them semantic names.
*/
var gulp 						= require( 'gulp' ); // Gulp of-course
var plugins 					= require( 'gulp-load-plugins' )();
var browserSync 				= require( 'browser-sync' ).create(); // Reloads browser and injects CSS.
var reload 						= browserSync.reload; // For manual browser reload.
var path 			= require( 'path' );

/**
 * Live Reloads, CSS injections, Localhost tunneling.
 *
 * @link http://www.browsersync.io/docs/options/
 */
gulp.task( 'browser-sync', function() {
	browserSync.init({
		proxy: project.url,
		open: true,
		injectChanges: true,
 		browser: "google chrome"
	});
});

/**
 * Creates style files and put them in the root folder.
 */
gulp.task( 'styles', function () {
	gulp.src( watch.styles.source )
		.pipe( plugins.sourcemaps.init() )
		.pipe( plugins.sass( {
			errLogToConsole: true,
			includePaths: ['./sass'],
			outputStyle: 'compact',
			precision: 10
		} ) )
		.on('error', console.error.bind(console))
		.pipe( plugins.autoprefixer( AUTOPREFIXER_BROWSERS ) )
		.pipe( plugins.sourcemaps.write ( './', { includeContent: false } ) )
		.pipe( gulp.dest( watch.styles.dest ) )
		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
		.pipe( plugins.mergeMediaQueries( { log: true } ) ) // Merge Media Queries
		.pipe( plugins.cssnano())
		.pipe( plugins.rename({
			prefix: project.name + '-'
		}))
		.pipe( gulp.dest( watch.styles.dest ) )


		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
		.pipe( browserSync.stream() ) // Reloads style.css if that is enqueued.
		.pipe( plugins.notify( { message: 'TASK: "styles" Completed! 💯', onLast: true } ) );
});

/**
 * Minifies PNG, JPEG, GIF and SVG images.
 */
gulp.task( 'images', function() {
	gulp.src( images.source )
		.pipe( plugins.imagemin({
			progressive: true,
			optimizationLevel: 3, // 0-7 low-high
			interlaced: true,
			svgoPlugins: [{removeViewBox: false}]
		}))
		.pipe( gulp.dest( images.dest ) )
		.pipe( plugins.notify( { message: 'TASK: "images" Completed! 💯', onLast: true } ) );
});

/**
 * WP POT Translation File Generator.
 */
gulp.task( 'translate', function () {
	return gulp.src( watch.php )
		.pipe( plugins.sort() )
		.pipe( plugins.wpPot( project.i18n ))
		.pipe( gulp.dest( project.i18n.path ) )
		.pipe( plugins.notify( { message: 'TASK: "translate" Completed! 💯', onLast: true } ) );
});

gulp.task( 'zipIt', function() {
	return gulp.src( zipFiles )
		.pipe( plugins.zip( project + '.zip' ) )
		.pipe( gulp.dest( './' ) );
});

tasks = [ 'translate', 'images', 'browser-sync', 'styles' ];

/**
 * Watches for file changes and runs specific tasks.
 */
gulp.task( 'default', tasks, function () {
	gulp.watch( watch.php, reload ); // Reload on PHP file changes.
	gulp.watch( watch.styles.source, ['styles', reload] ); // Reload on SCSS file changes.
});
