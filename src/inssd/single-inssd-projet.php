<?php
get_template_part( 'partials/general/block', 'head' );
get_template_part( 'partials/general/block', 'top-nav' );

$projectID = get_the_ID();
$projectThumbUrl = get_the_post_thumbnail_url( $projectID,'thumb_single_page_article' );
$projectTerm = get_the_terms( $projectID, 'catprojet' )[0];
$projectDate = get_the_date('d F Y');
$projectTitle = get_the_title();
$projectCustomFields = get_fields();

?>

<main id="main" role="main" class="page-single-news" tabindex="-1">

    <div class="container">
        <div class="row container__cols">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-block">
                            <div class="visual-heading borders">
                                <div class="block-img">
                                    <img class="visual-heading__img" src="<?php echo $projectThumbUrl; ?>" />
                                </div>
                            </div>

                            <div class="project-infos">
                                <p class="project-infos__item"><?php echo $projectDate; ?></p>
                                <p class="project-infos__item"><?php echo $projectTerm->name; ?></p>
                            </div>

                            <h1 class="title-h1"><?php echo $projectTitle; ?></h1>

                            <p class="intro"><?php echo $projectCustomFields['chapeau']; ?></p>

                            <div class="content-txt section-block">
                                <?php echo $projectCustomFields['zone_texte']; ?>
                            </div>
                            <?php

                            if( $projectCustomFields['type_de_black_box'] == true ){
                                set_query_var( 'box-fields', $projectCustomFields );
                                get_template_part( 'partials/general/block', 'black-box' );
                            }

                            ?>

                            <?php
                            get_template_part( 'partials/general/block', 'social-share' );
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
