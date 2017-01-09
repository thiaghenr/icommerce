// JavaScript Document


AbreChequesEmit = function(){

var xgChequesEmit = Ext.grid;

var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Favor Elejir un Registro');
}


var MovimentarChequeEmit = function(){
	var selectedKeys = grid_ChequesEmit.selModel.selections.keys; 
	if(selectedKeys.length > 0){
		var idselectcheque = Ext.decode(selectedKeys);
		
			winMovChequeEmit.show();
					record = grid_ChequesEmit.getSelectionModel().getSelected();
					
					var colCheque = grid_ChequesEmit.getColumnModel().getDataIndex(8); // Get field name 
					var colCheque = record.get(colCheque);
					Ext.getCmp('chequenumero').setText(colCheque);
					
					var colchequemoeda = grid_ChequesEmit.getColumnModel().getDataIndex(9); // Get field name chequevalidade
					var colchequemoeda = record.get(colchequemoeda);
					Ext.getCmp('chequemoeda').setText(colchequemoeda);
					
					idcontabancaria = grid_ChequesEmit.getColumnModel().getDataIndex(12); // Get field name 
					idcontabancaria = record.get(idcontabancaria);
					Ext.getCmp('chequenumero').setText(idcontabancaria);
					
					colVlCheque = grid_ChequesEmit.getColumnModel().getDataIndex(10); // Get field name 
					colVlCheque = record.get(colVlCheque);
					Ext.getCmp('vlcheques').setText(Ext.util.Format.usMoney(colVlCheque));

	}
	else
		{
		selecione();
		}
}

/////////////////////// INICIO STORE //////////////////////////////////
dsChequesEmit = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: 'php/ChequesEmit.php',
        method: 'POST'
    }),   
sortInfo:{field: 'dtvencimento', direction: "ASC"},
reader:  new Ext.data.JsonReader({
			totalProperty: 'total',
			root: 'results',
			id: 'idcheque_emit',
			fields: [
					 {name: 'idcheque_emit',  type: 'int' },
					 {name: 'contabancoid',  type: 'int' },
					 {name: 'nome_banco',  type: 'string' },
					 {name: 'nm_agencia',  type: 'string' },
					 {name: 'nm_conta',  type: 'string' },
					 {name: 'idconta_bancaria',  type: 'int' },
					 {name: 'numerocheque',  type: 'string' },
					 {name: 'dtemissao', type: 'date', format: 'Y/m/d'},
					 {name: 'dtvencimento',  type: 'date', format: 'Y/m/d'},
					 {name: 'historico',  type: 'string' },
					 {name: 'compraid',  type: 'int' },
					 {name: 'entid', type: 'int'},
					 {name: 'nome', type: 'string'},
					 {name: 'situacao', type: 'string'},
					 {name: 'vlcheque', type: 'float'},
					 {name: 'nm_moeda', type: 'string'},
					 {name: 'nome_user', type: 'string'},
					 {name: 'validade', type: 'string'}
					 ]
			}),					    
			baseParams:{acao: 'listarChequesEmit'}
		})
///////////// FIM STORE ////////////////////////

///////////// INICIO DA GRID //////////////////

	     var grid_ChequesEmit = new Ext.grid.GridPanel({
	        store: dsChequesEmit, // use the datasource
	       cm: new xgChequesEmit.ColumnModel([
		       
		        	//expander,
		            {id:'idcheque_emit', hidden: true, sortable: true, dataIndex: 'idcheque_emit'},
					{hidden: true, sortable: true, dataIndex: 'contabancoid'},
					{width:80, header: "Banco", align: 'left', sortable: true, dataIndex: 'nome_banco'},
					{width:60, header: "Agencia", align: 'left', sortable: true, dataIndex: 'nm_agencia'},
					{width:60, header: "Cuenta", align: 'left', sortable: true, dataIndex: 'nm_conta'},
					{width:60, header: "Emitido", align: 'right', sortable: true, dataIndex: 'dtemissao', renderer: Ext.util.Format.dateRenderer('d/m/Y')},		
					{width:60, header: "Validade", align: 'right', sortable: true, dataIndex: 'dtvencimento', renderer: Ext.util.Format.dateRenderer('d/m/Y')},				
					{width:90, header: "Historico", align: 'right', sortable: true, dataIndex: 'historico'},
					{width:40, header: "Cheque", align: 'right', sortable: true, dataIndex: 'numerocheque'},
					{width:40, header: "Moeda", align: 'right', sortable: true, dataIndex: 'nm_moeda'},
					{width:60, header: "Valor", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'vlcheque'},
					{width:60, header: "Situacao",align: 'right',  sortable: true, dataIndex: 'situacao'},
					{width:60, header: "",align: 'right', hidden: true, sortable: true, dataIndex: 'idconta_bancaria'}
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
			height: 500,
	        stripeRows:true,
			listeners: {
			},
			tbar : new Ext.Toolbar({
			align:'left',
         	buttons: [ 	
           				{
           			    text: 'Movimentar Cheque',
						align: 'left',
						iconCls: 'ico-app-go',
            			handler: function(){ // fechar	
     	    			MovimentarChequeEmit();
						}
  			 			},
						'-'
						/*
						,
						{
           			    text: 'pdf',
						id: 'pdf',
						align: 'left',
						iconCls: 'icon-pdf',
            			handler: function(){ // fechar	
     	    			imprimirPedidoPDF();
  			 			}
						},
						'-',
						{
           			    text: 'imprimir',
						id: 'printer',
						align: 'left',
						iconCls: 'icon-print',
            			handler: function(){ // fechar	
     	    			imprimirPedido();
  			 			}
						},
						'-',
						 {
				xtype: 'button',
			    id:'btnAddIten',
				text: 'Adicionar Itens',
				//autoShow: false,
				//hidden:  (situacao == 'A'),
				iconCls:'icon-add',
				tooltip: 'Clique para incluir novo iten',
				handler: function(){
						 ListaProdutosAdd();
						 Ext.getCmp('queryPedidoprodAdd').focus(); 
					
					} 
			   },'-',
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
                emptyText: 'N.Pedido',
				width: 120,
				forceSelection: true,
				store: [
                            ['id','Pedido'],
                            ['nome_cli','Nome'],
                            ['ruc','ruc']
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
							dsPesquisaPedido.load({params:{query: theQuery, combo: Ext.getCmp('sitID').getValue()}});
							 }
						}				
					}
	            }
						
			*/ 
        ]
    }),
			bbar: new Ext.PagingToolbar({
				store: dsChequesEmit,
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
		dsChequesEmit.load({params:{acao: 'listarCheques',start: 0, limit: 40}});

		grid_ChequesEmit.on('rowclick', function(grid, row, e) {
					 selectedKeys = grid_ChequesEmit.selModel.selections.keys;
					if(selectedKeys.length > 0){	
					 selectedRows = grid_ChequesEmit.selModel.selections.items;
					 selectedKeys = grid_ChequesEmit.selModel.selections.keys; 
					 idselectcheque = Ext.decode(selectedKeys);
					}
		});
		
		
	
		formMovChequeEmit = new Ext.FormPanel({
			frame		: true,
			closable:true,
            autoWidth   : true,
            split: true,
			//height	: 100,
			autoHeight: true,
			layout:'form',
            items:[
			{
			xtype: 'fieldset',
			height	: 90,
			items:[
			{
			xtype: 'label',
			text: 'Cheque: ',
			labelWidth: 5,
			style: 'font-weight:bold;color:blue;' 
			},
			{
			xtype: 'label',
			text: '',
			col: true,
			name: 'chequenumero',
			id: 'chequenumero',
			labelWidth: 20,
			style: 'font-weight:bold;color:black;' 
			},
			{
			xtype: 'label',
			text: 'Moneda: ',
			labelWidth: 5,
			style: 'font-weight:bold;color:blue;' 
			},
			{
			xtype: 'label',
			text: '',
			name: 'chequemoeda',
			id: 'chequemoeda',
			col: true,
			labelWidth: 20,
			style: 'font-weight:bold;color:black;' 
			},
			{
			xtype: 'label',
			text: 'Valor: ',
			labelWidth: 5,
			style: 'font-weight:bold;color:blue;' 
			},
			{
			xtype: 'label',
			text: '',
			name: 'vlcheques',
			id: 'vlcheques',
			col: true,
			labelWidth: 20,
			style: 'font-weight:bold;color:black;' 
			}
			]
			},
			{
            fieldLabel: 'Accion',
            displayField: 'displayField',   // what the user sees in the popup
            valueField: 'dataField',        // what is passed to the 'change' event
			emptyText: 'Seleccione',
            typeAhead: true,
            forceSelection: true,
            mode: 'local',
            triggerAction: 'all',
            selectOnFocus: true,
            editable: true,
            xtype: 'combo',
            store: store = new Ext.data.SimpleStore({
			fields: ['dataField', 'displayField'],
			data: [['AGUARDANDO', 'AGUARDANDO'],['COMPENSADO', 'COMPENSADO'], ['DEVOLVIDO', 'DEVOLVIDO']],
			autoLoad: false
			}),
			onSelect: function(combo, record){
					SituacaoChequeEmit = combo.data.dataField;
                   // console.log(SituacaoChequeEmit);
					this.collapse();
					this.setValue(combo.data.displayField);
					}	
                },
				{
						xtype:'button',
           			    text: 'Confirmar',
						iconCls: 'icon-save',
            			handler: function(){ 
							if(typeof SituacaoChequeEmit != "undefined"){
							Ext.Ajax.request({
								url: 'php/ChequesEmit.php',
								method: 'POST',
								remoteSort: true,
								params: {
								acao: 'Mover', 
								user: id_usuario,
								situacao: SituacaoChequeEmit,
								host: host,
								valor: colVlCheque,
								conta : idcontabancaria,
								idCheque: idselectcheque
								},
								callback: function (options, success, response) {
										if (success) { 
										//	Ext.MessageBox.alert('OK', response.responseText);
											var jsonData = Ext.util.JSON.decode(response.responseText);
											if(jsonData.response){
											Ext.MessageBox.alert('OK', jsonData.response);
											dsChequesEmit.reload();
											
											}
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										}
									
							});	
							}
							else{
							Ext.MessageBox.alert('Alerta', 'Favor Elejir una Opcion');
							}
						}
				}
			
			]
            });
			
			
	
		winMovChequeEmit = new Ext.Window({
				title: 'Movimiento',
				width:400,
				plain: true,						
				collapsible: false,
			//	resizable: false,
				closeAction:'hide',
				modal: true,
				border: false,
				items: [formMovChequeEmit],
				buttons: [
							{
            				text: 'Cerrar',
            				handler: function(){ // fechar	
     	    				winMovChequeEmit.hide();
							}
  			 				}
						],			
				focus: function(){
				}			
			})
winMovChequeEmit.on('hide', function() {
	formMovChequeEmit.getForm().reset();
	SituacaoChequeEmit = "";
});			
			


       	FormChequesEmit = new Ext.FormPanel({
		    autoWidth:true,
			autoScroll: true,
			border: false,
	        labelWidth: 75,
	        frame:true,
			//autoHeight: true,
			//height: 200,
			closable: true,
			layout: 'form',
	        title: 'Cheques Emitidos',
			items: [grid_ChequesEmit],
			listeners:{
				destroy: function() {
                             //grid_ItensPedido.destroy();
							// sul.remove('FormGridPedidosEdit');
							 
         				}
			         }	
 });



 
Ext.getCmp('tabss').add(FormChequesEmit);
Ext.getCmp('tabss').setActiveTab(FormChequesEmit);
FormChequesEmit.doLayout();	

}