// JavaScript Document



LancCompras = function(){


var fatura;

	Ext.form.Field.prototype.msgTarget = 'side';
	//Ext.form.FormPanel.prototype.bodyStyle = 'padding:5px';
	//Ext.form.FormPanel.prototype.labelAlign = 'right';
	Ext.QuickTips.init();

	var action = new Ext.ux.grid.RowActions({
    header:'Excluir'
 //  ,anchor: '10%'
  ,width: 15
  ,autoWidth: false
   ,actions:[{
       iconCls:'icon-excluir'
      ,tooltip:'Excluir'
	//  ,width: 1
   }] 
});

action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	  compra = record.data.id_compra;
	  Ext.Ajax.request({ 
			waitMsg: 'Executando...',
			url: 'php/LancCompras.php',		
			params: { 
					compra: compra,
					acao: 'deletacompra'
					},
			callback: function (options, success, response) {
					  if (success) { 
									Ext.MessageBox.alert('Aviso', response.responseText);
								   } 
					},
					failure:function(response,options){
						Ext.MessageBox.alert('Alerta', 'Erro...');
					},                                      
					success:function(response,options){
					if(response.responseText == 'Operacao realizada com sucesso'){
					dsCompras.reload();
							}
					}                                      
		})
   }
});


var actionDel = new Ext.ux.grid.RowActions({
	header:'Excluir'
	//  ,anchor: '10%'
	,width: 15
	,autoWidth: false
	,actions:[{
       iconCls:'icon-excluir'
      ,tooltip:'Excluir'
	//  ,width: 1
   }] 
});
actionDel.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	  idpgto = record.data.idcompra_pgto;
	  pgto_id = record.data.pgto_id;
	  Ext.Ajax.request({ 
			waitMsg: 'Executando...',
			url: 'php/LancCompras.php',		
			params: { 
					idCompra: idcompranova,
					idpgto: idpgto,
					acao: 'deletapago',
					pgto_id: pgto_id
					},
			callback: function (options, success, response) {
										if (success) { 
											//Ext.MessageBox.alert('OK', response.responseText);
											var jsonData = Ext.util.JSON.decode(response.responseText);
											if(jsonData.response){
											Ext.MessageBox.alert('Pagos:', jsonData.response);
											dsCompraPgto.load(({params:{acao: 'ListaPgto', idcompranova: idcompranova,  'start':0, 'limit':5}}));
											dsCompraPgto.remove(record);
											}
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										}                        
		})
   }
});

var FornCompras = function(){
   						Ext.Ajax.request({
           					url: 'php/LancDespesa.php',
							remoteSort: true,
           					params: {
							acao: 'fornCod',
							user: id_usuario,
			    			CodForn: Ext.getCmp("IdForne").getValue()
            					},
								success: function(response){//se ocorrer correto 
								var jsonData = Ext.decode(response.responseText);
								 forn = Ext.decode( response.responseText);
								 if(forn){
								 nomeFornec = forn.nome;
								 idforn = forn.controle;
								 EndForn = forn.endereco;
								 Ext.getCmp('NomForn').setValue(nomeFornec);
								 Ext.getCmp('ender').setValue(EndForn);
								 Ext.getCmp('IdForne').setValue(idforn);
								 Ext.getCmp('fatura').focus();
								 
								 }
								 else{ 
								 Ext.getCmp('NomeFn').setValue();
								 Ext.MessageBox.alert('Aviso', 'Fornecedor nao encontrado'); }
								 
								}
							});
						}

var NovaCompra = function(){
   						Ext.Ajax.request({
           					url: 'php/LancCompras.php',
							remoteSort: true,
           					params: {
							acao: 'NovaCompra',
							user: id_usuario
            					},
								success: function(response){//se ocorrer correto 
								var jsonData = Ext.decode(response.responseText);
								 CompraNova = Ext.decode( response.responseText);
								 if(CompraNova){
								 idcompranova = CompraNova.idcompranova;
								 formCompras.getForm().findField('compranova').setValue(idcompranova);
								 formCompras.getForm().items.each(function(itm){itm.setDisabled(false)});

							//	 Ext.getCmp('fatura').focus();
								 
								 }
								 else{ 
								 Ext.getCmp('NomeFn').setValue();
								 Ext.MessageBox.alert('Aviso', 'Intente logar se otra vez'); }
								 
								}
							});
						}						
		dsCompras = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/LancCompras.php',
			method: 'POST'
		}),
		baseParams:{
			acao: 'ListarCompras'
			},
		reader:  new Ext.data.JsonReader({
			root: 'Compras',
			id: 'id_compra'
		},
			[		
				   {name: 'action', type: 'string'},
				   {name: 'id_compra'},
				   {name: 'status'},
				   {name: 'nm_fatura'},
		           {name: 'dt_emissao_fatura'},
		           {name: 'vl_total_fatura'},
		           {name: 'data_lancamento'},
				   {name: 'nome_user'},
				   {name: 'nome'}
				
			]
		),
		sortInfo: {field: 'id_lanc_despesa', direction: 'DESC'},
		remoteSort: true,
		autoLoad: true
	});
	 var gridCompras = new Ext.grid.GridPanel({
	        store: dsCompras, 
	        columns:
		        [
						action,
						{id:'id_compra',header: "id_compra", hidden: true, width: 2, sortable: true, dataIndex: 'id_compra'},
						{header:'Nome', width: 200, sortable: true, dataIndex: 'nome'},
						{header: "Documento", width: 80, sortable: true, dataIndex: 'nm_fatura'},
						{header: "Dt Lancamento", width: 90, align: 'left', sortable: true, dataIndex: 'data_lancamento'},
						{header: "Dt Fatura", width: 80, align: 'left', sortable: true, dataIndex: 'dt_emissao_fatura'},
						{header: "Usuario", width: 80, align: 'right', sortable: true, dataIndex: 'nome_user'},	
						{header: "Status", width: 80, align: 'center', sortable: true, dataIndex: 'status'},							
						{header: "Total", width: 90, align: 'right', sortable: true, dataIndex: 'vl_total_fatura', renderer: 'usMoney'}
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				autoExpandColumn: true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
			plugins: [action],
		//	id: 'gridCompras',
			stripeRows : true,
			height: 150,
			ds: dsCompras,
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			closable: true,
			title: 'Ultimas Compras'
	});

		dsCompraPgto = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/LancCompras.php',
			method: 'POST'
		}),
		reader:  new Ext.data.JsonReader({
			root: 'PgtoCompras',
			totalProperty: 'totalpgto',
			id: 'idcompra_pgto'
		},
			[		
				   {name: 'action', type: 'string'},
				   {name: 'idcompra_pgto'},
				   {name: 'compra_id'},
				   {name: 'pgto_id'},
		           {name: 'vltotal_compra'},
		           {name: 'vlpgto'},
		           {name: 'status'},
				   {name: 'nome_user'},
				   {name: 'tipo_pgto_descricao'}
				
			]
		),
		sortInfo: {field: 'idcompra_pgto', direction: 'DESC'},
		remoteSort: true
	});
	
		 var gridCompraPgto = new Ext.grid.GridPanel({
	        store: dsCompraPgto, 
	        columns:
		        [
						{id:'idcompra_pgto',header: "idcompra_pgto", hidden: true, width: 2, sortable: true, dataIndex: 'idcompra_pgto'},
						{header:'Compra', width: 40, sortable: true, dataIndex: 'compra_id'},
						{header: "pgto_id", width: 80, sortable: true, hidden: true, dataIndex: 'pgto_id'},
						{header: "Total Compra", width: 60, align: 'left', sortable: true, dataIndex: 'vltotal_compra', renderer: 'usMoney'},
						{header: "Total Pgto", width: 80, align: 'left', sortable: true, dataIndex: 'vlpgto', renderer: 'usMoney'},
						{header: "Usuario", width: 80, align: 'right', hidden: true, sortable: true, dataIndex: 'nome_user'},	
						{header: "Status", width: 80, align: 'center', hidden: true, sortable: true, dataIndex: 'status'},							
						{header: "Tipo Pgto", width: 60, align: 'right', sortable: true, dataIndex: 'tipo_pgto_descricao'},
						actionDel

			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				autoExpandColumn: true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			width: 550,
			plugins: [actionDel],
			stripeRows : true,
			height: 180,
			ds: dsCompraPgto,
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			closable: true,
			//title: 'Pagamientos',
			tbar : new Ext.Toolbar({
			align:'left',
         	buttons: [	
						{
						xtype: 'label',
						text: 'Pagamientos: ',
						style: 'font-weight:bold;color:yellow;text-align:left;' 
						},
						/*
           				{
           			    text: 'Excluir',
						id: 'esc',
						align: 'left',
						iconCls: 'icon-excluir',
            			handler: function(){ // fechar	
     	    			deletarPedido();
						}
						}
						*/
						{
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
					width: 100,
					col: true,
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_tpgto.php',
					method: 'POST',
					remoteSort: true,
           			baseParams:{
							formapgto: 0
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
						fatura = formCompras.getForm().findField('fatura').getValue();
						vlcompra = formCompras.getForm().findField('valortotal').getValue();
						emissaofat = formCompras.getForm().findField('datafatura').getValue();
						if(idtipo_pagamento == 2){
							var abrewinentradacheque = function(){Ext.Load.file('jstb/saida_cheque.js', function(obj, item, el, cache){saida_cheque(vlcompra,fatura,emissaofat);},this)}
							abrewinentradacheque();
							this.collapse();
							this.setValue(tipo_pgto_descricao);
						}
						if(idtipo_pagamento == 3){
						tipopgto = "tarjeta";
						}
						if(idtipo_pagamento == 1){
							var abrewinentradacrediario = function(){Ext.Load.file('jstb/saida_crediario.js', function(obj, item, el, cache){saida_crediario(vlcompra,fatura,emissaofat);},this)}
							abrewinentradacrediario();
							//tipopgto = "crediario";
						this.collapse();
						this.setValue(tipo_pgto_descricao);
						}
						if(idtipo_pagamento == 4){
							var abrewinentradaespecie = function(){Ext.Load.file('jstb/saida_especie.js', function(obj, item, el, cache){saida_especie(vlcompra,fatura,emissaofat);},this)}
							abrewinentradaespecie();
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
				'-'
				
			]
		}),
		bbar : new Ext.Toolbar({ 
			items: [
						'-',
						{
						xtype:'button',
						text: 'Nueva Compra',
						iconCls: 'icon-add',
						id: 'novacompra',
						labelWidth: 70,
						handler:function(){
							NovaCompra();
							this.setDisabled(true);
						}
						},
						'-',
						{
						xtype:'button',
						text: 'Gravar',
						id: 'BtnGravar',
						iconCls: 'icon-save',
						col: true,
						handler:function(){
						if(restante == '0'){	
							// Extraindo os dados do Grid
							var jsonData = [];
							// Percorrendo o Store do Grid para resgatar os dados
							dsCompraPgto.each(function( record ){
							// Recebendo os dados
							jsonData.push( record.data );
								});
							jsonData = Ext.encode(jsonData);
							Ext.Ajax.request({
								url: 'php/LancCompras.php',
								method: 'POST',
								remoteSort: true,
								params: {
								acao: 'CadPagos', 
								user: id_usuario,
								dados: jsonData,
								host: host,
								total_nota: vlcompra,
								idCompra: idcompranova,
								nmfatura: fatura,
								idforn: idforn,
								emissaofat: emissaofat
								},
								callback: function (options, success, response) {
										if (success) { 
											//Ext.MessageBox.alert('OK', response.responseText);
											var jsonData = Ext.util.JSON.decode(response.responseText);
											if(jsonData.cheques > 0 || jsonData.crediario > 0 || jsonData.vista > 0 ){
											Ext.MessageBox.alert('Pagos:', '<strong>Cheques: </strong>'+ jsonData.cheques +'<br />'+
																					   '<strong>Crediario:  </strong>'+ jsonData.crediario  +'<br />'+
																					   '<strong>Al Contado:  </strong>'+ jsonData.vista, function(btn){
												if(btn == "ok"){
													dsCompras.load({params: {acao: 'ListarCompras'}});
													formCompras.getForm().items.each(function(itm){itm.setDisabled(false)});
													Ext.getCmp('novacompra').setDisabled(false);
													dsCompraPgto.removeAll();
													formCompras.form.reset();
													idcompranova = 0;
													fatura = 0;
												} });
											
											}
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										}
								});

								}
							else{
								Ext.MessageBox.alert('Erro','Verifique Total.');
							}
							}
						},
						'-',
						{
						xtype: 'label',
						text: 'Restante: ',
						style: 'font-weight:bold;color:yellow;text-align:left;' 
						}
						,
						{
						xtype:'textfield',
						fieldLabel: 'Restante',
						name: 'RestantePgto',
						id: 'RestantePgto',
						labelWidth: 40,
						readOnly: true,
						width: 120
						}
						
					]
			})
		});
	
	dsCompraPgto.on('load', function(grid, record, action, row, col, store, rowIndex) {
		 
		valor =  formCompras.getForm().findField('valortotal').getValue();
		valor = valor.replace(/\./g,"");
		
		//console.log(dsCompraPgto.getTotalCount());
		parcial = dsCompraPgto.getTotalCount();
		
		restante = parseFloat(valor) - parseFloat(parcial);
		Ext.getCmp('RestantePgto').setValue(restante);
		
		 });
						
	 formCompras = new Ext.FormPanel({
        labelAlign: 'top',
		//id: 'formCompras',
        frame: true,
        title: 'Entrada Compras',
		//width: 400,
		height: 310,
		tabWidth: '100%',
		closable: true,
		autoScroll: true,
		border : true,
		layout: 'form',
        items: [
				{
				xtype:'textfield',
				fieldLabel: 'Compra',
				labelWidth: 70,
				width: 50,
				name: 'compranova',
				readOnly: true
				},
				
				{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				dataField: ['idforn','nomeforn', 'EndForn'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Proveedor',
				id: 'NomForn',
				minChars: 2,
				name: 'NomForn',
				width: 200,
                resizable: true,
                listWidth: 300,
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
						Ext.getCmp('IdForne').setValue(idforn);
						Ext.getCmp('ender').setValue(ender);
					}
							
                },
				{
				xtype:'textfield',
				fieldLabel: 'Codigo',
				labelWidth: 70,
				allowBlank: false,
				width: 100,
				col: true,
				name: 'IdForne',
				id: 'IdForne',
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER && Ext.get('IdForne').getValue() != '') {
							CodForn = Ext.getCmp('IdForne').getValue();
							setTimeout(function(){
							//
							 }, 250);
							FornCompras();
				   //nav.form.findField('fin')setDisabled(false);
						}
						if(e.getKey() == e.ENTER && Ext.getCmp('IdForne').getValue() === '') {
							Ext.Msg.alert('Alerta', 'Erro, Entre com o Codigo');
						}	
					}
				},
				{
				xtype:'textfield',
				fieldLabel: 'Direccion',
				labelWidth: 70,
				width: 300,
				name: 'ender',
				id: 'ender',
				readOnly: true,
				col: true
				},
				{
				xtype:'textfield',
				fieldLabel: 'Numero Factura',
				labelWidth: 100,
				width: 100,
				name: 'fatura',
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('datafatura').focus();
						}
				}
				},
				{
				xtype:'datefield',
				fieldLabel: 'Fecha Factura',
				labelWidth: 70,
				width: 100,
				col: true,
				allowBlank: false,
				name: 'datafatura',
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('valortotal').focus();
						}
				}
				},
				new Ext.ux.MaskedTextField({
				fieldLabel: 'Total - Guaranies',
				labelWidth: 300,
				mask:'decimal',
				textReverse : true,
				width: 100,
				allowBlank: false,
				name: 'valortotal',
			//	value: '200000.00',
				col: true,
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('BtnGravar').focus();
						}
				}
				}),
				{
					style: 'margin-top:20px',
					float:'left'
					 },gridCompraPgto,gridCompras
				]
				
});

 

formCompras.getForm().items.each(function(itm){itm.setDisabled(true)});
//myFormPanel.buttons.forEach(function(btn){btn.setDisabled(true);}); //disable all 		


Ext.getCmp('tabss').add(formCompras);
Ext.getCmp('tabss').setActiveTab(formCompras);
formCompras.doLayout();	
Ext.getCmp('IdForne').focus();
/*
Ext.getCmp('sul').add(gridCompras);
Ext.getCmp('sul').setActiveTab(gridCompras);
gridCompras.doLayout();	
*/	
}