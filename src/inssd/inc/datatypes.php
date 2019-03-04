<?php
function create_cpt() {

    $labelsAmbassadors = array(
        'name' => 'Ambassadeurs',
        'singular_name' => 'Ambassadeur',
        'menu_name' => 'Ambassadeurs',
        'name_admin_bar' =>'Ambassadeur',
        'all_items' => 'Tous les ambassadeurs',
        'add_new_item' => 'Ajouter un nouvel ambassadeur',
        'add_new' => 'Ajouter',
        'new_item' => 'Nouvel ambassadeur',
        'edit_item' =>  'Editer l\'ambassadeur',
        'update_item' =>  'Mettre à jour l\'ambassadeur',
        'view_item' => 'Voir l\'ambassadeur',
        'view_items' =>  'Voir les ambassadeurs',
        'search_items' => 'Rechercher un ambassadeur',
        'not_found' => 'Non trouvé',
        'not_found_in_trash' =>  'Non trouvé dans la corbeille',
        'featured_image' => 'Image',
        'set_featured_image' => 'Mettre une image',
        'remove_featured_image' =>  'Retirer l\'image',
        'use_featured_image' =>  'Utiliser cette image',
    );

    $argsAmbassadors = array(
        'labels' => $labelsAmbassadors,
        'menu_icon' => 'dashicons-admin-users',
        'supports' => array('title', 'thumbnail', 'editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'taxonomies' => array( '' ),
        'rewrite' => array(
            'slug'          => 'ambassadeurs',
            'with_front'    => false,
        ),
    );
    register_post_type( 'tribe_organizer', $argsAmbassadors );

    $labelsEvents = array(
        'name' => 'Évènements',
        'singular_name' => 'Évènement',
        'menu_name' => 'Évènements',
        'name_admin_bar' =>'Évènement',
        'all_items' => 'Tous les évènements',
        'add_new_item' => 'Ajouter un nouvel évènement',
        'add_new' => 'Ajouter',
        'new_item' => 'Nouvel évènement',
        'edit_item' =>  'Editer l\'évènement',
        'update_item' =>  'Mettre à jour l\'évènement',
        'view_item' => 'Voir l\'évènement',
        'view_items' =>  'Voir les évènements',
        'search_items' => 'Rechercher un évènement',
        'not_found' => 'Non trouvé',
        'not_found_in_trash' =>  'Non trouvé dans la corbeille',
        'featured_image' => 'Image',
        'set_featured_image' => 'Mettre une image',
        'remove_featured_image' =>  'Retirer l\'image',
        'use_featured_image' =>  'Utiliser cette image',
    );

    $argsEvents = array(
        'labels' => $labelsEvents,
        'menu_icon' => 'dashicons-calendar',
        'supports' => array('title', 'thumbnail', 'editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'taxonomies' => array( '' ),
        'rewrite' => array(
            'slug'          => 'evenements',
            'with_front'    => false,
        ),
    );
    register_post_type( 'tribe_events', $argsEvents );

    $labelsThem = array(
        'name'                       => 'Thématique',
        'singular_name'              => 'Thématique',
        'search_items'               => 'Rechercher des thématiques',
        'popular_items'              => 'Thématiques populaires',
        'all_items'                  => 'Toutes les thématiques',
        'edit_item'                  => 'Modifier la thématique',
        'update_item'                => 'Mettre à jour la thématique',
        'add_new_item'               => 'Ajouter une thématique',
        'not_found'                  => 'aucune thématique trouvée',
        'menu_name'                  => 'Thématiques',
    );

    $argsThem = array(
        'hierarchical'          => true,
        'labels'                => $labelsThem,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'meta_box_cb' => 'post_categories_meta_box',
        'rewrite' => array(
            'slug'          => '',
            'with_front'    => false,
            'hierarchical'    => true,
        ),
    );
    register_taxonomy( 'tribe_events_cat', 'tribe_events', $argsThem );

    $labelsProjects = array(
        'name' => 'Projets',
        'singular_name' => 'Projet',
        'menu_name' => 'Projets',
        'name_admin_bar' =>'Projet',
        'all_items' => 'Tous les projets',
        'add_new_item' => 'Ajouter un nouveau projet',
        'add_new' => 'Ajouter',
        'new_item' => 'Nouveau projet',
        'edit_item' =>  'Editer le projet',
        'update_item' =>  'Mettre à jour le projet',
        'view_item' => 'Voir le projet',
        'view_items' =>  'Voir les projets',
        'search_items' => 'Rechercher un projet',
        'not_found' => 'Non trouvé',
        'not_found_in_trash' =>  'Non trouvé dans la corbeille',
        'featured_image' => 'Image',
        'set_featured_image' => 'Mettre une image',
        'remove_featured_image' =>  'Retirer l\'image',
        'use_featured_image' =>  'Utiliser cette image',
    );

    $argsProjects = array(
        'labels' => $labelsProjects,
        'menu_icon' => 'dashicons-admin-customizer',
        'supports' => array('title', 'thumbnail', 'editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'taxonomies' => array( '' ),
        'rewrite' => array(
            'slug'          => 'projets',
            'with_front'    => false,
        ),
    );
    register_post_type( 'inssd-projet', $argsProjects );

    $labelsThemProj = array(
        'name'                       => 'Thématique',
        'singular_name'              => 'Thématique',
        'search_items'               => 'Rechercher des thématiques',
        'popular_items'              => 'Thématiques populaires',
        'all_items'                  => 'Toutes les thématiques',
        'edit_item'                  => 'Modifier la thématique',
        'update_item'                => 'Mettre à jour la thématique',
        'add_new_item'               => 'Ajouter une thématique',
        'not_found'                  => 'aucune thématique trouvée',
        'menu_name'                  => 'Thématiques',
    );

    $argsThemProj = array(
        'hierarchical'          => true,
        'labels'                => $labelsThemProj,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'meta_box_cb' => 'post_categories_meta_box',
        'rewrite' => array(
            'slug'          => '',
            'with_front'    => false,
            'hierarchical'    => true,
        ),
    );
    register_taxonomy( 'catprojet', 'inssd-projet', $argsThemProj );

}
add_action( 'init', 'create_cpt', 0 );