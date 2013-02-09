jQuery(document).ready(function($) {
	var stratus_links = [];
	$('a.stratus').each(function( key, value ){
		stratus_links.push(value);
	});			
	$.stratus({
		links: stratus_links.join(','),
		color: '333'
	});
});