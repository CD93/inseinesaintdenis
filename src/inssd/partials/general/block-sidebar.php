<?php $sidebarFields = get_fields('option'); ?>
<div class="sidebar">
    <div class="sidebar-block sidebar-block--demarche">
        <div class="heading">
            <img class="heading__picto" src="<?php echo get_template_directory_uri(); ?>/img/common/picto-demarche.svg" />
            <div class="heading__title"><?php echo $sidebarFields['params_sidebar_title1']; ?></div>
        </div>
        <p class="sidebar__text"><?php echo $sidebarFields['params_sidebar_text1_a']; ?></p>
        <div class="sidebar__subtitle"><?php echo $sidebarFields['params_sidebar_subtitle1']; ?></div>
        <p class="sidebar__text"><?php echo $sidebarFields['params_sidebar_text1_b']; ?></p>
    </div>
    <div class="sidebar-block sidebar-block--ambassador">
        <div class="heading">
            <img class="heading__picto" src="<?php echo get_template_directory_uri(); ?>/img/common/picto-ambassador.svg" />
            <div class="heading__title"><?php echo $sidebarFields['params_sidebar_title2']; ?></div>
        </div>
        <p class="sidebar__text"><?php echo $sidebarFields['params_sidebar_text2']; ?></p>
        <a class="btn btn--black btn--round sidebar__link" href="<?php echo $sidebarFields['params_sidebar_button_link']; ?>"><?php echo $sidebarFields['params_sidebar_button_text']; ?></a>
    </div>
    <div class="sidebar-block sidebar-block--network">
        <div class="heading">
            <img class="heading__picto" src="<?php echo get_template_directory_uri(); ?>/img/common/picto-network.svg" />
            <div class="heading__title">#InSeineSaintDenis</div>
        </div>

        <?php
        if( !ENV_DEV ){
            $tweetsAPI = getTweets();
        }

        if( !empty($tweetsAPI) && is_array($tweetsAPI) ){

            $paramsFieldsTwitter = get_field('params_twitter', 'option');
            $screenNameTwitter = $paramsFieldsTwitter['account'];

            foreach( $tweetsAPI as $tweet){
                ?>
                <div class="sidebar__social borders social-item social-item--twitter">
                    <div style="" class="social-item__visuel"></div>

                    <div class="social-item__icon-network"></div>

                    <p class="social-item__post"><?php echo $tweet['text']; ?></p>

                    <div class="social-item__author author">
                        <div class="author__avatar"><img src="<?php echo get_template_directory_uri(); ?>/img/common/logo-header-inssd.svg" alt="" title=""></div>

                        <div class="author__infos">
                            <span class="author__name">In Seine-Saint-Denis</span>
                            <span class="author__account">@<?php echo $screenNameTwitter; ?></span>
                        </div>
                    </div>
                </div>
                <?php
            }
        }

        if( !ENV_DEV ){
            $facebookAPI = getFbPosts();
        }

        if( !empty($facebookAPI) && is_array($facebookAPI) ){

            $paramsFieldsFacebook = get_field('params_facebook', 'option');
            $screenNameFacebook = $paramsFieldsFacebook['account'];

            foreach($facebookAPI as $post){

                $classVisualPost = ( !empty($post['image_url']) ) ? 'social-item--visuel' : '';
                ?>
                <div class="sidebar__social borders social-item <?php echo $classVisualPost; ?> social-item--facebook">
                    <?php
                    if( !empty($post['image_url']) ) {
                        ?>
                        <div style="background-image: url(<?php echo $post['image_url']; ?>)" class="social-item__visuel"></div>
                        <?php
                    }
                    ?>
                    <div class="social-item__icon-network"></div>

                    <p class="social-item__post"><?php echo $post['text']; ?></p>

                    <div class="social-item__author author">
                        <div class="author__avatar"><img src="<?php echo get_template_directory_uri(); ?>/img/common/logo-header-inssd.svg" alt="" title=""></div>

                        <div class="author__infos">
                            <span class="author__name">In Seine-Saint-Denis</span>
                            <span class="author__account"><?php echo $screenNameFacebook; ?></span>
                        </div>
                    </div>
                </div>
                <?php
            }
        }

        ?>
    </div>
</div>
