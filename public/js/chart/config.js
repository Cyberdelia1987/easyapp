/**
 * Дефолтный конфиг для графиков
 */
var chartDefConfig = {
	chart: {
		renderTo: 'chart-display-main',
		type: 'line',
		zoomType: 'xy',
		animation: false
	},
	credits: {enabled: false},
	title: {
		text: 'Исходные данные',
		x: -20 //center
	},
	plotOptions : {
		animation: false,
		line :{
			marker : {
				enabled: false
			},
			states : {
				marker: {
					lineWidth: 1
				}
			}
		}
	},
	xAxis: {
		type: 'linear',
		categories: [],
		tickmarkPlacement: 'on',
		title: { enabled: false },
		labels: {
			enabled: true,
			step: 3
		},
		tickInterval: 10
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
	tooltip: {
		shared: true,
		crosshairs: true
	},
	rangeSelector: {
		enabled: false
	},
	series: []
};
