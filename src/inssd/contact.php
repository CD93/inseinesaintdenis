<?php

/**
 * - Template Name: Contact
 */

get_template_part( 'partials/general/block', 'head' );

get_template_part( 'partials/general/block', 'top-nav' );

$pageContactID = get_the_ID();
$pageContactObject = get_post( $pageContactID );
$pageContactTitle = $pageContactObject->post_title;
$pageContactChapeau = get_field('contact_chapeau', $pageContactID);
$pageContactFormText = get_field('contact_form_text', $pageContactID);

?>

<main id="main" role="main" class="page-single-news" tabindex="-1">

    <div class="container">
        <div class="row container__cols">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-block">
                            <h1 class="title-h1"><?php echo $pageContactTitle; ?></h1>

                            <p class="intro"><?php echo $pageContactChapeau; ?></p>

                            <form id="contact-form">

                                <div class="form-element">
                                    <div class="form-control flex">
                                        <span class="mandatory-field">*Champs obligatoires</span>
                                    </div>
                                </div>

                                <div class="form-element">
                                    <div class="form-control">
                                        <input type="text" name="contactName" class="" id="contact-name" placeholder="Nom*">
                                    </div>
                                </div>

                                <div class="form-element">
                                    <div class="form-control">
                                        <input type="text" name="contactFirstName" class="" id="contact-first-name" placeholder="Prénom*">
                                    </div>
                                </div>

                                <div class="form-element">
                                    <div class="form-control">
                                        <input type="email" name="contactEmail" class="" id="contact-email" placeholder="Email*">
                                    </div>
                                </div>

                                <div class="form-element">
                                    <div class="form-control">
                                        <label class="label">Votre message</label>
                                        <textarea id="ambassadeurComments" name="ambassadeur-comments" placeholder=""></textarea>
                                    </div>
                                </div>

                                <div class="form-element form-element--center">
                                    <p><?php echo $pageContactFormText; ?></p>

                                    <button class="btn btn--round btn--blue" type="submit">Envoyer</button>
                                </div>

                            </form>
                            <p id="contact-form-response" ></p>
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
