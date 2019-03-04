<?php
get_template_part( 'partials/general/block', 'head' );
get_template_part( 'partials/general/block', 'top-nav' );

$featuredPostID = get_field('params_home_featured_post','option')[0];
$featuredPostTitle = get_the_title($featuredPostID);
$featuredPostChapo = get_field('chapeau', $featuredPostID);
$featuredPostLink = get_the_permalink( $featuredPostID );
$featuredPostTerm = get_the_terms( $featuredPostID, 'category' )[0];
$featuredPostThumbUrl = get_the_post_thumbnail_url( $featuredPostID,'thumb_single_page_article' );

$eventText = get_field('params_home_event_text','option');
?>


<main id="main" role="main" class="page-home" tabindex="-1">

    <div class="container">
        <div class="row container__cols">
            <div class="col-md-8">
                <div class="row">
                    <div class="section-block clearfix">
                        <div class="col-md-12">
                            <div class="block-news block-news--large">
                                <a href="<?php echo $featuredPostLink; ?>" class="block-news__link">
                                    <div class="block-news__link__img">
                                        <div class="block-img">
                                            <img src="<?php echo $featuredPostThumbUrl; ?>" class="" alt="">
                                        </div>
                                        <div class="category category--pink block-news__link__img__category"><?php echo $featuredPostTerm->name; ?></div>
                                    </div>

                                    <div class="block-news__link__text">
                                        <h2 class="title-h2 block-news__link__text__title">
                                            <?php echo $featuredPostTitle; ?>
                                        </h2>

                                        <p class="block-news__link__text__description"><?php echo $featuredPostChapo; ?> <span class="link block-news__link__link">lire la suite</span></p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <?php
                        $args = array (
                            'post_type' => 'post',
                            'post_status' => array('publish'),
                            'posts_per_page' => 4,
                            'order' => 'DESC',
                            'orderby' => 'date',
                            'post__not_in' => array($featuredPostID),
                        );
                        $newsQry = new WP_Query( $args );

                        if ( $newsQry->have_posts() ) {

                            while ( $newsQry->have_posts() ) {
                                $newsQry->the_post();

                                $newsID = $post->ID;
                                $newsTitle = get_the_title($newsID);
                                $newsChapeau = get_field('chapeau', $newsID);
                                $newsLink = get_the_permalink( $newsID );
                                $newsTerm = get_the_terms( $newsID, 'category' )[0];
                                $newsThumbUrl = get_the_post_thumbnail_url( $newsID,'thumb_small_single_page_article' );
                                ?>
                                <div class="col-md-6">
                                    <div class="block-news borders">
                                        <a href="<?php echo $newsLink; ?>" class="block-news__link">
                                            <div class="block-news__link__img">
                                                <div class="block-img">
                                                    <img src="<?php echo $newsThumbUrl; ?>" class="" alt="">
                                                </div>
                                                <div class="category category--yellow block-news__link__img__category"><?php echo $newsTerm->name; ?></div>
                                            </div>

                                            <div class="block-news__link__text">
                                                <h2 class="title-h2 block-news__link__text__title">
                                                    <?php echo wp_trim_words( $newsTitle,8, '...' ); ?>
                                                </h2>

                                                <p class="block-news__link__text__description"><?php echo wp_trim_words( $newsChapeau, 15, '...' ); ?> <span class="link block-news__link__link">lire la suite</span></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            wp_reset_postdata();
                        }
                        ?>
                        <div class="col-md-12 text-align-center">
                            <a href="<?php echo get_the_permalink( 4863 ); ?>" class="home-link btn btn--pink">Toutes les actualités</a>
                        </div>
                    </div>

                    <div class="section-block section-block--events-issd clearfix">
                        <div class="col-md-12 text-align-center">
                            <div class="heading">
                                <img class="heading__picto" src="<?php echo get_template_directory_uri(); ?>/img/common/picto-events.svg" />
                                <div class="heading__title">Évènements In Seine-Saint-Denis</div>
                            </div>
                        </div>

                        <?php
                        $args = array (
                            'post_type' => 'tribe_events',
                            'post_status' => array('publish'),
                            'posts_per_page' => 2,
                            'order' => 'DESC',
                            'orderby' => 'date',
                        );
                        $eventsQry = new WP_Query( $args );

                        if ( $eventsQry->have_posts() ) {

                            while ( $eventsQry->have_posts() ) {
                                $eventsQry->the_post();

                                $eventID = $post->ID;
                                $eventTitle = get_the_title($eventID);
                                $eventChapeau = get_field('chapeau', $eventID);
                                $eventLink = get_the_permalink( $eventID );
                                $eventTerm = get_the_terms( $eventID, 'tribe_events_cat' )[0]->name;

                                if( empty($eventTerm)){
                                    $eventTerm = 'événements';
                                }
                                $eventThumbUrl = get_the_post_thumbnail_url( $eventID,'thumb_small_single_page_article' );
                                ?>
                                <div class="col-md-6">
                                    <div class="block-events borders">
                                        <a href="<?php echo $eventLink; ?>" class="block-events__link">
                                            <div class="block-events__link__img">
                                                <div class="block-img">
                                                    <img src="<?php echo $eventThumbUrl; ?>" class="" alt="">
                                                </div>
                                                <div class="category category--pink block-events__link__img__category"><?php echo $eventTerm; ?></div>
                                            </div>

                                            <div class="block-events__link__text">
                                                <h2 class="title-h2 block-events__link__text__title">
                                                    <?php echo wp_trim_words( $eventTitle,8, '...' ); ?>
                                                </h2>

                                                <p class="block-events__link__text__description"><?php echo wp_trim_words( $eventChapeau, 15, '...' ); ?> <span class="link block-news__link__link">lire la suite</span></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            wp_reset_postdata();
                        }
                        ?>
                        <div class="col-md-12 text-align-center">
                            <a href="<?php echo get_post_type_archive_link('tribe_events'); ?>" class="home-link home-link--events btn btn--pink">Tous les évènements</a>
                        </div>
                    </div>
                    <?php
                    $thematiqueEventsArray = getEventsForMap();
                    ?>
                    <div class="section-block events clearfix">
                        <div class="events__infos">
                            <div class="col-md-6 events__infos__left">
                                <p class=""><?php echo $eventText; ?></p>
                                <div class="events__infos__viewer">
                                    <form class="events__infos__viewer__form">
                                        <select class="events__infos__select">
                                            <option>Toutes les thématiques</option>

                                            <!-- @todo pierro : dynamiser les attributs ci dessous  -->
                                            <!-- data-events-count est un atrribut qui doit contenir le nombre total events pour la thématique  -->
                                            <!-- Puis, boucler sur chacun des events afin de générer leur sattributs nécessaires : data-events-date-X, data-events-latlng-X et data-events-link-X -->
                                            <!-- data-events-link-0 correspond à son slug, ce la me permet de gérer le lien par la suite -->
                                            <!-- exemples ci dessous -->
                                            <?php
                                            foreach($thematiqueEventsArray as $keyID => $thematiqueEvents) {
                                                ?>
                                                <option
                                                    val="<?php echo $keyID; ?>"
                                                    data-events-count="<?php echo $thematiqueEvents['count'] ?>"
                                                    <?php
                                                        foreach($thematiqueEvents['events'] as $key => $event){
                                                            echo 'data-events-date-' . $key . '="' . $event['start_date'] . '"';
                                                            echo 'data-events-latlng-' . $key . '="' . $event['long_lat'] . '"';
                                                            echo 'data-events-link-' . $key . '="' . $event['link'] . '"';
                                                        }
                                                    ?>

                                                ><?php echo $thematiqueEvents['name'] ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </form>
                                    <div class="events__infos__calendar"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="events__map"></div>
                            </div>
                        </div>
                    </div>

                    <div class="section-block clearfix">
                        <div class="col-md-12">
                            <?php
                            get_template_part( 'partials/general/block', 'black-box-event' );
                            ?>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-3 col-md-offset-1">
                <?php
                get_template_part( 'partials/general/block', 'sidebar' );
                ?>
            </div>
        </div>
    </div>

</main>


<?php

get_template_part( 'partials/general/block', 'bottom-nav' );

get_template_part( 'partials/general/block', 'footer' );
