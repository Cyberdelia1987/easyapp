{include file='main/header.tpl'}
	<h2>Этап 1: выбор или загрузка файла</h2><br/>
	<div class="row-fluid nav">
		<div class="span6 grey-block">
			<h5>Вы можете загрузить новый файл для анализа, либо выбрать ранее загруженный файл из списка справа</h5>
			<hr/>
			<form id="upload-form" class="form-inline" action="/decompose/upload/" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<td>
							<label for="upload-file" style="margin-right: 10px;">Выберите файл для загрузки</label>
							<input type="file" id="upload-file" name="data_file" style="width: 235px"/>
						</td>
						<td>
							<div class="controls right" style="text-align: right; margin-top: 10px;">
								<button type="submit" class="btn btn-primary">Загрузить</button>
							</div>
						</td>
					</tr>
				</table>


			</form>
		</div>
		<div class="span6 grey-block">
			<h5>Ранее загруженные файлы:</h5>
			<hr/>
			<div class="well">
				<ul class="nav nav-list file-list">
					<li><a>Файл #1<span class="add-on"><i class="icon-remove"></i></span></a></li>
					<li><a>Файл #2<span class="add-on"><i class="icon-remove"></i></span></a></li>
					<li><a>Файл #3<span class="add-on"><i class="icon-remove"></i></span></a></li>
					<li><a>Файл #4<span class="add-on"><i class="icon-remove"></i></span></a></li>
				</ul>
			</div>
		</div>
	</div>
{include file='main/footer.tpl'}