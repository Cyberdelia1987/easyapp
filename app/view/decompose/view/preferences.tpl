<div class="preferences-form">
	<div class="modal-header">
		<a href="#" class="close">×</a>
		<h3>Настройки приложения</h3>
	</div>
	<div class="modal-body">
		<form id="preferences-form" class="form-inline" action="/decompose/setProperties/" method="post" enctype="multipart/form-data">
			{$form_fields}
		</form>
	</div>
	<div class="modal-footer">
		<button id="save-preferences" type="submit" class="btn primary">Сохранить</button>
		<button id="cancel-preferences" class="btn btn-inverse cancel">Отменить</button>
	</div>
</div>