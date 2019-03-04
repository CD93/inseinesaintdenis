<?php

function upload_file( $file = array(), $title = false ) {

    require_once ABSPATH . 'wp-admin/includes/admin.php';

    $file_return = wp_handle_upload($file, array('test_form' => false));

    if(isset($file_return['error']) || isset($file_return['upload_error_handler'])){
        return false;
    }else{

        $filename = $file_return['file'];

        $attachment = array(
            'post_mime_type' => $file_return['type'],
            'post_content' => '',
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'guid' => $file_return['url']
        );

        if($title){
            $attachment['post_title'] = $title;
        }

        $attachment_id = wp_insert_attachment( $attachment, $filename );

        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );

        wp_update_attachment_metadata( $attachment_id, $attachment_data );

        if( 0 < intval( $attachment_id ) ) {
            return $attachment_id;
        }
    }
    return false;
}

add_action( 'wp_ajax_nopriv_process_ambassador_apply', 'process_ambassador_apply_callback' );
add_action( 'wp_ajax_process_ambassador_apply', 'process_ambassador_apply_callback' );
function process_ambassador_apply_callback() {
    // Security
    $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : 0;
    if ( !wp_verify_nonce($nonce, 'applyAmbassadorNonce') ) {
        exit(__('not allowed', 'inssd'));
    }

    $response['message'] = 'error';
    $response['status'] = 201;

    $ambassadorGender = $_POST['ambassadorGender'];
    $ambassadorName = $_POST['ambassadorName'];
    $ambassadorFirstName = $_POST['ambassadorFirstName'];
    $ambassadorStreet = $_POST['ambassadorStreet'];
    $ambassadorCity = $_POST['ambassadorCity'];
    $ambassadorPhone = $_POST['ambassadorPhone'];
    $ambassadorEmail = $_POST['ambassadortEmail'];
    $ambassadorFile = $_FILES['ambassadorFile'];

    $ambassadorAdhesion = $_POST['ambassadorAdhesion'];
    $ambassadorFunction = $_POST['ambassadorFunction'];
    $ambassadorEmployer = $_POST['ambassadorEmployer'];
    $ambassadorDomain = $_POST['ambassadorDomain'];
    $ambassadorFacebook = $_POST['ambassadorFacebook'];
    $ambassadorTwitter = $_POST['ambassadorTwitter'];
    $ambassadorInstagram = $_POST['ambassadorInstagram'];
    $ambassadorComments = $_POST['ambassadorComments'];
    $ambassadorImplication = $_POST['ambassadorImplication'];

    if( !empty($ambassadorName) && !empty($ambassadorFirstName) ){
        $title = 'Candidature de : ' . $ambassadorName . ' ' . $ambassadorFirstName;
    }else{
        $title = 'Nouvelle Candidature';
    }

    $ambassadorArgs = array(
        'post_title'    => $title,
        'post_content' => '',
        'post_status'   => 'pending',
        'post_type' => 'tribe_organizer',
    );

    $ambassadorID = wp_insert_post( $ambassadorArgs );

    if( is_numeric($ambassadorID) ){

        if( !empty($ambassadorGender) ){
            update_field('genre', $ambassadorGender, $ambassadorID);
        }
        if( !empty($ambassadorName) ){
            update_field('nom_amb', $ambassadorName, $ambassadorID);
        }
        if( !empty($ambassadorFirstName) ){
            update_field('prenom_ambassadeur', $ambassadorFirstName, $ambassadorID);
        }
        if( !empty($ambassadorStreet) ){
            update_field('rue_amb', $ambassadorStreet, $ambassadorID);
        }
        if( !empty($ambassadorCity) ){
            update_field('ville_amb', $ambassadorCity, $ambassadorID);
        }
        if( !empty($ambassadorPhone) ){
            update_field('tel_amb', $ambassadorPhone, $ambassadorID);
        }
        if( !empty($ambassadorEmail) ){
            update_field('mail_amb', $ambassadorEmail, $ambassadorID);
        }
        if( !empty($ambassadorAdhesion) ){
            update_field('adhere', $ambassadorAdhesion, $ambassadorID);
        }
        if( !empty($ambassadorFunction) ){
            update_field('fonction', $ambassadorFunction, $ambassadorID);
        }
        if( !empty($ambassadorEmployer) ){
            update_field('soc_org', $ambassadorEmployer, $ambassadorID);
        }
        if( !empty($ambassadorDomain) ){
            update_field('sec_act', $ambassadorDomain, $ambassadorID);
        }
        if( !empty($ambassadorFacebook) ){
            update_field('amb_facebook', $ambassadorFacebook, $ambassadorID);
        }
        if( !empty($ambassadorTwitter) ){
            update_field('amb_twitter', $ambassadorTwitter, $ambassadorID);
        }
        if( !empty($ambassadorInstagram) ){
            update_field('amb_instagram', $ambassadorInstagram, $ambassadorID);
        }
        if( !empty($ambassadorComments) ){
            update_field('mon_implication', $ambassadorComments, $ambassadorID);
        }
        if( !empty($ambassadorImplication) ){
            update_field('type_imp', $ambassadorImplication, $ambassadorID);
        }

        if ( !empty($ambassadorFile) ) {
            if ( $ambassadorFile['size'] > 2097152 ) { // Maximum file size is 2M
                $response['status'] = 201;
                $response['message'] = 'Votre image est trop grande. Elle doit faire moins de 500 Ko!';
                wp_send_json( $response );
                exit();
            } else {
                $filename = sanitize_file_name('photo_' . $ambassadorName );
                $attachment_id = upload_file( $ambassadorFile, $filename);
                if ( is_numeric($attachment_id) ) {
                    set_post_thumbnail( $ambassadorID, $attachment_id );
                }else{
                    $response['message'] = 'fatal error';
                }

            }
        }

        $response['status'] = 200;
        $response['message'] = 'Votre candidature est transmise.';
    }

    wp_send_json( $response );
}

add_action( 'wp_ajax_nopriv_process_send_event', 'process_send_event_callback' );
add_action( 'wp_ajax_process_send_event', 'process_send_event_callback' );
function process_send_event_callback() {
    // Security
    $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : 0;
    if ( !wp_verify_nonce($nonce, 'sendEventNonce') ) {
        exit(__('not allowed', 'inssd'));
    }

    $response['message'] = 'error';
    $response['status'] = 201;
    $eventClaimerName = $_POST['eventClaimerName'];
    $eventClaimerFirstName = $_POST['eventClaimerFirstName'];
    $eventClaimerEmail = $_POST['eventClaimerEmail'];
    $eventClaimerPhone = $_POST['eventClaimerPhone'];
    $eventDatetimeStart = $_POST['eventDatetimeStart'];
    $eventDatetimeEnd = $_POST['eventDatetimeEnd'];
    $eventLocation = $_POST['eventLocation'];
    $eventComments = $_POST['eventComments'];
    $eventFile = $_FILES['eventFile'];

    if( !empty($eventClaimerName) && !empty($eventClaimerFirstName) ){
        $title = 'Nouvelle proposition de : ' . $eventClaimerName . ' ' . $eventClaimerFirstName;
    }else{
        $title = 'Nouveau événement';
    }

    $eventArgs = array(
        'post_title'    => $title,
        'post_content' => '',
        'post_status'   => 'pending',
        'post_type' => 'tribe_events',
    );

    $eventID = wp_insert_post( $eventArgs );

    if( is_numeric($eventID) ){

        if( !empty($eventClaimerName) ){
            update_field('nom_event', $eventClaimerName, $eventID);
        }

        if( !empty($eventClaimerFirstName) ){
            update_field('prenom_event', $eventClaimerFirstName, $eventID);
        }

        if( !empty($eventClaimerPhone) ){
            update_field('tel_event', $eventClaimerPhone, $eventID);
        }

        if( !empty($eventClaimerEmail) ){
            update_field('mail_event', $eventClaimerEmail, $eventID);
        }

        if( !empty($eventDatetimeStart) ){
            $startDateTime = DateTime::createFromFormat("d/m/Y H:i", $eventDatetimeStart);
            $startDate = $startDateTime->format('Y-m-d H:i:s');
            update_field('start_date', $startDate, $eventID);
        }

        if( !empty($eventDatetimeEnd) ){
            $endDateTime = DateTime::createFromFormat("d/m/Y H:i", $eventDatetimeEnd);
            $endDate = $endDateTime->format('Y-m-d H:i:s');
            update_field('end_date', $endDate, $eventID);
        }

        if( !empty($eventLocation) ){
            update_field('place_event', $eventLocation, $eventID);
        }

        if( !empty($eventComments) ){
            update_field('zone_texte', $eventComments, $eventID);
        }

        if ( !empty($eventFile) ) {
            if ( $eventFile['size'] > 2097152 ) { // Maximum file size is 2M
                $response['status'] = 201;
                $response['message'] = 'Votre image est trop grande. Elle doit faire moins de 500 Ko!';
                wp_send_json( $response );
                exit();
            } else {
                $filename = sanitize_file_name('event_' . $eventClaimerName );
                $attachment_id = upload_file( $eventFile, $filename);
                if ( is_numeric($attachment_id) ) {
                    set_post_thumbnail( $eventID, $attachment_id );
                }else{
                    $response['message'] = 'fatal error';
                }

            }
        }

        $response['status'] = 200;
        $response['startTime'] = $startDate;
        $response['message'] = 'Votre événement est transmis.';
    }


    wp_send_json( $response );
}

add_action( 'wp_ajax_nopriv_process_form_contact', 'process_form_contact_callback' );
add_action( 'wp_ajax_process_form_contact', 'process_form_contact_callback' );
function process_form_contact_callback() {

    // Security
    $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : 0;
    if ( !wp_verify_nonce($nonce, 'contactNonce') ) {
        exit(__('not allowed', 'inssd'));
    }

    $response['message'] = 'une erreur est survenue. veuillez réessayer ultérieurement';
    $response['status'] = 201;

    $adminEmail = get_option('admin_email');

    $formContactName = isset( $_POST['params'][0]['value'] ) ? filter_var($_POST['params'][0]['value'],FILTER_SANITIZE_STRING) : '';
    $formContactFirstname = isset( $_POST['params'][1]['value'] ) ?  filter_var($_POST['params'][1]['value'],FILTER_SANITIZE_STRING) : '';
    $formContactEmail = isset( $_POST['params'][2]['value'] ) ? filter_var($_POST['params'][2]['value'],FILTER_SANITIZE_EMAIL) : '';
    $formContactMessage = isset( $_POST['params'][3]['value'] ) ? filter_var($_POST['params'][3]['value'],FILTER_SANITIZE_STRING) : '';

    if( !empty($adminEmail) && !empty($formContactEmail) && !empty($formContactName) && !empty($formContactFirstname) ){
        $headers = array(
            'From: Formulaire site In Seine-Saint-Denis <' . $adminEmail . '>',
            'Content-Type: text/html; charset=UTF-8',
        );
        $content = 'Nouveau message depuis le formulaire : <br>';
        $content .= 'Nom : ' . $formContactName . '<br>';
        $content .= 'Prénom : ' . $formContactFirstname . '<br>';
        $content .= 'Email : ' . $formContactEmail . '<br>';
        $content .= 'Message : ' . $formContactMessage . '<br>';

        if( wp_mail( $adminEmail, '[INSSD] Nouveau message', $content, $headers ) ) {
            $headersAR = array(
                'From: In Seine-Saint-Denis Contact <' . $adminEmail . '>',
                'Content-Type: text/html; charset=UTF-8',
            );
            $contentAR = 'Bonjour ' . $formContactFirstname . ',<br>';
            $contentAR .= 'Nous avons bien reçu votre message : ';
            $contentAR .= '<br>';
            $contentAR .= '"' . $formContactMessage . '"';
            $contentAR .= '<br>';

            if( wp_mail( $formContactEmail, 'Accusé de réception : inseinesaintdenis.fr', $contentAR, $headersAR ) ) {
                $response['status'] = 200;
                $response['message'] = 'Votre message a été transmis.';
            }
        }
    }
    $response['data'] = $formContactName . ' - ' . $formContactFirstname . ' - ' . $formContactEmail . ' - ' . $formContactMessage;
    wp_send_json( $response );
}

add_action( 'wp_ajax_nopriv_search_event', 'search_event_callback' );
add_action( 'wp_ajax_search_event', 'search_event_callback' );
function search_event_callback() {
    // Security
    $nonce = isset($_GET['nonce']) ? sanitize_text_field($_GET['nonce']) : 0;
    if ( !wp_verify_nonce($nonce, 'searchEventNonce') ) {
        exit(__('not allowed', 'inssd'));
    }
    $response['status'] = 201;
    $response['message'] = 'Aucun événement trouvé';

    $search = isset( $_GET['search'] ) ? filter_var($_GET['search'],FILTER_SANITIZE_STRING) : '';

    $args = array (
        'post_type' => 'tribe_events',
        'post_status' => array('publish'),
        'posts_per_page' => -1,
        'order' => 'DESC',
        'orderby' => 'date',
        's' => $search,
    );
    $eventsQry = new WP_Query( $args );

    if ( $eventsQry->have_posts() ) {
        $response['status'] = 200;
        $eventsArray = array();

        while ( $eventsQry->have_posts() ) {
            $eventsQry->the_post();

            $eventID = $post->ID;
            $startDate = get_field('start_date');
            $startDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $startDate);
            $startDate = $startDateTime->format('d/m/Y');
            $eventTerms = get_the_terms($eventID, 'tribe_events_cat');
            $eventTerm = '';
            if(!empty($eventTerms)){
                $eventTerm = $eventTerms[0]->name;
            }

            $event = array(
                'name' => get_the_title($eventID),
                'city' => get_field('city_event', $eventID),
                'date' => $startDate,
                'domain' => $eventTerm,
                'url' => get_the_permalink(),
            );

            $eventsArray[] = $event;
        }
        $response['events'] = $eventsArray;
        $response['test'] = $startDate;
        wp_reset_postdata();
    }

    wp_send_json( $response );
}

add_action( 'wp_ajax_nopriv_search_ambassador', 'search_ambassador_callback' );
add_action( 'wp_ajax_search_ambassador', 'search_ambassador_callback' );
function search_ambassador_callback() {
    // Security
    $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : 0;
    if ( !wp_verify_nonce($nonce, 'searchAmbassadorNonce') ) {
        exit(__('not allowed', 'inssd'));
    }
    $response['status'] = 201;
    $response['message'] = '<p>Aucun ambassadeur trouvé</p>';

    $paramsCity = isset( $_POST['params']['city'] ) ? filter_var($_POST['params']['city'],FILTER_SANITIZE_STRING) : '';
    $paramsDomain = isset( $_POST['params']['domain'] ) ? filter_var($_POST['params']['domain'],FILTER_SANITIZE_STRING) : '';
    $paramsSearch = isset( $_POST['params']['search'] ) ? filter_var($_POST['params']['search'],FILTER_SANITIZE_STRING) : '';
    $paramsOrder = isset( $_POST['params']['order'] ) ? filter_var($_POST['params']['order'],FILTER_SANITIZE_STRING) : '';
    $paramsPage = isset( $_POST['params']['page'] ) ? filter_var($_POST['params']['page'],FILTER_SANITIZE_NUMBER_INT) : '';
    $paramsPage = intval($paramsPage);

    $response['city'] = $paramsCity;
    $response['search'] = $paramsSearch;
    $response['page'] = $paramsPage;
    $response['domain'] = $paramsDomain;
    $response['order'] = $paramsOrder;

    /**
     * Setup query
     */
    if( $paramsOrder === 'false'){
        if(get_field('params_archive_ambassadors_random_sort','option') === 'oui'){
            $order = 'DESC';
            $orderby = 'rand';
        }else{
            $order = 'ASC';
            //$orderby = 'menu_order date';
            $orderby = 'name';
        }
    }else{
        $order = 'DESC';
        $orderby = 'date';
    }

    $args = array (
        'post_type' => 'tribe_organizer',
        'post_status' => array('publish'),
        'posts_per_page' => MAX_AMBASSADORS_PER_PAGE,
        'orderby' => $orderby,
        'order' => $order,
        'paged' => $paramsPage,
    );

    if( !empty($paramsSearch)){
        $args['s'] = $paramsSearch;
    }

    if(	$paramsCity != '' && $paramsDomain != '' ){

        $args['meta_query'] =  array(
            'relation'		=> 'AND',
            array(
                'key'		=> 'ville_amb',
                'value'		=> $paramsCity,
                'compare'	=> '='
            ),
            array(
                'key'		=> 'sec_act',
                'value'		=> $paramsDomain,
                'compare'	=> '='
            )
        );
    }else if( $paramsCity != '' ){

        $args['meta_query'] =  array(
            array(
                'key'		=> 'ville_amb',
                'value'		=> $paramsCity,
                'compare'	=> '='
            ),
        );

    }else if( $paramsDomain != '' ){

        $args['meta_query'] =  array(
            array(
                'key'		=> 'sec_act',
                'value'		=> $paramsDomain,
                'compare'	=> '='
            )
        );
    }


    $ambassadorsQry = new WP_Query( $args );

    ob_start();

    if ( $ambassadorsQry->have_posts() ) {
        ?>
        <div class="ambassador-blocks">
            <?php

            while ($ambassadorsQry->have_posts()) {
                $ambassadorsQry->the_post();

                global $post;
                $ambassadorID = $post->ID;

                $ambassadorLink = get_the_permalink($ambassadorID);
                $ambassadorThumbUrl = get_the_post_thumbnail_url($ambassadorID, 'thumb_archive_page_ambassador');

                $customFieldsAmbassador = get_fields($ambassadorID);

                if (!$ambassadorThumbUrl) {
                    $ambassadorThumbUrl = THEME_URL . 'img/ambassador_default.jpg';
                }

                ?>
                <div class="ambassador-block">
                    <?php if( !empty($customFieldsAmbassador['is_full']) ){
                        echo '<a href="' . get_the_permalink() .'">';
                    } ?>
                    <h2 class="title-h2 ambassador__name"><?php echo $customFieldsAmbassador['prenom_ambassadeur'] . ' ' . $customFieldsAmbassador['nom_amb']; ?></h2>
                    <?php if( !empty($customFieldsAmbassador['is_full']) ){
                        echo '</a>';
                    } ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="ambassador__infos">
                                <div class="ambassador__avatar"><img
                                        src="<?php echo $ambassadorThumbUrl; ?>" alt=""
                                        title=""></div>

                                <ul class="ambassador__specialties">
                                    <?php if (!empty($customFieldsAmbassador['fonction'])) { ?>
                                        <li class="ambassador__specialty ambassador__specialty--function">
                                            <span class="ambassador__specialty-icon"><i></i></span>
                                            <p>
                                                <span>Fonction</span><?php echo $customFieldsAmbassador['fonction']; ?>
                                            </p>
                                        </li>
                                    <?php }
                                    if (!empty($customFieldsAmbassador['soc_org'])) { ?>
                                        <li class="ambassador__specialty ambassador__specialty--business">
                                            <span class="ambassador__specialty-icon"><i></i></span>
                                            <p>
                                                <span>Entreprise</span><?php echo $customFieldsAmbassador['soc_org']; ?>
                                            </p>
                                        </li>
                                    <?php }
                                    if (!empty($customFieldsAmbassador['ville_amb'])) { ?>
                                        <li class="ambassador__specialty ambassador__specialty--city">
                                            <span class="ambassador__specialty-icon"><i></i></span>
                                            <p>
                                                <span>Ville</span><?php echo $customFieldsAmbassador['ville_amb']; ?>
                                            </p>
                                        </li>
                                    <?php }
                                    if (!empty($customFieldsAmbassador['sec_act'])) { ?>
                                        <li class="ambassador__specialty ambassador__specialty--domain">
                                            <span class="ambassador__specialty-icon"><i></i></span>
                                            <p>
                                                <span>Domaine</span><?php echo getDomains($customFieldsAmbassador['sec_act']); ?>
                                            </p>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <?php if ((!empty($customFieldsAmbassador['amb_facebook']) && $customFieldsAmbassador['amb_facebook'] != " ")
                                || (!empty($customFieldsAmbassador['amb_twitter']) && $customFieldsAmbassador['amb_twitter'] != " ")
                                || (!empty($customFieldsAmbassador['amb_instagram']) && $customFieldsAmbassador['amb_instagram'] != " ")) {
                                ?>
                                <div class="ambassador__actions">
                                    <h2 class="title-h2">Retrouvez-le sur les réseaux
                                        sociaux</h2>

                                    <ul class="ambassador__socials social">
                                        <?php if (!empty($customFieldsAmbassador['amb_facebook'])) { ?>
                                            <li class="ambassador__social social__item"><i
                                                    class="social__item-icon fab fa-facebook-f"></i><a
                                                    href="<?php echo $customFieldsAmbassador['amb_facebook']; ?>"><?php echo $customFieldsAmbassador['amb_facebook']; ?></a>
                                            </li>
                                        <?php }
                                        if (!empty($customFieldsAmbassador['amb_twitter'])) {
                                            ?>
                                            <li class="ambassador__social social__item"><i
                                                    class="social__item-icon fab fa-twitter"></i><a
                                                    href="<?php echo $customFieldsAmbassador['amb_twitter']; ?>"><?php echo $customFieldsAmbassador['amb_twitter']; ?></a>
                                            </li>
                                        <?php }
                                        if (!empty($customFieldsAmbassador['amb_instagram'])) {
                                            ?>
                                            <li class="ambassador__social social__item"><i
                                                    class="social__item-icon fab fa-instagram"></i>
                                                <a href="<?php echo $customFieldsAmbassador['amb_instagram']; ?>"><?php echo $customFieldsAmbassador['amb_instagram']; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (!empty($customFieldsAmbassador['mon_implication'])) { ?>
                        <div class="ambassador__specialty ambassador__specialty--implication">
                            <i class="ambassador__specialty-icon"></i>
                            <p><span>Mon implication</span><?php echo $customFieldsAmbassador['mon_implication']; ?></p>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        $response['content'] = ob_get_clean();
        ob_start();
        wp_pagination( $ambassadorsQry, $paramsPage, true);
        $response['pagination'] = ob_get_clean();

        $response['status'] = 200;
        $response['message'] = 'OK';
        wp_reset_postdata();
    }


    wp_send_json( $response );
}
