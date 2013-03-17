<div class="row-fluid">
	<div class="span8 grey-block">
		<div id="chart-display-main"></div>
	</div>
	<div class="span4 grey-block table-data">
		<h3>Данные таблицы</h3>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="xAxis">{$series_list->getXAxis()->getCaption()}</th>
					{foreach from=$series_list item="serie"}
						<th>{$serie->getCaption()}</th>
					{/foreach}
				</tr>
			</thead>
			<tbody>
				{foreach from=$series_list->getXAxis() item="xAxisValue" key="key"}
					<tr>
						<td class="xAxis">{$xAxisValue}</td>
						{foreach from=$series_list item="serie"}
							<td>{$serie.$key}</td>
						{/foreach}
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	var chart_data = {$chart_data};

	{literal}
	{/literal}
</script>