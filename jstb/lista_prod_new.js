// JavaScript Document


ListaProd = function(){


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

/////////////////// GRID DA PESQUISA DE PRODUTOS //////////////////////////////////////////////////////////////
 		dsProdList = new Ext.data.Store({
                url: 'php/lista_prod_pedido.php',
                method: 'POST',
								
            reader:  new Ext.data.JsonReader({
				totalProperty: 'totalProdutos',
				root: 'resultsProdutos',
				id: 'id',
				fields: [
				   {name: 'id'},
				   {name: 'custo'},
				   {name: 'Codigo_Fabricante'},
				   {name: 'Codigo'},
		           {name: 'Descricao'},
				   {name: 'peso'},
		           {name: 'Estoque'},
		           {name: 'qtd_bloq'},
		           {name: 'valorA', mapping: 'valor_a'},
				   {name: 'valorB', mapping: 'valor_b'}
				
			]
			}),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		remoteSort: true,
		autoLoad: true
			
		})


		    var gridList = new Ext.grid.GridPanel({
		        store: dsProdList,
		        columns: [
						{id:'id',header: "id", width: 2, hidden: true, sortable: true, dataIndex: 'id'},
						{header:'Referencia', width: 80, sortable: true, dataIndex: 'Codigo_Fabricante'},
						{header:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descripcion", width: 250, sortable: true, dataIndex: 'Descricao'},
						{header: "Peso", width: 80, sortable: true, dataIndex: 'peso'},
						{header: "Disponible", width: 80, sortable: true, dataIndex: 'Estoque'},
						{header: "Bloq", width: 80, sortable: true, dataIndex: 'qtd_bloq'},
						{header: "custo", width: 80,hidden: true,  sortable: true, dataIndex: 'custo'},
						{header: "Valor A", width: 80, sortable: true, dataIndex: 'valorA',renderer: "usMoney"},
						{header: "Valor B", width: 80, sortable: true, dataIndex: 'valorB',renderer: "usMoney"}
					],
		        stripeRows: true,
		        viewConfig: {forceFit:true},
				//autoScrool: true,
				height      : 290
				//autoHeight: true
		        
		    });
			
			gridList.getSelectionModel().on('rowselect', function(sm, rowIndex, colIndex) {
			var record = gridList.getStore().getAt( rowIndex );
			prodId = record.id;
			custo = record.data.custo;
			Codigo_Fabricante = record.data.Codigo_Fabricante;
			//console.info(custo);
			}, this);
		
		    gridList.addListener('keydown',function(event){
				getItemRow(this, event)
			});
		    function getItemRow(grid, event){
		   key = getKey(event);
		   var idData = prodId; 
		   if(key==119){
		    storelistaProdVend.load(({params:{codigo: prodId /*, campo: e.column */}}));
			
		   }
		  }
		   // grid.getSelectionModel().selectFirstRow();
			
			//////// INICIO DA GRID DOS VENDIDOS ////////
var storelistaProdVend = new Ext.data.Store({
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
 var DetProdVend = new Ext.grid.EditorGridPanel(
	    {
	        store: storelistaProdVend, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "Pedido", width: 50, sortable: true, dataIndex: 'idped'},
						{header: 'Codigo', width: 80, sortable: true, dataIndex: 'controle_cli'},
						{header: "Nome", width: 230, sortable: true, dataIndex: 'nome_cli'},
						{header: "Data", width: 90, align: 'right', sortable: true, dataIndex: 'data_car'},
						{header: "Qtd", width: 80,  align: 'right',  sortable: true, dataIndex: 'qtd_produto'},
						{header: "Valor", width: 90, align: 'right', sortable: true, dataIndex: 'prvenda', renderer: 'usMoney'}
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			width:'100%',
			id: 'prodsVdP',
			height: 148,
			ds: storelistaProdVend,
			selModel: new Ext.grid.CellSelectionModel({singleSelect:false}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar : new Ext.Toolbar({ 
			items: []
						})
			
		
});

DetProdVend.on('load', function(){
			DetProdVend.getBottomToolbar().items.items[2].el.innerHTML = Ext.util.Format.usMoney(custo);
			DetProdVend.getBottomToolbar().items.items[4].el.innerHTML = Codigo_Fabricante ;
		   })
 ////////FIM GRID DOS DETALHES ////////
			
			var formProdList = new Ext.Panel({
			frame: true,
			//height: 280,
			//closable: true,
			//title:'Productos',
			labelAlign: 'left',
			//bodyStyle:'background-color:#4e79b2',
			width       : '100%',
		//	height      : 300,
		autoHeight: true,
			items: [gridList]
			})
			
			
			var	PesquisaProdNew = new Ext.FormPanel({
		    width:'100%',
			layout      : 'form',
			closable: true,
			title:'Productos',
	        frame:false,
			border: false,
	        bodyStyle:'padding:5px 5px 0',
	        defaultType: 'textfield',
			items: [{
                    xtype:'textfield',
                    fieldLabel: 'Codigo',
                    name: 'CProduto',
					labelWidth: 50,
					id: 'CProduto',
					fireKey: function(e,type){
							var theQueryProds = Ext.getCmp('CProduto').getValue(this);
							if(e.getKey() == e.ENTER && Ext.getCmp('CProduto').getValue() != '') {
							dsProdList.load({params:{query: theQueryProds,combo: 'Codigo'}});
							PesquisaProdNew.form.reset();
							}
							if(e.getKey() == 40  ){//seta pra baixo  
							   //grid_listaProdDetalhes.getSelectionModel().selectFirstRow();
							   //grid_listaProdDetalhes.getView().focusEl.focus();
                            }
							}
							},
							{
                    xtype:'textfield',
                    fieldLabel: 'Descripcion',
                    name: 'DescricaoProdutoNew',
					id: 'DescricaoProdutoNew',
					labelWidth: 70,
					width: 300,
                    col:true,
					fireKey : function(e){//evento de tecla   
							var theQueryProds = Ext.getCmp('DescricaoProdutoNew').getValue(this);
                            if(e.getKey() == e.ENTER && Ext.getCmp('DescricaoProdutoNew').getValue() != '') {//precionar enter   
							dsProdList.load({params:{query: theQueryProds,combo: 'Descricao'}});
							PesquisaProdNew.form.reset();
                            }}
							},
							formProdList,
							DetProdVend
					]
					
			})



Ext.getCmp('tabss').add(PesquisaProdNew);
Ext.getCmp('tabss').setActiveTab(PesquisaProdNew);
PesquisaProdNew.doLayout();	
Ext.get('CProduto').focus(); 

}