
        <footer>
            <div class="footer__logo">
                <a href="" class="footer_logo--link"></a>
            </div>

            <div class="footer__actions">
                <div class="footer__list">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'footer-menu-bottom-col-1',
                            'container' => false,
                            'menu_id'         => 'menu-col1',
                            'menu_class'      => 'menu-col1',
                        )
                    );
                    ?>
                </div>

                <div class="footer__list">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'footer-menu-bottom-col-2',
                            'container' => false,
                            'menu_id'         => 'menu-col2',
                            'menu_class'      => 'menu-col2',
                        )
                    );
                    ?>
                </div>

                <div class="footer__list">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'footer-menu-bottom-col-3',
                            'container' => false,
                            'menu_id'         => 'menu-col3',
                            'menu_class'      => 'menu-col3',
                        )
                    );
                    ?>
                    <p class="copyright">© <?php echo date('Y'); ?> - In Seine-Saint-Denis</p>
                </div>
            </div>
            <div class="footer__text">
                <p><?php echo get_field('params_footer_text', 'option'); ?></p>
            </div>
        </footer>



        <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo get_field('params_gmap_api_key', 'option'); ?>&callback=initMap" type="text/javascript"></script>

        <?php
        wp_footer();

        $googleAnalyticsKey = get_field( 'params_ga' , 'option');
        if( !empty($googleAnalyticsKey) && ENV_PROD ): ?>
            <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', '<?php echo $googleAnalyticsKey; ?>', 'auto');
            ga('send', 'pageview');
            </script>
        <?php endif; ?>
    </body>
</html>
