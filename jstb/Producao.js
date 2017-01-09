Ext.override(Ext.form.NumberField, {
    setValue : function(v){
            v = typeof v == 'number' ? v : String(v).replace(this.decimalSeparator, ".");
        v = isNaN(v) ? '' : String(v).replace(".", this.decimalSeparator);
        return Ext.form.NumberField.superclass.setValue.call(this, v);
    },
    fixPrecision : function(value){
        var nan = isNaN(value);
        if(!this.allowDecimals || this.decimalPrecision == -1 || nan || !value){
           return nan ? '' : value;
        }
        return parseFloat(value).toFixed(this.decimalPrecision);
    }
})

Producao = function(){

	if(perm.CadGrupos.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}




var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Favor elejir un registro');
}

var action = new Ext.ux.grid.RowActions({
    header:'Remover'
   ,autoWidth: false
   ,actions:[{
       iconCls:'icon-excluir'
      ,tooltip:'Remover'
	  ,width: 7
   }] 
});
action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	idinsumo = record.data.idprod;
	acao = 'RemInsumo';
	ManipulaProd(acao,idinsumo);
	dsProdFormula.remove(record);
	
   }
});

//////////INICIO DA STORE ////////////////////
var dsProducao = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/Producao.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'idproducao'
		},
			[
			{name: 'idproducao'},
			{name: 'idproduto'},
			{name: 'disponivel'},
			{name: 'bloqueado'},
			{name: 'Descricao'},
			{name: 'Codigo'},
			{name: 'Estoque'}
			]
		),
		sortInfo: {field: 'idproducao', direction: 'DESC'},
		remoteSort: true,
		baseParams:{acao: 'ListaProds'},
		autoLoad: true
	});
//////// FIM STORE //////////////

var grid_Producao = new Ext.grid.EditorGridPanel(
	    {
	        store: dsProducao, // use the datasource
	        
	        columns:
		        [
						{id:'idproducao',header: "Codigo", width: 20, sortable: true, dataIndex: 'idproducao'},	        
						{header: "idproduto", width: 150, hidden: true, align: 'left', sortable: true, dataIndex: 'idproduto'},
						{header: "Codigo", width: 50, dataIndex: 'Codigo'},
						{header: "Descricao", width: 150, align: 'left', sortable: true, dataIndex: 'Descricao'},
						{header: "Disponivel para Venta", width: 50, align: 'left', sortable: true, dataIndex: 'Estoque'},
						{header: "Disponivel Fabrica", width: 50, align: 'right', sortable: true, dataIndex: 'disponivel'},
						{header: "Bloqueado Fabrica", width: 50, align: 'right', sortable: true, dataIndex: 'bloqueado'}
			
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
			//id: 'despesa_id',
			height: 300,
			ds: dsProducao,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dsProducao,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Nao tem dados",
				pageSize: 200,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina", 
				items:[],
				refreshText : "Atualizar",
				paramNames : {start: 'start', limit: 'limit'},
				items:[]
				}),
			tbar: [
				   {
					text: 'Formula del Producto',
					iconCls:'formula',
					tooltip: 'Clique para lancar un nuevo registro',
					handler: function(){
							selectedKeys = grid_Producao.selModel.selections.keys;
							selectedRows = grid_Producao.selModel.selections.items;
								if(selectedKeys.length > 0){
								record = grid_Producao.getSelectionModel().getSelected();
								idName = grid_Producao.getColumnModel().getDataIndex(1); // Get field name
								idproduto = record.get(idName);
								//console.info(controle);
									NovaFabricacao.show(); 
									dsProdFormula.load({params: {acao: 'ListaInsumos', idproducao: selectedKeys}});
									}
									else{
										selecione();
										}
							}
					}
				]
			
	});
	
	ManipulaProd = function(acao,idinsumo,qtd){
							 Ext.Ajax.request({
									url: 'php/Producao.php',
									method: 'POST',
									remoteSort: true,
									params: {
											acao: acao,
											idproduto: idproduto,
											idinsumo:idinsumo,
											qtd: qtd,
											idproducao: selectedKeys
									},
							callback: function (options, success, response) {
										if (success) { 
											Ext.MessageBox.alert('OK', response.responseText);
											var jsonData = Ext.util.JSON.decode(response.responseText);
												if(jsonData.del_count){
													
												}
												if(jsonData.response == 'ss'){ 
												
												}
											
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										
										}
								});
							}
	
	dsProdFormula = new Ext.data.GroupingStore({
			 proxy: new Ext.data.HttpProxy({
                url: 'php/Producao.php',
                method: 'POST'
				}),
				groupField:'idproduto',
				sortInfo:{field: 'idprod', direction: "DESC"},
				nocache: true,
            reader:  new Ext.data.JsonReader({
				totalProperty: 'total',
				root: 'results',
				id: 'idprod',
				fields: [
						 {name: 'action', type: 'string'},
						 {name: 'idprod',  mapping: 'idprod',  type: 'string' },
						 {name: 'codigo',  mapping: 'codigo' },
						 {name: 'descricao',  type: 'string' },
						 {name: 'un_medida',  type: 'int' },
						 {name: 'sigmed',  type: 'string' },
						 {name: 'idproduto',  type: 'int' },
						 {name: 'custo', type: 'float' },
						 {name: 'qtd_produto', type: 'float'},
						 {name: 'totals'},
						 {name: 'totalProds'}
						 ]
			})					    
		});
	// define a custom summary function
     Ext.grid.GroupSummary.Calculations['totalProds'] = function(v, record, field){
	//	precio = record.data.valorB;
	//	precio = precio.replace(".","");
		var v = v+ (parseFloat(record.data.custo) * parseFloat(record.data.qtd_produto));   //toNum
		//Ext.getCmp("SubTotal").setValue((v));
	   // subnota =  Ext.get("SubTotal").getValue();
				
		subtotal =  v ;
		//geral = totalnota - desc
		//.getCmp("Total").setValue(Ext.util.Format.usMoney(v));
		return v;
		
    }
	
	var summary = new Ext.grid.GroupSummary(); 
	var gridProdFormula = new Ext.grid.EditorGridPanel({
		   store: dsProdFormula,
		   enableColLock: true,
		   containerScroll  : false,
		   loadMask: {msg: 'Carregando...'},
			 columns: [
			  {id: 'idproduto', header: 'idproduto', width: 10, dataIndex: 'idproduto'},
			  {id: 'idprod', header: 'idprod', hidden: true, width: 10, dataIndex: 'idprod'},	
			  {id: 'codigo', header: 'Producto', summaryType: 'count', width: 200, dataIndex: 'codigo' },
			  {id: 'sigmed', header: 'UN Medida',  width: 80, dataIndex: 'sigmed'},
			  {id: 'un_medida', hidden: true, width: 80, dataIndex: 'un_medida'},
			  {id: 'custo', header: 'Costo Unit',  width: 80, dataIndex: 'custo', renderer: 'usMoney'},		
			  {id: 'qtd_produto', header: "Cant", dataIndex: 'qtd_produto', width: 80, align: 'right',   
					editor: new Ext.form.NumberField(  
						{
						allowBlank: false,
						selectOnFocus:true,
						allowNegative: false,
						decimalPrecision: 3
						})
			  },
			    {
			    id: 'totals',
			    header: "Costo Insumo",
			    width: 100,
			    align: 'right',
				sortable: false,
				fixed:true,
				groupable: false,
				renderer: function(v, params, record){
				val = Ext.util.Format.usMoney( (parseInt(record.data.custo)) * (parseFloat(record.data.qtd_produto)))
				 return val;
				},
				id:'totalProds',
				dataIndex: 'totalProds',
				summaryType:'totalProds',
				fixed:true,
				summaryRenderer: Ext.util.Format.usMoney
				},
				action
				],
				 view: new Ext.grid.GroupingView({
						forceFit:true,
						showGroupName: false,
						enableNoGroups:false, // REQUIRED!
						hideGroupedColumn: true
					}),
			   autoWidth:  true,
			   height: 350,
			   title: 'Insumos del producto industrializado',
			   border: true,
			   moveEditorOnEnter: true,
			   plugins: [summary,action],
			   loadMask: true,
			   clicksToEdit: 2,
			   listeners:{
						afteredit:function(e){
						idinsumo = e.record.data.idprod;
						qtd = e.value;
						acao = 'AddInsumo';
						ManipulaProd(acao,idinsumo,qtd);
						},
						  editcomplete:function(ed,value){
						  setTimeout(function(){
						  if(ed.col == 7){				
							//  Ext.getCmp("CodigoProduto").focus();
						  }
						  if(ed.col == 6 ){				
							//	gridProd.startEditing(ed.row,ed.col+1);
						  }
						   }, 250);
						  },
						  celldblclick: function(grid, rowIndex, columnIndex, e){
							   
							}
				}
}); 

			/*
			gridProdFormula.on('rowdblclick', function(grid, row, e) {
				
				descmax = dsCliPedido.getAt(row).get('descmax');
				controle = dsCliPedido.getAt(row).get('controleCliP');
			//console.info(controle);
						record = gridProdFormula.getSelectionModel().getSelected();
						var idName = gridProdFormula.getColumnModel().getDataIndex(0); // Get field name
						var idData = record.get(idName);
					
				select_cli_pedido.hide()
				dsProdFormula.load(({params:{'cliente':idData, 'user': id_usuario}}));
				Ext.get('CodigoProduto').focus();
					
			}); 
			*/
	
	FormNovoProd= new Ext.FormPanel({
			frame		: true,
            split       : true,
         //   autoWidth   : true,
		//	autoHeight	: true,
            collapsible : false,
			items:[
					{
                    xtype:'combo',
					fieldLabel: 'Codigo Producto',
					hideTrigger: true,
					emptyText: 'Selecione',
					allowBlank: true,
					editable: true,
				//	mode: 'remote',
					triggerAction: 'all',
					dataField: ['idprod', 'codprod', 'junto', 'unid', 'custo', 'sigmed' ],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
				//	id: 'codprod',
					width: 250,
					minChars: 2,
					name: 'codprod',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: '/pesquisa_cod.php?acao_nome=CodDescUnidCust',
					root: 'resultados',
					fields: [ 'idprod', 'codprod', 'junto', 'unid', 'custo', 'sigmed' ]
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
						codprod = record.data.codprod;
						descprod = record.data.junto;
						unid = record.data.unid;
						sigmed = record.data.sigmed;
						custo = record.data.custo;
						//console.info(sigmed);
						this.collapse();
						this.setValue(descprod);
					
					
					}
	                },
					{
					xtype: 'button',
					text: 'Adicionar insumo',
					iconCls: 'addinsumo',
					col: true,
			//		width: 150,
			//		style: 'padding: 5px 0px ;',
					handler: function(){
								 var Record = Ext.data.Record.create(['idproduto', 'idprod','codigo', 'un_medida', 'sigmed', 'qtd_produto','custo','totals']);
							//	precio = record.data.valorB;
							//	precio = parseFloat(precio.replace(".",""));
								var dados = new Record({
										"idproduto":idproduto,
										"idprod":idprod,
										"codigo":descprod, 
										"qtd_produto":"0",
										"un_medida": unid,
										"sigmed": sigmed,
										"custo": custo,
										"totals":"",
										"totalProds":""
										});
										//secondGrid.startEditing(0,3);
										// Verificando se o frete já foi inserido
											 // Percorrendo o Store do Grid para resgatar os dados
											 var Duplicado = "nao";
											dsProdFormula.each(function( record ){
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
											if(idproduto == dados.data.idprod){
												Ext.MessageBox.alert('Erro','No podes incluir el mismo a la formula !!');
											}
											else{										
												// ok	console.info(record.data.idprod);
													dsProdFormula.insert(0,dados);
													gridProdFormula.startEditing(0,6);
													Duplicado = "nao";
											}
									
					}
					},
					gridProdFormula]
		});

				NovaFabricacao = new Ext.Window({
	                  layout: 'form'
	                , width: 800
					, title       : 'Formulacion de productos'
					, autoHeight: true
	                , closeAction :'hide'
	                , plain: true
					, resizable: true
					, modal: true
					, items:[FormNovoProd]
					,buttons: [
								{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					NovaFabricacao.hide();
							//	FormCadGrupo.getForm().reset();
								}
  			 					}
							]
				});


var FormProducao= new Ext.FormPanel({
            title       : 'Produtos',
			labelAlign: 'top',
            closable	: true,
			frame		: true,
            split       : true,
            autoWidth   : true,
			layout		: 'form',
			items:[
					{
                    xtype:'combo',
					fieldLabel: 'Codigo Producto',
					hideTrigger: true,
					emptyText: 'Selecione',
					allowBlank: true,
					editable: true,
				//	mode: 'remote',
					triggerAction: 'all',
					dataField: ['idprod','codprod', 'junto'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
				//	id: 'codprod',
					width: 250,
					minChars: 2,
					name: 'codprod',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: '/pesquisa_cod.php?acao_nome=CodDesc',
					root: 'resultados',
					fields: [ 'idprod', 'codprod', 'junto' ]
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
					var	codprod = record.data.codprod;
					var	descprod = record.data.junto;
						this.collapse();
						this.setValue(descprod);
					
					
					}
	                },
					{
					xtype: 'button',
					text: 'Adicionar a producion',
					iconCls: 'icon-add',
					col: true,
					width: 150,
					style: 'padding: 19px 0px ;',
					handler: function(){
						 Ext.Ajax.request({
							  url   : 'php/Producao.php',
							  method: 'POST',
							  params: {
								  acao: 'AddProducao',
								  idprod: idprod,
								  user: id_usuario
								},
							  success: function(response){//se ocorrer correto 
								var jsonData = Ext.decode(response.responseText);
								 response = Ext.decode( response.responseText);
								 if(response){ 
								 if(response.response == "Produto ja incluido"){
									Ext.MessageBox.alert('AVIZO', response.response);
								 }
								 if(response.response == "Operacion Realizada con Exito"){
									Ext.MessageBox.alert('AVIZO', response.response);
									dsProducao.reload();
								 }
								 
														
								 
								 }
								 else{ 
								 FormReq.getForm().findField('IdForne').setValue();
								 Ext.MessageBox.alert('Aviso', 'Fornecedor nao encontrado'); }
								 
								}
							});
					
					}
					},
					grid_Producao
					],
					listeners: {
								destroy: function() {
								//	if(PrecoGrupo instanceof Ext.Window)
							   //     PrecoGrupo.destroy(); 
								//	if(NovoGrupo instanceof Ext.Window)
								//	NovoGrupo.destroy(); 
								}
							 }
        }); 



Ext.getCmp('tabss').add(FormProducao);
Ext.getCmp('tabss').setActiveTab(FormProducao);
FormProducao.doLayout();	
			

}