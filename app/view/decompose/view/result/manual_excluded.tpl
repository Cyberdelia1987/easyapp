<script type="text/javascript" src="{public}js/chart/config.js"></script>
<script type="text/javascript">
	var chart_data{$model->getStep()} = {$chart_data};

	{literal}
	var chart{/literal}{$model->getStep()}{literal};
	$(document).ready(function() {
		var table = $('#tabs-{/literal}{$model->getStep()}{literal} table');

		$(chart_data{/literal}{$model->getStep()}{literal}.series).each(function(){
			var serie = this;
			$('#chart-display-main'+{/literal}{$model->getStep()}{literal}).highcharts().addSeries({
				name: serie.caption,
				data: serie.data
			});

			table.find('thead tr').append('<th>'+serie.caption+'</th>');

			var trs = table.find('tbody tr');
			$(serie.data).each(function(key){
				$(trs[key]).append('<td>'+this+'</td>')
			});
		});
	});
	{/literal}
</script>