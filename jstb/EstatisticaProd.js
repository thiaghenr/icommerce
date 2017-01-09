// JavaScript Document

  Ext.BLANK_IMAGE_URL = '../ext3.1.1/resources/images/default/s.gif';
  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  Ext.QuickTips.init();



EstProd = function(){

	function change(val){
        if(val > 0){
            return '<span style="color:blue;font-weight: bold;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;font-weight: bold">' + val + '</span>';
        }
        return val;
    };
	
function Pesquisar(){
	marca = Ext.getCmp('marcaProdE').getValue();
	grupo = Ext.getCmp('grupoProdE').getValue();
	codigo = Ext.getCmp('textEstProd').getValue();
	Ext.getCmp('marcaProdE').clearValue();
	Ext.getCmp('grupoProdE').clearValue();
	//Ext.getCmp('textEstProd').clearValue();

dsEstatistica.load({params:{marca: marca, grupo: grupo, codigo: codigo }});


}


var dsEstatistica = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/EstatisticaProd.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Itens',
			totalProperty: 'total',
			id: 'id'
		},
			[
				   {name: 'id'},
				   {name: 'Codigo'},
		           {name: 'Descricao'},
		           {name: 'Estoque'},
		           {name: 'vla', mapping: 'valorA'},
				   {name: 'marca', mapping: 'nom_marca'},
				   {name: 'grupo', mapping: 'nom_grupo'},
				   {name: 'margen_a', mapping: 'margen_a'},
				   {name: 'margen_b', mapping: 'margen_b'},
				   {name: 'custo'},
				   {name: 'custo_anterior'},
				   {name: 'custo_medio'},	
				   {name: 'qtd_vendido'},
				   {name: 'vl_medio_venda'},
				   {name: 'lucro_medio'},		
				   {name: 'marcaid'},
				   {name: 'grupoid'}
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		remoteSort: true
		//autoLoad: true
	});
	
 var grid_Estatistica = new Ext.grid.EditorGridPanel({
	        store: dsEstatistica, // use the datasource
	        columns:
		        [
						{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header:'Codigo', width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descricao", width: 200, sortable: true, dataIndex: 'Descricao'},
						{header: "Grupo", width: 80, hidden: true, align: 'right', sortable: true, dataIndex: 'grupo'},
						{header: "Marca", width: 80, hidden: true, align: 'right', sortable: true, dataIndex: 'marca'},
						{header: "Estoque", width: 55, align: 'right', sortable: true, dataIndex: 'Estoque', renderer: change},
						{header: "Vendido", width: 55,  align: 'right',  sortable: true, dataIndex: 'qtd_vendido'},
						{header: "Custo Ant", width: 80, align: 'right', sortable: true, dataIndex: 'custo_anterior',renderer: 'usMoney'},
						{header: "Custo Med", width: 80, align: 'right', sortable: true, dataIndex: 'custo_medio',renderer: 'usMoney'},
						{header: "Custo Atu", width: 80, align: 'right', sortable: true, dataIndex: 'custo',renderer: 'usMoney'},
						{header: "Vl Med Vend", width: 80, align: 'right', sortable: true, dataIndex: 'vl_medio_venda',renderer: 'usMoney'},
						{header: "Lucro Medio", width: 80, align: 'right', sortable: true, dataIndex: 'lucro_medio', renderer: 'usMoney'}						
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
			ds: dsEstatistica,
			selModel: new Ext.grid.RowSelectionModel(),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true
});
	


/////////////////INICIO DO FORM //////////////////////////////
		var listaProdsE = new Ext.FormPanel({
			labelAlign: 'top',
			id: 'listaProdsE',
			title: 'Estatistica de Produtos',
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
					id: 'marcaProdE',
					minChars: 2,
					name: 'marcaProdE',
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

                },
				{
					xtype: 'textfield',
	                fieldLabel: 'Codigo',
	                name: 'textEstProd',
					id: 'textEstProd',
					anchor:'90%',
	                allowBlank:true,
					enableKeyEvents: true,
					fireKey : function(e){//evento de tecla   
                            
							if(e.getKey() == e.ENTER){ 
							var valor = Ext.getCmp('textEstProd').getValue();
							var campo = 'Codigo';
							Pesquisar(campo,valor);
							 Ext.getCmp('textEstProd').setValue('');
						}		
					}
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
					id: 'grupoProdE',
					minChars: 2,
                    name: 'grupoProdE',
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
											//pgrupo = Ext.get('idgrupo').getValue(),
											Pesquisar();
  			 								}
        				}
						]
			 	}
				   ]
					},
					grid_Estatistica
					],
			listeners:{
				destroy: function(){
				tabs.remove('listaProdsE');
				}
			}
        }); 
///////////////// FIM DO FORM ///////////////////////////////////////////////////





Ext.getCmp('tabss').add(listaProdsE);
Ext.getCmp('tabss').setActiveTab(listaProdsE);
listaProdsE.doLayout();	

}