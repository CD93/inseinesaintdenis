(function($){

    $(document).ready(function(){
        bindPaginationClick();
    });
    hideSpinner();

    $(window).on("scroll touchmove", function () {
        $('header').toggleClass('tiny', $(document).scrollTop() > 0);
    });

    new NavMobile($("#header-nav"));

    var $datePicker, map;
    var markers = [];
    var bounds;

    $("*[data-vote-project-id]").each(function() {
        var $elt = $(this);
        $elt.on("click", function(event) {
            var $target = $(event.target);
            event.preventDefault();

            var projectId = $target.data("vote-project-id");
            console.log(projectId);
            // TODO: make XHR request
        });
    });

    $("*[data-toggle-slide]").each(function() {
        var $elt = $(this);
        var selector = $elt.data("toggle-slide");
        var $eltToSlide = $("." + selector);
        $eltToSlide.slideUp(0);
    });
    $("*[data-toggle-slide]").on("click", function(event) {
        event.preventDefault();
        var $elt = $(this);
        $elt.hide();
        $elt.parent().addClass("open");
        var selector = $elt.data("toggle-slide");
        var $eltToSlide = $("." + selector);
        $eltToSlide.slideDown();
    });

    $("input[type=file]").each(function(index, element) {
        $(this).inputfile();
    });



    $("#send-event-form").validate({
        rules:
            {
                eventClaimerName:
                    {
                        required : true,
                        minlength: 2,
                    },
                eventClaimerFirstName:
                    {
                        required : true,
                        minlength: 2,
                    },
                eventClaimerEmail:
                    {
                        required : true,
                        email : true,
                    },
                eventClaimerPhone:
                    {
                        required : true,
                        phoneFormat : true,
                    },
                eventLocation:
                    {
                        required : true
                    },
                ambassadorValidate:
                    {
                        required : true
                    },
            },
        submitHandler: function(form) {
            console.log("validation form ok");

            $('#event-form-submit').prop( "disabled", true );

            var formDataEvent = new FormData();
            var formEvent = $(form).serializeArray();

            $.each(formEvent, function(i, val) {
                formDataEvent.append(val.name, val.value);
            });

            var $eventPhotoInput = $('#event-file');
            var eventPhotoFile = $eventPhotoInput[0].files[0];

            if( $eventPhotoInput.length  !== 0 && eventPhotoFile !== undefined) {
                formDataEvent.append('eventFile', eventPhotoFile);
            }
            formDataEvent.append('action', 'process_send_event');
            formDataEvent.append('nonce', boData.ajxSendEventNonce);

            formDataEvent.forEach( function(value,key) {
                console.log(key + " " + value)
            });

            $.ajax({
                type: 'POST',
                mimeType: "multipart/form-data",
                url: boData.wp_ajax_url,
                dataType	: 'json',
                data : formDataEvent,
                processData: false,
                contentType: false,
                beforeSend:function(){
                    console.log('loading...');
                },
                success: function(response){
                    var status = response.status;
                    var message = response.message;
                    console.log( "status",status );
                    console.log( "message",message );

                    if(status === 201){
                        $('#event-form-submit').prop( "disabled", false );
                    }

                    $('#event-ok-submit').text(message);
                }
            });
        }
    });

    // START CONTACT
    $("#contact-form").validate({
        rules:
            {
                contactName:
                    {
                        required : true
                    },
                contactFirstName:
                    {
                        required : true
                    },
                contactEmail:
                    {
                        required : true,
                        email : true
                    },
            },
        submitHandler: function(form) {
            console.log("validation form ok");
            $submitBtn = $(form).find(".btn--blue");
            $contactFormResponseText = $("#contact-form-response");

            var data={
                action:"process_form_contact",
                nonce: boData.ajxContactNonce,
                params : $(form).serializeArray(),
            };
            $.post(boData.wp_ajax_url, data, 'json')
                .done(function (response) {
                    console.log("ok");
                    console.log(response.status);
                    $contactFormResponseText.text(response.message);
                    if(response.status === 200){
                        $(form).find('.btn--blue').prop("disabled",true);
                    }
                })
                .fail(function () {
                    console.log("fail");
                    $(form).find('.btn--blue').prop("disabled",false);
                });
        }
    });

    // END CONTACT

    // START BECOME AMBASSADORS

    $("#become-ambassador-form").validate({
        rules:
            {
                ambassadorGender:
                    {
                        required : true
                    },
                ambassadorName:
                    {
                        required : true
                    },
                ambassadorFirstName:
                    {
                        required : true
                    },
                ambassadortEmail:
                    {
                        required : true,
                        email : true
                    },
                ambassadorAdhesion:
                    {
                        required : true
                    },
                ambassadorFunction:
                    {
                        required : true
                    },
                ambassadorEmployer:
                    {
                        required : true
                    },
                ambassadorRgpd:
                    {
                        required : true
                    },
                ambassadorEngaged:
                    {
                        required : true
                    },
            },
        errorPlacement: function(error, element) {
            console.log( element.attr("name") );
            if(element.attr("type") == "checkbox") {
                element.parent().append(error);
            } else if(element.attr("type") == "radio") {
                console.log("radio oui");
                element.parent().append(error);
            } else {
                error.insertAfter(element);
            }
            $(element).parent().addClass("error");
        },
        success: function(error, element) {
            $(element).parent().removeClass("error");
        },
        submitHandler: function(form) {
            console.log("validation form ok");
            $('#ambassador-form-submit').prop( "disabled", true );

            var formDataAmbassador = new FormData();
            var formAmbassador = $(form).serializeArray();

            $.each(formAmbassador, function(i, val) {
                formDataAmbassador.append(val.name, val.value);
            });

            var $ambassadorPhotoInput = $('#ambassador-file');
            var ambassadorPhotoFile = $ambassadorPhotoInput[0].files[0];

            if( $ambassadorPhotoInput.length  !== 0 && ambassadorPhotoFile !== undefined) {
                formDataAmbassador.append('ambassadorFile', ambassadorPhotoFile);
            }
            formDataAmbassador.append('action', 'process_ambassador_apply');
            formDataAmbassador.append('nonce', boData.ajxApplyAmbassadorNonce);

            /*formDataAmbassador.forEach( function(value,key) {
                 console.log(key + " " + value)
            });*/

            $.ajax({
                type: 'POST',
                mimeType: "multipart/form-data",
                url: boData.wp_ajax_url,
                dataType	: 'json',
                data : formDataAmbassador,
                processData: false,
                contentType: false,
                beforeSend:function(){
                    console.log('loading...');
                },
                success: function(response){
                    var status = response.status;
                    var message = response.message;
                    console.log( "status",status );
                    console.log( "message",message );

                    if(status === 201){
                        $('#ambassador-form-submit').prop( "disabled", false );
                    }

                    $('#ambassador-ok-submit').text(message);
                }
            });
        }
    });
    // END BECOME AMBASSADORS

    // START AMBASSADORS
    var previousParams = {};
    function bindPaginationClick(){
        $(".ambassador-pagination .pagination__link").on("click", function(event) {
            event.preventDefault();

            var $elt = $(this);
            var page = parseInt($elt.attr('href').replace(/\D/g,''));

            getAmbassadors(page);
        });
    }

    $("#ambassadors-form").on("submit", function(event) {
        event.preventDefault();

        var $elt = $(this);

        var city = $elt.find("#ambassador-city").val();
        var domain = $elt.find("#ambassador-domain").val();
        var name = $elt.find("#ambassador-name").val();
        var order = $elt.find("#ambassador-order").is(':checked');

        getAmbassadors(1, {
            city: city,
            domain: domain,
            search: name,
            order: order,
        });
        return false;
    });

    function getAmbassadors(page, params) {
        if(!params) {
            params = previousParams;
        }
        params.page = page;
        previousParams = params;

        $("html, body").animate({
            scrollTop: 0
        }, 500, function() {

        });

        showSpinner();
        removeOldAmbassadorData();
        requestAmbassadors(params);
    }

    function showSpinner() {
        $(".spinner").show();
    }

    function hideSpinner() {
        $(".spinner").hide();
    }

    function requestAmbassadors(params) {
        var data={
            action:"search_ambassador",
            nonce: boData.ajxSearchAmbassadorNonce,
            params : params,
        };

        $.ajax({
            type: 'POST',
            url: boData.wp_ajax_url,
            dataType	: 'json',
            data : data,
            beforeSend:function(){
                console.log('loading...');
            },
            success: function(response){
                onAmbassadorsResults(response);
                bindPaginationClick();
            }
        });
    }

    function onAmbassadorsResults(data) {
        hideSpinner();

        if(data.status === 200 ){
            appendAmbassadorData(data.content);
            updatePagination(data.pagination);
        }else if(data.status === 201){
            appendAmbassadorData(data.message);
            updatePagination('');
        }
    }

    function removeOldAmbassadorData() {
        $(".ambassador-blocks").empty();
        $(".ambassador-pagination").empty();
    }

    function appendAmbassadorData(content) {
        $(".ambassador-blocks").append(content);
    }

    function updatePagination(content) {
        $(".ambassador-pagination").append(content);
    }
    // END AMBASSADORS

    $(".ajax-search-event").each(function() {
        var $elt = $(this);

        $elt.on("submit", searchEvent);
    });

    function searchEvent(event) {
        if(event) event.preventDefault();

        $(".agenda__records").slideUp(function() {
            $(".agenda__no-result").removeClass("active");
            emptyResults();
            showSpinner();
            $(".agenda").addClass("disable");

            var search = $("#inputSearch").val();

            var data={
                action:"search_event",
                nonce: boData.ajxSearchEventNonce,
                search : search,
            };

            $.get(boData.wp_ajax_url, data, 'json')
                .done(function (response) {

                    hideSpinner();

                    if(response.status === 200){

                        results = response.events;

                        for(var i = 0; i < results.length; i++) {
                            var result = results[i];
                            addResult(result.name, result.city, result.date, result.domain, result.url);
                        }

                        $(".agenda").removeClass("disable");
                        $(".agenda__records").slideDown();
                    } else {
                        $(".agenda__no-result").addClass("active");
                    }
                })
                .fail(function () {
                    console.log("fail");
                });
        });
    }
    searchEvent();


    function emptyResults() {
        $(".agenda__lign:not(.agenda__lign--label)").remove();
    }

    function addResult(name, city, date, domain, url) {
        var str = "<div class=\"agenda__lign\">";
        str += "<div><a href=\"" + url +  "\">" + name + "</a></div>";
        str += "<div>" + city + "</div>";
        str += "<div>" + date + "</div>";
        str += "<div>" + domain + "</div>";
        str += "</div>";
        $(".agenda__records").append(str);
    }

    $(".datetimepicker").each(function() {
        var $elt = $(this);
        var dp = $elt.datepicker({
            classes: "datetimepicker",
            timepicker: true,
            language: 'fr',
            showOtherMonths: false,
            navTitles: {
                days: 'MM yyyy'
            },
            offset: -20
        }).data("datepicker");
        // dp.show();
    })

    function resetEventsCalendar() {
        $datePicker.destroy();
        if(markers) {
            for(var i = 0, l = markers.length; i < l; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        }
        bounds = new google.maps.LatLngBounds();
    }

    function initEventsCalendar(events) {
        var $picker = $('.events__infos__calendar');
        var firstDateIndex = 0;
        var firstDayOffset = -1;
        $datePicker = $picker.datepicker({
            classes: "events__datepicker",
            language: 'fr',
            showOtherMonths: false,
            navTitles: {
                days: 'MM yyyy'
            },
            onRenderCell: function (date, cellType) {
                var currentDate = date.getDate();
                // Add extra element, if `eventDates` contains `currentDate`
                var dateFormatted = date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).substr(-2) + "-" + ("0" + currentDate).substr(-2);
                var objectToReturn = {};

                var classes = [];

                if (events && cellType == 'day' && dateIndexInEvents(dateFormatted, events) !== -1) {
                    objectToReturn.html = '<span>' + currentDate + '</span>';
                    classes.push("has-event");
                }


                if(currentDate === 1) {
                    classes.push("round-prev");
                    firstDayOffset = firstDateIndex;
                }
                if(firstDayOffset != -1 && firstDateIndex > firstDayOffset && firstDateIndex % 7 === 0) {
                    classes.push("round-prev");
                }
                if(firstDayOffset != -1 && firstDateIndex > firstDayOffset && firstDateIndex % 7 === 6) {
                    classes.push("round-next");
                }
                var firstDayNextMonth = new Date(date.getFullYear(), date.getMonth() + 1, 1);
                var lastDay = new Date(firstDayNextMonth - 1);
                if(firstDayOffset != -1 && currentDate === lastDay.getDate()) {
                    classes.push("round-next");
                }
                objectToReturn.classes = classes.join(" ");
                firstDateIndex++;

                return objectToReturn;
            },
            onSelect: function onSelect(fd, date) {
                var dateFormatted = date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).substr(-2) + "-" + ("0" + date.getDate()).substr(-2);
                var index = dateIndexInEvents(dateFormatted, events);
                if(index === -1) {
                    return;
                }
                window.location.href = events[index].link;
            }
        }).data('datepicker');
    }

    function dateIndexInEvents(dateFormatted, events) {
        if(!events) {
            return -1;
        }
        for(var i = 0, l = events.length; i < l; i++) {
            if(events[i].date === dateFormatted) {
                return i;
            }
        }
        return -1;
    }

    function initEventsViewer() {
        var $elt = $(".events__infos__viewer__form");
        var $select = $elt.find("select");
        $select.on("change", onEventThemeChange);
    }

    function showAllEvents() {
        var $elt = $(".events__infos__viewer__form");
        var $select = $elt.find("select");
        var $options = $select.find("option[val]");
        var currentEvents = [];
        $options.each(function(index) {
            currentEvents = currentEvents.concat(getEvents($options.eq(index)));
        })
        initEventsCalendar(currentEvents);
    }

    function getEvents($options) {
        var eventsCount = parseInt($options.data("events-count"), 10);
        var events = [];
        var image = boData.wp_theme_url + '/img/common/pin.svg';
        var icon = {
            url: image,
            anchor: new google.maps.Point(15,30),
            scaledSize: new google.maps.Size(30,30),
            labelOrigin: new google.maps.Point(15,12)
        };
        for(var i = 0; i < eventsCount; i++) {
            var latlng = $options.data("events-latlng-" + i);
            var latlngParts = latlng.split(",");
            var pos = {lat: parseFloat(latlngParts[0]), lng: parseFloat(latlngParts[1])};
            var dateStr = $options.data("events-date-" + i);
            var link = $options.data("events-link-" + i);
            events.push({
                // index: i,
                date: dateStr,
                lat: pos.lat,
                lng: pos.lng,
                link: link,
            });
            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                label: {
                    color: "#ffffff",
                    text: dateStr.substr(-2),
                    fontSize: "12px"
                },
                draggable: false,
                optimized: false,
                icon: icon,
            });
            marker.link = link;
            marker.addListener('click', function() {
                window.location.href = this.link;
            });
            markers.push(marker);
            bounds.extend(marker.position);
        }
        map.fitBounds(bounds);
        return events;
    }

    function onEventThemeChange(event) {
        resetEventsCalendar();

        var $target = $(event.currentTarget);
        var $selectedOption = $target.find(":selected");
        var currentEvents;
        if($selectedOption.attr("val") === undefined) {
            showAllEvents();
        } else {
            currentEvents = getEvents($selectedOption);
            initEventsCalendar(currentEvents);
        }
    }

    function initMap() {
        var $map = $('.events__map');
        var ssd = {lat: 48.924924, lng: 2.4738833};
        bounds = new google.maps.LatLngBounds();
        if($map.length > 0) {
            // The map, centered at Seine Saint Denis
            map = new google.maps.Map(
                $map[0], {zoom: 11, center: ssd, styles: gmapsStyle});

            showAllEvents();
            initEventsViewer();
        } else {

            var $map = $('.event-localisation__map');
            if($map.length == 0) {
                return;
            }
            map = new google.maps.Map(
                $map[0], {
                    zoom: 11, center: ssd,
                    disableDefaultUI: true,
                    styles: gmapsStyle
                }
            );
        }


        $(".event-localisation__map").each(function() {

            var $elt = $(this);
            var latlng = $elt.data("map-latlng");
            var latlngParts = latlng.split(",");
            var pos = {lat: parseFloat(latlngParts[0]), lng: parseFloat(latlngParts[1])};
            var image = boData.wp_theme_url + '/img/common/pin.svg';
            var icon = {
                url: image,
                anchor: new google.maps.Point(15,30),
                scaledSize: new google.maps.Size(30,30),
                labelOrigin: new google.maps.Point(15,12)
            };
            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                draggable: false,
                optimized: false,
                icon: icon,
            });
            map.setCenter(pos);
            map.setZoom(11);
        });

    }

    initMap();

    $.extend($.validator.messages, {
        required: "Ce champ est obligatoire.",
        email: "Veuillez fournir une adresse électronique valide. (exemple : nom@domaine.com)",
        digits: "Veuillez ne saisir que des chiffres.",
        dateFormat: "Le format de la date du champ 'Date de naissance' n'est pas correct DD/MM/YYYY. (exemple : 07/12/1988)",
        dateAge: "L'âge doit être compris entre 14 et 100 ans.",
        textFormat: "Seul les caractères spéciaux de type caractères alphabétiques, espace ou - sont autorisés.",
        simpleCharacters: 'Les caractères spéciaux de type \ / : * ? " < > | sont interdits.',
        phoneFormat: "Le format du numéro de téléphone n'est pas correct. (exemple : 0612345678 ou 0712345678)",
        maxlength: $.validator.format("Veuillez fournir au plus {0} caractères."),
        minlength: $.validator.format("Veuillez fournir au moins {0} caractères."),
        filesize: "Le format ne doit pas excéder 100MO.",
        localisationRequired: "Ce champ est obligatoire.",
        pwdLength: "Le mot de passe doit contenir au moins 8 caractères.",
        pwdMaj: "Le mot de passe doit contenir au moins une lettre en majuscule.",
        pwdMin: "Le mot de passe doit contenir au moins une lettre en minuscule.",
        pwdNumber: "Le mot de passe doit contenir au moins un chiffre.",
        pwdCharacters: "Le mot de passe doit contenir au moins un caractère spécial de type ^ $ & * . - _ / \ + ! ?.",
        yearFormat: "Le format de l'année doit être renseignée en indiquant 4 chiffres et débuter par 19 ou 20. (exemple : 1980 ou 2010)"
    });

    $.validator.addMethod("phoneFormat",
        function(value, element) {
            return value.match(/^(06|07)(\d{8})$/);
        }
    );


})(jQuery);

/**
 * Fix redirection de WPML lorsque la langue du visiteur est la langue par defaut
 */
/**
 jQuery(document).ready(function () {
    var wpmlBrowserRedirect = new WPMLBrowserRedirect();
    if( !wpmlBrowserRedirect.cookieExists() ){
        wpmlBrowserRedirect.setCookie( 'fr-FR' );
    }
});
 */


