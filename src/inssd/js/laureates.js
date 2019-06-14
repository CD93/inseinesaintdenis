(function($){

    // START LAUREATES
    var previousLaureateParams = {};
    function bindLaureatesPaginationClick() {
        $(".laureates-pagination .pagination__link").on("click", function(event) {
            event.preventDefault();

            var $elt = $(this);
            var page = parseInt($elt.attr('href').replace(/\D/g,''));

            getLaureates(page);
        });
    }

    $("#laureates-form").on("submit", function(event) {
        event.preventDefault();

        var $elt = $(this);

        var thematic = $elt.find("#laureates-thematic").val();
        var subThematic = $elt.find("#laureates-sub-thematic").val();
        var zone = $elt.find("#laureates-zone").val();
        var association = $elt.find("#laureates-association").val();
        var project = $elt.find("#laureates-project").val();

        getLaureates(1, {
            thematic: thematic,
            subThematic: subThematic,
            zone: zone,
            association: association,
            project: project,
        });
        return false;
    });

    function getLaureates(page, params) {
        if(!params) {
            params = previousLaureateParams;
        }
        params.page = page;
        previousLaureateParams = params;

        $("html, body").animate({
            scrollTop: 0
        }, 500, function() {

        });

        showSpinner();
        removeOldLaureateData();
        requestLaureates(params);
    }

    function showSpinner() {
        $(".spinner").show();
    }

    function hideSpinner() {
        $(".spinner").hide();
    }

    function requestLaureates(params) {
        console.log(laureatData.ajxSearchLaureateNonce);
        var data={
            action:"search_laureates",
            nonce: laureatData.ajxSearchLaureateNonce,
            params : params,
        };

        $.ajax({
            type: 'POST',
            url: laureatData.wp_ajax_url,
            dataType	: 'json',
            data : data,
            beforeSend:function(){
                console.log('loading...');
            },
            success: function(response){
                onLaureatesResults(response);
                bindLaureatesPaginationClick();
            }
        });
    }

    function onLaureatesResults(data) {
        hideSpinner();

        if(data.status === 200 ){
            appendLaureateData(data.content);
            updatePagination(data.pagination);
        }else if(data.status === 201){
            appendLaureateData(data.message);
            updatePagination('');
        }
    }

    function removeOldLaureateData() {
        $(".laureates-blocks").empty();
        $(".laureates-pagination").empty();
    }

    function appendLaureateData(content) {
        $(".laureates-blocks").append(content);
    }

    function updatePagination(content) {
        $(".laureates-pagination").append(content);
    }
    bindLaureatesPaginationClick();
    // END LAUREATES

})(jQuery);
