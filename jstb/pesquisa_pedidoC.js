// JavaScript Document


Ext.onReady(function(){   
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



var  pesquisa_pedido= Ext.get('pesquisa_pedido');
pesquisa_pedido.on('click', function(e){ 

/// ICONES NA GRID ///////////////////////////////

var action = new Ext.ux.grid.RowActions({
    header:'Excluir'
   ,autoWidth: true
   ,actions:[{
       iconCls:'icon-excluir'
      ,tooltip:'Excluir'
	  ,width: 5
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
//console.info(situacao);
var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Por favor selecione um pedido');
}


var formataSitPedido = function(value){
	
	if(value=='A')
		  return '<span style="color: #FF0000;">Pendente</span>';
		else if(value=='F')
		  return 'Faturado';
		else
		  return 'Cancelado'; 

};

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
											Ext.MessageBox.alert('Avizo', response.responseText);
											var json = Ext.util.JSON.decode(response.responseText);
												if(json.del_count == 1){
													mens = "1 Registro deletado.";
												} else {
													mens = json.del_count + " Registros deletados.";
												}
												Ext.MessageBox.alert('Alerta', mens);
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
								function popup(){
window.open('../impressao.php?id_pedido='+selectedKeys +'','popup','width=750,height=500,scrolling=auto,top=0,left=0')
}
popup();
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
/////////////////////////////////////////////////////////////////////////














/////////////// Editar //////////////////////////////
var editarPedido = function(){
 selectedKeys = grid_Pedidos.selModel.selections.keys;
if(selectedKeys.length > 0){	
 selectedRows = grid_Pedidos.selModel.selections.items;
 selectedKeys = grid_Pedidos.selModel.selections.keys; 

record = grid_Pedidos.getSelectionModel().getSelected();
var colName = grid_Pedidos.getColumnModel().getDataIndex(4); // Get field name
var situacao = record.get(colName);

var win_editarPedido = new Ext.Window({
					//id: 'editaPedido',
					title: 'Pedido',
					width: 750,
					height: 400,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: grid_ItensPedido,
					buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_editarPedido.hide();
								
  			 					}
			 
        					}]
				});
			
				win_editarPedido.show();				
				storeItensPedido.load({params:{pedidoid: selectedKeys}});
				
				if(situacao == 'F'){
          			Ext.getCmp('btnAddIten').setVisible(false);
        			 } else {
            		Ext.getCmp('btnAddIten').setVisible(true);
		 			}
			}
else{
selecione();
}
}
/////////////////////////////////////////////////////////////////////////






	storePedidos = new Ext.data.SimpleStore({
        fields: ['sitID','sitNome'],
        data: [
            ['id', 'Pedido'],
            ['nome_cli', 'Nome'],
			['ruc', 'Ruc']
        ]
    });
	
    	simplePedidos = new Ext.FormPanel({
		    width:885,
			id: 'simplePedidos',
	        labelWidth: 75,
	        frame:true,
	      //  title: 'Live search',
	        bodyStyle:'padding:5px 5px 0',
	        defaults: {width: 230},
	        defaultType: 'textfield',
			items: [
					
					
					combo02 = new Ext.form.ComboBox({
                    name: 'sitID',
                    id: 'sitID',
					readOnly:true,
                    store: storePedidos,//origem dos dados
                    fieldLabel: 'Pesquisar por',
                    allowBlank: false, //permitir ou não branco, será validado ao sair do campo.
                    displayField: 'sitNome', //campo a ser exibido, de acordo com o mapemanto feito no objeto store
                    hiddenName: 'sitIDVal', //nome do campo Hidden que será criado automaticamente para receber o valor do item selecionado no combobox
                    typeAhead: true, //auto-selecionar o combo de acordo com o texto digitado
                    valueField: 'sitID',
                    mode: 'local', //localização da origem dos dados.
                    forceSelection: true,//forçar que só digite texto que exista em um dos itens. False para permitir qualquer texto.
                    triggerAction: 'all',
                    emptyText: 'Pedido', //texto a ser exibido quando não possuir item selecionado
                    selectOnFocus: true, //selecionar o texto ao receber foco
	                blankText : 'Pedido', 
                    width: 50,
					listeners:{select:{fn:function(combo, value) {
						 combos = combo.getValue();
               // alert(combo);
          }}}

                }),
				  
				
					{
	                fieldLabel: 'Pesquisa',
	                name: 'queryPedido',
					id: 'queryPedido',
	                allowBlank:true,
	  		                            
					listeners: 
					{
						
						keyup: function(el,type)
						{
							var theQuery=el.getValue();
							
							dsPesquisaPedido.load({params:{query: theQuery, combo: combo02.getValue()}});
							
						}				
					}
	            }
	        ]	
				
				
				
 });

/////////////////////// INICIO STORE //////////////////////////////////
dsPesquisaPedido = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: '../php/pesquisa_pedido.php',
        method: 'POST'
    }),   

reader:  new Ext.data.JsonReader({
			totalProperty: 'total',
			root: 'results',
			id: 'id',
			fields: [
					 {name: 'idPedido',  type: 'string', mapping: 'id' },
					 {name: 'ClientePedido',  type: 'string', mapping: 'nome_cli' },
					 {name: 'totalPedido',  type: 'string', mapping: 'totalitens' },
					 {name: 'dataPedido',  type: 'string', mapping: 'data' },
					 {name: 'situacaoPedido',  type: 'string', mapping: 'situacao' },
					 {name: 'formaPago',  type: 'string', mapping: 'descricao'},
					 {name: 'usuarioPedido',  type: 'string', mapping: 'nome_user' }
					 //{name: 'action1', type: 'string'},
   			         //{name: 'action2', type: 'string'}

					 ]
			})					    
			
		})
///////////// FIM STORE ////////////////////////
///////////// INICIO DA GRID //////////////////

	     var grid_Pedidos = new Ext.grid.GridPanel({
	        store: dsPesquisaPedido, // use the datasource
	       cm: new xgPedido.ColumnModel([
		       
		        	//expander,
		            {id:'idPedido', width:60, header: "Pedido",  sortable: true, dataIndex: 'idPedido'},
					{id:'ClientePedido', width:200, header: "Cliente",  sortable: true, dataIndex: 'ClientePedido'},
					{id:'totalPedido', width:80, header: "Total", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'totalPedido'},
					{id:'dataPedido', width:80, header: "Data", align: 'right', sortable: true, dataIndex: 'dataPedido'},
					{id:'situacaoPedido', width:80, header: "Situacao", align: 'right', renderer: formataSitPedido,  sortable: true, dataIndex: 'situacaoPedido'},
					{id:'formaPago', width:80, header: "Forma Pago", align: 'right',  sortable: true, dataIndex: 'formaPago'},
					{id:'usuarioPedido', width:80, header: "Usuario",align: 'right',  sortable: true, dataIndex: 'usuarioPedido'}
					//action

					
		        ]), 
	        viewConfig:{ forceFit:true},
			//plugins : action,
			collapsible: true,
			animCollapse: false,
			enableColLock: false,
			loadMask:true,
			width:885,
			height: 346,
			autoWidth:false,
	        stripeRows:true,
	        title:'Pedidos',
	        iconCls:'icon-grid',
			
			
			listeners: {
			keypress: function(e){
				
			if(e.getKey()  >47 && e.getKey() < 58 || e.getKey() >64 && e.getKey() < 91 || e.getKey() >95 && e.getKey() < 106 ){	
				
 	   					 Ext.get('queryPedido').focus();
			
				
			}}},
			tbar : new Ext.StatusBar({
         	buttons: [	
           				{
           			    text: 'Excluir',
						id: 'esc',
						align: 'left',
						iconCls: 'remove',
            			handler: function(){ // fechar	
     	    			deletarPedido();
						}
  			 			},
						{
           			    text: 'Abrir',
						align: 'left',
						iconCls: 'icon-edit',
            			handler: function(){ // fechar	
     	    			editarPedido();
  			 			}
						},
						{
           			    text: 'pdf',
						id: 'pdf',
						align: 'left',
						iconCls: 'icon-pdf',
            			handler: function(){ // fechar	
     	    			imprimirPedidoPDF();
  			 			}
						},
						{
           			    text: 'imprimir',
						id: 'printer',
						align: 'left',
						iconCls: 'icon-print',
            			handler: function(){ // fechar	
     	    			imprimirPedido();
  			 			},
						style: 'margin-right:640px'
						}
						
			 
        ]
    }),
			bbar: new Ext.PagingToolbar({
				store: dsPesquisaPedido,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Não tem dados",
				pageSize: 18,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina",    
				refreshText : "Atualizar",    
				paramNames : {start: 'start', limit: 'limit'}
			})
		//})


			
		
			
	    });	
		dsPesquisaPedido.load({params:{acao: 'listarPedidos',start: 0, limit: 18}});
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
	        {name: 'prvenda'},
            {name: 'qtd_produto'},
			{name: 'totals'},
			{name: 'totalGeral'}
 			]
		})
   });
	
var gridFormItens = new Ext.BasicForm(
		Ext.get('form3'),
		{
			});
    // define a custom summary function
    Ext.grid.GroupSummary.Calculations['totalGeral'] = function(v, record, field){
		return v + (parseFloat(record.data.prvenda) * parseFloat(record.data.qtd_produto));
    }

    var summary = new Ext.grid.GroupSummary(); 
    var grid_ItensPedido = new Ext.grid.EditorGridPanel({
	    store: storeItensPedido,
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
        frame:true,
        width: 790,
        height: 385,
		border: false,
        clicksToEdit: 1,
		selectOnFocus: true, //selecionar o texto ao receber foco
		//selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
       // collapsible: false,
       // animCollapse: false,
        trackMouseOver: false,
        enableColumnMove: true,
		stripeRows: true,
		autoScroll:false,
       // title: 'Duplicatas em Aberto',
        iconCls: 'icon-grid',
		tbar: [  
			   {xtype: 'button',
			    id:'btnAddIten',
				text: 'Adicionar Itens',
				//autoShow: false,
				//hidden:  (situacao == 'A'),
				iconCls:'add',
				tooltip: 'Clique para incluir novo iten',
				handler: function(){
						 ListaProdutosAdd();
						 Ext.getCmp('queryPedidoprodAdd').focus(); 
					
					} 
			   }
		],
		listeners:{ 
        afteredit:function(e){
         Ext.Ajax.request({
            url: '../php/update_itens_pedido.php',
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
	var storeProdPedidoAdd = new Ext.data.SimpleStore({
        fields: ['sitCodigoPedidoprodAdd','sitDescricaoPedidoprodAdd'],
        data: [
            ['Codigo', 'Codigo'],
            ['Descricao', 'Descricao']
        ]
    });
	
    var	produtos_pedidopAdd = new Ext.FormPanel({
			region      : 'north',
		    width:800,
			closeAction:'close',
			id: 'produtos_pedidoAdd',
	        labelWidth: 75,
	        frame:true,
	        defaults: {width: 230},
	        defaultType: 'textfield',
			items: [
					
					
					combo01PedidoprodAdd = new Ext.form.ComboBox({
                    name: 'sitCodigoPedidoprodAdd',
                    id: 'sitCodigoPedidoprodAdd',
					readOnly:true,
                    store: storeProdPedidoAdd,//origem dos dados
                    fieldLabel: 'Pesquisar por',
                    allowBlank: false, //permitir ou não branco, será validado ao sair do campo.
                    displayField: 'sitDescricaoPedidoprodAdd', //campo a ser exibido, de acordo com o mapemanto feito no objeto store
                    hiddenName: 'sitCodigoPedidoprodValAdd', //nome do campo Hidden que será criado automaticamente para receber o valor do item selecionado no combobox
                    typeAhead: true, //auto-selecionar o combo de acordo com o texto digitado
                    valueField: 'sitCodigoPedidoprodAdd',
                    mode: 'local', //localização da origem dos dados.
                    forceSelection: true,//forçar que só digite texto que exista em um dos itens. False para permitir qualquer texto.
                    triggerAction: 'all',
                    emptyText: 'Codigo', //texto a ser exibido quando não possuir item selecionado
                    selectOnFocus: true, //selecionar o texto ao receber foco
	                blankText : 'Codigo', 
                    width: 50,
					listeners:{select:{fn:function(combo, value) {
						 combos = combo.getValue();
          }}}

                }),
				  
				
					{
	                fieldLabel: 'Pesquisa',
	                name: 'queryPedidoprodAdd',
					id: 'queryPedidoprodAdd',
	                allowBlank:true,
	  		                            
					listeners:{
						
						keyup: function(el,type)
						{
							if(e.getKey() == 40  ){//seta pra baixo  
							   grid_listaProdDetalhesAdd.getSelectionModel().selectFirstRow();
							   grid_listaProdDetalhesAdd.getView().focusEl.focus();
                            }
							var ProdtheQuery=el.getValue();
							
							dsProdPedidoAdd.load(
							{
								params: 
								{	
									query: ProdtheQuery,
									combo: combo01PedidoprodAdd.getValue()
									
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
						{header: "Data", width: 90, align: 'right', sortable: true, dataIndex: 'data_car', renderer: change},
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
            //title       : 'Detalhes',
			labelAlign: 'top',
            region      : 'south',
			//layout      : 'column',
           // split       : false,
           // width       : false,
			//autoHeight		: true,
			height		:180,
			frame       :true,
            //collapsible : true,
			//msgTarget: 'side',
			//autoScroll: true,
			//html: 'teste.html'
            // margins     : '3 3 3 0',
			//bodyStyle:'padding:0px 5px 0',
            //cmargins    : '3 3 3 3',
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
                url: '../php/lista_prod_pedido.php',
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
						{header: "Disponivel", width: 55, align: 'right', sortable: true, dataIndex: 'Estoque', renderer: change},
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
			collapsible: true,
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
            url: '../php/update_itens_pedido.php', 
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
	   
	  //gridDetProdCmp.hide();
	  //gridDetProdCompras.hide();
	 
	 //gridDetProd.show();
     //dslistaProdDet.load(({params:{codigo: prodId, campo: e.column}}));
	 
	 DetProdVendAdd.show();
	 storelistaProdVendAdd.load(({params:{codigo: prodId, campo: e.column}}));
	 
	 
	//gridDetProd.hide();
   }
   
  // else if(key >47 && key < 58 || key >64 && key < 91 || key >95 && key < 106 ){
     // document.getElementById("ref").focus();

  // }
  else if(key==120){
	 gridDetProdAdd.hide();

	 gridDetProdVendAdd.hide();
	 
	 //gridDetProdCmp.show();
	 //dslistaProdCmp.load(({params:{codigo: prodId, campo: e.column}}));
	 
	 //gridDetProdCompras.show();
	// dslistaProdCompras.load(({params:{codigo: prodId, campo: e.column}}));
	 
   }
   
  // else if(key==75){ win_list.show(); }
}		 


function ListaProdutosAdd(){		
		if(!(ListaProdutosAdd instanceof Ext.Window)){
			ListaProdutoAdd = new Ext.Window({
				title: 'Estoque',
				width:730,
				height:520,
				plain: true,						
				collapsible: false,
				resizable: false,
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




//Criando Janela Exibicao Resultado
//function win_PesquisaPedidoShow(){		
//		if(!(win_PesquisaPedidoShow instanceof Ext.Window)){
		win_PesquisaPedido = new Ext.Window({
		//id: 'win_PesquisaPedido',
		title: 'Pesquisa de Pedidos',
		width:900,
		height:510,
		autoScroll: false,
		shim:true,
		closable : true,
		html: '<div id=\'CA\'></div><br /><div id=\'CB\'></div><br /><div id=\'CC\'></div>',
		layout: 'anchor',
		resizable: false,
		draggable: true, //Movimentar Janela
		plain: true,
		modal: false, //Bloquear tela do fundo
		items:[simplePedidos,grid_Pedidos],
		//focus: function(){
 	   //					 Ext.get('query').focus();
		//},  
		 buttons: [
           	{
            text: 'Cerrar',
            handler: function(){ // fechar	
     	    win_PesquisaPedido.destroy();
			if(win_editarPedido){
			win_editarPedido.destroy();
			}
			if(ListaProdutoAdd){
			ListaProdutoAdd.destroy(); }
  			 }
			 
        }]
	})
		//}
win_PesquisaPedido.show();	
//}


});
});