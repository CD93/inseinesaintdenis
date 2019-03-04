<?php
$boxFields['title'] = get_field('params_bb_event_title','option');
$boxFields['subtitle'] = get_field('params_bb_event_subtitle','option');
$boxFields['text'] = get_field('params_bb_event_text','option');
$boxFields['button_label'] = get_field('params_bb_event_button_label','option');
?>
<div class="push-more push-more--events push-more--black">
    <img class="push-more__picto" src="<?php echo get_template_directory_uri(); ?>/img/common/picto-events-blue.svg" />
    <div class="push-more__text">
        <h2 class="push-more__title title-h2"><?php echo $boxFields['title']; ?></h2>
        <p class="push-more__specs"><?php echo $boxFields['subtitle']; ?></p>
    </div>

    <p class="push-more__desc"><?php echo $boxFields['text']; ?></p>

    <a href="" class="btn btn--round push-more__btn toggle" data-toggle-slide="send-event-form-wrapper"><?php echo $boxFields['button_label']; ?></a>

    <div class="send-event-form-wrapper" id="send-event-form-toggle">
        <form id="send-event-form">
            <div class="form-element">
                <div class="form-control form-control--2col">
                    <input type="text" name="eventClaimerName" class="" id="claimer-name" placeholder="Nom*">
                </div>

                <div class="form-control form-control--2col">
                    <input type="text" name="eventClaimerFirstName" class="" id="claimer-first-name" placeholder="Prénom*">
                </div>
            </div>

            <div class="form-element">
                <div class="form-control form-control--2col">
                    <input type="email" name="eventClaimerEmail" class="" id="claimer-email" placeholder="Email*">
                </div>

                <div class="form-control form-control--2col">
                    <input type="tel" name="eventClaimerPhone" class="" id="claimer-phone" placeholder="Téléphone (format requis 0123456789)*">
                </div>
            </div>

            <div class="form-element">
                <div class="form-control form-control--2col">
                    <input type="datetime" name="eventDatetimeStart" class="datetimepicker" id="event-start-time" placeholder="Date et heure de début">
                </div>

                <div class="form-control form-control--2col">
                    <input type="datetime" name="eventDatetimeEnd" class="datetimepicker" id="event-end-time" placeholder="Date et heure de fin">
                </div>
            </div>

            <div class="form-element">
                <div class="form-control">
                    <input type="text" name="eventLocation" class="location-field" id="event-location" placeholder="Lieu*">
                </div>
            </div>

            <div class="form-element">
                <div class="form-control">
                    <textarea name="eventComments" id="event-comments" placeholder="Informations complémentaires"></textarea>
                </div>
            </div>

            <div class="form-element form-control">
                <input type="file" accept=".jpg, .png" id="event-file" name="eventFile" class="input-file-hidden" data-size="" data-label="Envoyer un fichier (jpg ou png. Poids maximum 2 Mo)">
            </div>

            <div class="form-element">
                <div class="form-control form-control--bottom form-control--2col">
                    <span class="mandatory-field">*Informations obligatoires</span>

                    <input id="event-claimer-state" name="ambassadorValidate" class="custom-checkbox custom-checkbox--white" type="checkbox" value="" />
                    <label for="event-claimer-state">
                        <span class="checkbox-btn"></span>
                        <span class="text">Je suis ambassadeur</span>
                    </label>
                </div>

                <button id="event-form-submit" class="btn btn--round btn--blue send-event-form__btn" type="submit">Envoyer</button>
            </div>
            <p id="event-ok-submit"></p>
        </form>
    </div>
</div>
