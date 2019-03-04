<?php

function stringLinkToHTML( $string ){
    $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
    $string= preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $string);
    return $string;
}

function getTweets(){

    $paramsFieldsTwitter = get_field('params_twitter', 'option');
    $oauth_access_token = $paramsFieldsTwitter['access_token'];
    $oauth_access_token_secret = $paramsFieldsTwitter['access_token_secret'];
    $consumer_key = $paramsFieldsTwitter['consumer_key'];
    $consumer_secret = $paramsFieldsTwitter['consumer_secret'];
    $screen_name = $paramsFieldsTwitter['account'];
    $return = false;

    if ( $oauth_access_token && $oauth_access_token_secret && $consumer_key && $consumer_secret && $screen_name ) {

        $settings = array(
            'oauth_access_token' => $oauth_access_token,
            'oauth_access_token_secret' => $oauth_access_token_secret,
            'consumer_key' => $consumer_key,
            'consumer_secret' => $consumer_secret,
        );

        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

        $base_tweet_url = 'https://twitter.com/' . $screen_name . '/status/';

        $getfield = '?screen_name=' . $screen_name . '&exclude_replies=true&tweet_mode=extended&count=2';
        $requestMethod = 'GET';

        $twitter = new TwitterAPIExchange($settings);

        $response = $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();

        $tweets = json_decode($response, true);

        if( !isset($tweets['errors'][0]['message']) ){
            $return = array();

            foreach($tweets as $key => $tweet){
                $tweet_url = $base_tweet_url . $tweet['id_str'];

                $return[$key]['text'] = wp_trim_words(stringLinkToHTML( $tweet['full_text'] ), 15, '...');
                $return[$key]['url'] = $tweet_url;
            }
        }

    }

    return $return;
}

function getFbPosts(){
    $paramsFieldsFacebook = get_field('params_facebook', 'option');

    $client_id = $paramsFieldsFacebook['app_id'];
    $client_secret = $paramsFieldsFacebook['app_client'];
    $pageName = $paramsFieldsFacebook['account'];
    $return = false;

    if ( $client_id && $client_secret ) {

        $access_str = wp_remote_get('https://graph.facebook.com/oauth/access_token?client_id=' . $client_id . '&client_secret=' . $client_secret . '&grant_type=client_credentials');

        if( !empty($access_str)){
            $body = wp_remote_retrieve_body( $access_str );

            $tokenarr = str_replace('"','', $body);
            $tokenarray = explode(":",str_replace(',',':', $tokenarr));

            if( !empty($tokenarray[1])){
                $response = wp_remote_get( 'https://graph.facebook.com/' . $pageName . '/posts?fields=attachments,message&limit=3&access_token=' . $tokenarray[1]);

                if( ! empty( $response ) ){
                    $body = wp_remote_retrieve_body( $response );
                    $body = json_decode( $body, true );

                    if( !isset($body['error'])){
                        $count = 0;
                        $fbPosts = array();

                        foreach ($body['data'] as $posts) {

                            if( isset($posts['attachments']['data'][0]['media']['image']['src']) ){
                                $fbPosts[$count]['image_url'] = $posts['attachments']['data'][0]['media']['image']['src'];
                            }
                            if( isset($posts['message']) ){
                                $fbPosts[$count]['text'] = wp_trim_words($posts['message'], 15, '...');
                            }
                            if( isset($posts['url']) ){
                                $fbPosts[$count]['url'] = $posts['url'];
                            }
                            $count++;
                        }

                        $return = $fbPosts;
                        /*$randomKeys = array_rand( $fbPosts, 3 );
                        $return[0] = $fbPosts[$randomKeys[0]];
                        $return[1] = $fbPosts[$randomKeys[1]];*/
                    }
                }
            }
        }

    }

    return $return;
}

function dateTimeInFr( $date ) {
    $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $french_days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $french_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
    return str_replace($english_months, $french_months, str_replace($english_days, $french_days, $date) );
}

function getDomains($key){

    switch ($key) {
        case 'sec_2':
            $secteur = '&Eacute;ducation';
            break;
        case 'sec_5':
            $secteur = 'Sport';
            break;
        case 'sec_6':
            $secteur = 'Autre';
            break;
        case 'nsec_0':
            $secteur = 'Métiers de bouche, agro-alimentaire';
            break;
        case 'nsec_1':
            $secteur = 'Artisanat d\'art';
            break;
        case 'nsec_3':
            $secteur = 'Tourisme, loisirs';
            break;
        case 'nsec_4':
            $secteur = 'BTP, construction, logement et ville durable';
            break;
        case 'nsec_5':
            $secteur = 'Numérique / digital, média, communication';
            break;
        case 'nsec_7':
            $secteur = 'Aéronautique, aérien et aéroportuaire (AAA), Mécanique, électronique, secteur industriel';
            break;
        case 'nsec_9':
            $secteur = 'Culture, création artistique';
            break;
        case 'nsec_10':
            $secteur = 'Agriculture / écologie urbaine';
            break;
        case 'nsec_11':
            $secteur = 'Solidarité, secteur social, santé';
            break;
        default:
            $secteur = '';
            break;

    }
    return $secteur;
}

function getEventsForMap(){

    $thematiqueEventsArray = array();

    $args = array (
        'post_type' => 'tribe_events',
        'post_status' => array('publish'),
        'posts_per_page' => -1,
        'order' => 'DESC',
        'orderby' => 'date',
    );
    $eventsQry = new WP_Query( $args );

    if ( $eventsQry->have_posts() ) {

        while ( $eventsQry->have_posts() ) {
            $eventsQry->the_post();

            global $post;
            $eventID = $post->ID;

            $eventTerm = get_the_terms( $eventID, 'tribe_events_cat' )[0];
            if( !empty($eventTerm)){
                $eventTermID = $eventTerm->term_id;
                $eventTermName = $eventTerm->name;
            }else{
                $eventTermID = 0;
                $eventTermName = 'Non classé';
            }

            $eventLongLat = get_field('gps_event');

            $eventStartDate = get_field('start_date');
            if( !empty($eventStartDate) ){
                $eventStartDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $eventStartDate);
                $eventStartDate = $eventStartDateTime->format('Y-m-d');
            }else{
                $eventStartDate = '1988-01-09';
            }

            $eventEndDate = get_field('end_date');
            if( !empty($eventEndDate) ){
                $eventEndDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $eventEndDate);
                $eventEndDate = $eventEndDateTime->format('Y-m-d');
            }else{
                $eventEndDate = '1992-09-07';
            }

            $eventLink = get_the_permalink();

            if( $eventLongLat['latitude'] === '0' && $eventLongLat['longitude'] === '0'){
                $dataMap = '48.9137455,2.484572899999989';
            }else{
                $dataMap = $eventLongLat['latitude'] . ',' . $eventLongLat['longitude'];
            }

            if( isset($thematiqueEventsArray[$eventTermID]['count'])){
                $thematiqueEventsArray[$eventTermID]['count']++;
            }else{
                $thematiqueEventsArray[$eventTermID]['name'] = $eventTermName;
                $thematiqueEventsArray[$eventTermID]['count'] = 1;
            }

            $thematiqueEventsArray[$eventTermID]['events'][] = array(
                'long_lat' => $dataMap,
                'start_date' => $eventStartDate,
                'end_date' => $eventEndDate,
                'link' => $eventLink,
            );

        }

        wp_reset_postdata();
    }

    return $thematiqueEventsArray;
}

function wp_pagination( $query = null, $paged = 1, $ajax = false ) {
    if (!$query)
        return;

    if( !$ajax ){
        $base = str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) );
        $format = 'page/%#%';
    }else{
        $base = '%_%';
        $format = '#page=%#%';
    }

    $paginate = paginate_links([
        'base' => $base,
        'type'      => 'array',
        'total'     => $query->max_num_pages,
        'format'    => $format,
        'current'   => max( 1, $paged ),
        'prev_text' => '',
        'next_text' => '',
        'end_size' => 2,
        'mid_size' => 2,
    ]);

    if ($query->max_num_pages > 1) : ?>
        <ul class="pagination">
            <?php

            foreach ( $paginate as $page ) {

                if (strpos($page, 'page-numbers current') !== false) {
                    $pageRp = str_replace('page-numbers current', 'pagination__link pagination__link--number pagination__link--current', $page);
                    echo '<li class="pagination__item">' . $pageRp . '</li>';
                } else if (strpos($page, 'prev page-numbers') !== false) {
                    $pageRp = str_replace('prev page-numbers', 'pagination__link pagination__link--reverse pagination__link--start', $page);
                    echo '<li class="pagination__item">' . $pageRp . '</li>';

                } else if (strpos($page, 'next page-numbers') !== false) {
                    $pageRp = str_replace('next', 'pagination__link pagination__link--end', $page);
                    echo '<li class="pagination__item">' . $pageRp . '</li>';
                }
                else if (strpos($page, 'page-numbers dots') !== false) {
                    echo '<li class="pagination__item">&hellip;</li>';
                } else if (strpos($page, 'page-numbers') !== false) {
                    $pageRp = str_replace('page-numbers', 'pagination__link pagination__link--number', $page);
                    echo '<li class="pagination__item">' . $pageRp . '</li>';
                }
            } ?>
        </ul>
    <?php endif;
}