$(document).ready(function() {
	$('#preferences-button').click(function(){
		$.ajax('/decompose/getProperties').done(function(data){
			if (typeof(data.result) == 'undefined') {
				noty({
					text : 'Ошибка получения данных от сервера: неверный ответ',
					type : 'error'
				});
			} else if (data.result == 'success') {
				noty({
					text : 'Настройки успешно получены с сервера',
					type : 'success'
				});
				$('#preferences-dialog').html(data.response);
				$( "#preferences-dialog" ).dialog({
					modal: true,
					width: 600,
					height: 450
				});
			} else if (data.result == 'error' || data.result == 'global_error' || data.result == 'exception') {
				noty({
					text : data.response,
					type : 'error'
				})
			}
		});
	});
});

function savePreferences()
{
	var formData = new FormData($('#preferences-form')[0]);

	$.ajax({
		url			: '/decompose/setProperties/',
		type		: 'POST',
		data		: formData,
		cache		: false,
		contentType	: false,
		processData	: false
	}).done(function(data){
		if (typeof(data.result) == 'undefined') {
			noty({
				text : 'Ошибка получения данных от сервера: неверный ответ: <br>'+data,
				type: 'error'
			});
		} else if (data.result == 'success') {
			noty({
				text : data.response,
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
				text : data.response,
				type : 'error'
			});
		}
	});
}