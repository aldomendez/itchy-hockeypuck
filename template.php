<div class="column">
	<h2 class="ui header">Busqueda de locacion por numero de serie</h2>
</div>

<div class="column">

		<div class="ui fluid form segment">
		  <div class="two fields">
			<form action="" id="serial_num" on-submit='checkLpn'>
			    <div class="field">
			      <label>LPN</label>
			        <div class="ui left labeled input">
			      	  <input type="text" value='{{actualLPN}}'>
			          <!-- <i class="user icon"></i> -->
			          <div class="ui corner label">
			            {{series.length}}
			          </div>
			        </div>
			    </div>
			</form>
			<form action="" id="serial_num" on-submit='addSerialTable'>
			    <div class="field">
					<label>Numero de serie</label>
			        <div class="ui left labeled input">
			      	  <input type="text" value='{{serial_num}}'>
			          <!-- <i class="user icon"></i> -->
			          <div class="ui corner label">{{lpnData.length}}
			          </div>
			        </div>
			    </div>
			</form>
		  </div>

		</div>

</div>
<div class="column">
	<div class="ui six column divided grid">
		<div class="column">
			<table class="ui table small compact">
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
			    <th>Aged days</th>
			    <th>Action</th>
			  </tr></thead>
			  <tbody>
			  	{{#series}}
			    <tr class="{{exists()}}">
			      <td>{{ITEM}}</td>
			      <td>{{JOB}}</td>
			      <td class="barcode">*{{JOB}}*</td>
			      <td>{{LOCATION}}</td>
			      <td>{{DATE_RECEIVED}}</td>
			      <td>{{LPN}}</td>
			      <td>{{ONHAND_QTY}}</td>
			      <td>{{PACK_STATUS}}</td>
			      <td>{{STATUS}}</td>
			      <td>{{AGED_DAYS}}</td>
			      <td><a href="#" on-click='delete'>borrar</a></td>
			    </tr>
			    {{/series}}
			  </tbody>
			</table>
		</div>
		<div class="column">
			<table class="ui table small compact">
			  <thead>
			    <tr><th>Item</th>
			    <th>Job</th>
			    <th>Location</th>
			    <th>Date_received</th>
			    <th>LPN</th>
			    <th>OnHandQty</th>
			  </tr></thead>
			  <tbody>
			    {{#lpnData}}
			    <tr>
			      <td>{{ITEM}}</td>
			      <td>{{JOB}}</td>
			      <td>{{LOCATION}}</td>
			      <td>{{DATE_RECEIVED}}</td>
			      <td>{{LPN}}</td>
			      <td>{{ONHAND_QTY}}</td>
			    </tr>
			    {{/lpnData}}

			  </tbody>
			</table>
		</div>
	</div>
</div>