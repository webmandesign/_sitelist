<?php
/**
 * List of WordPress multisite sites
 *
 * @package    _Multisite Site List
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.3.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Setup
 * 20) List of sites
 */
class SiteList {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						add_action( 'after_setup_theme', __CLASS__ . '::setup' );

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets' );

						add_action( 'tha_html_before', __CLASS__ . '::doctype' );

						add_action( 'wp_head', __CLASS__ . '::head', 1 );

						add_action( 'tha_content_top', __CLASS__ . '::list' );

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function init() {

			// Processing

				if ( null === self::$instance ) {
					self::$instance = new self;
				}


			// Output

				return self::$instance;

		} // /init





	/**
	 * 10) Setup
	 */

		/**
		 * Theme setup
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function setup() {

			// Processing

				// Title tag

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
					 */
					add_theme_support( 'title-tag' );

				// Enable HTML5 markup

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
					 */
					add_theme_support( 'html5', array(
							'caption',
							'comment-form',
							'comment-list',
							'gallery',
							'search-form',
						) );

		} // /setup



		/**
		 * HTML DOCTYPE
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function doctype() {

			// Output

				echo '<!DOCTYPE html>';

		} // /doctype



		/**
		 * HTML HEAD
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function head() {

			// Helper variables

				$output = array();


			// Processing

				$output[10] = '<meta charset="' . get_bloginfo( 'charset' ) . '">';
				$output[20] = '<meta name="viewport" content="width=device-width, initial-scale=1">';
				$output[30] = '<link rel="profile" href="http://gmpg.org/xfn/11">';


			// Output

				echo implode( "\r\n", $output ) . "\r\n";

		} // /head



		/**
		 * Assets
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function assets() {

			// Processing

				wp_enqueue_style( '_sitelist_styles', get_stylesheet_uri() );

		} // /assets





	/**
	 * 20) List of sites
	 */

		/**
		 * List of sites
		 *
		 * @since    1.0.0
		 * @version  1.3.0
		 */
		public static function list() {

			// Helper variables

				$output = array();

				$sites = get_sites( array(
					'site__not_in' => array( 1 ),
					'public'       => 1,
					'order'        => 'DESC',
				) );


			// Processing

				foreach ( $sites as $site ) {

					$t = wp_get_theme( basename( $site->path ) );

					$theme['name']        = $t->get( 'Name' );
					$theme['description'] = $t->get( 'Description' );
					$theme['screenshot']  = $t->get_screenshot();
					$theme['url']         = $t->get( 'ThemeURI' );

					$output_single = '';

					$output_single .= '<a href="' . esc_url( $site->domain . $site->path ) . '">';
					$output_single .= '<div class="site-image"><img src="' . esc_url( $theme['screenshot'] ) . '" alt="' . esc_attr( $theme['name'] ) . ' Theme Demo Website" /></div>';
					$output_single .= '<h2 class="site-title" title="' . esc_attr( $theme['name'] ) . ' Theme Demo Website">' . $theme['name'] . ' <small>Theme Demo</small></h2>';
					$output_single .= '</a>';

					// $output_single .= '<a href="' . esc_url( $theme['url'] ) . '" class="about-theme">More info about the theme &raquo;</a>';

					$output[] = $output_single;

				} // /foreach


			// Output

				if ( ! empty( $output ) ) {
					echo '<h1>Themes by <a href="http://www.webmandesign.eu">WebMan Design</a></h1>';
					echo '<ul class="sites"><li class="site">' . implode( '</li><li class="site">', $output ) . '</li></ul>';
				}


		} // /list





} // /SiteList

add_action( 'after_setup_theme', 'SiteList::init', -10 );
