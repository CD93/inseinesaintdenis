<?php
get_template_part( 'partials/general/block', 'head' );

get_template_part( 'partials/general/block', 'top-nav' );

$newsID = get_the_ID();
$newsThumbUrl = get_the_post_thumbnail_url( $newsID,'thumb_single_page_article' );
$newsTerms = get_the_terms( $newsID, 'category' );
$newsDate = get_the_date('d F Y');
$newsTitle = get_the_title();
$customFields = get_fields();
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
                                    <img class="visual-heading__img" src="<?php echo $newsThumbUrl; ?>" />
                                </div>
                            </div>

                            <div class="article-infos">
                                <?php
                                foreach( $newsTerms as $newsTerm ){
                                    echo '<a href="' . get_category_link($newsTerm->term_id) . '"><p class="article-infos__category">'. $newsTerm->name . '</p></a>';
                                }
                                ?>
                                <p class="article-infos__date"><?php echo $newsDate; ?></p>
                            </div>


                            <h1 class="title-h1"><?php echo $newsTitle; ?></h1>

                            <p class="intro"><?php echo $customFields['chapeau']; ?></p>

                            <div class="content-txt">
                                <?php echo $customFields['zone_texte']; ?>
                            </div>
                            <?php
                            if( $customFields['type_de_black_box'] == true ){
                                set_query_var( 'box-fields', $customFields );
                                get_template_part( 'partials/general/block', 'black-box' );
                            }

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
