{assign var="xaxis" value=$list->getXAxis()}

<form id="linears-form" action="/decompose/getExcludedManual" method="post" name="linear_parts">
<div id="linear-tabs">
	<ul class="tabs-list">
	{foreach from=$list key="key" item="serie"}
		<li><a href="#linear-tabs-{$key}">{$serie->getCaption()}</a></li>
	{/foreach}
	</ul>
	{foreach from=$list key="key" item="serie"}
		<div id="linear-tabs-{$key}">
			<div class="form-field">
				<input type="radio" value="counted" name="value_mode[{$key}]" id="value_mode_counted_{$key}" checked="checked" class="value_mode_counted">
				<label for="value_mode_counted_{$key}">Значения лин. участков, рассчитанные программно:</label>
			</div>
			<div class="counted-linear-values">
				{foreach from=$serie->getLineParts() key="option_key" item="line_part" name="options_loop"}
					<div class="form-field indented">
						<input type="radio" value="{$option_key}" name="serie_line[{$key}]" id="serie_line_{$key}_{$option_key}" {if $line_part.selected}checked="checked"{/if}>
						<label for="serie_line_{$key}_{$option_key}">{$line_part.value|round:4} ({$line_part.average|round:4}) | {$line_part.count} [{$xaxis[$line_part.start]}] - [{$xaxis[$line_part.end]}]</label>
					</div>
					{if $option_key gt 8}{break}{/if}
				{/foreach}
			</div>
			<div class="form-field">
				<input type="radio" value="manual" name="value_mode[{$key}]" id="value_mode_manual_{$key}">
				<div>
					<label for="value_mode_manual_{$key}"><input type="text" name="serie_line_manual_value[{$key}]"> Задать самому</label>
				</div>
				<div class="second_manual_value" style="margin-left: 23px; display: none;">
					<label for="value_mode_manual_{$key}"><input type="text" name="serie_line_manual_value_2[{$key}]"> Второй коэффициент</label>
				</div>
			</div>
		</div>
	{/foreach}
</div>
<div class="buttons" style="margin-top: 15px">
	<span style="display: inline-block;" >
		<label for="continue_decomposition" style="float: left; margin: 5px 20px 0 0;">Продолжать разложение: </label>
		<input name="continue_decomposition" type="hidden" value="0">
		<span style="float: left;" class="switch" id="toggle_continue" data-on-label="Да" data-off-label="Нет">
			<input id="continue_decomposition" name="continue_decomposition" type="checkbox" value="1" {if $can_continue}checked="checked"{else}disabled="disabled"{/if}>
		</span>
	</span>
	<button id="send-linears" type="submit" class="btn btn-primary pull-right">Далее</button>
</div>
</form>