jQuery(document).ready(function($) {
    $('.his-youtube-video img, .his-youtube-play svg').click(function(){
        var video_container;
        if( $(this).parent().attr('class') == 'his-youtube-video' ){
            video_container = $(this).parent();             
        } else{             
            video_container = $(this).parent().parent();                
        }
        
        video_container.html('<iframe width="640" height="360" src="http://www.youtube.com/embed/' + $(this).attr('data-guid') + '?autoplay=1" frameborder="0" allowfullscreen></iframe>');
    });
});