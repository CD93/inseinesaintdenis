<header role="banner" id="header-nav">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="top-bar">

                    <div class="header-social">
                        <?php
                        $twitterData = get_field('params_twitter','option');
                        $facebookData = get_field('params_facebook','option');
                        $instagramData = get_field('params_instagram','option');
                        ?>
                        <a class="social-head" target="_blank" href="https://twitter.com/<?php echo $twitterData['account']; ?>">
                            <i class="fab fa-twitter"><span class="sr-only">Twitter Inseinesaintdenis</span></i>
                        </a>

                        <a class="social-head" target="_blank" href="https://www.facebook.com/<?php echo $facebookData['account']; ?>">
                            <i class="fab fa-facebook-f"><span class="sr-only">Facebook Inseinesaintdenis</span></i>
                        </a>

                        <a class="social-head" target="_blank" href="https://www.instagram.com/<?php echo $instagramData; ?>">
                            <i class="fab fa-instagram"><span class="sr-only">Instagram Inseinesaintdenis</span></i>
                        </a>
                    </div>

                    <div class="open-menu-search header-search">
                        <div class="hidden-xs hidden-sm">
                            <?php echo get_search_form(); ?>
                        </div>

                        <div class="visible-xs visible-sm mobile-search">

                        </div>
                    </div>
                </div>

                <button type="button" class="nav-toggle"><span class="nav-toggle--icon-wrapper"><span class="sr-only">Menu principal</span><span class="nav-toggle--icon"></span></span></button>

                <div class="nav-wrapper">
                    <div class="header__logo">
                        <a href="<?php echo get_home_url(); ?>" class="header_logo--link"></a>
                    </div>

                    <div class="nav">
                        <div class="header-search visible-xs visible-sm">
                            <?php echo get_search_form(); ?>
                        </div>

                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location'  => 'header-top-menu',
                                'container' => false,
                                'menu_id'         => 'menu_id',
                                'menu_class'      => 'menu clearfix',
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

