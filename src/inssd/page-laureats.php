<?php

/**
 * - Template Name: Les Lauréats
 */

get_template_part('partials/general/block', 'head');
get_template_part('partials/general/block', 'top-nav');

$paged = 1;

?>
    <main id="main" role="main" class="page-laureates" tabindex="-1">

        <div class="container">
            <div class="row container__cols">
                <div class="col-md-8">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="clearfix section-block">
                                <h1 class="title-h1">Nos lauréats</h1>

                                <?php

                                if ( have_posts() ) {
                                    while ( have_posts() ) {
                                        the_post();
                                        the_content();
                                    } // end while
                                } // end if

                                $themTerms = get_terms( array(
                                    'taxonomy' => 'laureat_thematique',
                                    'hide_empty' => false,
                                ) );

                                $subThemTerms = get_terms( array(
                                    'taxonomy' => 'laureat_sub_thematique',
                                    'hide_empty' => false,
                                ) );

                                $zoneTerms = get_terms( array(
                                    'taxonomy' => 'laureat_zone',
                                    'hide_empty' => false,
                                ) );

                                ?>
                                <div class="laureates-form-wrapper" id="laureates-form">
                                    <form id="laureates-form">
                                        <div class="form-element">
                                            <div class="form-control form-control--3col">
                                                <select class="" id="laureates-thematic" name="laureatesThematic">
                                                    <option value="">Thématique</option>
                                                    <?php
                                                    foreach($themTerms as $themTerm){
                                                        echo '<option value="' . $themTerm->term_id . '">' . $themTerm->name . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-control form-control--3col">
                                                <select class="" id="laureates-sub-thematic" name="laureatesSubThematic">
                                                    <option value="">Sous-Thématique</option>
                                                    <?php
                                                    foreach($subThemTerms as $subThemTerm){
                                                        echo '<option value="' . $subThemTerm->term_id . '">' . $subThemTerm->name . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-control form-control--3col">
                                                <select class="" id="laureates-zone" name="laureatesZone">
                                                    <option value="">Zone</option>
                                                    <?php
                                                    foreach($zoneTerms as $zoneTerm){
                                                        echo '<option value="' . $zoneTerm->term_id . '">' . $zoneTerm->name . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <input type="text" id="laureates-association" name="laureatesAssociation" placeholder="Nom de l'association">
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <input type="text" id="laureates-project" name="laureatesProject" placeholder="Nom du projet">
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <button class="btn btn--black btn--round" type="submit">Rechercher</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <div class="spinner spinner--laureates">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                                <?php

                                $paged = 1;

                                $args = array(
                                    'post_type' => 'laureat',
                                    'post_status' => array('publish'),
                                    'posts_per_page' => MAX_LAUREATS_PER_PAGE,
                                    'order' => 'ASC',
                                    'orderby' => 'name',
                                );

                                $laureatesQry = new WP_Query($args);
                                $laureatesCount = $laureatesQry->found_posts;

                                if ($laureatesQry->have_posts()) {
                                    ?>
                                    <div class="laureates-blocks">
                                        <?php

                                        while ($laureatesQry->have_posts()) {
                                            $laureatesQry->the_post();

                                            $laureateID = $post->ID;
                                            $laureateTitle = get_the_title($laureateID);

                                            $customFieldsLaureate = get_fields();

                                            $laureatThumbUrl = get_the_post_thumbnail_url($laureateID, 'thumb_archive_page_ambassador');
                                            if (!$laureatThumbUrl) {
                                                $laureatThumbUrl = THEME_URL . 'img/ambassador_default.jpg';
                                            }

                                            ?>
                                            <div class="laureate-block">
                                                <h2 class="title-h2 laureate__name"><?php echo $laureateTitle; ?></h2>
                                               
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="laureate__infos">
                                                            <div class="laureate__avatar"><img
                                                                    src="<?php echo $laureatThumbUrl; ?>" alt=""
                                                                    title=""></div>

                                                            <ul class="laureate__specialties">
                                                                <?php 
                                                                if (!empty($customFieldsLaureate['laureat_organism_name']) || !empty($customFieldsLaureate['laureat_director_name'])  ) {
                                                                ?>
                                                                    <li class="laureate__specialty laureate__specialty--association">
                                                                        <span class="laureate__specialty-icon"><i></i></span>
                                                                        <p>
                                                                            <?php echo $customFieldsLaureate['laureat_organism_name']; ?>
                                                                            <br>
                                                                            <?php echo $customFieldsLaureate['laureat_director_name']; ?>
                                                                        </p>
                                                                    </li>
                                                                <?php 
                                                                }

                                                                $zones = get_the_terms($laureateID, 'laureat_zone');

                                                                if (!empty($zones) ) {
                                                                    ?>
                                                                    <li class="laureate__specialty laureate__specialty--zone">
                                                                        <span class="laureate__specialty-icon"><i></i></span>
                                                                        <p>
                                                                            <?php
                                                                            $zonesStr = '';
                                                                            foreach($zones as $zone){
                                                                                $zonesStr .= $zone->name;
                                                                                if( end($zones) !== $zone){
                                                                                    $zonesStr .= '<br>';
                                                                                }
                                                                            }
                                                                            echo $zonesStr;

                                                                            ?>
                                                                        </p>
                                                                    </li>
                                                                <?php 
                                                                }
                                                                $thems = get_the_terms($laureateID, 'laureat_thematique');
                                                                $subThems = get_the_terms($laureateID, 'laureat_sub_thematique');

                                                                if ( !empty($thems) || !empty($subThems) ) {
                                                                ?>
                                                                    <li class="laureate__specialty laureate__specialty--thematic">
                                                                        <span class="laureate__specialty-icon"><i></i></span>
                                                                        <p>
                                                                            <?php
                                                                            if ( !empty($thems) ) {
                                                                                $themsStr = '';
                                                                                foreach($thems as $them){
                                                                                    $themsStr .= $them->name;
                                                                                    if( end($thems) !== $them){
                                                                                        $themsStr .= '<br>';
                                                                                    }
                                                                                }
                                                                                echo $themsStr;
                                                                                if ( !empty($subThems) ) {
                                                                                    echo '<br>';
                                                                                }
                                                                            }
                                                                            if ( !empty($subThems) ) {
                                                                                $subThemsStr = '';
                                                                                foreach($subThems as $subThem){
                                                                                    $subThemsStr .= $subThem->name;
                                                                                    if( end($subThems) !== $subThem){
                                                                                        $subThemsStr .= '<br>';
                                                                                    }
                                                                                }
                                                                                echo $subThemsStr;
                                                                            }
                                                                            ?>
                                                                        </p>
                                                                    </li>
                                                                <?php 
                                                                 }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <?php

                                                        if ((!empty($customFieldsLaureate['laureat_social_network']['facebook']))
                                                            || (!empty($customFieldsLaureate['laureat_social_network']['twitter']))
                                                            || (!empty($customFieldsLaureate['laureat_social_network']['instagram']) )) {
                                                            ?>
                                                            <div class="laureate__actions">
                                                                <h2 class="title-h2">Ses réseaux sociaux</h2>

                                                                <ul class="laureate__socials social">
                                                                    <?php if (!empty($customFieldsLaureate['laureat_social_network']['facebook'])) { ?>
                                                                        <li class="laureate__social social__item"><i
                                                                                class="social__item-icon fab fa-facebook-f"></i><a
                                                                                href="<?php echo $customFieldsLaureate['laureat_social_network']['facebook']; ?>"><?php echo $customFieldsLaureate['laureat_social_network']['facebook']; ?></a>
                                                                        </li>
                                                                    <?php }
                                                                    if (!empty($customFieldsLaureate['laureat_social_network']['twitter'])) {
                                                                        ?>
                                                                        <li class="laureate__social social__item"><i
                                                                                class="social__item-icon fab fa-twitter"></i><a
                                                                                href="<?php echo $customFieldsLaureate['laureat_social_network']['twitter']; ?>"><?php echo $customFieldsLaureate['laureat_social_network']['twitter']; ?></a>
                                                                        </li>
                                                                    <?php }
                                                                    if (!empty($customFieldsLaureate['laureat_social_network']['instagram'])) {
                                                                        ?>
                                                                        <li class="laureate__social social__item"><i
                                                                                class="social__item-icon fab fa-instagram"></i>
                                                                            <a href="<?php echo $customFieldsLaureate['laureat_social_network']['instagram']; ?>"><?php echo $customFieldsLaureate['laureat_social_network']['instagram']; ?></a>
                                                                        </li>
                                                                    <?php }
                                                                    if (!empty($customFieldsLaureate['laureat_email'])) {
                                                                        ?>
                                                                        <li class="laureate__social social__item"><i
                                                                                    class="social__item-icon fas fa-envelope"></i>
                                                                            <a href="<?php echo 'mailto:' . $customFieldsLaureate['laureat_email']; ?>"><?php echo $customFieldsLaureate['laureat_email']; ?></a>
                                                                        </li>
                                                                    <?php } ?>

                                                                </ul>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <?php 
                                                 if (!empty($customFieldsLaureate['laureat_text'])) {
                                                ?>
                                                    <div class="laureate__specialty laureate__specialty--desc">
                                                        <span class="laureate__specialty-icon"><i></i></span>
                                                        <p><?php echo $customFieldsLaureate['laureat_text']; ?></p>
                                                    </div>
                                                <?php 
                                                 }

                                                if(!empty($customFieldsLaureate['laureat_ambassador'])) {

                                                    $ambassadorPost = get_post($customFieldsLaureate['laureat_ambassador'][0]);
                                                    $ambassadorID = $ambassadorPost->ID;

                                                    $ambassadorName = ucfirst( strtolower( get_field('nom_amb', $ambassadorID) ) );
                                                    $ambassadorFirstName = ucfirst( strtolower(get_field('prenom_ambassadeur', $ambassadorID) ) );
                                                    $ambLink = get_permalink($ambassadorID);
                                                    $ambassadorThumbUrl = get_the_post_thumbnail_url($ambassadorID, 'thumb_ambassador_small');

                                                    if (!$ambassadorThumbUrl) {
                                                        $ambassadorThumbUrl = THEME_URL . 'img/ambassador_default.jpg';
                                                    }

                                                    ?>
                                                    <a href="<?php echo $ambLink; ?>" class="laureate__ambassador">
                                                        <div class="laureate-ambassador__avatar-wrapper">
                                                            <div class="laureate-ambassador__avatar"><img src="<?php echo $ambassadorThumbUrl; ?>" alt="" title=""></div>
                                                        </div>
                                                        <p>Ambassadeur : <?php echo $ambassadorFirstName . ' ' . $ambassadorName;?></p>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                                </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="laureates-pagination">
                                        <?php
                                        wp_pagination( $laureatesQry, $paged, true);
                                        ?>
                                    </div>
                                    <?php
                                    wp_reset_postdata();
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-3 col-md-offset-1">
                    <?php
                    get_template_part('partials/general/block', 'sidebar');
                    ?>
                </div>
            </div>
        </div>

    </main>

<?php

get_template_part('partials/general/block', 'bottom-nav');

get_template_part('partials/general/block', 'footer');
