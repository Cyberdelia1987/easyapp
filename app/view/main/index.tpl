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
					{if $uploaded_files && sizeof($uploaded_files)}
						{foreach from=$uploaded_files item="file"}
							<li>
								<span class="file-icon icon-hdd"></span>
								<a href="/decompose/count/{$file.file_name}">
									{$file.orig_file_name}
									<span style="display: block; font-size: 70%; color: #333; ">{$file.modify_time} - {$file.size}</span>
								</a>
								<span class="add-on" rel="{$file.file_name}"><i class="icon-remove"></i></span>
							</li>
						{/foreach}
					{else}
						Вы не добавили ни одного файла для проведения рассчетов. Пожалуйста, загрузите файл со входными данными для проведения рассчетов.
					{/if}
				</ul>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="{public}js/scripts/main_page.js"></script>
{include file='main/footer.tpl'}