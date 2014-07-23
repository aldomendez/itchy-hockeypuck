<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Material en FG</title>
	<link rel="stylesheet" href="../jsLib/SemanticUi/1.0.0/packaged/css/semantic.min.css">
	<style type="text/css">
	@font-face {
	    font-family: 'Free3of9'; /*a name to be used later*/
	    src: url('http://cymautocert/osaapp/fonts/free3of9.ttf'); /*URL to font*/
	}
	.barcode {
		font-family:"Free3of9", Helvetica, sans-serif;
		font-size:1.75em;
	}
	</style>
</head>
<body>
	<div class="ui page" id="container"></div>
	<script id="template" type="text/ractivejs"><?php include 'template.php'; ?></script>
	<script src="../jsLib/jquery/jquery-2.1.1.min.js"></script>
	<script src="../jsLib/ractivejs/ractive-0.5.5.js"></script>
<script>
var series = [];

r = new Ractive({
	el:'container',
	template:'#template',
	data:{
		serial_num:'',
		series:series,
		show:'serial_num',
		availableStates:['serial_num','lpnList'],
		actualLPN:'',
		lpnData:[]
	}
});

 var PlaceHolder = function (serial_num) {
 	return {
		AGED_DAYS: "",
		DATE_RECEIVED: "",
		ITEM: "",
		JOB: serial_num,
		LOCATION: "",
		LPN: null,
		ONHAND_QTY: "",
		PACK_STATUS: "",
		STATUS: "Buscando",
	}
 }
lookup = function (serial_num) {
	for (var i = series.length - 1; i >= 0; i--) {
		if (series[i]['JOB'] == serial_num){
			return i;
		}
	};
	return -1;
}
r.on('addSerialTable',function (e) {
	e.original.preventDefault();
	if (lookup(e.context.serial_num) == -1 || r.data.series.length == 0) {
		series.push(PlaceHolder(e.context.serial_num));
		datos = $.getJSON(
			'toolbox.php',{
				action:'getResults',
				serial_num:e.context.serial_num
			});
		datos.done(function (datos) {
			if (datos[0]['ITEM'] != null) {
				ff = lookup(datos[0]['JOB']);
				r.set("series."+ ff ,datos[0]);
			}else{
				ff = lookup(datos[0]['JOB']);
				content = PlaceHolder(datos[0]['JOB']);
				content.STATUS = "No se encontro";
				r.set("series."+ ff ,content);
			};
		}).fail(function (error) {
		});
	};
	r.set('serial_num','');
});

r.on('delete',function (e) {
	e.original.preventDefault();
	series.splice(e.keypath.match(/\d/i)[0], 1);
});

r.on('gotoLPNList', function (e) {
	e.original.preventDefault();
	r.set('show', 'serial_num');
})

r.on('returnToSerialNumList', function (e) {
	e.original.preventDefault();
	r.set('show', 'lpnList');
})

r.on('checkLpn', function (e) {
	e.original.preventDefault();
	datos = $.getJSON(
		'toolbox.php',{
			action:'getLPN',
			lpn:r.get('actualLPN')
		}
	);
	datos.done(function (datos) {
		r.set('lpnData',datos);
		console.log(datos);
	}).fail(function (error) {
		console.log(error);
	});
	r.set('show', 'lpnList');
});
</script>
</body>
</html>