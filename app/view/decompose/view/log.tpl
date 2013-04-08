{assign var="xaxis" value=$list->getXAxis()}
{foreach from=$list item="one"}
	<b>{$one->getCaption()}</b><br/>
	{foreach from=$one->getLineParts() item="two"}
		<span {if $two.selected}class="selected"{/if}>Значение: {$two.value}; Среднее значение: {$two.average}; Количество точек: {$two.count}; Начало участка: {$xaxis[$two.start]}; Конец участка: {$xaxis[$two.end]};</span><br/>
	{/foreach}
	<br/>
{/foreach}