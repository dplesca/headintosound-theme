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
<script>
jQuery(document).ready(function($) {
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
(function(G,o,O,g,l){G.GoogleAnalyticsObject=O;G[O]||(G[O]=function(){(G[O].q=G[O].q||[]).push(arguments)});G[O].l=+new Date;g=o.createElement('script'),l=o.scripts[0];g.src='//www.google-analytics.com/analytics.js';l.parentNode.insertBefore(g,l)}(this,document,'ga'));ga('create','UA-5915627-7');ga('send','pageview')
</script>
</body>
</html>