// JavaScript Document


CadDepositos = function(){
/*	if(perm.CadGrupos.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}
*/
    Ext.QuickTips.init();
    Ext.form.Field.prototype.msgTarget = 'side';


var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Por favor selecione um Registro');
}

var PrecoGrupo;
var selectedKeys;
var cad_depositos;
var NovoDeposito;
var print_depositos;
var depositosel;
var win_relatorio_deposito;

//////////INICIO DA STORE ////////////////////
var dsDepositos = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/Depositos.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Depositos',
			totalProperty: 'totaldepositos',
			id: 'iddepositos'
		},
			[
			{name: 'iddepositos'},
			{name: 'nomedep'},
			{name: 'resp'},
			{name: 'dataini'},
			]
		),
		sortInfo: {field: 'iddepositos', direction: 'ASC'},
		remoteSort: true		
	});
//////// FIM STORE //////////////
//////// INICIO DA GRID  ////////
 var grid_Depositos = new Ext.grid.EditorGridPanel(
	    {
	        store: dsDepositos, // use the datasource
	        
	        columns:
		        [
						{id:'iddepositos',header: "Codigo", width: 20, sortable: true, dataIndex: 'iddepositos'},	        
						{header: "nomedep", width: 200, align: 'left', sortable: true, dataIndex: 'nomedep',
						editor: new Ext.form.TextField({
														 allowBlank: false,
														 selectOnFocus:true,
														 allowNegative: false	
														 })
						},
						{header: "resp", width: 200, align: 'left', sortable: true, dataIndex: 'resp'},
						{id:'dataini',header: "Cadastro", width: 50, dataIndex: 'dataini'}
			
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
			//id: 'despesa_id',
			height: 300,
			ds: dsDepositos,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dsDepositos,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Nao tem dados",
				pageSize: 200,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina", 
				items:[],
				refreshText : "Atualizar",
				paramNames : {start: 'start', limit: 'limit'},
				items:[{
                    xtype:'button',
					text: 'Itens do Deposito',
					style: 'margin-left:7px',
					iconCls: 'icon-print',
					handler: function(){
						relatorioGrupo();
						
						/*	
						Ext.Ajax.request(
							{
								url:'print_produtos.php',
								params:{data: Ext.encode(dslistaProd.reader.jsonData.Produtos)}
						function popup(){
						window.open('../impressao.php?id_pedido='+1 +'','popup','width=750,height=500,scrolling=auto,top=0,left=0')
								}
						popup();
					*/					
					
					}
					}]
			}),
			tbar: [
			   {
				text: 'Nuevo Deposito',
				iconCls:'icon-add',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
						NovoDeposito.show();
						} 
				},
				'-',
				{
				text: 'Excluir',
				iconCls:'icon-delete',
				tooltip: 'Clique para excluir um registro',
				handler: function(){
						selectedKeys = grid_Depositos.selModel.selections.keys;
						if(selectedKeys.length > 0){	
 						selectedRows = grid_Depositos.selModel.selections.items;
 						selectedKeys = grid_Depositos.selModel.selections.keys; 
						Ext.Ajax.request({
           				   		url: '../php/Depositos.php', 
           					 	params : {
									acao: 'excluir',
               						iddeposito: selectedKeys
            						},
									callback: function (options, success, response) {
										if (success) { 
											//Ext.MessageBox.alert('Aviso', response.responseText);   
											var json = Ext.util.JSON.decode(response.responseText);
											if(json.response == 'DepositoExcluido'){
												dsDepositos.reload();
												Ext.MessageBox.alert('Aviso', 'Deposito Excluido com Sucesso');
											}
											if(json.response == 'LancamentoExistente'){
												Ext.MessageBox.alert('Impossivel', 'Ha Itens Cadastrados Com Esse Deposito');
											}
										}
										}
									
										});
								
						}
						else{
							selecione();
							}
					
					} 
					},
					'-',
					{
				text: 'Transferir Mercaderia',
				iconCls:'ico-app-go',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
				Ext.Load.file('jstb/transf_prod.js', function(obj, item, el, cache){TransfProds();},this)}
				}
			],
			listeners:{ 
        	afteredit:function(e){
			dsGrupos.load(({params:{valor: e.value, acao: 'alterar', idGrupo: e.record.get('id'), campo: e.column,  'start':0, 'limit':100}}));
	  		}
			}
		
});

dsDepositos.load(({params:{'id':1, 'start':0, 'limit':200}}));


 var FormDepositos= new Ext.FormPanel({
            title       : 'Depositos',
			labelAlign: 'top',
			id			: 'FormDepositos',
            closable	: true,
			frame		: true,
            split       : true,
            autoWidth   : true,
			closeAction: 'destroy',
			layout		: 'form',
			items:[grid_Depositos],
			listeners: {
						destroy: function() {
						//	if(PrecoGrupo instanceof Ext.Window)
                       //     PrecoGrupo.destroy(); 
						//	if(NovoGrupo instanceof Ext.Window)
						//	NovoGrupo.destroy(); 
         				}
			         }
        }); 
 FormDepositos.on('destroy', function(){
				 setTimeout(function(){
				 if(NovoDeposito instanceof Ext.Window)
				 NovoDeposito.destroy(); 
		     	  }, 250);
			  })
 

 FormCadDepositos= new Ext.FormPanel({
			frame		: true,
            split       : true,
            autoWidth   : true,
			closeAction: 'destroy',
			layout		: 'form',
		//	autoHeight	: true,
			items:[
				   {
                    xtype:'textfield',
                    fieldLabel: 'Nome Deposito',
                    name: 'nomedep',
                    width: 250
					},
					{
                    xtype:'textfield',
                    fieldLabel: 'Local Fisico',
                    name: 'localdep',
                    width: 250
					},
					{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				dataField: ['idforn','nomeforn'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Responsable',
			//	id: 'nomeforn',
				minChars: 2,
				name: 'nomeforn',
				width: 250,
                resizable: true,
                listWidth: 350,
				forceSelection: true,
				store: new Ext.data.JsonStore({
				url: 'php/LancDespesa.php?acao_nome=fornNome',
				root: 'resultados',
				fields: [ 'idforn', 'nomeforn' ]
				}),
					hiddenName: 'idforn',
					valueField: 'idforn',
					displayField: 'nomeforn',
					fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
						//  Ext.getCmp('documento').focus();
						}
					},
					onSelect: function(record){
						idforn = record.data.idforn;
						nomeforn = record.data.nomeforn;
						this.collapse();
						this.setValue(nomeforn);
			//      	Ext.getCmp('idFornecedor').setValue(idforn);
					}
							
                }
				
					
					]		
        }); 

var relatorioDepositos = function(){
var selectedKeys = grid_Depositos.selModel.selections.keys;
if(selectedKeys.length > 0){		

var selectedRows = grid_Depositos.selModel.selections.items;
var selectedKeys = grid_Depositos.selModel.selections.keys; 
	
var win_relatorio_depositos = new Ext.Window({
					id: 'relatario_depositos_prod',
					title: 'Relatorio de Depositos',
					width: 650,
					height: 500,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='../produtos_deposito.php?grupo="+selectedKeys+"' > </iframe>"},
					buttons: [
           						{
            					text: 'Sair',
            					handler: function(){ // fechar	
     	    					win_relatorio_depositos.destroy();
  			 					}
			 
        					}]
				});
win_relatorio_depositos.show();
}
else{
selecione();
}			
}


if (NovoDeposito == null){
				NovoDeposito = new Ext.Window({
					id:'NovoDeposito'
					,title       : 'Cadastrar Novo Deposito'
	                ,layout: 'form'
	                , width: 400
	                , closeAction :'hide'
	                , plain: true
					, resizable: true
					, modal: true
					, items:[FormCadDepositos]
					,focus: function(){
 	    					//	Ext.get('nomedep').focus();
									}
					,buttons: [
								{
            					text: 'Gravar',
            					handler: function(){ // fechar	
									FormCadDepositos.getForm().submit({
									url: "php/Depositos.php"
									, params : {
									  acao: 'novodeposito'
									}
									, waitMsg: 'Cadastrando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
									}); 
								function OnSuccess(form,action){
								dsDepositos.reload();
								Ext.MessageBox.alert("Confirma&ccedil;&atilde;o!",action.result.response);
								};
			
								function OnFailure(form,action){
								Ext.MessageBox.alert(action.result.msg);
								};
								
									}
        						},
								{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					NovoDeposito.hide();
								FormCadDeposito.getForm().reset();
								}
  			 					}
							]					

				});
			}

Ext.getCmp('tabss').add(FormDepositos);
Ext.getCmp('tabss').setActiveTab(FormDepositos);
FormDepositos.doLayout();	
			

}