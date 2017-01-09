// JavaScript Document
Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
  
Ext.QuickTips.init();
Ext.form.Field.prototype.msgTarget = 'side';
	
ContReceber = function(){

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
	  }
	  ] 
});


action.on({
   action:function(grid, record, action, row, col) {
    //  Ext.Msg.alert('Ação', String.format('acao: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  
		console.info(record);
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
					width: 650,
					height: 200,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { },
						buttons:[
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_rec.destroy();
  			 					}
        					}]
				});
				win_rec.show();
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





//////////////////////////////////////////////////////////////////////////////

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
						iconCls: 'icon-print',
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
						}
						
  			 			
						
  			 			
					//	, '<b>Total=</b>',''
		
		] 
						   })
		
});
dsContRec.load(({params:{acao:'acao', 'start':0, 'limit':200}}));
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
 			]
		})
   });
	
var gridFormContRec = new Ext.BasicForm(
		Ext.get('form4'),
		{
			});
    // define a custom summary function
    Ext.grid.GroupSummary.Calculations['totalGeral'] = function(v, record, field){
		var juro = record.data.valor_juros;
		if(juro < 0)
		juro = 0;
return v + ( parseFloat(record.data.vl_parcela) - ( parseFloat(record.data.desconto) + parseFloat(record.data.valor_recebido) ) );
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
                },
				editor: new Ext.form.NumberField({
						allowBlank : false,
						selectOnFocus:true,
						allowNegative: false
			   })
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
                var v = Ext.util.Format.usMoney( parseFloat(record.data.vl_parcela)  - (parseFloat(record.data.desconto) + parseFloat(record.data.valor_recebido)) );
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
           			
				//	, '<b>Total=</b>',''
				] 
		}),
		listeners:{ 
        afteredit:function(e){
           var params = {
               id: e.record.get('id'),
               valor: e.value,
			   campo: e.column,
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
									   
			storeContRec.baseParams.idCli = idCli;
			storeContRec.load();
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
							fieldLabel: 'Valor',
							name: 'vlReceber',
							fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
									Ext.Ajax.request({ 
									waitMsg: 'Executando...',
									url: 'php/contas_receber.phpp',
									params: { 
											idPagare: idPagare,
											idVenda: idVenda,
											vlPago: formRecValor.getForm().findField('vlReceber').getValue()
											},
									success: function(result, request){//se ocorrer correto 
									var jsonData = Ext.util.JSON.decode(result.responseText);
									if(jsonData.response == 'Recebido'){
													Ext.MessageBox.alert('Aviso','Recebido.'); //aki uma funcao se necessario);
													storeContRec.reload(); 
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
		draggable: true, //Movimentar Janela
		plain: true,
		modal: true, //Bloquear tela do fundo
		items:[formRecValor],
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



