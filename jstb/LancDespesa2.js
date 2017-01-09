// JavaScript Document



LancDespesa = function(){

	Ext.form.Field.prototype.msgTarget = 'side';
	//Ext.form.FormPanel.prototype.bodyStyle = 'padding:5px';
	//Ext.form.FormPanel.prototype.labelAlign = 'right';
	Ext.QuickTips.init();
	Ext.ns('Ext.ux.tree');
	
	var treePlano = new Ext.tree.TreePanel({
    id:'treePlano'
    ,autoScroll:true
    ,rootVisible:false
    ,root:{
    nodeType:'async'
    ,id:'root'
    ,text:'Plano de Contas'
    ,expanded:true
    }
    ,loader: {
    url:'php/PlanoContas.php'
    ,baseParams:{
    cmd:'getChildren'
    ,treeTable:'tree2'
    ,treeID:1
	,acao: 'despesa'
    }
    },
	listeners: {
            click: function(n) {
                //Ext.Msg.alert('Navigation Tree Click', 'You clicked: "' + n.attributes.text + '"');
				if(n.attributes.leaf === true){
				formFornecedor.getForm().findField('nomedesp').setValue(n.attributes.cod);
				idnode = n.attributes.id;
				cod = n.attributes.cod;
				}
				else{
				formFornecedor.getForm().findField('nomedesp').setValue("");
				}
            }
        }
    ,plugins:[new Ext.ux.state.TreePanel()]
    }); // eo tree
	 
var SelectForn = function(){
   						Ext.Ajax.request({
           					url: 'php/LancContas.php',
							remoteSort: true,
           					params: {
							acao: 'fornCod',
							user: id_usuario,
			    			CodForn: Ext.getCmp("idFornecedor").getValue()
            					},
								success: function(response){//se ocorrer correto 
								var jsonData = Ext.decode(response.responseText);
								 forn = Ext.decode( response.responseText);
								 if(forn){
								 nomeFornec = forn.nome;
								 Ext.getCmp('nomeforn').setValue(nomeFornec);
								 Ext.getCmp('nomedesp').focus();
								 
								 }
								 else{ 
								 Ext.getCmp('nomeforn').setValue();
								 Ext.MessageBox.alert('Aviso', 'Fornecedor nao encontrado'); }
								 
								}
							});
						}
	
		var dsDespesas = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/LancContas.php',
			method: 'POST'
		}),
		baseParams:{
			acao: 'ListarDesp'
			},
		reader:  new Ext.data.JsonReader({
			root: 'Despesas',
			id: 'id_lanc_despesa'
		},
			[
				   {name: 'id_lanc_despesa'},
				   {name: 'nome_despesa'},
		           {name: 'documento'},
		           {name: 'dt_lanc_desp'},
		           {name: 'venc_desp'},
		           {name: 'desc_desp'},
				   {name: 'valor'},
				   {name: 'nome_user'},
				   {name: 'nome'},
				   {name: 'valor_total'}
				
			]
		),
		sortInfo: {field: 'id_lanc_despesa', direction: 'DESC'},
		remoteSort: true,
		autoLoad: true
	});
	 var gridDespesas = new Ext.grid.GridPanel({
	        store: dsDespesas, 
	        columns:
		        [
						{id:'id_lanc_despesa',header: "id_lanc_despesa", hidden: true, width: 2, sortable: true, dataIndex: 'id_lanc_despesa'},
						{header:'Plano Conta', width: 200, sortable: true, dataIndex: 'nome_despesa'},
						{header: "Documento", width: 80, sortable: true, dataIndex: 'documento'},
						{header: "Dt Lancamento", width: 90, align: 'left', sortable: true, dataIndex: 'dt_lanc_desp'},
						{header: "Vencimento", width: 80, align: 'left', sortable: true, dataIndex: 'venc_desp'},
						{header: "Descricao", width: 150, align: 'left', sortable: true, dataIndex: 'desc_desp'},
						{header: "Valor", width: 90, align: 'right', sortable: true, dataIndex: 'valor', renderer: 'usMoney'},
						{header: "Usuario", width: 80, align: 'right', sortable: true, dataIndex: 'nome_user'},	        
						{header: "Fornecedor", width: 150, align: 'left', sortable: true, dataIndex: 'nome'},
						{header: "Total", width: 90, align: 'right', sortable: true, dataIndex: 'valor_total', renderer: 'usMoney'}
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				autoExpandColumn: true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
			id: 'gridDespesas',
			stripeRows : true,
			height: 150,
			ds: dsDespesas,
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			closable: true
	});

						
	var formFornecedor = new Ext.FormPanel({
        labelAlign: 'top',
		id: 'formFornecedor',
        frame: true,
        title: 'Lancar Cuenta',
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
				name: 'idFornecedor',
				id: 'idFornecedor',
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER && Ext.get('idFornecedor').getValue() != '') {
							CodForn = Ext.getCmp('idFornecedor').getValue();
							setTimeout(function(){
							//
							 }, 250);
							SelectForn();
				   //nav.form.findField('fin')setDisabled(false);
						}
						if(e.getKey() == e.ENTER && Ext.getCmp('idFornecedor').getValue() === '') {
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
				dataField: ['idforn','nomeforn', 'endereco'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Entidade',
				id: 'nomeforn',
				minChars: 2,
				name: 'nomeforn',
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
					fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
						  Ext.getCmp('documento').focus();
						}
					},
					onSelect: function(record){
						idforn = record.data.idforn;
						nomeforn = record.data.nomeforn;
						this.collapse();
						this.setValue(nomeforn);
						Ext.getCmp('idFornecedor').setValue(idforn);
					}
							
                },
				{
				xtype:'textfield',
				fieldLabel: 'Cuenta',
				emptyText: 'Seleccione la cuenta',
				labelWidth: 100,
				allowBlank: false,
				readOnly: true,
				width: 250,
				col: true,
				name: 'nomedesp',
				id: 'nomedesp',
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('dtfatura').focus();
						}
				}
				},
				{
				xtype:'textfield',
				fieldLabel: 'Documento',
				labelWidth: 100,
				width: 100,
				//col: true,
				name: 'documento',
				id: 'documento',
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('dtfatura').focus();
						}
				}
				},
				{
				xtype:'datefield',
				fieldLabel: 'Data Fatura',
				labelWidth: 70,
				width: 100,
				allowBlank: false,
				name: 'dtfatura',
				id: 'dtfatura',
				col: true,
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('vltotal').focus();
						}
				}
				},
				new Ext.ux.MaskedTextField({
				fieldLabel: 'Valor Total',
				mask:'decimal',
				textReverse : true,
				width: 100,
				allowBlank: false,
				name: 'vltotal',
				id: 'vltotal',
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('obsDesp').focus();
						}
				}
				}),
				{
				xtype: 'checkbox',
				fieldLabel: 'Al Contado',
				labelAlign: 'right',
				id: 'ckbVista',
				checked: true,
				col: true,
				handler: function() {
            				if (this.checked){
							Ext.getCmp('btnVenc').setDisabled(true);
							}
							else{
							Ext.getCmp('btnVenc').setDisabled(false);	
							}
						}
				},
				{
				xtype:'textfield',
				fieldLabel: 'Observacao',
				labelWidth: 70,
				width: 350,
				name: 'obsDesp',
				id: 'obsDesp'
			//	col: true
				},
				{
				xtype:'button',
				text: 'Informar Vencimentos',
				id: 'btnVenc',
				disabled: true,
				iconCls: 'icon-periodo',
				labelWidth: 70,
				width: 150,
				col: true,
				scale: 'large',
				handler:function(){
					Ext.getCmp('ckbVista').setDisabled(true);
					addText();
					formFornecedor.doLayout();
				}
				},
				{
				xtype:'button',
				text: 'Gravar',
				id: 'btnGravar',
				iconCls: 'icon-save',
				scale: 'large',
				col: true,
				handler:function(){
					formFornecedor.getForm().submit({
										url: "php/LancContas.php",
										params: {
												user: id_usuario,
												acao: 'Cadastra',
												index: index,
												idnode: idnode
										}
										, waitMsg: 'Cadastrando'
										, waitTitle : 'Aguarde....'
										, scope: this
										, success: OnSuccess
										, failure: OnFailure
									}); 
								function OnSuccess(form,action){
										Ext.Msg.alert('Confirmacao', action.result.msg);
										Ext.getCmp('tabss').remove(formFornecedor);
										LancDespesa();
										dsDespesas.reload();
										formFornecedor.getForm().reset();
									}
								function OnFailure(form,action){
									//	alert(action.result.msg);
									}

								}
				},
				{
					style: 'margin-top:10px',
					float:'left'
					 }
			   ]
	});

 var index = 0;
    while(index < 0){
        addText();
    }
    function addText(){
        formFornecedor.add(
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
            	fieldLabel: 'Parcela ' + (++index),
				id : 'data' + (index),
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
			id : 'vlparc' + (index),
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
	

		var formpanel = new Ext.Panel({
		title: 'Plano de Contas'
		,id:'formpanel'
		,closable: true
		,layout:'border'
		,width:600
		,height:400
		,items:[{
				region:'center'
				,layout:'border'
				,frame:true
				,border:false
				,items:[{
				region:'center'
				,layout:'fit'
				,height: 200
				,frame:true
				,border:false
				,items:[formFornecedor]
				},{
				region:'south'
				,title: 'Ultimos Lanzamientos'
				,id: 'plan'
				,collapsible: true
				,collapsed: true
				,layout:'form'
				,border:false
				,height: 200
				,frame:true
				,items:[gridDespesas]
				}]
				},{
				region:'west'
				,layout:'fit'
				,frame:true
				,border:false
				,width:320
				,split:true
				,title: 'Cuentas'
				,collapsible:true
				,collapseMode:'mini'
				,items:[treePlano]
			}]
		});
		
	
	
	
Ext.getCmp('tabss').add(formpanel);
Ext.getCmp('tabss').setActiveTab(formpanel);
formpanel.doLayout();	
Ext.getCmp('idFornecedor').focus();
/*
Ext.getCmp('sul').add(gridDespesas);
Ext.getCmp('sul').setActiveTab(gridDespesas);
gridDespesas.doLayout();	
*/
}