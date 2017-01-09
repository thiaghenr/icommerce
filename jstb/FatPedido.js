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


FatPedido = function(){
    
Ext.form.Field.prototype.msgTarget = 'side';
Ext.form.FormPanel.prototype.bodyStyle = 'padding:5px';
Ext.form.FormPanel.prototype.labelAlign = 'right';
Ext.QuickTips.init();
	
	
var xgPedido = Ext.grid;
var winNTC;
var ncredito;
var vlcredito;

var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Favor elejir un pedido');
}

	FaturaPedido =  function(tipopgto){
	//console.info(tipopgto);
			     FormPedido.getForm().submit({
				        url: "../sistema/php/FatPedido.php",
                        params: {
						  user: id_usuario,
						  acao: 'Faturar',
                          idpedido: idpedidoFat,
                          idForma: idforma,
						  ncredito: ncredito,
						  tipopgto: tipopgto
						}
				    , waitMsg: 'Faturando'
				    , waitTitle : 'Aguarde....'
				    , scope: this
				    , success: OnSuccess
				    , failure: OnFailure
			     }); 
			function OnSuccess(form,action){
			     Ext.Msg.alert('Confirmacao', action.result.response);			
                 winPedido.hide();
                 dsFatPedido.reload();
				 winTipoPgto.hide();
				 
			}
			
			function OnFailure(form,action){
			//	alert(action.result.msg);
			}
			};

var action = new Ext.ux.grid.RowActions({
    header:'Credito'
 //  ,anchor: '10%'
  ,width: 50
  ,autoWidth: false
   ,actions:[{
       iconCls:'icon-delete'
      ,tooltip:'Usar Credito'
	//  ,width: 1
   }] 
});

action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	   idpedidofat = selectedKeys;
	  vlcredito = record.data.vlcredito;
	  devolvido = record.data.devolvido;
	  creditofinal = vlcredito - devolvido;
	  creditofinal = creditofinal.toFixed(2);
	  idcredito = record.data.idnota_credito;
	  ncredito = idcredito;
	  totalgeral = parseFloat(total_nota) - parseFloat(creditofinal);
	 // FormPedido.getForm().findField('labelnota').setText(ncredito); 
	 Ext.getCmp('labelnota').setText(ncredito);
	 Ext.getCmp('labelvalor').setText(creditofinal);
	 Ext.getCmp('totalfaturar').setText(totalgeral);
	  
	  winNTC.hide();
	 
   }
});


/////////////////////// INICIO STORE //////////////////////////////////
dsFatPedido = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: '../sistema/php/FatPedido.php',
        method: 'POST'
    }),   

reader:  new Ext.data.JsonReader({
			totalProperty: 'total',
			root: 'results',
			id: 'id',
			remoteSort: true,
			fields: [
					 {name: 'idPedido',  type: 'string', mapping: 'id' },
					 {name: 'CodCli',  type: 'string', mapping: 'controle_cli' },
                     {name: 'total_nota',  type: 'string' },
                     {name: 'idforma',  type: 'string' },
					 {name: 'ClienteEndereco',  type: 'string', mapping: 'endereco' },
					 {name: 'ClientePedido',  type: 'string', mapping: 'nome_cli' },
					 {name: 'totalPedido',  type: 'float', mapping: 'totalitens' },
					 {name: 'dataPedido',  type: 'string', mapping: 'data' },
					 {name: 'formaPago',  type: 'string', mapping: 'descricao'},
					 {name: 'NCredito',  type: 'string'},
					 {name: 'usuarioPedido',  type: 'string', mapping: 'nome_user' }
					 //{name: 'action1', type: 'string'},
   			         //{name: 'action2', type: 'string'}

					 ]
			})	,
			baseParams:{acao: 'listarPedidos'}
		})
///////////// FIM STORE ////////////////////////
///////////// INICIO DA GRID //////////////////

	     var gridFatPedido = new Ext.grid.GridPanel({
	        store: dsFatPedido, // use the datasource
	       cm: new xgPedido.ColumnModel([
		       
		        	//expander,
					{id:'CodCli', width:40, hidden: true, header: "CodCli",  sortable: true, dataIndex: 'CodCli'},
		            {id:'idPedido', width:40, header: "Pedido",  sortable: true, dataIndex: 'idPedido'},
					{id:'ClientePedido', width:130, header: "Cliente",  sortable: true, dataIndex: 'ClientePedido'},
					{id:'NCredito', width:130, header: "N Credito",  sortable: true, dataIndex: 'NCredito'},
					{id:'totalPedido', width:60, header: "Total", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'totalPedido'},
					{id:'dataPedido', width:60, header: "Data", align: 'right', sortable: true, dataIndex: 'dataPedido'},
					{id:'formaPago', width:40, header: "Forma Pago", align: 'right',  sortable: true, dataIndex: 'formaPago'},
					{id:'usuarioPedido', width:40, header: "Usuario",align: 'right',  sortable: true, dataIndex: 'usuarioPedido'}
					//action

					
		        ]), 
	        viewConfig:{ 
			forceFit:true
			},
			collapsible: true,
            id: 'gridFatPedido',
			animCollapse: false,
			enableColLock: false,
			loadMask:true,
			title: 'Pedidos Pendentes',
			closable: true,
			autoWidth:true,
			height: 300,
	        stripeRows:true,
			tbar : new Ext.Toolbar({
			align:'left',
         	buttons: [	
           				
					]
			}),
			bbar: new Ext.PagingToolbar({
				store: dsFatPedido,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Não tem dados",
				pageSize: 25,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina",    
				refreshText : "Atualizar",    
			//	paramNames : {start: 0, limit: 5},
				items:['-', '<b> * Duplo click para abrir</b>'  ]
			}),
			listeners:{
				destroy: function() {
                          // FormPedido.destroy();
			//		tabs.remove('FormPedido');	 
         				}
			         }
		});
		dsFatPedido.load({params:{acao: 'listarPedidos',start: 0, limit: 25}});
	
		 PedidoTemplate = 
		                  [
							'</br>'
							,'<b>Pedido: &nbsp;</b>{idPedido}<br/>'
							,'<b>Codigo: &nbsp;</b>{CodCli}&nbsp;&nbsp;'
							,'<b>Nome: &nbsp;</b>{ClientePedido}&nbsp;&nbsp;'
							,'<b>Endereco: &nbsp;</b>{ClienteEndereco}<br/>'
                            ,'<b>Total: &nbsp;</b>{total_nota}<br/>'
							,'</br>'
							];
                            
		PedidoTpl = new Ext.XTemplate(PedidoTemplate);
	

 		dsPedidoItens = new Ext.data.Store({
                url: '../sistema/php/FatPedido.php',
                method: 'POST',
        reader:  new Ext.data.JsonReader({
				root: 'Itens',
				//totalProperty: 'total',
				id: 'id',
				fields: [
				   {name: 'id'},
				   {name: 'refer_prod', mapping: 'referencia_prod'},
		           {name: 'desc_prod', mapping: 'descricao_prod'},
		           {name: 'qtd_produto', mapping: 'qtd_produto'},
                   {name: 'pr_venda', mapping: 'prvenda'},
                   {name: 'total_iten', mapping: 'total_iten'}
				
			]
			})
		});
         var gridFatItens = new Ext.grid.GridPanel({
	        store: dsPedidoItens, // use the datasource
	       cm: new xgPedido.ColumnModel([
		       
		            {id:'id', width:40, header: "id", hidden: true, sortable: true, dataIndex: 'id'},
					{id:'refer_prod', width:100, header: "Codigo",  sortable: true, dataIndex: 'refer_prod'},
					{id:'desc_prod', width:130, header: "Descricao",  sortable: true, dataIndex: 'desc_prod'},
					{id:'qtd_produto', width:60, header: "Qtd", align: 'right', sortable: true, dataIndex: 'qtd_produto'},
					{id:'pr_venda', width:80, header: "Valor", align: 'right',  sortable: true, dataIndex: 'pr_venda'},
					{id:'total_iten', width:80, header: "Total",align: 'right',  sortable: true, dataIndex: 'total_iten'}
		
		        ]), 
	        viewConfig:{ 
			forceFit:true
			},
			collapsible: false,
			animCollapse: false,
			enableColLock: false,
			loadMask:true,
			autoWidth:true,
			height: 150,
	        stripeRows:true
            
            });
	
	var formtplPedido = new Ext.Panel({
        frame:false,
        border: true,
		items:[]
	});
	

	var FormPedido = new Ext.FormPanel({
        title: '',
        id: 'FormPedidod',
    //    autoWidth: true,
    //    autoEl: 'div',
	//	layout:'form',
		closable:true,
		closeAction: 'hide',
        labelAlign: 'right',
        autoScroll: true,
        items: [ 
                formtplPedido,
                gridFatItens,           
                   {
					xtype:'moneyfield',
                    fieldLabel: 'Subtotal',
                    name: 'subtotalFat',
                    readOnly: true,
					disabled: true,
                    labelWidth: 50,
                    width: 100
                },
                
                {
                    xtype: 'moneyfield',
                    name: 'valor_entrada',
					id: 'valor_entrada',
                    fieldLabel: 'Valor Entrada',
					decimalPrecision : 2,
					style:'{text-align:right;}',
                    col: true,
                    labelWidth: 180,
                    width: 100,
                    allowBlank: false,
                    labelWidth: 100,
                    paddingLeft: 10,
                    enableKeyEvents: true,
                    listeners:{
                    keydown: function(e,type){						
					      CalculaTotal();
			             	}
                    }
                },
                {
                    xtype: 'moneyfield',
                    name: 'valor_debitar',
                    fieldLabel: '<b>Valor Nota</b>',
                    col: true,
                    labelWidth: 160,
					disabled: true,
                    readOnly: true,
                    labelAlign: 'right',
                    style: 'color: #E18325',
                    width: 100,
                    paddingLeft: 18
                },
				{
		xtype: 'fieldset',
		items:[
		{
		xtype: 'label',
		text: 'Nota Credito n: ',
		col: true,
		labelWidth: 5,
		style: 'font-weight:bold;color:blue;' 
		},
		{
		xtype: 'label',
		text: '',
		col: true,
		name: 'labelnota',
		id: 'labelnota',
		labelWidth: 20,
		style: 'font-weight:bold;color:blue;' 
		},
		{
		xtype: 'label',
		text: 'Valor: ',
		labelWidth: 5,
		style: 'font-weight:bold;color:blue;' 
		},
		{
		xtype: 'label',
		text: '',
		name: 'labelvalor',
		id: 'labelvalor',
		col: true,
		labelWidth: 20,
		style: 'font-weight:bold;color:blue;' 
		},
		{
		xtype: 'label',
		text: 'Total Faturar: ',
		labelWidth: 5,
		style: 'font-weight:bold;color:blue;' 
		},
		{
		xtype: 'label',
		text: '',
		name: 'totalfaturar',
		id: 'totalfaturar',
		col: true,
		labelWidth: 20,
		style: 'font-weight:bold;color:blue;' 
		}
		]
		},
		/*
                {
			     xtype: 'button',
			     id: 'faturar',
                 text: 'Faturar',
				 iconCls: 'icon-cambio',
                 scale: 'large',
				 disabled: true,
			     width: 20,
			     handler: function(){
					
					FaturaPedido(tipopgto);
			}
        },
		*/
		 {
			     xtype: 'button',
			     id: 'faturarTipo',
                 text: 'Facturar',
				 iconCls: 'icon-cambio',
                 scale: 'large',
			     width: 20,
			     handler: function(){
			     
					var abrewintipo = function(){Ext.Load.file('jstb/TipoPgto.js', function(obj, item, el, cache){tipoPgto();},this)}
					abrewintipo();
			
			}
        },
		{
		xtype: 'button',
        text: 'Importar N. Credito',
		align: 'left',
		col: true,
		scale: 'large',
        handler: function(){ // fechar	
     	NTCredito();
		}
		}
		
        ]
		});
winPedido = new Ext.Window({
		title: 'Faturar Pedido',
		width:700,
		autoHeight: true,
		shim:true,
		closable : true,
		resizable: false,
		closeAction: 'hide',
		draggable: true, //Movimentar Janela
		plain: true,
		modal: true, //Bloquear tela do fundo
		items:[FormPedido]
		
		});
winPedido.on('hide', function() {
	ncredito = "";
	Ext.getCmp('labelnota').setText('');
	Ext.getCmp('labelvalor').setText('');
  

});
        
        CalculaTotal = function(){
                       
           // entrada = FormPedido.getForm().findField('valor_entrada').getValue();
		   
			 entrada = Ext.getCmp('valor_entrada').getValue();
			 entrada = entrada.replace(",", ".");
			// console.info(entrada);
        }
	
	gridFatPedido.on('rowdblclick', function(grid, row, e) {  
					
	winPedido.show();
	
   PedidoTpl.overwrite(formtplPedido.body, dsFatPedido.getAt(row).data);
      
	idEnt = dsFatPedido.getAt(row).data.CodCli;
	//console.info(idEnt);
    idpedidoFat = dsFatPedido.getAt(row).data.idPedido;
    total_nota = dsFatPedido.getAt(row).data.total_nota;
    idforma = dsFatPedido.getAt(row).data.idforma;
    dsPedidoItens.load({params:{acao: 'listarItens',idpedido: idpedidoFat }});
    
	FormPedido.getForm().findField('valor_entrada').setDisabled(false);
    FormPedido.getForm().reset();
    FormPedido.getForm().findField('valor_entrada').focus();
    
	FormPedido.getForm().findField('subtotalFat').setValue(Ext.util.Format.usMoney(total_nota));
    if(idforma == '1' || idforma == '2' || idforma > '3'){
	FormPedido.getForm().findField('valor_debitar').setValue(Ext.util.Format.usMoney(total_nota));
    FormPedido.getForm().findField('valor_entrada').setDisabled(true);
    }

}); 

dsNTCredito = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: '../sistema/php/NotasCredito.php',
        method: 'POST'
    }),   

reader:  new Ext.data.JsonReader({
			root: 'results',
			id: 'idnota_credito',
			remoteSort: true,
			fields: [
					 {name: 'idnota_credito',  type: 'string' },
					 {name: 'idcliente',  type: 'string' },
                     {name: 'nome',  type: 'string' },
                     {name: 'dtlcto',  type: 'string' },
					 {name: 'vlcredito',  type: 'string'},
					 {name: 'devolvido',  type: 'string' },
					 {name: 'saldo', type: 'float'}
					 //{name: 'action1', type: 'string'},
   			         //{name: 'action2', type: 'string'}

					 ]
			})
		})
///////////// FIM STORE ////////////////////////
///////////// INICIO DA GRID //////////////////

	     var gridNTCredito = new Ext.grid.GridPanel({
	        store: dsNTCredito, // use the datasource
	       cm: new xgPedido.ColumnModel([
		       
		        	//expander,
		            {id:'idnota_credito', width:40, header: "Nota C",  sortable: true, dataIndex: 'idnota_credito'},
					{ width:50, header: "Cliente",  sortable: true, dataIndex: 'idcliente'},
					{ width:130, header: "Nombre",  sortable: true, dataIndex: 'nome'},
					{ width:80, header: "Data", align: 'right', sortable: true, dataIndex: 'dtlcto'},
					{ width:85, header: "Valor", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'vlcredito'},
					{ width:85, header: "Devolvido", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'devolvido'},
					{header: "Saldo", width: 100, align: 'right', sortable: true, dataIndex: 'totalcol', 
						renderer: function Cal(value, metaData, rec, rowIndex, colIndex, store) {
						return  Ext.util.Format.usMoney(rec.data.vlcredito - rec.data.devolvido);
						}
						},
					action

					
		        ]), 
	        viewConfig:{ 
			forceFit:true
			},
			plugins : action,
            id: 'gridFatPedido',
			animCollapse: false,
			enableColLock: false,
			loadMask:true,
			closable: true,
			autoWidth:true,
			height: 300,
	        stripeRows:true
	});

 NTCredito = function(){
 selectedKeys = gridFatPedido.selModel.selections.keys;
 if(selectedKeys.length > 0){		

 selectedRows = gridFatPedido.selModel.selections.items;
 selectedKeys = gridFatPedido.selModel.selections.keys; 


if (winNTC == null){
				winNTC = new Ext.Window({
					title       : 'Notas de Credito' 
					, id:'winNTC'
	                , layout: 'form'
	                , width: 600
					, autoHeight: true
	                , closeAction :'hide'
	                , plain: true
					, resizable: false
					, modal: true
					, items:[gridNTCredito]
					,buttons: [
								{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					winNTC.hide();
								}
  			 					}
							]					

				});
			}
winNTC.show();
dsNTCredito.load(({params:{'pedido': selectedKeys, 'acao': 'listarNotas'}}));
}
else{
selecione();
}			
}

	
     FormPedidosFaturar = new Ext.FormPanel({
			id: 'FormPedidosFaturar',
            title       : 'Pedidos Pendentes',
			labelAlign: 'left',
			frame		: true,
			closable:true,
            autoWidth   : true,
			//height	: 350,
            collapsible : false,
			layout:'form',
            items:[gridFatPedido],
            listeners:{
					destroy: function() {
							if(winNTC)
							 winNTC.destroy();
         				   }
		              }
            });
		
    Ext.getCmp('tabss').add(FormPedidosFaturar);
    Ext.getCmp('tabss').setActiveTab(FormPedidosFaturar);
    FormPedidosFaturar.doLayout();		
	

	
	
}



