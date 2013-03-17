/**
 * Данные графика изменения эквити по сделкам
 * @type {Object}
 */
var trades_equity_chart_data = {};
var chart_trades_equity;

$(document).ready(function(){
	window.trades_equity_config = $.extend(true, trades_equity_config, {
		yAxis: {
			title: {text: charts_i18n.axisEquity}
		},
		rangeSelector : {
			buttons : {
				4 : {
					text: charts_i18n.rangeSelectorZoomAll
				}
			}
		},
		tooltip: {
			formatter: function() {
				var point = this.points[0];
				var element = typeof(window.trades_equity_chart_data[this.x]) != 'undefined' ? window.trades_equity_chart_data[this.x] : [0, 0, 0, 0];
				return '<span style="color:'+point.series.color+';font-weight: bold">'+point.series.name+'</span><br/><br/>'
					+'<b>'+charts_i18n.tooltipEquity+':</b> '+Math.round(point.y*100) / 100+'<br/>'
					+'<b>'+charts_i18n.tooltipOrder+':</b> '+element[2]+'<br/>'
					+'<b>'+charts_i18n.tooltipVolume+':</b> '+element[3]+'<br/>'
					+'<b>'+charts_i18n.tooltipCloseTime+':</b> '+Highcharts.dateFormat('%Y-%m-%d %H:%M:%S',element[4]*1000);
			}
		}
	});

	chart_trades_equity = new Highcharts.StockChart(window.trades_equity_config);
});

var trades_equity_config = {
	chart: {
		renderTo: 'container_trades_equity',
		backgroundColor: '#FAFBFC',
		defaultSeriesType: 'spline',
		zoomType: 'xy'
	},
	credits: {enabled: false},
	title: false,
	xAxis: {
		type: 'linear',
		categories: [],
		tickmarkPlacement: 'on',
		title: { enabled: false },
		maxzoom: 10,
		showFirstLabel: true,
		showLastLabel: true,
		labels: {
			formatter: function(){return this.value},
			enabled: true
		}
	},
	yAxis: {
		title: { text: '' },
		labels: {}
	},
	scrollbar: {
		enabled: true
	},
	plotOptions: {
		spline: {
			marker: {
				enabled: false,
				states: { hover: { enabled: true }}
			}
		}
	},
	navigator: { xAxis: { labels: { formatter: function () {return this.value}}}},
	rangeSelector: {
		inputEnabled: false,
		buttonTheme: {
			width: 50
		},
		buttons : [{
			type: 'millisecond',
			count: 10,
			text: '10'
		}, {
			type: 'millisecond',
			count: 100,
			text: '100'
		}, {
			type: 'millisecond',
			count: 1000,
			text: '1000'
		}, {
			type: 'millisecond',
			count: 10000,
			text: '10000'
		}, {
			type: 'all',
			text: 'All'
		}]
	},
	legend : {
		enabled: false
	},
	series: [{
		data: {}
	}]
};

function getOffset(length)
{
	var offset = 0;

	if (length > 15000) {
		offset = 10000;
	} else if (length > 1500) {
		offset = 1000;
	} else if (length > 150) {
		offset = 100;
	} else if (length > 15) {
		offset = 10;
	}

	return offset;
}