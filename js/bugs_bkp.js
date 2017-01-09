//Correção do clearSelections
Ext.override(Ext.grid.RowSelectionModel, {
    clearSelections : function(fast){
        if(this.locked) return;
        if(fast !== true){
            var ds = this.grid.store;
            var s = this.selections;
            s.each(function(r){
                this.deselectRow(ds.indexOfId(r.id));
            }, this);
            s.clear();
        }else{
            this.selections.clear();
        }
        this.last = false;
        // Change
        var hdCheckbox = this.grid.getEl().select('.x-grid3-hd-checker-on');
        if(hdCheckbox) hdCheckbox.removeClass('x-grid3-hd-checker-on');
        // End of change
    }
});

//Bug dos Checkbox que não aparecem
Ext.override(Ext.form.Field, {
   markInvalid: function(msg) {
      if (!this.rendered || this.preventMark) {
         return;
      }
      var markEl = this.markEl || this.el;
      markEl.addClass(this.invalidClass);
      msg = msg || this.invalidText;
      switch (this.msgTarget) {
      case 'qtip':
         markEl.dom.qtip = msg;
         markEl.dom.qclass = 'x-form-invalid-tip';
         if (Ext.QuickTips) {
            Ext.QuickTips.enable();
         }
         break;
      case 'title':
         markEl.dom.title = msg;
         break;
      case 'under':
         if (!this.errorEl) {
            var elp = this.getErrorCt();
            if (!elp) {
               markEl.dom.title = msg;
               break;
            }
            this.errorEl = elp.createChild({
               cls: 'x-form-invalid-msg'
            });
            this.errorEl.setWidth(elp.getWidth(true) - 20);
         }
         this.errorEl.update(msg);
         Ext.form.Field.msgFx[this.msgFx].show(this.errorEl, this);
         break;
      case 'side':
         if (!this.errorIcon) {
            var elp = this.getErrorCt();
            if (!elp) {
               markEl.dom.title = msg;
               break;
            }
            this.errorIcon = elp.createChild({
               cls: 'x-form-invalid-icon'
            });
         }
         this.alignErrorIcon();
         this.errorIcon.dom.qtip = msg;
         this.errorIcon.dom.qclass = 'x-form-invalid-tip';
         this.errorIcon.show();
         this.on('resize', this.alignErrorIcon, this);
         break;
      default:
         var t = Ext.getDom(this.msgTarget);
         t.innerHTML = msg;
         t.style.display = this.msgDisplay;
         break;
      }
      this.fireEvent('invalid', this, msg);
   },
   clearInvalid: function() {
      if (!this.rendered || this.preventMark) {
         return;
      }
      var markEl = this.markEl || this.el;
      markEl.removeClass(this.invalidClass);
      switch (this.msgTarget) {
      case 'qtip':
         markEl.dom.qtip = '';
         break;
      case 'title':
         markEl.dom.title = '';
         break;
      case 'under':
         if (this.errorEl) {
            Ext.form.Field.msgFx[this.msgFx].hide(this.errorEl, this);
         } else {
            markEl.dom.title = '';
         }
         break;
      case 'side':
         if (this.errorIcon) {
            this.errorIcon.dom.qtip = '';
            this.errorIcon.hide();
            this.un('resize', this.alignErrorIcon, this);
         } else {
            markEl.dom.title = '';
         }
         break;
      default:
         var t = Ext.getDom(this.msgTarget);
         t.innerHTML = '';
         t.style.display = 'none';
         break;
      }
      this.fireEvent('valid', this);
   },
   alignErrorIcon: function() {
      this.errorIcon.alignTo(this.markEl || this.el, 'tl-tr', [2, 0]);
   }
});
Ext.override(Ext.form.Checkbox, {
   onRender: function(ct, position) {
      Ext.form.Checkbox.superclass.onRender.call(this, ct, position);
      if (this.inputValue !== undefined) {
         this.el.dom.value = this.inputValue;
      }
      this.el.removeClass(this.baseCls);
      this.innerWrap = this.el.wrap({
         cls: this.baseCls + '-wrap-inner'
      });
      this.wrap = this.innerWrap.wrap({
         cls: this.baseCls + '-wrap'
      });
      this.imageEl = this.innerWrap.createChild({
         tag: 'img',
         src: Ext.BLANK_IMAGE_URL,
         cls: this.baseCls
      });
      if (this.boxLabel) {
         this.labelEl = this.innerWrap.createChild({
            tag: 'label',
            htmlFor: this.el.id,
            cls: 'x-form-cb-label',
            html: this.boxLabel
         });
      }
      if (this.checked) {
         this.setValue(true);
      } else {
         this.checked = this.el.dom.checked;
      }
      this.originalValue = this.checked;
      this.markEl = this.innerWrap;
   },
   afterRender: function() {
      Ext.form.Checkbox.superclass.afterRender.call(this);
      this.imageEl[this.checked ? 'addClass': 'removeClass'](this.checkedCls);
   },
   initCheckEvents: function() {
      this.innerWrap.addClassOnOver(this.overCls);
      this.innerWrap.addClassOnClick(this.mouseDownCls);
      this.innerWrap.on('click', this.onClick, this);
      if (this.validationEvent !== false) {
         this.el.on(this.validationEvent, this.validate, this, {
            buffer: this.validationDelay
         });
      }
   },
   onFocus: function(e) {
      Ext.form.Checkbox.superclass.onFocus.call(this, e);
      this.innerWrap.addClass(this.focusCls);
   },
   onBlur: function(e) {
      Ext.form.Checkbox.superclass.onBlur.call(this, e);
      this.innerWrap.removeClass(this.focusCls);
   },
   onClick: function(e) {
      if (e.getTarget().htmlFor != this.el.dom.id) {
         if (e.getTarget() != this.el.dom) {
            this.el.focus();
         }
         if (!this.disabled && !this.readOnly) {
            this.toggleValue();
         }
      }
   },
   onEnable: Ext.form.Checkbox.superclass.onEnable,
   onDisable: Ext.form.Checkbox.superclass.onDisable,
   onKeyUp: undefined,
   setValue: function(v) {
      var checked = this.checked;
      this.checked = (v === true || v === 'true' || v == '1' || String(v).toLowerCase() == 'on');
      if (this.rendered) {
         this.el.dom.checked = this.checked;
         this.el.dom.defaultChecked = this.checked;
         this.imageEl[this.checked ? 'addClass': 'removeClass'](this.checkedCls);
      }
      if (checked != this.checked) {
         this.fireEvent("check", this, this.checked);
         if (this.handler) {
            this.handler.call(this.scope || this, this, this.checked);
         }
      }
   },
   getResizeEl: function() {
      return this.wrap;
   },
   markInvalid: Ext.form.Checkbox.superclass.markInvalid,
   clearInvalid: Ext.form.Checkbox.superclass.clearInvalid,
   validationEvent: 'click',
   validateOnBlur: false,
   validateValue: function(value) {
      if (this.vtype) {
         var vt = Ext.form.VTypes;
         if (!vt[this.vtype](value, this)) {
            this.markInvalid(this.vtypeText || vt[this.vtype + 'Text']);
            return false;
         }
      }
      if (typeof this.validator == "function") {
         var msg = this.validator(value);
         if (msg !== true) {
            this.markInvalid(msg);
            return false;
         }
      }
      return true;
   }
});
Ext.override(Ext.form.Radio, {
   checkedCls: 'x-form-radio-checked',
   markInvalid: Ext.form.Radio.superclass.markInvalid,
   clearInvalid: Ext.form.Radio.superclass.clearInvalid
});

//Corrige bug do grid no IE6 que faz o grid ficar enorme e com erros na scrollbar
Ext.override(Ext.grid.GridView, {
   initTemplates: function() {
      var ts = this.templates || {};
      if (!ts.master) {
         ts.master = new Ext.Template('<div class="x-grid3" hidefocus="true">', '<div class="x-grid3-viewport">', '<div class="x-grid3-header"><div class="x-grid3-header-inner" style="{ostyle}"><div class="x-grid3-header-offset">{header}</div></div><div class="x-clear"></div></div>', '<div class="x-grid3-scroller"><div class="x-grid3-body" style="{bstyle}">{body}</div><a href="#" class="x-grid3-focus" tabIndex="-1"></a></div>', '</div>', '<div class="x-grid3-resize-marker">&nbsp;</div>', '<div class="x-grid3-resize-proxy">&nbsp;</div>', '</div>');
      }
      if (!ts.header) {
         ts.header = new Ext.Template('<table border="0" cellspacing="0" cellpadding="0" style="{tstyle}">', '<thead><tr class="x-grid3-hd-row">{cells}</tr></thead>', '</table>');
      }
      if (!ts.hcell) {
         ts.hcell = new Ext.Template('<td class="x-grid3-hd x-grid3-cell x-grid3-td-{id} {css}" style="{style}"><div {tooltip} {attr} class="x-grid3-hd-inner x-grid3-hd-{id}" unselectable="on" style="{istyle}">', this.grid.enableHdMenu ? '<a class="x-grid3-hd-btn" href="#"></a>': '', '{value}<img class="x-grid3-sort-icon" src="', Ext.BLANK_IMAGE_URL, '" />', '</div></td>');
      }
      if (!ts.body) {
         ts.body = new Ext.Template('{rows}');
      }
      if (!ts.row) {
         ts.row = new Ext.Template('<div class="x-grid3-row {alt}" style="{tstyle}"><table class="x-grid3-row-table" border="0" cellspacing="0" cellpadding="0" style="{tstyle}">', '<tbody><tr>{cells}</tr>', (this.enableRowBody ? '<tr class="x-grid3-row-body-tr" style="{bodyStyle}"><td colspan="{cols}" class="x-grid3-body-cell" tabIndex="0" hidefocus="on"><div class="x-grid3-row-body">{body}</div></td></tr>': ''), '</tbody></table></div>');
      }
      if (!ts.cell) {
         ts.cell = new Ext.Template('<td class="x-grid3-col x-grid3-cell x-grid3-td-{id} {css}" style="{style}" tabIndex="0" {cellAttr}>', '<div class="x-grid3-cell-inner x-grid3-col-{id}" unselectable="on" {attr}>{value}</div>', '</td>');
      }
      for (var k in ts) {
         var t = ts[k];
         if (t && typeof t.compile == 'function' && !t.compiled) {
            t.disableFormats = true;
            t.compile();
         }
      }
      this.templates = ts;
      this.colRe = new RegExp("x-grid3-td-([^\\s]+)", "");
   },
   updateAllColumnWidths: function() {
      var tw = this.getTotalWidth();
      var clen = this.cm.getColumnCount();
      var ws = [];
      for (var i = 0; i < clen; i++) {
         ws[i] = this.getColumnWidth(i);
      }
      this.innerHd.firstChild.style.width = this.getOffsetWidth();
      this.innerHd.firstChild.firstChild.style.width = tw;
      this.mainBody.dom.style.width = tw;
      for (var i = 0; i < clen; i++) {
         var hd = this.getHeaderCell(i);
         hd.style.width = ws[i];
      }
      var ns = this.getRows(),
      row,
      trow;
      for (var i = 0, len = ns.length; i < len; i++) {
         row = ns[i];
         row.style.width = tw;
         if (row.firstChild) {
            row.firstChild.style.width = tw;
            trow = row.firstChild.rows[0];
            for (var j = 0; j < clen; j++) {
               trow.childNodes[j].style.width = ws[j];
            }
         }
      }
      this.onAllColumnWidthsUpdated(ws, tw);
   },
   updateColumnWidth: function(col, width) {
      var w = this.getColumnWidth(col);
      var tw = this.getTotalWidth();
      this.innerHd.firstChild.style.width = this.getOffsetWidth();
      this.innerHd.firstChild.firstChild.style.width = tw;
      this.mainBody.dom.style.width = tw;
      var hd = this.getHeaderCell(col);
      hd.style.width = w;
      var ns = this.getRows(),
      row;
      for (var i = 0, len = ns.length; i < len; i++) {
         row = ns[i];
         row.style.width = tw;
         if (row.firstChild) {
            row.firstChild.style.width = tw;
            row.firstChild.rows[0].childNodes[col].style.width = w;
         }
      }
      this.onColumnWidthUpdated(col, w, tw);
   },
   updateColumnHidden: function(col, hidden) {
      var tw = this.getTotalWidth();
      this.innerHd.firstChild.style.width = this.getOffsetWidth();
      this.innerHd.firstChild.firstChild.style.width = tw;
      this.mainBody.dom.style.width = tw;
      var display = hidden ? 'none': '';
      var hd = this.getHeaderCell(col);
      hd.style.display = display;
      var ns = this.getRows(),
      row;
      for (var i = 0, len = ns.length; i < len; i++) {
         row = ns[i];
         row.style.width = tw;
         if (row.firstChild) {
            row.firstChild.style.width = tw;
            row.firstChild.rows[0].childNodes[col].style.display = display;
         }
      }
      this.onColumnHiddenUpdated(col, hidden, tw);
      delete this.lastViewWidth;
      this.layout();
   },
   afterRender: function() {
      this.mainBody.dom.innerHTML = this.renderRows() || '&nbsp;';
      this.processRows(0, true);
      if (this.deferEmptyText !== true) {
         this.applyEmptyText();
      }
   },
   renderUI: function() {
      var header = this.renderHeaders();
      var body = this.templates.body.apply({
         rows: '&nbsp;'
      });
      var html = this.templates.master.apply({
         body: body,
         header: header,
         ostyle: 'width:' + this.getOffsetWidth() + ';',
         bstyle: 'width:' + this.getTotalWidth() + ';'
      });
      var g = this.grid;
      g.getGridEl().dom.innerHTML = html;
      this.initElements();
      Ext.fly(this.innerHd).on("click", this.handleHdDown, this);
      this.mainHd.on("mouseover", this.handleHdOver, this);
      this.mainHd.on("mouseout", this.handleHdOut, this);
      this.mainHd.on("mousemove", this.handleHdMove, this);
      this.scroller.on('scroll', this.syncScroll, this);
      if (g.enableColumnResize !== false) {
         this.splitZone = new Ext.grid.GridView.SplitDragZone(g, this.mainHd.dom);
      }
      if (g.enableColumnMove) {
         this.columnDrag = new Ext.grid.GridView.ColumnDragZone(g, this.innerHd);
         this.columnDrop = new Ext.grid.HeaderDropZone(g, this.mainHd.dom);
      }
      if (g.enableHdMenu !== false) {
         if (g.enableColumnHide !== false) {
            this.colMenu = new Ext.menu.Menu({
               id: g.id + "-hcols-menu"
            });
            this.colMenu.on("beforeshow", this.beforeColMenuShow, this);
            this.colMenu.on("itemclick", this.handleHdMenuClick, this);
         }
         this.hmenu = new Ext.menu.Menu({
            id: g.id + "-hctx"
         });
         this.hmenu.add({
            id: "asc",
            text: this.sortAscText,
            cls: "xg-hmenu-sort-asc"
         },
         {
            id: "desc",
            text: this.sortDescText,
            cls: "xg-hmenu-sort-desc"
         });
         if (g.enableColumnHide !== false) {
            this.hmenu.add('-', {
               id: "columns",
               text: this.columnsText,
               menu: this.colMenu,
               iconCls: 'x-cols-icon'
            });
         }
         this.hmenu.on("itemclick", this.handleHdMenuClick, this);
      }
      if (g.trackMouseOver) {
         this.mainBody.on("mouseover", this.onRowOver, this);
         this.mainBody.on("mouseout", this.onRowOut, this);
      }
      if (g.enableDragDrop || g.enableDrag) {
         this.dragZone = new Ext.grid.GridDragZone(g, {
            ddGroup: g.ddGroup || 'GridDD'
         });
      }
      this.updateHeaderSortState();
   },
   onColumnWidthUpdated: function(col, w, tw) { // empty
   },
   onAllColumnWidthsUpdated: function(ws, tw) { // empty
   },
   onColumnHiddenUpdated: function(col, hidden, tw) { // empty
   },
   getOffsetWidth: function() {
      return (this.cm.getTotalWidth() + this.scrollOffset) + 'px';
   },
   renderBody: function() {
      var markup = this.renderRows() || '&nbsp;';
      return this.templates.body.apply({
         rows: markup
      });
   },
   hasRows: function() {
      var fc = this.mainBody.dom.firstChild;
      return fc && fc.nodeType == 1 && fc.className != 'x-grid-empty';
   }
});

//Override de validações de E-mail e url para aceitar hífen.
Ext.form.VTypes = function() {
   var alpha = /^[a-zA-Z_]+$/;
   var alphanum = /^[a-zA-Z0-9_]+$/;
   var email = /^([\w\-]+)(\.[\w\-]+)*@([\w\-]+\.){1,5}([A-Za-z]){2,4}$/;
   var url = /(((https?)|(ftp)):\/\/([\-\w]+\.)+\w{2,3}(\/[%\-\w]+(\.\w{2,})?)*(([\w\-\.\?\\\/+@&#;`~=%!]*)(\.\w{2,})?)*\/?)/i;
   return {
      'email': function(v) {
         return email.test(v);
      },
      'emailText': 'This field should be an e-mail address in the format "user@domain.com"',
      'emailMask': /[a-z0-9_\.\-@]/i,
      'url': function(v) {
         return url.test(v);
      },
      'urlText': 'This field should be a URL in the format "http:/' + '/www.domain.com"',
      'alpha': function(v) {
         return alpha.test(v);
      },
      'alphaText': 'This field should only contain letters and _',
      'alphaMask': /[a-z_]/i,
      'alphanum': function(v) {
         return alphanum.test(v);
      },
      'alphanumText': 'This field should only contain letters, numbers and _',
      'alphanumMask': /[a-z0-9_]/i
   };
} ();