$(document).ready(function(){
	$('#toggle-manual').on('switch-change', function (e, data) {
		var el = $(data.el);
		el.ajaxRequest({
			url: '/preferences/switchMode/',
			data: new FormData($('#switch_mode_form')[0])
		});
		el.ajaxRequest('query').ajaxRequest('destroy');
	});
});