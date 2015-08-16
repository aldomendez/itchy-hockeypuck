class Family
  constructor: (@family) ->
    @showMenu = false
    @familys={
      'OSA':{
        operations:["OSA","OSA10GB","OSA2-5GB","OSA-COC","OSACRTDV"]
      }
      'L2K':{
        operations:['EML','DML']
      }
      'PIC-DIAMOND':{
        operations:['PIC-DIAMOND']
      }
      'PIC-PMQP':{
        operations:['PIC-PMQP']
      }
      'PIC-LR4':{
        operations:['PIC-LR4']
      }
      'PIC-CFP':{
        operations:['PIC-CFP']
      }
      'ENG10GTO':{
        operations:['ENG10GTO']
      }
      'ENG2-5GT':{
        operations:['ENG2-5GT']
      }
      'ENG10GRO':{
        operations:['ENG10GRO']
      }
      'TUN':{
        operations:['TUN']
      }
    }
    @constructFamilyIndex()
  constructFamilyIndex:()->
    @index = _.keys @familys
  switchFamily:(@family)->
    r.data.summary = []
    r.data.specific = {}
    @familys[@family].operations.map (el)=>
      r.data.summary.push new Summary el
    # r.update()
    r.data.show = 'summary'
    r.data.fm.showMenu = false

class Summary
  constructor: (@family) ->
    @data = []
    @get()

  get:()->
    NProgress.start();
    prm = $.getJSON 'toolbox.php', {
      action:'getSummary'
      family:@family
    }
    .done (data)=>
      @data = data
      NProgress.done();
      r.update()

class Specific
  constructor: (@family,@operation='') ->
    @data = []
    @get()
  get:()->
    NProgress.start();
    prm = $.getJSON 'toolbox.php', {
      action:'getSpecific'
      family:@family
    }
    .done (data)=>
      @data = data
      @createHeader()
      @filter @operation
      NProgress.done();
  createHeader:()->
    @header = _.uniq _.pluck @data, 'OPN_CODE'
  filter:(@operation='')->
    if @operation is ''
      @filtered = @data
    else
      @filtered = _.filter @data, (el)=>
        el.OPN_CODE is @operation
    r.update()

fm = new Family 'OSA'

r = new Ractive {
  el: 'container'
  template: '#template'
  data:{
    fm:fm
    summary:[
      new Summary 'OSA'
      new Summary 'OSA10GB'
      new Summary 'OSA2-5GB'
      new Summary 'OSA-COC'
      new Summary 'OSACRTDV'
    ]
    specific:{}
    meta:{
        specific:{
          selected:'OSACRTDV'
          family:''
      }
    }
    show:'summary'
    justName:(fullName)-> fullName.match(/\w*/)
  }
}

r.on 'familyDetail', (e,val)->
  e.original.preventDefault()
  family = r.data.summary[e.keypath.match(/\w*\.(\d+)/i)[1]].family
  # console.log family
  if !r.data.specific[family]?
    r.data.specific[family] = new Specific family
    r.set 'meta.specific.selected', family
  else
    r.data.specific[family].filter ''
    r.set 'meta.specific.selected', family
  r.set 'show', 'specific'
  

r.on 'CodeDetail', (e,val)->
  e.original.preventDefault()
  [d,f,c] = e.keypath.match(/\w*\.(\d+)\.\w+\.(\d+)/i)
  family = r.data.summary[f].family
  operation = r.data.summary[f].data[c].OPN_CODE
  console.log [family, operation]

  if !r.data.specific[family]?
    r.data.specific[family] = new Specific family, operation
    r.set 'meta.specific.selected', family
  else
    r.data.specific[family].filter operation
    r.set 'meta.specific.selected', family

  r.set 'show', 'specific'


r.on 'unfilter', (e)->
  e.original.preventDefault()
  r.data.specific[r.data.meta.specific.selected].filter ''

r.on 'filter', (e, operation)->
  e.original.preventDefault()
  r.data.specific[r.data.meta.specific.selected].filter operation

r.on 'show', (e, element)->
  e.original.preventDefault()
  r.set 'show', element

r.on 'toggleFamily', (e)->
  e.original.preventDefault()
  r.set 'fm.showMenu', !r.data.fm.showMenu
  console.log r.data.fm.showMenu
r.on 'selectFamily', (e,fam)->
  e.original.preventDefault()
  console.log fam
  r.data.fm.switchFamily fam

window.r = r
