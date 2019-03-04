/*
 * jQuery Form Elements
 *
 * Author : @starfennec
 * Version: 0.1
 * Date: mar 22 2017
 */

(function($) {

    var dropDown = function(dropdown, options) {

        var settings = $.extend({
            maxItems: 5
        }, options || {});

        this.settings = settings;

        var $dropdown = $(dropdown);

        if( $dropdown.parent('.form-element').length == 1 ) {
            var activeVal = $dropdown.find('option:selected').text();
            var options = '';
            $dropdown.find('option').each(function(i,e){
                var active = "";
                if(i == 0) {active = "active";}
                options += '<li data-value="' + $(e).val() + '" class="' + active + '"><button type="button" class="select-option">'+$(e).text()+'</button></li>';
            });



            var newDropdown = $('<div class="form-element-dropdown">'+
                '<button type="button" class="open-options"><span>'+activeVal+'</span></button>'+
                '<ul data-max-items="'+this.settings.maxItems+'">'+options+'</ul>'+
            '</div>');

            $dropdown.addClass("disable").parent('.form-element').append(newDropdown);
            // $dropdown.hide().parent('.form-element').append(newDropdown);
            // $dropdown.parent('.form-element').append(newDropdown);
        }
    }

    function init(){
        $('body').on('click', '.form-element-dropdown>.open-options', function(e){
            e.preventDefault();
            var wrap = $(this).parent('.form-element-dropdown');
            var isOpen = false;

            if(wrap.hasClass('active')){
                isOpen = true;
            }

            $('.form-element-dropdown').each(function(i,e){
                if($(this).hasClass('active')){
                    closeDropdown(this);
                }
            });

            if(!isOpen){
                openDropdown(wrap);
            }


        }).on('click', '.form-element-dropdown ul li', function(e){
            // e.preventDefault();
            var index = $(this).index(),
                val = $(this).data("value"),
                valTxt = $(this).text(),
                wrap = $(this).closest('.form-element-dropdown');

            wrap.siblings('select')
                .find('option')
                .eq(index)
                .prop("selected",true);

            wrap.find('>a span').text(valTxt);

            if(app.currentPage.id == "Works" ) {
                if( wrap.siblings('select').hasClass("categories") ) {
                    app.currentPage.filterByCategories(val);
                } else {
                    app.currentPage.filterBySectors(val);
                }
            } else if(app.currentPage.id == "News" ) {
                app.currentPage.filterByCatogory(val);

            } else if(app.currentPage.id == "Contact") {
                if(index == 0) {
                    wrap.siblings('.label').removeClass("active");
                } else {
                    wrap.siblings('.label').addClass("active");

                    wrap.siblings('select').closest(".form-element-select").removeClass("error");
                }
            }

            wrap.find("li").removeClass("active");
            wrap.find("li").eq(index).addClass("active");

            closeDropdown(wrap);
        });

        $('body').on('click', function(e){
            if($(e.target).closest('.form-element-dropdown').length == 0){

                $('.form-element-dropdown').each(function(i,e){

                    if($(this).hasClass('active')){
                        closeDropdown(this);
                    }
                });
            }
        });
    }
    function openDropdown(dropdown){
        var $dropdown = $(dropdown);
        $dropdown.addClass('active');



        var itemHeight = $dropdown.find('li').eq(0).height(),
            itemNum = $dropdown.find('li').length,
            maxItems = $dropdown.find('ul').attr('data-max-items');

        setTimeout(function() {
            TweenMax.to($dropdown.find("ul"), .25, {opacity: "1", display: "block" });
        }, 10);

        //console.log(itemNum+'*'+itemHeight+'(max '+maxItems+')');
        // if(itemNum > maxItems){
        //     $dropdown.find('ul').css({ 'height' : maxItems*itemHeight });
        // }
    }

    function closeDropdown(dropdown){
        var $dropdown = $(dropdown);
        $dropdown.removeClass('active');
        TweenMax.to($dropdown.find("ul"), .25, { opacity: "0", display: "none" });
    }

    function log(){
        if (window.console && console.log)
            console.log('[FormElements] ' + Array.prototype.join.call(arguments,' '));
    }

    var initialized = false;

    $.fn.dropdown = function(options){
        if(!initialized) {
            init();
            initialized = true;
        }

        return this.each(function(i,e){
            var fe = new dropDown(e, options);
       });
    };

    var inputFile = function(input, options) {
        var settings = $.extend({

        }, options || {});

        this.settings = settings;

        var $input = $(input);


        if($input.parent('.form-element').length == 1){
          var label = $input.attr('data-label');
          var $btn = $('<div><span>'+label+'</span></div>');
          var $cross = $('<a href="#"></a>');
          $cross.on('click', function(e){
            e.preventDefault();
            e.stopPropagation();

            $input.val('');
            $btn.removeClass('form-element-inputfile-filled');
            $(this).siblings('span').text(label);
          });

          $cross.addClass('form-element-inputfile-reset').appendTo($btn);
          $btn.addClass('form-element-inputfile');
          $btn.on('click', function(){
              $input.trigger('click');
          });

          $input.on('change', function(e){
            if(this.files[0].size > 2000000){
               this.value = "";
               return;
            };

            var fileName = '';

            if( this.files && this.files.length > 1 )
              fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{n}', this.files.length );
            else if( e.target.value )
              fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
              $btn.addClass('form-element-inputfile-filled').find('span').text(fileName);
            else
              $btn.removeClass('form-element-inputfile-filled').find('span').text(label);
          });

          // Firefox bug fix
          $input
            .on( 'focus', function(){ $input.addClass( 'has-focus' ); })
            .on( 'blur', function(){ $input.removeClass( 'has-focus' ); });

          $input.addClass('input-file-hidden');
          $btn.appendTo($input.parent('.form-element'));
        }
    }

    $.fn.inputfile = function(options){
        return this.each(function(i,e){
            var fe = new inputFile(e, options);
        });
    };

})(jQuery);
