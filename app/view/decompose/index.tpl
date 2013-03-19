{include file='main/header.tpl'}
<div class="side-margins">
	<div class="content">
		<div class="controls">
			<button class="btn btn-primary">Рассчитать</button>
			<button id="preferences-button" class="btn btn-inverse">Настройки</button>
		</div>
		<div class="tabs-container">
			<div id="tabs">
				<ul>
					<li><a href="#tabs-1">Основные данные</a></li>
				</ul>
				<div id="tabs-1">
					{$model_count_main->display()}
				</div>
			</div>
		</div>
		<fieldset>
			<legend>Лог работы</legend>
			<div class="main-log grey-block">

			</div>
		</fieldset>
	</div>
</div>

<div id="preferences-dialog" title="Настройки декомпозиции"></div>

<script type="text/javascript" src="{public}js/scripts/decompose_page.js"></script>
<script type="text/javascript">
{literal}
	$('#tabs').tabs();
{/literal}
</script>
{include file='main/footer.tpl'}