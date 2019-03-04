<?php

/**
 * - Template Name: Devenir ambassadeur
 */

get_template_part( 'partials/general/block', 'head' );

get_template_part( 'partials/general/block', 'top-nav' );

$customFields = get_fields();

?>


<main id="main" role="main" class="page-become-ambassador" tabindex="-1">

    <div class="container">
        <div class="row container__cols">
            <div class="col-md-8">
                <div class="row">

                    <div class="col-md-12">
                        <div class="clearfix section-block">
                            <div class="section-top">
                                <h1 class="title-h1"><?php the_title(); ?></h1>

                                <p class="intro">
                                    <?php
                                    echo $customFields['page_become_ambassador_chapo'] ?></p>

                                <?php
                                $pageId = get_the_ID();
                                $page_object = get_post( $pageId );
                                echo $page_object->post_content;
                                ?>
                            </div>

                            <div class="become-ambassador-form-wrapper">
                                <form id="become-ambassador-form">
                                    <div class="wrapper-form-element">
                                        <div class="form-element flex">

                                            <div class="form-control form-control--radio">
                                                <label class="label">Mes informations</label>
                                                <input id="ambassador-status-madame" name="ambassadorGender" value="madame" class="custom-radio" type="radio" value="" />
                                                <label for="ambassador-status-madame">
                                                    <span class="radio-btn"></span>
                                                    <span class="text">Madame</span>
                                                </label>
                                                <input id="ambassador-status-monsieur" name="ambassadorGender" value="monsieur" class="custom-radio" type="radio" value="" />
                                                <label for="ambassador-status-monsieur">
                                                    <span class="radio-btn"></span>
                                                    <span class="text">Monsieur</span>
                                                </label>
                                            </div>

                                            <span class="mandatory-field">*Champs obligatoires</span>
                                        </div>


                                        <div class="form-element">
                                            <div class="form-control">
                                                <input type="text" name="ambassadorName" class="" id="ambassador-name" placeholder="Nom*">
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <input type="text" name="ambassadorFirstName" class="" id="ambassador-first-name" placeholder="Prénom*">
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <input type="text" name="ambassadorStreet" class="" id="ambassador-street" placeholder="Rue">
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <select name="ambassadorCity" class="">
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
                                                    <option value="Les Pavillons-sous-Bois">Les Pavillons-sous-Bois</option>
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
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <input type="text" name="ambassadorPhone" class="" id="ambassador-phone" placeholder="Tél">
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <input type="email" name="ambassadortEmail" class="" id="ambassador-email" placeholder="Email*">
                                            </div>
                                        </div>

                                        <div class="form-element form-control">
                                            <input type="file" accept=".jpg, .png" id="ambassador-file" name="ambassadorFile" class="input-file-hidden" data-size="" data-label="Téléverser une photo (jpg ou png. Poids maximum 2 Mo)">
                                        </div>
                                    </div>


                                    <div class="form-element">
                                        <div class="form-control form-control--radio">
                                            <label class="label">J’adhère* :</label>
                                            <input id="ambassador-adhesion-me" name="ambassadorAdhesion" value="ad_perso" class="custom-radio" type="radio" />
                                            <label for="ambassador-adhesion-me">
                                                <span class="radio-btn"></span>
                                                <span class="text">à titre personnel</span>
                                            </label>
                                            <input id="ambassador-adhesion-institution" name="ambassadorAdhesion" value="ad_struct" class="custom-radio" type="radio" />
                                            <label for="ambassador-adhesion-institution">
                                                <span class="radio-btn"></span>
                                                <span class="text">au titre d’une structure privée ou publique, d’une association, d’une institution</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="wrapper-form-element">
                                        <div class="form-element">
                                            <div class="form-control">
                                                <input type="text" name="ambassadorFunction" class="" id="ambassador-function" placeholder="Fonction*">
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <input type="text" name="ambassadorEmployer" class="" id="ambassador-employer" placeholder="Société / Organisme*">
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <select name="ambassadorDomain" class="select-black">
                                                    <option value="">Domaine d'activité</option>
                                                    <option value="sec_2">&Eacute;ducation</option>
                                                    <option value="nsec_11">Solidarit&eacute;, secteur social, sant&eacute;</option>
                                                    <option value="sec_5">Sport</option>
                                                    <option value="nsec_1">Artisanat d'art</option>
                                                    <option value="nsec_3">Tourisme, loisirs</option>
                                                    <option value="nsec_4">BTP, construction, logement et ville durable</option>
                                                    <option value="nsec_5">Numérique / digital, média, communication</option>
                                                    <option value="nsec_7">Aéronautique, électronique, secteur industriel</option>
                                                    <option value="nsec_9">Culture, création artistique</option>
                                                    <option value="nsec_10">Agriculture / écologie urbaine</option>
                                                    <option value="sec_6">Autre</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="wrapper-form-element">
                                        <div class="form-element">
                                            <div class="form-control">
                                                <label class="label">Réseaux sociaux</label>
                                                <input type="text" name="ambassadorFacebook" class="" id="ambassador-facebook" placeholder="Compte Facebook">
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <input type="text" name="ambassadorTwitter" class="" id="ambassador-twitter" placeholder="Compte Twitter">
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control">
                                                <input type="text" name="ambassadorInstagram" class="" id="ambassador-instagram" placeholder="Compte Instagram">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="wrapper-form-element">
                                        <div class="form-element">
                                            <div class="form-control">
                                                <label class="label">Mon implication dans le IN (500 signes max)</label>
                                                <textarea id="ambassadeurComments" name="ambassadorComments" placeholder=""></textarea>
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <div class="form-control form-control--radio form-control--implication">
                                                <label class="label">Je souhaite que mon implication soit</label>
                                                <input id="ambassador-implication-public" name="ambassadorImplication" value="public" class="custom-radio" type="radio" value="" />
                                                <label for="ambassador-implication-public">
                                                    <span class="radio-btn"></span>
                                                    <span class="text">publique</span>
                                                </label>
                                                <input id="ambassador-implication-private" name="ambassadorImplication" value="private" class="custom-radio" type="radio" value="" />
                                                <label for="ambassador-implication-private">
                                                    <span class="radio-btn"></span>
                                                    <span class="text">privée</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wrapper-form-element">
                                        <div class="form-element">
                                            <div class="form-control">
                                                <input id="ambassador-rgpd" name="ambassadorRgpd" class="custom-checkbox" type="checkbox" value=""/>
                                                <label for="ambassador-rgpd">
                                                    <span class="checkbox-btn"></span>
                                                    <span class="text text--b">Accepter la réglementation RGPD <span class="small">(obligatoire)</span>
                                                        <p><?php echo $customFields['page_become_ambassador_rgpd'] ?></p>
                                                    </span>

                                                </label>
                                            </div>
                                        </div>


                                        <div class="form-element">
                                            <div class="form-control">
                                                <input id="ambassador-engaged" name="ambassadorEngaged" class="custom-checkbox" type="checkbox" value=""/>
                                                <label for="ambassador-engaged">
                                                    <span class="checkbox-btn"></span>
                                                    <span class="text text--b">Je m’engage à respecter les engagements de la charte du In Seine-Saint-Denis <span class="small">(obligatoire)</span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-element form-element--center">
                                        <button id="ambassador-form-submit" class="btn btn--round btn--blue" type="submit">ENVOYER</button>
                                    </div>
                                </form>
                                <p id="ambassador-ok-submit" ></p>
                            </div>

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
