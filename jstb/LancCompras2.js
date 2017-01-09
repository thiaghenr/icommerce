// JavaScript Document



LancCompras = function(){




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
								 EndForn = forn.endereco;
								 Ext.getCmp('NomForn').setValue(nomeFornec);
								 Ext.getCmp('ender').setValue(EndForn);
								 Ext.getCmp('fatura').focus();
								 
								 }
								 else{ 
								 Ext.getCmp('NomeFn').setValue();
								 Ext.MessageBox.alert('Aviso', 'Fornecedor nao encontrado'); }
								 
								}
							});
						}
	
			var dsCompras = new Ext.data.Store({
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

						
	var formCompras = new Ext.FormPanel({
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
				fieldLabel: 'Codigo',
				labelWidth: 70,
				allowBlank: false,
				width: 100,
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
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				dataField: ['idforn','nomeforn', 'EndForn'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Fornecedor	',
				id: 'NomForn',
				minChars: 2,
				name: 'NomForn',
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
						Ext.getCmp('IdForne').setValue(idforn);
						Ext.getCmp('ender').setValue(ender);
						Ext.getCmp('fatura').focus();
					}
							
                },
				{
				xtype:'textfield',
				fieldLabel: 'Endereco',
				labelWidth: 70,
				width: 300,
				name: 'ender',
				id: 'ender',
				readOnly: true,
				col: true
				},
				{
				xtype:'textfield',
				fieldLabel: 'Numero da Fatura',
				labelWidth: 100,
				width: 100,
				name: 'fatura',
				id: 'fatura',
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('datafatura').focus();
						}
				}
				},
				{
				xtype:'datefield',
				fieldLabel: 'Data Fatura',
				labelWidth: 70,
				width: 100,
				allowBlank: false,
				name: 'datafatura',
				id: 'datafatura',
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('valortotal').focus();
						}
				}
				},
				new Ext.ux.MaskedTextField({
				fieldLabel: 'Valor Total',
				mask:'decimal',
				textReverse : true,
				width: 100,
				allowBlank: false,
				name: 'valortotal',
				id: 'valortotal',
				col: true,
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('BtnGravar').focus();
						}
				}
				}),
				{
				xtype: 'checkbox',
				fieldLabel: 'A vista',
				labelAlign: 'right',
				id: 'ckb',
				checked: true,
				col: true,
				handler: function() {
            				if (this.checked){
							Ext.getCmp('BtnVenc').setDisabled(true);
							}
							else{
							Ext.getCmp('BtnVenc').setDisabled(false);	
							}
						}
				},
				{
				xtype:'button',
				text: 'Informar Vencimentos',
				id: 'BtnVenc',
				disabled: true,
				iconCls: 'icon-periodo',
				labelWidth: 70,
				width: 150,
				handler:function(){
					Ext.getCmp('ckb').setDisabled(true);
					addField();
					formCompras.doLayout();
				}
				},
				{
				xtype:'button',
				text: 'Gravar',
				id: 'BtnGravar',
				iconCls: 'icon-save',
				col: true,
				handler:function(){
					formCompras.getForm().submit({
										url: "php/LancCompras.php",
										params: {
												user: id_usuario,
												acao: 'Cadastra',
												auto: auto
										}
										, waitMsg: 'Cadastrando'
										, waitTitle : 'Aguarde....'
										, scope: this
										, success: OnSuccess
										, failure: OnFailure
									}); 
								function OnSuccess(form,action){
										Ext.Msg.alert('Confirmacao', action.result.msg);
										Ext.getCmp('tabss').remove(formCompras);
										LancCompras();
									//	dsDespesas.reload();
									}
								function OnFailure(form,action){
									//	alert(action.result.msg);
									}

								}
				},
				{
					style: 'margin-top:10px',
					float:'left'
					 },gridCompras
				]
				
});

 var auto = 0;
    while(auto < 0){
        addField();
    }
    function addField(){
        formCompras.add(
{
layout:'column',
labelAlign: 'top',
items:[
	   {
	   columnWidth:.2,
       layout: 'form',
	   labelAlign: 'top',
       items: [
				{
				xtype: 'datefield',
				autoDestroy: true,
            	fieldLabel: 'Parcela ' + (++auto),
				id : 'Data' + (auto),
				width: 100,
				labelAlign: 'left'
				}
			]
	  },
	 {
	 columnWidth:.2,
	 layout: 'form',
	 labelAlign: 'top',
	 items: [
			new Ext.ux.MaskedTextField({
            fieldLabel: 'Valor ',
			id : 'Vlparc' + (auto),
			width: 100,
			mask:'decimal',
			textReverse : true,
			labelAlign: 'left'
	   		})
			]
	}
			]
			}
	   		
			
			);				
    }	
	
	

		


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