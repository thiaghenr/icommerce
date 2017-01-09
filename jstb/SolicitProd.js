// JavaScript Document


Solicit = function(){



Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
Ext.QuickTips.init();

Ext.override(Ext.grid.EditorGridPanel, {
initComponent: Ext.grid.EditorGridPanel.prototype.initComponent.createSequence(function(){
this.addEvents("editcomplete");
}),
onEditComplete: Ext.grid.EditorGridPanel.prototype.onEditComplete.createSequence(function(ed, value, startValue){
this.fireEvent("editcomplete", ed, value, startValue);
})
});

var xgOrdem = Ext.grid;

var formataSituacao = function(value){
	
	if(value=='0'){
		  return '<span style="color: #FF0000;">Aguardando Producion</span>';
	}
	else{
		  return '<span style="color: #6EEAE9;">Concluido</span>'; 
	}

};

var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Por favor selecione um pedido');
}

/////////////// PDF //////////////////////////////
var impOrdemPDF = function(){
var selectedKeys = GridSolicit.selModel.selections.keys;
if(selectedKeys.length > 0){	
var selectedKeys = GridSolicit.selModel.selections.keys; 
																
var winOrdemPDF = new Ext.Window({
					id: 'imprimePedido',
					title: 'Pedido',
					width: 650,
					height: 500,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='../pdf_ordem.php?id="+selectedKeys +"' > </iframe>" },
					buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					winOrdemPDF.destroy();
  			 					}
			 
        					}]
				});
				winOrdemPDF.show();
			}
else{
selecione();
}
}

var action = new Ext.ux.grid.RowActions({
    header:'Remover'
   ,autoWidth: false
   ,actions:[{
       iconCls:'icon-excluir'
      ,tooltip:'Remover'
	  ,width: 5
	  }] 
});
action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	idinsumo = record.data.idprod;
	acao = 'RemProd';
	dsOrdemProd.remove(record);
	
   }
});

		
		////////////////STORE DOS PEDIDOS DO CLIENTE ///////////////////////
var dsItensProd = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/SolicitProd.php',
			method: 'POST'
		}),   
//		baseParams:{acao: "listarContatos"},
		reader:  new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'idproducao_solicit_itens'
		},
			[
				{name: 'idproducao_solicit_itens'},
				{name: 'idsolicit'},
				{name: 'idproduto_produzir'},
				{name: 'Descricao'},
				{name: 'Codigo'},
				{name: 'sigla_medida'},
				{name: 'qtd_prdoduzir',  type: 'string'},
				{name: 'obs'},
				{name: 'qtdproduzido'},
				{name: 'idprodsolicit'}
				
			]
		),
		sortInfo: {field: 'idproducao_solicit_itens', direction: 'DESC'},  
		remoteSort: true,
		baseParams:{acao: 'ListaItensOrdem'}
	});
//////// FIM STORE DOS PEDIDOS DO CLIENTE //////////////
//////// INICIO DA GRID DOS PEDIDOS DO CLIENTE ////////
 var gridItensProducao = new Ext.grid.GridPanel({
	        store: dsItensProd, // use the datasource
	        columns:
		        [
		        	//expander,
					{hidden: true,  sortable: true, dataIndex: 'idproducao_solicit_itens'},
					{hidden: true,  sortable: true, dataIndex: 'idsolicit'},
		            {hidden: true,  sortable: true, dataIndex: 'idproduto_produzir'},
		            {width:80, header: "Codigo",  sortable: true, dataIndex: 'Codigo'},
					{width:100, header: "Descripcion",  sortable: true, dataIndex: 'Descricao'},
					{width:80, header: "UN Medida",  sortable: true, dataIndex: 'sigla_medida'},
					{width:80, header: "Cant Solicitada",  sortable: true, dataIndex: 'qtd_prdoduzir'},
					{width:200, header: "Obs",  sortable: true, dataIndex: 'obs'},
					{width:80, header: "Cant Produzido",  sortable: true, dataIndex: 'qtdproduzido'}
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			autoWidth:true,
			autoHeight: true,
			border: true,
			loadMask: true,
			title:'Itens Solicitados',
			closable: true,
			enableColLock: false,
			//renderTo: Ext.getCmp('south').body,
	        stripeRows:true,
	        iconCls:'icon-grid',
            bbar: new Ext.PagingToolbar({
				store: dsItensProd,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Não tem dados",
				pageSize: 20,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina",    
				refreshText : "Atualizar"  
			//	paramNames : {start: 0, limit: 5},
			})
});


/////////////////////// INICIO STORE //////////////////////////////////
dsSolicit = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: 'php/SolicitProd.php',
        method: 'POST'
    }),   

reader:  new Ext.data.JsonReader({
			totalProperty: 'total',
			root: 'results',
			id: 'idproducao_solicit',
			fields: [
					 {name: 'idproducao_solicit',  type: 'string' },
					 {name: 'data_solicit',  type: 'string'},
					 {name: 'data_validade',  type: 'string'},
					 {name: 'dtconclusao',  type: 'string'},
					 {name: 'nome_user',  type: 'string'},
					 {name: 'situacao',  type: 'int'}
					 ]
			}),					    
			baseParams:{acao: 'ListaSolicit'}
		})
///////////// FIM STORE ////////////////////////
///////////// INICIO DA GRID //////////////////

	     var GridSolicit = new Ext.grid.GridPanel({
	        store: dsSolicit, // use the datasource
	       cm: new xgOrdem.ColumnModel([
		       
		        	//expander,
		            {id:'idproducao_solicit', align: 'center', width:40, header: "Orden",  sortable: true, dataIndex: 'idproducao_solicit'},
					{width:60, header: "Fecha Orden",  sortable: true, dataIndex: 'data_solicit'},
					{width:60, header: "Hasta el dia", align: 'left', sortable: true, dataIndex: 'data_validade'},
					{width:60, header: "Solicitante", align: 'left', sortable: true, dataIndex: 'nome_user'},
					{width:60, header: "Situacion", align: 'left', renderer: formataSituacao, sortable: true, dataIndex: 'situacao'},
					{width:60, header: "Fecha Conclusion", align: 'left', sortable: true, dataIndex: 'dtconclusao'}
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
			tbar : new Ext.Toolbar({
			align:'left',
         	buttons: [	
						{
           			    text: 'Nueva Orden',
						align: 'left',
						iconCls: 'icon-add',
            			handler: function(){ // fechar	
     	    			WinNovaOrdem.show();
						}
  			 			},
						'-',
						/*
           				{
           			    text: 'Excluir',
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
						align: 'left',
						iconCls: 'icon-pdf',
            			handler: function(){ // fechar	
     	    			impOrdemPDF();
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
                emptyText: 'N.Solicitacion',
				width: 120,
				forceSelection: true,
				store: [
                            ['idproducao_solicit','Numero']
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
							dsSolicit.load({params:{query: theQuery, combo: Ext.getCmp('sitID').getValue()}});
							 }
						}				
					}
	            }
						
			 
        ]
    }),
			bbar: new Ext.PagingToolbar({
				store: dsSolicit,
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
		dsSolicit.load({params:{acao: 'ListaSolicit',start: 0, limit: 40}});
		
		GridSolicit.on('rowclick', function(grid, row, e) {
			record = GridSolicit.getSelectionModel().getSelected();
			var idName = GridSolicit.getColumnModel().getDataIndex(0); // Get field name
			var idData = record.get(idName);
			dsItensProd.load({params:{id: idData}});
		});

		
		FormSolicit = new Ext.FormPanel({
		    autoWidth:true,
			autoScroll: true,
			border: false,
	        frame:true,
			//autoHeight: true,
			//height: 200,
			closable: true,
			layout: 'form',
	        title: 'Solicitaciones',
			items: [GridSolicit,gridItensProducao],
			listeners:{
				destroy: function() {
                             //grid_ItensPedido.destroy();
							// sul.remove('FormGridPedidosEdit');
							 
         				}
			         }	
	});
	
	dsOrdemProd = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/SolicitProd.php',
			method: 'POST'
		}),
		baseParams:{
			acao: 'ListarProdOrdem'
			},
		reader:  new Ext.data.JsonReader({
			root: 'Ordem',
			id: 'idproducao_solicit_itens'
		},
			[		
				   {name: 'action', type: 'string'},
				   {name: 'idproducao_solicit_itens'},
				   {name: 'idprod'},
				   {name: 'codigo'},
		           {name: 'qtd_prdoduzir'},
		           {name: 'obs'},
				   {name: 'sigmed'}
				
			]
		),
		sortInfo: {field: 'id_lanc_despesa', direction: 'DESC'},
		remoteSort: true,
		autoLoad: true
	});
	var gridOrdemProd = new Ext.grid.EditorGridPanel({
	        store: dsOrdemProd, 
	        columns:
		        [
						{id:'idproducao_solicit_itens', hidden: true, width: 2, sortable: true, dataIndex: 'idproducao_solicit_itens'},
						{hidden: true, sortable: true, dataIndex: 'idprod'},
						{header: "Producto", width: 130, sortable: true, dataIndex: 'codigo'},
						{header: "UN. Med", width: 130, sortable: true, dataIndex: 'sigmed'},
						{header: "Cantidad", width: 60, align: 'left', sortable: true, dataIndex: 'qtd_prdoduzir',
							editor: new Ext.form.NumberField(  
							{
							allowBlank: false,
							selectOnFocus:true,
							allowNegative: false,
							decimalPrecision: 2
							})
						},
						{header: "Obs", width: 200, align: 'left', sortable: true, dataIndex: 'obs',
							editor: new Ext.form.TextField(  
							{
							selectOnFocus:true
							})
						},
						action
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				autoExpandColumn: true,
				emptyText: 'Nenhum registro encontrado' 
	        },
			autoWidth: true,
			plugins: [action],
			stripeRows : true,
			autoHeight: true,
			loadMask: true,
			autoScroll: true,
			enableColLock: false,
	        stripeRows:true,
			closable: true,
			title: 'Productos a Produzir',
			clicksToEdit: 2,
			listeners:{
						afteredit:function(e){
						idprod = e.record.data.idprod;
						qtd = e.value;
						acao = 'AddProducao';
						Ext.Ajax.request({
							url: 'php/SolicitProd.php',
							method: 'POST',
							remoteSort: true,
								params: {
									acao: 'VerificaQtd',
									idprod: idprod,
									qtd: qtd
								},
							callback: function (options, success, response) {
								if (success) { 
									var jsonData = Ext.util.JSON.decode(response.responseText);
									if(jsonData.total > 0){
										Ext.MessageBox.alert('Avizo', 'Un iten que compoe este producto no tiene cantidad suficiente: '+ response.responseText,
											function(btn){
												if(btn == "ok"){
													e.record.reject();
													gridOrdemProd.startEditing(0,4);
													FormNovaOrdem.getForm().findField('codprod').setValue();
												} 
											}
										);
									}
									if(jsonData.total == 0){ 
										gridOrdemProd.startEditing(0,5);
										FormNovaOrdem.getForm().findField('codprod').setValue();
									}	
								}
								else{
									Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
								}
							}
						});	
						},
						editcomplete:function(ed,value){
							setTimeout(function(){
								if(ed.col == 4){
								}
						   }, 250);
						},
						celldblclick: function(grid, rowIndex, columnIndex, e){
						}
			}
	});
	
	FormNovaOrdem = new Ext.FormPanel({
			labelAlign: 'left',
			height		:380,
			labelWidth: 140,
			frame       :true,
			autoScroll: true,
			items: [
					{
					xtype:'datefield',
					fieldLabel: 'Produzir todos hasta dia',
					width: 130,
					allowBlank: false,
					emptyText: 'Campo Obligatorio',
					name: 'dtproduzir'
					},
					{
                    xtype:'combo',
					fieldLabel: 'Agregar a Orden',
					hideTrigger: true,
					emptyText: 'Selecione',
					allowBlank: true,
					editable: true,
					triggerAction: 'all',
					dataField: ['idprod','codprod', 'junto'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
					width: 250,
					minChars: 2,
					name: 'codprod',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: '/pesquisa_cod.php?acao_nome=Producao',
					root: 'resultados',
					fields: [ 'idprod', 'junto', 'obs', 'unid', 'sigmed' ]
					}),
					//	hiddenName: 'idprod',
					//	valueField: 'idprod',
						displayField: 'junto',
						fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('grupo').focus();
                            }},
					onSelect: function(record){
						idprod = record.data.idprod;
						descprod = record.data.junto;
						unid = record.data.unid;
						sigmed = record.data.sigmed;
						custo = '';
						//console.info(sigmed);
						this.collapse();
						this.setValue(descprod);
					
					
					}
	                },
					{
					xtype: 'button',
					text: 'Agregar',
					iconCls: '',
					col: true,
			//		width: 150,
			//		style: 'padding: 5px 0px ;',
					handler: function(){
								 var Record = Ext.data.Record.create(['idprod','codigo', 'un_medida', 'sigmed', 'qtd_prdoduzir','obs']);
							//	precio = record.data.valorB;
							//	precio = parseFloat(precio.replace(".",""));
								var dados = new Record({
										"idprod":idprod,
										"codigo":descprod, 
										"qtd_prdoduzir":"0",
										"un_medida": unid,
										"sigmed": sigmed,
										"obs": ""
										});
										//secondGrid.startEditing(0,3);
										// Verificando se o frete já foi inserido
											 // Percorrendo o Store do Grid para resgatar os dados
											 var Duplicado = "nao";
											dsOrdemProd.each(function( record ){
												// Recebendo os dados
												//console.info( record.data.idprod );
												//idprod
												if(dados.data.idprod == record.data.idprod){
												 Duplicado = "sim";
											}
											});
											if(Duplicado == "sim"){
												Ext.MessageBox.alert('Erro','Iten ya adicionado !!');
											}
										//	if(idprod == dados.data.idprod){
										//		Ext.MessageBox.alert('Erro','No podes incluir el mismo a la formula !!');
										//	}
										//	else{										
												// ok	console.info(record.data.idprod);
													dsOrdemProd.insert(0,dados);
													gridOrdemProd.startEditing(0,4);
													Duplicado = "nao";
										//	}
									
					}
					},
					gridOrdemProd
					]
	  }); 

	WinNovaOrdem = new Ext.Window({
				title: 'Nueva Orden',
				width:730,
				plain: true,						
				collapsible: false,
				closeAction:'hide',
				modal: true,
				border: true,
				items: [FormNovaOrdem],
				buttons: [
								{
								xtype:'button',
								text: 'Gravar',
								iconCls: 'icon-save',
								handler:function(){
									data = FormNovaOrdem.getForm().findField('dtproduzir').getValue();
									if(data != ""){
									// Extraindo os dados do Grid
									var jsonData = [];
									// Percorrendo o Store do Grid para resgatar os dados
									dsOrdemProd.each(function( record ){
									// Recebendo os dados
									jsonData.push( record.data );
										});
									jsonData = Ext.encode(jsonData);
									Ext.Ajax.request({ 
										url: 'php/SolicitProd.php',
										method: 'POST',
										remoteSort: true,
										params: {
										acao: 'CadSolicit', 
										user: id_usuario,
										dados: jsonData,
										dtproduzir : FormNovaOrdem.getForm().findField('dtproduzir').getValue()
										},
										callback: function (options, success, response) {
										if (success) { 
											//Ext.MessageBox.alert('OK', response.responseText);
											var jsonData = Ext.util.JSON.decode(response.responseText);
											if(jsonData.Ordem > 0 ){
											Ext.MessageBox.alert('OK:', '<strong>Orden N.: </strong>'+ jsonData.Ordem +'<br />'+
																					   '<strong>Cant. Itens:  </strong>'+ jsonData.del_count  +'<br />',
																					   function(btn){
												if(btn == "ok"){
													dsSolicit.load({params: {acao: 'ListaSolicit'}});
													dsOrdemProd.removeAll();
													FormNovaOrdem.form.reset();
													WinNovaOrdem.hide();
												} });
											
											}
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										}
									});
									}
									else{
										Ext.MessageBox.alert('Avizo',"Necesario informar fecha para finalizacion");
									}

								}
								},
								{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					WinNovaOrdem.hide();
								FormNovaOrdem.getForm().reset();
								dsOrdemProd.removeAll();
								}
  			 					}
							]
			})
		
		

Ext.getCmp('tabss').add(FormSolicit);
Ext.getCmp('tabss').setActiveTab(FormSolicit);
FormSolicit.doLayout();	

};