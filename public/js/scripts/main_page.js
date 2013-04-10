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
				addClass: 'btn btn-primary',
				text: 'Да',
				onClick: function() {
					var list = $('.file-list');
					list.ajaxRequest({
						url: '/removeFile/'+elem.attr('rel'),
						onSuccess : function(data) {
							noty({text : data.response.message, type : 'success'});
							$('.file-list').html(data.response.list);
						}
					});
					list.ajaxRequest('query');
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
		var uploadForm = $('#upload-form');
		var formData = new FormData(uploadForm[0]);

		uploadForm.ajaxRequest({
			url: '/uploadFile/',
			data: formData,
			onSuccess		: function(data) {
				noty({text : data.response.message, type : 'success'});
				$('.file-list').html(data.response.list);
			},
			onError			: function(data) { noty({text : data.response.message, type : 'error'}); },
			onGlobalError	: function(data) { noty({text : data.response.message, type : 'error'}); },
			onException		: function(data) { noty({text : data.response.message, type : 'error'}); }
		});
		uploadForm.ajaxRequest('query');
	});
});