  Ext.BLANK_IMAGE_URL = 'ext-3.2.1/resources/images/default/s.gif';
  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  Ext.QuickTips.init();
  
   Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
  
  Ext.QuickTips.init();
  Ext.form.Field.prototype.msgTarget = 'side';
  
  	EntProdCompra = function(){
  
		  Ext.override(Ext.grid.EditorGridPanel, {
			initComponent: Ext.grid.EditorGridPanel.prototype.initComponent.createSequence(function(){
			this.addEvents("editcomplete");
			}),
			onEditComplete: Ext.grid.EditorGridPanel.prototype.onEditComplete.createSequence(function(ed, value, startValue){
			this.fireEvent("editcomplete", ed, value, startValue);
			})
			});

	function change(val){
        if(val > 0){
            return '<span style="color:blue;font-weight: bold;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;font-weight: bold">' + val + '</span>';
        }
        return val;
    };


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
	  secondGridStore.remove(record);
	  Ext.getCmp("CodigoProduto").focus();
	 
   }
});

	
var xg = Ext.grid;
var expander;
var grid_listaProd;



////////////////////////// INICIO GRID PRINCIPAL DOS PRODUTOS ////////////////////////////////////////////////////////////////	
	
	
	var dslistaProd = new Ext.data.Store({
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
//////// FIM STORE DOS PRODUTOS //////////////
//////// INICIO DA GRID DOS PRODUTOS ////////
 var grid_listaProd = new Ext.grid.GridPanel({
	        store: dslistaProd, // use the datasource
	        columns:[
						{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header: "Cod Original", width: 80, align: 'left', sortable: true, dataIndex: 'Codigo_Fabricante'},
						{header:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descricao", width: 250, sortable: true, dataIndex: 'Descricao'},
						{header: "RF", width: 55, sortable: true, dataIndex: 'ref'},
						{header: "Peso", width: 55, sortable: true, dataIndex: 'peso'},
						{header: "Disponivel", width: 55, align: 'right', sortable: true, dataIndex: 'Estoque', renderer: change},
						{header: "Bloqueados", width: 55,  align: 'right',  sortable: true, dataIndex: 'qtd_bloq'},
						{header: "Valor A", width: 80, align: 'right', sortable: true, dataIndex: 'valorA',renderer: 'usMoney'},
						{header: "Custo", width: 80, align: 'right', sortable: true, dataIndex: 'custo',renderer: 'usMoney'}        
						
			 ],
	        viewConfig:{
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado'
				
	        },
			width:'100%',
			//id:'grid_listaProd',
			height: 250,
			autoExpandColumn : 'id',
			loadMask: true,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dslistaProd,
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
				text: 'Gravar',
				iconCls:'icon-save',
				tooltip: 'Clique para lancar um registro(s) selecionado',
				handler: function(){
					jsonData = "[";
						
						for(d=0;d<secondGridStore.getCount();d++) {
							record = secondGridStore.getAt(d);
							if(record.data.newRecord || record.dirty) {
								jsonData += Ext.util.JSON.encode(record.data) + ",";
							}
						}
						
						jsonData = jsonData.substring(0,jsonData.length-1) + "]";
						//alert(jsonData);
							Ext.Ajax.request(
							{
								waitMsg: 'Enviando Cotacão, por favor espere...',
								url:'php/EntProd.php',
								params:{
								data:jsonData,
								idcompra: compra,
								acao: "Entrada"
								},
								callback: function (options, success, response) {
										if (success) { 
											Ext.MessageBox.alert('OK', response.responseText);
											var json = Ext.util.JSON.decode(response.responseText);
												if(json.del_count == 1){
													mens = "1 Iten Inserido.";
												} else {
													mens = json.del_count + " Itens Inseridos.";
												}
												Ext.MessageBox.alert('Alerta', mens);
											} else{
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
					} }
				]
				
			}),
			listeners:{ 
			
			}
		
});	

	secondGridStore = new Ext.data.GroupingStore({
			 proxy: new Ext.data.HttpProxy({
                url: 'php/lista_prod.php',
                method: 'POST'
				}),
				groupField:'grupo',
				sortInfo:{field: 'id', direction: "DESC"},
				nocache: true,

 reader:  new Ext.data.JsonReader({
				totalProperty: 'totalProdutos',
				root: 'Produtos',
				id: 'id',
				fields: [
						 {name: 'action1', type: 'string'},
						 {name: 'id', mapping: 'id', type: 'string' },
						 {name: 'grupo', mapping: 'grupo', type: 'string' },
						 {name: 'compra', mapping: 'compra', type: 'string' },
						 {name: 'Codigo',  mapping: 'Codigo' },
						 {name: 'Descricao',  type: 'string' },
						 {name: 'custo' },
						 {name: 'Estoque' },
						 {name: 'totals'},
						 {name: 'totalProds'}
						 ]
			})					    
		});
 
   Ext.grid.GroupSummary.Calculations['totalProds'] = function(v, record, field){
		//Barrafinal.getBottomToolbar().items.items[3].el.innerHTML = nome_user; vpp
		qtd = record.data.Estoque;
		vl = (record.data.custo);
		vl = vl.replace(".","");
		vl = vl.replace(",",".");
		var v = v+ (parseFloat(qtd) * parseFloat(vl));   //toNum
		return v;
    }

var summary = new Ext.grid.GroupSummary(); 		

var secondGrid = new Ext.grid.EditorGridPanel({
   store: secondGridStore,
   enableColLock: true,
   containerScroll  : false,
   loadMask: {msg: 'Carregando...'},
     columns: [
	   action,
	  {id: 'id', header: 'id', hidden: true, width: 10, dataIndex: 'id'},
	  {id: 'grupo', header: 'grupo', hidden: true, width: 10, dataIndex: 'grupo'},
	  {id: 'compra', header: 'compra', hidden: true, width: 10, dataIndex: 'compra'},	  
	  {id: 'Codigo', header: 'Codigo', summaryType: 'count', width: 60, dataIndex: 'Codigo' },
      {id: 'Descricao',  header: 'Descripcion', width: 250, dataIndex: 'Descricao'},
      {id: 'Estoque', header: "Qtd", dataIndex: 'Estoque',  width: 50, align: 'right', //renderer: "usMoney",
	  editor: new Ext.form.NumberField({
								allowBlank: false,
								selectOnFocus:true,
								allowNegative: true
								})
								},
	  {id: 'custo', header: "Valor", dataIndex: 'custo', width: 50, align: 'right',   
	 editor: new Ext.ux.MaskedTextField({
									readOnly: false,
									mask:'decimal',
									textReverse : true,
									selectOnFocus:true
								})
	 			},
	  			{	
                id: 'totals',
                header: "Total",
                width: 100,
				align: 'right',
                sortable: false,
				fixed:true,
                groupable: false,
                renderer: function(v, params, record){
				vl = (record.data.custo);
				vl = vl.replace(".","");
				vl = vl.replace(",",".");
                return Ext.util.Format.usMoney(parseFloat(vl) * parseFloat(record.data.Estoque));
                },
				id:'totalProds',
                dataIndex: 'totalProds',
                summaryType:'totalProds',
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
   width:'100%',
   height:243,
   border: true,
   moveEditorOnEnter: true,
   plugins: [summary,action],
   loadMask: true,
   clicksToEdit:1,
   listeners:{
	  editcomplete:function(ed,value){
	  if(ed.col == 6 ){				
	  secondGrid.startEditing(ed.row,ed.col+1);
	  }
	  if(ed.col == 7 ){
		setTimeout(function(){
		Ext.getCmp("CodigoProduto").focus();
		}, 250);
		}
	  }
   		}
}); 

	grid_listaProd.addListener('keydown',function(event){
		   getItemRow(this, event);
		});
		
		function getItemRow(grid,  event){
		   key = getKey(event);
		//console.info(event);
		var idData = prodId; 
		
		if(key==13){		
		var Record = Ext.data.Record.create(['id','Codigo','Descricao','Estoque','custo','total']);
		var dados = new Record({"id":record.data.id,
								"compra":"compra",
								"Codigo":record.data.Codigo, 
								"Descricao":record.data.Descricao,
								"Estoque":"1",
								"custo":record.data.custo,
								"total":record.data.custo,
								"grupo":"1",
								"totalProds":""});
		
		//secondGrid.startEditing(0,3);
		record = grid_listaProd.getSelectionModel().getSelected();
		//console.info(dados);
		secondGridStore.insert(0,dados);
		secondGrid.startEditing(0,6);

			}
		if(key >47 && key < 58 || key >64 && key < 91 || key >95 && key < 106 ){
 	   					Ext.get('CodigoProduto').focus(); 
			}
		
		}
		
	AcertoTemplate = [
	'</br>'
	,'<b>Compra: &nbsp;</b>'+compra+'<br/>'
	,'<b>Proveedor: &nbsp;</b>'+nomeprov+'<br/>'
	,'<b>Valor: &nbsp;</b>'+vlcompra+'<br/>'
	,'</br>'
	,'<b>Responsavel: &nbsp;</b>'+nome_user+'<br/>'
	];
	AcertoTpl = new Ext.Template(AcertoTemplate);
	
	var formtpl = new Ext.Panel({
       // bodyStyle:'background-color:#4e79b2',
		items:[AcertoTpl]
	})

			////////////////////////////////////////  FIM GRID DRAG //////////////////////////////////////////////
		var FormlistaProd = new Ext.Panel({
            title       : 'Itens de la Compra',
		//	renderTo: 'formDrag',
            split       : true,
			autoHeight		: true,
            collapsible : true,
			collapsed   : false,
			layout: 'form',
			labelWidth: 45,
			items:[
			{
								layout:'column',
								border: false,
								items:[{
									columnWidth:.7,
									layout: 'form',
									border: false,
									items:[secondGrid]		
									},
									{
									columnWidth:.2,
									layout: 'form',
									border: false,
									items:[formtpl]		
									}]
									}]
        }); 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		grid_listaProd.getSelectionModel().on('rowselect', function(sm, rowIndex, colIndex) {
		record = grid_listaProd.getStore().getAt( rowIndex );
		prodId = record.id;
		}, this);
		
		/////////////////INICIO DO FORM  NORTH //////////////////////////////
		var FormlistaProdsP = new Ext.form.FormPanel({
			labelAlign: 'top',
			id: 'FormlistaProdsP',
			title: 'Entrada de Productos',
            closable:true,
			frame: true,
			//border: false,
			autoHeight: true,
			//height		: 100,
			items:[
					{	
					xtype:'textfield',
					fieldLabel: 'Codigo',
					name: 'CodigoProduto',
					id: 'CodigoProduto',
					selectOnFocus: true,
					width: 100,
					enableKeyEvents: true,
					listeners: {
								keyup: function(field, key){
									if(key.getKey() == key.ENTER) {
										var Codigo = Ext.getCmp('CodigoProduto').getValue(); 
										dslistaProd.load(({params:{'pesquisa':Codigo, 'start':0, 'limit':200}}));
										}
									if(key.getKey() == 40) {
										grid_listaProd.getSelectionModel().selectFirstRow();
										grid_listaProd.getView().focusEl.focus();
									}
								}
								}
					},
					{
					xtype:'textfield',
					fieldLabel: 'Descripcion',
					name: 'DescricaoProduto',
					id: 'DescricaoProduto',
					width: 200,
					col:true,
					enableKeyEvents: true,
					listeners: {
						keyup: function(field, key){
							if(key.getKey() == key.ENTER) {
							var Descricao = Ext.getCmp('DescricaoProduto').getValue(); 
							dslistaProd.load(({params:{'pesquisa':Descricao, 'campo': 2, 'start':0, 'limit':200}}));
							}
						}
					}
					},
					grid_listaProd,
					FormlistaProd
				]		
        }); 
/////////////////////////// FIM DO FORM NORTH //////////////////////////////////////////////////////////////////////

	

		dslistaProd.load(({params:{'Codigo':12, 'start':0, 'limit':200}}));

Ext.getCmp('tabss').add(FormlistaProdsP);
Ext.getCmp('tabss').setActiveTab(FormlistaProdsP);
FormlistaProdsP.doLayout();
}