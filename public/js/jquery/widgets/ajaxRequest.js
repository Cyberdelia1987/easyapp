$(function() {
	// the widget definition, where "custom" is the namespace,
	// "colorize" the widget name
	$.widget( 'easyapp.ajaxRequest', {
		// default options
		options: {
			url						: '',
			type					: 'GET',
			data					: null,
			beforeQuery				: function() { $('.ajax-loader').show(); },
			beforeProcessRequest	: function(data) { $('.ajax-loader').hide(); },
			onUndefined				: function(data) {
				noty({text : 'Ошибка получения данных от сервера: неверный ответ: <br>'+data,	type: 'error'});
			},
			onSuccess				: function(data) {},
			onError					: function(data) { noty({text : data.response, type : 'error'}); },
			onGlobalError			: function(data) { noty({text : data.response, type : 'error'}); },
			onException				: function(data) { noty({text : data.response, type : 'error'}); }
		},

		// the constructor
		_create: function() {
			if (typeof(this.options.data) == 'object' || typeof(this.options.data) == 'array') {
				this.options.type = 'POST';
			}
		},

		// called when created, and later when changing options
		_refresh: function() {},

		// events bound via _on are removed automatically
		// revert other modifications here
		_destroy: function() {},

		// _setOptions is called with a hash of all options that are changing
		// always refresh when changing options
		_setOptions: function() {},

		// _setOption is called for each individual option that is changing
		_setOption: function(key, value) {
			if (key == 'data') {
				if (typeof(value) == 'object' || typeof(value) == 'array') {
					this.options.type = 'POST';
				} else {
					this.options.type = 'GET';
				}
			}
			this._super( key, value );
		},

		// Отправка запроса на сервер
		query: function () {
			var widget = this;
			this.options.beforeQuery();
			$.ajax({
				url			: this.options.url,
				type		: this.options.type,
				data		: this.options.data,
				cache		: false,
				contentType	: false,
				processData	: false
			}).done(function(data){
				widget.options.beforeProcessRequest(data);
				if (typeof(data.result) == 'undefined') {
					widget.options.onUndefined(data);
				} else if (data.result == 'success') {
					widget.options.onSuccess(data);
				} else if (data.result == 'error') {
					widget.options.onError(data);
				} else if (data.result == 'global_error') {
					widget.options.onGlobalError(data);
				} else if (data.result == 'exception') {
					widget.options.onException(data);
				}
			});
		}
	});
});