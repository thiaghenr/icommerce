// JavaScript Document


AbreCheques = function(){

var xgCheques = Ext.grid;

var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Favor Elejir un Registro');
}


var Movimentar = function(){
	var selectedKeys = grid_Cheques.selModel.selections.keys; 
	if(selectedKeys.length > 0){
		var idselect = Ext.decode(selectedKeys);
		
			winMovCheque.show();
					record = grid_Cheques.getSelectionModel().getSelected();
					var colNameCli = grid_Cheques.getColumnModel().getDataIndex(1); // Get field name 
					var colNameCli = record.get(colNameCli);
					Ext.getCmp('nomeclientecheque').setText(colNameCli);
					
					var colchequevalidade = grid_Cheques.getColumnModel().getDataIndex(10); // Get field name chequevalidade
					var colchequevalidade = record.get(colchequevalidade);
					Ext.getCmp('chequevalidade').setText(colchequevalidade);
					
					colValor = grid_Cheques.getColumnModel().getDataIndex(8); // Get field name 
					colValor = record.get(colValor);
					Ext.getCmp('valorcheque').setText(colValor);

	}
	else
		{
		selecione();
		}
}

/////////////////////// INICIO STORE //////////////////////////////////
dsCheques = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: '../sistema/php/Cheques.php',
        method: 'POST'
    }),   
sortInfo:{field: 'data_validade', direction: "ASC"},
reader:  new Ext.data.JsonReader({
			totalProperty: 'total',
			root: 'results',
			id: 'id_cheque',
			fields: [
					 {name: 'id_cheque',  type: 'int' },
					 {name: 'nome_banco',  type: 'string' },
					 {name: 'agencia',  type: 'string' },
					 {name: 'conta',  type: 'string' },
					 {name: 'num_cheque',  type: 'string' },
					 {name: 'data_dia', type: 'date', format: 'Y/m/d'},
					 {name: 'data_validade',  type: 'date', format: 'Y/m/d'},
					 {name: 'nome',  type: 'string' },
					 {name: 'nm_moeda', type: 'string'},
   			         {name: 'idpedido', type: 'int'},
					 {name: 'situacao', type: 'string'},
					 {name: 'valor', type: 'float'},
					 {name: 'validade', type: 'string'}
					 ]
			}),					    
			baseParams:{acao: 'listarCheques'}
		})
///////////// FIM STORE ////////////////////////

///////////// INICIO DA GRID //////////////////

	     var grid_Cheques = new Ext.grid.GridPanel({
	        store: dsCheques, // use the datasource
	       cm: new xgCheques.ColumnModel([
		       
		        	//expander,
		            {id:'id_cheque', width:20, header: "Num",  sortable: true, dataIndex: 'id_cheque'},
					{width:100, header: "Cliente",  sortable: true, dataIndex: 'nome'},
					{width:60, header: "Cadastro", align: 'right', sortable: true, dataIndex: 'data_dia', renderer: Ext.util.Format.dateRenderer('d/m/Y')},
					{width:60, header: "Validade", align: 'right', sortable: true, dataIndex: 'data_validade', renderer: Ext.util.Format.dateRenderer('d/m/Y')},
					{width:80, header: "Banco", align: 'right', sortable: true, dataIndex: 'nome_banco'},
					{width:40, header: "Agencia", align: 'right', sortable: true, dataIndex: 'agencia'},
					{width:40, header: "Cheque", align: 'right', sortable: true, dataIndex: 'num_cheque'},
					{width:40, header: "Moeda", align: 'right', sortable: true, dataIndex: 'nm_moeda'},
					{width:60, header: "Valor", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'valor'},
					{width:60, header: "Situacao",align: 'right',  sortable: true, dataIndex: 'situacao'},
					{width:60, hidden: true, align: 'right',  sortable: true, dataIndex: 'validade'}
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
     	    			Movimentar();
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
				store: dsCheques,
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
		dsCheques.load({params:{acao: 'listarCheques',start: 0, limit: 40}});

		grid_Cheques.on('rowclick', function(grid, row, e) {
					 selectedKeys = grid_Cheques.selModel.selections.keys;
					if(selectedKeys.length > 0){	
					 selectedRows = grid_Cheques.selModel.selections.items;
					 selectedKeys = grid_Cheques.selModel.selections.keys; 
					 idselect = Ext.decode(selectedKeys);
					}
		});
		
		
	
		formMovCheque = new Ext.FormPanel({
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
			text: 'Cliente: ',
			labelWidth: 5,
			style: 'font-weight:bold;color:blue;' 
			},
			{
			xtype: 'label',
			text: '',
			col: true,
			name: 'nomeclientecheque',
			id: 'nomeclientecheque',
			labelWidth: 20,
			style: 'font-weight:bold;color:black;' 
			},
			{
			xtype: 'label',
			text: 'Vencimiento: ',
			labelWidth: 5,
			style: 'font-weight:bold;color:blue;' 
			},
			{
			xtype: 'label',
			text: '',
			name: 'chequevalidade',
			id: 'chequevalidade',
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
			name: 'valorcheque',
			id: 'valorcheque',
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
			data: [['AGUARDANDO', 'AGUARDANDO'], ['DEPOSITADO', 'DEPOSITADO'], 
				['COMPENSADO', 'COMPENSADO'], ['DEVOLVIDO', 'DEVOLVIDO']],
			autoLoad: false
			}),
			onSelect: function(combo, record){
					SituacaoCheque = combo.data.dataField;
                   // console.log(SituacaoCheque);
					this.collapse();
					this.setValue(combo.data.displayField);
					if(SituacaoCheque == "DEPOSITADO"){
						formMovCheque.getForm().findField('conta').setDisabled(false); 
					}
                }	
                },
				{
                    xtype:'combo',
					hideTrigger: false,
					emptyText: 'Selecione',
					disabled: true,
					allowBlank: false,
					editable: true,
					fieldLabel: 'Cuenta	',
					labelWidth: 50,
					width: 130,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idconta_bancaria','conta'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
					minChars: 2,
					name: 'conta',
					listWidth: 280,
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: '/pesquisa_conta_bancaria.php?acao_nome=NomeConta',
					root: 'resultados',
					fields: [ 'idconta_bancaria', 'conta' ]
					}),
						hiddenName: 'conta',
						valueField: 'idconta_bancaria',
						displayField: 'conta',
						fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('grupo').focus();
                            }},
					onSelect: function(record){
						idconta_bancaria = record.data.idconta_bancaria;
						conta = record.data.conta;
						this.collapse();
						this.setValue(idconta_bancaria);
					}
	                },
				{
						xtype:'button',
           			    text: 'Confirmar',
						iconCls: 'icon-save',
            			handler: function(){ 
							if(typeof SituacaoCheque != "undefined"){
							Ext.Ajax.request({
								url: '../sistema/php/Cheques.php',
								method: 'POST',
								remoteSort: true,
								params: {
								acao: 'Mover', 
								user: id_usuario,
								situacao: SituacaoCheque,
								host: host,
								valor: colValor,
								conta : idconta_bancaria,
								idCheque: idselect
								},
								callback: function (options, success, response) {
										if (success) { 
										//	Ext.MessageBox.alert('OK', response.responseText);
											var jsonData = Ext.util.JSON.decode(response.responseText);
											if(jsonData.response){
											Ext.MessageBox.alert('OK', jsonData.response);
											dsCheques.reload();
											
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
			
			
	
		winMovCheque = new Ext.Window({
				title: 'Movimiento',
				width:400,
				plain: true,						
				collapsible: false,
			//	resizable: false,
				closeAction:'hide',
				modal: true,
				border: false,
				items: [formMovCheque],
				buttons: [
							{
            				text: 'Cerrar',
            				handler: function(){ // fechar	
     	    				winMovCheque.hide();
							}
  			 				}
						],			
				focus: function(){
				}			
			})
winMovCheque.on('hide', function() {
	formMovCheque.getForm().reset();
	SituacaoCheque = "";
	formMovCheque.getForm().findField('conta').setDisabled(true); 
});			
			


       	FormCheques = new Ext.FormPanel({
		    autoWidth:true,
			autoScroll: true,
			border: false,
	        labelWidth: 75,
	        frame:true,
			//autoHeight: true,
			//height: 200,
			closable: true,
			layout: 'form',
	        title: 'Cheques Recibidos',
			items: [grid_Cheques],
			listeners:{
				destroy: function() {
                             //grid_ItensPedido.destroy();
							// sul.remove('FormGridPedidosEdit');
							 
         				}
			         }	
 });



 
Ext.getCmp('tabss').add(FormCheques);
Ext.getCmp('tabss').setActiveTab(FormCheques);
FormCheques.doLayout();	

}