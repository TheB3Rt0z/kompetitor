jQuery.noConflict();


var delay = 125;


function hideMobileNav() {
	
	if (jQuery(window).width() < 768) {
		jQuery('header nav').hide(delay);
		jQuery('header .button.nav').show(delay);
	}
}

jQuery(function() {
	
	jQuery('.content.log').prependTo('html body section article > div');
	
	jQuery('header .button.nav').bind('click', function() {
		jQuery(this).hide(delay);
		jQuery('header nav').show(delay);
	});
	
	jQuery('header nav').bind('mouseleave click', function() {
		hideMobileNav();
	});
	
	jQuery('.content .header').bind('click', function() {
		var body = jQuery(this).siblings('.body');
		body.toggle(delay);
		jQuery(this).children('span').toggleClass('opened');
	});
});