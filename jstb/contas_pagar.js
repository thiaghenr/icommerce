// JavaScript Document
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


  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
  
  Ext.QuickTips.init();
  Ext.form.Field.prototype.msgTarget = 'side';
  
  	CtPagar = function(){
		
	if(perm.contas_pagar.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}

var geral;
var totalpp;
var ContPagar;									  
var winPagar;
var idData;
var totalProd;
//var FormParcial;
var xg = Ext.grid;
var win_ctpg;

 selecione = function(){
Ext.MessageBox.alert('Alerta', 'Por favor selecione um Proveedor');
}

 
function formataPagar(value){
        return value == 1 ? 'Sim' : 'Não';  
    };

var formataVlpago = function(value){
	if(value=='null')
		  value = 0.00;
};

function acertaValor(val){
        if(val <= 0){
            val = '$'+ 0.00;
        }else {
            val = '$'+val;
        }
        return val;
    };
var CorTotal = function(value){
    return  '<span style="color: #E5872C;">'+value+'</span>'; 
}

///COMECA A GRID /////
	  var storePagar = new Ext.data.GroupingStore({
      proxy: new Ext.data.HttpProxy({
	  method: 'POST',
	  url: '../sistema/php/contas_pagar.php'
	  }),
	  
      groupField:'nome',
      sortInfo:{field: 'ctproveedor_id', direction: "ASC"},
      reader: new Ext.data.JsonReader({
		 totalProperty: 'total',
	     root:'result',
	     fields: [
			{name: 'idcp'},
			{name: 'compra_id',  mapping: 'compra_id'},
			{name: 'ctproveedor_id', mapping: 'idprov'},
	        {name: 'nome'},
            {name: 'nome_cli'},
            {name: 'description'},
            {name: 'vl_total_fatura'},
            {name: 'vl_parcela'},
			{name: 'num_fatura'},
			{name: 'nm_parcela'},
            {name: 'totalpago'},
			{name: 'vencimento', dateFormat: 'd-m-Y'},
			{name: 'juros', type:'float',  mapping: 'vl_juro'},
			{name: 'descontos', type:'float', mapping: 'vl_desconto'},
			{name: 'totals'},
			{name: 'totalGeral', type:'float'}
		//	{name: 'statuss', align: 'center', mapping: 'status', type:'boolean'}
 		]
		})
   });
   
   function MudaCor(row, index) {
		if (row.data.totalGeral < 40) {
			return 'cor';
		}
	}
	
   storePagar.load();
var gridForm = new Ext.BasicForm(
		Ext.get('form2'),
		{
			});
   
    // define a custom summary function
    Ext.grid.GroupSummary.Calculations['totalGeral'] = function(v, record, field){
		var TotalDevidoForn =+ record.data.totalpago;
		return v + (parseFloat(record.data.juros) + parseFloat(record.data.vl_parcela) - parseFloat(record.data.descontos) - parseFloat(TotalDevidoForn));  
    }

    var summary = new Ext.grid.GroupSummary(); 
    var grid_forn = new Ext.grid.EditorGridPanel({
	    store: storePagar,
		//layout: 'column',
		enableColLock: true,
		containerScroll  : false,
	    loadMask: {msg: 'Carregando...'},
        columns: [
			
			{id: 'idcp', header: "idcp", sortable: true, dataIndex: 'idcp', fixed:true,	hidden: true },
			{id: 'ctproveedor_id', header: "ctproveedor_id", sortable: true, dataIndex: 'ctproveedor_id', fixed:true, hidden: true},
            {id: 'idprov', header: "Proveedores", width: 100, sortable: true, dataIndex: 'nome_cli', summaryType: 'count', fixed:true, hideable: false,
                summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '(' + v +' Compras)' : '(1 Compra)');
                }
            },
			{header: "nome", name: 'nome', sortable: true, dataIndex: 'nome', fixed:true, expand: false},
			{id: 'compra_id', header: "Compra", sortable: true, align: 'right', dataIndex: 'compra_id', fixed:true, width: 80, hidden: false},
			{id: 'num_fatura', header: "N.Factura", sortable: true, align: 'right', dataIndex: 'num_fatura', fixed:true, width: 80, hidden: false},
			{header: "Vencimiento", width: 90, align: 'right', sortable: true, dataIndex: 'vencimento', dateFormat: 'd-m-Y', fixed:true},
			{header: "VL.Factura", width: 90, align: 'right', sortable: true, dataIndex: 'vl_total_fatura',  fixed:true},
			{header: "VL.Quota",width: 90,align: 'right',sortable: true,fixed:true, dataIndex: 'vl_parcela'},
			//{header: "Quota",width: 70,align: 'right',sortable: true,fixed:true,dataIndex: 'nm_parcela'},
			{header: 'Interes',width: 65,id: 'juros',align: 'right', dataIndex: 'juros',name: 'juros',fixed:true,
				editor: new Ext.form.NumberField({
						allowBlank : false
			   })
			},
			{header: 'Descuentos',width: 80,align: 'right',dataIndex: 'descontos',name: 'descontos',fixed:true,
				editor: new Ext.form.NumberField({
						allowBlank : false
			   })
			},
			{header: "Pago Parcial",width: 90,align: 'right',sortable: true,dataIndex: 'totalpago',name: 'totalpago',id: 'totalpago',fixed:true},
			{dataIndex: 'totals',id: 'totals',header: "Total",name: 'totals',width: 100,align: 'right',sortable: false,fixed:true,groupable: false,
                renderer: function(v, params, record){
				 totalp = record.data.totalpago;
				if (totalp === '') totalpp = 0.00; 
				if (totalp > 0) totalpp = totalp;
           geral = Ext.util.Format.usMoney(parseFloat(record.data.juros) + parseFloat(record.data.vl_parcela) - parseFloat(record.data.descontos) - parseFloat(record.data.totalpago));
		  return geral;
				
                },
				name: 'totalGeral',
                dataIndex: 'totalGeral',
                summaryType:'totalGeral',
				fixed:true,
                summaryRenderer: Ext.util.Format.usMoney
            }
			/*{
				header: "Pagar",
				dataIndex: 'statuss',
				fixed:true,
				width: 50,
				renderer: formataPagar,
				editor: new Ext.grid.GridEditor(new Ext.form.Checkbox())				
			}
			*/
        ],

        view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true,
			startCollapsed: true
           // getRowClass: MudaCor
        }),
        plugins: summary,
        autoWidth: true,
        height: 300,
        clicksToEdit: 1,
		autoScroll:false,
		tbar: [ /*
			   {
				text: 'Gravar',
				iconCls:'icon-save',
				tooltip: 'Clique para lancar um registro(s) selecionado',
				handler: function(){
					jsonData = "[";
						
						for(d=0;d<storePagar.getCount();d++) {
							record = storePagar.getAt(d);
							if(record.data.newRecord || record.dirty) {
								jsonData += Ext.util.JSON.encode(record.data) + ",";
							}
						}
						
						jsonData = jsonData.substring(0,jsonData.length-1) + "]";
						//alert(jsonData);
							Ext.Ajax.request(
							{
								waitMsg: 'Enviando Cotacão, por favor espere...',
								url:'php/pagar_duplicata.php',
								params:{data:jsonData},
								success:function(form, action) {
									Ext.Msg.alert('Obrigado', 'Enviado com sucesso!!!!');
									storePagar.reload();
								},
								
								failure: function(form, action) {
									Ext.Msg.alert('Alerta', 'Erro, Tente Novamente');
								}								
							}
						);						
					} },
					*/
					
		],
		 bbar: [
				{
					xtype: 'label',
					text: 'Relatorios: ',
					style: 'font-weight:bold;color:yellow;text-align:left;' 
					},
				{
				text: 'Por Periodo',
				style: 'padding-left:10px;',
				iconCls:'icon-periodo',
				 tooltip: 'Elejir el periodo!',
				handler: function(){
					var win_contas_pagar = new Ext.Window({
					id: 'win_contas',
					title: 'Informe de Cuentas a Pagar por Periodo',
					width: 300,
					height: 160,
					modal: true,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: [
							FormContasPagar= new Ext.FormPanel({
							frame		: true,
							id			: 'FormContasPagar',
							split       : true,
							items:[
								   {
									xtype:'datefield',
									fieldLabel: 'De',
									name: 'dtini'
									},
									{
									xtype:'datefield',
									fieldLabel: 'Hasta',
									name: 'dtfim'
									},
									{
									xtype: 'button',
									text: 'Relatorio',
									iconCls: 'icon-pdf',
									handler: function(){
									
									dtini = FormContasPagar.getForm().findField('dtini').getValue(); 
									dtfim = FormContasPagar.getForm().findField('dtfim').getValue(); 
									function popup(){
											void(open('../sistema/pdf_contaspagar_per.php?dtini='+dtini +'&dtfim='+dtfim +'','','width=800, height=700'));
											}
									popup();
									}
									}
									]		
						})
						],
						buttons: [
           						{
            					text: 'Salir',
            					handler: function(){ // fechar	
     	    					win_contas_pagar.destroy();
  			 					}
			 
        					}]
				});
				win_contas_pagar.show();
			}
				},
				'-',
				{
				text: 'Por Proveedor',
				iconCls:'icon-user',
				tooltip: 'Elejir el proveedor!',
				handler: function(){
				win_print.show();
				
				}
				},
				'-',
				{	
				xtype: 'button',
				iconCls:'icon-pdf', 
				text: 'Todos',
				handler: function(){ 
				//console.info(idforn);
					function popup(){
						window.open('../sistema/pdf_contaspagar.php','popup','width=750,height=500,scrolling=auto,top=0,left=0')
					}
				popup();
				}
				}
				/*
				{
				text: 'Contas no Periodo',
				handler: function(){ // fechar	
     	    					win_ctpg.show();
  			 					}
				//iconCls:'icon-pdf'
				
				}*/
				],
		listeners:{ 
	    celldblclick: function(grid, rowIndex, columnIndex, e){
            var record = grid.getStore().getAt(rowIndex); // Pega linha 
            var fieldName = grid.getColumnModel().getDataIndex(0); // Pega campo da coluna
            var data = record.get(fieldName); //Valor do campo
            //alert(data);
			win_grid_parcial.show();
			dsPagoProv.baseParams.id = data;
			dsPagoProv.load();
         }
	}
    });
	///TERMINA A GRID	
	
var relatorioPeriodo = function(){
var dtini = Ext.get('dtinicial').getValue();
var dtfim = Ext.get('dtfinal').getValue();
if(dtini.length > 0){		

var win_relatorio_periodo = new Ext.Window({
					id: 'win_relatorio_periodo',
					title: 'Relatorio no Periodo',
					width: 650,
					height: 500,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='../sistema/relatorio_forn_imp_per.php?dtini="+dtini+"&dtfim="+dtfim+"' > </iframe>"},
					buttons: [
           						{
            					text: 'Sair',
            					handler: function(){ // fechar	
     	    					win_relatorio_periodo.destroy();
  			 					}
			 
        					}]
				});
win_relatorio_periodo.show();
}
else{
//selecione();
}			
}


 FormCtPeriodo = new Ext.FormPanel({
			frame		: true,
			layout      : 'form',
			border 		: false,
            split       : true,
			//region      : 'center',
            autoWidth   : true,
			height		: 233,
            collapsible : false,
			items:[{
							 xtype: 'datefield',
                    		 fieldLabel: 'Data Inicial',
							 readOnly: false,
							 id: 'dtinicial',
                    		 name: 'dtinicial'
							 },
							 {
							 xtype: 'datefield',
							 readOnly: false,
                    		 fieldLabel: 'Data Final',
							 id: 'dtfinal',
                    		 name: 'dtfinal'
							 },
							 {
							 style: 'margin-top:30px',
							 float:'left'
					         },
					 		 {
							xtype: 'button',
							text: 'Buscar',
							iconCls:'icon-pdf',
							tooltip: 'Imprimir!',
							handler: function(){
								relatorioPeriodo();
							}
				}
					 
						]
										   });
 
	if (win_ctpg == null){
				win_ctpg = new Ext.Window({
					id:'win_ctpg'
					, border 	: false
					, title: "Busca por periodo"
	                , layout: 'form'
	                , width: 350
					, height: 250
	                , closeAction :'hide'
	                , plain: true
					, modal: true
					, items:[FormCtPeriodo]
					,buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_ctpg.hide();
								//FormInfPedido.getForm().reset();
  			 					}
        			}
					]
					,focus: function(){
 	   					// Ext.get('qtd_produto').focus();
						}

				});
				
				
			}
		
		BaixaContaPagar = function(){
		
			if(typeof jsonSaidaCheque == 'undefined')
							jsonSaidaCheque = "[]";
						Ext.Ajax.request({
							waitMsg: 'Salvando...',
							url: '../sistema/php/pago_prov_parcial.php', 
							params: { 
								acao: "novopg",
								jsonSaidaCheque: jsonSaidaCheque,
								valor_parcial: FormParcial.getForm().findField('valor_parcial').getValue(), //Ext.get('valor_parcial').getValue(),                        
								data_ct_parcial: FormParcial.getForm().findField('data_ct_parcial').getValue(), //Ext.get('data_ct_parcial').getValue(),                        
								numero_recibo: FormParcial.getForm().findField('numero_recibo').getValue(), //Ext.get('numero_recibo').getValue(),
								formapgto: FormParcial.getForm().findField('formapagoconta').getValue(),
								idctpag : dsPagoProv.baseParams.id
							},
							failure:function(response,options){
								Ext.MessageBox.alert('Erro', 'Nao foi possivel salvar...');
								dsPagoProv.rejectChanges();
							},
							success: function(result, request){//se ocorrer correto 
							var jsonData = Ext.util.JSON.decode(result.responseText);
								if(jsonData.response){
									Ext.MessageBox.alert('Aviso',jsonData.response); //aki uma funcao se necessario);
								}
						//		dsPagoProv.commitChanges();	
						//		dsPagoProv.baseParams.id;
						//		dsPagoProv.load();							
						//		Ext.MessageBox.alert('Alerta', 'Salvo com sucesso');
						//		FormParcial.form.reset();							
							}
						});			 		
		}
	
		FormParcial = new Ext.form.FormPanel({
		//	id: 'FormParcial',
			url: 'funcionarios/salvar',
			method: 'POST',
			baseCls: 'x-plain',
		//	labelWidth: 110,
			bodyStyle: 'padding: 2px;',
			frame:false,
			labelAlign:'left',					        
			waitMsgTarget: false,					        
			layout: 'form',	
			onSubmit: Ext.emptyFn,	
			defaultType: 'textfield',
			defaults: {
				width: 100,
				allowBlank:false,
				selectOnFocus: true,
				blankText: 'Llenar el campo'
			},	
			items: [
				{
				xtype:'moneyfield',
				name: 'valor_parcial',
				width: 80,
				//mask:'decimal',
				// textReverse : true,
				//renderer: 'usMoney',
				fieldLabel: '<b>Valor Pago</b>',
				fireKey : function(e){	
					if(e.getKey() == e.ENTER){
					//	Ext.getCmp('data_ct_parcial').focus();
					}
				}					
				},
				{
				//	id:'data_ct_parcial',
				name: 'data_ct_parcial',							
				fieldLabel: '<b>Data Pgto</b>',
				xtype: 'datefield',
				fireKey : function(e){	
					if(e.getKey() == e.ENTER){
					//	Ext.getCmp('numero_recibo').focus();
					}
				}						
				},
				{
				//	id:'numero_recibo',
				name: 'numero_recibo',							
				fieldLabel: '<b>Nº Recibo</b>',
				fireKey : function(e){	
					if(e.getKey() == e.ENTER){
					//	Ext.getCmp('cedula').focus();
					}
				}						
				},
				{
				xtype: 'radiogroup'
				,hideLabel: true
				,bodyStyle: 'padding-top: 10px;'
				,width: 300
			    ,items: [
				    {
					boxLabel: 'Caja Usuario'
					, name: 'formapagoconta'
					, inputValue: 'cxuser'
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
					, name: 'formapagoconta'
					, inputValue: 'cxempr'
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
					boxLabel: 'Cheque'
					, name: 'formapagoconta'
					, inputValue: 'cheque'
					,listeners: {
						check: function (ctl, val) {
							if(val == true){
								idcompranova = dsPagoProv.baseParams.id;
								var abrewinentradacheque = function(){Ext.Load.file('jstb/saida_cheque_cp.js', function(obj, item, el, cache){saida_cheque(
								FormParcial.getForm().findField('valor_parcial').getValue(),
								dsPagoProv.baseParams.id,
								FormParcial.getForm().findField('data_ct_parcial').getValue()
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
	
function novo_provpgtos(){		
			novo_provpgto = new Ext.Window({
				title: 'Lancar Pagamentos',
				width:350,
				height:230,
				plain: true,						
				collapsible: false,
				resizable: false,
				closeAction:'hide',
				closable: false,
				modal: true,
				border: false,
				items: [FormParcial],
				buttonAlign:'right',
				buttons: [{
					id:'btnSalvapgto',
					text:'Grabar',
					iconCls: 'icon-save',
					type: 'submit',
					minButtonWidth: 75,
					handler: function(){	
						BaixaContaPagar();
					}
				},
				{
					id: "close",
					text: 'Salir',
					handler: function(){
						novo_provpgto.hide();
					}
				}
			],
				focus: function(){
					FormParcial.getForm().findField('valor_parcial').focus(); //Ext.get('valor_parcial').focus();
				}				
			});
		
		novo_provpgto.show();
	}

/////COMECA GRID PAGAMENTOS PARCIAIS /////////////////////////
dsPagoProv = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: '../sistema/php/pago_prov_parcial.php',
			method: 'POST'
		}),   
		baseParams:{acao: "listarDados"},
		reader:  new Ext.data.JsonReader({
			root: 'result',
			totalProperty: 'total',
			id: 'idcontas_pagarParcial'
		},
			[
				{name: 'idcontas_pagarParcial'},
				{name: 'contas_pagar_id'},
				{name: 'totalpago'},
				{name: 'datapgto',  dateFormat: 'd-m-Y'},
				{name: 'numero_recibo'},				
				{name: 'user_id'}
				
			]
		),
		sortInfo: {field: 'nome', direction: 'ASC'},
		remoteSort: true		
	});

 var grid_pagoParcial = new Ext.grid.GridPanel({
	        store: dsPagoProv, 
	        columns:
		        [
		{dataIndex: 'idcontas_pagarParcial',header: 'Id',hidden: true,hideable: false},
		{dataIndex: 'contas_pagar_id',header: 'Nº Compra',align: 'right',width: 65},	
		{dataIndex: 'totalpago',header: 'Valor Pago',width: 70,align: 'right',Renderer: Ext.util.Format.usMoney,
		editor: new Ext.form.NumberField({
			   allowBlank: false
			})				
		},
		{dataIndex: 'numero_recibo',header: 'Nº Recibo',width: 60,align: 'right',
		editor: new Ext.form.TextField({
			   allowBlank: false
			  
			})				
		},			
		{dataIndex: 'datapgto',header: 'Data Pgto',width: 60,align: 'right',
		editor: new Ext.form.DateField({
			format: 'd/m/Y'
			})				
		},
		{dataIndex: 'user_id',header: 'Usuario',width: 45,align: 'right',
		editor: new Ext.form.TextField({
			   allowBlank: false
			})				
		}
		],
		viewConfig:{
	            forceFit:true,
				autoExpandColumn: true,
				emptyText: 'Nenhum registro encontrado' 
	        },
		ds: dsPagoProv,
		enableColLock: false,
		stripeRows: true,
		autoScroll:true,
		//plugins: [checkColumn],
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		width:'100%',
		height:200,					
	    tbar: [		
			{		
				text: 'Pagamento',
				iconCls:'icon-add', 
				tooltip: 'Novo Pagamento',
				handler : function(){	
					novo_provpgtos();
				}
			}, '-',
				
			{
				text: 'Deletar registro',
				tooltip: 'Clique para Deletar um registro(s) selecionado',
				handler: function(){
					var selectedKeys = grid_pagoParcial.selModel.selections.keys; 
					if(selectedKeys.length > 0)
					{
						Ext.MessageBox.confirm('Alerta', 'Deseja deletar esse registro?', function(btn) {
							if(btn == "yes"){	
								var selectedRows = grid_pagoParcial.selModel.selections.items;
								var selectedKeys = grid_pagoParcial.selModel.selections.keys; 
								var encoded_keys = Ext.encode(selectedKeys);
			
								Ext.Ajax.request(
								{ 
									waitMsg: 'Executando...',
									url: '../sistema/php/pago_prov_parcial.php',		
									params: { 
										acao : 'deletar',
										id_pago: encoded_keys,
										key: 'idcontas_pagarParcial'										
									},
										
									callback: function (options, success, response) {
										if (success) { 
											Ext.MessageBox.alert('OK', response.responseText);
											var json = Ext.util.JSON.decode(response.responseText);
												if(json.del_count == 1){
													mens = "1 Registro deletado.";
												} else {
													mens = json.del_count + " Registros deletados.";
												}
												Ext.MessageBox.alert('Alerta', mens);
											} else{
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										},
										
										failure:function(response,options){
											Ext.MessageBox.alert('Alerta', 'Erro...');
										},                                      
										success:function(response,options){
											dsPagoProv.reload();
										}                                      
									 } 
								);						
							}	
						});
					}
					else
					{
						Ext.MessageBox.alert('Alerta', 'Por favor selecione uma linha');
					}
				}, 
				iconCls:'icon-delete' 
			}]
		 });


///TERMINA GRID PAGAMENTOS PARCIAIS ////////////////////////////////

var form_print_prov = new Ext.FormPanel({
        //labelAlign: 'top',
        frame:true,
        bodyStyle:'padding:5px 5px 0',
        autoWidth: true,
		height: 300,
		items: [{
					xtype: 'radiogroup'
					,hideLabel: true
			    	,items: [
						 {
							 boxLabel: 'Todos'
							 , name: 'prov'
							 , inputValue: 'T'
							 , checked: true
					    },
						{
							boxLabel: 'Especificar'
							, name: 'prov'
							, inputValue: 'E'
							
							
							
						}	
					]
				},
				{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				dataField: ['idforn','nomeforn', 'endereco'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Proveedor	',
				id: 'nomeprov',
				minChars: 2,
				name: 'nomeprov',
				width: 200,
                resizable: true,
                listWidth: 350,
				//col: true,
				forceSelection: true,
				store: new Ext.data.JsonStore({
				url: '../sistema/php/LancDespesa.php?acao_nome=fornNome',
				root: 'resultados',
				fields: [ 'idforn', 'nomeforn', 'endereco' ]
				}),
					hiddenName: 'idforn',
					valueField: 'idforn',
					displayField: 'nomeforn',
					onSelect: function(record){
						idforn = record.data.idforn;
						nomeforn = record.data.nomeforn;
						this.collapse();
						this.setValue(nomeforn);
						//Ext.getCmp('idFornecedor').setValue(idforn);
						//Ext.getCmp('nomedesp').focus();
						//console.info(idforn);
					}
							
                },
				{	
				xtype: 'button',
				iconCls:'icon-pdf', 
				text: 'Gerar Relatorio',
				handler: function(){ 
					Entidade = form_print_prov.getForm().findField('prov').getValue();
				//console.info(idforn);
				if(idforn > 0){	
								function popup(){
		window.open('../sistema/pdf_contaspagar_forn.php?id='+idforn +'&ent='+Entidade +'','popup','width=750,height=500,scrolling=auto,top=0,left=0')
		}
		popup();
		}
		else{
		selecione();
		}
				}
			 
				}
				
				]
			});

win_print = new Ext.Window({
	//	id: 'win_print',
		title: 'Gerar Relatorio',
		width:350,
		height:250,
		autoScroll: false,
		closable: false,
		layout: 'fit',
		resizable: false,
		border: false,
		modal: true, //Bloquear tela do fundo
		items:[form_print_prov],
		buttons: [
           	{
            text: 'Cerrar',
            handler: function(){ // fechar	
     	    win_print.hide();
  			 }
			 
        }]
		
	});




	win_grid_parcial = new Ext.Window({
		//id: 'win_grid_parcial',
		title: 'Pagamentos Parciais',
		width:450,
		height:270,
		autoScroll: false,
		//shim:true,
		closable : false,
		//html: '<div id=\'CA\'></div><br /><div id=\'CB\'></div><br /><div id=\'CC\'></div>',
		layout: 'form',
		resizable: false,
		border: false,
		draggable: true, //Movimentar Janela
		plain: true,
		modal: true, //Bloquear tela do fundo
		items:[grid_pagoParcial],
		buttons: [
           	{
            text: 'Cerrar',
            handler: function(){ // fechar	
     	    win_grid_parcial.hide();
			storePagar.reload();
  			 }
			 
        }]
		
	});


FormContasPagar = new Ext.FormPanel({
	    title: 'Contas Pagar',
	//	id: 'FormContasPagar',
		layout:'fit',
		frame: true,
		closable:true,
		autoWidth: true,
		titleCollapse: false,
		items:[grid_forn],
		listeners:{
				destroy: function() {
                             //grid_ItensPedido.destroy();
							 win_print.destroy();
							 if(typeof novo_provpgto != 'undefined')
							 novo_provpgto.destroy();
							 
         				}
			         }			

});	

Ext.getCmp('tabss').add(FormContasPagar);
Ext.getCmp('tabss').setActiveTab(FormContasPagar);

	}