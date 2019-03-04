<!DOCTYPE html>
<html lang="<?php echo ( defined( 'ICL_LANGUAGE_CODE' ) ) ? ICL_LANGUAGE_CODE : 'fr' ; ?>">
    <head>
        <meta charset="utf-8" />
        <?php $title =  (is_front_page() ? get_bloginfo('name') : wp_title('', false) . ' | ' . get_bloginfo('name') ); ?>
        <title><?php echo $title; ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- Copy & Paste Real Favicon Geenerator code : http://realfavicongenerator.net -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/img/app/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/img/app/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/img/app/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/img/app/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/img/app/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/img/app/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/img/app/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/img/app/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/img/app/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri(); ?>/img/app/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/img/app/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/img/app/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/img/app/favicon-16x16.png">
        <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/img/app/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/img/app/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <!-- Apple Mobile -->
        <link rel="apple-touch-icon-precomposed" href="">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/img/app/favicon.ico">
        <meta name='HandheldFriendly' content='true' />
        <meta name='format-detection' content='telephone=no' />
        <meta name="msapplication-tap-highlight" content="no">
        <!-- Add to Home Screen -->
        <meta name="apple-mobile-web-app-title" content="" />
        <meta name="apple-mobile-web-app-capable" content="no" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />

        <!-- Facebook Open Graph
        https://developers.facebook.com/tools/debug/sharing/
        https://developers.facebook.com/docs/sharing/webmasters#markup -->
        <meta property="fb:app_id" content="">

        <?php

        echo '<meta property="og:title" content="' . $title . '">';

        if( is_front_page() ){
            $url = site_url();
            echo '<meta property="og:url" content="' . $url . '"/>';
            echo '<meta property="og:type" content="website"/>';

            $defaultImageId = get_field('params_og_image', 'option');
            $thumbnail_src = wp_get_attachment_image_src( $defaultImageId, 'thumb_single_page_article' );

        }else if(is_post_type_archive('tribe_events') ){
            $url = get_post_type_archive_link( 'tribe_events' );
            echo '<meta property="og:url" content="' . $url . '"/>';
            echo '<meta property="og:type" content="website"/>';

            $defaultImageId = get_field('params_og_image', 'option');
            $thumbnail_src = wp_get_attachment_image_src( $defaultImageId, 'thumb_single_page_article' );

        }else if(is_post_type_archive('tribe_organizer') ){
            $url = get_post_type_archive_link( 'tribe_organizer' );
            echo '<meta property="og:url" content="' . $url . '"/>';
            echo '<meta property="og:type" content="website"/>';

            $defaultImageId = get_field('params_og_image', 'option');
            $thumbnail_src = wp_get_attachment_image_src( $defaultImageId, 'thumb_single_page_article' );

        } else if(is_post_type_archive('projet') ){
            $url = get_post_type_archive_link( 'projet' );
            echo '<meta property="og:url" content="' . $url . '"/>';
            echo '<meta property="og:type" content="website"/>';

            $defaultImageId = get_field('params_og_image', 'option');
            $thumbnail_src = wp_get_attachment_image_src( $defaultImageId, 'thumb_single_page_article' );

        }else if(is_page() ){
            $url = get_the_permalink();
            echo '<meta property="og:url" content="' . $url . '"/>';
            echo '<meta property="og:type" content="website"/>';

            $defaultImageId = get_field('params_og_image', 'option');
            $thumbnail_src = wp_get_attachment_image_src( $defaultImageId, 'thumb_single_page_article' );
        }else if(is_singular() ){
            $url = get_the_permalink();

            echo '<meta property="og:type" content="article"/>';
            echo '<meta property="og:url" content="' . $url . '"/>';
            echo '<meta property="article:author" content="' . get_the_author() . '">';

            if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
                $defaultImageId = get_field('params_og_image', 'option');
                $thumbnail_src = wp_get_attachment_image_src( $defaultImageId, 'thumb_single_page_article' );
            }
            else{
                $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumb_single_page_article' );
            }
        }

        ?>
        <meta property="og:image" content="<?php echo esc_attr( $thumbnail_src[0] ); ?>"/>
        <meta property="og:image:width" content="800" />
        <meta property="og:image:height" content="500" />
        <meta property="og:description" content="<?php bloginfo( 'description' ); ?>">
        <meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>">
        <meta property="og:locale" content="fr_FR">

        <!-- Twitter Card
        https://cards-dev.twitter.com/validator
        https://dev.twitter.com/cards/getting-started -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@site_account">
        <meta name="twitter:creator" content="@individual_account">
        <meta name="twitter:url" content="<?php echo $url; ?>">
        <meta name="twitter:title" content="<?php echo $title; ?>">
        <meta name="twitter:description" content="<?php bloginfo( 'description' ); ?>">
        <meta name="twitter:image" content="<?php echo esc_attr( $thumbnail_src[0] ); ?>">
        <!-- Google / Search Engine Tags -->
        <meta itemprop="name" content="<?php echo $title; ?>">
        <meta itemprop="description" content="<?php bloginfo( 'description' ); ?>">
        <meta itemprop="image" content="<?php echo esc_attr( $thumbnail_src[0] ); ?>">
        <!-- Meta Tags Generated via http://heymeta.com -->
        <!-- http://humanstxt.org -->
        <link type="text/plain" rel="author" href="" />

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,700,700i,800" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Caveat+Brush" rel="stylesheet">

        <?php
        wp_head(); ?>

    </head>

    <body <?php body_class(); ?>>
