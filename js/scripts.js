
function muestroError() {
	alert("ERROR")
}

/**
* Funcion que obtiene la cantidad de productos vendidos entre dos fechas dadas
*/
function obtenerProductosVendidos() {
	var fechaInicio = $("#fechaInicio").val();
	var fechaFin = $("#fechaFin").val();
	$.ajax(
		{
			url: './index.php',
			type: 'get',
			async: true,
			data: 'action=getSoldProducts&fechaInicio='+ fechaInicio + '&fechaFin=' + fechaFin,
			dataType: 'json',
			success: cargarGrafico
		});
}

function cargarGrafico(respuesta) {
	var res = respuesta;
	var arr = new Array();
	var arr2 = new Array();
	for (var i = 0; i < res.length; i++) {
		arr.push(res[i].cantidad);
		arr2.push(res[i].fecha);
	}
	$('#graph').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: 'Productos vendidos'
		},
		xAxis: {
			categories: arr2
		},
		yAxis: {
			title: {
				text: 'Productos'
			}
		},
		series: [{
			name: 'Productos',
			type: 'column',
			data: arr
			}
			]
	});
}

/**
* Funcion que obtiene la cantidad de productos electronicos vendidos entre dos fechas dadas
*/
function obtenerElectronicosVendidos() {
	var fechaInicio = $("#fechaInicio").val();
	var fechaFin = $("#fechaFin").val();
	$.ajax(
		{
			url: './index.php',
			type: 'get',
			async: true,
			data: 'action=getSoldElectronics&fechaInicio='+ fechaInicio + '&fechaFin=' + fechaFin,
			dataType: 'json',
			success: cargarGraficoElectronicos,
		});
}

function cargarGraficoElectronicos(respuesta) {
	var res = respuesta;
	var arr = new Array();
	var arr2 = new Array();
	for (var i = 0; i < res.length; i++) {
		arr.push(res[i].cantidad);
		arr2.push(res[i].fecha);
	}
	$('#graph').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: 'Productos vendidos'
		},
		xAxis: {
			categories: arr2
		},
		yAxis: {
			title: {
				text: 'Productos'
			}
		},
		series: [{
			name: 'Productos',
			type: 'column',
			data: arr
			}
			]
	});
}

function obtenerProductosEmpleados() {
	var fechaInicio = $("#fechaInicio").val();
	var fechaFin = $("#fechaFin").val();
	$.ajax(
	{
		url: './index.php',
		type: 'get',
		async: true,
		data: 'action=getProductsEmployees&fechaInicio='+ fechaInicio + '&fechaFin=' + fechaFin,
		dataType: 'json',
		success:cargarGraficoProductosEmpleados,
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function cargarGraficoProductosEmpleados(respuesta) {
	var res = respuesta;
	var arr = new Array();
	for (var i = 0; i < res.length; i++) {
			arr.push({name: "Empleados", y: res[i].cantEmp});
			arr.push({name: "Clientes", y: res[i].cantNoEmp});
	}
	$('#graph').highcharts({
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: 'Productos Vendidos'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.y}</b>'
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>',
					style: {
						color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
					}
				}
			}
		},
		series: [{
			name: 'Productos',
			colorByPoint: true,
			data: arr
		}]
	});
}

function obtenerCuponesUsados() {
	var fechaInicio = $("#fechaInicio").val();
	var fechaFin = $("#fechaFin").val();
	$.ajax(
		{
			url: './index.php',
			type: 'get',
			async: true,
			data: 'action=getUsedCoupons&fechaInicio='+ fechaInicio + '&fechaFin=' + fechaFin,
			dataType: 'json',
			success: cargarGraficoCupones
		});
}

function cargarGraficoCupones(respuesta) {
	var res = respuesta;
	var arr = new Array();
	var arr2 = new Array();
	for (var i = 0; i < res.length; i++) {
		arr.push(res[i].cantidad);
		arr2.push(res[i].fecha);
	}
	$('#graph').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: 'Productos vendidos'
		},
		xAxis: {
			categories: arr2
		},
		yAxis: {
			title: {
				text: 'Productos'
			}
		},
		series: [{
			name: 'Productos',
			type: 'column',
			data: arr
			}
			]
	});
}