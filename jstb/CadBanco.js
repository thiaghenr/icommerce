CadastroBancos = function(){

//////////INICIO DA STORE ////////////////////
var dsBancos = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/CadBanco.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'resultados',
			totalProperty: 'totalBancos',
			id: 'idconta_bancaria'
		},
			[
			{name: 'id_banco'},
			{name: 'nome_banco'},
			{name: 'codigo_banco'}
			]
		),
		sortInfo: {field: 'id_banco', direction: 'ASC'},
		remoteSort: true		
	});
//////// FIM STORE //////////////
//////// INICIO DA GRID  ////////
 var grid_Bancos = new Ext.grid.EditorGridPanel(
	    {
	        store: dsBancos, // use the datasource
	        
	        columns:
		        [
						{id:'id_banco',header: "Num.", align: 'right', width: 20, sortable: true, dataIndex: 'id_banco'},	        
						{header: "Codigo", width: 70, align: 'left',align: 'right', sortable: true, dataIndex: 'codigo_banco'},
						{header: "Banco", width:130, align: 'left', sortable: true, dataIndex: 'nome_banco'}
			
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
			height: 300,
			ds: dsBancos,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dsBancos,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Nao tem dados",
				pageSize: 5,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina", 
				items:[],
				refreshText : "Atualizar",
				paramNames : {start: 0, acao:'ListaBancos', limit: 5},
				items:[]
			}),
			tbar: [
			   {
				text: 'Cadastrar Banco',
				iconCls:'icon-add',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
						NovoBanco.show();
						} 
				}
			],
			listeners:{ 
        	afteredit:function(e){
			dsBancos.load(({params:{valor: e.value, acao: 'alterar', idGrupo: e.record.get('id'), campo: e.column,  'start':0, 'limit':5}}));
	  		}
			}
		
});
dsBancos.load(({params:{'id':1, 'acao':'ListaBancos', 'start':0, 'limit':5}}));


		FormCadBanco = new Ext.FormPanel({
			frame		: true,
            split       : true,
            autoWidth   : true,
			layout		: 'form',
			items:[
					 {
                    xtype:'textfield',
                    fieldLabel: 'Codigo Banco',
					labelWidth: 50,
                    name: 'CodigoBanco',
                    width: 100
					},
				   {
                    xtype:'textfield',
                    fieldLabel: 'Banco',
					labelWidth: 50,
                    name: 'Banco',
                    width: 200
					}
					]		
        }); 

				NovoBanco = new Ext.Window({
	                  layout: 'form'
	                , width: 600
					, title: 'Catastrar Nuevo Banco'
					//, height: 200
					, autoHeight	: true
	                , closeAction :'hide'
	                , plain: true
					, modal: true
					, items:[FormCadBanco]
					,focus: function(){
 	    					//	Ext.get('nome_grupo').focus();
									}
					,buttons: [
								{
            					text: 'Gravar',
								iconCls:'icon-save',
            					handler: function(){ // fechar	
									FormCadBanco.getForm().submit({
									url: "php/CadBanco.php"
									, params : {
									  acao: 'NovoBanco',
									  user: id_usuario
									}
									, waitMsg: 'Cadastrando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
									}); 
								function OnSuccess(form,action){
								dsBancos.reload();
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
								NovoBanco.hide();
								FormCadBanco.getForm().reset();
								}
								}
							]
				});


var FormBancos = new Ext.FormPanel({
            title       : 'Bancos',
			labelAlign: 'top',
            closable	: true,
			frame		: true,
            split       : true,
            autoWidth   : true,
			closeAction: 'destroy',
			layout		: 'form',
			items:[grid_Bancos],
			listeners: {
						destroy: function() {
						//	if(PrecoGrupo instanceof Ext.Window)
                       //     PrecoGrupo.destroy(); 
						//	if(NovoGrupo instanceof Ext.Window)
						//	NovoGrupo.destroy(); 
         				}
			         }
        }); 
		
		
		
Ext.getCmp('tabss').add(FormBancos);
Ext.getCmp('tabss').setActiveTab(FormBancos);
FormBancos.doLayout();	
			

}