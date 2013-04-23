$(document).ready(function(){
	$('#toggle-manual').on('switch-change', function (e, data) {
		var $el = $(data.el), value = data.value;
		//console.log(e, $el, value);
	});
});