   
	$.plot('#demo-flot-donut', investmentDataSet, {
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

	$.plot('#demo-morris-area', withdrawalDataSet, {
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


