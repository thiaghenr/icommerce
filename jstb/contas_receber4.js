// JavaScript Document
// JavaScript Document
// Create user extensions namespace (Ext.ux)
Ext.ux.MoneyField = function(config){
                    var defConfig = {
                            autocomplete: 'off',
                            allowNegative: true,
                            format: 'us',
                            currency: '',
                            showCurrency: false
                    };
                    Ext.applyIf(config,defConfig);
        Ext.ux.MoneyField.superclass.constructor.call(this, config);
    };
    Ext.extend(Ext.ux.MoneyField, Ext.form.TextField,{
           
        /*initComponent:function() {
           
        },*/
   
            initEvents : function(){
            Ext.ux.MoneyField.superclass.initEvents.call(this);
                    this.el.on("keydown",this.stopEventFunction,this);
                    this.el.on("keyup", this.mapCurrency,this);
                    this.el.on("keypress", this.stopEventFunction,this);
        },
       
        KEY_RANGES : {
            numeric: [48, 57],
            padnum: [96, 105]
        },
       
        isInRange : function(charCode, range) {
            return charCode >= range[0] && charCode <= range[1];
        },
                 
        formatCurrency : function(evt, floatPoint, decimalSep, thousandSep) {                 
                floatPoint  = !isNaN(floatPoint) ? Math.abs(floatPoint) : 2;
                thousandSep = typeof thousandSep != "string" ? "" : thousandSep;
                decimalSep  = typeof decimalSep != "string" ? "." : decimalSep;
                var key = evt.getKey();    
               
            if (this.isInRange(key, this.KEY_RANGES["padnum"])) {
                key -= 48;
            }
                       
                this.sign = (this.allowNegative && (key == 45 || key == 109)) ? "-" : (key == 43 || key == 107 || key == 16) ? "" : this.sign;
               
                var character = (this.isInRange(key, this.KEY_RANGES["numeric"]) ? String.fromCharCode(key) : "");    
                    var field = this.el.dom;
                    var value = (field.value.replace(/\D/g, "").replace(/^0+/g, "") + character).replace(/\D/g, "");
                    var length = value.length;
                                                                                   
            if ( character == "" && length > 0 && key == 8) {
                    length--;
                    value = value.substr(0,length);
                    evt.stopEvent();
                    }
                   
            if(field.maxLength + 1 && length >= field.maxLength) return false;
           
            length <= floatPoint && (value = new Array(floatPoint - length + 2).join("0") + value);
            for(var i = (length = (value = value.split("")).length) - floatPoint; (i -= 3) > 0; value[i - 1] += thousandSep);
            floatPoint && floatPoint < length && (value[length - ++floatPoint] += decimalSep);
            field.value = (this.showCurrency && this.currencyPosition == 'left' ? this.currency : '' ) +
                                      (this.sign ? this.sign : '') +
                                      value.join("") +
                                      (this.showCurrency && this.currencyPosition != 'left' ? this.currency : '' );           
        },
         
        mapCurrency : function(evt) {       
            switch (this.format) {
                case 'BRL':
                    this.currency = '';
                    this.currencyPosition = 'left';
                    this.formatCurrency(evt, 2,',','.');
                    break;
                   
                case 'EUR':
                    this.currency = ' €';
                    this.currencyPosition = 'right';
                    this.formatCurrency(evt, 2,',','.');
                    break;
                   
                case 'USD':
                    this.currencyPosition = 'left';
                    this.currency = '';
                    this.formatCurrency(evt, 2);
                    break;
                   
                default:
                    this.formatCurrency(evt, 2);
            }
        },
   
            stopEventFunction : function(evt) {
            var key = evt.getKey();
           
            if (this.isInRange(key, this.KEY_RANGES["padnum"])) {
                key -= 48;
            }
           
            if ( (( key>=41 && key<=122 ) || key==32 || key==8 || key>186) && (!evt.altKey && !evt.ctrlKey) ) {
                            evt.stopEvent();
                    }
            },
           
            getCharForCode : function(keyCode){   
                    var chr = '';
                    switch(keyCode) {
                            case 48: case 96: // 0 and numpad 0
                                    chr = '0';
                                    break;
                           
                            case 49: case 97: // 1 and numpad 1
                                    chr = '1';
                                    break;
                           
                            case 50: case 98: // 2 and numpad 2
                                    chr = '2';
                                    break;
                           
                            case 51: case 99: // 3 and numpad 3
                                    chr = '3';
                                    break;
                           
                            case 52: case 100: // 4 and numpad 4
                                    chr = '4';
                                    break;
                           
                            case 53: case 101: // 5 and numpad 5
                                    chr = '5';
                                    break;
                           
                            case 54: case 102: // 6 and numpad 6
                                    chr = '6';
                                    break;
                           
                            case 55: case 103: // 7 and numpad 7
                                    chr = '7';
                                    break;
                           
                            case 56: case 104: // 8 and numpad 8
                                    chr = '8';
                                    break;
                           
                            case 57: case 105: // 9 and numpad 9
                                    chr = '9';
                                    break;
                           
                            case 45: case 189: case 109:
                                    chr = '-';
                                    break;
                           
                            case 43: case 107: case 187:
                                    chr = '+';
                                    break;
                           
                            default:
                                    chr = String.fromCharCode(keyCode); // key pressed as a lowercase string
                                    break;
                    }
                    return chr;
        }
    });
   
    Ext.ComponentMgr.registerType('moneyfield', Ext.ux.MoneyField);

Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
  
Ext.QuickTips.init();
Ext.form.Field.prototype.msgTarget = 'side';
	
ContReceber = function(){

 function renderVencimento(value, metadata, record, rowIndex, colIndex, store){
  if(record.data.diferenca > 0){
  return '<span style="color:red;font-weight: bold;">' + value + '</span>';
  }
  else{
  return '<span style="color:blue;font-weight: bold;">' + value + '</span>';
  }
}

function getRowClass(record) {
    if (record.data.diferenca > 0) {
        return 'red';
    }
    
   
    return 'default-color';
}

function MudaCor(row, index) {
      if (row.data.diferenca > 0) { // change é o nome do campo usado como referência
         return '#dfdfdf';
      }
   }
  
//Mudar cor da linha, aplicar o gridview
/*
function MudaCor(row, index) {
      if (row.data.diferenca > 0) { // change 顯 nome do campo usado como refer믣ia
         return 'cor';
      }
   } 
   */
var action = new Ext.ux.grid.RowActions({
    header:'Action'
   ,autoWidth: false
   ,width: 100
   ,actions:[{
       iconCls:'icon-checked'
      ,tooltip:'Receber'
	  ,text: 'Recibir'
	  ,width: 30
	  },
	  {
       iconCls:'icon-search'
      ,tooltip:'Visualisar'
	  ,text: 'Pagados'
	  ,width: 30
	  ,handler: {
	  	  }
	  },
	  {
       iconCls:'icon-delete'
      ,tooltip:'Devolver'
	  ,text: 'Devolver'
	  ,width: 30
	  ,handler: {
	  	  }
	  }
	  ] 
});

dsRecCli = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/rec_cli_parcial.php',
			method: 'POST'
		}),   
		baseParams:{acao: "listarDados"},
		reader:  new Ext.data.JsonReader({
			root: 'result',
			totalProperty: 'total',
			id: 'contas_rec_id'
		},
			[
				{name: 'contas_rec_id'},
				{name: 'pedido_id'},
				{name: 'datapg',  dateFormat: 'd-m-Y'},
				{name: 'usuarioid'},				
				{name: 'user_id'},
				{name: 'valorpg'}
			]
		),
		sortInfo: {field: 'nome', direction: 'ASC'},
		remoteSort: true		
	});

var cm = new Ext.grid.ColumnModel([
		new Ext.grid.RowNumberer(),
		    {id: 'contas_rec_id', dataIndex: 'contas_rec_id',header: 'Controle',width: 50,hidden: false},	
		    {dataIndex: 'pedido_id',header: 'Nº Pedido',align: 'right',width: 125},	
			{dataIndex: 'datapg',header: 'Data',width: 150,align: 'right'},
			{dataIndex: 'usuarioid',header: 'User',width: 120,align: 'right'},			
			{dataIndex: 'valorpg',	header: 'Valor',width: 145,align: 'right',renderer: Ext.util.Format.usMoney}
		]);
cm.defaultSortable = true;
var grid_recCliParcial = new Ext.grid.EditorGridPanel({
		id: 'grid_recCliParcial',
		ds: dsRecCli,
		cm: cm,
		enableColLock: false,
		loadMask: true,
		stripeRows: true,
		autoScroll:true,
		//plugins: [checkColumn],
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		width:'100%',
		height:137,
		bbar : new Ext.Toolbar({ 
			items: [ 	            
           				{
						xtype:'button',
           			    text: 'Recibo',
						tooltip: 'Imprimir Recibo al Cliente!',
						align: 'left',
						iconCls: 'icon-pdf',
            			handler: function(){ // fechar	
							var idPgr = grid_recCliParcial.selModel.selections.keys; 
							if(idPgr.length > 0){
								var win_pgr_cli = new Ext.Window({
								title: 'Relatorio Cliente',
								width: 650,
								height: 450,
								shim: false,
								animCollapse: false,
								constrainHeader: true,
								maximizable: false,
								layout: 'fit',
								items: { html: "<iframe height='100%' width='100%' src='../pdf_recibo.php?idPgr="+idPgr+"' > </iframe>" },
								buttons: [
										{
										text: 'Cerrar',
										handler: function(){ // fechar	
										win_pgr_cli.hide();
										}
					 
									}]
						});
						win_pgr_cli.show();
						}
						else{
						Ext.MessageBox.alert('Aviso','Seleccione una linea.' /*aki uma funcao se necessario*/);
						}
				}
			}
			] 
	   })
	});
grid_recCliParcial.on('rowclick', function(grid, row, e) {
			recordpgr = grid_recCliParcial.getSelectionModel().getSelected();
			 idPgr = grid_recCliParcial.getColumnModel().getDataIndex(0); // Get field name
			 idPgr = recordpgr.get(idPgr);	
			
		//	storeContRec.load(({params:{'acao': 'ListaLcto', 'idCli' : idCli }}));			
		//	storeContRec.baseParams.idCli = idCli;
		//	storeContRec.load();
}); 	

dsPagosCli = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/rec_cli_parcial.php',
			method: 'POST'
		}),   
		baseParams:{acao: "listarDados"},
		reader:  new Ext.data.JsonReader({
			root: 'result',
			totalProperty: 'total',
			id: 'contas_rec_id'
		},
			[
				{name: 'contas_rec_id'},
				{name: 'id'},
				{name: 'pedido_id'},
				{name: 'datapg',  dateFormat: 'd-m-Y'},
				{name: 'usuarioid'},				
				{name: 'user_id'},
				{name: 'valorpg'}
			]
		),
		sortInfo: {field: 'nome', direction: 'ASC'},
		remoteSort: true		
	});

var cmp = new Ext.grid.ColumnModel([
		new Ext.grid.RowNumberer(),
			{id: 'contas_rec_id', dataIndex: 'contas_rec_id', hidden: true, header: 'contas_rec_id',align: 'right',width: 125},	
			{dataIndex: 'pedido_id',header: 'Nº Pedido',align: 'right',width: 125},	
		    {dataIndex: 'id',header: 'Pagare',width: 50,hidden: false},	
			{dataIndex: 'datapg',header: 'Data',width: 150,align: 'right'},
			{dataIndex: 'usuarioid',header: 'User',width: 120,align: 'right'},			
			{dataIndex: 'valorpg',	header: 'Valor',width: 145,align: 'right',renderer: Ext.util.Format.usMoney}
		]);
cmp.defaultSortable = true;
var grid_pagos = new Ext.grid.EditorGridPanel({
		id: 'grid_pagos',
		ds: dsPagosCli,
		cm: cmp,
		enableColLock: false,
		loadMask: true,
		stripeRows: true,
		autoScroll:true,
		//plugins: [checkColumn],
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		width:'100%',
		height:137,
		bbar : new Ext.Toolbar({ 
			items: [ 	            
           				{
						xtype:'button',
           			    text: 'Recibo',
						tooltip: 'Imprimir Recibo al Cliente!',
						align: 'left',
						iconCls: 'icon-pdf',
            			handler: function(){ // fechar	
							var idPgr = grid_pagos.selModel.selections.keys; 
							if(idPgr.length > 0){
								var win_pgr_cli = new Ext.Window({		
								title: 'Relatorio Cliente',
								width: 650,
								height: 450,
								shim: false,
								animCollapse: false,
								constrainHeader: true,
								maximizable: false,
								layout: 'fit',
								items: { html: "<iframe height='100%' width='100%' src='../pdf_recibo.php?idPgr="+idPgr+"' > </iframe>" },
								buttons: [
										{
										text: 'Cerrar',
										handler: function(){ // fechar	
										win_pgr_cli.hide();
										}
					 
									}]
						});
						win_pgr_cli.show();
						}
						else{
						Ext.MessageBox.alert('Aviso','Seleccione una linea.' /*aki uma funcao se necessario*/);
						}
				}
			}
			] 
	   })
	});


action.on({
   action:function(grid, record, action, row, col) {
    //Ext.Msg.alert('Ação', String.format('acao: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  
	 //console.info(record);
	  idpedidoFat = record.data.pedido_id; 
	  idPagare = record.data.id;
	  idVenda = record.data.venda_id;
	  nomeReceber = record.data.nome;
	  totalDevedor = Ext.util.Format.usMoney(parseFloat(record.data.vl_parcela)  - (parseFloat(record.data.desconto) + parseFloat(record.data.valor_recebido)) );
	  if(action == 'icon-checked'){
		winRecValor.show();
		formRecValor.getForm().findField('ClienteRec').setValue(nomeReceber);
		formRecValor.getForm().findField('vlTotal').setValue(totalDevedor);
		}
		if(action == 'icon-search'){
					var win_rec = new Ext.Window({
					title: 'Recebimentos',
					closable: false,
					width: 650,
					height: 200,
				//	shim: false,
					animCollapse: false,
				//	constrainHeader: true,
					maximizable: false,
					layout: 'form',
					items:[grid_recCliParcial] ,
					buttons:[
           					{
            				text: 'Cerrar',
            				handler: function(){ // fechar	
     	    				win_rec.hide();
  			 				}
        					}]
				});
				win_rec.show();
				dsRecCli.baseParams.id = idPagare;
			    dsRecCli.load();
			}
			if(action == 'icon-delete'){
				var ImpCredito = function(){Ext.Load.file('jstb/ImpNotaCredito.js', function(obj, item, el, cache){ImpCreditos(idpedidoFat,ContReceber);},this)}
					ImpCredito();
			}
		}
});


function acertaValor(val){
        if(val <= 0){
            val = '$'+ 0.00;
        }else {
            val = '$'+val;
        }
        return val;
    };
var juro;

////////////////////////////////////////////////////////////////////////////
var dsContRec = new Ext.data.GroupingStore({
		proxy: new Ext.data.HttpProxy({
			url: 'php/contas_receber.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Clientes',
			totalProperty: 'totalClientes',
			id: 'controle_cli'
		},
			[
			{name: 'controle'},
		    {name: 'nome'},
		    {name: 'ruc'},
			{name: 'diferenca'},
		    {name: 'telefonecom'},
		    {name: 'valor_parcela'}
			]
		),
		sortInfo: {field: 'controle_cli', direction: 'ASC'},
		remoteSort: true		
	});
	
//////// FIM STORE DOS PRODUTOS //////////////
Ext.grid.GroupSummary.Calculations['totalGeral'] = function(v, record, field){
		return v + (parseFloat(record.data.juros) + parseFloat(record.data.vl_parcela) - parseFloat(record.data.descontos) - parseFloat(record.data.totalpago));
    }
 
//////// INICIO DA GRID DOS PRODUTOS ////////
 var gridContRec = new Ext.grid.EditorGridPanel(
	    {
	        store: dsContRec, // use the datasource
	        
	        columns:
		        [
						{header:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'controle'},
						{header: "Nome", width: 230, sortable: true, dataIndex: 'nome'},
						{header: "Ruc", width: 80, align: 'left', sortable: true, dataIndex: 'ruc'},
						{header: "Fone", width: 100,  align: 'left',  sortable: true, dataIndex: 'telefonecom'},
						{header: "Total", width: 100, align: 'right', sortable: true, dataIndex: 'valor_parcela',renderer: 'usMoney'},
						{width: 80, hidden: true, sortable: true, dataIndex: 'diferenca'}
			
			 ],
	        viewConfig:{
			forceFit:true,
			getRowClass: function(record) { return getRowClass(record); }
			},
			width:'100%',
			height: 280,
			ds: dsContRec,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			listeners:{ 
        	afteredit:function(e){
			dsContRec.load(({params:{pesquisa: e.value, campo: e.column,  'start':0, 'limit':200}}));
	  		},
			afterrender: function(e){
   			//gridContRec.getSelectionModel().selectFirstCell();
			
			}
			},
			bbar : new Ext.Toolbar({ 
			items: [ 	            
           				{
						xtype:'button',
           			    text: 'Relatorio Cliente',
						tooltip: 'Imprimir Relatorio do Cliente!',
						id: 'PrintReceber',
						align: 'left',
						iconCls: 'icon-user',
            			handler: function(){ // fechar	
     	    			var win_rel_cli = new Ext.Window({
						id: 'helps',
						title: 'Relatorio Cliente',
						width: 650,
						height: 500,
						shim: false,
						animCollapse: false,
						constrainHeader: true,
						maximizable: false,
						layout: 'fit',
						items: { html: "<iframe height='100%' width='100%' src='../relatorio_cli.php?cli="+idCli+"' > </iframe>" },
						buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_rel_cli.destroy();
  			 					}
			 
        					}]
				});
				win_rel_cli.show();
				}
			},
			/*
			{
						xtype:'button',
           			    text: 'Relatorio Geral',
						tooltip: 'Imprimir Relatorio Sintetico!',
						align: 'left',
						iconCls: 'icon-users',
            			handler: function(){ // fechar	
     	    			var win_rel_geral = new Ext.Window({
						title: 'Relatorio Sintetico',
						width: 650,
						height: 500,
						shim: false,
						animCollapse: false,
						constrainHeader: true,
						maximizable: false,
						layout: 'fit',
						items: { html: "<iframe height='100%' width='100%' src='../relatorio_cli_geral.php' > </iframe>" },
						buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_rel_geral.destroy();
  			 					}
			 
        					}]
				});
				win_rel_geral.show();
				}
			},
			*/
			{
						xtype:'button',
           			    text: 'Relatorio Analitico',
						tooltip: 'Imprimir Relatorio Analitico!',
						align: 'left',
						iconCls: 'icon-users',
            			handler: function(){ // fechar	
     	    			var win_rel_analitico = new Ext.Window({
						title: 'Relatorio Analitico',
						width: 650,
						height: 500,
						shim: false,
						animCollapse: false,
						constrainHeader: true,
						maximizable: false,
						layout: 'fit',
						items: { html: "<iframe height='100%' width='100%' src='../relatorio_cli_analitico.php' > </iframe>" },
						buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_rel_analitico.destroy();
  			 					}
			 
        					}]
				});
				win_rel_analitico.show();
				}
			}
			] 
	   }),
	   tbar : new Ext.Toolbar({ 
			items: [
			
			{
			xtype: 'label',
			text: 'Localizar Nombre: ',
			style: 'font-weight:bold;color:yellow;text-align:left;' 
			},
			{
			xtype:'textfield',
			fieldLabel: 'Cliente',
			name: 'ClienteLoc',
			id: 'ClienteLoc',
			width: 250,
			fireKey: function(e,type){
							if(e.getKey() == e.ENTER && Ext.get('ClienteLoc').getValue() != '') {
								controle = Ext.getCmp('ClienteLoc').getValue();
					  			setTimeout(function(){
                      			dsContRec.load({params: {query: controle, acao: 'ListaContas'}});
								 }, 250);
							}
						}
			}
			]
		})
		
});
dsContRec.load(({params:{acao:'ListaContas', 'start':0, 'limit':200}}));
//////////////////////FIM GRID DOS CLIENTES A RECEBER /////////////////////////////////////


///COMECA A GRID DAS FATURAS ///////////////////////////////////////////////
	  var storeContRec = new Ext.data.GroupingStore({
      proxy: new Ext.data.HttpProxy({method: 'POST', url: 'php/contas_receber.php'}),
      groupField:'nome',
      sortInfo:{field: 'id', direction: "DESC"},
      reader: new Ext.data.JsonReader({
		 totalProperty: 'total',
	     root:'Facturas',
	     fields: [
			{name: 'id'},
			{name: 'nome'},
			{name: 'diferenca'},
			{name: 'pedido_id'},
			{name: 'dt_vencimento', mapping: 'dt_vencimento'},
			{name: 'dt_lancamento', mapping: 'dt_lancamento'},
			{name: 'total_parcelas',  mapping: 'nm_total_parcela'},
			{name: 'vl_ntcredito',  mapping: 'vl_ntcredito'},
			{name: 'venda_id', mapping: 'venda_id'},
			{name: 'vl_parcela', type: 'float'},
	        {name: 'desconto', type: 'float'},
            {name: 'valor_juros', type: 'float'},
			{name: 'perc_juros', type: 'float'},
			{name: 'valor_recebido', type: 'float'},
			{name: 'totals'},
			{name: 'totalGeral'},
			{name: 'action', type: 'string'},
			{name: 'statuss', align: 'center', mapping: 'status'}
 			]
		})
   });
   
   function formataPagar(value){
        return value == 1 ? 'Sim' : 'Não';  
    };
	
	
	
var gridFormContRec = new Ext.BasicForm(
		Ext.get('form4'),
		{
			});
    // define a custom summary function
    Ext.grid.GroupSummary.Calculations['totalGeral'] = function(v, record, field){
		var juro = record.data.valor_juros;
		if(juro < 0)
		juro = 0;
return v + ( parseFloat(record.data.vl_parcela) - ( parseFloat(record.data.desconto) + parseFloat(record.data.valor_recebido) + parseFloat(record.data.vl_ntcredito) ) );
    }

    var summary = new Ext.grid.GroupSummary(); 
    var gridFormContRec = new Ext.grid.EditorGridPanel({
	    store: storeContRec,
		//layout: 'column',
		enableColLock: true,
		containerScroll  : false,
		loadMask: {msg: 'Carregando...'},
        columns: [
			action,
		//	{header: "Selecionar", dataIndex: 'statuss',fixed:true,width: 50,editor: new Ext.grid.GridEditor(new Ext.form.Checkbox())},
			{header: "Pagare",name: 'id',sortable: true,align: 'left',dataIndex: 'id',hidden: true,width: 10},
			{header: "Pedido",name: 'pedido_id',sortable: true,align: 'left',dataIndex: 'pedido_id',width: 50},
			{id: 'dt_lancamento',header: "Lancamento",width: 70,sortable: true,dataIndex: 'dt_lancamento',fixed:true,hideable: false},
			{id: 'dt_vencimento',header: "Vencimento",width: 70,sortable: true,dataIndex: 'dt_vencimento',renderer: renderVencimento,hideable: false,summaryType: 'count',
				summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '(' + v +' Facturas)' : '(1 Factura)');
                }
            },
			{header: "Quotas",name: 'total_parcelas',sortable: true,align: 'left',dataIndex: 'total_parcelas',width: 50},
			{header: "nome",name: 'nome',sortable: true,dataIndex: 'nome'},
			{id: 'venda_id',header: "Venda",sortable: true,align: 'left',dataIndex: 'venda_id',width: 50,hidden: false},
			{header: "Valor Quota",width: 50,align: 'right',sortable: true,dataIndex: 'vl_parcela',summaryType:'sum',renderer : function(v){
                    return Ext.util.Format.usMoney(v);   
                }
            },
			{header: "Desconto",width: 50,align: 'right',sortable: true,dataIndex: 'desconto',summaryType:'sum',renderer : function(v){
                    return Ext.util.Format.usMoney(v);   
                },
				editor: new Ext.form.NumberField({
						allowBlank : false,
						selectOnFocus:true,
						allowNegative: false
			    })
             },
			{header: "Devolucion",name: 'vl_ntcredito',sortable: true,align: 'right',renderer: Ext.util.Format.usMoney,dataIndex: 'vl_ntcredito',width: 50},
			{header: "Taxa mes %",width: 10,align: 'right',sortable: true,dataIndex: 'perc_juros',renderer: Ext.util.Format.usMoney,hidden: true},
			{header: 'Interes',width: 10,align: 'right',dataIndex: 'valor_juros',name: 'valor_juros',id: 'valor_juros',hidden: true,renderer : function(v){
					var parcela = v;
					if(parcela < 0)
						parcela = 0.00;					
                    return Ext.util.Format.usMoney(parcela);   
                }
			},
			new Ext.ux.MaskedTextField({
			header: 'Recebido',width: 50,align: 'right',iconCls: 'user-red',mask:'decimal',textReverse : true,dataIndex: 'valor_recebido',name: 'valor_recebido',renderer: 'usMoney',
				summaryType:'sum',
				renderer : function(v){
                    return Ext.util.Format.usMoney(v);   
                }
			}),
			{dataIndex: 'totals',id: 'totals',header: "Total",name: 'totals',width: 55,align: 'right',sortable: false,groupable: false,renderer: function(v, params, record){
                var v = Ext.util.Format.usMoney( parseFloat(record.data.vl_parcela)  - (parseFloat(record.data.desconto) + parseFloat(record.data.valor_recebido) + parseFloat(record.data.vl_ntcredito)) );
				return v;
				},
			name: 'totalGeral',dataIndex: 'totalGeral',summaryType:'totalGeral',summaryRenderer: Ext.util.Format.usMoney},
			{name: 'diferenca',sortable: true,align: 'left',dataIndex: 'diferenca',hidden: true}
			],
        view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true
        }),

        plugins: [summary,action],
        frame:true,
        width: '100%',
       // height: 172,
	    autoHeight: true,
		border: false,
        clicksToEdit: 1,
		//selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
       // collapsible: false,
       // animCollapse: false,
       // trackMouseOver: false,
       // enableColumnMove: true,
		//stripeRows: false,
		autoScroll:true,
        iconCls: 'icon-grid',
		bbar : new Ext.Toolbar({ 
			items: [
					 {
						xtype:'button',
           			    text: 'Pagos Anteriores',
						tooltip: 'Ver Pagos Anteriores',
						align: 'left',
						iconCls: 'icon-grid',
            			handler: function(){ 
						//	var idCli = gridContRec.selModel.selections.keys; 
							if(idCli.length > 0){
								var winPagos = new Ext.Window({
								title: 'Listado de cuentas quitadas',
								width: 650,
								height: 350,
								shim: false,
								animCollapse: false,
								constrainHeader: true,
								maximizable: false,
								layout: 'fit',
								items: [grid_pagos],
								buttons: [
										{
										text: 'Cerrar',
										handler: function(){ // fechar	
										winPagos.hide();
										}
					 
									}]
						});
						winPagos.show();
						dsPagosCli.load(({params:{'acao': 'ListaPagos', 'idCli' : idCli }}));	
						}
						else{
						Ext.MessageBox.alert('Aviso','Seleccione un cliente.' /*aki uma funcao se necessario*/);
						}
						
						}
					}
				] 
		}),
		listeners:{ 
        afteredit:function(e){
           var params = {
               id: e.record.get('id'),
               valor: e.value,
			   campo: e.column,
			   acao: 'desconto',
			   venda: e.record.get('venda_id')
            };
			Ext.Ajax.request({
            url: 'php/contas_receber.php',
			params: params,		
			
			success: function(result, request){//se ocorrer correto 
			var jsonData = Ext.util.JSON.decode(result.responseText);
			if(jsonData.response == 'ValorMaior'){
							Ext.MessageBox.alert('Aviso','Valor Maior que a Duplicata.' /*aki uma funcao se necessario*/);
                            storeContRec.reload(); 
							};
			if(jsonData.response == 'Recebido'){
							Ext.MessageBox.alert('Aviso','Recebido.' /*aki uma funcao se necessario*/);
                            storeContRec.reload(); 
							};
			if(jsonData.response == 'Desconto'){
							Ext.MessageBox.alert('Aviso','Desconto Concedido.' /*aki uma funcao se necessario*/);
                            storeContRec.reload(); 
							};
			if(jsonData.response == 'DescontoCancel'){
							Ext.MessageBox.alert('Aviso','Desconto nao permitido !' /*aki uma funcao se necessario*/);
                            storeContRec.reload(); 
							};
						   
                        },
			failure: function(){
                           Ext.example.msg('Erro','N&atilde;o foi possivel Alterar.');
                           storeContRec.rejectChanges();
                        }
         }) 
			
      }}
	//}
});
///TERMINA A GRID	
gridContRec.on('rowdblclick', function(grid, row, e) {
			record = gridContRec.getSelectionModel().getSelected();
			 idName = gridContRec.getColumnModel().getDataIndex(0); // Get field name
			 idCli = record.get(idName);	
			
			storeContRec.load(({params:{'acao': 'ListaLcto', 'idCli' : idCli }}));			
		//	storeContRec.baseParams.idCli = idCli;
		//	storeContRec.load();
		//console.info(idCli);
}); 

	BaixaConta = function(origem,ncredito){
		if(origem != "NTCredito"){
			caixapgto = formRecValor.getForm().findField('caixapagoconta').getValue();
					
		}
		else{
		caixapgto = "";
		}
		if(typeof jsonCheq == 'undefined')
			jsonCheq = "[]";
		if(caixapgto == "cheque" && jsonCheq == "[]")
				Ext.MessageBox.alert('Aviso','Cheque no Informado.');	
		Ext.Ajax.request({ 
			waitMsg: 'Executando...',
			url: 'php/contas_receber.php',
			params: { 
				idPagare: idPagare,
				idVenda: idVenda,
				acao: 'Receber',
				origem: origem,
				ncredito: ncredito, 
				caixapgto: caixapgto,
				jsonCheq: jsonCheq,
				valor: formRecValor.getForm().findField('vlReceber').getValue()
				},
			success: function(result, request){//se ocorrer correto 
				var jsonData = Ext.util.JSON.decode(result.responseText);
					if(jsonData.response){
						Ext.MessageBox.alert('Aviso',jsonData.response); //aki uma funcao se necessario);
						storeContRec.reload(); 
					};
					if(jsonData.response == 'Nopodesrecibir'){
						Ext.MessageBox.alert('Aviso','No podes recibir monto mayor que la deuda.'); //aki uma funcao se necessario);
					};
					if(jsonData.response == 'NopodesrecibirZero'){
						Ext.MessageBox.alert('Aviso','No podes recibir monto igual a cero o menor.'); //aki uma funcao se necessario);
					};
			}, 
			failure:function(response,options){
				Ext.MessageBox.alert('Alerta', 'Erro...');
			}         
		}) 
	}




  formRecValor = new Ext.FormPanel({
			split       : true,
			id: 'formRecValor',
			layout: 'form',
			frame       :true,
			items		: [
							{
							xtype:'textfield',
							fieldLabel: 'Cliente',
							name: 'ClienteRec',
							disabled: true
							},
							{
							xtype:'textfield',
							fieldLabel: 'Total', 
							name: 'vlTotal',
							disabled: true
							},
							{
							xtype:'moneyfield',
							fieldLabel: '<b>Valor Contado</b>',
							name: 'vlReceber',
							id: 'vlReceber',
							fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter 
										ctreceber = "ctreceber";
										origem = ctreceber;
										BaixaConta(origem);
											}	
										}  
							},
							{
							bodyStyle:'padding:0px 15px 0'
							},
							{
							xtype: 'radiogroup'
							,hideLabel: true
							,bodyStyle: 'padding-top: 10px;'
							,width: 300
							,items: [
								{
								boxLabel: 'Caja Usuario'
								, name: 'caixapagoconta'
								, inputValue: 'cxuser'
								, checked: true
								,listeners: {
									check: function (ctl, val) {
										if(val == true){
											jsonCheq = "[]";
										}
									}
								}
								},
								{
								boxLabel: 'Caja General'
								, name: 'caixapagoconta'
								, inputValue: 'cxempr'
								,listeners: {
									check: function (ctl, val) {
										if(val == true){
											jsonCheq = "[]";
										}
									}
								}
								}
								,
								{
								boxLabel: 'Cheque'
								, name: 'caixapagoconta'
								, inputValue: 'cheque'
								,listeners: {
									check: function (ctl, val) {
										if(val == true){
								var abrewinentradacheque = function(){Ext.Load.file('jstb/entrada_cheque_cr.js', function(obj, item, el, cache){ent_cheque(
								formRecValor.getForm().findField('vlReceber').getValue(),
								idPagare
								);},this)}
										abrewinentradacheque();
										}
									}
								}
								}	
							]
							}
						
							
						
						]
	  }); 
winRecValor = new Ext.Window({
		title: 'Contas A Receber',
		width:350,
		height:280,
		shim:true,
		closable : true,
		resizable: false,
		closeAction: 'hide',
		bodyStyle:{padding:'10px 10px 10px 10px'},
		draggable: true, //Movimentar Janela
		plain: true,
		modal: true, //Bloquear tela do fundo
		items:[
			formRecValor,
			{
			bodyStyle:'padding:0px 15px 0'
			},
			{
			xtype: 'button',
           	text: 'Grabar',
			align: 'left',
			iconCls: 'icon-save',
            handler: function(){ // fechar	
				ctreceber = "ctreceber";
				origem = ctreceber;
				BaixaConta(origem);
  			}
			}
			/*
			{
			xtype:'button',
			text: '<b>Con cheque</b>', 
			name: 'btncheque',
			iconCls:'icon-check',
			handler: function(){ // fechar	
     	    	Ext.Load.file('jstb/CadCheque.js', function(obj, item, el, cache){Cheques();},this);
  			}
			}
			*/
		],
		buttons: [
			{
            text: 'Cerrar',
            handler: function(){ // fechar	
     	    	winRecValor.hide();
				formRecValor.getForm().reset();
			}
  			}
		],	
		focus: function(){
 	    	formRecValor.getForm().findField('vlReceber').focus();
		}
		
	});
	
///////INICIO DO FORM /////////////////////////////////////////////////////////////////////
        var listaRec = new Ext.FormPanel({
            title       : 'Cartera Recibir',
			labelAlign: 'top',
            split       : true,
			closable: true,
			height		: 280,
            collapsible : false,
			autoScroll: true,
			items:[gridContRec,gridFormContRec],
			listeners: {
						destroy: function() {
						//	if(winRecValor )
                        //    winRecValor.destroy(); 
						//	winRecValor.reset();
						//	if(NovoMarca instanceof Ext.Window)
						//	NovoMarca.destroy(); 
         				}
			         }
        }); 
	
		
		
///////////////// FIM DO FORM ///////////////////////////////////////////////////




//winRecValor.show();

Ext.getCmp('tabss').add(listaRec);
Ext.getCmp('tabss').setActiveTab(listaRec);



	};



