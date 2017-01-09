// JavaScript Document


CadMarcas = function(){

//	if(perm.CadMarcas.acessar == 0){
//return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
//}

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

var PrecoMarca;
var selectedKeys;
var cad_marcas;
var NovoMarca;
var print_marcas;
var marcasel;
var win_relatorio_marca;


storePrecoMarca = new Ext.data.SimpleStore({
        fields: ['sitReajusteC','sitReajusteD'],
        data: [
            ['Alta', 'Alta'],
            ['Baixa', 'Baixa']
			
        ]
    });



//////////INICIO DA STORE ////////////////////
var dsMarcas = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/CadMarcas.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Marcas',
			totalProperty: 'totalMarcas',
			id: 'id'
		},
			[
			{name: 'id'},
			{name: 'nom_marca'},
			{name: 'data'},
			]
		),
		sortInfo: {field: 'id', direction: 'ASC'},
		remoteSort: true		
	});
//////// FIM STORE //////////////
//////// INICIO DA GRID  ////////
 var grid_Marcas = new Ext.grid.EditorGridPanel(
	    {
	        store: dsMarcas, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "Codigo", width: 20, sortable: true, dataIndex: 'id'},	        
						{header: "nom_marca", width: 200, align: 'left', sortable: true, dataIndex: 'nom_marca',
						editor: new Ext.form.TextField({
														 allowBlank: false,
														 selectOnFocus:true,
														 allowNegative: false	
														 })
						},
						{id:'data',header: "Cadastro", width: 50, dataIndex: 'data'}
			
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
			//id: 'despesa_id',
			height: 300,
			ds: dsMarcas,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dsMarcas,
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
					text: 'Produtos da Marca',
					style: 'margin-left:7px',
					iconCls: 'icon-print',
					handler: function(){
						relatorioMarca();
						
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
				text: 'Novo',
				iconCls:'icon-add',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
						NovoMarca.show();
						} 
				},
				{
				text: 'Excluir',
				iconCls:'icon-delete',
				tooltip: 'Clique para excluir um registro',
				handler: function(){
						selectedKeys = grid_Marcas.selModel.selections.keys;
						if(selectedKeys.length > 0){	
 						selectedRows = grid_Marcas.selModel.selections.items;
 						selectedKeys = grid_Marcas.selModel.selections.keys; 
						Ext.Ajax.request({
           				   		url: '../php/CadMarcas.php', 
           					 	params : {
									acao: 'excluir',
               						idMarca: selectedKeys
            						},
									callback: function (options, success, response) {
										if (success) { 
											//Ext.MessageBox.alert('Aviso', response.responseText);   
											var json = Ext.util.JSON.decode(response.responseText);
											if(json.response == 'MarcaExcluido'){
												dsMarcas.reload();
												Ext.MessageBox.alert('Aviso', 'Marca Excluido com Sucesso');
											}
											if(json.response == 'LancamentoExistente'){
												Ext.MessageBox.alert('Impossivel', 'Ha Produtos Cadastrados Com Esse Marca');
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
					{
				text: 'Reajuste de Precos',
				iconCls:'icon-reajuste',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
						PrecoMarcaAlt();
						} 
				}
			],
			listeners:{ 
        	afteredit:function(e){
			dsMarcas.load(({params:{valor: e.value, acao: 'alterar', idMarca: e.record.get('id'), campo: e.column,  'start':0, 'limit':100}}));
	  		}
			}
		
});

dsMarcas.load(({params:{'id':1, 'start':0, 'limit':200}}));





 var FormMarcas= new Ext.FormPanel({
            title       : 'Cadastro de Marcas',
			labelAlign: 'top',
			id			: 'FormMarcas',
            closable	: true,
			frame		: true,
            split       : true,
            autoWidth   : true,
			closeAction: 'destroy',
			layout		: 'form',
			items:[grid_Marcas],
			listeners: {
						destroy: function() {
						//	if(PrecoMarca instanceof Ext.Window)
                       //     PrecoMarca.destroy(); 
						//	if(NovoMarca instanceof Ext.Window)
						//	NovoMarca.destroy(); 
         				}
			         }
        }); 
 FormMarcas.on('destroy', function(){
				 if(PrecoMarca instanceof Ext.Window)
                 PrecoMarca.destroy(); 
				 setTimeout(function(){
				 if(NovoMarca instanceof Ext.Window)
				 NovoMarca.destroy(); 
		     	  }, 950);
			  })
 

 FormCadMarca= new Ext.FormPanel({
            title       : 'Cadastrar Novo Marca',
			frame		: true,
            split       : true,
            autoWidth   : true,
			closeAction: 'destroy',
			layout		: 'form',
			autoHeight	: true,
			items:[
				   {
                    xtype:'textfield',
                    fieldLabel: 'Nome Marca',
					id: 'nome_marca',
                    name: 'nome_marca',
                    width: 250
					}
					
					]		
        }); 

var FormPrecoMarca= new Ext.FormPanel({
            //title       : 'Reajuste de Precos no Marca',
			frame		: true,
            split       : true,
            autoWidth   : true,
			autoHeight	: true,
            collapsible : false,
			items:[
				   
				   comboReajustaMarca = new Ext.form.ComboBox({
                    name: 'sitReajusta',
                    id: 'sitReajusta',
                    store: storePrecoMarca,//origem dos dados
                    fieldLabel: 'Reajuste',
                    allowBlank: false, //permitir ou n�o branco, ser� validado ao sair do campo.
                    displayField: 'sitReajusteD', //campo a ser exibido, de acordo com o mapemanto feito no objeto store
                    hiddenName: 'sitReajustaVal', //nome do campo Hidden que ser� criado automaticamente para receber o valor do item selecionado no combobox
                    typeAhead: true, //auto-selecionar o combo de acordo com o texto digitado
                    valueField: 'sitReajusteC',
                    mode: 'local', //localiza��o da origem dos dados.
                    forceSelection: true,//for�ar que s� digite texto que exista em um dos itens. False para permitir qualquer texto.
                    triggerAction: 'all',
                    emptyText: 'Selecione', //texto a ser exibido quando n�o possuir item selecionado
                    selectOnFocus: true, //selecionar o texto ao receber foco
	                blankText : 'Selecione', 
                    width: 100,
					listeners:{select:{fn:function(combo, value) {
						 combos = combo.getValue();
          			}}}

                	}),
                    new Ext.ux.MaskedTextField({
                    fieldLabel: 'Margen A  %',
					mask:'decimal',
					textReverse : true,
					id: 'AmargenReajuste',
                    name: 'AmargenReajuste',
                    width: 120
					}),
                    new Ext.ux.MaskedTextField({
                    fieldLabel: 'Margen B  %',
					mask:'decimal',
					textReverse : true,
					id: 'BmargenReajuste',
                    name: 'BmargenReajuste',
                    width: 120
					}),
                    new Ext.ux.MaskedTextField({
                    fieldLabel: 'Margen C  %',
					mask:'decimal',
					textReverse : true,
					id: 'CmargenReajuste',
                    name: 'CmargenReajuste',
                    width: 120
					}),
					{
					style: 'padding-top:10px',
					float:'left'
					 }
					]		
        }); 

var relatorioMarca = function(){
var selectedKeys = grid_Marcas.selModel.selections.keys;
if(selectedKeys.length > 0){		

var selectedRows = grid_Marcas.selModel.selections.items;
var selectedKeys = grid_Marcas.selModel.selections.keys; 
	
var win_relatorio_marca = new Ext.Window({
					id: 'relatario_marca_prod',
					title: 'Relatorio de Produtos',
					width: 650,
					height: 500,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='../produtos_marca.php?marca="+selectedKeys+"' > </iframe>"},
					buttons: [
           						{
            					text: 'Sair',
            					handler: function(){ // fechar	
     	    					win_relatorio_marca.destroy();
  			 					}
			 
        					}]
				});
win_relatorio_marca.show();
}
else{
selecione();
}			
}

 PrecoMarcaAlt = function(){
 selectedKeys = grid_Marcas.selModel.selections.keys;
 if(selectedKeys.length > 0){		

 selectedRows = grid_Marcas.selModel.selections.items;
 selectedKeys = grid_Marcas.selModel.selections.keys; 


if (PrecoMarca == null){
				PrecoMarca = new Ext.Window({
					title       : 'Reajuste de Precos na Marca' 
					, id:'PrecoGrupo'
	                , layout: 'form'
	                , width: 400
					, autoHeight: true
	                , closeAction :'hide'
	                , plain: true
					, resizable: false
					, modal: true
					, items:[FormPrecoMarca]
					,focus: function(){
 	    						Ext.get('AmargenReajuste').focus();
									}
					,buttons: [
								{
            					text: 'Gravar',
            					handler: function(){ // fechar	
									FormPrecoMarca.getForm().submit({
									url: "php/CadMarcas.php"
									, params : {
									  acao: 'alteraPrecos',
									  idMarca: selectedKeys
									}
									, waitMsg: 'Cadastrando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
									}); 
								function OnSuccess(form,action){
								Ext.MessageBox.alert("Confirma&ccedil;&atilde;o!",action.result.response);
								};
			
								function OnFailure(form,action){
								Ext.MessageBox.alert('Aviso', 'Selecione o tipo de Reajuste');
								};
								
									}
        						},
								{
            					text: 'Fechar',
            					handler: function(){ // fechar	
     	    					PrecoMarca.hide();
								FormPrecoMarca.getForm().reset();
								}
  			 					}
							]					

				});
			}
PrecoMarca.show();
}
else{
selecione();
}			
}




if (NovoMarca == null){
				NovoMarca = new Ext.Window({
					id:'NovoMarca'
	                ,layout: 'form'
	                , width: 400
					, height: 130
	                , closeAction :'hide'
	                , plain: true
					, resizable: true
					, modal: true
					, items:[FormCadMarca]
					,focus: function(){
 	    						Ext.get('nome_marca').focus();
									}
					,buttons: [
								{
            					text: 'Gravar',
            					handler: function(){ // fechar	
									FormCadMarca.getForm().submit({
									url: "php/CadMarcas.php"
									, params : {
									  acao: 'novoMarca'
									}
									, waitMsg: 'Cadastrando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
									}); 
								function OnSuccess(form,action){
								dsMarcas.reload();
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
     	    					NovoMarca.hide();
								FormCadMarca.getForm().reset();
								}
  			 					}
							]					

				});
			}

Ext.getCmp('tabss').add(FormMarcas);
Ext.getCmp('tabss').setActiveTab(FormMarcas);
FormMarcas.doLayout();	
			

}