<?php
get_template_part( 'partials/general/block', 'head' );
get_template_part( 'partials/general/block', 'top-nav' );

$eventID = get_the_ID();
$eventThumbUrl = get_the_post_thumbnail_url( $eventID,'thumb_single_page_article' );
$eventTerms = get_the_terms( $eventID, 'category' );
$eventDate = get_the_date('d F Y');
$eventTitle = get_the_title();
$eventCustomFields = get_fields();

?>

<main id="main" role="main" class="page-single-event" tabindex="-1">

    <div class="container">
        <div class="row container__cols">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-block">
                            <div class="visual-heading borders">
                                <div class="block-img">
                                    <img class="visual-heading__img" src="<?php echo $eventThumbUrl; ?>" />
                                </div>
                            </div>

                            <h1 class="title-h1"><?php echo $eventTitle; ?></h1>

                            <div class="event-infos">
                                <div class="main-infos">
                                    <p class="intro"><?php echo $eventCustomFields['chapeau']; ?></p>
                                    <?php
                                    if( !empty($eventCustomFields['start_date']) || !empty($eventCustomFields['end_date']) || !empty($eventCustomFields['place_event']) || !empty($timeText) ){
                                        ?>
                                        <ul class="main-infos__list">
                                            <?php
                                            if( !empty($eventCustomFields['start_date']) && !empty($eventCustomFields['end_date']) ){

                                                $startDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $eventCustomFields['start_date']);
                                                $startDate = dateTimeInFr( $startDateTime->format('d F Y') );
                                                $startDay = $startDateTime->format('d');
                                                $startMonthYear = dateTimeInFr($startDateTime->format('F Y'));
                                                $startTime = $startDateTime->format('H\hi');

                                                $endDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $eventCustomFields['end_date']);
                                                $endDate = dateTimeInFr( $endDateTime->format('d F Y') );
                                                $endDay = $endDateTime->format('d');
                                                $endMonthYear = dateTimeInFr($endDateTime->format('F Y'));
                                                $endTime = $endDateTime->format('H\hi');

                                                if( $startDate === $endDate ){
                                                    $dateText = 'Le ' . $startDate;
                                                }else{
                                                    if($startMonthYear === $endMonthYear){
                                                        $dateText = 'Du ' . $startDay . ' au ' . $endDay . ' ' . $endMonthYear;
                                                    }else{
                                                        $dateText = 'Du ' . $startDate . ' au ' . $endDate;
                                                    }

                                                }

                                                $timeText = 'De ' . $startTime . ' à ' . $endTime;

                                                echo ' <li class="main-infos__logistic"><i class="main-infos__icon far fa-calendar-alt"></i>' . $dateText . '</li>';
                                            }

                                            if( !empty($eventCustomFields['place_event']) ){
                                                echo '<li class="main-infos__logistic"><i class="main-infos__icon fas fa-map-marker-alt"></i>' . $eventCustomFields['place_event'] . '</li>';
                                            }

                                            if( !empty($timeText)){
                                                echo '<li class="main-infos__logistic"><i class="main-infos__icon far fa-clock"></i>' . $timeText . '</li>';
                                            }
                                            ?>
                                        </ul>
                                        <?php
                                    }?>
                                </div>

                                <div class="event-localisation">
                                    <?php
                                    if( $eventCustomFields['gps_event']['latitude'] == 0 && $eventCustomFields['gps_event']['longitude'] == 0){
                                        $dataMap = '48.9137455,2.484572899999989';
                                    }else{
                                        $dataMap = $eventCustomFields['gps_event']['latitude'] . ',' . $eventCustomFields['gps_event']['longitude'];
                                    }

                                    ?>
                                    <div class="event-localisation__map" data-map-latlng="<?php echo $dataMap;  ?>"></div>
                                    <a href="" class="link">Voir le plan</a>
                                </div>
                            </div>

                            <div class="content-txt">
                                <?php echo $eventCustomFields['zone_texte']; ?>
                            </div>

                            <?php

                            if( $eventCustomFields['type_de_black_box'] == true ){
                                set_query_var( 'box-fields', $eventCustomFields );
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
