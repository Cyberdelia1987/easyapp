{include file='main/header.tpl'}
<div class="side-margins">
	<div class="topbar-wrapper">
		<div class="topbar controls">
			<div class="topbar-inner">
				<div class="container">
				<a class="brand">Управление</a>
					<ul class="nav">
						<li class="divider-vertical"></li>
						<li><span class="btn-group">
							<button id="calculate-button" class="btn">Рассчитать</button>
						</span></li>
						<li class="divider-vertical"></li>
						<li><span class="btn-group">
							<button id="preferences-button" class="btn primary">Настройки</button>
						</span></li>
						<li class="divider-vertical"></li>
						<li>
							<form id="switch_mode_form" method="post" enctype="application/x-www-form-urlencoded" style="margin:0;">
								<span style="display: inline-block;" >
									<label for="manual_mode_switcher" style="float: left; margin-right: 10px;">Ручной режим: </label>
									<input name="manual_mode_switcher" type="hidden" value="0">
									<span style="float: left;" class="switch" id="toggle-manual" data-on-label="Да" data-off-label="Нет">
										<input id="manual_mode_switcher" name="manual_mode_switcher" type="checkbox" value="1" {if $manual_mode}checked="checked" {/if}>
									</span>
								</span>
							</form>
						</li>
						<li class="divider-vertical"></li>
						<li class="pull-right"><span class="btn-group">
							<button class="btn primary" style="float: right;" onclick="window.location.reload();">Очистить данные вычислений</button>
						</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="tabs-container">
		<div id="tabs">
			<ul class="tabs-list">
				<li class="active"><a href="#tabs-0">Основные данные</a></li>
			</ul>
			<div class="active" id="tabs-0">
				{$display_data}
			</div>
		</div>
	</div>
	<fieldset>
		<legend>Лог работы</legend>
		<div class="main-log grey-block">

		</div>
	</fieldset>
</div>

<div id="preferences-dialog" title="Настройки декомпозиции" class="modal hide fade">
</div>
<div id="linear-dialog" title="Линейные участки"></div>

<script type="text/javascript" src="{public}js/scripts/decompose_page.js"></script>
<script type="text/javascript" src="{public}js/scripts/modeswitch.js"></script>
<script type="text/javascript">
{literal}
	$(document).ready(function(){
		$('#tabs').tabs();
	});
{/literal}
</script>
{include file='main/footer.tpl'}