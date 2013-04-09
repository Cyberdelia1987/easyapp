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
/*
	// initialize with default options
	$( "#my-widget1" ).colorize();

	// initialize with two customized options
	$( "#my-widget2" ).colorize({
		red: 60,
		blue: 60
	});

	// initialize with custom green value
	// and a random callback to allow only colors with enough green
	$( "#my-widget3" ).colorize( {
		green: 128,
		random: function( event, ui ) {
			return ui.green > 128;
		}
	});

	// click to toggle enabled/disabled
	$( "#disable" ).click(function() {
		// use the custom selector created for each widget to find all instances
		// all instances are toggled together, so we can check the state from the first
		if ( $( ":custom-colorize" ).colorize( "option", "disabled" ) ) {
			$( ":custom-colorize" ).colorize( "enable" );
		} else {
			$( ":custom-colorize" ).colorize( "disable" );
		}
	});

	// click to set options after initalization
	$( "#black" ).click( function() {
		$( ":custom-colorize" ).colorize( "option", {
			red: 0,
			green: 0,
			blue: 0
		});
	});*/
});