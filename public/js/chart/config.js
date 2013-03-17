/**
 * Дефолтный конфиг для графиков
 */
var chartDefConfig = {
	chart: {
		renderTo: 'chart-display-main',
		type: 'spline',
		zoomType: 'xy',
		animation: false
	},
	credits: {enabled: false},
	title: {
		text: 'Исходные данные',
		x: -20 //center
	},
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
		title: {
			text: 'Данные измерений'
		},
		plotLines: [{
			value: 0,
			width: 1,
			color: '#808080'
		}]
	},
	legend: {
		enabled: true,
		layout: 'vertical',
		align: 'right',
		verticalAlign: 'top',
		x: -10,
		y: 100,
		borderWidth: 0
	},
	rangeSelector: {
		enabled: false
	},
	series: []
};
