jQuery(document).ready(function($) {
    $(".main-menu").flmenu();   
     
    $('.products_crs').owlCarousel({
        loop: true,
        margin: 5,
        autoplay: true,
        nav: true,
        items: 5,
        dots: false,
        slideSpeed : 1000,
        responsive: {
            0:{items: 2},520:{items: 3},768:{items: 4},1024:{items: 5}
        },
        navText: [ "<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
    });     

    $('.dns-crpost').owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        nav: true,
        items: 3,
        dots: false,
        slideSpeed : 1000,
        responsive: {
            0:{items: 1, margin: 0},
            520:{items: 2,margin: 5},
            800:{items: 3,margin: 10},
           // 1024:{items: 3}
        },
        navText: [ "<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
    });     

    $('.dns-lqpost').owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        nav: true,
        items: 2,
        dots: false,
        slideSpeed : 1000,
        responsive: {
            0: {items: 1,margin: 0},
            520: {items: 2, margin: 10,},
        },
        navText: [ "<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
    });   

    // $('.dns-cr_product').owlCarousel({
    //     loop: true,
    //     autoplay: true,
    //     nav: true,
    //     items: 4,
    //     dots: false,
    //     slideSpeed : 1000,
    //     slideTransition: '',
    //     responsive: {
    //         0: {items: 2,margin: 5},
    //         520: {items: 3},
    //         768: {items: 4,margin: 10,},
    //         1024: {items: 5}
    //     },
    //     navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
    // });

    // Back to top
    if ($('#wrap-back-to-top').length) {
        var scrollTrigger = 150,
            backToTop = function() {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#wrap-back-to-top').addClass('show');
                } else {
                    $('#wrap-back-to-top').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function() {
            backToTop();
        });
        $('#wrap-back-to-top').on('click', function(e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 1000);
        });
    }
    $('.flex-viewport a').click(function(event) {
        /* Act on the event */
        $('.woocommerce-product-gallery__trigger').click();
    });

    $('.mobile-search').click(function(event) {
        /* Act on the event */
        $('.searh_mobile').slideToggle();
        return false;
    });
    
   // new WOW().init();   
});



/************* DNS Post Share ***********/
(function($) {
    /**
     * jQuery function to prevent default anchor event and take the href * and the title to make a share popup
     * @param  {[object]} e           [Mouse event]
     * @param  {[integer]} intWidth   [Popup width defalut 500]
     * @param  {[integer]} intHeight  [Popup height defalut 400]
     * @param  {[boolean]} blnResize  [Is popup resizeabel default true]
     */
    $.fn.dns_share_post = function(e, intWidth, intHeight, blnResize) {
        e.preventDefault();
        intWidth = intWidth || '500';
        intHeight = intHeight || '400';
        strResize = (blnResize ? 'yes' : 'no');
        var strTitle = ((typeof this.attr('title') !== 'undefined') ? this.attr('title') : 'Social Share'),
            strParam = 'width=' + intWidth + ',height=' + intHeight + ',resizable=' + strResize,
            objWindow = window.open(this.attr('href'), strTitle, strParam).focus();
    }

    $(document).ready(function($) {
        $('.dns_social_list a').on("click", function(e) {
            $(this).dns_share_post(e);
        });
    });
}(jQuery));