// JavaScript Document



DespesaContas = function(){

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
			//	if(n.attributes.leaf){
				formpanelConta.getForm().findField('Cuenta').setValue(n.attributes.cod);
				idnode = n.attributes.id;
				cod = n.attributes.cod;
				
			//	}
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
			    			CodForn: formFornecedor.getForm().findField('idFornecedor').getValue()
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
		
		var imprimirContasPDF = function(idnode){
		idnode = idnode;
		dtini = formpanelConta.getForm().findField('datainicial').getValue();
		dtini = dtini.format("Y-m-d");
		dtfim = formpanelConta.getForm().findField('datafinal').getValue();
		dtfim = dtfim.format("Y-m-d");
			if(idnode.length > 0){	
																			
			var win_ContasPDF = new Ext.Window({
								id: 'imprimePedido',
								title: 'Pedido',
								width: 650,
								height: 500,
								shim: false,
								animCollapse: false,
								constrainHeader: true,
								maximizable: false,
								layout: 'fit',
								items: { html: "<iframe height='100%' width='100%' src='../relatorio_contas.php?idnode="+idnode +"&dtini="+dtini +"&dtfim="+dtfim +"' > </iframe>" },
								buttons: [
											{
											text: 'Cerrar',
											handler: function(){ // fechar	
											win_ContasPDF.destroy();
											}
						 
										}]
							});
							win_ContasPDF.show();
			}
			else{
			Ext.MessageBox.alert('Alerta', 'Favor elejir un plan de cuenta');
			}
		}
	
		var dsDespContas = new Ext.data.GroupingStore({
		proxy: new Ext.data.HttpProxy({
			url: 'php/RelContas.php',
			method: 'POST'
		}),
		baseParams:{
			acao: 'ListarDesp'
			},
		groupField:'informe',
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
				   {name: 'informe'},
				   {name: 'totalGeral'}
				
			]
		),
		sortInfo: {field: 'id_lanc_despesa', direction: 'DESC'},
		remoteSort: true,
		autoLoad: false
	});
	 // define a custom summary function
    Ext.grid.GroupSummary.Calculations['totalGeral'] = function(v, record, field){
		return v + (parseFloat(record.data.valor));
    }

    var summary = new Ext.grid.GroupSummary(); 
	 var gridDespesas = new Ext.grid.EditorGridPanel({
	        store: dsDespContas, 
	        columns:
		        [
						{id:'id_lanc_despesa',header: "id_lanc_despesa", hidden: true, width: 2, sortable: true, dataIndex: 'id_lanc_despesa'},
						{header: "Informe", hidden: true, width: 2, sortable: true, dataIndex: 'informe'},
						{header:'Plano Conta', width: 200, sortable: true, dataIndex: 'nome_despesa'},
						{header: "Documento", width: 80, sortable: true, dataIndex: 'documento'},
						{header: "Dt Lancamento", width: 90, align: 'left', sortable: true, dataIndex: 'dt_lanc_desp'},
						{header: "Usuario", width: 80, align: 'right', sortable: true, dataIndex: 'nome_user'},	        
						{header: "Fornecedor", width: 150, align: 'left', sortable: true, dataIndex: 'nome'},
						{id: 'valor', header: "Valor", width: 90, align: 'right', sortable: true, groupable: false, dataIndex: 'valor', 
						renderer: function(v, params, record){
							return Ext.util.Format.usMoney(parseFloat(record.data.valor));
								
							},
						name: 'totalGeral',
						dataIndex: 'totalGeral',
						summaryType:'totalGeral',
						fixed:true,
						summaryRenderer: Ext.util.Format.usMoney}
			 ],
	       view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true
        }),
			plugins: [summary],
			autoWidth: true,
			stripeRows : true,
			autoHeight: true,
		//	autoScroll: true,
		//	height: 400,
			ds: dsDespContas,
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			tbar : new Ext.Toolbar({
			align:'left',
         	buttons: [	
           				{
           			    text: 'Imprimir Consulta',
						align: 'left',
						iconCls: 'icon-pdf',
            			handler: function(){ // fechar	
						if(typeof idnode != 'undefined')
     	    			imprimirContasPDF(idnode);
						}
  			 			},
						'-'
			]
			})
	});

	var formpanelConta = new Ext.FormPanel({
		title: 'Plano de Contas'
		,id:'formpanel'
		,closable: true
		,layout:'border'
		,width:600
		//,height:400
		,items:[{
				region:'center'
				,layout:'form'
				,frame:true
				,autoScroll: true
				//,autoHeight: true
				,border:false
				,items:[{
				region:'center'
				,layout:'form'
				,height: 100
				,frame:true
				,labelWidth: 50
				,border:false
				,items:[
					{
					xtype: 'datefield',
					fieldLabel: 'Data incial',
					name: 'datainicial',
				//	id: 'datainicial',
					labelWidth:65,
					width: 100
				    },
				    {
				    xtype: 'datefield',
				    fieldLabel: 'Data final',
				    name: 'datafinal',
				    //  id: 'datafinal',
				    width: 100,
				    labelWidth:65,
				    col: true
				    },
				    {
					xtype: 'textfield',
				    name: 'Cuenta',							
				    fieldLabel: '<b>Cuenta</b>',
					labelWidth: 50,
				    width: 200
					},
					{
					xtype: 'button',
					text: 'Pesquisar',
					name: 'buscarlcto',
					col:true,
					handler: function(){ 
						dtini = formpanelConta.getForm().findField('datainicial').getValue();
						dtfim = formpanelConta.getForm().findField('datafinal').getValue();
						dsDespContas.load(({params:{'acao': 'LctoDespesas', 'contaid': idnode, 'dataini':dtini, 'datafim':dtfim}}));
			  		}
					}
				
				]
				},{
				region:'south'
				,title: 'Lanzamientos de la cuenta'
			//	,id: 'plan'
				,layout:'fit'
				,border:false
			//	,height: 630
			//	,autoScroll: true
			//	,autoHeight: true
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
		
	
	
	
Ext.getCmp('tabss').add(formpanelConta);
Ext.getCmp('tabss').setActiveTab(formpanelConta);
formpanelConta.doLayout();	
/*
Ext.getCmp('sul').add(gridDespesas);
Ext.getCmp('sul').setActiveTab(gridDespesas);
gridDespesas.doLayout();	
*/
}