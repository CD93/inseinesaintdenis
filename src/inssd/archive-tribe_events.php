<?php
get_template_part( 'partials/general/block', 'head' );
get_template_part( 'partials/general/block', 'top-nav' );

$pageEventsChapeau = get_field('params_archive_events_chapeau','option');

?>


<main id="main" role="main" class="page-events" tabindex="-1">

    <div class="container">
        <div class="row container__cols">
            <div class="col-md-8">
                <div class="row">

                    <div class="col-md-12">
                        <div class="clearfix">
                            <h1 class="title-h1">Évènements In Seine-Saint-Denis</h1>

                            <p class="intro"><?php echo $pageEventsChapeau; ?></p>
                            <?php
                            $thematiqueEventsArray = getEventsForMap();
                            ?>
                            <form class="events__infos__viewer__form">
                                <select class="events__infos__select">
                                    <option>Choisir une thématique</option>
                                    <?php
                                    foreach($thematiqueEventsArray as $keyID => $thematiqueEvents) {
                                        ?>
                                        <option
                                                val="<?php echo $keyID; ?>"
                                                data-events-count="<?php echo $thematiqueEvents['count'] ?>"
                                            <?php
                                            foreach($thematiqueEvents['events'] as $key => $event){
                                                echo 'data-events-date-' . $key . '="' . $event['start_date'] . '"';
                                                echo 'data-events-latlng-' . $key . '="' . $event['long_lat'] . '"';
                                                echo 'data-events-link-' . $key . '="' . $event['link'] . '"';
                                            }
                                            ?>

                                        ><?php echo $thematiqueEvents['name'] ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="events clearfix">
                        <div class="events__infos">
                            <div class="col-md-6 events__infos__left">
                                <div class="events__infos__viewer">
                                    <div class="events__infos__calendar"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="events__map"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="section-block search">
                            <h2 class="title-h2 search__title">
                                Résultats
                                <div class="spinner">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                            </h2>

                            <form class="ajax-search-event">
                                <div class="form-element search-form">
                                    <input type="text" name="search" class="" id="inputSearch" placeholder="Filter les résultats par mots clé…">

                                    <button class="btn btn--round btn--black" type="submit">Filtrer</button>
                                </div>
                            </form>


                            <div class="agenda__no-result intro">
                                <p class="">Aucun résultat.</p>
                            </div>

                            <div class="agenda">
                                <div class="agenda__lign agenda__lign--label">
                                    <div class="label">Nom</div>
                                    <div class="label">Ville</div>
                                    <div class="label">Date</div>
                                    <div class="label">Domaine</div>
                                </div>

                                <div class="agenda__records">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <?php
                        get_template_part( 'partials/general/block', 'black-box-event' );
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
