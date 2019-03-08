<?php
/*
Template Name: Actualités
*/

get_template_part( 'partials/general/block', 'head' );
get_template_part( 'partials/general/block', 'top-nav' );
$catId = get_query_var('cat');
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

if( empty($catId)){
    $pageNewsTitle = get_field('params_archive_post_title','option');
}else{
    $currentTerm = get_term_by('id', $catId,'category');
    $pageNewsTitle = $currentTerm->name;
}

$pageNewsChapeau = get_field('params_archive_post_chapeau','option');

?>

<main id="main" role="main" class="page-news" tabindex="-1">

    <div class="container">
        <div class="row container__cols">
            <div class="col-md-8">
                <div class="row">

                    <div class="col-md-12">
                        <div class="clearfix">
                            <h1 class="title-h1"><?php echo $pageNewsTitle; ?></h1>

                            <p class="intro"><?php echo $pageNewsChapeau; ?></p>
                        </div>
                    </div>
                    <?php
                    $args = array (
                        'post_type' => 'post',
                        'post_status' => array('publish'),
                        'posts_per_page' => 5,
                        'order' => 'DESC',
                        'orderby' => 'date',
                        'paged' => $paged,
                        'cat' => $catId,
                    );
                    $newsQry = new WP_Query( $args );

                    if ( $newsQry->have_posts() ) {

                        $isFirstPost = true;
                        ?>
                        <div class="section-block clearfix">

                            <?php
                            while ( $newsQry->have_posts() ) {
                                $newsQry->the_post();

                                $newsID = $post->ID;
                                $newsTitle = get_the_title($newsID);
                                $newsChapeau = get_field('chapeau', $newsID);
                                $newsLink = get_the_permalink( $newsID );
                                $newsTerm = get_the_terms( $newsID, 'category' )[0];

                                if($isFirstPost){
                                    $newsThumbUrl = get_the_post_thumbnail_url( $newsID,'thumb_single_page_article' );
                                    $isFirstPost = false;
                                    ?>
                                    <div class="col-md-12">
                                        <div class="block-news block-news--large">

                                                <div class="block-news__link__img">
                                                    <div class="block-img">
                                                        <img src="<?php echo $newsThumbUrl; ?>" class="" alt="">
                                                    </div>
                                                    <div class="category-element category--pink block-news__link__img__category"><a href="<?php echo get_category_link($newsTerm->term_id); ?>"><?php echo $newsTerm->name; ?></a></div>
                                                </div>
                                            <a href="<?php echo $newsLink; ?>" class="block-news__link">
                                                <div class="block-news__link__text">
                                                    <h2 class="title-h2 block-news__link__text__title">
                                                        <?php echo $newsTitle; ?>
                                                    </h2>

                                                    <p class="block-news__link__text__description"><?php echo wp_trim_words($newsChapeau, 45, '...'); ?> <span class="link block-news__link__link">lire la suite</span></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }else {
                                    $newsThumbUrl = get_the_post_thumbnail_url( $newsID,'thumb_small_single_page_article' );
                                    ?>
                                    <div class="col-md-6">
                                        <div class="block-news borders">

                                                <div class="block-news__link__img">
                                                    <div class="block-img">
                                                        <img src="<?php echo $newsThumbUrl; ?>" class="" alt="">
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
                            }

                            ?>
                            <div class="col-md-12">
                                <?php
                                wp_pagination( $newsQry, $paged, false);
                                ?>
                            </div>

                        </div>

                        <?php

                        wp_reset_postdata();
                    }
                    ?>

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
