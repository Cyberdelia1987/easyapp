<div class="preferences-form">
	<form id="preferences-form" class="form-inline" action="/decompose/setProperties/" method="post" enctype="multipart/form-data">
		{$form_fields}
		<div class="buttons">
			<button id="save=preferences" type="submit" class="btn btn-primary" onclick="savePreferences(); return false;">Сохранить</button>
			<button id="cancel-preferences" class="btn btn-inverse cancel" onclick="$('#preferences-dialog').dialog('close'); return false;">Отменить</button>
		</div>
	</form>
</div>