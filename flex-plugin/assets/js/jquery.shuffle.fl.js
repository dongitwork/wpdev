(function ($) {
    $(document).ready(function () {
        $('.fl-grid-masonry').each(function () {
            var $this = $(this),
                $filter = $this.parent().find('.fl-grid-filter'),
                $sizer = $this.find('.shuffle__sizer');
            $this.imagesLoaded(function () {
                $this.shuffle({
                    itemSelector: '.fl-grid-item',
                    sizer: $sizer
                });
            });
            if ($filter) {
                $filter.find('a').click(function (e) {
                    e.preventDefault();
                    // set active class
                    $filter.find('a').removeClass('active');
                    $(this).addClass('active');

                    // get group name from clicked item
                    var groupName = $(this).attr('data-group');
                    // reshuffle grid
                    $(this).parent().parent().parent().parent().find('.fl-grid-masonry').shuffle('shuffle', groupName);
                });
            }
        });
    });
})(jQuery);