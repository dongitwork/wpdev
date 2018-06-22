jQuery(document).ready(function($) {
    /****************** SA MENU & SEARCH ********************/
    $("#main-menu").flmenu();
    $('.menu_top_right .sa_btn_search').click(function(event) {
        if ($(this).hasClass('exs')) {
            $(this).removeClass('exs');
            $(this).next().slideUp();
        } else {
            $(this).addClass('exs');
            $(this).next().slideDown();
        }
        return false;
    });

    /****************** SA Testimonials ********************/
    $('.sa_tt_carousel').owlCarousel({
        items: 3,
        margin: 70,
        loop: true,
        dots: true,
        responsive: {
            0: {
                margin: 0,
                items: 1,
                dots: false,
            },
            768: {
                items: 2,
                margin: 30,
            },
            992: {
                items: 3,
                margin: 50,
            },
            1200: {
                margin: 70,
            }
        }
    });

    /****************** SA PRODUCT CAROUSEL ********************/
    $('.sa-cr_carousel').owlCarousel({
        items: 2,
        margin: 0,
        loop: true,
        nav: true,
        navText: ['<i class="fa fa-long-arrow-left" ></i>', '<i class="fa fa-long-arrow-right" ></i>'],
        dots: false,
        responsive: {
            0: {
                items: 1,
            },
            640: {
                items: 2,
            },
        }
    });


    /****************** SA FULLWIDTH PRODUCT SLIDER ********************/
    $('.sa_sfw_product').owlCarousel({
        items: 1,
        margin: 0,
        loop: true,
        autoplay: true,
        autoplayTimeout: 7000,
        lazyContent: true,
        mouseDrag: false,
        touchDrag: false,
        dots: true,
        animateOut: 'fadeOut',
        responsive: {
            0: {
                dots: true,
            },
            768: {
                dots: true,
            },
        }
    });


    /**************** SA PLAY ******************/
    $(".sa-play").colorbox({ iframe: true, innerWidth: 640, innerHeight: 390 });

    /**************** SA IMAGES MAPS ******************/
    $('.sa-image_maps .sa-map_iterm .sa-tt_icon').click(function(event) {
        //alert($(this).position().right);
        if ($(this).hasClass('open')) {
            $(this).html('+');
            $(this).removeClass('open');
            $(this).parents('.sa-map_iterm_wp').find('.sa_tooltip').removeClass('active');
        } else {
            $('.sa-image_maps .sa-map_iterm .sa-tt_icon').html('+');
            $('.sa-image_maps .sa-map_iterm .sa-tt_icon').removeClass('open');
            $('.sa-image_maps .sa-map_iterm_wp .sa_tooltip').removeClass('active');

            $(this).html('-');
            $(this).addClass('open');
            $(this).parents('.sa-map_iterm_wp').find('.sa_tooltip').addClass('active');
        }
        return false;
    });

});


/*
 * SA AJAX filter Product
 */
jQuery(function($) {
    /**************** SA PRICE **************/
    $("#sa-range").slider({
        range: true,
        min: 0,
        max: $(".sa_price #sa-range").data('max_price'),
        values: [$("#sa_min_price").val(), $("#sa_max_price").val()],
        slide: function(event, ui) {
            $("#sa_min_price").val(ui.values[0]);
            $("#sa_max_price").val(ui.values[1]);
        },
        stop: function(event, ui) {
            if ($('.sa_shop_url').length > 0) {
                var surl = $('.sa_shop_url').attr('surl');
                var href = new Url(surl);
            }else{
                var href =  new Url;
            }
            href.query.min_price = $("#sa_min_price").val();
            href.query.max_price = $("#sa_max_price").val();
            //window.location.href = href;
            SaProductAjaxProcess(href);
        }
    });
    /**************** SA Viewing **************/
    $('.woocommerce-viewing').off('change', 'select.count').on('change', 'select.count', function(e) {
        e.preventDefault();
        if ($('.sa_shop_url').length > 0) {
            var surl = $('.sa_shop_url').attr('surl');
            var href = new Url(surl);
        }else{
            var href =  new Url;
        }
        href.query.count = $(this).val();
        //window.location.href = href;
        SaProductAjaxProcess(href);

    });

    /**************** SA Procat **************/
    $('.sa-procat').off('change', 'select.procat').on('change', 'select.procat', function(e) {
        e.preventDefault();
        if ($('.sa_shop_url').length > 0) {
           var surl = $('.sa_shop_url').attr('surl');
            var href = new Url(surl);
        }else{
            var href =  new Url;
        }
        href.query.procat = $(this).val();
        //window.location.href = href;
        SaProductAjaxProcess(href);

    });


    /**************** SA ORDER BY **************/
    $('.sa-ordering').off('change', 'select.sa-orderby').on('change', 'select.sa-orderby', function(e) {
        e.preventDefault();
        if ($('.sa_shop_url').length > 0) {
            var surl = $('.sa_shop_url').attr('surl');
            var href = new Url(surl);
        }else{
            var href =  new Url;
        }
        href.query.orderby = $(this).val();
        //window.location.href = href;
        SaProductAjaxProcess(href);

    });


    /*********** SA FILTER COLOR *********/
    $('.sa-swatch-color').click(function(event) {
        if ($('.sa_shop_url').length > 0) {
            var surl = $('.sa_shop_url').attr('surl');
            var href = new Url(surl);
        }else{
            var href =  new Url;
        }
        
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            $('.sa-swatch-color.selected').removeClass('selected');
            $(this).addClass('selected');
        }
        if ($('.sa-swatch-color.selected').length > 0) {
            // var sa_color = [];
            // $('.sa-swatch-color').each(function(index, el) {
            //     if ($(this).hasClass('selected')) {
            //         sa_color.push($(this).data('value'));
            //     }
            // });

            href.query.filter_color = $(this).data('value');

        } else {
            href = RemoveParameterFromUrl(href, 'filter_color');
        }
        SaProductAjaxProcess(href);
    });

    var SaProductAjaxProcess = function(href) {
        $('.sa_ajax_loadding').show();
        var shop_container = '.sa_products';
        $.ajax({
            url: href,
            success: function(response) {
                $(shop_container).html($(response).find(shop_container));
                $('.sa_ajax_loadding').hide();
                if ($('.sa_shop_url').length>0) {
                    $('.sa_shop_url').attr('surl',href);
                }
                window.history.pushState({ "pageTitle": response.pageTitle }, "", href);
                $(document).trigger("ready");

            }
        });
    };

    $(document).ajaxComplete(function() {
        sa_qty_change();
        $('.variations_form').tawcvs_variation_swatches_form();
    });

    function RemoveParameterFromUrl(url, parameter) {
        return url
            .toString().replace(new RegExp('[?&]' + parameter + '=[^&#]*(#.*)?$'), '$1')
            .toString().replace(new RegExp('([?&])' + parameter + '=[^&]*&'), '$1');
    }

    /**************** SA Qty ******************/
    function sa_qty_change() {
        $('.sa-qty .qty-arrows').click(function(event) {
            var qty_el = $(this).parents('.sa-qty_ginput').find('.qty');
            var qty = qty_el.val();
            if ($(this).hasClass('qty-up')) {
                qty_el.attr('value', parseInt(qty) + 1);
            } else {
                if (qty > 0) {
                    qty_el.attr('value', parseInt(qty) - 1);
                }
            }
            return false;
        });
    }
    sa_qty_change();
});




(function($) {

    /************* SA Share ***********/
    /**
     * jQuery function to prevent default anchor event and take the href * and the title to make a share popup
     * @param  {[object]} e           [Mouse event]
     * @param  {[integer]} intWidth   [Popup width defalut 500]
     * @param  {[integer]} intHeight  [Popup height defalut 400]
     * @param  {[boolean]} blnResize  [Is popup resizeabel default true]
     */
    $.fn.sa_share_post = function(e, intWidth, intHeight, blnResize) {
        e.preventDefault();
        intWidth = intWidth || '500';
        intHeight = intHeight || '400';
        strResize = (blnResize ? 'yes' : 'no');
        var strTitle = ((typeof this.attr('title') !== 'undefined') ? this.attr('title') : 'Social Share'),
            strParam = 'width=' + intWidth + ',height=' + intHeight + ',resizable=' + strResize,
            objWindow = window.open(this.attr('href'), strTitle, strParam).focus();
    }

    $(document).ready(function($) {
        $('.sa_social_list a').on("click", function(e) {
            $(this).sa_share_post(e);
        });
    });
}(jQuery));