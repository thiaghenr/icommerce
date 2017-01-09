// JavaScript Document

CadCliente = function(){	

if(perm.lista_cli.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}

    Ext.QuickTips.init();
    Ext.form.Field.prototype.msgTarget = 'side';


function getKey(e){
	var tecla;
	if(!e)
		e = window.event;
	if(e.keyCode)
		tecla = e.keyCode;
	else if(e.which)
		tecla = e.which;
	return tecla;
}

// Função que trata exibição do Ativo S = Sim e N = Não
var formataAtivo = function(value){
	if(value=='S')
		  return 'Sim';
		else if(value=='N')
		  return '<span style="color: #FF0000;">N&atilde;o</span>';
		else
		  return 'Desconhecido'; 
};

//// SITUACAO ///////////
var formataSituacao = function(value){
	if(value=='A')
		  return '<span style="color: #FF0000;">Pendente</span>';
		else if(value=='F')
		  return 'Faturado';
		else
		  return 'Devolvido'; 
};
////////////////////////


var xg = Ext.grid;
var expander;
var FormContato;
var win_novocontato;


	storeSit = new Ext.data.SimpleStore({
        fields: ['sitCodigo','sitDescricao'],
        data: [
            ['nome', 'Nome'],
            ['controle', 'Codigo'],
			['ruc', 'Ruc'],
			['telefone1', 'Fone'],
			['cidade', 'Cidade']
        ]
    });
	
    	
		
//##############################################################################################
 		ds = new Ext.data.Store({
            proxy: new Ext.data.HttpProxy({
                url: 'php/lista_cli.php',
                method: 'POST'
            }),     
								
            reader:  new Ext.data.JsonReader({
				totalProperty: 'total',
				root: 'results',
				id: 'controle',
				fields: [
						 {name: 'controle',  type: 'string' },
						 {name: 'nomecliLista',  type: 'string', mapping: 'nome' },
						 {name: 'telefone1',  type: 'string' },
						 {name: 'ruccli',  type: 'string', mapping: 'ruc' },
						 {name: 'ativo',  type: 'string' },
						 {name: 'data',  type: 'string' },
						 {name: 'fantasia',  type: 'string'},
						 {name: 'cedulacli',  type: 'string', mapping:'cedula' },
						 {name: 'endereco',  type: 'string' },
						 {name: 'fax',  type: 'string' },
						 {name: 'celular',  type: 'string' },
						 {name: 'lim_credito',  type: 'string' },
						 {name: 'emailcli',  type: 'string' ,mapping:'email' },
						 {name: 'obs',  type: 'string' },
						 {name: 'saldo_devedor',  type: 'string' },
						 {name: 'idCidadesCli' },
						 {name: 'datnasc'},
						 {name: 'nomecidade'}
						 ]
			})					    
			
		})
		     grid_listacli = new Ext.grid.GridPanel({
	        store: ds, // use the datasource
	        cm: new xg.ColumnModel(
		        [
		            {id:'controle', width:20, header: "Codigo",  sortable: true, dataIndex: 'controle'},
		            {id:'nomecliLista', width:150, header: "Nome",  sortable: true, dataIndex: 'nomecliLista'},
					{id:'telefone1', width:90, header: "Fone",  sortable: true, dataIndex: 'telefone1'},
					{id:'ruccli', width:90, header: "Ruc",  sortable: true, dataIndex: 'ruccli'},
					{id:'ativo', width:20, header: "Ativo",  sortable: true, dataIndex: 'ativo', renderer: formataAtivo},
					{id:'data', width:20, header: "Data", hidden: true,  sortable: true, dataIndex: 'data'},
					{id:'fantasia', width:150, header: "Fantasia", hidden: true,  sortable: true, dataIndex: 'fantasia'},
					{id:'cedulacli', width:90, header: "Cedula", hidden: true,  sortable: true, dataIndex: 'cedulacli'},
					{id:'endereco', width:150, header: "Endereco", hidden: true,  sortable: true, dataIndex: 'endereco'},
					{id:'fax', width:90, header: "Fax", hidden: true,  sortable: true, dataIndex: 'fax'},
					{id:'celular', width:90, header: "Celular", hidden: true,  sortable: true, dataIndex: 'celular'},
					{id:'lim_credito', width:90, header: "Limite", hidden: true,  sortable: true, dataIndex: 'lim_credito'},
					{id:'emailcli', width:150, header: "Email", hidden: true,  sortable: true, dataIndex: 'emailcli'},
					{id:'obs', width:150, header: "Obs", hidden: true,  sortable: true, dataIndex: 'obs'},
					{id:'saldo_devedor', width:90, header: "Saldo Devedor", hidden: true,  sortable: true, dataIndex: 'saldo_devedor'},
					{id:'idCidadesCli', width:100, header: "Cidade", hidden: true,  sortable: true, dataIndex: 'idCidadesCli'},
					{id:'datnasc', width:100, header: "datnasc", hidden: true,  sortable: true, dataIndex: 'datnasc'}
					
		        ]
	        ), 
	        viewConfig: 
	        {
	            forceFit:true
	        },
	        
	        plugins: expander,
			collapsible: true,
			animCollapse: false,
        	//autoscroll: true,
			autoWidth:true,
			height: 250,
	        stripeRows:true,
		    title:'Entidades Encontrados',
	        iconCls:'icon-grid',
	        autoHeight:false,
			listeners: {
			keypress: function(e){
				
			if(e.getKey()  >47 && e.getKey() < 58 || e.getKey() >64 && e.getKey() < 91 || e.getKey() >95 && e.getKey() < 106 ){	
 	   					 Ext.get('query').focus();
			}}			
			
			}
	    });	
		
		//////////// Formulario/////////////////////////////////////
var top = new Ext.FormPanel({
        //labelAlign: 'top',
        frame:true,
        bodyStyle:'padding:5px 5px 0',
        width: 764,
		autoHeight: true,
        items: [{
            layout:'column',
            items:[{
                columnWidth:.5,
                layout: 'form',
                items: [
					{
				 	xtype:'textfield',
                    fieldLabel: 'Codigo',
					readOnly: true,
					Style: 'color: #ccccc;',
                    name: 'controle',
					edit: false,
                    anchor:'45%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('nomecliLista').focus();
					
                            }}

                }, 	
					{
                    xtype:'textfield',
                    fieldLabel: 'Nome',
                    name: 'nomecliLista',
                    anchor:'85%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('fantasia').focus();
                            }}

                }, 
					
					{
                    xtype:'textfield',
                    fieldLabel: 'Ruc',
                    name: 'ruccli',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('endereco').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Endereco',
                    name: 'endereco',
                    anchor:'85%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('emailcli').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Telefone',
                    name: 'telefone1',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('fax').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Celular',
                    name: 'celular',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('lim_credito').focus();
                            }}
                },
				{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				dataField: ['idcidade','nomecidade'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Cidade',
				minChars: 2,
				name: 'nomecidade',
				id: 'nomecidade',
                resizable: true,
				anchor:'65%',
                listWidth: 300,
				store: new Ext.data.JsonStore({
				url: 'php/pesquisa_cidade.php',
				root: 'resultados',
				fields: [ 'idcidade', 'nomecidade' ]
			}),
				hiddenName: 'idcidade',
				valueField: 'idcidade',
				displayField: 'nomecidade'
                },
					
				{
                    xtype:'datefield',
                    fieldLabel: 'Fecha Nasc.',
                    name: 'datnasc',
                    width: 130,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('fantasia').focus();
                            }}
                }
					
					]
            },
				{
                columnWidth:.5,
                layout: 'form',
                items: [
					{
				 	xtype:'textfield',
                    fieldLabel: 'Cliente Desde',
					readOnly: true,
                    name: 'data',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('fantasia').focus();
                            }}

                }, 	
					{
                    xtype:'textfield',
                    fieldLabel: 'Fantasia',
                    name: 'fantasia',
                    anchor:'85%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('ruccli').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Cedula',
                    name: 'cedulacli',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('endereco').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Email',
                    name: 'emailcli',
                    vtype:'email',
                    anchor:'85%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('telefone1').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Fax',
                    name: 'fax',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('celular').focus();
                            }}
                },
				{
                    xtype:'textfield',
                    fieldLabel: 'Saldo Devedor',
                    name: 'saldo_devedor',
					readOnly: true,
			        anchor:'65%'
					/*fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   //document.getElementById('contato1').focus();
                            }}*/
                },
                   {
                    xtype:'textfield',
                    fieldLabel: 'Limite',
                    name: 'lim_credito',
					mask:'guarani',
					textReverse : true,
                    anchor:'65%'
					/*fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('contato1').focus();
                            }}*/
                },
					
					//aki preciso de um radio qe venha a opcao 'SIM' checado caso, ativo = 'S', e checado a opcao 'NAO' caso ativo = 'N'
				{
				xtype:'fieldset',
				title: 'Ativo',
				//width: 270,
				autoHeight: true,
				items: [{
					xtype: 'radiogroup'
					,hideLabel: true
			    	,items: [
						 {
							 boxLabel: 'Sim'
							 , name: 'ativo'
							 , inputValue: 'S'
							
					    },
						{
							boxLabel: 'N&atilde;o'
							, name: 'ativo'
							, inputValue: 'N'
							, checked: true
							
						}	
					]
				}]
			  }			
				]
            }]
        },
			{
            xtype:'htmleditor',
			name: 'obs',
            fieldLabel:'Observacao',
            height:90,
            anchor:'82%'
        }]
});

			
		grid_listacli.on('rowdblclick', function(grid, row, e) {
			tabs_cli.show();					 
			// Carrega O formulario Com os dados da linha Selecionada
			top.getForm().loadRecord(ds.getAt(row));	
					dsContatos.load({params:{acao: 'listarContatos', id: top.getForm().findField('controle').getValue()}});
		});
		grid_listacli.on('rowclick', function(grid, row, e) {
					record = grid_listacli.getSelectionModel().getSelected();
					var idName = grid_listacli.getColumnModel().getDataIndex(0); // Get field name
					var idData = record.get(idName);
                   // dsPedidosCli.load({params:{id: idData ,start: 0, limit: 18}});
                    dsPedidosCli.baseParams = {id: idData ,start: 0, limit: 20};

				//	dsPedidosCli.baseParams.id = idData;
				dsPedidosCli.load();
		});
		
		var dsContatos = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_contatos.php',
			method: 'POST'
		}),   
//		baseParams:{acao: "listarContatos"},
		reader:  new Ext.data.JsonReader({
			root: 'contatos',
			id: 'idcontatos'
		},
			[
				{name: 'clienteid'},
				{name: 'nomecontato'},
				{name: 'celcontato'},
				{name: 'emailcontato'}
				
			]
		),
		sortInfo: {field: 'contato', direction: 'DESC', id: id},
		remoteSort: true		
	});
 var grid_contatos = new Ext.grid.GridPanel(
	    {
	        store: dsContatos, // use the datasource
	        
	        columns:
		        [
		        	//expander,
					{id:'clienteid', width:'20', header: "Nome ", hidden: true,  sortable: true, dataIndex: 'clienteid'},
		            {id:'nomecontato', width:'20', header: "Nome ",  sortable: true, dataIndex: 'nomecontato'},
		            {id:'celcontato', width:'300', header: "Celular",  sortable: true, dataIndex: 'celcontato'},
					{id:'emailcontato', width:'90', header: "Email",  sortable: true, dataIndex: 'emailcontato'}
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			width:780,
			height: 340,
	        stripeRows:true,
	       // title:'Contatos em ',
	        iconCls:'icon-grid',
			 tbar: [		
			{		
				text: 'Novo',
				iconCls:'add', 
				tooltip: 'Novo Funcionario',
				handler : function(){	
					novoContato();
				}
			}, 
				
			{
				text: 'Deletar registro',
				tooltip: 'Clique para Deletar um registro(s) selecionado',
				handler: function(){
					var selectedKeys = grid_contatos.selModel.selections.keys; 
					if(selectedKeys.length > 0)
					{
						Ext.MessageBox.confirm('Alerta', 'Deseja deletar esse registro?', function(btn) {
							if(btn == "yes"){	
								var selectedRows = grid_contatos.selModel.selections.items;
								var selectedKeys = grid_contatos.selModel.selections.keys; 
								var encoded_keys = Ext.encode(selectedKeys);
			
								Ext.Ajax.request(
								{ 
									waitMsg: 'Executando...',
									url: 'php/deleta_contato.php',		
									params: { 
										id: encoded_keys,
										key: 'idcontatos'										
									},
										
									callback: function (options, success, response) {
										if (success) { 
											Ext.MessageBox.alert('OK', response.responseText);
											var json = Ext.util.JSON.decode(response.responseText);
												if(json.del_count == 1){
													mens = "1 Registro deletado.";
												} else {
													mens = json.del_count + " Registros deletados.";
												}
												Ext.MessageBox.alert('Alerta', mens);
											} else{
												Ext.MessageBox.alert('Desculpe, por favor tente novamente. [Q304]',response.responseText);
											}
										},
										
										failure:function(response,options){
											Ext.MessageBox.alert('Alerta', 'Erro...');
										},                                      
										success:function(response,options){
											dsContatos.reload();
										}                                      
									 } 
								);						
							}	
						});
					}
					else
					{
						Ext.MessageBox.alert('Alerta', 'Por favor selecione uma linha');
					}
				}, 
				iconCls:'remove' 
			}],
			 
			bbar: new Ext.PagingToolbar({
				store: dsContatos,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Não tem dados",
				pageSize: 30,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina",    
				refreshText : "Atualizar",    
				paramNames : {start: 'start', limit: 'limit'}
			})
		});
 		

		////////////////STORE DOS PEDIDOS DO CLIENTE ///////////////////////
var dsPedidosCli = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_pedidos_cli.php',
			method: 'POST'
		}),   
//		baseParams:{acao: "listarContatos"},
		reader:  new Ext.data.JsonReader({
			root: 'pedidos',
			totalProperty: 'totalPed',
			id: 'id'
		},
			[
				{name: 'id'},
				{name: 'controle_cli'},
				{name: 'data_car'},
				{name: 'situacao',  type: 'string'},
				{name: 'nome_user'},
				{name: 'vendedor'},
				{name: 'total_nota'}
				
			]
		),
		sortInfo: {field: 'id', direction: 'DESC', id: top.getForm().findField('controle').getValue()},  
		remoteSort: true		
	});
//////// FIM STORE DOS PEDIDOS DO CLIENTE //////////////
//////// INICIO DA GRID DOS PEDIDOS DO CLIENTE ////////
 var grid_pedidos = new Ext.grid.GridPanel({
	        store: dsPedidosCli, // use the datasource
	        columns:
		        [
		        	//expander,
					{id:'id', width: 50, header: "Pedido ", hidden: false,  sortable: true, dataIndex: 'id'},
					{id:'controle_cli', width: 50, header: "controle_cli ", hidden: true,  sortable: true, dataIndex: 'controle_cli'},
		            {id:'data_car', width:90, header: "Data ",  sortable: true, dataIndex: 'data_car'},
		            {id:'situacao', width:90, header: "Situacao",  sortable: true, dataIndex: 'situacao', renderer: formataSituacao},
					{id:'nome_user', width:100, header: "Usuario",  sortable: true, dataIndex: 'nome_user'},
					{id:'vendedor', width:100, header: "Vendedor",  sortable: true, dataIndex: 'vendedor'},
					{id:'total_nota', width:120, header: "Total",  sortable: true, dataIndex: 'total_nota', renderer: 'usMoney'}
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			autoWidth:true,
			id:'grid_pedidos',
			height: 170,
			border: true,
			loadMask: true,
			title:'Pedidos Encontrados',
			closable: true,
			enableColLock: false,
			//renderTo: Ext.getCmp('south').body,
	        stripeRows:true,
	        iconCls:'icon-grid',
            bbar: new Ext.PagingToolbar({
				store: dsPedidosCli,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Não tem dados",
				pageSize: 20,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina",    
				refreshText : "Atualizar"  
			//	paramNames : {start: 0, limit: 5},
			})
});


////// FIM DA GRID PEDIDOS DO CLIENTE ///////////////////
 
		var tabs = new Ext.TabPanel({
			 id: 'tabs',
        	 activeTab: 0,
			 layoutOnTabChange: true,
       		 width:745,
       		// height:440,
             autoHeight: true,
			 frame: true,
        	 plain:true,
        	 defaults:{autoScroll: true},
        	 items:[{
                title: 'Cadastro ',
				autoscroll: true,
				items: top,
				 autoHeight: true
				//params:{ }
                
            	},{
                title: 'Contatos',
                items:[grid_contatos]
           		 }
        ]
    });
		simple = new Ext.FormPanel({
		    autoWidth: true,
			id: 'simple',
	        labelWidth: 100,
	        frame:true,
			closable:true,
	        title: 'Entidades',
		    autoWidth: true,
			items: [
					combo01 = new Ext.form.ComboBox({
                    name: 'sitCodigo',
                    id: 'sitCodigo',
					readOnly:true,
                    store: storeSit,//origem dos dados
                    fieldLabel: 'Pesquisar por',
                    allowBlank: false, //permitir ou não branco, será validado ao sair do campo.
                    displayField: 'sitDescricao', //campo a ser exibido, de acordo com o mapemanto feito no objeto store
                    hiddenName: 'sitCodigoVal', //nome do campo Hidden que será criado automaticamente para receber o valor do item selecionado no combobox
                    typeAhead: true, //auto-selecionar o combo de acordo com o texto digitado
                    valueField: 'sitCodigo',
                    mode: 'local', //localização da origem dos dados.
                    forceSelection: true,//forçar que só digite texto que exista em um dos itens. False para permitir qualquer texto.
                    triggerAction: 'all',
                    emptyText: 'Nome', //texto a ser exibido quando não possuir item selecionado
                    selectOnFocus: true, //selecionar o texto ao receber foco
	                blankText : 'Nome', 
                    width: 150,
					listeners:{select:{fn:function(combo, value) {
						 combos = combo.getValue();
          }}}
                }),
					{
					xtype: 'textfield',
	                fieldLabel: 'Pesquisa',
	                name: 'query',
					width: 150,
	                allowBlank:true,
					fireKey: function(e,type){
					   if(e.getKey() == e.ENTER) {//precionar enter   
							var theQuery= simple.getForm().findField('query').getValue();
							ds.load({params:{query: theQuery, combo: combo01.getValue()}});
						}
                        }
					},grid_listacli,
					{
					html: 
				   '* Duplo click para editar',
				   frame:true,
				   width: 265
				   },grid_pedidos
	            
	        ]
 });
	
		
		tabs_cli = new Ext.Window({
			  id:'CadastroWindow'
			, title: "Controle de Entidades"
			, layout: 'form'
			, frame: true
			, width: 790
			//, height: 450
            //, autoHeight: true
			, closeAction :'hide' //com close a informação se perde, com hide não.
			, plain: true
			, modal: true              /* Faz o fundo se tornar não editavel*/
			, items: [tabs]
			, closable: false
			, resizable: false
			, focus: function(){
			 // simple.getForm().findField('nomecliLista').getValue()
			},
        buttons: [{
			id: 'cadastrarr',
            text: 'Gravar',
			handler: function(){
			top.getForm().submit({
				url: "php/update_cli.php"
				, waitMsg: 'Cadastrando'
				, waitTitle : 'Aguarde....'
				, scope: this
				, success: OnSuccess
				, failure: OnFailure
			}); 
			function OnSuccess(form,action){
				Ext.MessageBox.alert("Confirmação",action.result.msg);
				ds.reload();
				
			};
			
			function OnFailure(form,action){
				Ext.MessageBox.alert(action.result.msg);
			};
			}
        },
		{
            text: 'Cerrar',
			handler: function(){
			tabs_cli.hide();
			}
		}
			]
		});

Ext.getCmp('tabss').add(simple);
Ext.getCmp('tabss').setActiveTab(simple);
/*
Ext.getCmp('sul').add(grid_pedidos);
Ext.getCmp('sul').setActiveTab(grid_pedidos);
Ext.get('query').focus();
*/
}
