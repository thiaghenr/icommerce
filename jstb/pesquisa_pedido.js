// JavaScript Document


AbrePedido = function(){


// if(perm.pesquisa_pedido.acessar == 0){
// return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
// }
Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
Ext.QuickTips.init();

//function popup(){
//window.open('autoriza.php','popup','width=750,height=500,scrolling=auto,top=0,left=0')
//}

function getKey(e){
	var tecla;
	if(!e)
		e = window.event;
	if(e.keyCode)
		tecla = e.keyCode;
	else if(e.which)
		tecla = e.which;
	return tecla;
}




/// ICONES NA GRID ///////////////////////////////

var action = new Ext.ux.grid.RowActions({
    header:'Excluir'
 //  ,anchor: '10%'
  ,width: 15
  ,autoWidth: false
   ,actions:[{
       iconCls:'icon-excluir'
      ,tooltip:'Excluir'
	//  ,width: 1
   }] 
});

action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	  itenpedido = record.data.id;
	  idpedido = record.data.id_pedido;
	  Ext.Ajax.request({ 
			waitMsg: 'Executando...',
			url: 'php/deleta_iten_pedido.php',		
			params: { 
					iditen: itenpedido,
					idpedido: idpedido
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
   }
});

//console.info(action);

//// FIM ICONES NA GRID //////////////////////////////////////////////////
var ListaProdutoAdd;
 var idData;
var xgProdPesquisaAdd = Ext.grid;
var btnAddIten;
var situacao = 'F';
var xgPedido = Ext.grid;
//var grid_ItensPedido = Ext.grid;
var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Por favor selecione um pedido');
}




var formataSitPedido = function(value){
	
	if(value=='A')
		  return '<span style="color: #FF0000;">Pendente</span>';
		else if(value=='F')
		  return 'Faturado';
   	    else if(value=='D')
		  return 'Devolvido';
		else
		  return '<span style="color: #6EEAE9;">Cancelado</span>'; 

};
var CorTotal = function(value){
    return  '<span style="color: #E5872C;">'+value+'</span>'; 
}

//////FUNCAO DELETAR PEDIDO /////////////////////////
var deletarPedido = function(){
					var selectedKeys = grid_Pedidos.selModel.selections.keys; 
					if(selectedKeys.length > 0)
					{
						Ext.MessageBox.confirm('Alerta', 'Deseja deletar esse registro?', function(btn) {
							if(btn == "yes"){	
								var selectedRows = grid_Pedidos.selModel.selections.items;
								var selectedKeys = grid_Pedidos.selModel.selections.keys; 
								var encoded_keys = Ext.encode(selectedKeys);
			
								Ext.Ajax.request(
								{ 
									waitMsg: 'Executando...',
									url: 'php/deleta_pedido.php',		
									params: { 
										id: encoded_keys,
										key: 'idPedido'										
									},
										
									callback: function (options, success, response) {
										if (success) { 
										//	Ext.MessageBox.alert('Aviso', response.responseText);
											var json = Ext.util.JSON.decode(response.responseText);
												if(json.del_count == 1){
													mens = "1 Registro deletado.";
												} else {
													mens = json.del_count + " Registros deletados.";
												}
												Ext.MessageBox.alert('Alerta', json.response);
											} else{
												Ext.MessageBox.alert('Desculpe, por favor tente novamente. [Q304]',response.responseText);
											}
										},
										
										failure:function(response,options){
											Ext.MessageBox.alert('Alerta', 'Erro...');
										},                                      
										success:function(response,options){
											dsPesquisaPedido.reload();
										}                                      
									 } 
								);						
							}	
						});
					}
					else
					{
						selecione();
					}
				}
/////////////////////////////////////////////	

////////////// IMPRIMIR ////////////////////
var imprimirPedido = function(){
var selectedKeys = grid_Pedidos.selModel.selections.keys; 
					if(selectedKeys.length > 0){	
								var selectedRows = grid_Pedidos.selModel.selections.items;
								var selectedKeys = grid_Pedidos.selModel.selections.keys; 
								
								Ext.Ajax.request({
									url: 'impressao.php',
									params: {
									   id_pedido: selectedKeys
									}
									});
//								function popup(){
//window.open('../impressao.php?id_pedido='+selectedKeys +'','popup','width=750,height=500,scrolling=auto,top=0,left=0')
//}
//popup();
}
else{
selecione();
}
}
///////////////////////////////////////////////////									 
/////////////// PDF //////////////////////////////
var imprimirPedidoPDF = function(){
var selectedKeys = grid_Pedidos.selModel.selections.keys;
if(selectedKeys.length > 0){	
var selectedRows = grid_Pedidos.selModel.selections.items;
var selectedKeys = grid_Pedidos.selModel.selections.keys; 
																
var win_ImprimirPDF = new Ext.Window({
					id: 'imprimePedido',
					title: 'Pedido',
					width: 650,
					height: 500,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='../pedido_ok.php?id_pedido="+selectedKeys +"' > </iframe>" },
					buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_ImprimirPDF.destroy();
  			 					}
			 
        					}]
				});
				win_ImprimirPDF.show();
			}
else{
selecione();
}
}


/////////////////////// INICIO STORE //////////////////////////////////
dsPesquisaPedido = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: 'php/pesquisa_pedido.php',
        method: 'POST'
    }),   

reader:  new Ext.data.JsonReader({
			totalProperty: 'total',
			root: 'results',
			id: 'id',
			fields: [
					 {name: 'idPedido',  type: 'string', mapping: 'id' },
					 {name: 'ClientePedido',  type: 'string', mapping: 'nome_cli' },
					 {name: 'totalPedido',  type: 'string', mapping: 'total_nota' },
					 {name: 'dataPedido',  type: 'string', mapping: 'data' },
					 {name: 'situacaoPedido',  type: 'string', mapping: 'situacao' },
					 {name: 'desconto',  type: 'float', mapping: 'desconto' },
					 {name: 'nform',  type: 'string' },
					 {name: 'formaPago',  type: 'string', mapping: 'descricao'},
					 {name: 'usuarioPedido',  type: 'string', mapping: 'nome_user' }
					 //{name: 'action1', type: 'string'},
   			         //{name: 'action2', type: 'string'}

					 ]
			}),					    
			baseParams:{acao: 'listarPedidos'}
		})
///////////// FIM STORE ////////////////////////
///////////// INICIO DA GRID //////////////////

	     var grid_Pedidos = new Ext.grid.GridPanel({
	        store: dsPesquisaPedido, // use the datasource
	       cm: new xgPedido.ColumnModel([
		       
		        	//expander,
		            {id:'idPedido', width:40, header: "Pedido",  sortable: true, dataIndex: 'idPedido'},
					{id:'ClientePedido', width:130, header: "Cliente",  sortable: true, dataIndex: 'ClientePedido'},
					{id:'totalPedido', width:60, header: "Total", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'totalPedido'},
					{id:'desconto', width:40, header: "Descuento", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'desconto'},
					{id:'nform', width:60, header: "Facturas", align: 'right', sortable: true, dataIndex: 'nform'},
					{id:'dataPedido', width:40, header: "Data", align: 'right', sortable: true, dataIndex: 'dataPedido'},
					{id:'situacaoPedido', width:50, header: "Situacao", align: 'right', renderer: formataSitPedido,  sortable: true, dataIndex: 'situacaoPedido'},
					{id:'formaPago', width:40, header: "Forma Pago", align: 'right',  sortable: true, dataIndex: 'formaPago'},
					{id:'usuarioPedido', width:40, header: "Usuario",align: 'right',  sortable: true, dataIndex: 'usuarioPedido'}
					//action

					
		        ]), 
	        viewConfig:{ 
			forceFit:true
			},
			//plugins : action,
			animCollapse: false,
			enableColLock: false,
			loadMask:true,
			autoWidth:true,
			//autoHeight: true,
			height: 300,
	        stripeRows:true,
			listeners: {
			keypress: function(e){
				
			if(e.getKey()  >47 && e.getKey() < 58 || e.getKey() >64 && e.getKey() < 91 || e.getKey() >95 && e.getKey() < 106 ){	
				
 	   					 Ext.get('queryPedido').focus();
			
				
			}}},
			tbar : new Ext.Toolbar({
			align:'left',
         	buttons: [	
           				{
           			    text: 'Excluir',
						id: 'esc',
						align: 'left',
						iconCls: 'icon-excluir',
            			handler: function(){ // fechar	
     	    			deletarPedido();
						}
  			 			},
						'-',
						{
           			    text: 'pdf',
						id: 'pdf',
						align: 'left',
						iconCls: 'icon-pdf',
            			handler: function(){ // fechar	
     	    			imprimirPedidoPDF();
  			 			}
						},
						'-',
						{
           			    text: 'imprimir',
						id: 'printer',
						align: 'left',
						iconCls: 'icon-print',
            			handler: function(){ // fechar	
     	    			imprimirPedido();
  			 			}
						},
						'-',
						 {
				xtype: 'button',
			    id:'btnAddIten',
				text: 'Adicionar Itens',
				//autoShow: false,
				//hidden:  (situacao == 'A'),
				iconCls:'icon-add',
				tooltip: 'Clique para incluir novo iten',
				handler: function(){
						 ListaProdutosAdd();
						 Ext.getCmp('queryPedidoprodAdd').focus(); 
					
					} 
			   },'-',
						{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: true,
				editable: false,
				mode: 'local',
				triggerAction: 'all',
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Pesquisa',
				id: 'sitID',
				minChars: 2,
				name: 'sitID',
                emptyText: 'N.Pedido',
				width: 120,
				forceSelection: true,
				store: [
                            ['id','Pedido'],
                            ['nome_cli','Nome'],
                            ['ruc','ruc']
                            ]
                },
						{
					xtype: 'textfield',
	                fieldLabel: 'Pesquisa',
	                name: 'queryPedido',
					id: 'queryPedido',
					emptyText: 'Pesquise aqui',
					width: 200,
					//enableKeyEvents: true,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							var theQuery= Ext.getCmp('queryPedido').getValue();
							 if(e.getKey() == e.ENTER) {//precionar enter   
							dsPesquisaPedido.load({params:{query: theQuery, combo: Ext.getCmp('sitID').getValue()}});
							 }
						}				
					}
	            }
						
			 
        ]
    }),
			bbar: new Ext.PagingToolbar({
				store: dsPesquisaPedido,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Não tem dados",
				pageSize: 40,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina",    
				refreshText : "Atualizar"
			//	paramNames : {start: 'start', limit: 'limit'}
			})
		});
		dsPesquisaPedido.load({params:{acao: 'listarPedidos',start: 0, limit: 40}});

		grid_Pedidos.on('rowclick', function(grid, row, e) {
					 selectedKeys = grid_Pedidos.selModel.selections.keys;
					if(selectedKeys.length > 0){	
					 selectedRows = grid_Pedidos.selModel.selections.items;
					 selectedKeys = grid_Pedidos.selModel.selections.keys; 
					
					record = grid_Pedidos.getSelectionModel().getSelected();
					var colName = grid_Pedidos.getColumnModel().getDataIndex(4); // Get field name
					var situacao = record.get(colName);
					
					storeItensPedido.load({params:{pedidoid: selectedKeys}});
				
					if(situacao == 'F' || situacao == 'D'){
          			Ext.getCmp('btnAddIten').setVisible(false);
        			 } else {
            		Ext.getCmp('btnAddIten').setVisible(true);
		 			}
					
					}
		});


			
		
	
 
//////////////////////////// FIM DA GRID ///////////////////////////////


///COMECA A GRID DOS ITENS ///////////////////////////////////////////////
	  var storeItensPedido = new Ext.data.GroupingStore({
      proxy: new Ext.data.HttpProxy({method: 'POST', url: 'php/lista_itens_pedido.php'}),
      groupField:'id_pedido',
      sortInfo:{field: 'id_pedido', direction: "DESC"},
      reader: new Ext.data.JsonReader({
		 totalProperty: 'total',
	     root:'Itens',
	     fields: [
			{name: 'action1', type: 'string'},
			{name: 'id'},
			{name: 'id_pedido', mapping: 'id_pedido'},
			{name: 'referencia_prod',  mapping: 'referencia_prod'},
			{name: 'descricao_prod', mapping: 'descricao_prod'},
	        {name: 'prvenda', type: 'float'},
            {name: 'qtd_produto', type: 'float'},
			{name: 'totais'},
			{name: 'totalGeral'}
 			]
		})
   });
	
var gridFormItens = new Ext.BasicForm(
		Ext.get('form13'),
		{
			});
    // define a custom summary function
    Ext.grid.GroupSummary.Calculations['totalGeral'] = function(v, record, field){
		return v + (parseFloat(record.data.prvenda) * parseFloat(record.data.qtd_produto));
    }

    var summary = new Ext.grid.GroupSummary(); 
     grid_ItensPedido = new Ext.grid.EditorGridPanel({
	    store: storeItensPedido,
       // id: 'grid_ItensPedido',
		enableColLock: true,
		containerScroll  : true,
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
				width: 150
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
				fixed:true,
                editor: new Ext.form.NumberField({
						allowBlank : false
			    })
             
            },
			
			{
				header: 'Qtd',
				width: 55,
				align: 'right',
				dataIndex: 'qtd_produto',
				name: 'qtd_produto',
				fixed:true,
				editor: new Ext.form.NumberField({
						allowBlank : false
			   })
			},
		
			
			{	
				dataIndex: 'totais',
                id: 'totais',
                header: "Total",
				name: 'totais',
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
		autoWidth:true,
       // height: 140,
	   autoHeight: true,
		border: true,
        clicksToEdit: 1,
		selectOnFocus: true, //selecionar o texto ao receber foco
        trackMouseOver: false,
        enableColumnMove: false,
		stripeRows: true,
		autoScroll:true,
		listeners:{ 
        afteredit:function(e){
         Ext.Ajax.request({
            url: 'php/update_itens_pedido.php',
            params: {
               id: e.record.get('id'),
               valor: e.value,
			   campo: e.column,
			   pedido: e.record.get('id_pedido')
            },
			success: function(){
                           //Ext.example.msg('Informa&ccedil;&atilde;o','Registro atualizado com sucesso');
                           storeItensPedido.commitChanges();
                        },
			failure: function(){
                           Ext.example.msg('Erro','N&atilde;o foi possivel Alterar.');
                           storeItensPedido.rejectChanges();
                        }
         })
      },
	   editcomplete:function(ed,value){
	                   setTimeout(function(){
	                       if(ed.col == 5){				
	                               grid_ItensPedido.startEditing(ed.row,ed.col+1);
	                               }
	                    }, 250);
	                   }
	  }
});
///TERMINA A GRID	

////////////////////// INICIO ADD NOVO ITEN ////////////////////////////////////////////////////
// COMBO PESQUISA DE PRODUTOS////////////////////////////

	
    var	produtos_pedidopAdd = new Ext.FormPanel({
			region      : 'north',
		    autoWidth: true,
			id: 'produtos_pedidopAdd',
            layout: 'form',
	        frame:true,
			items: [					
			    {
				xtype:'combo',
				hideTrigger: false,
				allowBlank: true,
				editable: false,
				mode: 'local',
				triggerAction: 'all',
				selectOnFocus: true,
				fieldLabel: 'Pesquisar por',
				id: 'comboPedidoprodAdd',
				minChars: 2,
				name: 'comboPedidoprodAdd',
                emptyText: 'Codigo',
				width: 120,
				forceSelection: true,
				store: [
                        ['Codigo', 'Codigo'],
                        ['Descricao', 'Descricao']
                        ]
                },
					{
                    xtype: 'textfield',
	                fieldLabel: 'Pesquisa',
	                name: 'queryPedidoprodAdd',
					id: 'queryPedidoprodAdd',
                    col:true,
	                allowBlank:true,              
					fireKey: function(e,type){
							if(e.getKey() == 40  ){//seta pra baixo  
							   grid_listaProdDetalhesAdd.getSelectionModel().selectFirstRow();
							   grid_listaProdDetalhesAdd.getView().focusEl.focus();
                            }
							var ProdtheQuery=Ext.getCmp('queryPedidoprodAdd').getValue();
							if(e.getKey() == e.ENTER ){
							dsProdPedidoAdd.load({
								params:{	
									query: ProdtheQuery,
									combo: Ext.getCmp('comboPedidoprodAdd').getValue()
								    }
																
							});
							
					}
               
					}
	            }
	        ],
			focus: function(){
                Ext.get('queryPedidoprodAdd').focus(); 
      }				
 });
	
//////// INICIO DA GRID DOS VENDIDOS ////////
var storelistaProdVendAdd = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod_det_vend.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'idped'},
				   {name: 'controle_cli'},
		           {name: 'nome_cli'},
		           {name: 'data_car'},
		           {name: 'qtd_produto'},
		           {name: 'prvenda'},
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		//id: 9,
		remoteSort: true		
	});
 var DetProdVendAdd = new Ext.grid.EditorGridPanel(
	    {
	        store: storelistaProdVendAdd, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "Pedido", width: 50, sortable: true, dataIndex: 'idped'},
						{header: 'Codigo', width: 80, sortable: true, dataIndex: 'controle_cli'},
						{header: "Nome", width: 230, sortable: true, dataIndex: 'nome_cli'},
						{header: "Data", width: 90, align: 'right', sortable: true, dataIndex: 'data_car' /*, renderer: change*/},
						{header: "Qtd", width: 80,  align: 'right',  sortable: true, dataIndex: 'qtd_produto'},
						{header: "Valor", width: 90, align: 'right', sortable: true, dataIndex: 'prvenda'}
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			width:'100%',
			id: 'prodsVdP',
			height: 100,
			ds: storelistaProdVendAdd,
			selModel: new Ext.grid.CellSelectionModel({singleSelect:false}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true
			
		
});
 ////////FIM GRID DOS DETALHES ///////////////////////////////////////////////////


//////////////////// GRID DA PESQUISA DE PRODUTOS //////////////////////////////////////////////////////////////
var DtProdsVendidosAdd = new Ext.FormPanel({
			id: 'sulVendAdd',
			labelAlign: 'top',
            region      : 'south',
			height		:180,
			frame       :true,
			items: [{
            layout:'form',
            items:[{
                width: '100%',
				style: 'padding:0px; border:0px; margin:0px;',
                layout: 'form',
                items: [DetProdVendAdd]},
				{
                width: '100%',
                layout: 'form',
                items: []}
				  ]
					}]
	  }); 



 		dsProdPedidoAdd = new Ext.data.Store({
                url: 'php/lista_prod_pedido.php',
              //  method: 'POST'
            reader:  new Ext.data.JsonReader({
				totalProperty: 'totalProdutos',
				root: 'resultsProdutos',
				id: 'id',
				fields: [
				   {name: 'id'},
				   {name: 'Codigo'},
		           {name: 'Descricao'},
		           {name: 'Estoque'},
		           {name: 'qtd_bloq'},
		           {name: 'valorA', mapping: 'valor_a'},
				   {name: 'valorB', mapping: 'valor_b'},
				   {name: 'valorC', mapping: 'valor_c'}
				
			]
			})					    
			
		})


	     var grid_listaProdDetalhesAdd = new Ext.grid.GridPanel(
	    {
	        store: dsProdPedidoAdd, // use the datasource
	        
	        cm: new xgProdPesquisaAdd.ColumnModel(
		        [
		        	//expander,
		           		{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descricao", width: 200, sortable: true, dataIndex: 'Descricao'},
						{header: "Disponivel", width: 55, align: 'right', sortable: true, dataIndex: 'Estoque' /*, renderer: change*/},
						{header: "Bloqueados", width: 55,  align: 'right',  sortable: true, dataIndex: 'qtd_bloq'},
						{header: "Valor A", width: 80, align: 'right', sortable: true, dataIndex: 'valorA',renderer: 'usMoney'},
						{header: "Valor B", width: 80, align: 'right', sortable: true, dataIndex: 'valorB',renderer: 'usMoney'},	        
						{header: "Valor C", width: 80, align: 'right', sortable: true, dataIndex: 'valorC',renderer: 'usMoney'}	
					
		        ]
	        ), 
	        viewConfig: 
	        {
	            forceFit:true
	        },
	        
	       // plugins: expander,
			animCollapse: false,
			deferRowRender : false,
			width:728,
			height: 255,
	        stripeRows:true,
			//selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			listeners: {
			keypress: function(e){
				
			if(e.getKey() >47 && e.getKey() < 58 || e.getKey() >64 && e.getKey() < 91 || e.getKey() >95 && e.getKey() < 106 ){
 	   					Ext.get('queryPedidoprodAdd').focus(); 
			}
			else if(e.getKey() == e.ENTER) {//
			// Carrega O formulario Com os dados da linha Selecionada
			record = grid_listaProdDetalhesAdd.getSelectionModel().getSelected();
			//tabs.getForm().loadRecord(record);	
			var idName = grid_listaProdDetalhesAdd.getColumnModel().getDataIndex(0); // Get field name
			var idData = record.get(idName);
			

	//Ext.getCmp('queryPedidoprod').setValue('');
	//produtos_pedidopAdd.form.reset();
	ListaProdutoAdd.hide() //url: '../php/lista_car_pedido.php',
	Ext.Ajax.request({
            url: 'php/update_itens_pedido.php', 
            params : {
               idProd: idData,
			   acao: 'addProd',
			   pedido: selectedKeys
            },
			success: function(result, request){//se ocorrer correto 
								var jsonData = Ext.util.JSON.decode(result.responseText);
								if(jsonData.response == 'ProdutoAdicionado'){ 
                          			 storeItensPedido.reload();
									 setTimeout(function(){
									 grid_ItensPedido.startEditing(0,5);
									 }, 250);
									 }
								if(jsonData.response == 'ProdutoJaAdicionado'){
									 Ext.MessageBox.alert('Aviso','Produto ja Adicionado.');
								     }
                        },
			failure: function(){
                           Ext.example.msg('Erro','N&atilde;o foi possivel Alterar.');
                           storeItensPedido.rejectChanges();
                        } 
					 });
	
			}
			}}
			
	    });	
		 
grid_listaProdDetalhesAdd.getSelectionModel().on('rowselect', function(sm, rowIndex, colIndex) {
    var record = grid_listaProdDetalhesAdd.getStore().getAt( rowIndex );
	prodId = record.id;
}, this);

grid_listaProdDetalhesAdd.addListener('keydown',function(event){
   getItemRow(this, event);
});

function getItemRow(grid, event){
   key = getKey(event);
//console.info(event);
var idData = prodId; 
   if(key==119){

	 DetProdVendAdd.show();
	 storelistaProdVendAdd.load(({params:{codigo: prodId}}));
	 
   }
   
  else if(key==120){

//	 DetProdVendAdd.hide();
//	 gridDetProdCompras.show();
//	 dslistaProdCompras.load(({params:{codigo: prodId}}));
	 
   }
}		 


function ListaProdutosAdd(){		
		if(!(ListaProdutosAdd instanceof Ext.Window)){
			ListaProdutoAdd = new Ext.Window({
				title: 'Estoque',
				width:730,
				plain: true,						
				collapsible: false,
			//	resizable: false,
				closeAction:'hide',
				closable: true,
				modal: true,
				border: false,
				items: [produtos_pedidopAdd,grid_listaProdDetalhesAdd,DtProdsVendidosAdd],
				focus: function(){
					Ext.get('queryPedidoprodAdd').focus(); 
				}			
			})
		}
		ListaProdutoAdd.show();
	}
     FormGridPedidosEdit = new Ext.Panel({
			id: 'FormGridPedidosEdit',
            title: 'Itens do Pedido',
			frame		: true,
			closable:true,
            autoWidth   : true,
            split: true,
			//height	: 350,
			autoHeight: true,
			layout:'form',
            items:[grid_ItensPedido],
            listeners:{
					destroy: function() {
							 tabs.remove('simplePedidos');
         				   }
		              }
            });
       	simplePedidos = new Ext.FormPanel({
		    autoWidth:true,
			autoScroll: true,
			border: false,
		//	id: 'simplePedidos',
	        labelWidth: 75,
	        frame:true,
			//autoHeight: true,
			//height: 200,
			closable: true,
			layout: 'form',
	        title: 'Pedidos',
			items: [grid_Pedidos,FormGridPedidosEdit],
			listeners:{
				destroy: function() {
                             //grid_ItensPedido.destroy();
						//	 sul.remove('FormGridPedidosEdit');
							 
         				}
			         }	
 });
 
 

Ext.getCmp('tabss').add(simplePedidos);
Ext.getCmp('tabss').setActiveTab(simplePedidos);
simplePedidos.doLayout();	
/*
Ext.getCmp('sul').add(FormGridPedidosEdit);
Ext.getCmp('sul').setActiveTab(FormGridPedidosEdit);
FormGridPedidosEdit.doLayout();	
*/

};
