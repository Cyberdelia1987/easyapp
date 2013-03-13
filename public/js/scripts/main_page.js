$(document).ready(function(){
	//
	$('.file-list .add-on').click(function(event){
		event.stopPropagation();
		var elem = $(this);
		var confirm = noty({
			text: 'Вы действительно хотите удалить этот файл?',
			layout: 'center',
			type: 'information',
			buttons:  [{
				addClass: 'btn btn-primary',
				text: 'Да',
				onClick: function() {
					$.ajax('/removeFile/'+elem.attr('rel')).done(function(data){
						if (typeof(data.result) == 'undefined') {
							noty({
								text : 'Ошибка получения данных от сервера: неверный ответ',
								layout : 'topRight',
								type: 'error'
							});
						} else if (data.result == 'success') {
							noty({
								text : data.response,
								layout : 'topRight',
								type: 'success'
							});

							document.location.reload(true);
						} else if (data.result == 'error' || data.result == 'global_error' || data.result == 'exception') {
							noty({
								text : data.response,
								layout: 'topRight',
								type : 'error'
							})
						}
					});
				}
			}, {
				addClass: 'btn btn-danger',
				text: 'Отмена',
				onClick: function() {}
			}]
		});

		confirm.close();
	});
});
