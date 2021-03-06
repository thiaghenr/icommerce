// JavaScript Document

Ext.onReady(function(){   
  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
  
  Ext.QuickTips.init();
  Ext.form.Field.prototype.msgTarget = 'side';
	
var  cont_pagar= Ext.get('cont_pagar');
cont_pagar.on('click', function(e){  

var geral;
var totalpp;
var ContPagar;									  
var winPagar;
var idData;
var totalProd;
var FormParcial;
 var xg = Ext.grid;
 
function formataPagar(value){
        return value == 1 ? 'Sim' : 'N�o';  
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


///COMECA A GRID /////
	  var storePagar = new Ext.data.GroupingStore({
      proxy: new Ext.data.HttpProxy({
	  method: 'POST',
	  url: 'php/contas_pagar.php'
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
			{name: 'nm_parcela'},
            {name: 'totalpago', type:'float'},
			{name: 'vencimento', dateFormat: 'd-m-Y'},
			{name: 'juros', type:'float',  mapping: 'vl_juro'},
			{name: 'descontos', type:'float', mapping: 'vl_desconto'},
			{name: 'totals', type:'float'},
			{name: 'totalGeral', type:'float'},
			{name: 'statuss', align: 'center', mapping: 'status', type:'boolean'}
 		]
		})
   });
	
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
			
			{	
				id: 'idcp',
                header: "idcp",
                sortable: true,
                dataIndex: 'idcp',
				fixed:true,
				hidden: true
            },
			
			{	
				id: 'ctproveedor_id',
                header: "ctproveedor_id",
                sortable: true,
                dataIndex: 'ctproveedor_id',
				fixed:true,
				hidden: true
            },
            {
                id: 'idprov',
                header: "Proveedores",
                width: 100,
                sortable: true,
                dataIndex: 'nome_cli',
                summaryType: 'count',
				fixed:true,
                hideable: false,
                summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '(' + v +' Compras)' : '(1 Compra)');
                }
            },{
                header: "nome",
				name: 'nome',
                sortable: true,
                dataIndex: 'nome',
				fixed:true
            },
			{	
				id: 'compra_id',
                header: "Compra",
                sortable: true,
				align: 'right',
                dataIndex: 'compra_id',
				fixed:true,
				width: 50,
				hidden: false
            },
			
			{
                header: "Vencimento",
                width: 70,
				align: 'right',
                sortable: true,
                dataIndex: 'vencimento',
				 dateFormat: 'd-m-Y',
				 fixed:true
              //  summaryType:'min'
               
            },
			{
                header: "VL. Fatura",
                width: 70,
				align: 'right',
                sortable: true,
                dataIndex: 'vl_total_fatura',
			    renderer: Ext.util.Format.usMoney,
				fixed:true
               // summaryType:'sum',
               // renderer : function(v){
               //     return v ;
              //  },
             
            },{
                header: "VL. Parcela",
                width: 70,
				align: 'right',
                sortable: true,
				fixed:true,
                renderer: Ext.util.Format.usMoney,
                dataIndex: 'vl_parcela'
               // summaryType:'average'
               
            },
			{
                header: "Quota",
                width: 50,
				align: 'right',
                sortable: true,
				fixed:true,
                dataIndex: 'nm_parcela'
            },
			{  
				header: 'Juros',
				width: 65,
				id: 'juros',
				align: 'right',
				renderer: Ext.util.Format.usMoney,
				dataIndex: 'juros',
				name: 'juros',
				fixed:true,
				editor: new Ext.form.NumberField({
						allowBlank : false
						
						
			   })
			},
			{
				header: 'Descontos',
				width: 75,
				align: 'right',
				renderer: Ext.util.Format.usMoney,
				dataIndex: 'descontos',
				name: 'descontos',
				fixed:true,
				editor: new Ext.form.NumberField({
						allowBlank : false
			   })
			},
			{
                header: "Pago Parcial",
                width: 60,
				align: 'right',
                sortable: true,
                dataIndex: 'totalpago',
				name: 'totalpago',
				id: 'totalpago',
				fixed:true,
				renderer: Ext.util.Format.usMoney
				
               
            },
			
			{	
				dataIndex: 'totals',
                id: 'totals',
                header: "Total",
				name: 'totals',
                width: 75,
				align: 'right',
                sortable: false,
				fixed:true,
                groupable: false,
                renderer: function(v, params, record){
				 totalp = record.data.totalpago;
				if (totalp === '') totalpp = 0.00; 
				if (totalp > 0) totalpp = totalp;
           geral = Ext.util.Format.usMoney(parseFloat(record.data.juros) + parseFloat(record.data.vl_parcela) - parseFloat(record.data.descontos) - parseFloat(totalpp));
		  return geral;
				
                },
				name: 'totalGeral',
                dataIndex: 'totalGeral',
                summaryType:'totalGeral',
				fixed:true,
                summaryRenderer: Ext.util.Format.usMoney
            },
			{
				header: "Pagar",
				dataIndex: 'statuss',
				fixed:true,
				width: 50,
				renderer: formataPagar,
				editor: new Ext.grid.GridEditor(new Ext.form.Checkbox())				
			}
			
        ],

        view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true
        }),

        plugins: summary,
        frame:true,
        width: 790,
        height: 385,
		border: false,
        clicksToEdit: 1,
		//selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
       // collapsible: false,
       // animCollapse: false,
       // trackMouseOver: false,
       // enableColumnMove: true,
		//stripeRows: false,
		autoScroll:false,
        title: 'Duplicatas em Aberto',
        iconCls: 'icon-grid',
		tbar: [
			   {
				text: 'Gravar',
				iconCls:'remove',
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
								waitMsg: 'Enviando Cotac�o, por favor espere...',
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
					} }
		],
		 bbar: [
				{
				text: 'Gerar Relat�rio',
				iconCls:'print',
				 tooltip: 'Imprimir!',
				handler: function(){
			var win_cont_pagar = new Ext.Window({
					id: 'help',
					title: 'Relatorio Geral',
					width: 650,
					height: 500,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='../relatorio_forn_imp.php' > </iframe>" },
					buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_cont_pagar.destroy();
  			 					}
			 
        					}]
				});
				win_cont_pagar.show();
			}
				
				
				}
				],
				
				
				
		listeners:{ /*
        afteredit:function(e){
         Ext.Ajax.request({
            url: '../php/contas_pagar.phpp',
            params: {
               id: e.record.get('idcp'),
               valor: e.value,
			   campo: e.column

            },
			success: function(){
                           //Ext.example.msg('Informa&ccedil;&atilde;o','Registro atualizado com sucesso');
                           storePagar.commitChanges();
                        },
			failure: function(){
                           Ext.example.msg('Erro','N&atilde;o foi possivel Alterar.');
                           storePagar.rejectChanges();

                        }

         })
      }}*/
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
	if(!(FormParcial instanceof Ext.form.FormPanel)){
		FormParcial = new Ext.form.FormPanel({
			id: 'FormParcial',
			url: 'funcionarios/salvar',
			method: 'POST',
			baseCls: 'x-plain',
			labelWidth: 110,
			bodyStyle: 'padding: 2px;',
			frame:false,
			labelAlign:'right',					        
			waitMsgTarget: false,					        
			layout: 'form',	
			onSubmit: Ext.emptyFn,	
			defaultType: 'textfield',
			defaults: {
				width: 100,
				allowBlank:false,
				selectOnFocus: true,
				blankText: 'Preencha o campo'
			},	
			items: [
					
					new Ext.ux.MaskedTextField({
					id:'valor_parcial',
					name: 'valor_parcial',
					width: 80,
					mask:'decimal',
					textReverse : true,
					renderer: 'usMoney',
					fieldLabel: '<b>Valor Pago</b>',
					fireKey : function(e){	
						if(e.getKey() == e.ENTER){
							Ext.getCmp('data_ct_parcial').focus();
						}
					}					
				}),
				
				{
					id:'data_ct_parcial',
					name: 'data_ct_parcial',							
					fieldLabel: '<b>Data Pgto</b>',
					xtype: 'datefield',
					fireKey : function(e){	
						if(e.getKey() == e.ENTER){
							Ext.getCmp('numero_recibo').focus();
						}
					}						
				},
				
				{
					id:'numero_recibo',
					name: 'numero_recibo',							
					fieldLabel: '<b>N� Recibo</b>',
					fireKey : function(e){	
						if(e.getKey() == e.ENTER){
							Ext.getCmp('cedula').focus();
						}
					}						
				}
			],					
			buttonAlign:'center',
			buttons: [{
				id:'btnSalvapgto',
				text:'Salvar',
				type: 'submit',
				minButtonWidth: 75,
				handler: function(){
					
			        Ext.Ajax.request( 
			        {
						waitMsg: 'Salvando...',
						url: 'php/pago_prov_parcial.php', 
						
						params: { 
							acao: "novopg",
							valor_parcial: Ext.get('valor_parcial').getValue(),                        
							data_ct_parcial: Ext.get('data_ct_parcial').getValue(),                        
							numero_recibo: Ext.get('numero_recibo').getValue(),
							idctpag : dsPagoProv.baseParams.id
						},
						failure:function(response,options){
							Ext.MessageBox.alert('Erro', 'Nao foi possivel salvar...');
							dsPagoProv.rejectChanges();
						},
						
						success:function(response, options){
							dsPagoProv.commitChanges();	
							dsPagoProv.baseParams.id;
			dsPagoProv.load();							
							Ext.MessageBox.alert('Alerta', 'Salvo com sucesso');
							
							FormParcial.form.reset();							
						}
					 });
					
		 
				}
			},
			{
				id: "close",
				text: 'Cancelar',
				handler: function(){
					novo_provpgto.hide();
				}
			}
			]
		});
	}
function novo_provpgtos(){		
		if(!(novo_provpgtos instanceof Ext.Window)){
			novo_provpgto = new Ext.Window({
				title: 'Lancar Pagamentos',
				width:250,
				height:150,
				plain: true,						
				collapsible: false,
				resizable: false,
				closeAction:'hide',
				closable: true,
				modal: true,
				border: false,
				items: [FormParcial],
				focus: function(){
					Ext.get('valor_parcial').focus();
				}				
			});
		}
		novo_provpgto.show();
	}

/////COMECA GRID PAGAMENTOS PARCIAIS /////////////////////////
dsPagoProv = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/pago_prov_parcial.php',
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
				{name: 'idcontas_pagarParcial'},
				{name: 'compra_id'},
				{name: 'totalpago'},
				{name: 'datapgto',  dateFormat: 'd-m-Y'},
				{name: 'numero_recibo'},				
				{name: 'user_id'}
				
			]
		),
		sortInfo: {field: 'nome', direction: 'ASC'},
		remoteSort: true		
	});

var cm = new Ext.grid.ColumnModel([
		new Ext.grid.RowNumberer(),
		
		{
			dataIndex: 'idcontas_pagarParcial',
			header: 'Id',
			hidden: true,
			hideable: false
			
		},
		
		{
			dataIndex: 'idcontas_pagarParcial',
			header: 'ct pagar',
			width: 45,
			hidden: true
		},	
		{
			dataIndex: 'compra_id',
			header: 'N� Compra',
			align: 'right',
			width: 65
							
		},	
		{
			dataIndex: 'totalpago',
			header: 'Valor Pago',
			width: 70,
			align: 'right',
			Renderer: Ext.util.Format.usMoney,
			editor: new Ext.form.NumberField({
			   allowBlank: false
			})				
		},
		
		{
			dataIndex: 'numero_recibo',
			header: 'N� Recibo',
			width: 60,
			align: 'right',
			editor: new Ext.form.TextField({
			   allowBlank: false
			  
			})				
		},			
		
		{
			dataIndex: 'datapgto',
			header: 'Data Pgto',
			width: 60,
			align: 'right',
			//renderer: Ext.util.Format.dateRenderer('d/m/Y'),
			editor: new Ext.form.DateField({
				format: 'd/m/Y'
			})				
		},
		{
			dataIndex: 'user_id',
			header: 'Usuario',
			width: 45,
			align: 'right',
			editor: new Ext.form.TextField({
			   allowBlank: false
			})				
		}
		]);
cm.defaultSortable = true;
var grid_pagoParcial = new Ext.grid.EditorGridPanel({
		//title:'Lista de Funcionarios',
		id: 'datagrid1',
		ds: dsPagoProv,
		cm: cm,
		enableColLock: false,
		loadMask: true,
		stripeRows: true,
		autoScroll:true,
		//plugins: [checkColumn],
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		width:'100%',
		height:200,					
		//renderTo: document.body,
			
		viewConfig: {
			forceFit:true,
			getRowClass : function (row, index) {				
				var cls = '';
				if(row.data.ativo == false){
					cls = 'corGrid'
				} else {
					cls = ''
				}				
				return cls;
			}	
		},	
				
	     tbar: [		
			{		
				text: 'Pagamento',
				iconCls:'add', 
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
									url: 'php/pago_prov_parcial.php',		
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
				iconCls:'remove' 
			}]
		 
		 
										});


///TERMINA GRID PAGAMENTOS PARCIAIS ////////////////////////////////
	win_grid_parcial = new Ext.Window({
		id: 'win_grid_parcial',
		title: 'Pagamentos Parciais',
		width:450,
		height:270,
		autoScroll: false,
		//shim:true,
		closable : true,
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

								  
								  

	win_contas_pagar = new Ext.Window({
		id: 'win_contas_pagar',
		title: 'Contas a Pagar',
		width:800,
		height:450,
		autoScroll: false,
		//shim:true,
		closable : true,
		//html: '<div id=\'CA\'></div><br /><div id=\'CB\'></div><br /><div id=\'CC\'></div>',
		layout: 'form',
		resizable: false,
		border: false,
		draggable: true, //Movimentar Janela
		plain: true,
		modal: false, //Bloquear tela do fundo
		items:[grid_forn],
		buttons: [
           	{
            text: 'Cerrar',
            handler: function(){ // fechar	
     	    win_contas_pagar.destroy();
  			 }
			 
        }]
	});

	win_contas_pagar.show();								  
								  
	}); 
							  
	});
