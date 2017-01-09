// JavaScript Document
Ext.onReady(function(){
Ext.get("cadastro_grupo").on('click',function(s,e){
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
var NovoGrupo;
var print_grupos;
var gruposel;
var win_relatorio_grupo;


storePrecoGrupo = new Ext.data.SimpleStore({
        fields: ['sitReajusteC','sitReajusteD'],
        data: [
            ['Alta', 'Alta'],
            ['Baixa', 'Baixa']
			
        ]
    });



//////////INICIO DA STORE ////////////////////
var dsGrupos = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/CadGrupos.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Grupos',
			totalProperty: 'totalGrupos',
			id: 'id'
		},
			[
			{name: 'id'},
			{name: 'nom_grupo'},
			{name: 'data'},
			]
		),
		sortInfo: {field: 'id', direction: 'ASC'},
		remoteSort: true		
	});
//////// FIM STORE //////////////
//////// INICIO DA GRID  ////////
 var grid_Grupos = new Ext.grid.EditorGridPanel(
	    {
	        store: dsGrupos, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "Codigo", width: 20, sortable: true, dataIndex: 'id'},	        
						{header: "nom_grupo", width: 200, align: 'left', sortable: true, dataIndex: 'nom_grupo',
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
			width:'100%',
			//id: 'despesa_id',
			height: 300,
			ds: dsGrupos,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dsGrupos,
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
					text: 'Imprimir Produtos',
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
				text: 'Novo',
				iconCls:'icon-add',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
						NovoGrupo.show();
						} 
				},
				{
				text: 'Excluir',
				iconCls:'icon-delete',
				tooltip: 'Clique para excluir um registro',
				handler: function(){
						selectedKeys = grid_Grupos.selModel.selections.keys;
						if(selectedKeys.length > 0){	
 						selectedRows = grid_Grupos.selModel.selections.items;
 						selectedKeys = grid_Grupos.selModel.selections.keys; 
						Ext.Ajax.request({
           				   		url: '../php/CadGrupos.php', 
           					 	params : {
									acao: 'excluir',
               						idGrupo: selectedKeys
            						},
									callback: function (options, success, response) {
										if (success) { 
											//Ext.MessageBox.alert('Aviso', response.responseText);   
											var json = Ext.util.JSON.decode(response.responseText);
											if(json.response == 'GrupoExcluido'){
												dsGrupos.reload();
												Ext.MessageBox.alert('Aviso', 'Grupo Excluido com Sucesso');
											}
											if(json.response == 'LancamentoExistente'){
												Ext.MessageBox.alert('Impossivel', 'Ha Produtos Cadastrados Com Esse Grupo');
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
				iconCls:'icon-money',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
						PrecoGrupoAlt();
						} 
				}
			],
			listeners:{ 
        	afteredit:function(e){
			dsGrupos.load(({params:{valor: e.value, acao: 'alterar', idGrupo: e.record.get('id'), campo: e.column,  'start':0, 'limit':100}}));
	  		}
			}
		
});

dsGrupos.load(({params:{'id':1, 'start':0, 'limit':200}}));





 var FormGrupos= new Ext.FormPanel({
            title       : 'Cadastro de Grupos',
			labelAlign: 'top',
           // region      : 'top',
            split       : true,
            autoWidth   : true,
			autoHeight	: true,
            collapsible : false,
           // margins     : '3 3 3 0',
			//bodyStyle:'padding:5px 5px 0',
            //cmargins    : '3 3 3 3',
			items:[grid_Grupos]		
        }); 

var FormCadGrupo= new Ext.FormPanel({
            title       : 'Cadastrar Novo Grupo',
			frame		: true,
            split       : true,
            autoWidth   : true,
			autoHeight	: true,
            collapsible : false,
			items:[
				   {
                    xtype:'textfield',
                    fieldLabel: 'Nome Grupo',
					id: 'nome_grupo',
                    name: 'nome_grupo',
                    width: 250
					}
					
					]		
        }); 

var FormPrecoGrupo= new Ext.FormPanel({
            //title       : 'Reajuste de Precos no Grupo',
			frame		: true,
            split       : true,
            autoWidth   : true,
			autoHeight	: true,
            collapsible : false,
			items:[
				   
				   comboReajustaGrupo = new Ext.form.ComboBox({
                    name: 'sitReajusta',
                    id: 'sitReajusta',
					readOnly:true,
                    store: storePrecoGrupo,//origem dos dados
                    fieldLabel: 'Reajuste',
                    allowBlank: false, //permitir ou não branco, será validado ao sair do campo.
                    displayField: 'sitReajusteD', //campo a ser exibido, de acordo com o mapemanto feito no objeto store
                    hiddenName: 'sitReajustaVal', //nome do campo Hidden que será criado automaticamente para receber o valor do item selecionado no combobox
                    typeAhead: true, //auto-selecionar o combo de acordo com o texto digitado
                    valueField: 'sitReajusteC',
                    mode: 'local', //localização da origem dos dados.
                    forceSelection: true,//forçar que só digite texto que exista em um dos itens. False para permitir qualquer texto.
                    triggerAction: 'all',
                    emptyText: 'Selecione', //texto a ser exibido quando não possuir item selecionado
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
					 },
					 {
					xtype       : 'fieldset',
					title       : 'Reajustar Custos',
					//layout      : 'form',
					collapsible : true,                    
					collapsed   : false,
					autoHeight  : true,
					forceLayout : true,
					items       : [
					new Ext.ux.MaskedTextField({
                    fieldLabel: 'Custos %',
					mask:'decimal',
					textReverse : true,
					id: 'CustoReajuste',
                    name: 'CustoReajuste',
                    width: 120
					})
					]
					 }
					
					]		
        }); 

					

/*	
if (print_grupos == null){
				print_grupos = new Ext.Window({
					id:'print_grupos'
					, frame:true
					, labelAlign: 'top'
					, title: "Impressao de produtos"
	                , layout: 'form'
	                , width: 270
					, height: 180
	                , closeAction :'hide'
	                , plain: true
					, modal: false
					, items:[	
							
							   {
                    			xtype:'textfield',
                   				fieldLabel: 'Com quantidade menor que',
								id: 'qtd_grupo',
                   			    name: 'qtd_grupo',
                    			width: 50
								},
								{ 			
								xtype:'button',
            					text: 'Gerar Relatorio',
								iconCls: 'icon-pdf',
            					handler: function(){ // fechar	
     	    					win_relatorio_grupo.show();
  			 					}
								},
								{
								style: 'margin-top:5px'
					 			},
								{
									xtype: 'label',
									text: '* Em branco para Todos',
									style: 'margin-top:20px'
								}
							]
					,buttons: [
							    
           						{
            					text: 'Sair',
            					handler: function(){ // fechar	
     	    					print_grupos.hide();
  			 						}
        						}
					]					

				});
			//}
print_grupos.show();
		}
*/


var relatorioGrupo = function(){
var selectedKeys = grid_Grupos.selModel.selections.keys;
if(selectedKeys.length > 0){		

var selectedRows = grid_Grupos.selModel.selections.items;
var selectedKeys = grid_Grupos.selModel.selections.keys; 
	
var win_relatorio_grupo = new Ext.Window({
					id: 'relatario_grupo_prod',
					title: 'Relatorio de Produtos',
					width: 650,
					height: 500,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='../produtos_grupo.php?grupo="+selectedKeys+"' > </iframe>"},
					buttons: [
           						{
            					text: 'Sair',
            					handler: function(){ // fechar	
     	    					win_relatorio_grupo.destroy();
  			 					}
			 
        					}]
				});
win_relatorio_grupo.show();
}
else{
selecione();
}			
}




 PrecoGrupoAlt = function(){
 selectedKeys = grid_Grupos.selModel.selections.keys;
 if(selectedKeys.length > 0){		

 selectedRows = grid_Grupos.selModel.selections.items;
 selectedKeys = grid_Grupos.selModel.selections.keys; 


if (PrecoGrupo == null){
				PrecoGrupo = new Ext.Window({
					title       : 'Reajuste de Precos no Grupo' 
					, id:'PrecoGrupo'
	                , layout: 'form'
	                , width: 400
					, height: 300
	                , closeAction :'hide'
	                , plain: true
					, resizable: false
					, modal: false
					, items:[FormPrecoGrupo]
					,focus: function(){
 	    						Ext.get('AmargenReajuste').focus();
									}
					,buttons: [
								{
            					text: 'Gravar',
            					handler: function(){ // fechar	
									FormPrecoGrupo.getForm().submit({
									url: "php/CadGrupos.php"
									, params : {
									  acao: 'alteraPrecos',
									  idGrupo: selectedKeys
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
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					PrecoGrupo.hide();
								FormPrecoGrupo.getForm().reset();
								}
  			 					}
							]					

				});
			}
PrecoGrupo.show();
}
else{
selecione();
}			
}




if (NovoGrupo == null){
				NovoGrupo = new Ext.Window({
					id:'NovoGrupo'
	                , layout: 'form'
	                , width: 400
					, height: 110
	                , closeAction :'hide'
	                , plain: true
					, resizable: false
					, modal: false
					, items:[FormCadGrupo]
					,focus: function(){
 	    						Ext.get('nome_grupo').focus();
									}
					,buttons: [
								{
            					text: 'Gravar',
            					handler: function(){ // fechar	
									FormCadGrupo.getForm().submit({
									url: "php/CadGrupos.php"
									, params : {
									  acao: 'novoGrupo'
									}
									, waitMsg: 'Cadastrando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
									}); 
								function OnSuccess(form,action){
								dsGrupos.reload();
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
     	    					NovoGrupo.hide();
								FormCadGrupo.getForm().reset();
								}
  			 					}
							]					

				});
			}




 if (cad_grupos == null){
				cad_grupos = new Ext.Window({
					id:'cad_grupos'
					, title: "CP SA"
	                , layout: 'form'
	                , width: '55%'
					, height: 400
	                , closeAction :'hide'
	                , plain: true
					, modal: false
					, items:[FormGrupos]
					,buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					cad_grupos.destroy();
								PrecoGrupo.destroy();
								NovoGrupo.destroy();
  			 					}
        			}
					]					

				});
			}

  cad_grupos.show();

			
	});	
});