$(document).ready(function () {


	var year = (new Date).getFullYear();
	datagrafico(year);
	$("#year").on("change", function () {
		yearselected = $(this).val();
		datagrafico(yearselected);
	});

});


function datagrafico(year) {
	namesMonth = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];
	$.ajax({

		url: base_url + "admin/dashboard/getData",
		type: "POST",
		data: {
			year: year
		},
		dataType: "json",
		success: function (data) {
			var monthly = new Array();
			var amounts = new Array();
			$.each(data, function (key, value) {
				monthly.push(namesMonth[value.month - 1]);
				valor = Number(value.total);
				amounts.push(valor);
			});
			graficar(monthly, amounts, year);
		}
	});
}


function graficar(monthly, amounts, year) {
	Highcharts.chart('grafico', {
		chart: {
			type: 'column'
		},
		title: {
			text: 'Montante De Vendas Por Mês'
		},
		subtitle: {
			text: year
		},
		xAxis: {
			categories: monthly,
			crosshair: true
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Valor Acumulado'
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.2f}</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series: [{
			name: 'Meses',
			data: amounts

		}]
	});
}
