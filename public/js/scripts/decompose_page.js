var can_continue = true;
$(document).ready(function() {
	var preferencesDialog = $('#preferences-dialog');
	/**
	 * Загрузка настроек с сервера
	 */
	$('#preferences-button').click(function(){
		$('.ajax-loader').show();
		$.ajax('/preferences/get').done(function(data){
			$('.ajax-loader').hide();
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

	/**
	 * Сохранение настроек
	 */
	preferencesDialog.on('click', '#save-preferences', function(event) {
		event.preventDefault();
		var formData = new FormData($('#preferences-form')[0]);
		$('.ajax-loader').show();
		$.ajax({
			url			: '/preferences/set/',
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
					text : data.response,
					type : 'success'
				});
				$('#preferences-dialog').dialog('close');
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
	});

	/**
	 * Обработка кнопки "Отмена"
	 */
	preferencesDialog.on('click', '#cancel-preferences', function(event) {
		event.preventDefault();
		$('#preferences-dialog').dialog('close');
	});

	/**
	 * Клик на кнопку "Рассчитать"
	 */
	$('#calculate-button').click(function(event) {
		event.preventDefault();

		if (!can_continue) return;
		$('.ajax-loader').show();
		$.ajax('/decompose/getNext/').done(function(data) {
			$('.ajax-loader').hide();
			if (typeof(data.result) == 'undefined')
			{
				noty({
					text : 'Ошибка получения данных от сервера: неверный ответ: <br>'+data,
					type: 'error'
				});
			} else if (data.result == 'success') {
				can_continue = data.response.can_continue;

				var tabs_container = $('#tabs');
				noty({
					text : data.response.message,
					type : 'success'
				});

				var html = $('<div id="tabs-'+data.response.step+'"></div>');
				html.html(data.response.html);
				tabs_container.append(html);
				var list_elem = $('<li><a href="#tabs-'+data.response.step+'">Шаг #'+data.response.step+'</a></li>');
				$('.tabs-list').append(list_elem);

				tabs_container.tabs("destroy").tabs({active: $('.tabs-list li').length - 1});

				$('.main-log').append(data.response.log);

				if (!data.response.can_continue)
				{
					getFinalData();
				}
			}
			else if (data.result == 'error' || data.result == 'global_error')
			{
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
	});
});

/**
 * Рассчет и получение конечных данных
 */
function getFinalData() {
	$('.ajax-loader').show();
	$.ajax('/decompose/getRevert').done(function(data) {
		$('.ajax-loader').hide();
		if (typeof(data.result) == 'undefined')
		{
			noty({
				text : 'Ошибка получения данных от сервера: неверный ответ: <br>'+data,
				type: 'error'
			});
		} else if (data.result == 'success') {
			can_continue = data.response.can_continue;

			var tabs_container = $('#tabs');
			noty({
				text : data.response.message,
				type : 'success'
			});

			var html = $('<div id="tabs-'+data.response.step+'"></div>');
			html.html(data.response.html);
			tabs_container.append(html);
			var list_elem = $('<li><a href="#tabs-'+data.response.step+'">Конечные рассчеты</a></li>');
			$('.tabs-list').append(list_elem);
			tabs_container.tabs("destroy").tabs({active: $('.tabs-list li').length - 1});
		}
		else if (data.result == 'error' || data.result == 'global_error')
		{
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