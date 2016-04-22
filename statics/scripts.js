jQuery.noConflict();


var delay = 125;


function hideMobileNav() {
	
	if (jQuery(window).width() < 768) {
		jQuery('header nav').hide(delay);
		jQuery('header .button.nav').show(delay);
	}
}


function checkBreakpoints() {
	
	//jQuery('td.breakpoint').after('</tr><tr>');
	
	/*jQuery('td.breakpoint').each(function(){
		jQuery(this).prevUntil('td').andSelf().wrapAll(jQuery('<tr></tr>'));
	});
	jQuery('td:first').after(jQuery('td:first').children());
	jQuery('td:first').remove();*/
	
	jQuery('td.breakpoint').wrapAll(jQuery('<tr></tr>'));
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
	
	jQuery('')
});