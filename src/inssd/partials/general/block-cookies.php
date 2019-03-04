<div id="cookies-eu-banner" style="display: none;">
    <div class="cookies-eu-banner-container">
        <?php
        $text = 'Nous utilisons des cookies pour améliorer votre expérience sur notre site. Vous pouvez mettre à jour vos paramètres.';

        if( 'en' == ICL_LANGUAGE_CODE ){
            $text = 'We use cookies to improve your experience on our website. You can update your settings.';
        }
        ?>
        <p><?php echo $text; ?></p>

        <div class="buttons-container">
            <button id="cookies-eu-reject" class="btn primary">Annuler</button>
            <button id="cookies-eu-accept" class="btn secondary">Accepter</button>
        </div>
    </div>
</div>

<script type="text/javascript">

    new CookiesEuBanner(function() {

        //put some trackers

    }, true);

</script>
