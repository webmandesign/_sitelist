<?php do_action( 'tha_html_before' ); ?>

<html class="no-js" <?php language_attributes(); ?>>

<head>

<?php

do_action( 'tha_head_top' );
do_action( 'tha_head_bottom' );

wp_head();

?>

</head>

<body <?php body_class(); ?>>

<?php

wp_body_open();

do_action( 'tha_body_top' );

do_action( 'tha_header_before' );
do_action( 'tha_header_top' );
do_action( 'tha_header_bottom' );
do_action( 'tha_header_after' );

do_action( 'tha_content_before' );
do_action( 'tha_content_top' );
