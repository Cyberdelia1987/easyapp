var can_continue = true;

/**
 * Основная обработка событий
 */
$(document).ready(function() {
	var preferencesDialog = $('#preferences-dialog');
	var linear_dialog = $('#linear-dialog');
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
				preferencesDialog.html(data.response);
				preferencesDialog.dialog({
					modal: true,
					width: 600,
					height: 450
				});
				preferencesDialog.find('[type=checkbox]').wrap('<div class="switch" data-on-label="Да" data-off-label="Нет"/>').parent().bootstrapSwitch();
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

	/**
	 *
	 */
	linear_dialog.on('click', '#send-linears', function(event) {
		event.preventDefault();
		getExcluded();
	});
});

/**
 * Получение следующего шага расчета
 */
function getNextStep()
{
	if (!can_continue) return;
	$('#manual_mode_switcher').parent().bootstrapSwitch('status') ? getNextManual() : getNextAutomatic();
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
 * Получение данных по ручному рассчету
 */
function getNextManual()
{
	var button = $('#calculate-button')
	button.ajaxRequest({
		url: '/decompose/getDividedManual/',
		onSuccess: function(data) {
			can_continue = false;

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

			tabs_container.tabs("destroy");
			switchToLastTab();

			var linears_dialog = $('#linear-dialog');
			linears_dialog.html(data.response.linears);
			linears_dialog.dialog({
				width: 600,
				height: 585
			});
			linears_dialog.find('#linear-tabs').tabs();
		}
	}).ajaxRequest('query').ajaxRequest('destroy');
}

/**
 *
 */
function getNextAutomatic()
{
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

			tabs_container.tabs("destroy");
			switchToLastTab();

			$('.main-log').append(data.response.log);

			if (!data.response.can_continue) {
				getFinalData();
			} else {
				confirmNextStep();
			}
		}
	}).ajaxRequest('query').ajaxRequest('destroy');
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
			tabs_container.tabs("destroy");
			switchToLastTab();
		}
	}).ajaxRequest('query');
}

/**
 *
 */
function getExcluded()
{
	var formData = new FormData($('#linears-form')[0]);
	var dialog = $('#linear-dialog');
	dialog.dialog('close');

	dialog.ajaxRequest({
		url: '/decompose/getExcludedManual',
		data: formData,
		onSuccess : function(data) {
			can_continue = data.response.can_continue;

			noty({
				text : data.response.message,
				type : 'success'
			});

			var html = $(data.response.html);
			$('body').append(html);
			console.log($('.tabs-list li').length);
			switchToLastTab();
			$('.main-log').append(data.response.log);

			if (!data.response.can_continue) {
				getFinalData();
			} else {
				confirmNextStep();
			}
		}
	}).ajaxRequest('query').ajaxRequest('destroy');
}

/**
 *
 */
function switchToLastTab()
{
	$('#tabs').tabs({active: $('#tabs .tabs-list li').length - 1});
}