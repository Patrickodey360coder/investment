   
	$.plot('#demo-flot-donut', dataSet, {
		series: {
			pie: {
				show: true,
				combine: {
				color: '#999',
				threshold: 0.1
				}
			}
		},
		legend: {
		show: false
		}
	});


   Morris.Area({
		element: 'demo-morris-area',
		data: graph_data,
		gridEnabled: false,
		gridLineColor: 'transparent',
		behaveLikeLine: true,
		xkey: 'period',
		ykeys: ['dl', 'up'],
		labels: ['New', 'Active'],
		lineColors: ['#045d97'],
		pointSize: 0,
		pointStrokeColors : ['#045d97'],
		lineWidth: 0,
		resize:true,
		hideHover: 'auto',
		fillOpacity: 0.7,
		parseTime:false
	});


