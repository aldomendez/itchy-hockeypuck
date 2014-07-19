<div class="column">
	<h2 class="ui header">Busqueda de locacion por numero de serie</h2>
</div>
<div class="column">
	<form action="" method="POST" id="serial_num" on-submit='addSerialTable'>
		<div class="ui form">
		  <div class="field">
		    <label>User Input</label>
		    <input type="text" value='{{serial_num}}'>
		  </div>
		</div>
	</form>
	<table class="ui table compact segment">
	  <thead>
	    <tr><th>Item</th>
	    <th>Job</th>
	    <th>Barcode</th>
	    <th>Location</th>
	    <th>Date_received</th>
	    <th>LPN</th>
	    <th>OnHandQty</th>
	    <th>PackStatus</th>
	    <th>Status</th>
	    <th>Action</th>
	  </tr></thead>
	  <tbody>
	  {{#series}}
	    <tr>
	      <td>{{ITEM}}</td>
	      <td>{{JOB}}</td>
	      <td class="barcode">*{{JOB}}*</td>
	      <td>{{LOCATION}}</td>
	      <td>{{DATE_RECEIVED}}</td>
	      <td>{{LPN}}</td>
	      <td>{{ONHAND_QTY}}</td>
	      <td>{{PACK_STATUS}}</td>
	      <td>{{STATUS}}</td>
	      <td><a href="#" on-click='delete'>borrar</a></td>
	    </tr>
	    {{/series}}
	  </tbody>
	  <tfoot>
	</table>
<!-- Respuesta de OSFM
AGED_DAYS: "2"
DATE_RECEIVED: "16-JUL-14"
ITEM: "1626L0"
JOB: "141814036"
LOCATION: "MS9P-ENG"
LPN: null
ONHAND_QTY: "1"
PACK_STATUS: "UNPACKED"
STATUS: "INCORRECT LOCATION" -->
</div>