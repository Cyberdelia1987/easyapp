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
			modal: true,
			buttons:  [{
				addClass: 'btn primary',
				text: 'Да',
				onClick: function() {
					$(this).ajaxRequest({
						url: '/removeFile/'+elem.attr('rel'),
						onSuccess : function(data) {
							noty({text : data.response.message, type : 'success'});
							$('.file-list').html(data.response.list);
						}
					});
					$(this).ajaxRequest('query');
					confirm.close();
				}
			}, {
				addClass: 'btn danger',
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
		event.stopPropagation();
		var uploadForm = $('#upload-form');
		var data = new FormData(uploadForm[0]);

		$(this).ajaxRequest({
			url: '/uploadFile/',
			type: 'POST',
			data: data,
			onSuccess		: function(data) {
				noty({text : data.response.message, type : 'success'});
				$('.file-list').html(data.response.list);
			},
			onError			: function(data) { noty({text : data.response.message, type : 'error'}); },
			onGlobalError	: function(data) { noty({text : data.response.message, type : 'error'}); },
			onException		: function(data) { noty({text : data.response.message, type : 'error'}); }
		});
		$(this).ajaxRequest('query').ajaxRequest('destroy');
	});
});