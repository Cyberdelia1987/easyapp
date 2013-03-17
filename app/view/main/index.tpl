{include file='main/header.tpl'}
<div class="container">
	<h2>Этап 1: выбор или загрузка файла</h2><br/>
	<div class="row-fluid nav">
		<div class="span6 grey-block">
			<h4>Загрузка файла с исходными данными</h4>
			<p>Вы можете загрузить новый файл для анализа, либо выбрать ранее загруженный файл из списка справа.</p>
			<p>Загружаемый файл будет преобразован в необходимый формат для дальнейшей обработки.</p>
			<hr/>
			<form id="upload-form" class="form-inline" action="/decompose/upload/" method="post" enctype="multipart/form-data">
				<h4 style="text-align: center;">Выберите файл для загрузки</h4>
				<table>
					<tr>
						<td>
							<input type="file" id="upload-file" name="data_file" />
						</td>
						<td>
							<div class="controls right" style="text-align: right;">
								<button type="submit" class="btn btn-primary">Загрузить</button>
							</div>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div class="span6 grey-block">
			<h5>Ранее загруженные файлы:</h5>
			<p>Щелкните по названию файла для перехода к разложению</p>
			<hr/>
			<div class="well file-list">
				{$list_model->get()}
			</div>
		</div>
	</div>
	<script type="text/javascript" src="{public}js/scripts/main_page.js"></script>
</div>
{include file='main/footer.tpl'}