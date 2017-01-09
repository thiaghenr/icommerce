

HistProd = function(){





 var ProdVendEnt = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/HistEntProd.php',
			method: 'POST'
		}), 
		listeners:{
   				load:function(){
				//imagem = dsProdVend.getAt(0).get('imagem');
				// console.info(imagem);
  			 }
			},  
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'id'},
				   {name: 'referencia_prod'},
		           {name: 'descricao_prod'},
		           {name: 'qtd_vendido'},
				   {name: 'Estoque'},
				   {name: 'media'},
				   {name: 'valor_a'}
				   
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		remoteSort: true		
	});
 var gridProdVendEnt = new Ext.grid.EditorGridPanel({
	        store: ProdVendEnt, // use the datasource
	        columns:[
						{id:'id',header: "id", hidden: true, width: 50, sortable: true, dataIndex: 'id'},
						{header: 'Codigo', width: 80, sortable: true, dataIndex: 'referencia_prod'},
						{header: "Descricao", width: 230, sortable: true, dataIndex: 'descricao_prod'},
						{header: "Cant Vendido", width: 80,  align: 'right',  sortable: true, dataIndex: 'qtd_vendido'},
						{header: "Valor Medio Venda", width: 90, align: 'right', sortable: true, dataIndex: 'media', renderer: 'usMoney'},
						{header: "Cant Stok", width: 90, align: 'right', sortable: true, dataIndex: 'Estoque'},
						{header: "Valor A", width: 90, align: 'right', sortable: true, dataIndex: 'valor_a', renderer: 'usMoney'}
			 ],
	        viewConfig:{
	            forceFit:true
	        },
			width:'100%',
			id: 'id',
			height: 350,
			ds: ProdVendEnt,
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			autoScroll: true,
			bbar: new Ext.PagingToolbar({
				store: ProdVendEnt,
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
 ////////FIM GRID DOS DETALHES ///////////////////////////////////////////////////	




/*
editor.on({
  scope: this,
  afteredit: function(roweditor, changes, record, rowIndex) {
    //your save logic here - might look something like this:
    Ext.Ajax.request({
      url   : record.phantom ? '/users' : '/users/' + record.get('user_id'),
      method: record.phantom ? 'POST'   : 'PUT',
      params: {
	  idForn: FormReq.getForm().findField('IdForne').getValue(),
	  codprod: record.data.codprod,
	  idprod: record.data.idprod,
	  descprod: record.data.descprod,
	  qtdprod: record.data.qtdprod,
	  obsprod: record.data.obsprod,
	  user: id_usuario
	  },
      success: function() {
        //post-processing here - this might include reloading the grid if there are calculated fields
      }
    });
	console.info(record);
  }
});
*/

var FornCompras = function(){
   						Ext.Ajax.request({
           					url: 'php/LancDespesa.php',
							remoteSort: true,
           					params: {
							acao: 'fornCod',
							user: id_usuario,
			    			CodForn: FormEntProd.getForm().findField('IdForne').getValue()
            					},
								success: function(response){//se ocorrer correto 
								var jsonData = Ext.decode(response.responseText);
								 forn = Ext.decode( response.responseText);
								 if(forn){
								 nomeFornec = forn.nome;
								 EndForn = forn.endereco;
								 FormEntProd.getForm().findField('nomeforns').setValue(nomeFornec);
								 FormEntProd.getForm().findField('dataini').focus();								
								 
								 }
								 else{ 
								 FormEntProd.getForm().findField('IdForne').setValue();
								 Ext.MessageBox.alert('Aviso', 'Fornecedor nao encontrado'); }
								 
								}
							});
						}

var FormEntProd = new Ext.FormPanel({
			frame: true,
			id: 'FormEntProd',
			closable: true,
			title: 'Historico Produtos',
			bodyStyle:'background-color:#CDB5CD',
			width       : '100%',
			items: [
				{
				xtype       : 'fieldset',
				title       : 'Entre con los datos',
				layout      : 'form',
				collapsible : false,                    
				collapsed   : false,
				autoHeight  : true,
				anchor		: '97%',
				forceLayout : true,
				items: [
				
						{
						xtype:'textfield',
						fieldLabel: 'Entidade',
						labelWidth: 50,
						allowBlank: false,
						width: 40,
						name: 'IdForne',
						fireKey: function(e,type){
								if(e.getKey() == e.ENTER && FormEntProd.getForm().findField('IdForne').getValue() != '') {
									CodForn = FormEntProd.getForm().findField('IdForne').getValue();
									setTimeout(function(){
									//
									 }, 250);
									FornCompras();
						   //nav.form.findField('fin')setDisabled(false);
								}
								if(e.getKey() == e.ENTER && FormEntProd.getForm().findField('IdForne').getValue() === '') {
									Ext.Msg.alert('Alerta', 'Erro, Entre com o Codigo');
								}	
							}
						},
						{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: true,
				editable: true,
				labelWidth: 40,
				mode: 'remote',
				triggerAction: 'all',
				dataField: ['id','nomeforn'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Nome',
				minChars: 2,
				name: 'nomeforns',
				id: 'nomeforns',
				width: 200,
                resizable: true,
                listWidth: 300,
				col: true,
				forceSelection: true,
				store: new Ext.data.JsonStore({
				url: 'php/LancCompras.php?acao_nome=fornNome',
				root: 'resultados',
				fields: [ 'idforn', 'nomeforn' ]
				}),
					hiddenName: 'idforn',
					valueField: 'idforn',
					displayField: 'nomeforn',
					fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
						  Ext.getCmp('fatura').focus();
						}
					},
					onSelect: function(record){
						idforn = record.data.idforn;
						nomeforn = record.data.nomeforn;
						this.collapse();
						this.setValue(nomeforn);
						FormEntProd.getForm().findField('IdForne').setValue(idforn);
					}
					 },
					{
						xtype:'datefield',
						fieldLabel: 'De',
						labelWidth: 20,
						width: 100,
						name: 'dataini',
						//id: 'ender',
						col: true
						},
					{
						xtype:'datefield',
						fieldLabel: 'Hasta',
						labelWidth: 35,
						width: 100,
						name: 'datafim',
						//id: 'ender',
						col: true
						},
				{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: true,
				editable: true,
				labelWidth: 50,
				mode: 'remote',
				triggerAction: 'all',
				dataField: ['idprod','junto'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Codigo',
				minChars: 2,
				name: 'junto',
				id: 'junto',
				width: 200,
                resizable: true,
                listWidth: 300,
				forceSelection: true,
				store: new Ext.data.JsonStore({
				url: 'pesquisa_cod.php?acao_nome=CodDesc',
				root: 'resultados',
				fields: [ 'idprod', 'junto' ]
				}),
					hiddenName: 'idprod',
					valueField: 'idprod',
					displayField: 'junto'
				
			},
			{
			xtype:'button',
			text: 'Buscar',
			width: 100,
			name: 'buscarprod',
			col: true,
			handler: function(){
			/*FormEntProd.getForm().submit({
				url: "php/HistEntProd.php",
				params: {
						acao: 'busca'
				}
				, waitMsg: 'Buscando'
				, waitTitle : 'Aguarde....'
				, scope: this
			,callback: function (options, success, response) {
										if (success) { 
											Ext.MessageBox.alert('OK', response.responseText);
											var jsonData = Ext.util.JSON.decode(response.responseText);
											alert(jsonData);
											//	Ext.MessageBox.alert('Alerta', mens);
											//	window.location.reload();
											
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										//	if(jsonData.response == 'Confirme su password'){ 
										//	alert(jsonData.response);
										//	Ext.getCmp('password').focus();
										//	}
										}
						}); */
			ProdVendEnt.load({params:{
			acao: 'busca', 
			idprod: FormEntProd.getForm().findField('idprod').getValue(),
			entidade: FormEntProd.getForm().findField('IdForne').getValue(),
			dataini: FormEntProd.getForm().findField('dataini').getValue(),
			datafim: FormEntProd.getForm().findField('datafim').getValue()
			}});
			}
			},
			
			gridProdVendEnt
			
			
			]
			}
			]
			
			});

Ext.getCmp('tabss').add(FormEntProd);
Ext.getCmp('tabss').setActiveTab(FormEntProd);
FormEntProd.doLayout();	
			

}