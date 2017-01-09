

EmitirReq = function(){





 var storeRequisicao = new Ext.data.JsonStore({
		autoLoad: false,
		url: '../json.php',
		root:'resultados',
		fields: [
				{name: 'idprod'},
				{name: 'codprod'},
				{name: 'descprod'},
				{name: 'qtdprod'},
				{name: 'obsprod'}
		]
})

var editor = new Ext.ux.grid.RowEditor();

var gridReq = new Ext.grid.GridPanel({
		plugins: editor,
		store: storeRequisicao,
		height      : 500,
		tbar: [{
				text: 'Adicionar Iten',
				iconCls: 'icon-add',
				handler: function(){
				editor.newRecord();
				Ext.getCmp('codprod').focus();
				}
				},
				'-',
				{
				text: 'Gravar Requisicao',
				iconCls: 'icon-save',
				handler: function(){
				
				if(FormReq.getForm().findField('IdForne').getValue() != '' ){	
					jsonData = "[";
					for(d=0;d<storeRequisicao.getCount();d++) {
					record = storeRequisicao.getAt(d);
					if(record.data.newRecord || record.dirty) {
					jsonData += Ext.util.JSON.encode(record.data) + ",";
					}
				}
				jsonData = jsonData.substring(0,jsonData.length-1) + "]";
				
						 Ext.Ajax.request({
           					url: 'php/EmitirRequisicao.php',
							method: 'POST',
							remoteSort: true,
           					params: {
							acao: 'FinReq', 
							user: id_usuario,
							dados: jsonData,
							host: host,
							idForn: FormReq.getForm().findField('IdForne').getValue()
						//	codprod: record.data.codprod,
						//	idprod: record.data.idprod,
						//	descprod: record.data.descprod,
						//	qtdprod: record.data.qtdprod,
						//	obsprod: record.data.obsprod,
            				},
								callback: function (options, success, response) {
										if (success) { 
											Ext.MessageBox.alert('OK', response.responseText);
											var jsonData = Ext.util.JSON.decode(response.responseText);
												if(jsonData.del_count){
													
													mens = jsonData.del_count + " Itens Inseridos. Requisicao N: " + jsonData.Requisicao;
													requisicao = jsonData.Requisicao;
													
												//	window.open('impressao.phpp?id_pedido='+jsonData.Requisicao +'','popup','width=750,height=500,scrolling=auto,top=0,left=0');
												//	window.location.reload();
												var win_rel_cli = new Ext.Window({
														id: 'helps',
														title: 'Relatorio Cliente',
														width: 650,
														height: 500,
														shim: false,
														animCollapse: false,
														constrainHeader: true,
														maximizable: false,
														layout: 'fit',
														items: { html: "<iframe height='100%' width='100%' src='pdf_requisicao.php?id_pedido="+requisicao +"' > </iframe>" },
														buttons: [
																{
																text: 'Cerrar',
																handler: function(){ // fechar	
																win_rel_cli.destroy();
																}
											 
															}]
												});
												win_rel_cli.show();
												}
												 if(jsonData.response == 'Confirme su password'){ 
												//	alert(jsonData.response);
												//Ext.getCmp('password').focus();
												}
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										}
								
							//	dsProds.removeAll();
							//	dsProdVend.removeAll();
							//	formCliente.form.reset();
							//	formFinalisar.form.reset();
							//	tot.form.reset();
							//	Ext.getCmp('fin').setDisabled(true);
						  });
					}
				
				else{
					Ext.MessageBox.alert('Erro','Campo Obligatorio.');
				}
				
					}		
				}
				
				],

	columns: [{
		header: '',
		dataIndex: 'idprod',
		//hidden: true,
		width: 2,
		editor: {
		id: 'idprod',
		name: 'idprod',
		xtype: 'textfield',
		readOnly: true		
		}
		},
		{
			header: '<b>Codigo</b>',
			dataIndex: 'codprod',
		//	sortable: true,
			editor: {
                    xtype:'combo',
					hideTrigger: true,
					emptyText: 'Selecione',
					allowBlank: true,
					editable: true,
				//	mode: 'remote',
					triggerAction: 'all',
					dataField: ['idprod','codprod', 'descprod'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
					id: 'codprod',
					minChars: 2,
					name: 'codprod',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: '/pesquisa_cod.php?acao_nome=CodProd',
					root: 'resultados',
					fields: [ 'idprod', 'codprod', 'descprod' ]
					}),
					//	hiddenName: 'idprod',
					//	valueField: 'idprod',
						displayField: 'codprod',
						fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('grupo').focus();
                            }},
					onSelect: function(record){
					var	idprod = record.data.idprod;
					var	codprod = record.data.codprod;
					var	descprod = record.data.descprod;
						this.collapse();
						this.setValue(codprod);
					
					Ext.getCmp('descprod').setValue(descprod);
					Ext.getCmp('qtdprod').setValue('1');
					Ext.getCmp('idprod').setValue(idprod);
					}
	                }
		},
		{
			header: '<b>Descripcion</b>',
			dataIndex: 'descprod',
			width: 300,
			editor: {
			xtype:'combo',
				hideTrigger: true,
				allowBlank: true,
				editable: true,
			//	mode: 'remote',
				triggerAction: 'all',
				dataField: ['idprod','codprod', 'descprod'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				id: 'descprod',
				minChars: 2,
				name: 'descprod',
				width: 250,
                resizable: true,
                listWidth: 300,
				forceSelection: false,
				store: new Ext.data.JsonStore({
				url: '/pesquisa_cod.php?acao_nome=DescProd',
				root: 'resultados',
				fields: [ 'idprod', 'codprod', 'descprod' ]
				}),
					hiddenName: 'idprod',
					valueField: 'idprod',
					displayField: 'descprod',
					fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
						  // document.getElementById('margen_a').focus();
						}
					},
				onSelect: function(record){
					var	idprod = record.data.idprod;
					var	codprod = record.data.codprod;
					var	descprod = record.data.descprod;
						this.collapse();
						this.setValue(descprod);
					
					Ext.getCmp('codprod').setValue(codprod);
					Ext.getCmp('qtdprod').setValue('1');
					Ext.getCmp('idprod').setValue(idprod);
					}
			 }
		},
		{
			header: '<b>Qtd</b>',
			dataIndex: 'qtdprod',
			editor: {
			xtype: 'numberfield',
			id: 'qtdprod',
			name: 'qtdprod',
			allowBlank: true
			}
		},
		{
			header: '<b>Obs</b>',
			dataIndex: 'obsprod',
			width: 350,
			editor: {
			xtype: 'textfield',
			id: 'obsprod',
			name: 'obsprod',
			allowBlank: true
			}
		}
	]
	
	
})

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
			    			CodForn: FormReq.getForm().findField('IdForne').getValue()
            					},
								success: function(response){//se ocorrer correto 
								var jsonData = Ext.decode(response.responseText);
								 forn = Ext.decode( response.responseText);
								 if(forn){
								 nomeFornec = forn.nome;
								 EndForn = forn.endereco;
								 FormReq.getForm().findField('NomForne').setValue(nomeFornec);
								 FormReq.getForm().findField('ender').setValue(EndForn);								
								 
								 }
								 else{ 
								 FormReq.getForm().findField('IdForne').setValue();
								 Ext.MessageBox.alert('Aviso', 'Fornecedor nao encontrado'); }
								 
								}
							});
						}

var FormReq = new Ext.FormPanel({
			frame: true,
			id: 'FormReq',
			closable: true,
			title: 'Emitir Requisicao',
			bodyStyle:'background-color:#CDB5CD',
			width       : '100%',
			items: [
				{
				xtype       : 'fieldset',
				title       : 'Pesquisa por proveedor',
				layout      : 'form',
				collapsible : false,                    
				collapsed   : false,
				autoHeight  : true,
				anchor		: '97%',
				forceLayout : true,
				items: [
						{
						xtype:'textfield',
						fieldLabel: 'Codigo',
						labelWidth: 40,
						allowBlank: false,
						width: 100,
						name: 'IdForne',
						fireKey: function(e,type){
								if(e.getKey() == e.ENTER && FormReq.getForm().findField('IdForne').getValue() != '') {
									CodForn = FormReq.getForm().findField('IdForne').getValue();
									setTimeout(function(){
									//
									 }, 250);
									FornCompras();
						   //nav.form.findField('fin')setDisabled(false);
								}
								if(e.getKey() == e.ENTER && FormReq.getForm().findField('IdForne').getValue() === '') {
									Ext.Msg.alert('Alerta', 'Erro, Entre com o Codigo');
								}	
							}
						},
						{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: true,
				labelWidth: 70,
				mode: 'remote',
				triggerAction: 'all',
				dataField: ['idforn','nomeforn', 'EndForn'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Fornecedor	',
				minChars: 2,
				name: 'NomForne',
				id: 'NomForne',
				width: 200,
                resizable: true,
                listWidth: 300,
				col: true,
				forceSelection: true,
				store: new Ext.data.JsonStore({
				url: 'php/LancCompras.php?acao_nome=fornNome',
				root: 'resultados',
				fields: [ 'idforn', 'nomeforn', 'EndForn' ]
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
						ender = record.data.EndForn;
						this.collapse();
						this.setValue(nomeforn);
						FormReq.getForm().findField('IdForne').setValue(idforn);
						FormReq.getForm().findField('ender').setValue(ender);
					}
					 },
					{
						xtype:'textfield',
						fieldLabel: 'Endereco',
						labelWidth: 60,
						width: 300,
						name: 'ender',
						//id: 'ender',
						readOnly: true,
						col: true
						}
				]
			},		
			gridReq
			
			
			]
			
			});

Ext.getCmp('tabss').add(FormReq);
Ext.getCmp('tabss').setActiveTab(FormReq);
FormReq.doLayout();	
			

}