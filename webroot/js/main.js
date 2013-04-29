jQuery(function($) {

	$('[data-toggle="tooltip"]').tooltip({
		placement : 'bottom',
		trigger : 'hover'
	});
	$('[data-toggle="popover"]').popover({
		placement : 'bottom',
		trigger : 'click'
	});

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
