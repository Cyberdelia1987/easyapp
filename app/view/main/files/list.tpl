<ul class="nav nav-list">
	{if $uploaded_files && sizeof($uploaded_files)}
		{foreach from=$uploaded_files item="file"}
			<li>
				<span class="ui-icon ui-icon- ui-icon-document"></span>
				<a href="/decompose/{$file.file_name}">
					{$file.orig_file_name}
					<span style="display: block; font-size: 70%; color: #333; ">{$file.modify_time} - {$file.size}</span>
				</a>
				<div class="remove-btn"><span class="btn btn-danger" rel="{$file.file_name}"><i class="ui-icon ui-icon-close"></i></span></div>
			</li>
		{/foreach}
	{else}
		Вы не добавили ни одного файла для проведения рассчетов. Пожалуйста, загрузите файл со входными данными для проведения рассчетов.
	{/if}
</ul>