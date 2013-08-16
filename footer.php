<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package headintobootstrap
 */
?>

	</div><!-- #main -->

</div><!-- #page -->

<?php wp_footer(); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.8.4/jquery.lazyload.min.js"></script>
<script>
jQuery(document).ready(function($) {
	$("img.his-youtube-thumb").lazyload({
		effect : "fadeIn"
	});
	$('#respond').addClass('col-lg-9');
	$('#commentform').addClass('form-horizontal');
	$('#submit').addClass('btn').addClass('btn-primary');
	var stratus_links = [];
	$('a.stratus').each(function( key, value ){
		stratus_links.push(value);
	});			
	$.stratus({
		links: stratus_links.join(','),
		color: '333'
	});
});
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-5915627-7']);
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
</body>
</html>