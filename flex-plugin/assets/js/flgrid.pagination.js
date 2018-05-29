jQuery(document).ready(function ($) {
    "use strict";
    $('.fl-grid-wraper').each(function () {
        var $this = $(this);
        var $id = $(this).attr('id');
        $this.find('a.page-numbers').live('click', function () {
            $this.css('opacity', 0.3);
            var $link = $(this).attr('href');
            jQuery.get($link, function (data) {
                $this.html($(data).find('#' + $id).html());
                $this.css('opacity', 1);
            });
            return false;
        });
    })
});