// JavaScript Document


CadCidades = function(){

/*	if(perm.CadGrupos.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}
*/
    Ext.QuickTips.init();
    Ext.form.Field.prototype.msgTarget = 'side';


var Receita = function(value){
	
	if(value==2)
		  return 'Saida';
		else if(value==1)
		  return 'Entrada';
		else
		  return 'Desconhecido'; 

};

var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Por favor selecione um Registro');
}

var PrecoGrupo;
var selectedKeys;
var cad_grupos;
var NovaCidade;
var print_grupos;
var gruposel;
var relatorioCidade;

//////////INICIO DA STORE ////////////////////
var dsCidades = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/CadCidades.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Cidades',
			totalProperty: 'totalcidades',
			id: 'idcidade'
		},
			[
			{name: 'idcidade'},
			{name: 'nomecidade'}
			]
		),
		sortInfo: {field: 'nomecidade', direction: 'ASC'},
		remoteSort: true		
	});
//////// FIM STORE //////////////
//////// INICIO DA GRID  ////////
 var grid_Cidades = new Ext.grid.EditorGridPanel(
	    {
	        store: dsCidades, // use the datasource
	        
	        columns:
		        [
						{id:'idcidade',header: "Codigo", width: 20, sortable: true, dataIndex: 'idcidade'},	        
						{header: "Cidade", width: 200, align: 'left', sortable: true, dataIndex: 'nomecidade',
						editor: new Ext.form.TextField({
														 allowBlank: false,
														 selectOnFocus:true,
														 allowNegative: false	
														 })
						}
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
			height: 300,
			autoScroll: true,
			ds: dsCidades,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dsCidades,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Nao tem dados",
				pageSize: 8,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina", 
				items:[],
				refreshText : "Atualizar",
				paramNames : {start: 'start', limit: 'limit'},
				items:[
				/*{
                    xtype:'button',
					text: 'Produtos do Grupo',
					style: 'margin-left:7px',
					iconCls: 'icon-print',
					handler: function(){
						relatorioCidade();
						
						/*	
						Ext.Ajax.request(
							{
								url:'print_produtos.php',
								params:{data: Ext.encode(dslistaProd.reader.jsonData.Produtos)}
						function popup(){
						window.open('../impressao.php?id_pedido='+1 +'','popup','width=750,height=500,scrolling=auto,top=0,left=0')
								}
						popup();
										
					
					}
					}
					*/
					]
			}),
			tbar: [
			   {
				text: 'Novo',
				iconCls:'icon-add',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
						NovaCidade.show();
						} 
				},
				{
				text: 'Excluir',
				iconCls:'icon-delete',
				tooltip: 'Clique para excluir um registro',
				handler: function(){
						selectedKeys = grid_Cidades.selModel.selections.keys;
						if(selectedKeys.length > 0){	
 						selectedRows = grid_Cidades.selModel.selections.items;
 						selectedKeys = grid_Cidades.selModel.selections.keys; 
						Ext.Ajax.request({
           				   		url: '../php/CadCidades.php', 
           					 	params : {
									acao: 'excluir',
               						idcidade: selectedKeys
            						},
									callback: function (options, success, response) {
										if (success) { 
											//Ext.MessageBox.alert('Aviso', response.responseText);   
											var json = Ext.util.JSON.decode(response.responseText);
											if(json.response == 'CidadeExcluida'){
												dsCidades.reload();
												Ext.MessageBox.alert('Aviso', 'Registro Excluido com Sucesso');
											}
											if(json.response == 'LancamentoExistente'){
												Ext.MessageBox.alert('Impossivel', 'Ha Obras Cadastradas Com Essa Cidade');
											}
										}
										}
									
										});
								
						}
						else{
							selecione();
							}
					
					} 
					}	
			],
			listeners:{ 
        	afteredit:function(e){
			dsCidades.load(({params:{valor: e.value, acao: 'alterar', idcidade: e.record.get('idcidade'), campo: e.column,  'start':0, 'limit':100}}));
	  		}
			}
		
});

dsCidades.load(({params:{'idcidade':1, 'start':0, 'limit':200}}));





 var FormCidades= new Ext.FormPanel({
            title       : 'Cadastro de Cidades',
			labelAlign: 'top',
			id			: 'FormCidades',
            closable	: true,
			frame		: true,
            split       : true,
            autoWidth   : true,
			closeAction: 'destroy',
			layout		: 'form',
			items:[grid_Cidades],
			listeners: {
						destroy: function() {
						//	if(PrecoGrupo instanceof Ext.Window)
                       //     PrecoGrupo.destroy(); 
						//	if(NovoGrupo instanceof Ext.Window)
						//	NovoGrupo.destroy(); 
         				}
			         }
        }); 
 FormCidades.on('destroy', function(){
				 setTimeout(function(){
				 if(NovaCidade instanceof Ext.Window)
				 NovaCidade.destroy(); 
		     	  }, 250);
			  })
 

 FormCadCidade= new Ext.FormPanel({
            title       : 'Cadastrar Nova Cidade',
			frame		: true,
            split       : true,
            autoWidth   : true,
			closeAction: 'destroy',
			layout		: 'form',
			autoHeight	: true,
			items:[
				   {
                    xtype:'textfield',
                    fieldLabel: 'Nome Cidade',
					id: 'nomecidade',
                    name: 'nomecidade',
                    width: 250
					}
					
					]		
        }); 


var relatorioCidade = function(){
var selectedKeys = grid_Cidades.selModel.selections.keys;
if(selectedKeys.length > 0){		

var selectedRows = grid_Cidades.selModel.selections.items;
var selectedKeys = grid_Cidades.selModel.selections.keys; 
	
var win_relatorio_cidade = new Ext.Window({
					id: 'win_relatorio_cidade',
					title: 'Obras en Andamento',
					width: 650,
					height: 500,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='../obras_cidade.php?grupo="+selectedKeys+"' > </iframe>"},
					buttons: [
           						{
            					text: 'Sair',
            					handler: function(){ // fechar	
     	    					win_relatorio_cidade.destroy();
  			 					}
			 
        					}]
				});
win_relatorio_cidade.show();
}
else{
selecione();
}			
}

if (NovaCidade == null){
				NovaCidade = new Ext.Window({
					id:'NovaCidade'
	                ,layout: 'form'
	                , width: 400
					, height: 130
	                , closeAction :'hide'
	                , plain: true
					, resizable: true
					, modal: true
					, items:[FormCadCidade]
					,focus: function(){
 	    						Ext.get('nomecidade').focus();
									}
					,buttons: [
								{
            					text: 'Gravar',
            					handler: function(){ // fechar	
									FormCadCidade.getForm().submit({
									url: "php/CadCidades.php"
									, params : {
									  acao: 'novacidade'
									}
									, waitMsg: 'Cadastrando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
									}); 
								function OnSuccess(form,action){
								dsCidades.reload();
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
     	    					NovaCidade.hide();
								FormCadCidade.getForm().reset();
								}
  			 					}
							]					

				});
			}

Ext.getCmp('tabss').add(FormCidades);
Ext.getCmp('tabss').setActiveTab(FormCidades);
FormCidades.doLayout();	
			

}