// JavaScript Document
Ext.onReady(function(){
Ext.get("devolucao").on('click',function(s,e){
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
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	  itenpedido = record.data.id;
	  idpedido = record.data.id_pedido;
	  
	  win_devolucao_iten.show();
	  FormItensDevolucao.getForm().loadRecord(storeItensPedidoDev.getAt(row));
	  /* Ext.Ajax.request({ 
			waitMsg: 'Executando...',
			url: 'php/Devolucao.php',		
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
      proxy: new Ext.data.HttpProxy({method: 'POST', url: 'php/Devolucao.php'}),
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
        height: 235,
		border: false,
        clicksToEdit: 1,
		selectOnFocus: true, //selecionar o texto ao receber foco
		selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
       // collapsible: false,
       // animCollapse: false,
        //trackMouseOver: false,
        //enableColumnMove: true,
		//stripeRows: true,
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
								window.open('../impressao_devolucao.php?id_pedido='+id_pedido +'','popup','width=750,height=500,scrolling=auto,top=0,left=0')
								}
								popup(); 
					
					} 
			   }
		]
});
///TERMINA A GRID	
grid_ItensPedidoDev.on('rowdblclick', function(grid, row, e, record) {
			record = grid_ItensPedidoDev.getSelectionModel().getSelected();
			 itenpedido = record.data.id;	
			 
			 idPed = grid_ItensPedidoDev.getColumnModel().getDataIndex(1); // Get field name
			 idpedido = record.get(idPed);	
									   
			win_devolucao_iten.show();
	 		FormItensDevolucao.getForm().loadRecord(storeItensPedidoDev.getAt(row));
}); 


//itenpedido = record.data.id;
//	  idpedido = record.data.id_pedido;

var FormInfPedido = new Ext.FormPanel({
			frame		: true,
			region      : 'north',
            split       : true,
            autoWidth   : true,
			height	: 80,
            collapsible : false,
			items:[
				   {
					xtype       : 'fieldset',
					title       : 'Informe o numero do Pedido',
					layout      : 'form',
					collapsible : false,                    
					collapsed   : false,
					autoHeight  : true,
					forceLayout : true,
					items: [{
           				 layout:'column',
            			items:[{
                		columnWidth:.4,
                		layout: 'form',
					items       : [
					{
					xtype: 'numberfield',
                    fieldLabel: 'Pedido',
					id: 'pedidoDevolucao',
                    name: 'pedidoDevolucao',
                    width: 120,
					listeners:{
								keyup:function(field, key){ //alert(key.getKey());
									if(key.getKey() == key.ENTER) {
										Ext.Ajax.request({
            							url: '../php/Devolucao.php', 
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
											Ext.MessageBox.alert('Alerta', 'Pedido nao Encontrado');
										}
										}
														 })
				 					}         
									}
									}
					}
					]
					
							   },
							   {
                		columnWidth:.3,
                		layout: 'fit',
						items       : [{}]
						
						
						}
							   
							   ]
							}]
					
					
					 }
					 ]
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
							 id: 'qtd_produto',
                    		 name: 'qtd_produto',
							 listeners:{
								keyup:function(field, key){ //alert(key.getKey());
									if(key.getKey() == key.ENTER) {
										Ext.Ajax.request({
            							url: '../php/Devolucao.php', 
            							params : {
			   							user : id_usuario,
										acao: 'Devolver',
			   							idIten: itenpedido,
										Pedido: Ext.get('pedidoDevolucao').getValue(),
										dtdDev: Ext.get('qtd_produto').getValue()
           								 },
										 success: function(result, request){//se ocorrer correto  
										var jsonData = Ext.util.JSON.decode(result.responseText);
										nota = jsonData.ntcredito;
										resposta = jsonData.response;
											Ext.MessageBox.alert('Aviso', resposta);
											if(jsonData.response == 'Produto Devolvido'){
											Ext.getCmp('btnPrintNota').setVisible(true);
											//Ext.getCmp('btnItensDev').setVisible(true);
											storeItensPedidoDev.reload();
										}
										}
														 })
				 					}         
									}
									}
							 }
							 ]}]
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
								//FormInfPedido.getForm().reset();
  			 					}
        			}
					]
					,focus: function(){
 	   					 Ext.get('qtd_produto').focus();
						}

				});
				
				
			}

 if (win_devolucao == null){
				win_devolucao = new Ext.Window({
					id:'win_devolucao'
					, border 	: false
					, title: "CP SA"
	                , layout: 'form'
	                , width: '65%'
					, height: 400
	                , closeAction :'close'
	                , plain: true
					, modal: false
					, resizable: false
					, items:[FormInfPedido,FormGridDevolucao]
					,buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_devolucao.close();
								FormInfPedido.getForm().reset();
								win_devolucao_iten.destroy();
  			 					}
        			}
					]
					,focus: function(){
 	   					 Ext.get('pedidoDevolucao').focus();
						}

				});
				
				
			}

  win_devolucao.show();


if(status == null){
Ext.getCmp('btnPrintNota').setVisible(false);
//Ext.getCmp('btnItensDev').setVisible(false);
} 
else {
Ext.getCmp('btnPrintNota').setVisible(true);
//Ext.getCmp('btnItensDev').setVisible(false);
}




	});	
});