(function() {
  var Family, Specific, Summary, fm, r;

  Family = (function() {
    function Family(family1) {
      this.family = family1;
      this.showMenu = true;
      this.familys = {
        'OSA': {
          operations: ["OSA", "OSA10GB", "OSA2-5GB", "OSA-COC", "OSACRTDV"]
        },
        'PIC-DIAMOND': {
          operations: ['PIC-DIAMOND']
        },
        'PIC-PMQP': {
          operations: ['PIC-PMQP']
        },
        'PIC-LR4': {
          operations: ['PIC-LR4']
        },
        'PIC-CFP': {
          operations: ['PIC-CFP']
        },
        'ENG10GTO': {
          operations: ['ENG10GTO']
        },
        'ENG2-5GT': {
          operations: ['ENG2-5GT']
        },
        'ENG10GRO': {
          operations: ['ENG10GRO']
        },
        'TUN': {
          operations: ['TUN']
        }
      };
      this.constructFamilyIndex();
    }

    Family.prototype.constructFamilyIndex = function() {
      return this.index = _.keys(this.familys);
    };

    Family.prototype.switchFamily = function(family1) {
      this.family = family1;
      console.log(this.family);
      r.set('summary', []);
      r.set('specific', {});
      this.familys[this.family].operations.map((function(_this) {
        return function(el) {
          return r.push('summary', new Summary(el));
        };
      })(this));
      r.set('show', 'summary');
      return r.set('fm.showMenu', false);
    };

    return Family;

  })();

  Summary = (function() {
    function Summary(family1) {
      this.family = family1;
      this.data = [];
      this.get();
    }

    Summary.prototype.get = function() {
      var prm;
      return prm = $.getJSON('toolbox.php', {
        action: 'getSummary',
        family: this.family
      }).done((function(_this) {
        return function(data) {
          _this.data = data;
          return r.update();
        };
      })(this));
    };

    return Summary;

  })();

  Specific = (function() {
    function Specific(family1, operation1) {
      this.family = family1;
      this.operation = operation1 != null ? operation1 : '';
      this.data = [];
      this.get();
    }

    Specific.prototype.get = function() {
      var prm;
      return prm = $.getJSON('toolbox.php', {
        action: 'getSpecific',
        family: this.family
      }).done((function(_this) {
        return function(data) {
          _this.data = data;
          _this.createHeader();
          return _this.filter(_this.operation);
        };
      })(this));
    };

    Specific.prototype.createHeader = function() {
      return this.header = _.uniq(_.pluck(this.data, 'OPN_CODE'));
    };

    Specific.prototype.filter = function(operation1) {
      this.operation = operation1 != null ? operation1 : '';
      if (this.operation === '') {
        this.filtered = this.data;
      } else {
        this.filtered = _.filter(this.data, (function(_this) {
          return function(el) {
            return el.OPN_CODE === _this.operation;
          };
        })(this));
      }
      return r.update();
    };

    return Specific;

  })();

  fm = new Family('OSA');

  r = new Ractive({
    el: 'container',
    template: '#template',
    data: {
      fm: fm,
      summary: [],
      specific: {},
      meta: {
        specific: {
          selected: '',
          family: ''
        }
      },
      show: 'summary',
      justName: function(fullName) {
        return fullName.match(/\w*/);
      }
    }
  });

  r.on('familyDetail', function(e, val) {
    var family;
    e.original.preventDefault();
    family = r.get("summary[" + (e.keypath.match(/\w*\.(\d+)/i)[1]) + "]").family;
    console.log(family);
    if (r.get("specific." + family) == null) {
      r.set("specific." + family, new Specific(family));
      r.set('meta.specific.selected', family);
    } else {
      r.get("specific." + family).filter('');
      r.set('meta.specific.selected', family);
    }
    return r.set('show', 'specific');
  });

  r.on('CodeDetail', function(e, val) {
    var c, d, f, family, operation, ref;
    e.original.preventDefault();
    ref = e.keypath.match(/\w*\.(\d+)\.\w+\.(\d+)/i), d = ref[0], f = ref[1], c = ref[2];
    family = r.get("summary[" + f + "].family");
    operation = r.get("summary[" + f + "].data[" + c + "].OPN_CODE");
    console.log([family, operation]);
    if (r.get("specific." + family) == null) {
      r.set("specific." + family, new Specific(family, operation));
      r.set('meta.specific.selected', family);
    } else {
      r.get("specific." + family).filter(operation);
      r.set('meta.specific.selected', family);
    }
    return r.set('show', 'specific');
  });

  r.on('unfilter', function(e) {
    e.original.preventDefault();
    return r.get("specific." + (r.get('meta.specific.selected'))).filter('');
  });

  r.on('filter', function(e, operation) {
    e.original.preventDefault();
    return r.get("specific." + (r.get('meta.specific.selected'))).filter(operation);
  });

  r.on('show', function(e, element) {
    e.original.preventDefault();
    return r.set('show', element);
  });

  r.on('toggleFamily', function(e) {
    e.original.preventDefault();
    r.set('fm.showMenu', !r.get('fm.showMenu'));
    return console.log(r.get('fm.showMenu'));
  });

  r.on('selectFamily', function(e, fam) {
    e.original.preventDefault();
    return r.get("fm").switchFamily(fam);
  });

  window.r = r;

}).call(this);
