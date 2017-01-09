  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  Ext.QuickTips.init();
  
   Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
  
  Ext.QuickTips.init();
  Ext.form.Field.prototype.msgTarget = 'side';
  
  GREtiquetas = function(){

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
  
  var action = new Ext.ux.grid.RowActions({
    header:'Excluir'
   ,autoWidth: false
   ,actions:[{
       iconCls:'icon-excluir'
      ,tooltip:'Excluir'
	  ,width: 10
   }] 
});
action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );
	  secondGridStoreEt.remove(record);
	  Ext.getCmp("CodigoProdutoEt").focus();
	 
   }
});

  
  	var dslistaProdEt = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'id',  mapping : 'id'},
				   {name: 'Codigo'},
		           {name: 'Descricao'},
		           {name: 'Estoque'},
				   {name: 'ref'},
		           {name: 'qtd_bloq'},
		           {name: 'valorA'},
				   {name: 'custo'},
				   {name: 'Codigo_Fabricante'},
				   {name: 'peso'}

				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		//id: 9,
		remoteSort: false		
	});
//////// FIM STORE DOS PRODUTOS /////////////
//////// INICIO DA GRID DOS PRODUTOS ////////
 var grid_listaProdEt = new Ext.grid.GridPanel({
	        store: dslistaProdEt, // use the datasource
	        columns:[
						{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header: "Cod Original", width: 80, align: 'left', sortable: true, dataIndex: 'Codigo_Fabricante'},
						{header:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descricao", width: 250, sortable: true, dataIndex: 'Descricao'},
						{header: "RF", width: 55, sortable: true, dataIndex: 'ref'},
						{header: "Peso", width: 55, sortable: true, dataIndex: 'peso'},
						{header: "Disponivel", width: 55, align: 'right', sortable: true, dataIndex: 'Estoque'},
						{header: "Bloqueados", width: 55,  align: 'right',  sortable: true, dataIndex: 'qtd_bloq'},
						{header: "Valor A", width: 80, align: 'right', sortable: true, dataIndex: 'valorA',renderer: 'usMoney'}
						
			 ],
	        viewConfig:{
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado'
				
	        },
			width:'100%',
			id:'grid_listaProd',
			height: 250,
			autoExpandColumn : 'id',
			loadMask: true,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dslistaProdEt,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Nao tem dados",
				pageSize: 100,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina", 
				refreshText : "Atualizar",
				paramNames : {start: 'start', limit: 'limit'},
				items:[
				{
				text: 'Gerar',
				iconCls:'icon-pdf',
				tooltip: 'Clique para lancar um registro(s) selecionado',
				handler: function(){
					jsonData = "[";
						
						for(d=0;d<secondGridStoreEt.getCount();d++) {
							record = secondGridStoreEt.getAt(d);
							if(record.data.newRecord || record.dirty) {
								jsonData += Ext.util.JSON.encode(record.data) + ",";
							}
						}
						
						jsonData = jsonData.substring(0,jsonData.length-1) + "]";
						//alert(jsonData);
							window.open('pdf_etiquetas.php?json='+jsonData +'','popup','width=750,height=500,scrolling=auto,top=0,left=0');		
					} }
				]
				
			})
});	
  
		secondGridStoreEt = new Ext.data.Store({
			 proxy: new Ext.data.HttpProxy({
                url: 'php/lista_prod.php',
                method: 'POST'
				}),
				sortInfo:{field: 'id', direction: "DESC"},
				nocache: true,

 reader:  new Ext.data.JsonReader({
				totalProperty: 'totalProdutos',
				root: 'Produtos',
				id: 'id',
				fields: [
						 {name: 'action1', type: 'string'},
						 {name: 'id', mapping: 'id', type: 'string' },
						 {name: 'Codigo_Fabricante', mapping: 'Codigo_Fabricante', type: 'string' },
						 {name: 'Codigo',  mapping: 'Codigo' },
						 {name: 'ref'},
						 {name: 'Descricao',  type: 'string' },
						 {name: 'qtd' }
						 ]
			})					    
		});
	
	var secondGridEt = new Ext.grid.EditorGridPanel({
   store: secondGridStoreEt,
   enableColLock: true,
   containerScroll  : false,
   loadMask: {msg: 'Carregando...'},
     columns: [
	   action,
	  {id: 'id', header: 'id', hidden: true, width: 10, dataIndex: 'id'},
	//  { header: 'Cod Original', width: 80, dataIndex: 'Codigo_Fabricante'},	  
	  { header: 'Codigo',  width: 70, dataIndex: 'Codigo' },
    //  { header: 'Descripcion', width: 250, dataIndex: 'Descricao'},
	  { header: 'Cantidad',  width: 70, dataIndex: 'qtd', 
	  editor: new Ext.form.NumberField({
								allowBlank: false,
								selectOnFocus:true,
								allowNegative: true
								}) },
	  {hidden: true,  header: 'ref', width: 250, dataIndex: 'ref'},
	  ],
	width:'100%',
   height:243,
   border: true,
   moveEditorOnEnter: true,
   plugins: [action],
   loadMask: true,
   clicksToEdit:1,
   listeners:{
	  editcomplete:function(ed,value){
	   if(ed.col == 3 ){
		setTimeout(function(){
		Ext.getCmp("CodigoProdutoEt").focus();
		}, 850);
		}
	  }
   		}
  });
  
  grid_listaProdEt.getSelectionModel().on('rowselect', function(sm, rowIndex, colIndex) {
		record = grid_listaProdEt.getStore().getAt( rowIndex );
		prodId = record.id;
		}, this);
  
  	grid_listaProdEt.addListener('keydown',function(event){
		   getItemRow(this, event);
		});
		
		function getItemRow(grid,  event){
		   key = getKey(event);
		//console.info(event);
		var idData = prodId; 
		
		var auto = 0;
		
		if(key==13){
	
   
	
        
		var Record = Ext.data.Record.create(['id','Codigo','Descricao','qtd', 'Codigo_Fabricante', 'ref']);
		var dados = new Record({"id":record.data.id,
								"Codigo":record.data.Codigo, 
							//	"Codigo_Fabricante": record.data.Codigo_Fabricante,
								"Descricao":record.data.Descricao,
								"qtd":"0",
							//	"ref": record.data.ref
								});
		
		//secondGrid.startEditing(0,3);
		record = grid_listaProdEt.getSelectionModel().getSelected();
		//console.info(dados);
		secondGridStoreEt.insert(0,dados);
		secondGridEt.startEditing(0,3);
				
			}
		if(key >47 && key < 58 || key >64 && key < 91 || key >95 && key < 106 ){
 	   					Ext.getCmp('CodigoProdutoEt').focus(); 
			}
		
		}
		
  		/////////////////INICIO DO FORM  NORTH //////////////////////////////
		var FormlistaProdsEt = new Ext.form.FormPanel({
			labelAlign: 'top',
			id: 'FormlistaProdsEt',
			title: 'Gerar Etiquetas',
            closable:true,
			frame: true,
			//border: false,
			autoHeight: true,
			//height		: 100,
			items:[
					{	
					xtype:'textfield',
					fieldLabel: 'Codigo',
					name: 'CodigoProdutoEt',
					id: 'CodigoProdutoEt',
					selectOnFocus: true,
					width: 100,
					enableKeyEvents: true,
					listeners: {
								keyup: function(field, key){
									if(key.getKey() == key.ENTER) {
										var Codigo = Ext.getCmp('CodigoProdutoEt').getValue(); 
										dslistaProdEt.load(({params:{'pesquisa':Codigo, 'start':0, 'limit':200}}));
										}
									if(key.getKey() == 40) {
										grid_listaProdEt.getSelectionModel().selectFirstRow();
										grid_listaProdEt.getView().focusEl.focus();
									}
								}
								}
					},
					{
					xtype:'textfield',
					fieldLabel: 'Descripcion',
					name: 'DescricaoProdutoEt',
					id: 'DescricaoProdutoEt',
					width: 200,
					col:true,
					enableKeyEvents: true,
					listeners: {
						keyup: function(field, key){
							if(key.getKey() == key.ENTER) {
							var Descricao = Ext.getCmp('DescricaoProdutoEt').getValue(); 
							dslistaProdEt.load(({params:{'pesquisa':Descricao, 'campo': 2, 'start':0, 'limit':200}}));
							}
						}
					}
					},
					grid_listaProdEt,
					secondGridEt
				]		
        });



Ext.getCmp('tabss').add(FormlistaProdsEt);
Ext.getCmp('tabss').setActiveTab(FormlistaProdsEt);
FormlistaProdsEt.doLayout();
}