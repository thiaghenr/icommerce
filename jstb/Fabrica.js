// JavaScript Document

  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
  
  Ext.QuickTips.init();
  Ext.form.Field.prototype.msgTarget = 'side';
  
FrabricaProd = function(){
		
	if(perm.contas_pagar.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}

var geral;
var totalpp;
var ContPagar;									  
var winPagar;
var idData;
var totalProd;
var FormParcialProd;
var xg = Ext.grid;
var win_ctpg;

 selecione = function(){
Ext.MessageBox.alert('Alerta', 'Favor elejir un registro');
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
	  var storeFabrica = new Ext.data.GroupingStore({
      proxy: new Ext.data.HttpProxy({
	  method: 'POST',
	  url: 'php/Fabrica.php'
	  }),
	  
      groupField:'idsolicit', 
	  groupDir : 'DESC',
      sortInfo:{field: 'idsolicit', direction: "DESC"},
      reader: new Ext.data.JsonReader({
		 totalProperty: 'total',
	     root:'result',
	     fields: [
			{name: 'idproducao_solicit_itens', type:'int'},
			{name: 'idsolicit', type:'int'},
			{name: 'idproduto_produzir'},
	        {name: 'qtd_prdoduzir'},
            {name: 'obs'},
            {name: 'qtdproduzido'},
            {name: 'Descricao'},
            {name: 'Codigo'},
			{name: 'sigla_medida'},
            {name: 'data_solicit'},
			{name: 'data_validade'},
			{name: 'dtconclusao'},
			{name: 'Estoque'}
 		]
		}),
		baseParams:{acao: 'ListaProducao'}
   });
   
  function change(val){
        if(val > 0){
            return '<span style="color:blue;font-weight: bold;">' + val + '</span>';
        }else if(val <= 0){
            return '<span style="color:red;font-weight: bold">' + val + '</span>';
        }
        return val;
    };
	function verde(val){
        if(val >= 0){
            return '<span style="color:green;font-weight: bold;">' + val + '</span>';
        }
        return val;
    };
	
  // storeFabrica.load();
   storeFabrica.load({params:{start: 0, limit: 30}});
   
	var gridForm = new Ext.BasicForm(
		Ext.get('form2'),
		{
			});
   
    var summary = new Ext.grid.GroupSummary(); 
    var gridFabrica = new Ext.grid.EditorGridPanel({
	    store: storeFabrica,
		//layout: 'column',
		enableColLock: true,
		containerScroll  : false,
	    loadMask: {msg: 'Carregando...'},
        columns: [
			{id: 'idproducao_solicit_itens', sortable: true, dataIndex: 'idproducao_solicit_itens', fixed:true,	hidden: true},
			{header: "Orden", sortable: true, dataIndex: 'idsolicit', fixed:true},
            {header: "Codigo", width: 100, sortable: true, align: 'left', dataIndex: 'idproduto_produzir', summaryType: 'count', fixed:true,
				summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '(' + v +' Productos)' : '(1 Producto)');
                }
            },
			{header: "Descricao", width: 200, align: 'left', sortable: true, dataIndex: 'Descricao', fixed:true},
			{header: "UN", sortable: true, align: 'left', dataIndex: 'sigla_medida', fixed:true, width: 50},
			{header: "Estoque", width: 70, align: 'right', sortable: true, dataIndex: 'Estoque', fixed:true, renderer: change},
			{header: "Producir", width: 70, align: 'right', sortable: true, dataIndex: 'qtd_prdoduzir', fixed:true, renderer: verde},
			{header: "Fecha", width: 90, align: 'right', sortable: true, dataIndex: 'data_solicit', fixed:true},
            {header: "Plazo", width: 90, align: 'right', sortable: true, fixed:true, dataIndex: 'data_validade'},
			{header: "Producido", width: 80, align: 'right', sortable: true, fixed:true, dataIndex: 'qtdproduzido'},
			{header: "Obs", width:270, align: 'left', sortable: true, fixed:true, dataIndex: 'obs'}
			],

        view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: true,
            enableNoGroups:true, // REQUIRED!
            hideGroupedColumn: false
           // getRowClass: MudaCor
        }),
        plugins: summary,
      //  autoWidth: true,
        height: 300,
        clicksToEdit: 1,
		autoScroll:false,
		tbar: [ 
			    {
				text: 'Informar Producion',
				iconCls:'icon-grid',
				tooltip: 'Click para lanzar un registro(s)',
				handler: function(){
						InformarProducao();
						dsInfProd.load({params: {acao: 'listarInformes', idIten: data}});
					
					} 
				}
					
					
		],
		/*
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
					title: 'Relatorio de Cuentas a Pagar por Periodo',
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
											void(open('pdf_contaspagar_per.php?dtini='+dtini +'&dtfim='+dtfim +'','','width=800, height=700'));
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
				}
				],
				*/
		bbar: new Ext.PagingToolbar({
				store: storeFabrica,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "No contiene datos",
				pageSize: 30,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina",    
				refreshText : "Atualizar"
			//	paramNames : {start: 'start', limit: 'limit'}
			}),
		listeners:{ 
	    cellclick: function(grid, rowIndex, columnIndex, e){
            var record = grid.getStore().getAt(rowIndex); // Pega linha 
            var fieldName = grid.getColumnModel().getDataIndex(0); // Pega campo da coluna
            data = record.get(fieldName); //Valor do campo
            //alert(data);
			//dsPagoProv.baseParams.id = data;
			//dsPagoProv.load();
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
					items: { html: "<iframe height='100%' width='100%' src='../relatorio_forn_imp_per.php?dtini="+dtini+"&dtfim="+dtfim+"' > </iframe>"},
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
			
		FormParcialProd = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 110,
			bodyStyle: 'padding: 2px;',
			frame:false,
			labelAlign:'right',					        
			waitMsgTarget: false,					        
			layout: 'form',	
			//onSubmit: Ext.emptyFn,	
			defaultType: 'textfield',
			defaults: {
				width: 100,
				allowBlank:false,
				labelWidth: 200,
				selectOnFocus: true,
				blankText: 'llenar el campo'
			},	
			items: [
					 {
					xtype:'moneyfield',
                    name: 'CantParcial',
                    labelWidth: 220,
					decimalPrecision : 2,
					style:'{text-align:right;}',
                    width: 100,
					fieldLabel: '<b>Cant. Producida</b>'
				}
			]	
			
		});
	
	
			novo_infprod = new Ext.Window({
				title: 'Lancar Pagamentos',
				width:350,
				height:150,
				plain: true,						
				collapsible: false,
				resizable: false,
				closeAction:'hide',
				modal: true,
				border: false,
				items: [FormParcialProd],
				focus: function(){
					FormParcialProd.getForm().findField('CantParcial').focus();
				},
				buttonAlign:'right',
				buttons: [{
					text:'Grabar',
					iconCls: 'icon-save',
					minButtonWidth: 75,
					handler: function(){
						
						Ext.Ajax.request( 
						{
							waitMsg: 'Salvando...',
							url: 'php/Fabrica.php', 
							params: { 
								acao: "novoInforme",
								CantParcial: FormParcialProd.getForm().findField('CantParcial').getValue(),                
								idIten : data
							},
							callback: function (options, success, response) {
								if (success) { 
									var jsonData = Ext.util.JSON.decode(response.responseText);
								//	console.info(jsonData.response);
									if(jsonData.total == 0){
										Ext.MessageBox.alert('Avizo', jsonData.response,
											function(btn){
												if(btn == "ok"){
													
												} 
											}
										);
									}
									if(jsonData.total > 0){ 
										Ext.MessageBox.alert('Avizo', jsonData.response,
											function(btn){
												if(btn == "ok"){
													dsInfProd.reload();
												} 
											}
										);
									}	
								}
								else{
									Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
								}
							}
						 });
						
			 
					}
				},
				{
					text: 'Cancelar',
					handler: function(){
						novo_infprod.hide();
						FormParcialProd.getForm().reset();
						storeFabrica.reload();
					}
				}
				]
			});
		
	

/////COMECA GRID PAGAMENTOS PARCIAIS /////////////////////////
	dsInfProd = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/Fabrica.php',
			method: 'POST'
		}),   
	//	baseParams:{acao: "listarInformes"},
		reader:  new Ext.data.JsonReader({
			root: 'result',
			totalProperty: 'total',
			id: 'idproducao_itens_parcial'
		},
			[
				{name: 'idproducao_itens_parcial'},
				{name: 'iditens_solicit'},
				{name: 'qtdproduzido'},
				{name: 'dataproducao'},				
				{name: 'user'}
				
			]
		),
		sortInfo: {field: 'idproducao_itens_parcial', direction: 'DESC'},
		remoteSort: true
	});

		var gridInfProd = new Ext.grid.GridPanel({
	        store: dsInfProd, 
	        columns:
		        [
				{dataIndex: 'idproducao_itens_parcial',header: 'Id',hidden: true,hideable: false},
				{dataIndex: 'iditens_solicit',header: 'Controle',align: 'right',width: 40},	
				{dataIndex: 'qtdproduzido',header: 'Cant.',width: 70,align: 'right'},
				{dataIndex: 'dataproducao',header: 'Fecha',width: 60,align: 'right'},			
				{dataIndex: 'user', hidden: true, header: 'Usuario',width: 45,align: 'right'}
				],
			viewConfig:{
	            forceFit:true,
				autoExpandColumn: true,
				emptyText: 'Ningun registro encontrado' 
	        },
		//	ds: dsInfProd,
			enableColLock: false,
			stripeRows: true,
			autoScroll:true,
			//plugins: [checkColumn],
			selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
			width:'100%',
			height:200,					
			tbar: [		
					{		
					text: 'Informar',
					iconCls:'icon-add', 
					tooltip: 'Informar Producion',
					handler : function(){	
						novo_infprod.show();
						
					}
					},
					'-'					
			]
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
							 , disabled: true
							
					    },
						{
							boxLabel: 'Especificar'
							, name: 'prov'
							, inputValue: 'E'
							, checked: true
							
							
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
				url: 'php/LancDespesa.php?acao_nome=fornNome',
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
				//console.info(idforn);
				if(idforn > 0){	
								function popup(){
window.open('../pdf_contaspagar_forn.php?id='+idforn +'','popup','width=750,height=500,scrolling=auto,top=0,left=0')
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
		id: 'win_print',
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


	InformarProducao = function(){
		if(typeof(data) !="undefined"){
		
			winParcialProd = new Ext.Window({
				title: 'Informar Producion',
				width:450,
				autoHeight: true,
				autoScroll: false,
				//shim:true,
				closable : true,
				//html: '<div id=\'CA\'></div><br /><div id=\'CB\'></div><br /><div id=\'CC\'></div>',
				layout: 'fit',
				resizable: false,
				border: false,
				draggable: true, //Movimentar Janela
				plain: true,
				modal: true, //Bloquear tela do fundo
				items:[gridInfProd],
				buttons: [
							{
							text: 'Cerrar',
							handler: function(){ // fechar	
								winParcialProd.hide();
							}
						 
							}
						]
			});
			winParcialProd.show();
		}
		else{
		selecione();
		}
	}


FormContasPagar = new Ext.FormPanel({
	    title: 'Producion',
		layout:'fit',
		frame: true,
		closable:true,
		autoWidth: true,
		titleCollapse: false,
		items:[gridFabrica],
		listeners:{
				destroy: function() {
                             //grid_ItensPedido.destroy();
							 win_print.destroy();
							 
         				}
			         }			

});	

Ext.getCmp('tabss').add(FormContasPagar);
Ext.getCmp('tabss').setActiveTab(FormContasPagar);

	}