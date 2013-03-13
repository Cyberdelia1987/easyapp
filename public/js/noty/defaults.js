$(document).ready(function(){
	$.extend($.noty.defaults, {
		layout		: 'topRight',
		type		: 'information',
		animation	: $.extend($.noty.defaults.animation, {	speed: 100 }),
		timeout		: 5000
	});
});
