<?php
get_template_part('partials/general/block', 'head');

get_template_part('partials/general/block', 'top-nav');

$ambassadorID = get_the_ID();
$ambassadorThumbUrl = get_the_post_thumbnail_url($ambassadorID, 'thumb_single_page_article');
$ambassadorTitle = get_the_title();
$customFieldsAmbassador = get_fields();
?>

    <main id="main" role="main" class="page-ambassador" tabindex="-1">

        <div class="container">
            <div class="row container__cols">
                <div class="col-md-8">
                    <div class="row">


                        <div class="col-md-12">
                            <div class="section-block">
                                <div class="visual-heading borders">
                                    <div class="block-img">
                                        <?php if ($ambassadorThumbUrl != false) { ?>
                                            <img class="visual-heading__img" src="<?php echo $ambassadorThumbUrl; ?>"/>
                                        <?php } ?>
                                    </div>
                                </div>

                                <h1 class="title-h1"><?php echo $ambassadorTitle; ?></h1>
                                <?php if (!empty($customFieldsAmbassador['chapeau_amb'])) { ?>
                                    <p class="intro"><?php echo $customFieldsAmbassador['chapeau_amb']; ?></p>
                                <?php } ?>
                                <div class="content-txt">
                                    <?php
                                    if (have_posts()):
                                        while (have_posts()):
                                            the_post();
                                            the_content();
                                        endwhile;
                                    endif;
                                    ?>
                                </div>
                                <?php

                                if ((!empty($customFieldsAmbassador['amb_facebook']) && $customFieldsAmbassador['amb_facebook'] != " ")
                                    || (!empty($customFieldsAmbassador['amb_twitter']) && $customFieldsAmbassador['amb_twitter'] != " ")
                                    || (!empty($customFieldsAmbassador['mail_amb']) && $customFieldsAmbassador['mail_amb'] != " ")
                                    || (!empty($customFieldsAmbassador['amb_instagram']) && $customFieldsAmbassador['amb_instagram'] != " ")) {
                                    ?>
                                    <div class="centered">
                                        <div class="ambassador__actions">
                                            <h2 class="title-h2">
                                                <?php echo 'Retrouvez-' . (($customFieldsAmbassador['genre'] === 'monsieur') ? 'le' : 'la'); ?>
                                                sur les réseaux sociaux
                                            </h2>

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
                                                                class="social__item-icon fab fa-instagram"></i> <a
                                                                href="<?php echo $customFieldsAmbassador['amb_instagram']; ?>"><?php echo $customFieldsAmbassador['amb_instagram']; ?></a>
                                                    </li>
                                                <?php }
                                                if (!empty($customFieldsAmbassador['mail_amb'])) {
                                                    ?>
                                                    <li class="ambassador__social social__item"><i
                                                                class="social__item-icon far fa-envelope"></i> <a
                                                                href="mailto:<?php echo $customFieldsAmbassador['mail_amb']; ?>"><?php echo $customFieldsAmbassador['mail_amb']; ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php }
                                $args = array(
                                    'post_type' => 'tribe_events',
                                    'post_status' => array('publish'),
                                    'posts_per_page' => -1,
                                    'order' => 'DESC',
                                    'orderby' => 'date',
                                    'meta_query' => array(
                                        array(
                                            'key' => 'ambassador_event',
                                            'value' => '"' . $ambassadorID . '"',
                                            'compare' => 'LIKE'
                                        )
                                    )
                                );
                                $eventsQry = new WP_Query($args);

                                if ($eventsQry->have_posts()) {
                                    ?>
                                    <h2 class="title-h2 events-title">Découvrez les évènements de cet ambassadeur</h2>
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

                                            $eventID = $post->ID;
                                            $startDate = get_field('start_date');
                                            $startDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $startDate);
                                            $startDate = $startDateTime->format('d/m/Y');
                                            $eventTerms = get_the_terms($eventID, 'tribe_events_cat');
                                            $eventTerm = '';
                                            if(!empty($eventTerms)){
                                                $eventTerm = $eventTerms[0]->name;
                                            }
                                            ?>
                                            <div class="agenda__lign">
                                                <div><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></div>
                                                <div><?php echo get_field('city_event'); ?></div>
                                                <div><?php echo $startDate; ?></div>
                                                <div><?php echo $eventTerm; ?></div>
                                            </div>
                                            <?php
                                        }

                                        wp_reset_postdata();
                                        ?>
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
