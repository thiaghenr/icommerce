// JavaScript Document


EntConsig = function(){


if(perm.pesquisa_pedido.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}
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


//// FIM ICONES NA GRID //////////////////////////////////////////////////
var ListaProdutoAdd;
 var idData;
var xgProdPesquisaAdd = Ext.grid;
var btnAddIten;
var situacao = 'F';
var xgConsignacao = Ext.grid;
//var grid_ItensConsig = Ext.grid;
var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Favor elelir un registro');
}




var formataSitPedido = function(value){
	
	if(value=='A')
		  return '<span style="color: #FF0000;">Pendente</span>';
		else if(value=='F')
		  return 'Encerrado';
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
var imprimirConsig = function(){
var selectedKeys = grid_Consignacao.selModel.selections.keys; 
					if(selectedKeys.length > 0){	
								var selectedRows = grid_Consignacao.selModel.selections.items;
								var selectedKeys = grid_Consignacao.selModel.selections.keys; 
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
var imprimirConsigPDF = function(){
var selectedKeys = grid_Consignacao.selModel.selections.keys;
if(selectedKeys.length > 0){	
var selectedRows = grid_Consignacao.selModel.selections.items;
var selectedKeys = grid_Consignacao.selModel.selections.keys; 
																
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
					items: { html: "<iframe height='100%' width='100%' src='../consig_imp.php?id_pedido="+selectedKeys +"' > </iframe>" },
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
dsConsignacao = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: 'php/Consignacao.php',
        method: 'POST'
    }),   

reader:  new Ext.data.JsonReader({
			totalProperty: 'total',
			root: 'results',
			id: 'csg_idconsignacao',
			fields: [
					 {name: 'csg_idconsignacao',  type: 'string', mapping: 'csg_idconsignacao' },
					 {name: 'csg_entidadeid',  type: 'string', mapping: 'csg_entidadeid' },
					 {name: 'csg_entidadenome',  type: 'string', mapping: 'csg_entidadenome' },
					 {name: 'csg_data',  type: 'string', mapping: 'csg_data' },
					 {name: 'csg_usuarioid',  type: 'string', mapping: 'usuario' },
					 {name: 'csg_total',  type: 'float', mapping: 'csg_total' },
					 {name: 'csg_status',  type: 'string', mapping: 'csg_status'},
					 {name: 'csg_situacao',  type: 'string', mapping: 'csg_situacao' },
					 {name: 'csg_movimento',  type: 'string', mapping: 'csg_movimento' }
					 //{name: 'action1', type: 'string'},
   			         //{name: 'action2', type: 'string'}

					 ]
			}),					    
			baseParams:{acao: 'Listar'}
		})
///////////// FIM STORE ////////////////////////
///////////// INICIO DA GRID //////////////////

	     var grid_Consignacao = new Ext.grid.GridPanel({
	        store: dsConsignacao, // use the datasource
	       cm: new xgConsignacao.ColumnModel([
		       
		        	//expander,
		            {id:'csg_idconsignacao', width:20, header: "ID",  sortable: true, dataIndex: 'csg_idconsignacao'},
					{width:130, header: "Entidade",  sortable: true, dataIndex: 'csg_entidadenome'},
					{width:60, header: "Data", align: 'right', sortable: true, dataIndex: 'csg_data'},
					{width:40, header: "User", align: 'right',   sortable: true, dataIndex: 'csg_usuarioid'},
					{width:40, header: "Movimiento", align: 'right',   sortable: true, dataIndex: 'csg_movimento'},
				//	{width:50, header: "Situacao", align: 'right', renderer: formataSitPedido,  sortable: true, dataIndex: 'csg_situacao'},
					{width:40, header: "Total", align: 'right',  sortable: true, renderer: Ext.util.Format.usMoney, dataIndex: 'csg_total'}
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
			height: 200,
	        stripeRows:true,
			listeners: {
			keypress: function(e){
				
			if(e.getKey()  >47 && e.getKey() < 58 || e.getKey() >64 && e.getKey() < 91 || e.getKey() >95 && e.getKey() < 106 ){	
				
 	   					 Ext.get('queryPedido').focus();
			
				
			}}},
			tbar : new Ext.Toolbar({
			align:'left',
         	buttons: [	/*
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
						*/
						{
           			    text: 'pdf',
						id: 'pdf',
						align: 'left',
						iconCls: 'icon-pdf',
            			handler: function(){ // fechar	
     	    			imprimirConsigPDF();
  			 			}
						},
						
						'-'
						/*
						,
						
						{
           			    text: 'imprimir',
						id: 'printer',
						align: 'left',
						iconCls: 'icon-print',
            			handler: function(){ // fechar	
     	    			imprimirConsig();
  			 			}
						}, 
						'-',
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
                emptyText: 'Filtro',
				width: 120,
				forceSelection: true,
				store: [
                            ['csg_idconsignacao','Numero'],
                            ['csg_entidadenome','Entidade'],
                            ['csg_data','Fecha']
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
				*/		
			 
        ]
    }),
			bbar: new Ext.PagingToolbar({
				store: dsConsignacao,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Não tem dados",
				pageSize: 6,
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
		dsConsignacao.load({params:{acao: 'Listar',start: 0, limit: 6}});

		grid_Consignacao.on('rowclick', function(grid, row, e) {
					 selectedKeys = grid_Consignacao.selModel.selections.keys;
					if(selectedKeys.length > 0){	
					 selectedRows = grid_Consignacao.selModel.selections.items;
					 selectedKeys = grid_Consignacao.selModel.selections.keys; 
					
					record = grid_Consignacao.getSelectionModel().getSelected();
					var colName = grid_Consignacao.getColumnModel().getDataIndex(4); // Get field name
					var situacao = record.get(colName);
					
					storeItensConsig.load({params:{'acao': 'ListaItens', idconsig: selectedKeys}});
				
					if(situacao == 'F' || situacao == 'D'){
          		//	Ext.getCmp('btnAddIten').setVisible(false);
        			 } else {
            	//	Ext.getCmp('btnAddIten').setVisible(true);
		 			}
					
					}
		});


			
		
	
 
//////////////////////////// FIM DA GRID ///////////////////////////////


///COMECA A GRID DOS ITENS ///////////////////////////////////////////////
	  var storeItensConsig = new Ext.data.Store({
      proxy: new Ext.data.HttpProxy({
		method: 'POST', 
		url: 'php/Consignacao.php'}),
      sortInfo:{field: 'itcsg_descricao', direction: "ASC"},
      reader: new Ext.data.JsonReader({
		 totalProperty: 'total',
	     root:'Itens',
	     fields: [
		//	{name: 'action1', type: 'string'},
			{name: 'itcsg_iditensconsig'},
			{name: 'itcsg_consigid', mapping: 'itcsg_consigid'},
			{name: 'itcsg_descricao', mapping: 'itcsg_descricao'},
	        {name: 'prvenda', type: 'float'},
            {name: 'itcsg_qtd'},
			{name: 'itcsg_valor'},
			{name: 'itcsg_referencia'},
			{name: 'peso'},
			{name: 'itcsg_produtoid'},
			{name: 'itcsg_dev'},
			{name: 'itcsg_fat'}
 			]
		})
   });
	


     grid_ItensConsig = new Ext.grid.EditorGridPanel({
	    store: storeItensConsig,
       // id: 'grid_ItensPedido',
		enableColLock: true,
		containerScroll  : true,
		loadMask: {msg: 'Carregando...'},
        columns: [
		
			{header: "itcsg_iditensconsig", id: 'itcsg_iditensconsig', sortable: true, dataIndex: 'itcsg_iditensconsig', fixed:true, hidden: true },
			{header: "itcsg_consigid", sortable: true, dataIndex: 'itcsg_consigid', hidden: true},
			{header: 'idprod',	width: 55, align: 'right', dataIndex: 'itcsg_produtoid', hidden: true},
			{header: "Codigo", sortable: true, dataIndex: 'itcsg_referencia', width: 150},
			{header: "Descricao", sortable: true, dataIndex: 'itcsg_descricao', width: 300},
			{header: 'Qtd',	width: 55, align: 'right', dataIndex: 'itcsg_qtd'},
			{header: "Valor", width: 80, align: 'right', sortable: true, dataIndex: 'itcsg_valor', renderer: Ext.util.Format.usMoney},
			{header: 'Devolvido',	width: 80, align: 'right', dataIndex: 'itcsg_dev'},
			{header: 'Facturado',	width: 80, align: 'right', dataIndex: 'itcsg_fat'}
			],
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
                           storeItensConsig.commitChanges();
                        },
			failure: function(){
                           Ext.example.msg('Erro','N&atilde;o foi possivel Alterar.');
                           storeItensConsig.rejectChanges();
                        }
         })
      },
	   editcomplete:function(ed,value){
	                   setTimeout(function(){
	                       if(ed.col == 5){				
	                               grid_ItensConsig.startEditing(ed.row,ed.col+1);
	                               }
	                    }, 250);
	                   }
	  }
});
///TERMINA A GRID	

////////////////////// INICIO ADD NOVO ITEN ////////////////////////////////////////////////////
// COMBO PESQUISA DE PRODUTOS////////////////////////////




/*		 
grid_listaProdDetalhesAdd.getSelectionModel().on('rowselect', function(sm, rowIndex, colIndex) {
    var record = grid_listaProdDetalhesAdd.getStore().getAt( rowIndex );
	prodId = record.id;
}, this);

grid_listaProdDetalhesAdd.addListener('keydown',function(event){
   getItemRow(this, event);
});
*/
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
     FormGridConsig = new Ext.Panel({
            title: 'Itens Consignados',
			frame		: true,
			closable:true,
            autoWidth   : true,
            split: true,
			//height	: 350,
			autoHeight: true,
			layout:'form',
            items:[grid_ItensConsig],
            listeners:{
					destroy: function() {
							 tabs.remove('simplePedidos');
         				   }
		              }
            });
       	formConsignacao = new Ext.FormPanel({
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
	        title: 'Consignacion',
			items: [grid_Consignacao,FormGridConsig],
			listeners:{
			
			         }	
 });
 
 

Ext.getCmp('tabss').add(formConsignacao);
Ext.getCmp('tabss').setActiveTab(formConsignacao);
formConsignacao.doLayout();	

};
