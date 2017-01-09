// JavaScript Document

function DevItens(){
	
//	if(perm.Devolucao.acessar == 0){
//return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
//}
	
	Ext.QuickTips.init();
    Ext.form.Field.prototype.msgTarget = 'side';
	
var win_devolucao; 	
var btnPrintNota;
var  status = null;
var btnItensDev;	
var win_devolucao_iten;	
var nota;
	
var action = new Ext.ux.grid.RowActions({
    header:'Devolver'
   ,autoWidth: false
   , sortable: true
   ,actions:[{
       iconCls:'icon-arrow_down'
      ,tooltip:'Devolucao'
	  ,width: 5
   }] 
});

action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('A��o', String.format('A��o disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	  itenpedido = record.data.id;
	  idpedido = record.data.id_pedido;
	  
	  win_devolucao_iten.show();
	  FormItensDevolucao.getForm().loadRecord(storeItensPedidoDev.getAt(row));
	  /* Ext.Ajax.request({ 
			waitMsg: 'Executando...',
			url: '../sistema/php/Devolucao.php',		
			params: { 
					iditen: itenpedido,
					Pedido: idpedido,
					acao: 'Devolver'
					},
			callback: function (options, success, response) {
					  if (success) { 
									Ext.MessageBox.alert('Aviso', response.responseText);
								   } 
					},
					failure:function(response,options){
						Ext.MessageBox.alert('Alerta', 'Erro...');
					},                                      
					success:function(response,options){
					if(response.responseText == 'ITEN ELIMINADO'){
					storeItensPedido.reload();
							}
					}                                      
		})
	  */
   }
});
	
	
	
	
///COMECA A GRID DOS ITENS ///////////////////////////////////////////////
	  var storeItensPedidoDev = new Ext.data.GroupingStore({
      proxy: new Ext.data.HttpProxy({method: 'POST', url: '../sistema/php/Devolucao.php'}),
      groupField:'id_pedido',
      sortInfo:{field: 'id_pedido', direction: "DESC"},
      reader: new Ext.data.JsonReader({
		 totalProperty: 'total',
	     root:'Itens',
	     fields: [
			{name: 'action'},
			{name: 'id'},
			{name: 'id_pedido', mapping: 'id_pedido'},
			{name: 'referencia_prod',  mapping: 'referencia_prod'},
			{name: 'descricao_prod', mapping: 'descricao_prod'},
	        {name: 'prvenda'},
            {name: 'qtd_produto'},
			{name: 'totals'},
			{name: 'percentual', type: 'float'},
			{name: 'totalGeral'}
 			]
		})
   });	
	
	var gridFormItens = new Ext.BasicForm(
		Ext.get('form10'),
		{
			});
	
    // define a custom summary function
    Ext.grid.GroupSummary.Calculations['totalGeral'] = function(v, record, field){
		return v + (parseFloat(record.data.prvenda) * parseFloat(record.data.qtd_produto));
    }

    var summary = new Ext.grid.GroupSummary(); 
    var grid_ItensPedidoDev = new Ext.grid.EditorGridPanel({
	    store: storeItensPedidoDev,
		//layout: 'column',
		enableColLock: true,
		containerScroll  : false,
		loadMask: {msg: 'Carregando...'},
        columns: [
			action,
			{
                header: "id",
				name: 'id',
                sortable: true,
				align: 'left',
                dataIndex: 'id',
				fixed:true,
				hidden: true
            },
			
            {
                id: 'id_pedido',
                header: "id_pedido",
                width: 100,
                sortable: true,
                dataIndex: 'id_pedido',
                summaryType: 'count',
				fixed:true,
                hideable: false,
                summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '(' + v +' Itens)' : '(1 Iten)');
                }
            },{
                header: "Codigo",
				name: 'referencia_prod',
                sortable: true,
				align: 'left',
                dataIndex: 'referencia_prod',
				fixed:true,
				width: 140
            },
			{	
				id: 'descricao_prod',
                header: "Descricao",
                sortable: true,
				align: 'left',
                dataIndex: 'descricao_prod',
				fixed:true,
				width: 300,
				hidden: false
            },
			
			{
                header: "Valor",
                width: 80,
				align: 'right',
                sortable: true,
                dataIndex: 'prvenda',
			    renderer: Ext.util.Format.usMoney,
				fixed:true
             
            },
			
			{
				header: 'Qtd',
				width: 55,
				align: 'right',
				dataIndex: 'qtd_produto',
				name: 'qtd_produto',
				fixed:true
			},
		
			
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
                return Ext.util.Format.usMoney(parseFloat(record.data.prvenda) * parseFloat(record.data.qtd_produto));
					
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
        frame:false,
        //width: 200,
		autoWidth   : true,
        height: 180,
		border: false,
        clicksToEdit: 1,
		selectOnFocus: true, //selecionar o texto ao receber foco
		selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
		autoScroll:true,
        //title: 'Duplicatas em Aberto',
        iconCls: 'icon-grid',
		tbar: [  
			 //  {xtype: 'button',
			 //   id:'btnItensDev',
			//	text: 'Itens Devolvidos',
			//	iconCls:'icon-grid',
			//	autoShow: false,
			//	tooltip: 'Clique para visualizar os itens devolvidos',
			//	handler: function(){
			//			 ListaProdutosAdd();
			//			 Ext.getCmp('queryPedidoprodAdd').focus(); 
					
			//		} 
			//   },
			   {xtype: 'button',
			    id:'btnPrintNota',
				name: 'btnPrintNota',
				text: 'Nota de Credito',
				iconCls:'icon-print',
				tooltip: 'Clique para imprimir nota de credito',
				handler: function(){
						  id_pedido =  nota;
						 function popup(){
								window.open('../sistema/impressao_devolucao.php?id_pedido='+id_pedido +'','popup','width=750,height=500,scrolling=auto,top=0,left=0')
								}
								popup(); 
					
					} 
			   }
				],
			listeners:{
				destroy: function() {
							if(win_devolucao_iten)
                             win_devolucao_iten.destroy();
							 //sul.remove('grid_pedidos');
         				}
			         }
});

///TERMINA A GRID	
grid_ItensPedidoDev.on('rowdblclick', function(grid, row, e, record) {
			record = grid_ItensPedidoDev.getSelectionModel().getSelected();
			 itenpedido = record.data.id;	
			 
			 idPed = grid_ItensPedidoDev.getColumnModel().getDataIndex(1); // Get field name
			 idpedido = record.get(idPed);	
									   
			record = grid_ItensPedidoDev.getSelectionModel().getSelected();
													Pedido = Ext.get('pedidoDevolucao').getValue();
													//dtdDev = Ext.get('qtd_produtos').getValue();
													prodnota = record.data.qtd_produto;
													
												//	if(parseFloat(dtdDev) <= parseFloat(prodnota)){
													
													var Record = Ext.data.Record.create(['id','Codigo','Descricao','qtd','valor']);
													vlorig = record.data.prvenda;
													perc = record.data.percentual;
													vldesc = vlorig / 100 * perc;
													vlfinal = vlorig - vldesc;
													
													var dados = new Record({
													"id":record.data.id,
													"Codigo":record.data.referencia_prod, 
													"Descricao":record.data.descricao_prod,
													"qtd":"0",
													"valor":vlfinal
												});
												
												dsProdDev.insert(0,dados);
												gridProdDev.startEditing(0,3);
											//	dsProdDev.commitChanges();
												
												//console.info(datas);
												//}
											//	else{
											//		Ext.MessageBox.alert('Alerta', 'Quantidade superior a vendida');
											//	}
}); 


var dsProdDev = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: '../sistema/php/Devolucao.php',
			method: 'POST'
		}), 
		listeners:{
   				load:function(){
				//imagem = dsProdVend.getAt(0).get('imagem');
				// console.info(imagem);
				dsProdDev.commitChanges();
  			 }
			},  
		reader:  new Ext.data.JsonReader({
			root: 'results',
			id: 'id'
		},
			[
				   {name: 'id'},
				   {name: 'Codigo'},
		           {name: 'Descricao'},
		           {name: 'qtd', type: 'float'},
				   {name: 'valor', type: 'float'},
				   {name: 'totalcol', type: 'float'}
				  
				   
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		remoteSort: true		
	});
	
	var gridProdDev = new Ext.grid.EditorGridPanel({
	        store: dsProdDev, // use the datasource
	        columns:[
						{id:'id',header: "id", hidden: true, width: 50, sortable: true, dataIndex: 'id'},
						{header: 'Codigo', width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descricao", width: 180, sortable: true, dataIndex: 'Descricao'},
						{header: "Qtd", width: 50,  align: 'right',  sortable: true, dataIndex: 'qtd',
						 editor: new Ext.form.NumberField({
						allowBlank : false,
						selectOnFocus:true,
						allowNegative: false
						})
						},
						{header: "Valor", width: 90, align: 'right', sortable: true, dataIndex: 'valor', renderer: 'usMoney'},
						{header: "Total", width: 100, align: 'right', sortable: true, dataIndex: 'totalcol', 
						renderer: function Cal(value, metaData, rec, rowIndex, colIndex, store) {
						return  Ext.util.Format.usMoney(rec.data.valor * rec.data.qtd);
						}
						}
			 ],
	        viewConfig:{
	            forceFit:true
	        },
			width:600,
			title: 'Itens a Devolver',
			id: 'id',
			height: 150,
			ds: dsProdDev,
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			autoScroll: true,
			bbar: new Ext.PagingToolbar({
				store: dsProdDev,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				pageSize: 40,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina", 
				items:[
						{
						xtype: 'button',
						name: 'incluir',
						text: 'Grabar',
						iconCls: 'icon-save',
						handler: function(){
								jsonData = "[";
									for(d=0;d<dsProdDev.getCount();d++) {
									record = dsProdDev.getAt(d);
									if(record.data.newRecord || record.dirty) {
										jsonData += Ext.util.JSON.encode(record.data) + ",";
										}
									}
								jsonData = jsonData.substring(0,jsonData.length-1) + "]";
								//alert(jsonData);
							Ext.Ajax.request({
								waitMsg: 'Enviando Cotac�o, por favor espere...',
								url:'../sistema/php/Devolucao.php',
								params:{
								data: jsonData,
								acao: "Devolver",
								user: id_usuario,
								pedido: Ext.get('pedidoDevolucao').getValue()
								},
								callback: function (options, success, response) {
										if (success) { 
											//Ext.MessageBox.alert('OK', response.responseText);
											var json = Ext.util.JSON.decode(response.responseText);
												if(json.response == 'Produto Devolvido'){
													Ext.MessageBox.alert('Alerta', json.response+ ', Nota de Credito:'+ json.ntcredito);
													dsProdDev.removeAll();
													storeItensPedidoDev.removeAll();
												} 
												else {
													mens = json.del_count + " Erro ocorrido.";
												}
												//Ext.MessageBox.alert('Alerta', mens);
											} 
											else{
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										},
										failure:function(response,options){
											Ext.MessageBox.alert('Alerta', 'Erro... Intente Novamente');
										},                                      
										success:function(response,options){
											//Ext.getCmp('tabss').remove(FormlistaProdsP);
										}       
															
							}
						);						
											
							}
						}
					],
				refreshText : "Atualizar"
			//	paramNames : {start: 'start', limit: 'limit'}
			}),
		clicksToEdit:1
		});
		
 gridProdDev.on('validateedit', function(e) {

  if (e.value > prodnota) {
    e.cancel = true;
    e.record.data[e.field] = e.value;
	Ext.MessageBox.alert('Alerta', 'Quantidade superior a vendida', function(btn){
						if(btn == "ok"){
							gridProdDev.startEditing(0,3);
						} })
  }
});

var FormGridDevolucao = new Ext.FormPanel({
			frame		: true,
			layout      : 'form',
			border 		: false,
            split       : true,
			region      : 'center',
            autoWidth   : true,
			height		: 233,
            collapsible : false,
			items:[grid_ItensPedidoDev]
});

var FormItensDevolucao = new Ext.FormPanel({
			frame		: true,
			layout      : 'form',
			border 		: false,
            split       : true,
			//region      : 'center',
            autoWidth   : true,
			height		: 233,
            collapsible : false,
			items:[{
							 xtype: 'textfield',
                    		 fieldLabel: 'Codigo',
							 readOnly: true,
							 id: 'referencia_prod',
                    		 name: 'referencia_prod'
							 },
							 {
							 xtype: 'textfield',
							 readOnly: true,
                    		 fieldLabel: 'Descricao',
							 id: 'descricao_prod',
                    		 name: 'descricao_prod'
							 },
							 {
							 xtype: 'numberfield',
							 readOnly: true,
                    		 fieldLabel: 'Valor',
							 id: 'prvenda',
                    		 name: 'prvenda'
							 },
							 {
							 style: 'margin-top:15px',
							 float:'left'
					 		 },
							 {
							 xtype       : 'fieldset',
							 title       : 'Informe a quantidade a ser devolvida',
							 layout      : 'form',
							 collapsible : false,                    
							 collapsed   : false,
							 autoHeight  : true,
							 forceLayout : true,
							 items: [
							 {
							 xtype: 'numberfield',
                    		 fieldLabel: 'Quantidade',
							 id: 'qtd_produtos',
                    		 name: 'qtd_produtos',
							 fireKey: function(e,type){
													if(e.getKey() == e.ENTER) {
													record = grid_ItensPedidoDev.getSelectionModel().getSelected();
													Pedido = Ext.get('pedidoDevolucao').getValue();
													dtdDev = Ext.get('qtd_produtos').getValue();
													prodnota = record.data.qtd_produto;
													if(parseFloat(dtdDev) <= parseFloat(prodnota)){
													
													var Record = Ext.data.Record.create(['id','Codigo','Descricao','qtd','valor']);
													vlorig = record.data.prvenda;
													perc = record.data.percentual;
													vldesc = vlorig / 100 * perc;
													vlfinal = vlorig - vldesc;
													
													var dados = new Record({
													"id":record.data.id,
													"Codigo":record.data.referencia_prod, 
													"Descricao":record.data.descricao_prod,
													"qtd":dtdDev,
													"valor":vlfinal
												});
												
												dsProdDev.insert(0,dados);
												
												
												dsProdDev.commitChanges();
												
												//console.info(datas);
												}
												else{
													Ext.MessageBox.alert('Alerta', 'Quantidade superior a vendida');
												}
												
												}
           								
				 					}         
									}]
									//}
							 }
							 
							 ]
});

 if (win_devolucao_iten == null){
				win_devolucao_iten = new Ext.Window({
					id:'win_devolucao_iten'
					, border 	: false
					, title: "Devolucao de produto"
	                , layout: 'form'
	                , width: 350
					, height: 250
	                , closeAction :'hide'
	                , plain: true
					, modal: true
					, items:[FormItensDevolucao]
					,buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_devolucao_iten.hide();
  			 					}
        			}
					]
					,focus: function(){
 	   					 Ext.get('qtd_produtos').focus();
						}

				});
				
				
			}

var FormInfPedido = new Ext.FormPanel({
			id: 'FormInfPedido',
			frame		: true,
            split       : true,
			title		: 'Devolucao Itens',
            autoWidth   : true,
			layout      : 'form',
			closable: true,
			height: 300,
			items:[
				   {
					xtype       : 'fieldset',
					title       : 'Informe o numero do Pedido',
					collapsible : false,                    
					collapsed   : false,
					autoHeight  : true,
					forceLayout : true,
					items: [{
           				 layout:'column',
            			 items:[{
                		 columnWidth:.4,
						 autoHeight  : true,
                		 layout: 'form',
						 items: [
									{
									xtype: 'numberfield',
									fieldLabel: 'Pedido',
									id: 'pedidoDevolucao',
									name: 'pedidoDevolucao',
									width: 120,
									fireKey: function(e,type){
													if(e.getKey() == e.ENTER) {
														Ext.Ajax.request({
														url: '../sistema/php/Devolucao.php', 
														params : {
														user : id_usuario,
														acao: 'listar',
														Pedido: Ext.get('pedidoDevolucao').getValue()
														 },
														 success: function(result, request){//se ocorrer correto 
														var jsonData = Ext.util.JSON.decode(result.responseText);
														status = jsonData.response;
														nota = jsonData.ntcredito;
														if(jsonData.response != 'PedidoNaoEncontrado'){ 
															Ext.getCmp('btnPrintNota').setVisible(false);
															//Ext.getCmp('btnItensDev').setVisible(false);
															storeItensPedidoDev.load({params: {Pedido: jsonData.response, acao: 'ListaItens'}});
														}
														if(jsonData.ntcredito != ''){
															Ext.getCmp('btnPrintNota').setVisible(true);
															//Ext.getCmp('btnItensDev').setVisible(true);
														}
														if(jsonData.response == 'PedidoNaoEncontrado'){ 
															Ext.MessageBox.alert('Alerta', 'Pedido todavia no Facturado, o no existe');
														}
														}
																		 })
													}         
													}
									}
								]
					
							   }
							   
							   ]
							}]
					
					
					 },
					 grid_ItensPedidoDev,gridProdDev
					 ]
			
});





Ext.getCmp('tabss').add(FormInfPedido);
Ext.getCmp('tabss').setActiveTab(FormInfPedido);
FormInfPedido.doLayout();	

if(status == null){
Ext.getCmp('btnPrintNota').setVisible(false);
//Ext.getCmp('btnItensDev').setVisible(false);
} 
else {
Ext.getCmp('btnPrintNota').setVisible(true);
//Ext.getCmp('btnItensDev').setVisible(false);
}
Ext.get('pedidoDevolucao').focus();

}