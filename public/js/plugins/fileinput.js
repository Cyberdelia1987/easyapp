$(document).ready(function(){
	$('input[type="file"]').each(function() {
		var elem = $(this).addClass('file-orig-button');
		elem.wrap('<div class="file-input-wrapper" />');
		var wrapper = elem.parent();
		var fileName = $('<div class="file-name-holder"><span class="text"></span></div>').css('display', 'none').attr('id', elem.attr('id'));
		var button = $('<div class="file-button btn btn-inverse">Выберите файл</div>');
		var blocker = $('<div class="file-input-blocker" />');
		var fileIcon = $('<div/>');
		fileName.prepend(fileIcon);

		elem.change(function(){
			var file = elem.val();
			var reWin = /.*\\(.*)/;
			var fileTitle = file.replace(reWin, "$1"); //выдираем название файла
			var reUnix = /.*\/(.*)/;
			fileTitle = fileTitle.replace(reUnix, "$1"); //выдираем название файла
			fileName.find('.text').html(fileTitle);

			var RegExExt =/.*\.(.*)/;
			var ext = fileTitle.replace(RegExExt, "$1");//и его расширение

			if (ext){
				var file_icon = 'unknown';
				switch (ext.toLowerCase())
				{
					case 'doc'  : file_icon = 'doc';	break;
					case 'docx' : file_icon = 'doc';	break;
					case 'xsl'  : file_icon = 'xls';	break;
					case 'xlsx' : file_icon = 'xls';	break;
					case 'ppt'	: file_icon = 'ppt';	break;
					case 'pptx'	: file_icon = 'ppt';	break;
					case 'psd'	: file_icon = 'psd';	break;
					case 'ai'	: file_icon = 'ai';		break;
					case 'pdf'	: file_icon = 'pdf';	break;
					case 'html'	: file_icon = 'html';	break;
					case 'htm'	: file_icon = 'html';	break;
					case 'xml'	: file_icon = 'xml';	break;
					case 'txt'	: file_icon = 'txt';	break;
					case 'mp3'	: file_icon = 'music';	break;
					case 'wav'	: file_icon = 'music';	break;
					case 'ogg'	: file_icon = 'music';	break;
					case 'flac'	: file_icon = 'music';	break;
					case 'jpg'	: file_icon = 'img';	break;
					case 'jpeg'	: file_icon = 'img';	break;
					case 'gif'	: file_icon = 'img';	break;
					case 'bmp'	: file_icon = 'img';	break;
					case 'png'	: file_icon = 'png';	break;
					case 'zip'	: file_icon = 'archive';	break;
					case 'rar'	: file_icon = 'archive';	break;
					case 'tar'	: file_icon = 'archive';	break;
					case 'dat'	: file_icon = 'dat';	break;
				}
				fileName.show();
			}
			var icon_class = 'extension-icon-'+file_icon;
			fileIcon.removeClass().addClass('extension-icon '+icon_class);
		});

		wrapper.append(button);
		wrapper.append(blocker);
		wrapper.append(fileName);
		wrapper.append('<div class="clearfix"/>')
	});
});