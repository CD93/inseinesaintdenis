<?php

/**
 * - Template Name: Recherche
 */

get_template_part('partials/general/block', 'head');
get_template_part('partials/general/block', 'top-nav');

$search = get_query_var('s');

?>


    <main id="main" role="main" class="page-search" tabindex="-1">

        <div class="container">
            <div class="row container__cols">
                <div class="col-md-8">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="clearfix section-block">
                                <h1 class="title-h1">Résultats</h1>

                                <?php
                                $args = array(
                                    'post_type' => 'post',
                                    'post_status' => array('publish'),
                                    'posts_per_page' => -1,
                                    'order' => 'DESC',
                                    'orderby' => 'date',
                                    's' => $search,
                                );
                                $newsQry = new WP_Query($args);

                                if ($newsQry->have_posts()) {
                                    $newsCount = $newsQry->found_posts;
                                    ?>
                                    <div class="searh-block searh-block--news">
                                        <h2 class="title-h2 main-h2">Articles
                                            (<span><?php echo $newsCount; ?></span> <?php echo 'résultat' . (($newsCount > 1) ? 's' : ''); ?>)</h2>

                                        <div class="row">
                                            <?php
                                            while ($newsQry->have_posts()) {
                                                $newsQry->the_post();

                                                $newsID = $post->ID;
                                                $newsTitle = get_the_title($newsID);
                                                $newsChapeau = get_field('chapeau', $newsID);
                                                $newsLink = get_the_permalink($newsID);
                                                $newsTerm = get_the_terms($newsID, 'category')[0];
                                                $newsThumbUrl = get_the_post_thumbnail_url($newsID, 'thumb_small_single_page_article');
                                                ?>
                                                <div class="col-md-6">
                                                    <div class="block-news borders">

                                                            <div class="block-news__link__img">
                                                                <div class="block-img">
                                                                    <img src="<?php echo $newsThumbUrl; ?>" class=""
                                                                         alt="">
                                                                </div>
                                                                <div class="category-element category--yellow block-news__link__img__category"><a href="<?php echo get_category_link($newsTerm->term_id); ?>" class=""><?php echo $newsTerm->name; ?></a></div>
                                                            </div>
                                                        <a href="<?php echo $newsLink; ?>" class="block-news__link">
                                                            <div class="block-news__link__text">
                                                                <h2 class="title-h2 block-news__link__text__title">
                                                                    <?php echo wp_trim_words($newsTitle, 8, '...'); ?>
                                                                </h2>

                                                                <p class="block-news__link__text__description"><?php echo wp_trim_words($newsChapeau, 15, '...'); ?>
                                                                    <span class="link block-news__link__link">lire la suite</span>
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            wp_reset_postdata();
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }

                                $args = array(
                                    'post_type' => 'inssd-projet',
                                    'post_status' => array('publish'),
                                    'posts_per_page' => -1,
                                    'order' => 'DESC',
                                    'orderby' => 'date',
                                    's' => $search,
                                );
                                $projectsQry = new WP_Query($args);

                                if ($projectsQry->have_posts()) {
                                    $projectsCount = $projectsQry->found_posts;
                                    ?>
                                    <div class="searh-block">
                                        <h2 class="title-h2 main-h2">Projets
                                            (<span><?php echo $projectsCount; ?></span> <?php echo 'résultat' . (($projectsCount > 1) ? 's' : ''); ?>)</h2>
                                        <?php

                                        while ($projectsQry->have_posts()) {
                                            $projectsQry->the_post();

                                            $projectID = $post->ID;
                                            $projectTitle = get_the_title($projectID);
                                            $projectLink = get_the_permalink($projectID);
                                            $projectTerm = get_the_terms($projectID, 'catprojet')[0];
                                            $projectThumbUrl = get_the_post_thumbnail_url($projectID, 'thumb_archive_page_project');
                                            $projectCustomFields = get_fields();
                                            $alreadyLiked = false;
                                            //$projectCustomFields['project_linked_ambassador']
                                            ?>
                                            <div class="row project__lign">
                                                <div class="col-md-6">
                                                    <div class="project__visual">
                                                        <div class="block-img">
                                                            <img src="<?php echo $projectThumbUrl; ?>" class="" alt="">
                                                            <div class="strap">
                                                    <span class="strap__content">
                                                        <span class="strap__icon <?php echo($alreadyLiked ? 'strap__icon--actif' : ''); ?>"><i
                                                                    class="far fa-heart"></i></span>
                                                        <p class="strap__like"><?php echo $projectCustomFields['project_vote']; ?></p></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="project__infos">
                                                        <div class="project__head">
                                                            <span class="project__category hidden-xs"><?php echo $projectTerm->name; ?></span>
                                                            <h2 class="title-h2 project__title"><?php echo $projectTitle; ?></h2>
                                                        </div>

                                                        <p><?php echo wp_trim_words($projectCustomFields['chapeau'], 25, '...'); ?></p>

                                                        <div class="project__actions">
                                                            <ul class="project__socials social">
                                                                <li class="project__social social__item"><i
                                                                            class="social__item-icon fab fa-facebook-f"></i><a
                                                                            href="">loremipusm</a></li>
                                                                <li class="project__social social__item"><i
                                                                            class="social__item-icon fab fa-twitter"></i><a
                                                                            href="">loremipusm</a></li>
                                                                <li class="project__social social__item"><i
                                                                            class="social__item-icon fab fa-linkedin"></i>
                                                                    <a href="">linkedin/loremipusm</a></li>
                                                                <li class="project__social social__item"><i
                                                                            class="social__item-icon far fa-envelope"></i>
                                                                    <a href="mailto:">loremipsum@ipsum.com</a></li>
                                                            </ul>

                                                            <a href="<?php echo $projectLink; ?>"
                                                               title="SOUTENIR CE PROJET - nouvelle fenêtre"
                                                               class="btn btn--pink btn--round project__btn">SOUTENIR CE
                                                                PROJET</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        wp_reset_postdata();
                                        ?>
                                    </div>
                                    <?php
                                }

                                $args = array(
                                    'post_type' => 'tribe_organizer',
                                    'post_status' => array('publish'),
                                    'posts_per_page' => -1,
                                    'order' => 'DESC',
                                    'orderby' => 'date',
                                    's' => $search,
                                );
                                $ambassadorsQry = new WP_Query($args);
                                $ambassadorsCount = $ambassadorsQry->found_posts;

                                if ($ambassadorsQry->have_posts()) {
                                    ?>
                                    <div class="searh-block">
                                        <h2 class="title-h2 main-h2">Ambassadeurs
                                            (<span><?php echo $ambassadorsCount; ?></span> <?php echo 'résultat' . (($ambassadorsCount > 1) ? 's' : ''); ?>)</h2>
                                        <?php
                                        while ($ambassadorsQry->have_posts()) {
                                            $ambassadorsQry->the_post();

                                            $ambassadorID = $post->ID;
                                            $ambassadorTitle = get_the_title($ambassadorID);

                                            $ambassadorLink = get_the_permalink($ambassadorID);
                                            $ambassadorThumbUrl = get_the_post_thumbnail_url($ambassadorID, 'thumb_archive_page_ambassador');

                                            $customFieldsAmbassador = get_fields();

                                            if (!$ambassadorThumbUrl) {
                                                $ambassadorThumbUrl = THEME_URL . 'img/ambassador_default.jpg';
                                            }

                                            ?>
                                            <div class="ambassador-block">
                                                <h2 class="title-h2 ambassador__name"><?php echo $customFieldsAmbassador['prenom_ambassadeur'] . ' ' . $customFieldsAmbassador['nom_amb']; ?></h2>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="ambassador__infos">
                                                            <div class="ambassador__avatar"><img
                                                                        src="<?php echo $ambassadorThumbUrl; ?>" alt=""
                                                                        title=""></div>

                                                            <ul class="ambassador__specialties">
                                                                <?php if (!empty($customFieldsAmbassador['fonction'])) { ?>
                                                                    <li class="ambassador__specialty ambassador__specialty--function">
                                                                        <span class="ambassador__specialty-icon"><i></i></span>
                                                                        <p>
                                                                            <span>Fonction</span><?php echo $customFieldsAmbassador['fonction']; ?>
                                                                        </p>
                                                                    </li>
                                                                <?php }
                                                                if (!empty($customFieldsAmbassador['soc_org'])) { ?>
                                                                    <li class="ambassador__specialty ambassador__specialty--business">
                                                                        <span class="ambassador__specialty-icon"><i></i></span>
                                                                        <p>
                                                                            <span>Entreprise</span><?php echo $customFieldsAmbassador['soc_org']; ?>
                                                                        </p>
                                                                    </li>
                                                                <?php }
                                                                if (!empty($customFieldsAmbassador['ville_amb'])) { ?>
                                                                    <li class="ambassador__specialty ambassador__specialty--city">
                                                                        <span class="ambassador__specialty-icon"><i></i></span>
                                                                        <p>
                                                                            <span>Ville</span><?php echo $customFieldsAmbassador['ville_amb']; ?>
                                                                        </p>
                                                                    </li>
                                                                <?php }
                                                                if (!empty($customFieldsAmbassador['sec_act'])) { ?>
                                                                    <li class="ambassador__specialty ambassador__specialty--domain">
                                                                        <span class="ambassador__specialty-icon"><i></i></span>
                                                                        <p>
                                                                            <span>Domaine</span><?php echo getDomains($customFieldsAmbassador['sec_act']); ?>
                                                                        </p>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <?php if ((!empty($customFieldsAmbassador['amb_facebook']) && $customFieldsAmbassador['amb_facebook'] != " ")
                                                            || (!empty($customFieldsAmbassador['amb_twitter']) && $customFieldsAmbassador['amb_twitter'] != " ")
                                                            || (!empty($customFieldsAmbassador['mail_amb']) && $customFieldsAmbassador['mail_amb'] != " ")
                                                            || (!empty($customFieldsAmbassador['amb_instagram']) && $customFieldsAmbassador['amb_instagram'] != " ")) {
                                                            ?>
                                                            <div class="ambassador__actions">
                                                                <h2 class="title-h2">Retrouvez-le sur les réseaux
                                                                    sociaux</h2>

                                                                <ul class="ambassador__socials social">
                                                                    <?php if (!empty($customFieldsAmbassador['amb_facebook'])) { ?>
                                                                        <li class="ambassador__social social__item"><i
                                                                                    class="social__item-icon fab fa-facebook-f"></i><a
                                                                                    href="<?php echo $customFieldsAmbassador['amb_facebook']; ?>"><?php echo $customFieldsAmbassador['amb_facebook']; ?></a>
                                                                        </li>
                                                                    <?php }
                                                                    if (!empty($customFieldsAmbassador['amb_twitter'])) {
                                                                        ?>
                                                                        <li class="ambassador__social social__item"><i
                                                                                    class="social__item-icon fab fa-twitter"></i><a
                                                                                    href="<?php echo $customFieldsAmbassador['amb_twitter']; ?>"><?php echo $customFieldsAmbassador['amb_twitter']; ?></a>
                                                                        </li>
                                                                    <?php }
                                                                    if (!empty($customFieldsAmbassador['amb_instagram'])) {
                                                                        ?>
                                                                        <li class="ambassador__social social__item"><i
                                                                                    class="social__item-icon fab fa-instagram"></i>
                                                                            <a href="<?php echo $customFieldsAmbassador['amb_instagram']; ?>"><?php echo $customFieldsAmbassador['amb_instagram']; ?></a>
                                                                        </li>
                                                                    <?php }
                                                                    if (!empty($customFieldsAmbassador['mail_amb'])) {
                                                                        ?>
                                                                        <li class="ambassador__social social__item"><i
                                                                                    class="social__item-icon far fa-envelope"></i>
                                                                            <a href="mailto:<?php echo $customFieldsAmbassador['mail_amb']; ?>"><?php echo $customFieldsAmbassador['mail_amb']; ?></a>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php
                                                if (!empty($customFieldsAmbassador['mon_implication'])) {
                                                    ?>
                                                    <div class="ambassador__specialty ambassador__specialty--implication">
                                                        <i class="ambassador__specialty-icon"></i>
                                                        <p>
                                                            <span>Mon implication</span><?php echo $customFieldsAmbassador['mon_implication']; ?>
                                                        </p>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        wp_reset_postdata();
                                        ?>
                                    </div>
                                    <?php
                                }
                                $args = array(
                                    'post_type' => 'tribe_events',
                                    'post_status' => array('publish'),
                                    'posts_per_page' => -1,
                                    'order' => 'DESC',
                                    'orderby' => 'date',
                                    's' => $search,
                                );

                                $eventsQry = new WP_Query($args);

                                if ($eventsQry->have_posts()) {
                                    $eventsCount = $eventsQry->found_posts;
                                    ?>

                                    <div class="searh-block">
                                        <h2 class="title-h2 main-h2">Agenda
                                            (<span><?php echo $eventsCount; ?></span> <?php echo 'résultat' . (($eventsCount > 1) ? 's' : ''); ?>)</h2>
                                        <div class="agenda">
                                            <div class="agenda__lign agenda__lign--label">
                                                <div class="label">Nom</div>
                                                <div class="label">Ville</div>
                                                <div class="label">Date</div>
                                                <div class="label">Domaine</div>
                                            </div>
                                            <?php
                                            while ($eventsQry->have_posts()) {
                                                $eventsQry->the_post();

                                                global $post;
                                                $eventID = $post->ID;
                                                $eventTitle = get_the_title($eventID);
                                                $startDate = get_field('start_date', $eventID);
                                                $startDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $startDate);
                                                $startDate = $startDateTime->format('d/m/Y');
                                                $eventTerm = get_the_terms($eventID, 'tribe_events_cat')[0]->name;
                                                $eventCity = get_field('city_event', $eventID);

                                                ?>
                                                <div class="agenda__lign">
                                                    <div><?php echo $eventTitle; ?></div>
                                                    <div><?php echo $eventCity; ?></div>
                                                    <div><?php echo $startDate; ?></div>
                                                    <div><?php echo $eventTerm; ?></div>
                                                </div>
                                                <?php
                                            }

                                            wp_reset_postdata();
                                            ?>
                                        </div>
                                    </div>
                                    <?php
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
