<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Material en FG</title>
	<link rel="stylesheet" href="../jsLib/SemanticUi/0.19.0/packaged/css/semantic.min.css">
	<style type="text/css">
		.barcode {
			font-family:"Free 3 of 9", Helvetica, sans-serif;font-size:1.75em;
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
		series:series
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
		STATUS: "Searching...",
	}
 }
lookup = function (serial_num) {
	found = -1;
	for (var i = series.length - 1; i >= 0; i--) {
		if (series[i]['JOB'] == serial_num){
			found = i;
		}
	};
	return found;
}
r.on('addSerialTable',function (e) {
	e.original.preventDefault();
	series.push(PlaceHolder(e.context.serial_num));
	datos = $.getJSON(
		'toolbox.php',{
			action:'getResults',
			serial_num:e.context.serial_num
		});
	datos.done(function (datos) {
		console.log(datos.length);
		if (datos.length !== 0) {
			ff = lookup(datos[0]['JOB']);
			r.set("series."+ ff ,datos[0]);
		};
	}).fail(function (error) {
	});
	r.set('serial_num','');
})
r.on('delete',function (e) {
	e.original.preventDefault();
	series.splice(e.keypath.match(/\d/i)[0], 1);
})
</script>
</body>
</html>