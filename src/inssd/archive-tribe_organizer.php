<?php
get_template_part('partials/general/block', 'head');
get_template_part('partials/general/block', 'top-nav');

$pageAmbassadorsRandomSort = get_field('params_archive_ambassadors_random_sort', 'option');
$pageAmbassadorsIntroText = get_field('params_archive_ambassadors_text', 'option');

$paged = 1;

if($pageAmbassadorsRandomSort === 'oui'){
    $order = 'DESC';
    $orderby = 'rand';
}else{
    $order = 'ASC';
    $orderby = 'name';
}

$args = array(
    'post_type' => 'tribe_organizer',
    'post_status' => array('publish'),
    'posts_per_page' => MAX_AMBASSADORS_PER_PAGE,
    'order' => $order,
    'orderby' => $orderby,
);
$ambassadorsQry = new WP_Query($args);
$ambassadorsCount = $ambassadorsQry->found_posts;

?>


    <main id="main" role="main" class="page-ambassadors" tabindex="-1">

        <div class="container">
            <div class="row container__cols">
                <div class="col-md-8">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="clearfix section-block">
                                <h1 class="title-h1">Nos ambassadeurs</h1>
                                <h2 class="title-h2 ambassador__sub-title">Nous sommes actuellement <span><?php echo $ambassadorsCount; ?></span>
                                    ambassadeurs</h2>

                                <p><?php echo $pageAmbassadorsIntroText; ?></p>

                                <div class="ambassadors-form-wrapper" id="ambassadors-form">
                                    <form id="ambassadors-form">
                                        <div class="form-element">
                                            <div class="form-control form-control--2col">
                                                <select class="" id="ambassador-city" name="ambassadorCity">
                                                    <option value="">Ville</option>
                                                    <option value="Aubervilliers">Aubervilliers</option>
                                                    <option value="Aulnay-sous-Bois">Aulnay-sous-Bois</option>
                                                    <option value="Bagnolet">Bagnolet</option>
                                                    <option value="Bobigny">Bobigny</option>
                                                    <option value="Bondy">Bondy</option>
                                                    <option value="Clichy-sous-Bois">Clichy-sous-Bois</option>
                                                    <option value="Coubron">Coubron</option>
                                                    <option value="Drancy">Drancy</option>
                                                    <option value="Dugny">Dugny</option>
                                                    <option value="Épinay-sur-Seine">Épinay-sur-Seine</option>
                                                    <option value="Gagny">Gagny</option>
                                                    <option value="Gournay-sur-Marne">Gournay-sur-Marne</option>
                                                    <option value="L'Île-Saint-Denis">L'Île-Saint-Denis</option>
                                                    <option value="La Courneuve">La Courneuve</option>
                                                    <option value="Le Blanc-Mesnil">Le Blanc-Mesnil</option>
                                                    <option value="Le Bourget">Le Bourget</option>
                                                    <option value="Le Pré-Saint-Gervais">Le Pré-Saint-Gervais</option>
                                                    <option value="Le Raincy">Le Raincy</option>
                                                    <option value="Les Lilas">Les Lilas</option>
                                                    <option value="Les Pavillons-sous-Bois">Les Pavillons-sous-Bois
                                                    </option>
                                                    <option value="Livry-Gargan">Livry-Gargan</option>
                                                    <option value="Montfermeil">Montfermeil</option>
                                                    <option value="Montreuil">Montreuil</option>
                                                    <option value="Neuilly-Plaisance">Neuilly-Plaisance</option>
                                                    <option value="Neuilly-sur-Marne">Neuilly-sur-Marne</option>
                                                    <option value="Noisy-le-Grand">Noisy-le-Grand</option>
                                                    <option value="Noisy-le-Sec">Noisy-le-Sec</option>
                                                    <option value="Pantin">Pantin</option>
                                                    <option value="Pierrefitte-sur-Seine">Pierrefitte-sur-Seine</option>
                                                    <option value="Romainville">Romainville</option>
                                                    <option value="Rosny-sous-Bois">Rosny-sous-Bois</option>
                                                    <option value="Saint-Ouen">Saint-Ouen</option>
                                                    <option value="Saint-Denis">Saint-Denis</option>
                                                    <option value="Sevran">Sevran</option>
                                                    <option value="Stains">Stains</option>
                                                    <option value="Tremblay-en-France">Tremblay-en-France</option>
                                                    <option value="Vaujours">Vaujours</option>
                                                    <option value="Villemomble">Villemomble</option>
                                                    <option value="Villepinte">Villepinte</option>
                                                    <option value="Villetaneuse">Villetaneuse</option>
                                                    <option value="Paris">Paris</option>
                                                    <option value="Autre">Autre</option>
                                                </select>
                                            </div>

                                            <div class="form-control form-control--2col">
                                                <select class="" id="ambassador-domain" name="ambassadorDomain">
                                                    <option value="">Domaine d'activité</option>
                                                    <option value="sec_2">&Eacute;ducation</option>
                                                    <option value="nsec_11">Solidarit&eacute;, secteur social, sant&eacute;</option>
                                                    <option value="sec_5">Sport</option>
                                                    <option value="nsec_1">Artisanat d'art</option>
                                                    <option value="nsec_3">Tourisme, loisirs</option>
                                                    <option value="nsec_4">BTP, construction, logement et ville
                                                        durable
                                                    </option>
                                                    <option value="nsec_5">Numérique / digital, média, communication
                                                    </option>
                                                    <option value="nsec_7">Aéronautique, électronique, secteur
                                                        industriel
                                                    </option>
                                                    <option value="nsec_9">Culture, création artistique</option>
                                                    <option value="nsec_10">Agriculture / écologie urbaine</option>
                                                    <option value="sec_6">Autre</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <input type="text" id="ambassador-name" name="ambassadorName"
                                                       placeholder="Prénom, Nom">
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <button class="btn btn--black btn--round" type="submit">Rechercher</button>
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <input id="ambassador-order" name="ambassadorOrder"
                                                       class="custom-checkbox" type="checkbox" value="1"/>
                                                <label for="ambassador-order">
                                                    <span class="checkbox-btn"></span>
                                                    <span class="text">Trier par date d'inscription</span>
                                                </label>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <div class="spinner spinner--ambassadors">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                                <?php


                                if ($ambassadorsQry->have_posts()) {
                                    ?>
                                    <div class="ambassador-blocks">
                                        <?php

                                        while ($ambassadorsQry->have_posts()) {
                                            $ambassadorsQry->the_post();

                                            $ambassadorID = $post->ID;
                                            $ambassadorTitle = get_the_title($ambassadorID);

                                            $ambassadorLink = get_the_permalink($ambassadorID);
                                            $ambassadorThumbUrl = get_the_post_thumbnail_url($ambassadorID, 'thumb_archive_page_ambassador');

                                            $customFieldsAmbassador = get_fields();

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
                                                                <h2 class="title-h2">Ses réseaux sociaux</h2>

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
                                    <div class="ambassador-pagination">
                                        <?php
                                        wp_pagination( $ambassadorsQry, $paged, true);
                                        ?>
                                    </div>
                                    <?php
                                    wp_reset_postdata();
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-3 col-md-offset-1">
                    <?php
                    get_template_part('partials/general/block', 'sidebar');
                    ?>
                </div>
            </div>
        </div>

    </main>

<?php

get_template_part('partials/general/block', 'bottom-nav');

get_template_part('partials/general/block', 'footer');
