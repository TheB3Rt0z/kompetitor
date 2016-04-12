jQuery.noConflict();

var delay = 125;

jQuery(function() {
	
	jQuery('header .button.nav').bind('click', function() {
		jQuery(this).hide(delay);
		jQuery('header nav').show(delay);
	});
	
	jQuery('header nav').bind('mouseleave', function() {
		if (jQuery(window).width() < 768) {
			jQuery(this).hide(delay);
			jQuery('header .button.nav').show(delay);
		}
	});
});