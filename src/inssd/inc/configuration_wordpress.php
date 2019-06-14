<?php
function inssd_setup() {

	load_theme_textdomain( 'inssd', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
			'search-form',
			'gallery',
			'caption',
		),
		'post-thumbnails'
	);

	register_nav_menus( array(
		'header-top-menu' => 'Menu Principal',
		'footer-menu-bottom-col-1'     => 'Menu Footer Col 1',
		'footer-menu-bottom-col-2'     => 'Menu Footer Col 2',
		'footer-menu-bottom-col-3'     => 'Menu Footer Col 3',
	) );

	show_admin_bar( false );

    add_image_size( 'thumb_single_page_article', 800, 500, array( 'center', 'center' ) );
    add_image_size( 'thumb_ambassador_small', 80, 80, array( 'center', 'center' ) );
    add_image_size( 'thumb_small_single_page_article', 600, 400, array( 'center', 'center' ) );
    add_image_size( 'thumb_archive_page_project', 343, 200, array( 'center', 'center' ) );
    add_image_size( 'thumb_archive_page_ambassador', 156, 156, array( 'center', 'center' ) );
}

function acf_add_main_options() {
	if( function_exists('acf_add_options_page') ) {
		acf_add_options_page( 'Paramètres' );
	}
}

add_action( 'after_setup_theme', 'inssd_setup' );
add_action( 'wp_loaded', 'acf_add_main_options' );

//Get rid of tags on posts.
function unregister_tags_for_posts() {
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}
add_action( 'init', 'unregister_tags_for_posts' );

// Add picto to nav menu
add_filter('nav_menu_item_args', function ($args) {
    if ($args->theme_location == 'header-top-menu') {
        $args->link_before = '<span class="menu-item__picto"></span><span class="menu-item__label">';
        $args->link_after  = '</span>';
    }
    return $args;
}, 10, 3);

//SECURITY : disable feed
add_action('do_feed', 'itsme_disable_feed', 1);
add_action('do_feed_rdf', 'itsme_disable_feed', 1);
add_action('do_feed_rss', 'itsme_disable_feed', 1);
add_action('do_feed_rss2', 'itsme_disable_feed', 1);
add_action('do_feed_atom', 'itsme_disable_feed', 1);
add_action('do_feed_rss2_comments', 'itsme_disable_feed', 1);
add_action('do_feed_atom_comments', 'itsme_disable_feed', 1);

//SECURITY : remove wp version
remove_action('wp_head', 'wp_generator');

function itsme_disable_feed() {
    wp_die( __( 'Non disponible, <a href="'. esc_url( home_url( '/' ) ) .'">accueil</a>' ) );
}

//SECURITY :  remove version from rss
add_filter('the_generator', '__return_empty_string');

//SECURITY :  remove version from scripts and styles
function remove_version_scripts_styles($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'remove_version_scripts_styles', 9999);

// YOAST remove version number
add_filter( 'wpseo_hide_version', '__return_true' );

add_action('wp_head',function() { ob_start(function($o) {
    return preg_replace('/^\n?<!--.*?[Y]oast.*?-->\n?$/mi','',$o);
}); },~PHP_INT_MAX);

//SECURITY : change errors hints
function no_wordpress_errors(){
    return 'Erreur d\'authentification !';
}
add_filter( 'login_errors', 'no_wordpress_errors' );

//SECURITY : disable xmlrpc
add_filter('xmlrpc_methods', function () {
    return [];
}, PHP_INT_MAX);

//SECURITY : Disable X-Pingback to header
add_filter( 'wp_headers', 'disable_x_pingback' );
function disable_x_pingback( $headers ) {
    unset( $headers['X-Pingback'] );

    return $headers;
}

//SECURITY : disable REST API
add_filter( 'rest_api_init', 'rest_only_for_authorized_users', 99 );
function rest_only_for_authorized_users($wp_rest_server){
    if ( !is_user_logged_in() ) {
        wp_die('La parole est d\'argent, le silence est d\'or...','Non autorisé',403);
    }
}

//SECURITY : remove link rsd
remove_action( 'wp_head', 'rsd_link' );

//additional rewrite rule + pagination tested
function rewrite_search_slug() {
    add_rewrite_rule(
        'rechercher(/([^/]+))?(/([^/]+))?(/([^/]+))?/?',
        'index.php?s=$matches[2]&paged=$matches[6]',
        'top'
    );
}
add_action( 'init', 'rewrite_search_slug' );

function __search_by_title_only( $search, &$wp_query )
{
    global $wpdb;
    if(empty($search)) {
        return $search; // skip processing - no search term in query
    }
    $q = $wp_query->query_vars;

    if( $q['post_type'] !== 'tribe_organizer'){
        return $search;
    }
    $n = !empty($q['exact']) ? '' : '%';
    $search =
    $searchand = '';
    foreach ((array)$q['search_terms'] as $term) {
        $term = esc_sql($wpdb->esc_like($term));
        $search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
        $searchand = ' AND ';
    }
    if (!empty($search)) {
        $search = " AND ({$search}) ";
        if (!is_user_logged_in())
            $search .= " AND ($wpdb->posts.post_password = '') ";
    }
    return $search;
}
add_filter('posts_search', '__search_by_title_only', 500, 2);

function wpb_change_search_url() {
    if ( is_search() && ! empty( $_GET['s'] ) ) {
        wp_redirect( home_url( "/rechercher/" ) . urlencode( get_query_var( 's' ) ) );
        exit();
    }
}
add_action( 'template_redirect', 'wpb_change_search_url' );

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');
