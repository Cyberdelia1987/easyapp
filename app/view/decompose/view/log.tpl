{assign var="xaxis" value=$list->getXAxis()}
{foreach from=$list item="one"}
	<b>{$one->getCaption()}</b><br/>
	{foreach from=$one->getLineParts() item="two"}
		Значение: {$two.value}; Среднее значение: {$two.average}; Количество точек: {$two.count}; Начало участка: {$xaxis[$two.start]}; Конец участка: {$xaxis[$two.end]};<br/>
	{/foreach}
	<br/>
{/foreach}