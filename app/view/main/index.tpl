{include file='main/header.tpl'}
	<h2>Этап 1: выбор или загрузка файла</h2><br/>
	<div class="row-fluid nav">
		<div class="span6 grey-block">
			<h5>
				<p>Вы можете загрузить новый файл для анализа, либо выбрать ранее загруженный файл из списка справа.</p>
				<p>Загружаемый файл будет преобразован в необходимый формат для дальнейшей обработки.</p>
			</h5>
			<hr/>
			<form id="upload-form" class="form-inline" action="/decompose/upload/" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<td>
							<label for="upload-file" style="margin-right: 10px;">Выберите файл для загрузки</label>
							<input type="file" id="upload-file" name="data_file" />
						</td>
						<td>
							<div class="controls right" style="text-align: right; margin-top: 25px;">
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
			<div class="well file-list">
				{$list_model->get()}
			</div>
		</div>
	</div>
	<script type="text/javascript" src="{public}js/scripts/main_page.js"></script>
{include file='main/footer.tpl'}