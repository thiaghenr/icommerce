// JavaScript Document



/////////////////////////////////////// formar colunas, apenas ext3.x ////////////////////////////////////////////
Ext.override(Ext.form.FormPanel, {
	vIconSpace: 20,
	colSpace: 5,
	labelWidth: 100,
	ajustFields:function(ff){
		Ext.each(ff.items, function(f, i){
			if((f)&&(f.items)){
				this.ajustFields(f); //MODIFICADO
			}

			var c1 = ff.items[i]; //Campo atual
			var c2 = ff.items[i-1]; //Campo anterior

			if(c1&&c1.col&&c2){
				function confField(c){
					c.labelWidth = Ext.num(c.labelWidth, this.labelWidth); //Largura do Label
					c.vIconSpace = Ext.num(c.vIconSpace, this.vIconSpace); //Espaço após o campo
					c.colSpace   = Ext.num(c.colSpace,   this.colSpace); //Espaço antes do campo
					c.width      = Ext.num(c.width,      100); //Largura padrão MODIFICADO
					c.msgTarget  = c.msgTarget || this.msgTarget || Ext.form.Field.prototype.msgTarget;
					c.labelAlign = c.labelAlign || this.labelAlign;
				}

				function calcWidth(w){
					var x = w.width;
					x += (w.msgTarget == 'side' ? w.vIconSpace : 0);
					x += 5;
					x += (w.labelAlign == 'top' ? 0 : w.labelWidth);
					return x;
				}

				function createItem(field){
					return {
						width: calcWidth.createDelegate(this)(field),
						border: false,
						layout: 'form',
						labelWidth: field.labelWidth,
						items: field
					}
				}

				function addColum(c, field){
					c.items.push(createItem(field))
				}

				if(c2.layout!=='hbox'){
					confField.createDelegate(this)(c2);
					c2 = {
						xtype:'container',//MODIFICADO
						layout:'hbox',
						border:false,
						items:[createItem(c2)]
					}
				}
				confField.createDelegate(this)(c1);
				c2.items[c2.items.length-1].width += c1.colSpace;
				addColum(c2,c1);
				c1 = c2;
				c2 = 0;

				ff.items[i] = c1;
				ff.items[i-1] = c2;
			}
			delete c1;
			delete c2;
		},this)
		if(Ext.isArray(ff.items)){
			for(i in ff.items){
				ff.items.remove(0);
			}
		}
	},
	createForm:Ext.form.FormPanel.prototype.createForm.createInterceptor(function() {
		this.ajustFields(this);
	})
})
/*
//////////////////////////////////////formar colunas ext 2.x ///////////////////////////////
Ext.override(Ext.form.FormPanel, {
	ajustaFields:function(ff){
		Ext.each(ff.items, function(f, i){
			if((f)&&(f.items)){
				this.ajustaFields(f);
			}
			if(this.store){
				var r = this.store.fields.get(f.name);
			}
			if(r){
				if(typeof r.form == 'object'){
					Ext.apply(f,r.form);
				}
				if(!f.fieldLabel){f.fieldLabel = r.displayName;}
				f.maxLength = r.size || f.maxLength;
				f.xtype = f.xtype || r.xtype;
				if(!f.xtype){
					switch(r.type){
						case 'float': 
							f.xtype = 'numberfield';
						break
						case 'int': 
							f.xtype = 'numberfield';
							f.allowDecimals = false;
						break;
						case 'text': 
							f.xtype = 'textarea';
						break;
						case 'boolean':
						case 'bool': 
							f.xtype = 'xcheckbox';
						break;
						case 'date': 
							f.xtype = 'datefield';
						break;
						default: 
							f.xtype = 'textfield';
					}
					f.mask = r.mask;
					if(r.lookup){
						f.xtype = 'combo',
						f.triggerAction = r.triggerAction || 'all',
						f.minListWidth = r.minListWidth || 100,
						f.forceSelection = r.forceSelection == null ? true : r.forceSelection
						f.store = r.lookup,
						f.valueField = r.name,
						f.hiddenName = r.name,
						f.displayField = r.displayField || r.name,
						f.mode = r.mode || 'local',
						f.queryParam = f.displayField,
						f.typeAhead = true
					}
				}
			}
			 if(f && f.col){
				f.labelWidth  = (typeof f.labelWidth === 'number')  ? f.labelWidth : this.labelWidth||100;
				f.space       = (typeof f.space === 'number')       ? f.space : 25;
				f.paddingLeft = (typeof f.paddingLeft === 'number') ? f.paddingLeft : 5;
				
				ff.items[i-1].labelWidth  = (typeof ff.items[i-1].labelWidth === 'number')  ? ff.items[i-1].labelWidth : this.labelWidth||100;
				ff.items[i-1].space       = (typeof ff.items[i-1].space === 'number')       ? ff.items[i-1].space : 25;
				if(ff.items[i-1].layout=='column'){
					ff.items[i-1].items.push({
						//columnWidth:1,
						width: f.width ? f.width + 10 + (this.labelAlign == 'top' ? 0 : f.labelWidth) : f.width,
						border:false,
						layout:'form',
						labelWidth:f.labelWidth,
						style:'padding-left:5px;',
						items: f
					})
					ff.items[i] = 0;
				}else{
					ff.items[i] = {
						layout:'column',
						anchor:'100%',
						border:false,
						items:[{
							//columnWidth:1,
							width: ff.items[i-1].width ? ff.items[i-1].width + ff.items[i-1].space + (this.labelAlign == 'top' ? 0 : ff.items[i-1].labelWidth) : ff.items[i-1].width,
							border:false,
							layout:'form',
							labelWidth:ff.items[i-1].labelWidth,
							items: ff.items[i-1]
						},{
							//columnWidth:1,
							width: f.width ? f.width + f.space + 5 + (this.labelAlign == 'top' ? 0 : f.labelWidth) : f.width,
							border:false,
							layout:'form',
							labelWidth:f.labelWidth,
							style:'padding-left:'+f.paddingLeft+'px;',
							items: f
						}]
					}
					ff.items[i-1] = 0;
				}
				
			}
		},this)
		for(i in ff.items){
	/// aki estava dando erro ao add o arquivo CaixaGeral.js//		ff.items.remove(0);
	//ff.items.remove(0);
		}
	},
	createForm:Ext.form.FormPanel.prototype.createForm.createInterceptor(function() {
		this.ajustaFields(this);
	}),
	focusFirstEnabledField: function(){
		var i = this.getFirstEnabledField();
		if(i){
			i.focus(arguments);
		}
		return i;
	},
	getFirstEnabledField: function(){
		var x = null;
		Ext.each(this.form.items.items, function(i){
			if((!i.hidden)&&(!i.disabled)){
				x = i;
				return false;
			}
		},this)
		return x;
	}
})

//////////////////////////////////////////////// fim formar colunas /////////////////////////////////////////////////////
*/

/*
EXEMPLO DE USO

Ext.onReady(function(){
	Ext.form.Field.prototype.msgTarget = 'side';
	Ext.form.FormPanel.prototype.bodyStyle = 'padding:5px';
	Ext.form.FormPanel.prototype.labelAlign = 'right';
	Ext.QuickTips.init();

	var win = new Ext.Window({
		height: 210,
		width: 600,
		layout: 'fit',
		title: 'Override FormPanel, Colunas',
		items:[{
			xtype: 'form',
			labelWidth: 60,
			items: [{
				xtype: 'textfield',
				fieldLabel: 'Nome',
				allowBlank: false,
				width: 195
			},{
				xtype: 'textfield',
				fieldLabel: 'Sobrenome',
				allowBlank: false,
				labelWidth: 70,
				width: 195,
				col:true
			},{
				xtype: 'textfield',
				fieldLabel: 'Endereço',
				width: 490
			},{
				xtype: 'datefield',
				fieldLabel: 'Dt. Nasc.',
				width:100,
			},{
				xtype: 'datefield',
				fieldLabel: 'Dt. Cad.',
				allowBlank: false,
				labelWidth: 50,
				width:100,
				col:true
			},{
				xtype: 'combo',
				fieldLabel: 'Profissão',
				labelWidth: 50,
				width: 130,
				col:true
			},{
				xtype: 'textarea',
				fieldLabel: 'Obs.',
				width: 490,
				height: 50,
			}]
		}],
		buttons:[{
			text:'Salvar'
		},{
			text:'Cancelar'
		}]
	})
	win.show();
})
*/

////////////// MASCARA DE ESPERA ////////////////////////////////////
Ext.override(Ext.Element,{
	
	/**
	 * @author Bruno Tavares
	 * http://www.extdesenv.com.br
	 * 
	 * Mostra uma mensagem de carregando no elemento
	 * @param {Object} isLoading true para ativar a máscara e false para desativar
	 * @param {Object} cfg configurações adicionais: <ul><li>{String} text texto personalizado (default "Carregando...")</li><li>{Boolean} opaque true para deixar a máscara 100% opaca, impossibiliando a visualização de qualquer elemento atrás dela.</li></ul>
	 */
	setLoading:function( isLoading , cfg )
	{
		if( isLoading )
		{
			cfg = Ext.applyIf(cfg||{},{
				 text: Ext.LoadMask.prototype.msg
			});
		
			if(cfg.opaque == true)
				this.addClass('ext-ux-opaque');
			
			this.mask( cfg.text , 'x-mask-loading'  )
		}
		else
		{
			this.unmask();
			this.removeClass('ext-ux-opaque');
		}
	}
});
/////////////////////////FIM MASCARA DE ESPERA ///////////////////////




////////CORRIGIR PROBLEMA DO RADIOGROUP NAO PEGAR OS VALORES
Ext.override(Ext.form.CheckboxGroup, {
  getNames: function() {
    var n = [];

    this.items.each(function(item) {
      if (item.getValue()) {
        n.push(item.getName());
      }
    });

    return n;
  },

  getValues: function() {
    var v = [];

    this.items.each(function(item) {
      if (item.getValue()) {
        v.push(item.getRawValue());
      }
    });

    return v;
  },

  setValues: function(v) {
    var r = new RegExp('(' + v.join('|') + ')');

    this.items.each(function(item) {
      item.setValue(r.test(item.getRawValue()));
    });
  }
});

Ext.override(Ext.form.RadioGroup, {
  getName: function() {
    return this.items.first().getName();
  },

  getValue: function() {
    var v;

    this.items.each(function(item) {
      v = item.getRawValue();
      return !item.getValue();
    });

    return v;
  },

  setValue: function(v) {
    this.items.each(function(item) {
      item.setValue(item.getRawValue() == v);
    });
  }
});
//////////FIM ///////////////////////////////////////////////////////////////////


/*
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
*/