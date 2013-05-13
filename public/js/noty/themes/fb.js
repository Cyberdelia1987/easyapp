;(function($) {

	$.noty.themes.defaultTheme = {
		name: 'fbTheme',
		helpers: {
			borderFix: function() {}
		},
		modal: {
			css: {
				position: 'fixed',
				width: '100%',
				height: '100%',
				backgroundColor: '#000',
				zIndex: 10000,
				opacity: 0.6,
				display: 'none',
				left: 0,
				top: 0
			}
		},
		style: function() {

			this.$bar.css({
				overflow: 'hidden'
			});

			this.$message.css({
				fontSize: '11px',
				textAlign: 'center',
				padding: '15px',
				width: 'auto',
				position: 'relative'
			});

			this.$closeButton.css({
				position: 'absolute',
				top: 4, right: 4,
				width: 10, height: 10,
				display: 'none',
				cursor: 'pointer'
			});

			this.$buttons.css({
				padding: 5,
				textAlign: 'right',
				borderTop: '1px solid #ccc',
				backgroundColor: '#fff'
			});

			this.$buttons.find('button').css({
				marginLeft: 5
			});

			this.$buttons.find('button:first').css({
				marginLeft: 0
			});

			this.$bar.bind({
				mouseenter: function() { $(this).find('.noty_close').fadeIn(); },
				mouseleave: function() { $(this).find('.noty_close').fadeOut(); }
			});

			switch (this.options.layout.name) {
				case 'top':
					this.$bar.css({
						borderBottom: '2px solid #eee',
						borderLeft: '2px solid #eee',
						borderRight: '2px solid #eee',
						boxShadow: "0 2px 4px rgba(0, 0, 0, 0.1)"
					});
					break;
				case 'topCenter': case 'center': case 'bottomCenter': case 'inline':
				this.$bar.css({
					border: '1px solid #eee',
					boxShadow: "0 2px 4px rgba(0, 0, 0, 0.1)"
				});
				this.$message.css({textAlign: 'center'});
				break;
				case 'topLeft': case 'topRight':
				case 'bottomLeft': case 'bottomRight':
				case 'centerLeft': case 'centerRight':
				this.$bar.css({
					border: '1px solid #eee',
					boxShadow: "0 2px 4px rgba(0, 0, 0, 0.1)"
				});
				this.$message.css({textAlign: 'left'});
				break;
				case 'bottom':
					this.$bar.css({
						borderTop: '2px solid #eee',
						borderLeft: '2px solid #eee',
						borderRight: '2px solid #eee',
						boxShadow: "0 -2px 4px rgba(0, 0, 0, 0.1)"
					});
					break;
				default:
					this.$bar.css({
						border: '2px solid #eee',
						boxShadow: "0 2px 4px rgba(0, 0, 0, 0.1)"
					});
					break;
			}

			switch (this.options.type) {
				case 'alert': case 'notification':
				this.$bar.css({backgroundColor: '#FFF', borderColor: '#CCC', color: '#444'}); break;
				case 'warning':
					this.$bar.css({backgroundColor: '#F7F7F7', borderColor: '#CCC', color: '#333'});
					this.$buttons.css({borderTop: '1px solid #FFC237'}); break;
				case 'error':
					this.$bar.css({backgroundColor: '#FFEBE8', borderColor: '#DD3C10', color: '#333'});
					this.$message.css({fontWeight: 'bold'});
					this.$buttons.css({borderTop: '1px solid darkred'}); break;
				case 'information':
					this.$bar.css({backgroundColor: '#3b5998', borderColor: '#2C4479', color: '#FFF'});
					this.$buttons.css({borderTop: '1px solid #0B90C4'}); break;
				case 'success':
					this.$bar.css({backgroundColor: '#A7DBA7', borderColor: '#8AB88A', color: 'darkgreen'});
					this.$buttons.css({borderTop: '1px solid #50C24E'});break;
				default:
					this.$bar.css({backgroundColor: '#FFF', borderColor: '#CCC', color: '#444'}); break;
			}
		},
		callback: {
			onShow: function() { $.noty.themes.defaultTheme.helpers.borderFix.apply(this); },
			onClose: function() { $.noty.themes.defaultTheme.helpers.borderFix.apply(this); }
		}
	};

})(jQuery);