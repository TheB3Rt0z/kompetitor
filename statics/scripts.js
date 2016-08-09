jQuery.noConflict();


var delay = 125,
    BOH = '???';


function decorate() {
	
	jQuery('.content .body table td input[readonly]').each(function() {
		if (jQuery(this).val() == '???')
			jQuery(this).addClass('boh');
	});
}


function hideMobileNav() {
	
	if (jQuery(window).width() <= 1024) {
		jQuery('header nav').hide(delay);
		jQuery('header .button.nav').show(delay);
	}
}


jQuery(function() {
	
	jQuery('.content.log').prependTo('html body section article > div');
	
	decorate();
	
	jQuery('header .button.nav').bind('click', function() {
		jQuery(this).hide(delay);
		jQuery('header nav').show(delay);
	});
	
	jQuery('header nav').bind('mouseleave click', function() {
		hideMobileNav();
	});
	
	jQuery('header th nav .button.settings').bind('click', function() {
		jQuery('.content.settings').show(delay);
	});
	
	jQuery('.content .header').bind('click', function() {
		jQuery(this).siblings('.body').toggle(delay);
		jQuery(this).parent().toggleClass('closed');
		var input = jQuery(this).siblings('input');
		input.val(input.val() == BOH ? 'closed' : BOH);
	});
});