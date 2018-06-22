jQuery(document).ready(function($) {
    $(".main-mobilenav").flmenu();
    /****************** Add Placeholder *****************/
    $('.es_widget_form  input.es_textbox_class').attr('placeholder', 'Your Email Adress...');
    $('.es_widget_form .es_button .es_textbox_button').val('SEND');

    /****************** Slider home ********************/
    $( '.mz-slider-home' ).sliderPro({
        width: '100%',
        autoplay: false,
        height: 885,
        orientation: 'vertical',
        loop: true,
        arrows: false,
        buttons: false,
        thumbnailsPosition: 'right',
        thumbnailPointer: true,
        thumbnailWidth: 355,
        thumbnailHeight: 162,
        autoplayOnHover: 'none',
        fade: true,
        breakpoints: {
            750: {
                height: 500,
                thumbnailsPosition: 'bottom',

            },
            460: {
                height: 460,
                thumbnailsPosition: 'bottom'
            }
        }
    });

    /****************** Magazine Carousel Post ********************/
    jQuery(window).load(function() {
        var  $owl_crpost =$('.mz-crs-wp').owlCarousel({
           items: 1,
           margin: 60,
           loop: true,
           autoWidth:true,
           dots: false,
           responsive : {
                0 : {
                    autoWidth:false,
                    margin: 0,
                    items: 1,
                },
                768 : {
                    autoWidth:true,
                    margin: 60,
                }
            }
        });
        $owl_crpost.trigger('refresh.owl.carousel');
    });
    /*Fix padding Home Page*/ 
    fix_home($( window ).width()); 
    $( window ).resize(function() {
      fix_home($( window ).width());
    });  
    function fix_home(width) {
        if ($('.home #main-header').length > 0) {
            var pd = (width-1080)/2;
            if (width >= 1200) {
                $('.home #main-header').css('padding-left', pd+'px');
            }else{
                $('.home #main-header').css('padding-left', '0');
            }
        }
    }
    // Read later
    $('.mz-tnrlt').click(function(){
        var id_post = $(this).attr('id');
        $this = $(this);
        $.ajax({
            type: "POST",
            dataType: "text",
            url: window.location.href+'/wp-admin/admin-ajax.php',
            data: 'id_post='+id_post + '&action=add_later_post',
            success: function(data){
                $this.css('color', '#fbc02d');
                $this.find('i').css('color', '#fbc02d');
                alert('Added read later');
            }
        });         
        return false;
    });
});


/****************** Magazine Gallery Images ********************/
jQuery(document).ready(function($) {
    var sync1 = $("#mz_bgl");
    var sync2 = $("#mz_sgl");
    var slidesPerPage = 5; 
    var syncedSecondary = true;

    sync1.owlCarousel({
        items: 1,
        slideSpeed: 2000,
        nav: false,
        autoplay: true,
        dots: false,
        loop: false,
        responsiveRefreshRate: 200,
    }).on('changed.owl.carousel', syncPosition);

    sync2.on('initialized.owl.carousel', function() {
        sync2.find(".owl-item").eq(0).addClass("current");
    }).owlCarousel({
        items: slidesPerPage,
        dots: false,
        nav: false,
        margin: 30,
        smartSpeed: 200,
        slideSpeed: 500,
       // slideBy: slidesPerPage, 
        responsiveRefreshRate: 100
    }).on('changed.owl.carousel', syncPosition2);

    function syncPosition(el) {
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - (el.item.count / 2) - .5);
        if (current < 0) { current = count; }
        if (current > count) { current = 0; }
        sync2.find(".owl-item").removeClass("current")
            .eq(current).addClass("current");
            
        var onscreen = sync2.find('.owl-item.active').length - 1;
        var start = sync2.find('.owl-item.active').first().index();
        var end = sync2.find('.owl-item.active').last().index();

        if (current > end) {
            sync2.data('owl.carousel').to(current, 100, true);
        }
        if (current < start) {
            sync2.data('owl.carousel').to(current - onscreen, 100, true);
        }
    }

    function syncPosition2(el) {
        if (syncedSecondary) {
            var number = el.item.index;
            sync1.data('owl.carousel').to(number, 100, true);
        }
    }

    sync2.on("click", ".owl-item", function(e) {
        e.preventDefault();
        var number = $(this).index();
        sync1.data('owl.carousel').to(number, 300, true);
    });

    /* colorbox */
    $(".mz-lightbox").colorbox({rel:'.mz-lightbox',maxWidth:'95%', maxHeight:'95%'});
});

/************* Magazine Blog Share ***********/
(function($) {
    /**
     * jQuery function to prevent default anchor event and take the href * and the title to make a share popup
     * @param  {[object]} e           [Mouse event]
     * @param  {[integer]} intWidth   [Popup width defalut 500]
     * @param  {[integer]} intHeight  [Popup height defalut 400]
     * @param  {[boolean]} blnResize  [Is popup resizeabel default true]
     */
    $.fn.mz_share_post = function(e, intWidth, intHeight, blnResize) {
        e.preventDefault();
        intWidth = intWidth || '500';
        intHeight = intHeight || '400';
        strResize = (blnResize ? 'yes' : 'no');
        var strTitle = ((typeof this.attr('title') !== 'undefined') ? this.attr('title') : 'Social Share'),
            strParam = 'width=' + intWidth + ',height=' + intHeight + ',resizable=' + strResize,
            objWindow = window.open(this.attr('href'), strTitle, strParam).focus();
    }

    $(document).ready(function($) {
        $('.mz_social_list a').on("click", function(e) {
            $(this).mz_share_post(e);
        });
    });
}(jQuery));