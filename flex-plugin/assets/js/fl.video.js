/**
 * Zo Video Shortcode
 * This shortcode to show an image thumbnail for click to play video
 * and when video pause it will hidden and show thumbnail again
 *
 * @support youtube, vimeo
 * @version 1.0
 * @author VnZacky
 * @date 11/12/2015
 */
(function($){
    "use strict";
    var videoPlayer;

    /**
     * Youtube On Ready
     * @param id
     */
    function zoYoutubeReady(id){
        videoPlayer = new YT.Player(id, {
            events: {
                'onReady': function (event) {
                    event.target.playVideo();
                },
                'onStateChange': function (event) {
                    if (event.data == YT.PlayerState.PAUSED) {
                        var parent = $(event.target.f).closest('.fl-video-play-wrapper');
                        parent.find('.video-player').removeClass('active');
                    }
                }
            }
        });
    }

    /**
     * Vimeo Ready
     */
    $('.fl-video-play-wrapper').each(function() {
        var thisEl = $(this),
            videoPlayer = thisEl.find('iframe');
        if( typeof($f) === 'function' ) {
            videoPlayer = $f($(videoPlayer)[0]);
            videoPlayer.addEvent('ready', function() {
                videoPlayer.addEvent('pause', function (id){
                    var parent = $('#'+id).closest('.fl-video-play-wrapper');
                    parent.find('.video-player').removeClass('active');
                });
            });
        }
    });
    /**
     * Show and play video when click play
     */
    $('.fl-video-play-wrapper .play-button').on('click', function(e) {
        e.preventDefault();
        var playerID = $(this).data('player'),
            type = $(this).data('type');
        var player = $(this).closest('.fl-video-play-wrapper').find('.video-player').addClass('active');
        if(type == 'youtube') {
            zoYoutubeReady(playerID);
            $('#'+playerID)[0].contentWindow.postMessage('{"event":"command","func":"playVideo"}', '*');
        } else if( type == 'vimeo' && typeof($f) === 'function' ) {
            videoPlayer = $f($('#'+playerID)[0]);
            videoPlayer.api('play');
        }
    });
}(jQuery));
