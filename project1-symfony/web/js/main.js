/*
 * printThis v1.5
 * @desc Printing plug-in for jQuery
 * @author Jason Day
 *
 * Resources (based on) :
 *              jPrintArea: http://plugins.jquery.com/project/jPrintArea
 *              jqPrint: https://github.com/permanenttourist/jquery.jqprint
 *              Ben Nadal: http://www.bennadel.com/blog/1591-Ask-Ben-Print-Part-Of-A-Web-Page-With-jQuery.htm
 *
 * Licensed under the MIT licence:
 *              http://www.opensource.org/licenses/mit-license.php
 *
 * (c) Jason Day 2015
 *
 * Usage:
 *
 *  $("#mySelector").printThis({
 *      debug: false,               * show the iframe for debugging
 *      importCSS: true,            * import page CSS
 *      importStyle: false,         * import style tags
 *      printContainer: true,       * grab outer container as well as the contents of the selector
 *      loadCSS: "path/to/my.css",  * path to additional css file - us an array [] for multiple
 *      pageTitle: "",              * add title to print page
 *      removeInline: false,        * remove all inline styles from print elements
 *      printDelay: 333,            * variable print delay
 *      header: null,               * prefix to html
 *      formValues: true            * preserve input/form values
 *  });
 *
 * Notes:
 *  - the loadCSS will load additional css (with or without @media print) into the iframe, adjusting layout
 */
;
(function($) {
    var opt;
    $.fn.printThis = function(options) {
        opt = $.extend({}, $.fn.printThis.defaults, options);
        var $element = this instanceof jQuery ? this : $(this);

        var strFrameName = "printThis-" + (new Date()).getTime();

        if (window.location.hostname !== document.domain && navigator.userAgent.match(/msie/i)) {
            // Ugly IE hacks due to IE not inheriting document.domain from parent
            // checks if document.domain is set by comparing the host name against document.domain
            var iframeSrc = "javascript:document.write(\"<head><script>document.domain=\\\"" + document.domain + "\\\";</script></head><body></body>\")";
            var printI = document.createElement('iframe');
            printI.name = "printIframe";
            printI.id = strFrameName;
            printI.className = "MSIE";
            document.body.appendChild(printI);
            printI.src = iframeSrc;

        } else {
            // other browsers inherit document.domain, and IE works if document.domain is not explicitly set
            var $frame = $("<iframe id='" + strFrameName + "' name='printIframe' />");
            $frame.appendTo("body");
        }


        var $iframe = $("#" + strFrameName);

        // show frame if in debug mode
        if (!opt.debug) $iframe.css({
            position: "absolute",
            width: "0px",
            height: "0px",
            left: "-600px",
            top: "-600px"
        });


        // $iframe.ready() and $iframe.load were inconsistent between browsers
        setTimeout(function() {

            // Add doctype to fix the style difference between printing and render
            function setDocType($iframe,doctype){
                var win, doc;
                win = $iframe.get(0);
                win = win.contentWindow || win.contentDocument || win;
                doc = win.document || win.contentDocument || win;
                doc.open();
                doc.write(doctype);
                doc.close();
            }
            if(opt.doctypeString){
                setDocType($iframe,opt.doctypeString);
            }

            var $doc = $iframe.contents(),
                $head = $doc.find("head"),
                $body = $doc.find("body");

            // add base tag to ensure elements use the parent domain
            $head.append('<base href="' + document.location.protocol + '//' + document.location.host + '">');

            // import page stylesheets
            if (opt.importCSS) $("link[rel=stylesheet]").each(function() {
                var href = $(this).attr("href");
                if (href) {
                    var media = $(this).attr("media") || "all";
                    $head.append("<link type='text/css' rel='stylesheet' href='" + href + "' media='" + media + "'>")
                }
            });

            // import style tags
            if (opt.importStyle) $("style").each(function() {
                $(this).clone().appendTo($head);
                //$head.append($(this));
            });

            //add title of the page
            if (opt.pageTitle) $head.append("<title>" + opt.pageTitle + "</title>");

            // import additional stylesheet(s)
            if (opt.loadCSS) {
                if( $.isArray(opt.loadCSS)) {
                    jQuery.each(opt.loadCSS, function(index, value) {
                        $head.append("<link type='text/css' rel='stylesheet' href='" + this + "'>");
                    });
                } else {
                    $head.append("<link type='text/css' rel='stylesheet' href='" + opt.loadCSS + "'>");
                }
            }

            // print header
            if (opt.header) $body.append(opt.header);

            // grab $.selector as container
            if (opt.printContainer) $body.append($element.outer());

            // otherwise just print interior elements of container
            else $element.each(function() {
                $body.append($(this).html());
            });

            // capture form/field values
            if (opt.formValues) {
                // loop through inputs
                var $input = $element.find('input');
                if ($input.length) {
                    $input.each(function() {
                        var $this = $(this),
                            $name = $(this).attr('name'),
                            $checker = $this.is(':checkbox') || $this.is(':radio'),
                            $iframeInput = $doc.find('input[name="' + $name + '"]'),
                            $value = $this.val();

                        //order matters here
                        if (!$checker) {
                            $iframeInput.val($value);
                        } else if ($this.is(':checked')) {
                            if ($this.is(':checkbox')) {
                                $iframeInput.attr('checked', 'checked');
                            } else if ($this.is(':radio')) {
                                $doc.find('input[name="' + $name + '"][value=' + $value + ']').attr('checked', 'checked');
                            }
                        }

                    });
                }

                //loop through selects
                var $select = $element.find('select');
                if ($select.length) {
                    $select.each(function() {
                        var $this = $(this),
                            $name = $(this).attr('name'),
                            $value = $this.val();
                        $doc.find('select[name="' + $name + '"]').val($value);
                    });
                }

                //loop through textareas
                var $textarea = $element.find('textarea');
                if ($textarea.length) {
                    $textarea.each(function() {
                        var $this = $(this),
                            $name = $(this).attr('name'),
                            $value = $this.val();
                        $doc.find('textarea[name="' + $name + '"]').val($value);
                    });
                }
            } // end capture form/field values

            // remove inline styles
            if (opt.removeInline) {
                // $.removeAttr available jQuery 1.7+
                if ($.isFunction($.removeAttr)) {
                    $doc.find("body *").removeAttr("style");
                } else {
                    $doc.find("body *").attr("style", "");
                }
            }

            setTimeout(function() {
                if ($iframe.hasClass("MSIE")) {
                    // check if the iframe was created with the ugly hack
                    // and perform another ugly hack out of neccessity
                    window.frames["printIframe"].focus();
                    $head.append("<script>  window.print(); </script>");
                } else {
                    // proper method
                    if (document.queryCommandSupported("print")) {
                        $iframe[0].contentWindow.document.execCommand("print", false, null);
                    } else {
                        $iframe[0].contentWindow.focus();
                        $iframe[0].contentWindow.print();
                    }
                }

                //remove iframe after print
                if (!opt.debug) {
                    setTimeout(function() {
                        $iframe.remove();
                    }, 1000);
                }

            }, opt.printDelay);

        }, 333);

    };

    // defaults
    $.fn.printThis.defaults = {
        debug: false,           // show the iframe for debugging
        importCSS: true,        // import parent page css
        importStyle: false,     // import style tags
        printContainer: true,   // print outer container/$.selector
        loadCSS: "",            // load an additional css file - load multiple stylesheets with an array []
        pageTitle: "",          // add title to print page
        removeInline: false,    // remove all inline styles
        printDelay: 333,        // variable print delay
        header: null,           // prefix to html
        formValues: true,        // preserve input/form values
        doctypeString: '<!DOCTYPE html>' // html doctype
    };

    // $.selector container
    jQuery.fn.outer = function() {
        return $($("<div></div>").html(this.clone())).html()
    }
})(jQuery);

/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Andrew Stromnov (stromnov@gmail.com). */
( function( factory ) {
    if ( typeof define === "function" && define.amd ) {

        // AMD. Register as an anonymous module.
        define( [ "" ], factory );
    } else {

        // Browser globals
        factory( jQuery.datepicker );
    }
}( function( datepicker ) {

    datepicker.regional.ru = {
        closeText: "Закрыть",
        prevText: "&#x3C;Пред",
        nextText: "След&#x3E;",
        currentText: "Сегодня",
        monthNames: [ "Январь","Февраль","Март","Апрель","Май","Июнь",
            "Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь" ],
        monthNamesShort: [ "Янв","Фев","Мар","Апр","Май","Июн",
            "Июл","Авг","Сен","Окт","Ноя","Дек" ],
        dayNames: [ "воскресенье","понедельник","вторник","среда","четверг","пятница","суббота" ],
        dayNamesShort: [ "вск","пнд","втр","срд","чтв","птн","сбт" ],
        dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ],
        weekHeader: "Нед",
        dateFormat: "dd.mm.yy",
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: "" };
    datepicker.setDefaults( datepicker.regional.ru );

    return datepicker.regional.ru;

} ) );

/* highslide */
            hs.graphicsDir = '/fond-bodia/bundles/mfo/js/highslide/graphics/';
            hs.align = 'center';
            hs.wrapperClassName = 'borderless floating-caption';
            hs.fadeInOut = true;
            hs.transitions = ['expand', 'crossfade'];
            hs.captionEval = 'this.a.title';
            hs.dimmingOpacity = .75;
            hs.padToMinWidth = true;
            hs.marginLeft = 10;
            hs.marginRight = 10;
            hs.marginTop = 10;
            hs.marginBottom = 10;
            
            // Add the slideshow controller
            hs.addSlideshow({
            	slideshowGroup: 'group1',
            	interval: 5000,
            	repeat: false,
            	useControls: true,
            	fixedControls: 'fit',
            	overlayOptions: {
            		opacity: 0.75,
            		position: 'bottom center',
            		offsetX: 0,
            		offsetY: -15,
            		hideOnMouseOut: true
            	}
            });
            
            // Russian language strings
            hs.lang = {
            	cssDirection: 'ltr',
            	loadingText: 'Загружается...',
            	loadingTitle: 'Нажмите для отмены',
            	focusTitle: 'Нажмите чтобы поместить на передний план',
            	fullExpandTitle: 'Развернуть до оригинального размера',
            	creditsText: '',
            	creditsTitle: '',
            	previousText: 'Предыдущее',
            	nextText: 'Следующее',
            	moveText: 'Переместить',
            	closeText: 'Закрыть',
            	closeTitle: 'Закрыть (esc)',
            	resizeTitle: 'Изменить размер',
            	playText: 'Слайдшоу',
            	playTitle: 'Начать слайдшоу (пробел)',
            	pauseText: 'Пауза',
            	pauseTitle: 'Приостановить слайдшоу (пробел)',
            	previousTitle: 'Предыдущее (стрелка влево)',
            	nextTitle: 'Следующее (стрелка вправо)',
            	moveTitle: 'Переместить',
            	fullExpandText: 'Оригинальный размер',
            	number: 'Изображение %1 из %2',
            	restoreTitle: 'Нажмите чтобы закрыть изображение, нажмите и перетащите для изменения местоположения. Для просмотра изображений используйте стрелки.'
            };
            
            var config1 = {
            	slideshowGroup: 'group1',
            	contentId: 'highslide-main'
            };
 


$(function(){


    var init = {

        application: function(){
            init.jqueryDatepicker('.datepicker');// инициализация datepicker
            init.formCalculator(); // инициализация ajaxForm
            init.documentReady()   // инициализация js для документа
        },

        jqueryDatepicker: function(input){
            $(input).removeClass('hasDatepicker');
            $(input).datepicker({
                dateFormat: 'dd.mm.yy',
                regional:'ru',
                minDate: 0,
                beforeShow: function(textbox, instance){
                    $('#date-field').append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').hide();
                }
            });
        },

        formCalculator: function(){

            $('body').on('click', '.submit-calc', function(){
                var btn = $('#credit_calculator_form_save');
                $('#calc-forma').ajaxSubmit({
                    forceSync: true,
                    dataType: 'json',
                    data:{
                        action: 'calculator'
                    },
                    beforeSend: function () {
                        init.btnStartProgress(btn);
                        $('.help-block').remove();
                    },
                    success: function (data) {
                        if(data.error){
                            $('#calculator').html(data.view);
                        }
                        else{
                            $('body').append(data.view);
                            $('#modal-dialog').modal('show');
                            $('#modal-dialog').on('hidden.bs.modal', function(){
                                $('.ajax-modal').remove();
                            });
                        }
                    },
                    complete: function () {
                        init.jqueryDatepicker('.datepicker');
                        init.btnStopProgress(btn);
                        setTimeout(function(){
                          $('.help-block').fadeOut(500, function(){
                            $('.help-block').remove();
                          });
                        },3000);
                    },
                    error: function (data) {
                        //console.log(data);
                    }
                });
            });

        },

        btnStartProgress: function(btn){
            btn.button('loading');
            btn.addClass('btn-progress');
        },

        btnStopProgress: function(btn){
            btn.button('reset');
            btn.removeClass('btn-progress');

        },

        preloader: function() {
            $('#preloader').toggleClass('hide', 100);
        },

        documentReady: function(){

            document.ondragstart = noselect;
            // запрет на перетаскивание
            document.onselectstart = noselect;
            // запрет на выделение элементов страницы
            document.oncontextmenu = noselect;
            // запрет на выведение контекстного меню
            function noselect() {return false;}

            $('body').on('click', '.prevent-default', function(e){
                e.preventDefault();
            });

            $('body').on('click', '#btn-print', function(){

                var btn = $(this);

                init.btnStartProgress(btn);

                setTimeout(function(){
                    init.btnStopProgress(btn);
                },1000);

                $('#credit-table-print').printThis({
                    loadCSS: '/bundles/mfo/css/print.css'
                });

            });

            /**
             * show modal content
             */
            $('body').on('click', '.show-modal-content', function(){
                var id = $(this).data('id'),
                    action = $(this).data('action');
                $.ajax({
                    cache:false,
                    dataType: 'json',
                    method: 'post',
                    url: '/fond-bodia/ajax',
                    data: {
                        nid: id,
                        action: action
                    },
                    beforeSend: function() {
                        init.preloader();
                    },
                    success: function(data) {
                        $('body').append(data.view);
                        $('#modal-dialog').modal('show');
                        $('#modal-dialog').on('hidden.bs.modal', function(){
                            $('.ajax-modal').remove();
                        });
                       
                    },
                    complete: function() {
                        init.preloader();
                    }
                });
            });
            /**
             * end
             */

            $('body').on('click', '.nav li:not(.active) a', function(){

                $(this).closest('li').siblings('.active').removeClass('active');
                $(this).closest('li').addClass('active');

                var id = $(this).attr('href'),
                    ht = $(id).height();

                $(window).scrollTo('body',800);
                $('.row-section').stop(true,true).animate({'top':ht}, 500);

                $(id).effect('blind', {
                    mode: 'hide',
                    direction: 'down'
                }, 500, function(){
                    var section = $(id).remove();

                    $('article').prepend(section);
                    $('.row-section').css('top',0);
                    $(id).effect('drop',{
                        mode: 'show',
                        direction: 'up'
                    }, 500, function(){
                        init.jqueryDatepicker('.datepicker');
                    });

                });

            });
            
            

            /**
             * map address
             */

            ymaps.ready(map);

            var myMap, myPlacemark;

            function map(){

                myMap = new ymaps.Map("map", {
                    center: [57.19436337922077,53.171938388671855],
                    zoom: 13,
                    controls: [
                        'typeSelector', // переключатель отображаемого типа карты
                        'zoomControl' // ползунок масштаба
                    ]
                });
                
                myMap.behaviors.disable('scrollZoom'); 

                var mfo = $('#slogan').text();

                $('.item-address').each(function(){

                    var address = $(this).data('address'),
                        desc  = $(this).html();

                    var myGeocoder = ymaps.geocode(address);

                    myGeocoder.then(
                        function (res) {

                            var coordinates = res.geoObjects.get(0).geometry.getCoordinates();

                             myPlacemark = new ymaps.Placemark(coordinates, {
                                hintContent: mfo + '<br>' + address,
                                balloonContent: desc
                             }, {
                                 // Опции.
                                 // Необходимо указать данный тип макета.
                                 iconLayout: 'default#image',
                                 // Своё изображение иконки метки.
                                 iconImageHref: '/fond-bodia/bundles/mfo/image/marker-map.png',
                                 // Размеры метки.
                                 iconImageSize: [115, 54],
                                 // Смещение левого верхнего угла иконки относительно
                                 // её "ножки" (точки привязки).
                                 iconImageOffset: [-60, -75]
                             });

                             myMap.geoObjects.add(myPlacemark);
                        },
                        function (err) {
                            // обработка ошибки
                        }
                    );
                });


                $('body').on('click', '.item-address', function(){
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var address = $(this).data('address');
                    var myGeocoder = ymaps.geocode(address);

                    myGeocoder.then(
                        function (res) {

                            var coordinates = res.geoObjects.get(0).geometry.getCoordinates();

                            myMap.setCenter(coordinates,18);
                        },
                        function (err) {
                            // обработка ошибки
                        }
                    );
                });



            }
            
          //pager
          $('body').on('click', '.link-page', function(){
            var el     = $(this),
                page   = el.data('page'),
                action = el.data('action');
                
                var news = parseInt($('#news').position().top) - parseInt($('header').outerHeight());
                $(window).scrollTo(news,300, function(){
                $.ajax({
                    cache:false,
                    dataType: 'json',
                    method: 'post',
                    url: '/fond-bodia/ajax',
                    data: {
                        page: page,
                        action: action
                    },
                    beforeSend: function() {
                        
                    },
                    success: function(data) {
                        $('.news-load').html(data.view);
                        el.parent('li').siblings().removeClass('active');
                        el.parent('li').addClass('active');                        
                    },
                    complete: function() {
                        
                    }
                });
                });
                
                
                
          });
          
        }
    }

    init.application(); // инициализация




});