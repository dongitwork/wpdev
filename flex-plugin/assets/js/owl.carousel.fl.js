(function ($) {
    "use strict";
    $(document).ready(function () {
        $(".fl-carousel").each(function () {
            var $this = $(this), slide_id = $this.attr('id'), slider_settings = flcarousel[slide_id];
            $this.addClass('owl-carousel owl-theme');
            $this.owlCarousel(slider_settings);
        });
    });
    $(window).load(function(){
        $('.fl-carousel-filter a').click(function(e){
            e.preventDefault();
            var parent = $(this).closest('.fl-carousel-wrap');
            $('.fl-carousel-filter a').removeClass('active');
            var filter = $(this).data('group');
            $(this).addClass('active');
            flCarouselFilter( filter, parent );
        });
    });

    /**
     * Carousel Filter
     * @param filter category
     * @param parent
     */
    function flCarouselFilter( filter, parent ){
        if ( filter == 'all'){
            $('.fl-carousel-filter-hidden .fl-carousel-filter-item', parent).each(function(){
                var owl   = $(".fl-carousel", parent);
                var parentElem      = $(this).parent(),
                    elem = parentElem.html();
                owl.trigger('add.owl.carousel', [elem]).trigger('refresh.owl.carousel');
                parentElem.remove();
            });
        } else {
            $('.fl-carousel-filter-hidden .fl-carousel-filter-item.'+ filter, parent).each(function(){
                var owl = $(".owl-carousel", parent);
                var parentElem      = $(this).parent(),
                    elem = parentElem.html();
                owl.trigger('add.owl.carousel', [elem]).trigger('refresh.owl.carousel');
                parentElem.remove();
            });

            $('.fl-carousel .fl-carousel-filter-item:not(".'+filter+'")', parent)
                .each(function(){
                var owl   = $(".fl-carousel", parent);
                var parentElem = $(this).parent(),
                    targetPos = parentElem.index();
                $( parentElem ).clone().appendTo( $('.fl-carousel-filter-hidden', parent) );
                owl.trigger('remove.owl.carousel', [targetPos]).trigger('refresh.owl.carousel');
            });
        }
    }
})(jQuery);