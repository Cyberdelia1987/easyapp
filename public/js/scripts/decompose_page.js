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
				preferencesDialog.modal({backdrop: true, keyboard: true, show: true});
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
				$('#preferences-dialog').modal('hide');
				$('.modal-backdrop').remove();
			}
		});
		$(this).ajaxRequest('query');
	});

	/**
	 * Обработка кнопки "Отмена"
	 */
	preferencesDialog.on('click', '#cancel-preferences', function(event) {
		event.preventDefault();
		$('#preferences-dialog').modal('hide');
		$('.modal-backdrop').remove();
	});

	/**
	 * Клик на кнопку "Рассчитать"
	 */
	$('#calculate-button').click(function(event) {
		event.preventDefault();
		getNextStep();
	});

	/**
	 * Обработчик нажатия кнопки "Далее" в диалоге выбора линейных
	 * участков для ручного режима
	 */
	linear_dialog.on('click', '#send-linears', function(event) {
		event.preventDefault();
		getExcluded();
	});

	/**
	 * Обработчик переключателя продолжения рассчетов для ручного режима
	 */
	linear_dialog.on('switch-change', '#toggle_continue', function (event, data) {
		switchContinueDecomposition(data.value);
	});

	/**
	 * Обрабочик нажатия на чекбокс при ручном режиме
	 */
	linear_dialog.on('change', '.counted-linear-values input[type="checkbox"]', function(event){
		var elem = $(this);
		var selected = elem.closest('.counted-linear-values').find('input[type="checkbox"]:checked');

		if (selected.length > 2)
		{
			var length = selected.length;
			selected.each(function() {
				var myself = $(this);
				if (myself.attr('id') != elem.attr('id') && length > 2)
				{
					myself.prop('checked', false);
					length--;
				}
			});
		}
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
			linears_dialog.find('#linear-tabs').tabs();
			linears_dialog.find('[type=checkbox]').wrap('<div class="switch" data-on-label="Да" data-off-label="Нет"/>').parent().bootstrapSwitch();
			linears_dialog.dialog({width: 500});
			switchContinueDecomposition($('#continue_decomposition').is(':checked'));
		}
	}).ajaxRequest('query').ajaxRequest('destroy');
}

/**
 * Перейти к расчету следующего шага в автоматическом режиме
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
 * Функция-обработчик нажатия кнопки "Далее" в диалоге выбора
 * линейных участков для ручного режима
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

			if (!data.response.can_continue || !$('#continue_decomposition').parent().bootstrapSwitch('status')) {
				getFinalData();
			} else {
				//confirmNextStep();
				getNextStep();
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

/**
 * Функция-обработчик переключателя продолжения
 * рассчетов для ручного режима
 * @param value	Включен/выключен переключатель
 */
function switchContinueDecomposition(value)
{
	var form = $('#linears-form');
	switch (value) {
		case true :
			form.find('.counted-linear-values input[type="checkbox"]').each(function(){
				var el = $(this);
				if (el.val() == 'manual') return;
				el.attr('type', 'radio');
				el.attr('name', el.attr('orig_name'));
			});
			$('.second_manual_value').hide();
			break;
		case false :
			form.find('.counted-linear-values input[type="radio"]').each(function(idx){
				var el = $(this);
				if (el.val() == 'manual') return;
				el.attr('type', 'checkbox');
				el.attr('orig_name', el.attr('name'));
				el.attr('name', el.attr('name')+'['+idx+']');
			});
			$('.second_manual_value').show();
			break;
	}
}