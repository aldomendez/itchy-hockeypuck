class Family
  constructor: (@family) ->
    @showMenu = true
    @familys={
      'OSA':{
        operations:["OSA","OSA10GB","OSA2-5GB","OSA-COC","OSACRTDV"]
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
    console.log @family
    r.set 'summary', []
    r.set 'specific', {}
    @familys[@family].operations.map (el)=>
      r.push 'summary', new Summary el
    # r.update()
    r.set 'show', 'summary'
    r.set 'fm.showMenu', false

class Summary
  constructor: (@family) ->
    @data = []
    @get()

  get:()->
    prm = $.getJSON 'toolbox.php', {
      action:'getSummary'
      family:@family
    }
    .done (data)=>
      @data = data
      r.update()

class Specific
  constructor: (@family,@operation='') ->
    @data = []
    @get()
  get:()->
    prm = $.getJSON 'toolbox.php', {
      action:'getSpecific'
      family:@family
    }
    .done (data)=>
      @data = data
      @createHeader()
      @filter @operation
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
    summary:[]
    specific:{}
    meta:{
        specific:{
          selected:''
          family:''
      }
    }
    show:'summary'
    justName:(fullName)-> 
      # console.log fullName
      fullName.match(/\w*/)
  }
}

r.on 'familyDetail', (e,val)->
  e.original.preventDefault()
  family = r.get("summary[#{e.keypath.match(/\w*\.(\d+)/i)[1]}]").family
  console.log family
  if !r.get("specific.#{family}")?
    r.set "specific.#{family}", new Specific family
    r.set 'meta.specific.selected', family
  else
    r.get("specific.#{family}").filter ''
    r.set 'meta.specific.selected', family
  r.set 'show', 'specific'
  

r.on 'CodeDetail', (e,val)->
  e.original.preventDefault()
  [d,f,c] = e.keypath.match(/\w*\.(\d+)\.\w+\.(\d+)/i)
  family = r.get "summary[#{f}].family"
  operation = r.get "summary[#{f}].data[#{c}].OPN_CODE"
  console.log [family, operation]

  if !r.get("specific.#{family}")?
    r.set "specific.#{family}", new Specific family, operation
    r.set 'meta.specific.selected', family
  else
    r.get("specific.#{family}").filter operation
    r.set 'meta.specific.selected', family

  r.set 'show', 'specific'


r.on 'unfilter', (e)->
  e.original.preventDefault()
  r.get("specific.#{r.get 'meta.specific.selected'}").filter ''

r.on 'filter', (e, operation)->
  e.original.preventDefault()
  r.get("specific.#{r.get 'meta.specific.selected'}").filter operation

r.on 'show', (e, element)->
  e.original.preventDefault()
  r.set 'show', element

r.on 'toggleFamily', (e)->
  e.original.preventDefault()
  r.set 'fm.showMenu', !r.get 'fm.showMenu'
  console.log r.get 'fm.showMenu'

r.on 'selectFamily', (e,fam)->
  e.original.preventDefault()
  # console.log r.get 'fm'
  # console.log fam
  r.get("fm").switchFamily fam

window.r = r
