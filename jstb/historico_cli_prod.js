var TRRecord = Ext.data.Record.create([
        {name: 'id'},
        {name: 'name'},
        {name: 'type'},
        {name: 'datainihist', type: 'date', dateFormat: 'Y-m-d'},
        {name: 'datafimhist', type: 'date', dateFormat: 'Y-m-d'}
]);  


HistoricoCliProd = function(){
 Ext.QuickTips.init();
    Ext.form.Field.prototype.msgTarget = 'side';
var xgPedido = Ext.grid;
/////////////////////// INICIO STORE //////////////////////////////////
dsPesquisaProds = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: 'php/historico_cli_prod.php',
        method: 'POST'
    }),   

reader:  new Ext.data.JsonReader({
			totalProperty: 'total',
			root: 'results',
			id: 'id',
			fields: [
					 {name: 'id' },
					 {name: 'referencia_prod',  type: 'string' },
					 {name: 'descricao_prod',  type: 'string' },
					 {name: 'total' }
					 //{name: 'action1', type: 'string'},
   			         //{name: 'action2', type: 'string'}

					 ]
			}),					    
			baseParams:{acao: 'listarPedidos'}
		})
///////////// FIM STORE ////////////////////////

		var grid_histprod = new Ext.grid.GridPanel({
	        store: dsPesquisaProds, // use the datasource
	       cm: new xgPedido.ColumnModel([
		       
		        	//expander,
		            {id:'id', width:40, hidden: true,  sortable: true, dataIndex: 'id'},
					{id:'referencia_prod', width:70, header: "Codigo",  sortable: true, dataIndex: 'referencia_prod'},
					{id:'descricao_prod', width:200, header: "Descricao",  sortable: true, dataIndex: 'descricao_prod'},
					{id:'total', width:60, header: "Total", align: 'right', sortable: true, dataIndex: 'total'}
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
			height: 300,
	        stripeRows:true,
			listeners: {
			keypress: function(e){
				
			if(e.getKey()  >47 && e.getKey() < 58 || e.getKey() >64 && e.getKey() < 91 || e.getKey() >95 && e.getKey() < 106 ){	
				
 	   					 Ext.get('queryPedido').focus();
			
				
			}}},
			bbar: new Ext.PagingToolbar({
				store: dsPesquisaProds,
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

	    FormHistPesq = new Ext.Panel({
			frame		: true,
			closable:true,
            autoWidth   : true,
            split: true,
			//height	: 350,
			autoHeight: true,
			layout:'form',
            items:[
			{
                 xtype: 'textfield',
                 name: 'entidade',
				 hidden: true
            },
			{
                 xtype: 'textfield',
                 name: 'produto',
				 hidden: true
            },
			{
                xtype: 'compositefield',
				combineErrors: false,
                fieldLabel: '<b>Entidade</b>',
                msgTarget : 'side',
                anchor    : '-20',
                defaults: {
                    flex: 1
                },
                items: [
				{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Entidade',
				labelWidth: 50,
				minChars: 2,
				name: 'nomeforn',
			//	id: 'nomeforn',
				width: 200,
                resizable: true,
                listWidth: 350,
				col: true,
				forceSelection: true,
				store: new Ext.data.JsonStore({
				url: 'php/LancDespesa.php?acao_nome=fornNome',
				root: 'resultados',
				fields: [ 'idforn', 'nomeforn', 'endereco' ]
				}),
					hiddenName: 'idforn',
					valueField: 'idforn',
					displayField: 'nomeforn',
					onSelect: function(record){
						idforn = record.data.idforn;
						nomeforn = record.data.nomeforn;
						this.collapse();
						this.setValue(nomeforn);
						HistCliProd.getForm().findField('entidade').setValue(idforn);
					}
							
                },
				 {
                 xtype: 'displayfield',
                 value: 'Produto:',
				 width: 50
                 },
				{
				xtype:'combo',
				hideTrigger: true,
				allowBlank: true,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Produto',
			//	id: 'descprod',
				minChars: 2,
				name: 'descprods',
				width: 200,
				labelWidth: 50,
                resizable: true,
                listWidth: 350,
				forceSelection: true,
				store: new Ext.data.JsonStore({
				url: 'pesquisa_desc.php?acao_nome=DescProd',
				root: 'resultados',
				fields: [ 'idprod', 'descprod' ]
				}),
					hiddenName: 'idprod',
					valueField: 'idprod',
					displayField: 'descprod',
					fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.BACKSPACE) {//precionar enter  
						 this.setValue();
						 HistCliProd.getForm().findField('produto').setValue();
						}
					},
					onSelect: function(record){
						idprod = record.data.idprod;
						descprod = record.data.descprod;
						this.collapse();
						this.setValue(descprod);
						HistCliProd.getForm().findField('produto').setValue(idprod);
					}
							
                }
				]
				},
				{
                xtype: 'compositefield',
                fieldLabel: '<b>Periodo</b>',
                msgTarget : 'side',
             //   anchor    : '-20',
                defaults: {
                    flex: 1
                },
                items: [
				{
                 xtype: 'displayfield',
                 value: 'De:',
				 width: 16
                 },
				{
			    xtype: 'datefield',
			    fieldLabel: 'Data incial',
			    name: 'datainihist',
			    width: 100,
				labelWidth: 60
			  },
			  {
                 xtype: 'displayfield',
                 value: 'Hasta:',
				 width: 33
                 },
		  	  {
			  xtype: 'datefield',
			  fieldLabel: 'Data final',
			  name: 'datafimhist',
			  width: 100,
			  labelWidth: 60
		  	  },
		     {
			  xtype: 'button',
			  text: 'Buscar',
			  iconCls: 'icon-search',
			  name: 'buscar',
			  width: 100,
			  col: true,
			  handler: function(){ 
			  dsPesquisaProds.load(({params:{'acao': 'buscaprods', 'dataini': HistCliProd.getForm().findField('datainihist').getValue(), 
			  'datafim': HistCliProd.getForm().findField('datafimhist').getValue(),
			  'entidade': HistCliProd.getForm().findField('entidade').getValue(),
			  'produto': HistCliProd.getForm().findField('produto').getValue() }}));
			 }
		  }
		  ]
		  }
			],
            listeners:{
					destroy: function() {
						//	 tabs.remove('simplePedidos');
         				   }
		              }
            });


	HistCliProd = new Ext.FormPanel({
			title: 'Historico',
		    autoWidth:true,
			autoScroll: true,
			border: false,
	        labelWidth: 75,
	        frame:true,
			col:true,
			//autoHeight: true,
			//height: 200,
			closable: true,
			layout: 'form',
			items: [FormHistPesq,grid_histprod],
			listeners:{
				destroy: function() {
                             //grid_ItensPedido.destroy();
						//	 sul.remove('FormGridPedidosEdit');
							 
         				}
			         }	
 });
 
 		////////////////STORE DOS PEDIDOS DO CLIENTE ///////////////////////
var dsPedidosEnt = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/historico_cli_prod.php',
			method: 'POST'
		}),   
		baseParams:{acao: "listarvendas"},
		reader:  new Ext.data.JsonReader({
			root: 'pedidos',
			totalProperty: 'totalPed',
			id: 'id'
		},
			[
				{name: 'id'},
				{name: 'data_car'},
				{name: 'vendedor'},
				{name: 'pedido'},
				{name: 'total_nota'}
				
			] 
		),
		sortInfo: {field: 'id', direction: 'DESC', id: HistCliProd.getForm().findField('entidade').getValue()},  
		remoteSort: true,
		autoLoad: true
	});
//////// FIM STORE DOS PEDIDOS DO CLIENTE //////////////
//////// INICIO DA GRID DOS PEDIDOS DO CLIENTE ////////
 var grid_pedidos_ent = new Ext.grid.GridPanel({
	        store: dsPedidosEnt, // use the datasource
	        columns:
		        [
		        	//expander,
					{id:'id', width: 50, header: "Venda ",   sortable: true, dataIndex: 'id'},
					{id:'pedido', width:100, header: "Pedido",  sortable: true, dataIndex: 'pedido'},
					{id:'vendedor', width:100, header: "Vendedor",  sortable: true, dataIndex: 'vendedor'},
		            {id:'data_car', width:90, header: "Data ",  sortable: true, dataIndex: 'data_car'},
					{id:'total_nota', width:120, header: "Total",  sortable: true, dataIndex: 'total_nota', renderer: 'usMoney'}
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			autoWidth:true,
			height: 350,
			border: true,
			loadMask: true,
			closable: true,
			enableColLock: false,
			//renderTo: Ext.getCmp('south').body,
	        stripeRows:true,
	        iconCls:'icon-grid',
            bbar: new Ext.PagingToolbar({
				store: dsPedidosEnt,
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


	
 winPedProds = new Ext.Window({
					title : 'Pedidos del Productos'
	                ,layout: 'form'
	                , width: 600
	                , closeAction :'hide'
	                , plain: true
					, modal: true
					, items:[grid_pedidos_ent]
					,focus: function(){
 	    					//	Ext.get('nomedep').focus();
									}
					,buttons: [
					{
					text: 'Cerrar',
					handler: function(){ 
						winPedProds.hide();
					
					}
					}
					]
					
					});
 
 grid_histprod.on('rowdblclick', function(grid, row, e) {
 
			record = grid_pedidos_ent.getSelectionModel().getSelected();
			var idName = grid_pedidos_ent.getColumnModel().getDataIndex(0); // Get field name
			var idData = record.get(idName);
					
			winPedProds.show();	
			dsPedidosEnt.load(({params:{'entidade': HistCliProd.getForm().findField('entidade').getValue(),
										'datafim': HistCliProd.getForm().findField('datafimhist').getValue(),
										'entidade': HistCliProd.getForm().findField('entidade').getValue(),
										'prod': idData }}));
			
			//  entidade: id: HistCliProd.getForm().findField('entidade').getValue()
			// Carrega O formulario Com os dados da linha Selecionada
//					dsContatos.load({params:{acao: 'listarContatos', id: top.getForm().findField('controle').getValue()}});
		});
		


Ext.getCmp('tabss').add(HistCliProd);
Ext.getCmp('tabss').setActiveTab(HistCliProd);
HistCliProd.doLayout();	

}