<?php
/**
 * Executing Ajax process : Le même que celui du WordPress d'origine mais allégé
 *
 * @since 2.1.0
 */
define( 'DOING_AJAX', true );

// Require an action parameter
if ( empty( $_REQUEST['action'] ) )
    die( '0' );

//to the relative location of the wp-load.php
require_once( $_SERVER[ 'DOCUMENT_ROOT' ] . '/wp-load.php' );

/** Allow for cross-domain requests (from the front end). */
send_origin_headers();

@header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
@header( 'X-Robots-Tag: noindex' );

send_nosniff_header();

// Mise en cache
header( 'Pragma: cache' );
header( 'Expires: ' . gmdate( "D, d M Y H:i:s", time() + HOUR_IN_SECONDS ) . ' GMT' );
header( 'Cache-Control: public, max-age=' . HOUR_IN_SECONDS );

$action = esc_attr( trim( $_REQUEST[ 'action' ] ) );

if ( is_user_logged_in() ) {
    do_action( 'wp_ajax_' . $action );
} else {
    do_action( 'wp_ajax_nopriv_' . $action );
}

// Default status
die( '0' );
