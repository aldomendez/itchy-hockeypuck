// Generated by CoffeeScript 1.7.1
(function() {
  var Device, Tag, r;

  Tag = (function() {
    function Tag(id) {
      this.id = id;
      this.scanned = [];
      this.fromDB = [];
      this.getFromDatabase();
      this.labelColor = '';
      this.loadingIcon = true;
    }

    Tag.prototype.getFromDatabase = function() {
      var coneccion;
      return coneccion = $.getJSON('toolbox.php', {
        action: 'getLPN',
        lpn: this.id
      }).done((function(_this) {
        return function(data) {
          _this.fromDB = data;
          console.log(data[0]);
          if (data[0]['ITEM'] != null) {
            _this.labelColor = 'green';
          } else {
            _this.labelColor = 'red';
          }
          return r.update();
        };
      })(this)).fail((function(_this) {
        return function(err) {
          return _this.labelColor = 'red';
        };
      })(this)).always((function(_this) {
        return function(data) {
          _this.loadingIcon = false;
          return r.update();
        };
      })(this));
    };

    return Tag;

  })();

  Device = (function() {
    function Device(id, source) {
      this.id = id;
      this.source = source;
      this.data = [];
    }

    Device.prototype.isFromScan = function() {
      if (this.source = 'scan') {
        return true;
      }
    };

    Device.prototype.getFromDatabase = function() {
      var coneccion;
      return coneccion = $.getJSON('toolbox.php', {
        action: 'getResults',
        serial_num: this.id
      }).done((function(_this) {
        return function(data) {
          _this.fromDB = data;
          _this.labelColor = 'green';
          return r.update();
        };
      })(this)).fail((function(_this) {
        return function(err) {
          return _this.labelColor = 'red';
        };
      })(this)).always((function(_this) {
        return function(data) {
          _this.loadingIcon = false;
          return r.update();
        };
      })(this));
    };

    return Device;

  })();

  r = new Ractive({
    el: 'container',
    template: '#template',
    data: {
      serial_num: '',
      show: 'byTag',
      scan: '',
      tags: [],
      devices: [],
      selectedTag: 0
    }
  });

  r.on('getScanner', function(e, val) {
    e.original.preventDefault();
    if (/MX\d{8}/.test(r.data.scan)) {
      r.set('selectedTag', 0);
      r.set('show', 'byTag');
      r.data.tags.unshift(new Tag(r.data.scan));
      return r.set('scan', '');
    } else if (/\d{9}/.test(r.data.scan)) {
      console.log("El codigo " + r.data.scan + " podria ser numero de serie");
      r.set('show', 'byDevice');
      r.data.devices.unshift(new Device(r.data.scan, 'scan'));
      return r.set('scan', '');
    } else {
      return console.log("" + r.data.scan + " no corresponde a ningun patron");
    }
  });

  r.on('scanType', function(e, type) {
    e.original.preventDefault();
    return r.set('show', type);
  });

  r.on('selectTag', function(e, tagId) {
    e.original.preventDefault();
    return r.set('selectedTag', tagId);
  });

  window.r = r;

}).call(this);

//# sourceMappingURL=main.map
