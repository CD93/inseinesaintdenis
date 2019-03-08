<?php
/**
 * Configuration de WordPress
 */
define('THEME_DIR', get_template_directory() . '/');
define('THEME_URL', get_template_directory_uri().'/');
define('MAX_AMBASSADORS_PER_PAGE', 4);

if(!ENV_DEV){
    define( 'ACF_LITE' , true );
}

require_once( __DIR__ . '/lib/TwitterAPIExchange.php');
require_once( __DIR__ . '/inc/datatypes.php');
require_once( __DIR__ . '/inc/ExcelAmbassadors.php');

if(!ENV_DEV){
    require_once( __DIR__ . '/inc/acf.php');
}

require_once( __DIR__ . '/inc/configuration_wordpress.php');
require_once( __DIR__ . '/inc/methods.php');
require_once( __DIR__ . '/inc/ajax-methods.php');

// --------------------------
// Scripts et style
// --------------------------
add_action( 'init', 'scripts_site' );
function scripts_site(){
    if( !is_admin() || !is_user_logged_in() ){

        // Style
        wp_enqueue_style( 'style_principal', get_template_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/style.css' ) );

        // Script à injecter exemple :
        wp_enqueue_script( 'datepicker.min', get_template_directory_uri() . '/js/libs/datepicker.min.js', array( 'jquery' ), '1.0', false );
        wp_enqueue_script( 'jquery-form-elements', get_template_directory_uri() . '/js/libs/jquery-form-elements.js', array( 'jquery' ), '1.0', false );
        wp_enqueue_script( 'datepicker.fr', get_template_directory_uri() . '/js/libs/i18n/datepicker.fr.js', array( 'jquery' ), '1.0', false );
        wp_enqueue_script( 'jquery.validate.min', get_template_directory_uri() . '/js/libs/jquery.validate.min.js', array( 'jquery' ), '1.0', false );
        wp_enqueue_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=' . get_field('params_gmap_api_key', 'option') . '', array(), '', true);
        wp_enqueue_script( 'styles.gmaps', get_template_directory_uri() . '/js/styles.gmaps.js', array( 'jquery' ), '1.0', false );
        wp_enqueue_script( 'burger', get_template_directory_uri() . '/js/burger.js', array( 'jquery' ), '1.0', true );
        wp_enqueue_script( 'script', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '1.0', true );

        $dataToBePassedMain = array(
            'wp_ajax_url' => admin_url( 'admin-ajax.php' ),
            'wp_theme_url' => THEME_URL,
            'ajxApplyAmbassadorNonce'    => wp_create_nonce( 'applyAmbassadorNonce' ),
            'ajxSendEventNonce'    => wp_create_nonce( 'sendEventNonce' ),
            'ajxContactNonce'    => wp_create_nonce( 'contactNonce' ),
            'ajxSearchEventNonce'    => wp_create_nonce( 'searchEventNonce' ),
            'ajxSearchAmbassadorNonce'    => wp_create_nonce( 'searchAmbassadorNonce' ),
        );
        wp_localize_script('script','boData', $dataToBePassedMain);

    }
}
