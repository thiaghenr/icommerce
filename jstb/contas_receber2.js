// JavaScript Document
Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
  
Ext.QuickTips.init();
Ext.form.Field.prototype.msgTarget = 'side';
	
ContReceber = function(){


function MudaCor(row, index) {
      if (row.data.valor_juros == 0) { // change é o nome do campo usado como referência
         return '#dfdfdf';
      }
   }

var action = new Ext.ux.grid.RowActions({
    header:'Action'
   ,autoWidth: false
   ,width: 40
   ,actions:[{
       iconCls:'icon-checked'
      ,tooltip:'Receber'
	  ,width: 30
	  },
	  {
       iconCls:'icon-search'
      ,tooltip:'Visualisar'
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
						{header: "Total", width: 100, align: 'right', sortable: true, dataIndex: 'valor_parcela',renderer: 'usMoney'}
			
			 ],
	        viewConfig:{forceFit:true},
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
			{
				header: "Selecionar",
				dataIndex: 'statuss',
				fixed:true,
				width: 100,
				//renderer: CheckboxSelectionModel,
				editor: new Ext.grid.GridEditor(new Ext.form.Checkbox())				
			},
			{
                header: "Pagare",
				name: 'id',
                sortable: true,
				align: 'left',
                dataIndex: 'id',
				width: 20
				
            },
			 {
                id: 'dt_lancamento',
                header: "Lancamento",
                width: 90,
                sortable: true,
                dataIndex: 'dt_lancamento',
				fixed:true,
                hideable: false,
				fixed:true                
            },
			
            {
                id: 'dt_vencimento',
                header: "Vencimento",
                width: 70,
                sortable: true,
                dataIndex: 'dt_vencimento',
				fixed:true,
                hideable: false,
				summaryType: 'count',
				fixed:true,
				summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '(' + v +' Facturas)' : '(1 Factura)');
                }
                
            },
			{
                header: "Quotas",
				name: 'total_parcelas',
                sortable: true,
				align: 'left',
                dataIndex: 'total_parcelas',
				fixed:true,
				width: 50
            },
			{
                header: "Devolucion",
				name: 'vl_ntcredito',
                sortable: true,
				align: 'left',
                dataIndex: 'vl_ntcredito',
				fixed:true,
				width: 70
            },
			{
                header: "nome",
				name: 'nome',
                sortable: true,
                dataIndex: 'nome',
				fixed:true
            },
			{	
				id: 'venda_id',
                header: "Venda",
                sortable: true,
				align: 'left',
                dataIndex: 'venda_id',
				fixed:true,
				width: 50,
				hidden: false
            },
			{
                header: "Valor Quota",
                width: 80,
				align: 'right',
                sortable: true,
                dataIndex: 'vl_parcela',
			    summaryType:'sum',
				fixed:true,
				renderer : function(v){
                    return Ext.util.Format.usMoney(v);   
                }
            },
			{
                header: "Desconto",
                width: 80,
				align: 'right',
                sortable: true,
                dataIndex: 'desconto',
				summaryType:'sum',
			    renderer : function(v){
                    return Ext.util.Format.usMoney(v);   
                },
				fixed:true,
                editor: new Ext.form.NumberField({
						allowBlank : false,
						selectOnFocus:true,
						allowNegative: false
			    })
             
            },
			
			{
                header: "Taxa mes %",
                width: 80,
				align: 'right',
                sortable: true,
                dataIndex: 'perc_juros',
			    renderer: Ext.util.Format.usMoney,
				fixed:true,
				hidden: true          
            },
			
			
			
			 	{
				header: 'Interes',
				width: 80,
				align: 'right',
				dataIndex: 'valor_juros',
				name: 'valor_juros',
				id: 'valor_juros',
				hidden: true, 
				//summaryType:'sum',
				fixed:true,
				renderer : function(v){
					var parcela = v;
					if(parcela < 0)
						parcela = 0.00;					
                    return Ext.util.Format.usMoney(parcela);   
                }
			},
			
			
				new Ext.ux.MaskedTextField({
				header: 'Recebido',
				width: 80,
				align: 'right',
				iconCls: 'user-red',
				mask:'decimal',
				textReverse : true,
				dataIndex: 'valor_recebido',
				name: 'valor_recebido',
				renderer: 'usMoney',
				summaryType:'sum',
				fixed:true,
				renderer : function(v){
                    return Ext.util.Format.usMoney(v);   
                }
			//	editor: new Ext.form.NumberField({
			//			allowBlank : false,
			//			selectOnFocus:true,
			//			allowNegative: false
			//   })
			}),
		
			
			{	
				dataIndex: 'totals',
                id: 'totals',
                header: "Total",
				name: 'totals',
				width: 85,
				align: 'right',
                sortable: false,
				fixed:true,
                groupable: false,
                renderer: function(v, params, record){
                var v = Ext.util.Format.usMoney( parseFloat(record.data.vl_parcela)  - (parseFloat(record.data.desconto) + parseFloat(record.data.vl_ntcredito) + parseFloat(record.data.valor_recebido)) );
				return v;
					
                },
				
				name: 'totalGeral',
                dataIndex: 'totalGeral',
                summaryType:'totalGeral',
				fixed:true,
                summaryRenderer: Ext.util.Format.usMoney
            }
			
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
			 //  acao: 'desconto',
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




var formRecValor = new Ext.FormPanel({
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
							fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
									Ext.Ajax.request({ 
									waitMsg: 'Executando...',
									url: 'php/contas_receber.php',
									params: { 
											idPagare: idPagare,
											idVenda: idVenda,
											acao: 'Receber',
											valor: formRecValor.getForm().findField('vlReceber').getValue()  
											},
									success: function(result, request){//se ocorrer correto 
									var jsonData = Ext.util.JSON.decode(result.responseText);
									if(jsonData.response == 'Recebido'){
													Ext.MessageBox.alert('Aviso','Recebido.'); //aki uma funcao se necessario);
													storeContRec.reload(); 
													};
									if(jsonData.response == 'Nopodesrecibir'){
													Ext.MessageBox.alert('Aviso','No podes recibir monto mayor que la deuda.'); //aki uma funcao se necessario);
													};
											}, 
											failure:function(response,options){
												Ext.MessageBox.alert('Alerta', 'Erro...');
													}         
												}) 
											}	
										}  
							},
							{
							bodyStyle:'padding:0px 15px 0'
							}
						
							
						
						]
	  }); 
winRecValor = new Ext.Window({
		title: 'Contas A Receber',
		width:300,
		height:200,
		shim:true,
		closable : true,
		resizable: false,
		closeAction: 'hide',
		bodyStyle:{padding:'10px 10px 10px 10px'},
		draggable: true, //Movimentar Janela
		plain: true,
		modal: true, //Bloquear tela do fundo
		items:[formRecValor,
							{
							xtype:'button',
							text: '<b>Con cheque</b>', 
							name: 'btncheque',
							iconCls:'icon-check',
							handler: function(){ // fechar	
     	    				Ext.Load.file('jstb/CadCheque.js', function(obj, item, el, cache){Cheques();},this);
  			 				}
							}],
		focus: function(){
 	    		formRecValor.getForm().findField('vlReceber').focus()
				}
		
	});
	
///////INICIO DO FORM /////////////////////////////////////////////////////////////////////
        var listaRec = new Ext.FormPanel({
            title       : 'Carteira Receber',
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



