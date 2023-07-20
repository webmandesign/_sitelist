<?php
/**
 * List of WordPress multisite sites
 *
 * @package    _Multisite Site List
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.8.0
 */
class SiteList {

	/**
	 * Initialization.
	 *
	 * @since    1.0.0
	 * @version  1.6.0
	 */
	public static function init() {

		// Processing

			// Hooks

				// Actions

					add_action( 'after_setup_theme', __CLASS__ . '::setup' );

					add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets' );

					add_action( 'tha_html_before', __CLASS__ . '::doctype' );

					add_action( 'wp_head', __CLASS__ . '::head', 0 );

					add_action( 'tha_content_top', __CLASS__ . '::list' );

	} // /init

	/**
	 * Theme setup.
	 *
	 * @since    1.0.0
	 * @version  1.6.0
	 */
	public static function setup() {

		// Processing

			add_theme_support( 'title-tag' );

			add_theme_support( 'html5', array(
				'caption',
				'comment-form',
				'comment-list',
				'gallery',
				'navigation-widgets',
				'search-form',
				'script',
				'style',
			) );

	} // /setup

	/**
	 * HTML doctype.
	 *
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public static function doctype() {

		// Output

			echo '<!DOCTYPE html>';

	} // /doctype

	/**
	 * HTML head.
	 *
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public static function head() {

		// Variables

			$output = array();


		// Processing

			$output[10] = '<meta charset="' . get_bloginfo( 'charset' ) . '">';
			$output[20] = '<meta name="viewport" content="width=device-width, initial-scale=1">';
			$output[30] = '<link rel="profile" href="http://gmpg.org/xfn/11">';


		// Output

			echo implode( "\r\n", $output ) . "\r\n";

	} // /head

	/**
	 * Assets.
	 *
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public static function assets() {

		// Processing

			wp_enqueue_style( '_sitelist_styles', get_stylesheet_uri() );

	} // /assets

	/**
	 * List of sites.
	 *
	 * @since    1.0.0
	 * @version  1.8.0
	 */
	public static function list() {

		// Variables

			$output = array();

			$args_sites = array(
				'site__not_in' => array( 1 ),
				'public'       => 1,
				'order'        => 'DESC',
			);

				// Display all sites for admins.
				if ( current_user_can( 'edit_theme_options' ) ) {
					unset( $args_sites['public'] );
				}

			$sites = get_sites( $args_sites );


		// Processing

			foreach ( $sites as $site ) {

				$site = get_blog_details( $site->blog_id );

				$t = wp_get_theme( get_blog_option( $site->blog_id, 'stylesheet' ) );

				$class  = 'theme--' . sanitize_title( $t->get_template() );
				$class .= ( $site->archived || $site->deleted || $site->mature || $site->spam ) ? ( ' is-alt' ) : ( '' );
				$class .= ( $site->archived ) ? ( ' is-archived' ) : ( '' );
				$class .= ( $site->deleted ) ? ( ' is-deleted' ) : ( '' );
				$class .= ( $site->mature ) ? ( ' is-mature' ) : ( '' );
				$class .= ( $site->spam ) ? ( ' is-spam' ) : ( '' );

				$theme['name']        = $t->get( 'Name' );
				$theme['description'] = $t->get( 'Description' );
				$theme['screenshot']  = $t->get_screenshot();
				$theme['url']         = $t->get( 'ThemeURI' );

				$output_single  = '<li class="site ' . esc_attr( $class ) . '">';
				$output_single .= '<a href="' . esc_url( $site->siteurl ) . '">';
				$output_single .= '<div class="site-image"><img src="' . esc_url( $theme['screenshot'] ) . '" alt="' . esc_attr( $theme['name'] ) . ' Theme Demo Website" /></div>';
				$output_single .= '<h2 class="site-title" title="' . esc_attr( $theme['name'] ) . ' Theme Demo Website">' . $site->blogname . ' <small>' . $theme['name'] . ' Theme Demo</small></h2>';
				$output_single .= '</a>';

				// Admin link.
				if ( current_user_can( 'edit_theme_options' ) ) {
					$output_single .= '<a href="' . esc_url( get_admin_url( $site->blog_id, 'edit.php?post_type=page' ) ) . '" class="link-admin">';
					$output_single .= '<span>Admin</span>';
					$output_single .= '</a>';
				}

				$output_single .= '</li>';

				$output[] = $output_single;
			}


		// Output

			if ( ! empty( $output ) ) {
				echo '<h1>Themes by <a href="http://www.webmandesign.eu">WebMan Design</a></h1>';
				echo '<ul class="sites">' . PHP_EOL . implode( PHP_EOL, $output ) . PHP_EOL . '</ul>';
			}

	} // /list

}

add_action( 'after_setup_theme', 'SiteList::init', -10 );
