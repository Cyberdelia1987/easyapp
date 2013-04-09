var can_continue = true;

/**
 * Основная обработка событий
 */
$(document).ready(function() {
	var preferencesDialog = $('#preferences-dialog');
	/**
	 * Загрузка настроек с сервера
	 */
	$('#preferences-button').click(function(){
		// Обработка запроса при клике на кнопку показа окна настроек
		$(this).ajaxRequest({
			url: '/preferences/get',
			onSuccess : function(data) {
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
			}
		});
		$(this).ajaxRequest('query');
	});

	/**
	 * Сохранение настроек
	 */
	preferencesDialog.on('click', '#save-preferences', function(event) {
		event.preventDefault();
		var formData = new FormData($('#preferences-form')[0]);
		$(this).ajaxRequest({
			url: '/preferences/set/',
			data: formData,
			onSuccess: function(data) {
				noty({
					text : data.response,
					type : 'success'
				});
				$('#preferences-dialog').dialog('close');
			}
		});
		$(this).ajaxRequest('query');
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
		getNextStep();
	});
});

/**
 * Получение следующего шага расчета
 */
function getNextStep()
{
	if (!can_continue) return;
	var button = $('#calculate-button');
	button.ajaxRequest({
		url: '/decompose/getNext/',
		onSuccess: function(data) {
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

			if (!data.response.can_continue) {
				getFinalData();
			} else {
				confirmNextStep();
			}
		}
	});
	button.ajaxRequest('query');
}

/**
 * Подтверждение следующего шага разложения
 */
function confirmNextStep()
{
	var confirm = noty({
		text: 'Продолжить разложение?',
		layout: 'center',
		type: 'information',
		modal: true,
		buttons:  [{
			addClass: 'btn btn-primary',
			text: 'Да',
			onClick: function() {
				getNextStep();
				confirm.close();
			}
		}, {
			addClass: 'btn btn-danger',
			text: 'Нет',
			onClick: function() {
				getFinalData();
				confirm.close();
			}
		}]
	});
}

/**
 * Рассчет и получение конечных данных
 */
function getFinalData() {
	var tabs = $('#tabs');
	tabs.ajaxRequest({
		url: '/decompose/getRevert',
		onSuccess: function(data) {
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
	});
	tabs.ajaxRequest('query');
}