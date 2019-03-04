<?php
get_template_part( 'partials/general/block', 'head' );
get_template_part( 'partials/general/block', 'top-nav' );


$pageProjectsTitle = get_field('params_archive_projects_title','option');
$pageProjectsChapeau = get_field('params_archive_projects_chapeau','option');
$pageProjectsContent = get_field('params_archive_projects_text','option');
$pageProjectsList = get_field('params_archive_projects_list','option');

?>

<main id="main" role="main" class="page-news" tabindex="-1">

    <div class="container">
        <div class="row container__cols">
            <div class="col-md-8">
                <div class="row">

                    <div class="col-md-12">
                        <div class="clearfix">
                            <h1 class="title-h1"><?php echo $pageProjectsTitle; ?></h1>

                            <p class="intro"><?php echo $pageProjectsChapeau; ?></p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <?php echo $pageProjectsContent; ?>
                    </div>

                    <div class="col-md-12">
                    <?php
                    $args = array (
                        'post_type' => 'inssd-projet',
                        'post_status' => array('publish'),
                        'posts_per_page' => -1,
                        'order' => 'DESC',
                        'orderby' => 'date',
                        'post_in' => $pageProjectsList,
                    );
                    $projectsQry = new WP_Query( $args );

                    if ( $projectsQry->have_posts() ) {

                        while ( $projectsQry->have_posts() ) {
                            $projectsQry->the_post();

                            $projectID = $post->ID;
                            $projectTitle = get_the_title($projectID);
                            $projectLink = get_the_permalink( $projectID );
                            $projectTerm = get_the_terms( $projectID, 'catprojet' )[0];
                            $projectThumbUrl = get_the_post_thumbnail_url( $projectID,'thumb_archive_page_project' );
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
                                                    <span class="strap__icon <?php echo ($alreadyLiked ? 'strap__icon--actif' : ''); ?>"><i class="far fa-heart"></i></span>
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

                                        <p><?php echo wp_trim_words( $projectCustomFields['chapeau'],25, '...' ); ?></p>

                                        <div class="project__actions">
                                            <ul class="project__socials social">
                                                <li class="project__social social__item"><i class="social__item-icon fab fa-facebook-f"></i><a href="">loremipusm</a></li>
                                                <li class="project__social social__item"><i class="social__item-icon fab fa-twitter"></i><a href="">loremipusm</a></li>
                                                <li class="project__social social__item"><i class="social__item-icon fab fa-linkedin"></i> <a href="">linkedin/loremipusm</a></li>
                                                <li class="project__social social__item"><i class="social__item-icon far fa-envelope"></i> <a href="mailto:">loremipsum@ipsum.com</a></li>
                                            </ul>

                                            <a href="<?php echo $projectLink; ?>" title="SOUTENIR CE PROJET - nouvelle fenêtre" class="btn btn--pink btn--round project__btn">SOUTENIR CE PROJET</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();
                    }
                    ?>
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
