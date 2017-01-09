// JavaScript Document
Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
  
Ext.QuickTips.init();
Ext.form.Field.prototype.msgTarget = 'side';
	
Cheques = function(){


var formCadCheques = new Ext.FormPanel({
			id: 'formCadCheques',
			autoHeight: true,
			layout: 'form',
			frame       :true,
			items		: [
							{
							xtype       : 'fieldset',
							title       : 'Datos del Cheque',
							autoHeight  : true,
							items: [
							{
								xtype:'combo',
								hideTrigger: false,
								emptyText: 'Banco',
								allowBlank: true,
								editable: true,
								mode: 'remote',
								triggerAction: 'all',
								dataField: ['id_banco','nome_banco'],
								loadingText: 'Consultando Banco de Dados',
								selectOnFocus: true,
								fieldLabel: 'Banco',
								minChars: 2,
								width: 110,
								labelWidth: '50',
								listWidth: 150,
								name: 'id_banco',
								forceSelection: false,
								store: new Ext.data.JsonStore({
								url: 'php/pesquisa_banco.php?acao=1',
								root: 'resultados',
								fields: [ 'id_banco', 'nome_banco' ]
								}),
									hiddenName: 'id_banco',
									valueField: 'id_banco',
									displayField: 'nome_banco',
									fireKey : function(e){//evento de tecla   
										if(e.getKey() == e.ENTER) {//precionar enter   
										  // document.getElementById('grupo').focus();
										}}

							},
							{
							xtype:'textfield',
							fieldLabel: 'Agencia',
							name: 'ClienteRec',
							labelWidth: '50',
							col: true
							},
							{
							xtype:'textfield',
							fieldLabel: 'Cuenta',
							name: 'cuenta',
							labelWidth: '45',
							col: true
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
							fieldLabel: 'Moneda',
							minChars: 2,
							labelWidth: '50',
							name: 'moeda',
							emptyText: 'Moneda',
							width: 110,
							forceSelection: true,
							store: [
									 ['gurani', 'Guaranies'],
									 ['dolar', 'Dolares'],
									 ['real', 'Reais']
									 ]
							},
							{
							xtype:'textfield',
							fieldLabel: 'Cheque N.',
							name: 'cuenta',
							labelWidth: '65',
							col: true
							},
							{
							xtype:'moneyfield',
							fieldLabel: '<b>Valor</b>',
							name: 'vlCheque',
							labelWidth: '45',
							col: true,
							fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
									Ext.Ajax.request({ 
									waitMsg: 'Executando...',
									url: 'php/contas_receber.php',
									params: { 
											idPagare: idPagare,
											idVenda: idVenda,
											acao: 'Receber',
											valor: formRecValor.getForm().findField('vlReceber').getValue()  
											},
									success: function(result, request){//se ocorrer correto 
									var jsonData = Ext.util.JSON.decode(result.responseText);
									if(jsonData.response == 'Recebido'){
													Ext.MessageBox.alert('Aviso','Recebido.'); //aki uma funcao se necessario);
													storeContRec.reload(); 
													};
									if(jsonData.response == 'Nopodesrecibir'){
													Ext.MessageBox.alert('Aviso','No podes recibir monto mayor que la deuda.'); //aki uma funcao se necessario);
													};
											}, 
											failure:function(response,options){
												Ext.MessageBox.alert('Alerta', 'Erro...');
													}         
												}) 
											}	
										}  
							},
							{
							bodyStyle:'padding:0px 15px 0'
							}
						
							
						
						]
						},
						{
							xtype       : 'fieldset',
							title       : 'Datos de Cobranca',
							layout      : 'form',
							collapsible : false,                    
							collapsed   : false,
							autoHeight  : true,
							//width		: 230,
							forceLayout : true,
							items: [
							{
							xtype:'datefield',
							fieldLabel: 'Emissao',
							name: 'emissao',
							labelWidth: '55',
							col: true
							},
							{
							xtype:'datefield',
							fieldLabel: 'Validade',
							name: 'validade',
							labelWidth: '55',
							col: true
							},
							{
							xtype:'textfield',
							fieldLabel: 'Emissor',
							name: 'emissor',
							width: 260,
							labelWidth: '50',
							},
							{
							xtype:'textfield',
							fieldLabel: 'Ruc',
							name: 'ruc',
							labelWidth: '20',
							labelWidth: '50',
							col:true
							}							
							]
							},
							{
							xtype:'label',
							text: '* Recurso disponivel brevemente'
							}
						
						],
				buttons	: [
							{
							text : 'Gravar',
							disabled: true
							},
							{
							text : 'Cancelar',
							handler: function(){
							winCheques.close();
							}							
							}
							]
						
	  }); 



winCheques = new Ext.Window({
		title: 'Catastro de Cheques',
		width:600,
		autoHeight: true,
		shim:true,
		closable : true,
		resizable: false,
		closeAction: 'hide',
		draggable: true, //Movimentar Janela
		plain: true,
		modal: true, //Bloquear tela do fundo
		items:[formCadCheques]
		
		});
winCheques.show();
		
}