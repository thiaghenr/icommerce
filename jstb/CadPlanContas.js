// JavaScript Document

PlanContas = function(){


if(perm.CadPlanContas.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}

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

var cad_plan_contas;
var NovoPlan;


//////////INICIO DA STORE ////////////////////
var dsPlanContas = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/CadPlanContas.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Planos',
			totalProperty: 'totalPlanos',
			id: 'despesa_id'
		},
			[
			{name: 'despesa_id'},
			{name: 'nome_despesa'},
			{name: 'receita_id'},
			]
		),
		sortInfo: {field: 'despesa_id', direction: 'ASC'},
		remoteSort: true		
	});
//////// FIM STORE //////////////
//////// INICIO DA GRID  ////////
 var grid_PlanContas = new Ext.grid.EditorGridPanel(
	    {
	        store: dsPlanContas, // use the datasource
	        
	        columns:
		        [
						{id:'despesa_id',header: "Codigo", width: 20, sortable: true, dataIndex: 'despesa_id'},	        
						{header: "nome_despesa", width: 200, align: 'left', sortable: true, dataIndex: 'nome_despesa',
						editor: new Ext.form.TextField({
														 allowBlank: false,
														 selectOnFocus:true,
														 allowNegative: false	
														 })
						},
						{id:'receita_id',header: "Receita", width: 50, dataIndex: 'receita_id', renderer: Receita}
			
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth:true,
			height: 300,
			ds: dsPlanContas,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dsPlanContas,
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
				paramNames : {start: 'start', limit: 'limit'}
			}),
			tbar: [
			   {
				text: 'Novo',
				iconCls:'icon-add',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
						NovoPlan.show();
						} 
				},
				{
				text: 'Excluir',
				iconCls:'icon-delete',
				tooltip: 'Clique para excluir um registro',
				handler: function(){
						selectedKeys = grid_PlanContas.selModel.selections.keys;
						if(selectedKeys.length > 0){	
 						selectedRows = grid_PlanContas.selModel.selections.items;
 						selectedKeys = grid_PlanContas.selModel.selections.keys; 
						Ext.Ajax.request({
           				   		url: '../php/CadPlanContas.php', 
           					 	params : {
									acao: 'excluir',
               						idDespesa: selectedKeys,
									user: id_usuario
            						},
									callback: function (options, success, response) {
										if (success) { 
											//Ext.MessageBox.alert('Aviso', response.responseText);   
											var json = Ext.util.JSON.decode(response.responseText);
											if(json.response == 'PlanoExcluido'){
												dsPlanContas.reload();
												Ext.MessageBox.alert('Aviso', 'Plano Excluido com Sucesso');
											}
											if(json.response == 'LancamentoExistente'){
												Ext.MessageBox.alert('Impossivel', 'Ha Despesas Cadastrada Com Esse Plano');
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
			dsPlanContas.load(({params:{valor: e.value, acao: 'alterar', idDespesa: e.record.get('despesa_id'), campo: e.column,  'start':0, 'limit':100}}));
	  		}
			}
		
});

dsPlanContas.load(({params:{'id':1, 'start':0, 'limit':200}}));





 var FormPlanContas= new Ext.FormPanel({
            title       : 'Plano de Contas',
			labelAlign: 'top',
			layout: 'form',
			frame		: true,
			closable	: true,
            split       : true,
            autoWidth   : true,
			items:[grid_PlanContas],
			listeners: {
						destroy: function() {
							if(NovoPlan)
                             NovoPlan.destroy();
         				}
			         }
        }); 

var FormCadPlan= new Ext.FormPanel({
            title       : 'Cadastrar Novo Plano de Contas',
			frame		: true,
            split       : true,
            autoWidth   : true,
			autoHeight	: true,
            collapsible : false,
			items:[
				   {
                    xtype:'textfield',
                    fieldLabel: 'Nome Despesa',
					id: 'nome_despesa',
                    name: 'nome_despesa',
                    width: 250
					},
					{
                    xtype:'textfield',
                    fieldLabel: 'Receita Tipo',
					id: 'receita',
                    name: 'receita',
					value: 'Saida',
					readOnly: true,
                    width: 250
					}
					]		
        }); 




if (NovoPlan == null){
				NovoPlan = new Ext.Window({
					id:'NovoPlan'
	                , layout: 'form'
	                , width: 400
					, height: 150
	                , closeAction :'hide'
	                , plain: true
					, resizable: false
					, modal: false
					, items:[FormCadPlan]
					,focus: function(){
 	    						Ext.get('nome_despesa').focus();
									}
					,buttons: [
								{
            					text: 'Gravar',
            					handler: function(){ // fechar	
									FormCadPlan.getForm().submit({
									url: "php/CadPlanContas.php"
									, params : {
									  acao: 'novoPlano'
									}
									, waitMsg: 'Cadastrando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
									}); 
								function OnSuccess(form,action){
								dsPlanContas.reload();
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
     	    					NovoPlan.hide();
								FormCadPlan.getForm().reset();
								}
  			 					}
							]					

				});
			}



Ext.getCmp('tabss').add(FormPlanContas);
Ext.getCmp('tabss').setActiveTab(FormPlanContas);
FormPlanContas.doLayout();	
			
}