jQuery(document).ready(function($) {
    $('.his-youtube-video img, .play-image').click(function(){
        $(this).parent().html('<iframe width="' + $(this).width() + '" height="' + (($(this).parent().width() / 16) * 9) + '" src="http://www.youtube.com/embed/' + $(this).attr('data-guid') + '?autoplay=1" frameborder="0" allowfullscreen></iframe>');
    });
});