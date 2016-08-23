<?php
/**
 * The template for displaying the footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    _Multisite Site List
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





/**
 * Content
 */

	do_action( 'tha_content_bottom' );

	do_action( 'tha_content_after' );



/**
 * Footer
 */

	if ( ! apply_filters( 'wmhook_sitelist_disable_footer', false ) ) {

		do_action( 'tha_footer_before' );

		do_action( 'tha_footer_top' );

		do_action( 'tha_footer_bottom' );

		do_action( 'tha_footer_after' );

	}



/**
 * Body and WordPress footer
 */

	do_action( 'tha_body_bottom' );

	wp_footer();

?>

</body>

</html>
