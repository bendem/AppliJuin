jQuery(function($) {

	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();

	$('.confirm').click(function() {
		var	text;
		if($(this).attr('data-text') == undefined) {
			text = "Êtes-vous sur ?";
		} else {
			text = $(this).attr('data-text');
		}
		return confirm(text);
	});

	$('.disabled').click(function(e) {
		e.preventDefault();
		return false;
	})

});
