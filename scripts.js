jQuery.noConflict();

var delay = 125;

jQuery(function() {
	jQuery('header .button.nav').bind('click', function() {
		jQuery(this).hide(delay);
		jQuery('header nav').show(delay).css({
			position: "fixed",
			right: "1%",
			top: "0"
		});
	});
});