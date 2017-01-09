// JavaScript Document



ImpBoleta = function(){


Ext.form.Field.prototype.msgTarget = 'side';
Ext.form.FormPanel.prototype.bodyStyle = 'padding:5px';
Ext.form.FormPanel.prototype.labelAlign = 'right';
Ext.QuickTips.init();
	
	
var xgVenda = Ext.grid;
var xgEqvla = Ext.grid;
var xgForms = Ext.grid;


var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Por favor selecione una Venta');
}

function showResultText(btn, text){
        Ext.Msg.alert('Button Click', 'You clicked the {0} button and entered the text "{1}".', btn, text);
		//console.info(btn);
		if(btn == "ok"){
		if(text){
		
		/*
		jsonData = "[";
		for(d=0;d<dsVendaItens.getCount();d++) {
		record = dsVendaItens.getAt(d);
		//	if(record.data.newRecord || record.dirty) {
		
			jsonData += Ext.util.JSON.encode(record.data) + ",";
		//	}
			}	
		jsonData = jsonData.substring(0,jsonData.length-1) + "]";
		*/
		
		var jsonData = [];
		// Percorrendo o Store do Grid para resgatar os dados
		dsVendaItens.each(function( record ){
		// Recebendo os dados
		jsonData.push( record.data );
		});
		jsonData = Ext.encode(jsonData);
									
		Ext.Ajax.request({
		    url: "php/ImpBoleta.php",
            params: {
		        user: id_usuario,
				acao: 'Faturar',
                idVenda: idVendaFat,
                idForma: idforma,
				nform: text,
				data:jsonData
					}
				, waitMsg: 'Faturando'
				, waitTitle : 'Aguarde....'
				, scope: this
				,callback: function (options, success, response) {
							if (success) { 
								Ext.MessageBox.alert('OK', response.responseText);
								var json = Ext.util.JSON.decode(response.responseText);
							if(json.response == 'Enviado com Sucesso'){
								mens = "Enviado com Sucesso";
								} 
							if(json.response == 'Algunos itens ya facturados'){
								mens = "Algunos itens ya facturados";
								}
							if(json.response == 'Itens con cantidad zero !!!'){ 
								mens = "Itens con cantidad zero !!!";
								}
							if(json.response == 'El limite de itens es 15 !!!'){
								mens = "El limite de itens es 15 !!!";
								}
							Ext.MessageBox.alert('Alerta', mens);
							} 
							else{
								Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
							}
							},
					failure:function(response,options){
											Ext.MessageBox.alert('Alerta', 'Erro...');
										},                                      
					success:function(response,options){
											//dsPagoProv.reload();
										}                           					
														
			     }); 
				 
			
		}
		else{
		   Ext.Msg.alert('Error', 'Informe el numero de formulario');
		}
		}
    };

//Mudar cor da linha, aplicar o gridview
function MudaCor(row, index) {
      if (row.data.Estoque > 0) { // change 顯 nome do campo usado como refer믣ia
         return 'cor';
      }
   }

 function renderBlue(value, metadata, record, rowIndex, colIndex, store){
  return '<span style="color:blue;font-weight: bold;">' + value + '</span>';
}

var action = new Ext.ux.grid.RowActions({
    header:'Remover'
 //  ,anchor: '10%'
   ,width: 80
   ,actions:[{
       iconCls:'icon-excluir'
      ,tooltip:'Remover'
	  ,width: 80
   }] 
});
action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );
	  dsVendaItens.remove(record);
	  gridFatItensVenda.getView().refresh();
   }
});

var action2 = new Ext.ux.grid.RowActions({
    header:'Action'
   ,autoWidth: false
   ,width: 100
   ,actions:[{
       iconCls:'icon-print'
      ,tooltip:'Reimprimir'
	  ,width: 100
   },
   {
       iconCls:'icon-cancel'
      ,tooltip:'Cancelar Impresion'
	  ,text: 'Cancelar'
	  ,width: 80
	  ,handler: {
	  	  }
	  }] 
});
action2.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );
	 id_pedido = record.data.idim_impressao;
	 if(action == 'icon-print'){
	 Ext.Ajax.request({
		    url: "factura.php?id_pedido="+id_pedido,
            params: {
					id_pedido: id_pedido
					}
					
		});
	}
	if(action == 'icon-cancel'){
	 Ext.Ajax.request({
		    url: "php/ImpBoleta.php",
            params: {
					id_pedido: id_pedido,
					acao: 'CancelaImp'
					},
					callback: function (options, success, response) {
							if (success) { 
								//Ext.MessageBox.alert('OK', response.responseText);
								var json = Ext.util.JSON.decode(response.responseText);
							if(json.response == 'Cancelado con Succeso'){
								mens = "Cancelado con Succeso";
								dsForms.reload();
								}
							if(json.response == 'No fue possible, intente denuevo'){
								mens = "No fue possible, intente denuevo";
								}
							
							Ext.MessageBox.alert('Alerta', mens);
							} 
							else{
								Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
							}
							}
		});
	}
		
   }
});



/////////////// PDF //////////////////////////////
var impFormularios = function(){
var selectedKeys = gridFatVenda.selModel.selections.keys;
if(selectedKeys.length > 0){	
var selectedRows = gridFatVenda.selModel.selections.items;
var selectedKeys = gridFatVenda.selModel.selections.keys; 
																
var win_VisForms = new Ext.Window({
					title: 'Formularios'+selectedKeys,
					width: 200,
					height: 300,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='../pdf_visforms.php?id_pedido="+selectedKeys +"' > </iframe>" },
					buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_VisForms.destroy();
  			 					}
			 
        					}]
				});
				win_VisForms.show();
			}
else{
selecione();
}
}

/////////////// PDF //////////////////////////////
var impItensFatura = function(){
var selectedKeys = gridFatVenda.selModel.selections.keys;
if(selectedKeys.length > 0){	
var selectedRows = gridFatVenda.selModel.selections.items;
var selectedKeys = gridFatVenda.selModel.selections.keys; 
																
var win_ItensFatura = new Ext.Window({
					title: 'Itens de la Factura',
					width: 200,
					height: 300,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='../pdf_itens_fatura.php?id_pedido="+selectedKeys +"' > </iframe>" },
					buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_ItensFatura.destroy();
  			 					}
			 
        					}]
				});
				win_ItensFatura.show();
			}
else{
selecione();
}
}

/////////////////////// INICIO STORE //////////////////////////////////
dsFatVenda = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: '../php/ImpBoleta.php',
        method: 'POST'
    }),   

reader:  new Ext.data.JsonReader({
			totalProperty: 'total',
			root: 'results',
			id: 'idVenda',
			remoteSort: true,
			fields: [
					 {name: 'idVenda',  type: 'string', mapping: 'idVenda' },
					 {name: 'idPedido',  type: 'string', mapping: 'idPedido' },
					 {name: 'CodCli',  type: 'string', mapping: 'controle_cli' },
                     {name: 'total_nota',  type: 'string' },
                     {name: 'idforma',  type: 'string' },
					 {name: 'ClienteEndereco',  type: 'string', mapping: 'endereco' },
					 {name: 'nome',  type: 'string', mapping: 'nome' },
					 {name: 'totalVenda',  type: 'string', mapping: 'totalitens' },
					 {name: 'datapedido',  type: 'string', mapping: 'datapedido' },
					 {name: 'formaPago',  type: 'string', mapping: 'descricao'},
					 {name: 'num_form',  type: 'string', mapping: 'num_form'},
					 {name: 'imp',  type: 'string', mapping: 'imp'},
					 {name: 'usuarioPedido',  type: 'string', mapping: 'nome_user' }
					 //{name: 'action1', type: 'string'},
   			         //{name: 'action2', type: 'string'}

					 ]
			})	,
			sortInfo:{field: 'idVenda', direction: "ASC"},
			baseParams:{acao: 'listarVendas'}
		})
///////////// FIM STORE ////////////////////////
///////////// INICIO DA GRID //////////////////

	     var gridFatVenda = new Ext.grid.GridPanel({
	        store: dsFatVenda, // use the datasource
	       cm: new xgVenda.ColumnModel([
		       
		        	//expander,
		            {id:'idVenda', width:40, header: "Venda",  sortable: true, dataIndex: 'idVenda'},
					{id:'idPedido', width:40, header: "Pedido",  sortable: true, dataIndex: 'idPedido'},
					{id:'imp', width:40, header: "Pedido", hidden: true, sortable: true, dataIndex: 'imp'},
					{id:'nome', width:130, header: "Cliente",  sortable: true, dataIndex: 'nome'},
					{id:'totalVenda', width:60, header: "Total", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'totalVenda'},
					{id:'datapedido', width:60, header: "Dt Pedido", align: 'right', sortable: true, dataIndex: 'datapedido'},
					{id:'formaPago', width:40, header: "Forma Pago", align: 'right',  sortable: true, dataIndex: 'formaPago'},
					{id:'usuarioPedido', width:40, header: "Vendedor",align: 'right',  sortable: true, dataIndex: 'usuarioPedido'},
					{id:'num_form', width:40, header: "Formulario", align: 'right',  sortable: true, dataIndex: 'num_form'}
					//action

					
		        ]), 
	        viewConfig:{ 
			forceFit:true
			},
			collapsible: false,
            id: 'gridFatVenda',
			animCollapse: false,
			enableColLock: false,
			loadMask:true,
			title: 'Vendas',
			closable: true,
			autoWidth:true,
			height: 300,
	        stripeRows:true,
			tbar : new Ext.Toolbar({
			align:'left',
			items:[
				{
				xtype: 'label',
				text: 'Buscar Pedido: ',
				style: 'font-weight:bold;color:yellow;text-align:left;' 
				},
				{
					xtype: 'textfield',
	                fieldLabel: 'Pesquisa',
	                name: 'queryBuscaPedido',
					id: 'queryBuscaPedido',
					emptyText: 'Numero del Pedido',
					width: 100,
					//enableKeyEvents: true,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							var theQueryPed = Ext.getCmp('queryBuscaPedido').getValue();
							 if(e.getKey() == e.ENTER) {//precionar enter   
							dsFatVenda.load({params:{theQueryPed: theQueryPed }});
							 }
						}				
					}
	            }
			]
			
			}),
			bbar: new Ext.PagingToolbar({
				store: dsFatVenda,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "N䯠tem dados",
				pageSize: 20,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina",    
				refreshText : "Atualizar",    
			//	paramNames : {start: 0, limit: 5},
				items:['-', '<b> * Duplo click para abrir</b>',
						{
						xtype: 'button', 
						name: 'formularios',
						text: 'Formularios',
						iconCls: 'icon-grid',
						width: 20,
						handler: function(){
							var selectedKeys = gridFatVenda.selModel.selections.keys;
							if(selectedKeys.length > 0){
							winGridForms.show();
							dsForms.load({params:{acao: 'ListaForm', 'idVenda': selectedKeys, start: 0, limit: 30}});
							}
							else{
							selecione();
							}
						
						}
						},
						'-',
						{
						xtype: 'button', 
						name: 'itensfatura',
						text: 'Itens Facturados',
						iconCls: 'icon-search',
						//width: 20,
						handler: function(){
							impItensFatura();
						
						}
						}
						]
			}),
			listeners:{
				destroy: function() {
                          // FormVenda.destroy();
					tabs.remove('FormVenda');	 
         				}
			         }
		});
		dsFatVenda.load({params:{acao: 'listarVendas',start: 0, limit: 20}});
	
		 VendaTemplate = 
		                  [
							'</br>'
							,'<b>Venta: &nbsp;</b>{idVenda}<br/>'
							,'<b>Codigo: &nbsp;</b>{CodCli}&nbsp;&nbsp;'
							,'<b>Nome: &nbsp;</b>{nome}&nbsp;&nbsp;'
							,'<b>Endereco: &nbsp;</b>{ClienteEndereco}<br/>'
                            ,'<b>Total: &nbsp;</b>{totalVenda}<br/>'
							,'</br>'
							];
                            
		VendaTpl = new Ext.XTemplate(VendaTemplate);
	
		var dsEqvla = new Ext.data.Store({
		   url: '../php/pesquisa_eqvla.php',
		   autoLoad: true,
		reader:  new Ext.data.JsonReader({
				root: 'Eqvlas',
				totalProperty: 'total',
				id: 'idprod_eqvla',
				fields: [
				   {name: 'id'},
				   {name: 'id_produtos'},
				   {name: 'idprod_eqvla'},
				   {name: 'id_prod_eqvla', mapping: 'id_prod_eqvla'},
		           {name: 'Codigo', mapping: 'Codigo'},
		           {name: 'Descricao', mapping: 'Descricao'},
                   {name: 'Estoque', mapping: 'Estoque'},
                   {name: 'stok', mapping: 'stok'}
				
			]
			})
		});
		
		         var GridEqvla = new Ext.grid.EditorGridPanel({
	        store: dsEqvla, // use the datasource
	       cm: new xgEqvla.ColumnModel([
		       
		            {id:'id', width:40, hidden: true, sortable: true, dataIndex: 'id'},
					{id:'id_produtos', width:40, hidden: true, sortable: true, dataIndex: 'id_produtos'},
					{id:'idprod_eqvla', width:40, hidden: true, sortable: true, dataIndex: 'idprod_eqvla'},
					{id:'id_prod_eqvla', width:100, hidden: true, header: "Codigo",  sortable: true, dataIndex: 'id_prod_eqvla'},
					{id:'Codigo', width:80, header: "Codigo",  sortable: true, dataIndex: 'Codigo'},
					{id:'Descricao', width:130, header: "Descricao", align: 'right', sortable: true, dataIndex: 'Descricao'},
					{id:'Estoque', width:80, header: "Fisico", align: 'right',  sortable: true, dataIndex: 'Estoque', renderer: renderBlue, css: "background-color: #FFFFE7;"},
					{id:'stok', width:80, header: "legal",align: 'right',  sortable: true, dataIndex: 'stok', renderer: renderBlue, css: "background-color: #FFF3D6;"}
		        ]), 
	        viewConfig:{ 
			forceFit:true
			},
			collapsible: false,
			animCollapse: false,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			enableColLock: false,
			loadMask:true,
			autoWidth:true,
			height: 150,
	        stripeRows:true,
			listeners:{ 
					rowdblclick: function(grid, rowIndex, columnIndex, e){
					var records = GridEqvla.getStore().getAt(rowIndex); // Pega linha 
					recordnew = GridEqvla.getSelectionModel().getSelected();
					var fieldNames = GridEqvla.getColumnModel().getDataIndex(3); // Pega campo da coluna
					prod = records.get(fieldNames); //Valor do campo
					
									
					qtd_old = recordold.get( 'qtd_produto'); 
					qtd_new = recordnew.get( 'stok'); 
					if(parseFloat(qtd_new) >= parseFloat(qtd_old)){
					recordold.set( 'refer_prod', recordnew.get('Codigo')); 
					recordold.set( 'desc_prod', recordnew.get('Descricao'));
					recordold.set( 'idproduto', recordnew.get('id_produtos'));
					recordold.set( 'Estoque', recordnew.get('Estoque'));
					recordold.set( 'stok', recordnew.get('stok'));
					}
					else{
						Ext.MessageBox.alert("Alerta", "Quantidade Insuficiente");
					}
					
					
					
         }
	}
		});
		
		function renderIcon(val) {
			return '<img src="shared/icons/fam/printer.png">';
		}

	
			var dsForms = new Ext.data.Store({
		    url: 'php/ImpBoleta.php',
		    autoLoad: false,
			reader:  new Ext.data.JsonReader({
				root: 'results',
				totalProperty: 'total',
				id: 'idim_impressao',
				fields: [
				   {name: 'idim_impressao'},
				   {name: 'id_pedido'},
				   {name: 'id_venda'},
				   {name: 'data_imp'},
		           {name: 'nform'}
				
			]
			})
		});
		    var GridForms = new Ext.grid.EditorGridPanel({
	        store: dsForms, // use the datasource
	        cm: new xgForms.ColumnModel([
					{header: "Pedido", width:40, sortable: true, dataIndex: 'id_pedido'},
					{header: "Venda", width:40, hidden: false, sortable: true, dataIndex: 'id_venda'},
					{header: "Fecha", width:110, sortable: true, dataIndex: 'data_imp'},
					{header: "Formulario", width:130, sortable: true, dataIndex: 'nform',
					editor: new Ext.form.TextField({
					allowBlank : false,
					allowNegative: false
					})
					},
		            {id:'idim_impressao', width:40, hidden: true, sortable: true, dataIndex: 'idim_impressao'},
					action2
		        ]), 
	        viewConfig:{ 
			forceFit:true
			},
			collapsible: false,
			plugins: [action2],
			animCollapse: false,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			enableColLock: false,
			loadMask:true,
			autoWidth:true,
			height: 150,
	        stripeRows:true,
			listeners:{ 
        	afteredit:function(e){
			dsForms.load(({params:{valor: e.value, acao: 'AlterarForm', idImp: e.record.get('idim_impressao'), campo: e.column,  'start':0, 'limit':100}}));
	  		}
			}
			});
	
			var winGridForms = new Ext.Window({
					title: 'Formularios',
					width: 480,
					height: 300,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					closeAction :'hide',
					layout: 'fit',
					items: [GridForms],
					buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					winGridForms.hide();
  			 					}
			 
        					}]
				});	
		
			
 		dsVendaItens = new Ext.data.Store({
                url: '../php/ImpBoleta.php',
                method: 'POST',
        reader:  new Ext.data.JsonReader({
				root: 'Itens',
				//totalProperty: 'total',
				id: 'id',
				fields: [
				   {name: 'id'},
				   {name: 'idproduto'},
				   {name: 'impsn'},
				   {name: 'Codigo', mapping: 'Codigo'},
		           {name: 'desc_prod', mapping: 'descricao_prod'},
		           {name: 'qtd_produto', mapping: 'qtd_produto'},
                   {name: 'pr_venda', mapping: 'prvenda'},
                   {name: 'total_iten', mapping: 'total_iten'},
				   {name: 'fisico', mapping: 'fisico'},
				   {name: 'stok', mapping: 'Estoque'},
				   {name: 'qtd_imp', mapping: 'qtd_imp', type: 'float'}
				
			]
			})
		});
         var gridFatItensVenda = new Ext.grid.EditorGridPanel({
	        store: dsVendaItens, // use the datasource
			stripeRows:true,
			cm: new xgVenda.ColumnModel([
					new xgVenda.RowNumberer(),
					action,
		            {id:'id', width:40, hidden: true, sortable: true, dataIndex: 'id'},
					{id:'impsn', width:40, hidden: true, sortable: true, dataIndex: 'impsn'},
					{id:'idproduto', width:40, hidden: true, sortable: true, dataIndex: 'idproduto'},
					{id:'Codigo', width:100, header: "Codigo",  sortable: true, dataIndex: 'Codigo'},
					{id:'desc_prod', width:130, header: "Descricao",  sortable: true, dataIndex: 'desc_prod'},
					{id:'qtd_produto', width:60, header: "Qt Pedido", align: 'right', sortable: true, dataIndex: 'qtd_produto',
					editor: new Ext.form.NumberField({
					allowBlank : false
					})
					},
					{id:'pr_venda', width:80, header: "Valor", align: 'right',  sortable: true, dataIndex: 'pr_venda',
					editor: new Ext.form.NumberField({
					allowBlank : false
					})
					},
					{id:'total_iten', width:80, header: "Total",align: 'right',  sortable: true, dataIndex: 'total_iten',
					renderer: function(v, params, record){
						return Ext.util.Format.usMoney(parseFloat(record.data.pr_venda) * parseFloat(record.data.qtd_produto));}
					},
					{id:'qtd_imp', width:60, header: "Qt Factura", align: 'right', sortable: true, dataIndex: 'qtd_imp',
					editor: new Ext.form.NumberField({
					allowBlank : false
					})
					},
					{id:'fisico', width:60, header: "Fisico", align: 'right', sortable: true, renderer: renderBlue, dataIndex: 'fisico',css: "background-color: #FFFFE7;"},
					{id:'stok', width:60, header: "<b>Legal</b>", align: 'right', sortable: true, renderer: renderBlue, dataIndex: 'stok', css: "background-color: #FFF3D6;"}
		        ]), 
	        viewConfig: {
         forceFit: true
        ,getRowClass: function(record, rowIndex, rp, ds){ // rp = rowParams
            if(record.get('qtd_imp') > '0'){
                return 'x-grid3-row-ativo';
            }
            //return 'x-grid3-row-inativo';
        }
    },
			//view: new Ext.grid.GridView({
			//forceFit: true,
			//getRowClass: MudaCor 
			//}),
			collapsible: false,
			plugins: [action],
			enableCaching:false,
			columnLines: true,
			animCollapse: false,
			enableColLock: false,
			loadMask:true,
			autoWidth:true,
			height: 250,
			listeners:{ 
					celldblclick: function(grid, rowIndex, columnIndex, e){
					records = grid.getStore().getAt(rowIndex); // Pega linha 
					recordold = grid.getStore().getAt(rowIndex); // Pega linha 
					var fieldNames = grid.getColumnModel().getDataIndex(1); // Pega campo da coluna
					prod = records.get(fieldNames); //Valor do campo
										
				    var coluna = grid.getColumnModel().getColumnId(columnIndex);
					if(coluna == 'refer_prod'){					
					WinEqvla.show();
					dsEqvla.load({params:{acao: 'ListarEqvlas', 'pesquisa': prod, start: 0, limit: 30}});
					}
					
				//	ds = dsVendaItens.readRecords();
				//	console.info(ds);
         }
		},
		 bbar: new Ext.ux.StatusBar({
            id: 'basic-statusbar',
            // defaults to use when the status is cleared:
            defaultText: '',
            //defaultIconCls: 'default-icon',      
            // values to set initially:
            text: '',
            iconCls: '',
			statusAlign: 'right',
            // any standard Toolbar items:
            items: ['-',
                'Numero Maximo de Itens: 22',
				'-',
				{
			     xtype: 'button', 
			     id: 'faturar',
                 text: 'Emitir Factura',
                // scale: 'large',
				 iconCls: 'icon-print',
			     width: 20,
			     handler: function(){
				
				//			 Ext.get('mb2').on('click', function(e){
				Ext.MessageBox.prompt('Formulario', 'Informe el numero de formulario:', showResultText);
		  //  });


					}
			
			}
			
			]
			})
            
            });
			
			dd = new Ext.data.JsonStore({
				url: 'pesquisa_coddesc.php?acao_nome=DescProd',
				root: 'resultados',
				fields: [ 'idprod', 'Codigo', 'Descricao', 'descprod', 'stok', 'fisico' ]
				});
	
	var formtplVenda = new Ext.Panel({
        frame:false,
        border: true,
		items:[]
	});
	

	var FormVenda = new Ext.FormPanel({
        title: 'Faturar Pedido',
        //id: 'FormVenda',
		frame: true,
        autoWidth: true,
       // autoEl: 'div',
		layout:'form',
		closable:true,
		closeAction :'hide',
        labelAlign: 'right',
        autoScroll: true,
        items: [ 
                formtplVenda,
				{
				xtype:'combo',
				hideTrigger: true,
				allowBlank: true,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Incluir Iten',
			//	id: 'idprod',
				minChars: 3,
				name: 'idprod',
				width: 200,
                resizable: true,
                listWidth: 350,
				forceSelection: true,
				store: dd,
					hiddenName: 'idprod',
					valueField: 'descprod',
					displayField: 'descprod',
					fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
											
						}
					},
					onSelect: function(record){
					
					var  Record = Ext.data.Record.create(['idprod','Codigo','Descricao','qtd_produto','pr_venda', 'stok', 'fisico']);
					var dados = new Record({
								"idproduto":record.data.idprod,
								"Codigo":record.data.Codigo, 
								"desc_prod":record.data.Descricao,
								"stok":record.data.stok,
								"fisico":record.data.fisico,
								"qtd_produto":"0",
								"pr_venda":'0'
							});
						//record = gridFatItensVenda.getSelectionModel().getSelected();
						dsVendaItens.insert(0,dados);
						
						
						idprod = record.data.idprod;
						Codigo = record.data.Codigo;
						this.collapse();
						this.setValue(Codigo);
						//formFornecedor.getForm().findField('idFornecedor').setValue(idforn);
					}
							
                },
                gridFatItensVenda,   
				{
					style: 'margin-top:10px'
					 }
                
	
        ],
        listeners:{
					destroy: function() {
							// sul.remove('gridFatVenda');
							//Ext.getCmp('tabss').remove(FormVenda);
         				}
			
		}
		});
        
 
	
	gridFatVenda.on('rowdblclick', function(grid, row, e) {  
					
	Ext.getCmp('tabss').add(FormVenda);
	Ext.getCmp('tabss').setActiveTab(FormVenda);
	FormVenda.doLayout();
	
   VendaTpl.overwrite(formtplVenda.body, dsFatVenda.getAt(row).data);
       
    idVendaFat = dsFatVenda.getAt(row).data.idVenda;
    total_nota = dsFatVenda.getAt(row).data.total_nota;
    idforma = dsFatVenda.getAt(row).data.idforma;
		
    dsVendaItens.load({params:{acao: 'listarItensVenda',idVenda: idVendaFat }});
   
   
    

}); 

	MyWindowEqvlaUi = Ext.extend(Ext.Window, {
    title: 'Produtos Equivalentes',
    width: 465,
    autoHeight: true,
    resizable: false,
    plain: false,
   // modal: true,
	shim: false,
	shadow: false,
	border: false,
	layout: 'form',
    closeAction: 'hide',
    initComponent: function() {
        this.items = [GridEqvla];
        MyWindowEqvlaUi.superclass.initComponent.call(this);
    }
});

WinEqvla = new MyWindowEqvlaUi();
	
     FormVendaFaturar = new Ext.FormPanel({
			id: 'FormVendaFaturar',
            title       : 'Vendas',
			labelAlign: 'left',
			frame		: true,
			closable:true,
            autoWidth   : true,
			//height	: 350,
            collapsible : false,
			layout:'form',
            items:[gridFatVenda],
            listeners:{
					destroy: function() {
							 tabs.remove('FormVenda');
         				   }
		              }
            });
		
 //   Ext.getCmp('tabss').add(formtplPedido,);
 //   Ext.getCmp('tabss').setActiveTab(formtplVenda);
 //   formtplVenda.doLayout();		
	
var imprimirPedidoPDF = function(){
var selectedKeys = 17; 

		Ext.Ajax.request({
		    url: "factura.php",
            params: {
		        user: id_usuario,
				acao: 'Faturar',
                id_pedido: selectedKeys
				}
				, waitMsg: 'Faturando'
				, waitTitle : 'Aguarde....'
				, scope: this
				,callback: function (options, success, response) {
							if (success) { 
								Ext.MessageBox.alert('OK', response.responseText);
								var json = Ext.util.JSON.decode(response.responseText);
							if(json.response == 'Enviado com Sucesso'){
								mens = "Enviado com Sucesso";
								} 
							
							Ext.MessageBox.alert('Alerta', mens);
							} 
							else{
								Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
							}
							},
					failure:function(response,options){
											Ext.MessageBox.alert('Alerta', 'Erro...');
										},                                      
					success:function(response,options){
											//dsPagoProv.reload();
										}                           					
														
			     }); 

				 

			}



	
	
Ext.getCmp('tabss').add(gridFatVenda);
Ext.getCmp('tabss').setActiveTab(gridFatVenda);
gridFatVenda.doLayout();		
	
	
	
}