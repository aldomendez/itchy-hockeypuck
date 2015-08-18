<div class="column">
  <div class="ui tiered small menu">
    <div class="menu">
      <a class="item">
        <i class="home icon"></i> AvagoTech
      </a>
      <a class="item">
        <b>Analizador de WIP</b>
      </a>

      <a class="{{show=='summary'?'active':''}} item" on-click="show:summary">
        <i class="tags icon"></i> Sumario
      </a>
      <a class="{{show=='specific'?'active':''}} item" on-click="show:specific">
        <i class="info icon"></i> Detalle
      </a>
      <a class="{{fm.showMenu ?'active':''}} item" on-click="toggleFamily">
        <i class="calendar icon"></i> Familia: <b>{{fm.family}}</b>
      </a>
    </div>
  </div>
    {{#fm.showMenu}}
    <div class="ui text menu">
      {{#each fm.index :i}}
        <a class="{{fm.family == this? 'active':''}} item" on-click="selectFamily:{{.}}">{{.}}</a>
      {{/each}}
    </div>
    {{/fm.showMenu}}
</div>

{{#show=='summary'}}
{{#summary :i}}
<div class="column">
  <div class="ui grid">
    <div class="row">
      <div class="column">
      <h4 on-click="familyDetail">
        <div class="ui basic button">
          <i class="icon zoom out"></i>
          {{family}}
        </div>
      </h4>
        <table class="ui basic table compact small">
          <thead>
            <th>OPN_CODE</th>
            <th>OPN_DESCRIPTION</th>
            <th>PACKS</th>
            <th>QTY</th>
            <th>JOB_STATUS</th>
            <th>MED_STALLED_TIME</th>
            <th>MIN_STALLED_TIME</th>
            <th>MAX_STALLED_TIME</th>
            <th>MED_CT</th>
            <th>MIN_CT</th>
            <th>MAX_CT</th>
          </thead>
          <tbody>
            {{# data}}
            <tr>
            <td>{{OPN_CODE}}</td>
            <td><a href="" on-click="CodeDetail" class="ui tiny basic button">{{justName(OPN_DESCRIPTION)}}</a></td>
            <td>{{PACKS}}</td>
            <td>{{QTY}}</td>
            <td>{{JOB_STATUS}}</td>
            <td>{{MED_STALLED_TIME}}</td>
            <td>{{MIN_STALLED_TIME}}</td>
            <td>{{MAX_STALLED_TIME}}</td>
            <td>{{MED_CYCLE_TIME}}</td>
            <td>{{MIN_CYCLE_TIME}}</td>
            <td>{{MAX_CYCLE_TIME}}</td>
            </tr>
            {{/ data}}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
{{/summary }}
{{/show=='summary'}}

{{#show=='specific'}}
{{#specific}}
{{#specific[meta.specific.selected]}}
<div class="column">
  <div class="ui grid">
    <div class="row">
      <div class="column">
      <div class="ui horizontal link list">
        {{#header :i}}
        <a class="item" on-click='filter:{{.}}'>
          {{.}}
        </a>
        {{/header}}
      </div>
      <h4 on-click="unfilter:{{family}}">
        <div class="ui basic button">
          <i class="icon level up"></i>
          {{family}} (piezas: {{specific[meta.specific.selected].filtered.length}})
        </div>
      </h4>
        <table class="ui basic table compact small">
          <thead>
            <th>ITEM</th>
            <th>JOB</th>
            <th>CREATION_DT</th>
            <th>OPN_CODE</th>
            <th>OPN_DESCRIPTION</th>
            <th>QTY</th>
            <th>STATUS</th>
            <th>STALLED</th>
            <th>CURR_CT</th>
            <th>LAST_MOVE_DT</th>
          </thead>
          <tbody>
            {{# filtered}}
            <tr>
            <td>{{ITEM}}</td>
            <td>{{JOB}}</td>
            <td>{{JOB_CREATION_DATE}}</td>
            <td>{{OPN_CODE}}</td>
            <td>{{OPN_DESCRIPTION}}</td>
            <td>{{QTY}}</td>
            <td>{{JOB_STATUS}}</td>
            <td>{{DAYS_SINCE_LAST_MOVE}}</td>
            <td>{{DAYS_SINCE_JOB_CREATION}}</td>
            <td>{{JOB_LAST_MOVE_DATE}}</td>
            </tr>
            {{/ filtered}}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
{{/specific[meta.specific.selected]}}
{{/specific }}
{{/show=='specific'}}