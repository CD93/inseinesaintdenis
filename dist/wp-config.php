<?php
/**

 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */


define('ENV_DEV', ( false !== strrpos( $_SERVER[ 'HTTP_HOST' ], 'inssd.code' ) ) );
define('ENV_PREPROD', ( false !== strrpos( $_SERVER[ 'HTTP_HOST' ], 'inssdv3-prod.integra.fr' ) ) );
define('ENV_PROD', ( !ENV_DEV && !ENV_PREPROD ) );

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', getenv('MYSQL_DATABASE'));

/** Utilisateur de la base de données MySQL. */
define('DB_USER', getenv('MYSQL_USER'));

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', getenv('MYSQL_PASSWORD'));

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', getenv('MYSQL_HOST'));

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');


xdebug_disable();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

if(ENV_DEV){
    ini_set('xdebug.var_display_max_depth', '10');
    ini_set('xdebug.var_display_max_children', '256');
    ini_set('xdebug.var_display_max_data', '1024');
}



/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'K7~F2QOJONA<f9r$v/5[<WP-}+!{.BzW0Xfw?+> |;nq-VTU5r*!fr_PYv<wI|b-');
define('SECURE_AUTH_KEY',  '|,@,TrHk%b=1pE$1`n,[^s(W@:-k4*(G5xduZq)!Rmk4Y6S`/8]~^dpc|qO7v+g/');
define('LOGGED_IN_KEY',    '&F>&+<(lp~If1ZDM)Ir,/oTI?I/+vV(`8-lI+h&l/7Kq;-x Rh5#&u(+x$#O}kn?');
define('NONCE_KEY',        'MyXtw/r+QJPh?@}I|Qgb?+eY:8].UYVP;*Wd:6BI[5&gz(~G?l39l-zDwI_}igrN');
define('AUTH_SALT',        'yTAM&qX<}?];o?4y[-KH*SJ4w+L:XzQ1]b;aY_M!(YSu9Z /8+Na||z<[kT,iqgO');
define('SECURE_AUTH_SALT', 'UV(i(}>7^ W:_jLgDU-OX?C:yiY:(e0?[+@d!w7eNp.D+~VIOUl6/`>7/i],@q4c');
define('LOGGED_IN_SALT',   '53wBm7z2();3AXWVH;Y5oMnG^|#{{-]*9%,G>P?%)-*+PdFrI)X]E.vo40zQqJVg');
define('NONCE_SALT',       '-35qa=g@yuQy9lY;a>#PD4)<c;+w.pB+v2>[3,wo62AMWfOLL4G9--8^ve%Q(-oM');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'in9ssd_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */


define('WP_DEBUG', ENV_DEV);

define( 'WP_POST_REVISIONS', 3 );

if(ENV_DEV){
    define('FS_METHOD','direct');
}

if(ENV_PROD){
	define('DISALLOW_FILE_EDIT',true);
	define('WP_AUTO_UPDATE_CORE', false );
    define('DISALLOW_FILE_MODS',true);
    define( 'CONCATENATE_SCRIPTS', true );
}

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
    $_SERVER['HTTPS'] = 'on';

$is_ssl = filter_var( empty( $_SERVER[ 'HTTPS' ] ) ? false : $_SERVER[ 'HTTPS' ], FILTER_VALIDATE_BOOLEAN );
if( isset( $_SERVER[ 'HTTP_HOST' ] ) ){
    /* Custom WordPress URL. */
    define( 'WP_SITEURL', sprintf( '%s://%s', $is_ssl ? 'https' : 'http', $_SERVER[ 'HTTP_HOST' ] ) );
    define( 'WP_HOME', sprintf( '%s://%s', $is_ssl ? 'https' : 'http', $_SERVER[ 'HTTP_HOST' ] ) );
    /* If SSL */
    if( $is_ssl ){
        define('FORCE_SSL_LOGIN', true);
        define('FORCE_SSL_ADMIN', true);
    }
}
// Sécurité
header('X-Frame-Options: SAMEORIGIN');
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
