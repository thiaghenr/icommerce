// JavaScript Document

Ext.onReady(function(){   
  Ext.BLANK_IMAGE_URL = '../ext2.2./resources/images/default/s.gif';
  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  Ext.QuickTips.init();


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





var  lista_prod= Ext.get('lista_prod');
lista_prod.on('click', function(e){
	
	
var prodId;
var xg = Ext.grid;
var expander;
var FormContato;
var win_novocontato;




/// STORE ITENS VENDIDOS ///////////////////////////////////////////////////

var dsItensProdP = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_itens_prod.php',
			method: 'POST'
		}),   
//		baseParams:{acao: "listarContatos"},
		reader:  new Ext.data.JsonReader({
			root: 'Itens',
			totalProperty: 'totalItens',
			id: 'id'
		},
			[
				   {name: 'idp', mapping: 'idp'},
				   {name: 'controle_clip', mapping: 'controle_clip'},
		           {name: 'nome_clip', mapping: 'nome_clip'},
		           {name: 'data_carp', mapping: 'data_carp'},
		           {name: 'total_notap', mapping: 'total_notap'}
				
			]
		),
		sortInfo: {field: 'id', direction: 'DESC'},
		//id: 9,
		remoteSort: true		
	});
//////// FIM STORE ITENS VENDIDOS //////////////
	//Criando Colunas do Grid
	var cmAA = new Ext.grid.ColumnModel([
		{header: 'Pedido', width: 50, dataIndex: 'idp', align: 'center', sortable: true},
		{header: 'Codigo', width: 56, dataIndex: 'controle_clip', sortable: true},
		{header: 'Nome', width: 150, dataIndex: 'nome_clip', sortable: true},
		{header: 'Data', width: 80, dataIndex: 'data_carp', sortable: true},
		{header: 'Valor', width: 80, dataIndex: 'total_notap', sortable: true}
	]);

	//Criando o Grid e setando Configuracoes
	var gridDetalhesP = new Ext.grid.GridPanel({
		el: 'CA',
		id: 'gridD',
		ds:  dsItensProdP,
		enableColumnResize: false,
		deferRowRender : false,
		width:'100%',
		height:302,
		//collapsed: true,
		collapsible: true,
		animCollapse: true,
		title: 'Pedidos',
		store: dsItensProdP,
		cm: cmAA,
		stripeRows: true,
		bbar: new Ext.PagingToolbar({
			pageSize: 10,
			store: dsItensProdP,
			displayInfo: true,
			displayMsg: 'Exibindo Registro(s) {0} - {1} de {2}',
			emptyMsg: "Nenhum Registro Encontrado"
		})
		
		
		

	});
//////////////////////////////////////////////////////////////////////////////
	
var dsItensProdC = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_itens_prod.php',
			method: 'POST'
		}),   
//		baseParams:{acao: "listarContatos"},
		reader:  new Ext.data.JsonReader({
			root: 'Itens',
			totalProperty: 'totalItens',
			id: 'id'
		},
			[
				   {name: 'id'},
				   {name: 'controle_cli'},
		           {name: 'nome_cli'},
		           {name: 'data_car'},
		           {name: 'total_nota'}
				
			]
		),
		sortInfo: {field: 'id', direction: 'DESC'},
		//id: 9,
		remoteSort: true		
	});
//////// FIM STORE ITENS VENDIDOS //////////////
	//Criando Colunas do Grid
	var cmAB = new Ext.grid.ColumnModel([
		{header: 'Pedido', width: 50, dataIndex: 'id', align: 'center', sortable: true},
		{header: 'Codigo', width: 56, dataIndex: 'controle_cli', sortable: true},
		{header: 'Nome', width: 150, dataIndex: 'nome_cli', sortable: true},
		{header: 'Data', width: 80, dataIndex: 'data_car', sortable: true},
		{header: 'Valor', width: 80, dataIndex: 'total_nota', sortable: true}
	]);

	//Criando o Grid e setando Configuracoes
	var gridDetalhesC = new Ext.grid.GridPanel({
	//	el: 'CA',
		id: 'gridDD',
		ds:  dsItensProdC,
		enableColumnResize: false,
		deferRowRender : false,
		width:'100%',
		height:302,
		//collapsed: true,
		collapsible: true,
		animCollapse: true,
		title: 'Cotacoes',
		store: dsItensProdC,
		cm: cmAB,
		stripeRows: true,
		bbar: new Ext.PagingToolbar({
			pageSize: 10,
			store: dsItensProdC,
			displayInfo: true,
			displayMsg: 'Exibindo Registro(s) {0} - {1} de {2}',
			emptyMsg: "Nenhum Registro Encontrado"
		})
		
		
		

	});
//////////////////////////////////////////////////////////////////////////////

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
				   {name: 'id'},
				   {name: 'Codigo'},
		           {name: 'Descricao'},
		           {name: 'Estoque'},
		           {name: 'qtd_bloq'},
		           {name: 'valorA'},
				   {name: 'valorB'},
				   {name: 'valorC'}
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		//id: 9,
		remoteSort: true		
	});
//////// FIM STORE DOS PRODUTOS //////////////
//////// INICIO DA GRID DOS PRODUTOS ////////
 var grid_listaProd = new Ext.grid.EditorGridPanel(
	    {
	        store: dslistaProd, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descricao", width: 250, sortable: true, dataIndex: 'Descricao'},
						{header: "Disponivel", width: 55, align: 'right', sortable: true, dataIndex: 'Estoque', renderer: change},
						{header: "Bloqueados", width: 55,  align: 'right',  sortable: true, dataIndex: 'qtd_bloq'},
						{header: "Valor A", width: 80, align: 'right', sortable: true, dataIndex: 'valorA',renderer: 'usMoney'},
						{header: "Valor B", width: 80, align: 'right', sortable: true, dataIndex: 'valorB',renderer: 'usMoney'},	        
						{header: "Valor C", width: 80, align: 'right', sortable: true, dataIndex: 'valorC',renderer: 'usMoney'}	 
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			width:'100%',
			id: 'prods',
			height: 250,
			ds: dslistaProd,
			selModel: new Ext.grid.CellSelectionModel(),
			loadMask: true,
			enableColLock: false,
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
				items:[{
                    xtype:'button',
					text: 'Imprimir',
					style: 'margin-left:7px',
					iconCls: 'icon-pdf',
					handler: function(){
						basic_printGrid();
						
						/*	
						Ext.Ajax.request(
							{
								url:'print_produtos.php',
								params:{data: Ext.encode(dslistaProd.reader.jsonData.Produtos)}
						function popup(){
						window.open('../impressao.php?id_pedido='+1 +'','popup','width=750,height=500,scrolling=auto,top=0,left=0')
								}
						popup();
					*/					
					
					}
					}]
				
			}),
			listeners:{ 
        	afteredit:function(e){
			dslistaProd.load(({params:{pesquisa: e.value, campo: e.column,  'start':0, 'limit':100}}));
	  		},
			afterrender: function(e){
			//focus: function(){
   			grid_listaProd.focus();
   			grid_listaProd.getSelectionModel().selectFirstCell();
			
			}//}
			}
		
});
///////////////////// INICIO GRID DOS DETALHES ////////////////////////////////////////
//////// INICIO DA GRID DOS PRODUTOS ////////
var dslistaProdDet = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod_det.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'id'},
				   {name: 'nom_marca'},
		           {name: 'nom_grupo'},
		           {name: 'custo'},
		           {name: 'Codigo_Fabricante'},
		           {name: 'Codigo_Fabricante2'},
				   {name: 'cod_original'},
				   {name: 'cod_original2'}
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		//id: 9,
		remoteSort: true		
	});
 var gridDetProd = new Ext.grid.EditorGridPanel(
	    {
	        store: dslistaProdDet, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header: 'Marca', width: 80, sortable: true, dataIndex: 'nom_marca'},
						{header: "Grupo", width: 80, sortable: true, dataIndex: 'nom_grupo'},
						{header: "custo", width: 55, align: 'right', sortable: true, dataIndex: 'custo', renderer: 'usMoney'},
						{header: "Fabricante", width: 80,  align: 'right',  sortable: true, dataIndex: 'Codigo_Fabricante'},
						{header: "Fabricante2", width: 80, align: 'right', sortable: true, dataIndex: 'Codigo_Fabricante2'},
						{header: "cod_original", width: 80, align: 'right', sortable: true, dataIndex: 'cod_original'},	        
						{header: "cod_original2", width: 80, align: 'right', sortable: true, dataIndex: 'cod_original2'}	 
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			width:'100%',
			id: 'prods',
			height: 45,
			ds: dslistaProdDet,
			selModel: new Ext.grid.CellSelectionModel({singleSelect:false}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true
		
});
 ////////FIM GRID DOS DETALHES ///////////////////////////////////////////////////
 
///////////////////// INICIO GRID DOS DETALHES ////////////////////////////////////////

//////// INICIO DA GRID DOS VENDIDOS ////////
var dslistaProdVend = new Ext.data.Store({
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
 var gridDetProdVend = new Ext.grid.EditorGridPanel(
	    {
	        store: dslistaProdVend, // use the datasource
	        
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
			id: 'prodsVd',
			height: 100,
			ds: dslistaProdVend,
			selModel: new Ext.grid.CellSelectionModel({singleSelect:false}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true
			
		
});
 ////////FIM GRID DOS DETALHES ///////////////////////////////////////////////////
 
//////// INICIO DA GRID DOS DETALHES DE COMPRA ////////
var dslistaProdCmp = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod_cmp.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'id'},
				   {name: 'margen_a'},
		           {name: 'margen_b'},
		           {name: 'margen_c'},
		           {name: 'custo'},
		           {name: 'custo_medio'},
				   {name: 'custo_anterior'},
				   {name: 'custoagr'}
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		//id: 9,
		remoteSort: true		
	});
 var gridDetProdCmp = new Ext.grid.EditorGridPanel(
	    {
	        store: dslistaProdCmp, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header: 'Margen A %', width: 80, sortable: true, dataIndex: 'margen_a', renderer: azul},
						{header: "Margen B %", width: 80, sortable: true, dataIndex: 'margen_b', renderer: azul},
						{header: "Margem C %", width: 55, align: 'right', sortable: true, dataIndex: 'margen_c', renderer: azul},
						{header: "Custo", width: 80,  align: 'right',  sortable: true, dataIndex: 'custo',  renderer: 'usMoney'},
						{header: "Custo Medio", width: 80, align: 'right', sortable: true, dataIndex: 'custo_medio', renderer: 'usMoney'},
						{header: "Custo Anterior", width: 80, align: 'right', sortable: true, dataIndex: 'custo_anterior', renderer: 'usMoney'},	        
						{header: "Custo Agregado", width: 80, align: 'right', sortable: true, dataIndex: 'custoagr', renderer: 'usMoney'}	 
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			width:'100%',
			id: 'prodscmp',
			height: 45,
			ds: dslistaProdCmp,
			selModel: new Ext.grid.CellSelectionModel({singleSelect:false}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true
		
});
 ////////FIM GRID DOS DETALHES DE COMPRA/////////////////////////////////////////////////// 
 
//////// INICIO DA GRID DOS DETALHES DE COMPRA ////////
var dslistaProdCompras = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod_det_cmp.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'idcmp'},
				   {name: 'fornecedor_id'},
		           {name: 'nome'},
		           {name: 'data_lancamento'},
		           {name: 'qtd_produto'},
		           {name: 'prcompra'},
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		//id: 9,
		remoteSort: true		
	});
 var gridDetProdCompras = new Ext.grid.EditorGridPanel(
	    {
	        store: dslistaProdCompras, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "Compra", width: 50, sortable: true, dataIndex: 'idcmp'},
						{header: 'Codigo', width: 80, sortable: true, dataIndex: 'fornecedor_id'},
						{header: "Fornecedor", width: 230, sortable: true, dataIndex: 'nome'},
						{header: "Data", width: 90, align: 'right', sortable: true, dataIndex: 'data_lancamento', renderer: change},
						{header: "Qtd", width: 80,  align: 'right',  sortable: true, dataIndex: 'qtd_produto'},
						{header: "Valor", width: 90, align: 'right', sortable: true, dataIndex: 'prcompra', renderer: 'usMoney'}
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			width:'100%',
			id: 'prodsCp',
			height: 100,
			ds: dslistaProdCompras,
			selModel: new Ext.grid.CellSelectionModel({singleSelect:false}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true
			
		
});

grid_listaProd.getSelectionModel().on('cellselect', function(sm, rowIndex, colIndex) {
       record = grid_listaProd.getStore().getAt( rowIndex );
       prodId = record.id;
       NomeCol = grid_listaProd.getColumnModel().getDataIndex(colIndex); // Get field name	

}, this);

grid_listaProd.addListener('keydown',function(event){
   getItemRow(this, event);
});

function getItemRow(grid, event){
   key = getKey(event);
//console.info(event);
var idData = prodId; 
   if(key==119){
	   
	  gridDetProdCmp.hide();
	  gridDetProdCompras.hide();
	 
	 gridDetProd.show();
     dslistaProdDet.load(({params:{codigo: prodId, campo: e.column}}));
	 
	 gridDetProdVend.show();
	 dslistaProdVend.load(({params:{codigo: prodId, campo: e.column}}));
   }
  else if(key==120){
	 gridDetProd.hide();
	 gridDetProdVend.hide();
	 
	 gridDetProdCmp.show();
	 dslistaProdCmp.load(({params:{codigo: prodId, campo: e.column}}));
	 
	 gridDetProdCompras.show();
	 dslistaProdCompras.load(({params:{codigo: prodId, campo: e.column}}));
   }
  else if(key==13){
	  if(NomeCol == 'Codigo' || NomeCol == 'Descricao'){
	  winPesquisa.show();
	   }
  }
}

dslistaProd.load(({params:{'Codigo':12, 'start':0, 'limit':200}}));


/////////////////INICIO DO FORM //////////////////////////////
		var listaProdsP = new Ext.FormPanel({
			labelAlign: 'top',
            region      : 'north',
			frame		: true,
			border: false,
            split       : true,
            //width       : 100,
			height		: 53,
            collapsible : true,
           // margins     : '3 3 3 0',
			//bodyStyle:'padding:5px 5px 0',
            //cmargins    : '3 3 3 3',
			items:[{
            layout:'column',
            items:[{
                columnWidth:.3,
				border: false,
                layout: 'form',
                items: [{
                    xtype:'combo',
					hideTrigger: false,
					allowBlank: true,
					editable: false,
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
					forceSelection: true,
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
                columnWidth:.3,
				border: false,
                layout: 'form',
                items: [{
                    xtype:'combo',
					hideTrigger: false,
					allowBlank: false,
					editable: false,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['id','grupo'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
                    fieldLabel: 'Grupo	',
					id: 'grupo',
					minChars: 2,
                    name: 'grupo',
                    anchor:'60%',
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
				//float:'left'
                layout: 'form',
				border: false,
                items: [{
				xtype:'button',
            	text: 'Pesquisar',
				iconCls	    : 'icon-search',
           	 	handler: function(){
     	    	pgrupo = Ext.get('idgrupo').getValue(),
				pmarca = Ext.get('idmarca').getValue(),
     	    	dslistaProd.load(({params:{pesquisa: e.value, campo: e.column, grupo: pgrupo, marca: pmarca, 'start':0, 'limit':20000}}));
				Ext.getCmp('marca').clearValue();
				Ext.getCmp('grupo').clearValue();
  			 	}
        		}]
      
	  
				   }
				   
				   ]
					}]		
        }); 

        var listaProd = new Ext.FormPanel({
            title       : 'Produtos',
			labelAlign: 'top',
            region      : 'center',
            split       : true,
            width       : 200,
			autoHeight		: true,
            collapsible : true,
           // margins     : '3 3 3 0',
			//bodyStyle:'padding:5px 5px 0',
            //cmargins    : '3 3 3 3',
			items:[grid_listaProd]		
        }); 
	
		var listaDtProdsD = new Ext.FormPanel({
			id: 'sul',
            //title       : 'Detalhes',
			labelAlign: 'top',
            region      : 'south',
			//layout      : 'column',
           // split       : false,
           // width       : false,
			//autoHeight		: true,
			height		:140,
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
                items: [gridDetProd,gridDetProdCmp.hide()]},
				{
                width: '100%',
                layout: 'form',
                items: [gridDetProdVend,gridDetProdCompras.hide()]}
				  ]
					}]
	  }); 
		
		
///////////////// FIM DO FORM ///////////////////////////////////////////////////


/////////////////// INICIO DA WINDOW PRINCIPAL

	win_lista_prod = new Ext.Window({
		id: 'win_lista_prod',
		title: 'Lista de Produtos',
		width:930,
		height:540,
		autoScroll: true,
		shim:true,
		//animateTarget: 'lista_prod',
		closable : true,
		layout: 'border',
		resizable: false,
		closeAction: 'destroy',
		draggable: true, //Movimentar Janela
		plain: true,
		modal: false, //Bloquear tela do fundo
		items:[listaProd,listaDtProdsD,listaProdsP],
		//focus: function(){
		//			Ext.get('controleCli').focus(); 
		//},
		buttons: [
           	{
            text: 'Cerrar',
            handler: function(){ // fechar	
     	    win_lista_prod.destroy();
  			 }
			 
        }],
		focus: function(){
				setTimeout(function(){
  				grid_listaProd.getView().focusCell(0,0);
				}, 1750);
		}
		
	});
	
	
	win_lista_prod.show();
	
////// FIM DA WINDOW PRINCIPAL ////////////////////////


function basic_printGrid(){
		global_printer = new Ext.grid.XPrinter({
			grid:grid_listaProd,  // grid object 
			pathPrinter:'../php/printer',  	 // relative to where the Printer folder resides  
			logoURL: 'ext_logo.jpg', // relative to the html files where it goes the base printing  
			pdfEnable: true,  // enables link PDF printing (only save as) 
			hasrowAction:false, 
			localeData:{
				Title:'Valpar',	
				subTitle:'By NetCommerce',	
				footerText:'Valpar', 
				pageNo:'Pagina # ',	//page label
				printText:'Print',  //print document action label 
				closeText:'Close',  //close window action label 
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


var loadFn = function(btn, statusBar){
        btn = Ext.getCmp(queryProduto);
        statusBar = Ext.getCmp(statusBar);
        
        btn.disable();
        statusBar.showBusy();
        
        (function(){
            statusBar.clearStatus({useDefaults:true});
            btn.enable();
        }).defer(2000);
    };

var PesquisaProd = new Ext.FormPanel({
			labelAlign: 'top',
            region      : 'center',
            split       : true,
            autoWidth   : true,
			frame       : true,
			autoHeight	: true,
			items:[{
				    xtype: 'textfield',
					width: 200,
	                fieldLabel: 'Pesquisa',
	                name: 'queryProduto',
					id: 'queryProduto',
	                allowBlank:true,
					listeners:{
							keyup: function(el,type)
							{
							if(e.getKey() == 13  ){//ENTER 
							var theQuery=el.getValue();
							if(theQuery.length > 2)
                           				dslistaProd.load({params:{pesquisa: theQuery, campo: NomeCol, start: 0, limit: 500}});
							}
							if(e.getKey() == 40  ){//seta pra baixo  
										winPesquisa.hide();
										grid_listaProd.getView().focusCell(0,0);
							}
						}
               
					}
	            }]

        }); 

winPesquisa = new Ext.Window({
		title: '',
		width:330,
		height:100,
		shim:true,
		//animateTarget: 'lista_prod',
		closable : true,
		resizable: false,
		closeAction: 'hide',
		draggable: true, //Movimentar Janela
		plain: true,
		modal: false, //Bloquear tela do fundo
		items:[PesquisaProd],
		focus: function(){
   			Ext.get('queryProduto').focus(); 
		}
	});

winPesquisa.on('hide', function(){
Ext.getCmp("queryProduto").setValue();								
grid_listaProd.getView().focusCell(0,0);
								});
								
win_lista_prod.on('destroy', function(){
winPesquisa.destroy();	 
});
		

win_list = new Ext.Window({
		width:140,
		height:100,
		shim:true,
		//animateTarget: 'grid_listaProd',
		closable : true,
		layout: 'border',
		resizable: false,
		closeAction: 'hide',
		draggable: true, //Movimentar Janela
		plain: true,
		modal: false, //Bloquear tela do fundo
		items:[{
                    xtype:'textfield',
                    fieldLabel: 'Codigo',
					id: 'Codigo_',
                    name: 'Codigo_'
					}],
		focus: function(){
   grid_listaProd.focus();
   grid_listaProd.getSelectionModel().selectFirstRow();
		}
	
		
	});




	});
});