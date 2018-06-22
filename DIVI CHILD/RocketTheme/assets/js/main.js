jQuery(document).ready(function($) {

    /********************* Module Tabs *******************/
    $('.rocket_wp_tabs .data_tab_title').on('click', '.tab_title', function(event) {
        event.preventDefault();
        if (!$(this).hasClass('active')) {
            $(this).parents('.rocket_wp_tabs').find('.tab_title').removeClass('active');
            $(this).addClass('active');
            $(this).parents('.rocket_wp_tabs').find('.data_tab_content').find('.active').removeClass('active');
            $(this).parents('.rocket_wp_tabs').find('#' + $(this).data('tab')).addClass('active');
        }
        if ($(window).width() < 767) {
            $('html, body').animate({
                scrollTop: $('#' + $(this).data('tab')).offset().top
            }, 1000);
        }
    });
    /********************* END Module Tabs *******************/

    /********************* Module Testimonial *******************/
    if ($('.testimonial_wp .tt_carouasel').length > 0) {
        $('.testimonial_wp .tt_carouasel').addClass('owl-carousel owl-theme');
        $('.testimonial_wp .tt_carouasel').owlCarousel({
            loop: true,
            margin: 30,
            items: 1,
            nav: false,
            dots:true,
            dotsContainer: '#custom-dots',
            responsive: {
                0: {
                    items: 1,
                },
                1000: {
                    items: 1,
                    autoWidth:true,
                },
            },
        });
    }
    /********************* END Module Testimonial *******************/

    /********************* Module What's new *******************/
    if ($('.what_new_wp .what_new_carouasel').length > 0) {
        $('.what_new_wp .what_new_carouasel').addClass('owl-carousel owl-theme');
        $('.what_new_wp .what_new_carouasel').owlCarousel({
            loop: true,
            margin: 30,
            items: 4,
            center: true,
            dots: false,
            //autoplay: true,
            navText: ['<i class="fa fa-angle-left" ></i>', '<i class="fa fa-angle-right" ></i>'],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: true,
                    autoWidth:true,
                },
                1024: {
                    items: 4,
                    nav: true,
                    autoWidth:true,
                },
            }
        });
    }
    /********************* END Module What's new *******************/

    // Module portfolio_wp
    if ($('.portfolio_wp .portfolio_carouasel').length > 0) {
        $('.portfolio_wp .portfolio_carouasel').addClass('owl-carousel owl-theme');
        $('.portfolio_wp .portfolio_carouasel').owlCarousel({
            loop: true,
            margin: 0,
            items: 1,
            nav: true,
            dots: false,
            autoplay: true,
            navText: ['<i class="fa fa-long-arrow-left" ></i>', '<i class="fa fa-long-arrow-right" ></i>'],

        });
    }

    /********************* Module Project *******************/

    if ($('.rkt_tpc_carousel .rkt_project_carousel').length > 0) {
        $('.rkt_tpc_carousel .rkt_project_carousel').addClass('owl-carousel owl-theme');
        $('.rkt_tpc_carousel .rkt_project_carousel').owlCarousel({
            loop: true,
            margin: 0,
            items: 1,
            nav: true,
            dots: false,
            autoplay: false,
            navText: ['<i class="fa fa-long-arrow-left" ></i>', '<i class="fa fa-long-arrow-right" ></i>'],
        });
    }

    $('.et_pb_rkt_project_iterm .rkt-prt-header .rkt-prt-tabs').on('click', '.rkt_tbs_tab', function(event) {
        event.preventDefault();
        /* Act on the event */
        var tbs_content = $(this).data('tbs_content'),
            tbs_carousel = $(this).data('tbs_carousel');

        if (!$(this).hasClass('active')) {
            $(this).parents('.et_pb_rkt_project_iterm').find('.active').removeClass('active');
            $(this).addClass('active');
            $(this).parents('.et_pb_rkt_project_iterm').find('#'+tbs_content).addClass('active');
            $(this).parents('.et_pb_rkt_project_iterm').find('#'+tbs_carousel).addClass('active');
        }
        return false;
    });
    $('#main-footer').after($('#rkt_project_popup_wp'));
    $('.rkt-projects .rkt-projects-tabs .btn-showpr').click(function(event) {
        var pitem = $('.rkt-projects .rkt_tpc_carousel.active .active .rkt_prc-iterm').data('pitem');
        var termid = $('.et_pb_rkt_project_iterm .rkt-prt-header .rkt-prt-tabs li a.active').data('termid');
         $('.rkt_ajax_loadding').show();
         $.ajax({
                url: rkt_js.ajaxurl, 
                data: {
                    'action': 'project_iterm',
                    'pid' : pitem,
                    'termid' : termid
                },
                success:function(html) {
                    $('#rkt_project_popup_wp .rkt-pp_content').html(html);
                    $('#rkt_project_popup_wp').show();
                },
                complete: function(){
                    $('.rkt_ajax_loadding').hide();
                }
        }); 
        return false;
    });
    $('#rkt_project_popup_wp').on('click', '.rkt-pp_close', function(event) {
        event.preventDefault();
        $('#rkt_project_popup_wp').hide();
        $('#rkt_project_popup_wp .rkt-pp_content').html('');
        return false;
    });

    $( document ).ajaxComplete(function() {
        if ($( "#rkt_project_popup_wp .project_carouasel" ).length>0 ) {
            $( "#rkt_project_popup_wp .project_carouasel" ).owlCarousel({
                margin: 0,
                items: 1,
                nav: true,
                navContainer: '#pps_nav',
                dots: false,
                autoplay: false,
                onInitialized  : prs_counter, 
                onTranslated : prs_counter,
                navText: ['<i class="fa fa-long-arrow-left" ></i>',
                            '<i class="fa fa-long-arrow-right" ></i>'],
            });
        }
        function prs_counter(event) {
           var element   = event.target;         
            var items     = event.item.count;     
            var item      = event.item.index + 1;     
          $('#pps_counter').html(item+"/"+items)
        }
        /* Popup Again */
         $('#rkt_project_popup_wp .nfpost').click(function(event) {
            var pitem = $(this).data('pitem');
            var termid = $(this).data('termid');
            $('.rkt_ajax_loadding').show();
             $.ajax({
                    url: rkt_js.ajaxurl, 
                    data: {
                        'action': 'project_iterm',
                        'pid' : pitem,
                        'termid' : termid
                    },
                    success:function(html) {
                        $('#rkt_project_popup_wp .rkt-pp_content').html(html);
                        $('#rkt_project_popup_wp').show();
                    },
                    complete: function(){
                        $('.rkt_ajax_loadding').hide();
                    },
            }); 
            return false;
        });
    });

    /********************* End Module Project *******************/


    /********************* Module Partners *********************/
    if ($('.rkt_partners_slider').length > 0) {
        $('.rkt_partners_slider').addClass('owl-carousel owl-theme');
        $('.rkt_partners_slider').owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            margin: 0,
            items: 5,
            nav: false,
            dots: false,
            navText: ['<i class="fa fa-long-arrow-left" ></i>', '<i class="fa fa-long-arrow-right" ></i>'],
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1024: {
                    items: 5
                },
            }

        });
    }
    /********************* END Module Partners *********************/

    /****************** Colorbox Play Video Youtube *****************/
    $('.rkt-whatvideo').colorbox({iframe:true, innerWidth:'80%', innerHeight:'80%'});

    /****************** Add placeholder *****************/
    $('.es_widget_form  input.es_textbox_class').attr('placeholder', 'Enter your email address...');

});