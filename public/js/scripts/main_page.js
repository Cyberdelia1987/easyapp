$(document).ready(function() {
	/**
	 * Обработка удаления файла
	 */
	$('.file-list').on('click', '.btn', function(event){
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
					$('.ajax-loader').show();
					$.ajax('/removeFile/'+elem.attr('rel')).done(function(data){
						$('.ajax-loader').hide();
						if (typeof(data.result) == 'undefined') {
							noty({
								text : 'Ошибка получения данных от сервера: неверный ответ',
								type : 'error'
							});
						} else if (data.result == 'success') {
							noty({
								text : data.response.message,
								type : 'success'
							});
							$('.file-list').html(data.response.list)
						} else if (data.result == 'error' || data.result == 'global_error' || data.result == 'exception') {
							noty({
								text : data.response,
								type : 'error'
							})
						}
					});
					confirm.close();
				}
			}, {
				addClass: 'btn btn-danger',
				text: 'Отмена',
				onClick: function() { confirm.close(); }
			}]
		});
	});

	/**
	 * Обработка загрузки файла
	 */
	$('#upload-form button[type="submit"]').click(function(event){
		event.preventDefault();
		var formData = new FormData($('#upload-form')[0]);

		$('.ajax-loader').show();
		$.ajax({
			url			: '/uploadFile/',
			type		: 'POST',
			data		: formData,
			cache		: false,
			contentType	: false,
			processData	: false
		}).done(function(data){
			$('.ajax-loader').hide();
			if (typeof(data.result) == 'undefined') {
				noty({
					text : 'Ошибка получения данных от сервера: неверный ответ: <br>'+data,
					type: 'error'
				});
			} else if (data.result == 'success') {
				noty({
					text : data.response.message,
					type : 'success'
				});
				$('.file-list').html(data.response.list)
			} else if (data.result == 'error' || data.result == 'global_error') {
				noty({
					text : data.response,
					type : 'error'
				});
			} else if (data.result == 'exception') {
				noty({
					text : data.response.message,
					type : 'error'
				});
			}
		});
	});
});