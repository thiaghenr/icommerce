// JavaScript Document


tipoPgto = function(){


		 var formTipoPgto = new Ext.FormPanel({
			frame: true,
			labelAlign: 'left',
			bodyStyle:'background-color:#4e79b2',
			width       : '100%',
			height      : 268,
			items: [{
                    xtype:'combo',
					typeAhead: true,
					lazyRender: true,
					hideTrigger: false,
					allowBlank: false,
					emptyText: 'Selecione',
					editable: false,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idtipo_pagamento','tipo_pgto_descricao'],
					loadingText: 'Consultando Banco de Dados',
					fieldLabel: 'Tipo Pgto',
				//	id: 'formaPgto',
					name: 'tipoPago',
					anchor:'80%',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_tpgto.php',
					method: 'POST',
					remoteSort: true,
           			baseParams:{
							formapgto:idforma
							},
					root: 'resultados',
					fields: [ 'idtipo_pagamento', 'tipo_pgto_descricao' ]
					}),
						hiddenName: 'idtipo_pagamento',
						valueField: 'idtipo_pagamento',
						displayField: 'tipo_pgto_descricao',
					onSelect: function(record){
						idtipo_pagamento = record.data.idtipo_pagamento;
						//console.info(idtipo_pagamento);
						tipo_pgto_descricao = record.data.tipo_pgto_descricao;
						if(idtipo_pagamento == 2){
							var abrewinentradacheque = function(){Ext.Load.file('jstb/entrada_cheque.js', function(obj, item, el, cache){ent_cheque();},this)}
							abrewinentradacheque();
							this.collapse();
							this.setValue(tipo_pgto_descricao);
						}
						if(idtipo_pagamento == 3){
						tipopgto = "tarjeta";
						}
						if(idtipo_pagamento == 1){
						tipopgto = "crediario";
						this.collapse();
						this.setValue(tipo_pgto_descricao);
						}
						if(idtipo_pagamento == 4){
						tipopgto = "contado";
						this.collapse();
						this.setValue(tipo_pgto_descricao);
						}
						else{
						this.collapse();
						this.setValue(tipo_pgto_descricao);
						}
						
					}


							
                },
				
				{
					style: 'margin-top:80px',
					float:'left'
					 },
				/*   INFORMAR DADOS DO FATURAMENTO ANTES DE CONFIRMAR
				{
					xtype       : 'fieldset',
					title       : 'Datos de Facturacion',
					labelAlign: 'top',
					layout      : 'form',
					collapsible : false,                    
					collapsed   : false,
					autoHeight  : true,
					items:[]
					},
				*/
			   			{
						xtype:'button',
           			    text: 'Confirmar',
						style   : 'padding-left:95px;',
						scale: 'large',
						iconCls: 'icon-save',
            			handler: function(){ // fechar	
						//console.info(tipopgto);
							if(typeof tipopgto != 'undefined'){
								if(tipopgto == 'tarjeta'){
									Ext.MessageBox.alert('Alerta', 'Forma de Pago no Disponible');
								}
								else{
								FaturaPedido(tipopgto);
								}
							}
							else{
								Ext.MessageBox.alert('Alerta', 'Favor Elejir Forma de Pago');
							}
						}
						
  			 			}
			   ]
			});
			



	   winTipoPgto = new Ext.Window({
				title: 'Confirmacion',
				width:300,
				height:270,
				//autoWidth: true,
				//autoHeight: true,
				plain: true,						
				collapsible: false,
				resizable: false,
				closeAction:'hide',
				closable: true,
				modal: true,
				border: false,
				items: [formTipoPgto],
				focus: function(){
				//	Ext.get('queryPedidoprod').focus(); 
				}			
			})
winTipoPgto.show();





//Ext.getCmp('tabss').add(FormMarcas);
//Ext.getCmp('tabss').setActiveTab(FormMarcas);
//FormMarcas.doLayout();	
			

}