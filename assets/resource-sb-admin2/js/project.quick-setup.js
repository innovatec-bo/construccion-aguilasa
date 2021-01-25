$(document).ready(function() {
	$('[data-toggle="popover"]').popover();
	$('#save-btn').on('click', function () {
		$(this).button('loading');
	});
});
