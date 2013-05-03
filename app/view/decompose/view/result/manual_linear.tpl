{assign var="xaxis" value=$list->getXAxis()}

<div id="linear-tabs">
	<ul class="tabs-list">
	{foreach from=$list key="key" item="serie"}
		<li><a href="#linear-tabs-{$key}">{$serie->getCaption()}</a></li>
	{/foreach}
	</ul>
	{foreach from=$list key="key" item="serie"}
		<div id="linear-tabs-{$key}">
			{foreach from=$serie->getLineParts() key="option_key" item="line_part" name="options_loop"}
				<div class="form-field">
					<input type="radio" value="{$line_part.value}" name="serie_line[{$key}]" id="serie_line_{$key}_{$option_key}">
					<label for="serie_line_{$key}_{$option_key}">{$line_part.value|round:4} ({$line_part.average|round:4}) | {$line_part.count} [{$xaxis[$line_part.start]}] - [{$xaxis[$line_part.end]}]</label>
				</div>
				{if $option_key gt 8}{break}{/if}
			{/foreach}
			<div class="form-field">
				<input type="radio" value="{$line_part.value}" name="serie_line[{$key}]" id="serie_line_manual_{$key}">
				<label for="serie_line_manual_{$key}"><input type="text" name="serie_line_manual_value"> Задать самому</label>
			</div>
		</div>
	{/foreach}
</div>
<div class="buttons" style="margin-top: 15px">
	<button id="send-linears" type="submit" class="btn btn-primary pull-right">Далее</button>
</div>