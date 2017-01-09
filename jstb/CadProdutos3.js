// JavaScript Document

  Ext.BLANK_IMAGE_URL = '../ext2.2./resources/images/default/s.gif';
  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  Ext.QuickTips.init();


//var NovoProdWindowa = Ext.Window;

CadProd = function(){

if(perm.CadProdutos.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}

var resposta;

    function azul(val){
        if(val >= 0){
            return '<span style="color:blue;font-weight: bold;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;font-weight: bold">' + val + '</span>';
        }
        return val;
    };
	
	function change(val){
        if(val > 0){
            return '<span style="color:blue;font-weight: bold;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;font-weight: bold">' + val + '</span>';
        }
        return val;
    };

// EXIBIR IMAGENS NA GRID ///////////////
function getImg(val, cell){
	//alert(val)
   return  "<img width='16' height='11' src='"+val+"' border='0'>";
}

 function renderThumbnailCell(value, p, record, rowIndex){
p.attr = 'ext:qtip="some tooltip" ext:qtitle="Tooltip Title!"';
     return value;
}

var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Por favor selecione um Iten');
}

/////////////// Editar //////////////////////////////
var editarProd = function(){
 selectedKeys = grid_listaProds.selModel.selections.keys;
  
if(selectedKeys.length > 0){	
 selectedRows = grid_listaProds.selModel.selections.items;
 selectedKeys = grid_listaProds.selModel.selections.keys; 

record = grid_listaProds.getSelectionModel().getSelected();
var colName = grid_listaProds.getColumnModel().getDataIndex(0); // Get field name
var situacao = record.get(colName);

idprod = selectedKeys

ListaProd.load(({params:{user: id_usuario, acao: 'ListaItens', idProduto: idprod }}));

NovoProdWindowa.show();
Ext.getCmp('cadastrar').setVisible(false);
			
				
}
else
{
selecione();
}
}
/////////////////////////////////////////////////////////////////////////

//////////////// EXCLUIR PRODUTO //////////////////////
var excluirProd = function(){
selectedKeys = grid_listaProds.selModel.selections.keys;
						if(selectedKeys.length > 0){	
 						selectedRows = grid_listaProds.selModel.selections.items;
 						selectedKeys = grid_listaProds.selModel.selections.keys; 
						Ext.Ajax.request({
           				   		url: '../php/cadastra_produto.php', 
           					 	params : {
									acao: 'excluirProd',
               						idProd: selectedKeys
            						},
									callback: function (options, success, response) {
										if (success) { 
											//Ext.MessageBox.alert('Aviso', response.responseText);   
											var json = Ext.util.JSON.decode(response.responseText);
											if(json.response == 'ProdutoExcluido'){
												dslistaProds.reload();
												Ext.MessageBox.alert('Aviso', 'Produto Excluido com Sucesso');
											}
											if(json.response == 'LancamentoExistente'){
												Ext.MessageBox.alert('Impossivel', 'Ha Pedidos Com Esse Iten');
											}
										}
										}
									
										});
								
						}
						else{
							selecione();
							}
}
//////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////
storeSearchProd = new Ext.data.SimpleStore({
        fields: ['sitCodigo','sitDescricao'],
        data: [
            ['Codigo', 'Codigo'],
            ['Descricao', 'Descricao'],
			['cod_original', 'Codigo Original'],
			['cod_original2', 'Codigo Original 2'],
			['Codigo_Fabricante', 'Codigo Fabricante'],
			['Codigo_Fabricante2', 'Codigo Fabricante 2'],
			['Codigo_Fabricante3', 'Codigo Fabricante 3']
        ]
    });

var dslistaProds = new Ext.data.Store({
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
				   {name: 'id'},
				   {name: 'Codigo'},
		           {name: 'Descricao'},
		           {name: 'Estoque'},
		           {name: 'qtd_bloq'},
		           {name: 'valorA'},
				   {name: 'valorB'},
				   {name: 'valorC'},
				   {name: 'grupo'},
				   {name: 'marca'},
				   {name: 'custo'}
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		remoteSort: true		
	});


var ListaProd = new Ext.data.Store({
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
				   {name: 'id'},
				   {name: 'Codigo'},
		           {name: 'Descricao'},
		           {name: 'Estoque'},
		           {name: 'qtd_bloq'},
		           {name: 'vla', mapping: 'valorA'},
				   {name: 'vlb', mapping: 'valorB'},
				   {name: 'vlc', mapping: 'valorC'},
				   {name: 'pr_min', mapping: 'pr_min'},
				   {name: 'Descricaoes', mapping: 'Descricaoes'},
				   {name: 'Codigo_Fabricante', mapping: 'Codigo_Fabricante'},
				   {name: 'Codigo_Fabricante2', mapping: 'Codigo_Fabricante2'},
				   {name: 'Codigo_Fabricante3', mapping: 'Codigo_Fabricante3'},
				   {name: 'cod_original', mapping: 'cod_original'},
				   {name: 'cod_original2', mapping: 'cod_original2'},
				   {name: 'marca', mapping: 'nom_marca'},
				   {name: 'grupo', mapping: 'nom_grupo'},
				   {name: 'margen_a', mapping: 'margen_a'},
				   {name: 'margen_b', mapping: 'margen_b'},
				   {name: 'margen_c', mapping: 'margen_c'},
				   {name: 'custo', mapping: 'custo'},
				   {name: 'qtd_min', mapping: 'qtd_min'},
				   {name: 'embalagem', mapping: 'embalagem'},
				   {name: 'local', mapping: 'local'},
				   {name: 'iva', mapping: 'iva'},
				   {name: 'obsprod', mapping: 'obs'},
				   {name: 'marcaid'},
				   {name: 'grupoid'}
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		remoteSort: true		
	});


//////// FIM STORE DOS PRODUTOS //////////////
//////// INICIO DA GRID DOS PRODUTOS ////////
 var grid_listaProds = new Ext.grid.EditorGridPanel(
	    {
	        store: dslistaProds, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header:'Codigo', width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descricao", width: 185, sortable: true, dataIndex: 'Descricao'},
						{header: "Disp", width: 45, align: 'right', sortable: true, dataIndex: 'Estoque', renderer: change},
						{header: "Bloqueados", width: 55,  align: 'right',  sortable: true, dataIndex: 'qtd_bloq'},
						{header: "Valor A", width: 80, align: 'right', sortable: true, dataIndex: 'valorA',renderer: 'usMoney'},
						{header: "Valor B", width: 80, align: 'right', sortable: true, dataIndex: 'valorB',renderer: 'usMoney'},	        
						{header: "Valor C", width: 80, align: 'right', sortable: true, dataIndex: 'valorC',renderer: 'usMoney'},
						{header: "Grupo", width: 80, hidden: true, align: 'right', sortable: true, dataIndex: 'grupo'},
						{header: "Marca", width: 80, hidden: true, align: 'right', sortable: true, dataIndex: 'marca'},
						{header: "Custo", width: 80,hidden: true, align: 'right', sortable: true, dataIndex: 'custo', renderer: 'usMoney'}	 
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true,
				autoExpandColumn: true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
			stripeRows : true,
			//autoSize : true,
			height: 300,
			ds: dslistaProds,
			selModel: new Ext.grid.RowSelectionModel(),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dslistaProds,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Nao tem dados",
				pageSize: 50,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina", 
				items:[{
                    xtype:'button',
					text: 'Imprimir',
					style: 'margin-left:7px',
					iconCls: 'icon-pdf',
					handler: function(){
						basic_printGrid();
					}
					}],
				refreshText : "Atualizar",
				paramNames : {start: 'start', limit: 'limit'}
			}),
			tbar: [
			   {
				text: 'Novo',
				iconCls:'icon-add',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
						NovoProdWindowa.show();
						NewProd.getForm().reset();
						Ext.getCmp('salvar').setVisible(false);
						Ext.getCmp('cadastrar').setVisible(true);
												
					} 
					},
				{
				text: 'Editar',
				iconCls:'icon-edit',
				tooltip: 'Clique para alterar um registro',
				handler: function(){
					   editarProd();
												
					} 
					},
				{
				text: 'Excluir',
				iconCls:'icon-delete',
				tooltip: 'Clique para excluir um registro',
				handler: function(){
					   excluirProd();
												
					} 
					},
					{
						bodyStyle:'padding:0px 35px 0'
					},
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
				id: 'sitCodigo',
				minChars: 2,
				name: 'sitCodigo',
                emptyText: 'Codigo',
				width: 120,
				forceSelection: true,
				store: [
                         ['Codigo', 'Codigo'],
                         ['Descricao', 'Descricao'],
			             ['cod_original', 'Codigo Original'],
			             ['cod_original2', 'Codigo Original 2'],
			             ['Codigo_Fabricante', 'Codigo Fabricante'],
                         ['Codigo_Fabricante2', 'Codigo Fabricante 2'],
		               	 ['Codigo_Fabricante3', 'Codigo Fabricante 3']
                         ]
                },
					{
						bodyStyle:'padding:0px 15px 0'
					},
					{
					xtype: 'textfield',
	                fieldLabel: 'Pesquisa',
	                name: 'queryProdutoSearch',
					id: 'queryProdutoSearch',
					autoWidth: true,
	                allowBlank:true,
					emptyText : 'Pesquise aqui',
					enableKeyEvents: true,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == 40) {//precionar enter //seta pra baixo  
							   grid_listaProds.getSelectionModel().selectFirstRow();
							   grid_listaProds.getView().focusEl.focus();
                            }
							
							if(e.getKey() == e.ENTER){ 
							var theQuery=Ext.getCmp('queryProdutoSearch').getValue();
							dslistaProds.load({	params:{pesquisa: theQuery,	campo: Ext.getCmp('sitCodigo').getValue()}});	
						}				
					}
	            }
			],
			listeners:{ 
        	afteredit:function(e){
			dslistaProds.load(({params:{pesquisa: e.value, campo: e.column,  'start':0, 'limit':50}}));
	  		},
			afterrender: function(e){
   			grid_listaProds.focus();
   			//grid_listaProds.getSelectionModel().selectFirstCell();
			
			},
			destroy: function() {
							 setTimeout(function(){
							 if(NovoProdWindowa instanceof Ext.Window)
                             NovoProdWindowa.destroy();
							 }, 250);
							 //sul.remove('grid_pedidos');
         				}
			}
		
});

dslistaProds.load(({params:{'Codigo':'%', 'start':0, 'limit':50}}));

ListaProd.on('load', function(){
	NewProd.getForm().loadRecord(ListaProd.getAt(0));	
	Ext.getCmp('salvar').setVisible(true);  
	Ext.getCmp('Estoque').setDisabled(true);
    	
    });

grid_listaProds.on('rowdblclick', function(grid, row, e, col) {
idprod = dslistaProds.getAt(row).data.id;

ListaProd.load(({params:{user: id_usuario, acao: 'ListaItens', idProduto: idprod }}));

NovoProdWindowa.show();
Ext.getCmp('cadastrar').setVisible(false);

}); 


/////////////////INICIO DO FORM //////////////////////////////
		var listaProdsP = new Ext.FormPanel({
			labelAlign: 'top',
			id: 'listaProdsP',
			title: 'Cadastro Produtos',
			closable	:true,
			layout		: 'form',
			frame		: true,
			border      : false,
            split       : true,
            autoWidth   : true,
			//height	    : 55,
            collapsible : false,
			items:[{
            layout:'column',
            items:[
				   {
                columnWidth:.2,
				border: false,
                layout: 'form',
                items: [{
                    xtype:'combo',
					hideTrigger: false,
					emptyText: 'Selecione',
					allowBlank: true,
					editable: true,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idmarca','marca'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
					fieldLabel: 'Marca',
					id: 'marcaProd',
					minChars: 2,
					name: 'marcaProd',
					anchor:'90%',
					forceSelection: false,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_marca.php?acao=1',
					root: 'resultados',
					fields: [ 'idmarca', 'marca' ]
					}),
						hiddenName: 'idmarca',
						valueField: 'idmarca',
						displayField: 'marca',
						fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('grupo').focus();
                            }}

                }]
      
	  
				   },
				{
                columnWidth:.2,
				border: false,
                layout: 'form',
                items: [{
                    xtype:'combo',
					emptyText: 'Selecione',
					hideTrigger: false,
					allowBlank: true,
					editable: true,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['id','grupo'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
                    fieldLabel: 'Grupo	',
					id: 'grupoProd',
					minChars: 2,
                    name: 'grupoProd',
                    resizable: true,
                    listWidth: 250,
                    anchor:'90%',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_grupo.php?acao=1',
					root: 'resultados',
					fields: [ 'idgrupo', 'grupo' ]
			}),
						hiddenName: 'idgrupo',
						valueField: 'idgrupo',
						displayField: 'grupo',
						fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('margen_a').focus();
                            }}


							
                }]
      
	  
				   },
				   
				  
				{
                columnWidth:.2,
				style: 'margin-top:19px',
                layout: 'form',
				border: false,
                items: [
						{
						xtype:'button',
						text: 'Pesquisar',
						iconCls	    : 'icon-search',
						handler: function(){
											pgrupo = Ext.get('idgrupo').getValue(),
											pmarca = Ext.get('idmarca').getValue(),
											dslistaProds.load(({params:{ grupo: pgrupo, marca: pmarca, 'start':0, 'limit':50}}));
											Ext.getCmp('marcaProd').clearValue();
											Ext.getCmp('grupoProd').clearValue();
  			 								}
        				}
						]
			 	}
				   ]
					},
					grid_listaProds
					],
			listeners:{
				destroy: function(){
				tabs.remove('listaProdsP');
				}
			}
        }); 


		
///////////////// FIM DO FORM ///////////////////////////////////////////////////

////////////////// NOVO PRODUTO ////////////////////////////////////////////////////




    var NewProd = new Ext.FormPanel({
        labelAlign: 'top',
		 fileUpload: true,
		layout: 'form',
        frame:true,
        //bodyStyle:'padding:5px 5px 0',
		//autoHeight: true,
	    autoWidth: true,
		autoScroll:true,
        items: [{
            layout:'column',
            items:[{
                columnWidth:.3,
                layout: 'form',
				//height: 455,
				
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Codigo',
					iconCls:'icon-grid',
                    name: 'Codigo',
					id: 'Codigo',
                    anchor:'70%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('Descricao').focus() ; 
                            }}

                }, 
					
					{
                    xtype:'textfield',
                    fieldLabel: 'Codigo Original',
					id: 'cod_original',
                    name: 'cod_original',
                    anchor:'70%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('grupo').focus() ; 
                            }}
                },
					
				
                    new Ext.ux.MaskedTextField({
                    fieldLabel: '% Margem A',
					id: 'margen_a',
                    name: 'margen_a',
					mask:'percent',
					textReverse : true,
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('margen_b').focus() ; 
                            }}

                }),
				
					new Ext.ux.MaskedTextField({
                    fieldLabel: 'Valor A',
					id: 'vla',
                    name: 'vla',
					mask:'guarani',
					textReverse : true,
					renderer: 'usMoney',
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('vlb').focus(); 
                            }}
							
                }),
					{
                    xtype:'textfield',
                    fieldLabel: 'Estoque',
					id: 'Estoque',
                    name: 'Estoque',
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('qtd_min').focus(); 
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Embalagem',
					id: 'embalagem',
                    name: 'embalagem',
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('local').focus(); 
                            }}
				},
			/*	{
            	xtype:'textfield',
            	id:'obsprod',
				name: 'obsprod',
            	fieldLabel:'Observacao',
            	anchor:'100%',
				listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('foto').focus(); 

						}}
					}
        		}, */
				{
				xtype: 'fileuploadfield',
         		emptyText: 'Selecione uma imagem...',
         		fieldLabel: 'Imagem',
         		name: 'foto',
				id:'foto',
				permitted_extensions: ['jpg', 'jpeg', 'gif', 'png'],
				buttonCfg: { text: '', iconCls: 'upload-icon' },
         		anchor:'100%'
      			}
					
					]
            },
			//#################Segunda Coluna ####################################
				{
                columnWidth:.3,
                layout: 'form',
                items: [
				    {
                    xtype:'textfield',
                    fieldLabel: 'Descricao',
					id: 'Descricao',
                    name: 'Descricao',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('custo').focus() ; 
                            }}
                },
				
					{
                    xtype:'combo',
					hideTrigger: false,
					allowBlank: false,
					editable: true,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idgrupo','grupo'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
                    fieldLabel: 'Grupo	',
					id: 'grupo',
					minChars: 2,
                    name: 'grupo',
                    anchor:'60%',
                    resizable: true,
                    listWidth: 250,
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_grupo.php?acao=1',
					root: 'resultados',
					autoLoad: true,
					fields: [ {name:'grupoid', mapping: 'idgrupo'}, {name:'grupo'} ]
			}),
						hiddenName: 'grupoid',
						valueField: 'grupoid',
						displayField: 'grupo'
                },
                    new Ext.ux.MaskedTextField({
                    fieldLabel: '% Margem B',
					id: 'margen_b',
                    name: 'margen_b',
					mask:'percent',
					textReverse : true,
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('margen_c').focus() ; 
                            }}
                }),
				
                    new Ext.ux.MaskedTextField({
                    fieldLabel: 'Valor B',
					id: 'vlb',
                    name: 'vlb',
					mask:'guarani',
					textReverse : true,
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('vlc').focus() ; 
                            }}
                }),
				{
                    xtype:'textfield',
                    fieldLabel: 'Qtd. Min',
					id: 'qtd_min',
                    name: 'qtd_min',
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('pr_min').focus(); 
                            }}
                },
				{
                    xtype:'textfield',
                    fieldLabel: 'Locacao',
					id: 'local',
                    name: 'local',
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('iva').focus(); 
                            }}
                }
				
				
				]
            },
			//#################Terceira Coluna #################################### 
			 {
		       columnWidth:.3,
                layout: 'form',
                items: [
				    
				
				//	{
				//	style: 'margin-top:30px',
				//	float:'left'
				//	 },
					 new Ext.ux.MaskedTextField({
                    fieldLabel: 'Custo',
					id: 'custo',
					mask:'guarani',
					textReverse : true,
                    name: 'custo',
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							    Ext.getCmp('cod_original').focus()  ; 
                            }}
					
					
                }),
				
				{
                    xtype:'combo',
					hideTrigger: false,
					allowBlank: false,
					editable: true,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idmarca','marca'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
					fieldLabel: 'Marca',
					id: 'marca',
					minChars: 2,
					name: 'marca',
					anchor:'60%',
                    resizable: true,
                   // listWidth: 250,
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_marca.php?acao=1',
					root: 'resultados',
					autoLoad: true,
					fields: [ {name:'marcaid', mapping:'idmarca'}, {name:'marca'} ]
					}),
						hiddenName: 'marcaid',
						valueField: 'marcaid',
						displayField: 'marca'
						
							
                },
					
					new Ext.ux.MaskedTextField({
                    fieldLabel: '% Margem C',
					id: 'margen_c',
					mask:'percent',
					textReverse : true,
                    name: 'margen_c',
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('vla').focus() ; 
                            }}
					
					
                }),
					
					new Ext.ux.MaskedTextField({
                    fieldLabel: 'Valor C',
					id: 'vlc',
                    name: 'vlc',
					mask:'guarani',
					textReverse : true,
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('Estoque').focus() ; 
                            }}
					
					
                }),
				
                    new Ext.ux.MaskedTextField({
                    fieldLabel: 'Precio Minimo',
					id: 'pr_min',
                    name: 'pr_min',
					mask:'guarani',
					textReverse : true,
                    anchor:'60%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('embalagem').focus() ; 
                            }}
					
					
                }),
				{
                    xtype:'textfield',
                    fieldLabel: '% Imposto',
					id: 'iva',
                    name: 'iva',
                    anchor:'60%',
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('foto').focus() ; 

						}}
					}
                }
				]
				}
			]
        }
			]
    });
    	
	function basic_printGrid(){
		global_printer = new Ext.grid.XPrinter({
			grid:grid_listaProds,  // grid object 
			pathPrinter:'../php/printer',  	 // relative to where the Printer folder resides  
			logoURL: 'ext_logo.jpg', // relative to the html files where it goes the base printing  
			pdfEnable: true,  // enables link PDF printing (only save as) 
			hasrowAction:false, 
			localeData:{
				Title:'CP SA',	
				subTitle:'By NetCommerce',	
				footerText:'CP SA', 
				pageNo:'Pagina # ',	//page label
				printText:'Imprimir',  //print document action label 
				closeText:'Fechar',  //close window action label 
				pdfText:'PDF'},
			useCustom:{  // in this case you leave null values as we dont use a custom store and TPL
				custom:false,
				customStore:null, 
				columns:[], 
				alignCols:[],
				pageToolbar:null, 
				useIt: false, 
				showIt: false, 
				location: 'bbar'
			},
			showdate:true,// show print date 
			showdateFormat:'d-m-Y H:i:s', // 
			showFooter:true,  // if the footer is shown on the pinting html 
			styles:'default' // wich style youre gonna use 
		}); 
		global_printer.prepare(); // prepare the document 
}

				NovoProdWindowa = new Ext.Window({
					id:'NovoProdWindowa'
					, title: "Novo Produto"
					, resizable: false
	                , layout: 'form'
	                , width: 650
				    , autoScroll:false
	                , closeAction :'hide'
					, closable : false
					, constrain: true
					//, height: 550
                    , autoHeight: true
	                , plain: true
					, modal: false
					, items: [NewProd]
					,focus: function(){
 	   					 Ext.get('Codigo').focus();
						},
					buttons: [{
								id: 'cadastrar',
								text: 'Cadastrar',
								iconCls: 'save',
								handler: function(){
								NewProd.getForm().submit({
										url: "php/cadastra_produto.php",
										params: {
												user: id_usuario,
												acao: 'Cadastra'
										}
										, waitMsg: 'Cadastrando'
										, waitTitle : 'Aguarde....'
										, scope: this
										, success: OnSuccess
										, failure: OnFailure
									}); 
								function OnSuccess(form,action){
										alert(action.result.msg);
									}
								function OnFailure(form,action){
										alert(action.result.msg);
									}
								}
        				},
					{
					id: 'salvar',
					text: 'Salvar',
					iconCls: 'save',
					handler: function(){
							NewProd.getForm().submit({
								url: "php/cadastra_produto.php",
									params: {
										user: id_usuario,
										acao: 'Update',
										idProd: idprod
										}
									, waitMsg: 'Salvando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
								}); 
							function OnSuccess(form,action){
								alert(action.result.msg);
								dslistaProds.reload();
							}
							function OnFailure(form,action){
								alert(action.result.msg);
							}
						}
					},
					{
					text: 'Fechar',
					handler: function(){ 
					NovoProdWindowa.hide();
					NewProd.getForm().reset();
					 }

        			}]
				});

	NovoProdWindowa.on('hide', function(){
			NewProd.getForm().reset();
		});
	
/////////////////////FIM NOVO PRODUTO /////////////////////////////////////

/////////////////// INICIO DA WINDOW PRINCIPAL

Ext.getCmp('tabss').add(listaProdsP);
Ext.getCmp('tabss').setActiveTab(listaProdsP);
listaProdsP.doLayout();	

/*
       Ext.getCmp('vla').on('keydown',calculaValorParcela);
//     field_parcelas.on('blur',calculaValorParcela);
 //    field_vlrmes.on('focus',calculaValorParcela);
*/

}