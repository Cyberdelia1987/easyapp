<div class="row-fluid">
	<div class="span-8 grey-block main-chart-wrapper">
		<div id="chart-display-main{$model->getStep()}" class="chart-block"></div>
	</div>
	<div class="span-4 grey-block table-data">
		<h4>Таблица исходных данных</h4>
		<table class="table table-bordered condensed-table zebra-striped">
			<thead>
			<tr>
				<th class="xAxis">{$series_list->getXAxis()->getCaption()}</th>
				{foreach from=$series_list item="serie"}
					<th style="text-align: center">
						{$serie->getCaption()}<br/>
					</th>
				{/foreach}
			</tr>
			</thead>
			<tbody>
			{foreach from=$series_list->getXAxis() item="xAxisValue" key="key"}
				<tr>
					<th class="xAxis">{$xAxisValue}</th>
					{foreach from=$series_list item="serie"}
						<td>{$serie.$key}</td>
					{/foreach}
				</tr>
			{/foreach}
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript" src="{public}js/chart/config.js"></script>
<script type="text/javascript">
	var chart_data{$model->getStep()} = {$chart_data};
	{literal}
	var chart{/literal}{$model->getStep()}{literal};
	$(document).ready(function() {
		var tmp = [];
		$(chart_data{/literal}{$model->getStep()}{literal}.series).each(function(i){
			tmp[i] = {
				name: this.caption,
				data: this.data
			};
		});

		tmp = $.extend(true, chartDefConfig, {
			chart: { renderTo: 'chart-display-main{/literal}{$model->getStep()}{literal}' },
			title: { text: 'Результаты рассчета обратного обхода' },
			xAxis: { categories:  chart_data{/literal}{$model->getStep()}{literal}.xAxis.data },
			yAxis: { title: { text: 'Ордината' } },
			series: tmp
		});

		chart{/literal}{$model->getStep()}{literal} = new Highcharts.Chart(tmp);

		// Очистка переменной
		delete window.chart_data{/literal}{$model->getStep()}{literal};
	});
	{/literal}
</script>