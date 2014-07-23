<div class="column">
  <div class="ui small pointing menu">
    <a class="item">
      <i class="home icon"></i> AvagoTech
    </a>
    <a class="item">
      <b>Validador de etiquetas</b>
    </a>
    <a class="active item">
      <i class="tags icon"></i> Por etiqueta
    </a>
    <a class="item">
      <i class="info icon"></i> Por Pieza
    </a>
    <!-- <div class="right menu"> -->
      <form class="item" on-submit="getScanner:1">
        <div class="ui icon input" autocomplete="off">
          <input type="text" placeholder="Escanea aqui" autocomplete="off" value="{{scan}}">
          <i class="barcode link icon"></i>
        </div>
      </form>
    <!-- </div> -->
  </div>
</div>
<div class="column">
  <div class="ui grid">
    <div class="row">
      <div class="four wide column">
        <div class="row">
          <div class="ui small vertical fluid pointing menu">
            {{#tags:i}}
            <a class="item" on-click="selectTag:{{i}}">
              {{id}}
              <span class="ui {{labelColor}} label"><i class="loading icon"></i></span>
            </a>
            {{/tags}}
          </div>
        </div>
      </div>
      <div class="twelve wide column">
        <div class="ui row">
          <table class="ui small table">
            <thead>
              <tr><th>Item</th>
              <th>Job</th>
              <!-- <th>Barcode</th> -->
              <th>Location</th>
              <th>Date received</th>
              <th>LPN</th>
              <th>OnhandQty</th>
              <th>PackStatus</th>
              <th>Status</th>
              <th>AgedDays</th>
              <!-- <th>Action</th> -->
            </tr></thead>
            <tbody>
              <tr>
                <td>No Name Specified</td>
                <td>Approved</td>
                <td>None</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr class="error">
                <td>Jimmy</td>
                <td>Cannot pull data</td>
                <td>None</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Jamie</td>
                <td>Approved</td>
                <td class="error"><i class="attention icon"></i> Classified</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Jill</td>
                <td>Approved</td>
                <td>None</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
          </table>
          <div class="ui divided list">
            <div class="item">
              <!-- <div class="right floated tiny teal ui button">A ver para que</div> -->
              <i class="green checked checkbox icon"></i>
              <div class="content">
                <div class="header">Validacion que si paso</div>
              </div>
            </div>
            <div class="item">
              <!-- <div class="right floated tiny teal ui button">A ver para que</div> -->
              <i class="warning red icon"></i>
              <div class="content">
                <div class="header">Causa de la falla</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>