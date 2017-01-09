// JavaScript Document

/// OverRide ////
Ext.override(Ext.form.Field, {
        fireKey : function(e) {
            if(((Ext.isIE && e.type == 'keydown') || e.type == 'keypress') && e.isSpecialKey()) {
                this.fireEvent('specialkey', this, e);
            }
            else {
                this.fireEvent(e.type, this, e);
            }
        }
      , initEvents : function() {
            this.el.on("focus", this.onFocus,  this);
            this.el.on("blur", this.onBlur,  this);
            this.el.on("keydown", this.fireKey, this);
            this.el.on("keypress", this.fireKey, this);
            this.el.on("keyup", this.fireKey, this);
            this.originalValue = this.getValue();
        }
    });


// Override que corrige bug
Ext.override(Ext.form.CheckboxGroup, {
  getNames: function() {
    var n = [];

    this.items.each(function(item) {
      if (item.getValue()) {
        n.push(item.getName());
      }
    });

    return n;
  },

  getValues: function() {
    var v = [];

    this.items.each(function(item) {
      if (item.getValue()) {
        v.push(item.getRawValue());
      }
    });

    return v;
  },

  setValues: function(v) {
    var r = new RegExp('(' + v.join('|') + ')');

    this.items.each(function(item) {
      item.setValue(r.test(item.getRawValue()));
    });
  }
});

Ext.override(Ext.form.RadioGroup, {
  getName: function() {
    return this.items.first().getName();
  },

  getValue: function() {
    var v;

    this.items.each(function(item) {
      v = item.getRawValue();
      return !item.getValue();
    });

    return v;
  },

  setValue: function(v) {
    this.items.each(function(item) {
      item.setValue(item.getRawValue() == v);
    });
  }
});



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
		  return 'Quitado';
		else
		  return 'Devolucao'; 

};
////////////////////////



///////////////////////////////
	
    // example of custom renderer function
    function change(val){
        if(val > 0){
            return '<span style="color:green;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;">' + val + '</span>';
        }
        return val;
    };

    // example of custom renderer function
    function pctChange(val){
        if(val > 0){
            return '<span style="color:green;">' + val + '%</span>';
        }else if(val < 0){
            return '<span style="color:red;">' + val + '%</span>';
        }
        return val;
    };
 ////////////////////////////////////////////////////////////////////////////////////////////
Ext.onReady(function(){   
  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  Ext.QuickTips.init();
	
var  lista_cli= Ext.get('lista_cli');
  var xg = Ext.grid;
  var expander;
  var FormContato;
	var win_novocontato;

//////////// Formulario/////////////////////////////////////
var top = new Ext.FormPanel({
        labelAlign: 'top',
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
					id: 'controle',
                    name: 'controle',
					edit: false,
                    anchor:'15%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('nomecliLista').focus();
					
                            }}

                }, 	
					{
                    xtype:'textfield',
                    fieldLabel: 'Nome',
					id: 'nomecliLista',
                    name: 'nomecliLista',
                    anchor:'85%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('razao_social').focus();
                            }}

                }, 
					
					{
                    xtype:'textfield',
                    fieldLabel: 'Ruc',
                    name: 'ruc',
					id: 'ruc',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('cedula').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Endereco',
					id: 'endereco',
                    name: 'endereco',
                    anchor:'85%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('email').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Telefone',
					id: 'telefonecom',
                    name: 'telefonecom',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('fax').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Celular',
					id: 'celular',
                    name: 'celular',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('limite').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Cidade',
					id: 'cidade',
                    name: 'cidade',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('obs').focus();
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
					id: 'data',
                    name: 'data',
                    anchor:'45%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('razao').focus();
                            }}

                }, 	
					{
                    xtype:'textfield',
                    fieldLabel: 'Razao Social',
					id: 'razao_sociall',
                    name: 'razao_social',
                    anchor:'85%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('ruc').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Cedula',
					id: 'cedula',
                    name: 'cedula',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('endereco').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Email',
					id: 'email',
                    name: 'email',
                    vtype:'email',
                    anchor:'85%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('telefonecom').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Fax',
					id: 'fax',
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
					id: 'saldo_devedor',
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
					id: 'limite',
                    name: 'limite',
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
            id:'obs',
			name: 'obs',
            fieldLabel:'Observacao',
            height:90,
            anchor:'82%'
        }],
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
        }
			]
});




/////////////TAB CONTATOS /////////////		

	if(!(FormContato instanceof Ext.form.FormPanel)){
		FormContato = new Ext.form.FormPanel({
			id: 'FormContato',
			url: 'php/salva_contato',
			method: 'POST',
			baseCls: 'x-plain',
			labelWidth: 110,
			bodyStyle: 'padding: 2px;',
			frame:false,
			labelAlign:'right',					        
			waitMsgTarget: false,					        
			layout: 'form',	
			onSubmit: Ext.emptyFn,	
			defaultType: 'textfield',
			defaults: {
				width: 100,
				allowBlank:false,
				selectOnFocus: true,
				blankText: 'Preencha o campo'
			},	
			items: [
				{					            
					id:'nome_contato',
					name: 'nome_contato',
					width: 200,
					fieldLabel: '<b>Nome</b>',
					fireKey : function(e){	
						if(e.getKey() == e.ENTER){
							Ext.getCmp('email_contato').focus();
						}
					}					
				},
				{
					id:'email_contato',
					name: 'email_contato',	
					width: 200,
					fieldLabel: '<b>Email</b>',
					fireKey : function(e){	
						if(e.getKey() == e.ENTER){
							Ext.getCmp('cedula_contato').focus();
						}
					}						
				},
				{
					id:'cedula_contato',
					name: 'cedula_contato',							
					fieldLabel: '<b>Cedula</b>',
					fireKey : function(e){	
						if(e.getKey() == e.ENTER){
							Ext.getCmp('ruc_contato').focus();
						}
					}						
				},
				{
					id:'ruc_contato',
					name: 'ruc_contato',							
					fieldLabel: '<b>Ruc</b>',
					fireKey : function(e){	
						if(e.getKey() == e.ENTER){
							Ext.getCmp('cel_contato').focus();
						}
					}						
				},
				{
					id:'cel_contato',
					name: 'cel_contato',							
					fieldLabel: '<b>Celular</b>',
					fireKey : function(e){	
						if(e.getKey() == e.ENTER){
							Ext.getCmp('dt_nascimento_contato').focus();
						}
					}						
				},
				{
                    xtype:'datefield',
                    fieldLabel: '<b>Data Nascimento</b>',
					id: 'dt_nascimento_contato',
                    name: 'dt_nascimento_contato',
                    width: 100,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('Botao').focus();
                            }}
                }

			],					
			buttonAlign:'center',
			buttons: [{
				id:'Botao',
				text:'Salvar',
				type: 'submit',
				minButtonWidth: 75,
				handler: function(){
					
			        Ext.Ajax.request( 
			        {
						waitMsg: 'Salvando...',
						url: 'php/salva_contato.php', 
						params: { 
							acao: "NovoContato",
							clienteid: Ext.get('controle').getValue(),
							nome_contato: Ext.get('nome_contato').getValue(),                        
							email_contato: Ext.get('email_contato').getValue(), 
							cel_contato: Ext.get('cel_contato').getValue(),
							cedula_contato: Ext.get('cedula_contato').getValue(),
							ruc_contato: Ext.get('ruc_contato').getValue(),
							dt_nascimento_contato: Ext.get('dt_nascimento_contato').getValue()
						},
						failure:function(response,options){
							Ext.MessageBox.alert('Erro', 'Nao foi possivel salvar...');
							dsContatos.rejectChanges();
						},
						
						success:function(response, options){
							dsContatos.commitChanges();	
							dsContatos.reload();							
							Ext.MessageBox.alert('Alerta', 'Salvo com sucesso');
							
							FormContato.form.reset();	
							//tabs_cli.reload();
						}
					 });
					
		 
				}
			}
			
			]
		});
	}

/////////////

	function novoContato(){		
		if(!(win_novocontato instanceof Ext.Window)){
			win_novocontato = new Ext.Window({
				title: 'Cadastro de Contatos',
				width:350,
				height:235,
				plain: true,						
				collapsible: false,
				resizable: false,
				closeAction:'hide',
				closable: true,
				modal: true,
				border: false,
				items: [FormContato],
				focus: function(){
					Ext.get('nome_contato').focus();
				}				
			});
		}
		win_novocontato.show();
	};
////////////////STORE DOS PEDIDOS DO CLIENTE ///////////////////////
var dsPedidosCli = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_pedidos_cli.php',
			method: 'POST'
		}),   
//		baseParams:{acao: "listarContatos"},
		reader:  new Ext.data.JsonReader({
			root: 'vendas',
			totalProperty: 'totalVend',
			id: 'id'
		},
			[
				{name: 'id'},
				{name: 'controle_cli'},
				{name: 'data_venda'},
				{name: 'st_venda',  type: 'string'},
				{name: 'pedido_id'},
				{name: 'valor_venda'}
				
			]
		),
		sortInfo: {field: 'st_venda', direction: 'DESC', id: Ext.getCmp("controle").getValue()},
		//id: 9,
		remoteSort: true		
	});
//////// FIM STORE DOS PEDIDOS DO CLIENTE //////////////
//////// INICIO DA GRID DOS PEDIDOS DO CLIENTE ////////
 var grid_pedidos = new Ext.grid.GridPanel(
	    {
	        store: dsPedidosCli, // use the datasource
	        
	        columns:
		        [
		        	//expander,
					{id:'id', width:'20', header: "Venda ", hidden: false,  sortable: true, dataIndex: 'id'},
					{id:'controle_cli', width:'20', header: "controle_cli ", hidden: true,  sortable: true, dataIndex: 'controle_cli'},
		            {id:'data_venda', width:'20', header: "Data ",  sortable: true, dataIndex: 'data_venda'},
		            {id:'st_venda', width:'300', header: "Situacao",  sortable: true, dataIndex: 'st_venda', renderer: formataSituacao},
					{id:'pedido_id', width:'90', header: "Pedido N.",  sortable: true, dataIndex: 'pedido_id'},
					{id:'valor_venda', width:'90', header: "Valor Venta",  sortable: true, dataIndex: 'valor_venda'}
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			width:780,
			height: 470,
			//ds: dsPedidosCli,
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
	       // title:'Contatos em ',
	        iconCls:'icon-grid',
			bbar: new Ext.PagingToolbar({
				store: dsPedidosCli,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Não tem dados",
				pageSize: 18,
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


////// FIM DA GRID PEDIDOS DO CLIENTE ///////////////////




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
			height: 470,
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
				pageSize: 18,
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
		//dsContatos.load({params:{acao: 'listarContatos', id: Ext.getCmp("controle").getValue()}});





var tabs = new Ext.TabPanel({
			 id: 'tabs',
        	 activeTab: 0,
			 layoutOnTabChange: true,
       		 width:790,
       		 height:540,
			 frame: true,
        	 plain:true,
        	 defaults:{autoScroll: true},
        	 items:[{
                title: 'Cadastro ',
				autoscroll: true,
				items: top
				//params:{ }
                
            	},{
                title: 'Contatos',
                items:[grid_contatos]
           		 },{
                title: 'Faturas',
				items:[grid_pedidos]
                //html: 'Disponivel em Breve'
            	}
        ]
    });


tabs_cli = new Ext.Window({
  id:'CadastroWindow'
, title: "Controle de Clientes"
, layout: 'form'
, frame: true
, width: 790
, height: 565
, closeAction :'hide' //com close a informação se perde, com hide não.
, plain: true
, modal: true              /* Faz o fundo se tornar não editavel*/
, items: tabs
, focus: function(){
   Ext.get('nomecliLista').focus();
}

});


////////////////////////////////////////////////////////////////////////////////////////////////////////////

lista_cli.on('click', function(e){  
	
 
	 
	storeSit = new Ext.data.SimpleStore({
        fields: ['sitCodigo','sitDescricao'],
        data: [
            ['nome', 'Nome'],
            ['controle', 'Codigo'],
			['ruc', 'Ruc'],
			['telefonecom', 'Fone'],
			['cidade', 'Cidade']
        ]
    });
	
    	simple = new Ext.FormPanel({
		    width:800,
			id: 'simple',
	        labelWidth: 75,
	        frame:true,
	      //  title: 'Live search',
	        bodyStyle:'padding:5px 5px 0',
	        defaults: {width: 230},
	        defaultType: 'textfield',
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
                    width: 50,
					listeners:{select:{fn:function(combo, value) {
						 combos = combo.getValue();
               // alert(combo);
          }}}

                }),
				  
				
					{
	                fieldLabel: 'Pesquisa',
	                name: 'query',
					id: 'query',
	                allowBlank:true,
	  		                            
					listeners: 
					{
						
						keyup: function(el,type)
						{
							var theQuery=el.getValue();
							
							ds.load(
							{
								params: 
								{	
									query: theQuery,
									combo: combo01.getValue()
									
								}
																
							});
							
						}				
					}
	            }
	        ]	
				
				
				
 });
		
		

//##############################################################################################
 		ds = new Ext.data.Store({
            proxy: new Ext.data.HttpProxy({
                url: '../php/lista_cli.php',
                method: 'POST'
            }),     
								
            reader:  new Ext.data.JsonReader({
				totalProperty: 'total',
				root: 'results',
				id: 'controle',
				fields: [
						 {name: 'controle',  type: 'string' },
						 {name: 'nomecliLista',  type: 'string', mapping: 'nome' },
						 {name: 'telefonecom',  type: 'string' },
						 {name: 'ruc',  type: 'string' },
						 {name: 'ativo',  type: 'string' },
						 {name: 'data',  type: 'string' },
						 {name: 'razao_social',  type: 'string'},
						 {name: 'cedula',  type: 'string' },
						 {name: 'endereco',  type: 'string' },
						 {name: 'fax',  type: 'string' },
						 {name: 'celular',  type: 'string' },
						 {name: 'limite',  type: 'string' },
						 {name: 'email',  type: 'string' },
						 {name: 'obs',  type: 'string' },
						 {name: 'saldo_devedor',  type: 'string' },
						 {name: 'cidade',  type: 'string' }
						 ]
			})					    
			
		})
		// Função que trata exibição do Ativo S = Sim e N = Não


	     var grid_listacli = new Ext.grid.GridPanel(
	    {
	        store: ds, // use the datasource
	        
	        cm: new xg.ColumnModel(
		        [
		        	//expander,
		            {id:'controle', width:'20', header: "Codigo",  sortable: true, dataIndex: 'controle'},
		            {id:'nomecliLista', width:'300', header: "Nome",  sortable: true, dataIndex: 'nomecliLista'},
					{id:'telefonecom', width:'90', header: "Fone",  sortable: true, dataIndex: 'telefonecom'},
					{id:'ruc', width:'90', header: "Ruc",  sortable: true, dataIndex: 'ruc'},
					{id:'ativo', width:'20', header: "Ativo",  sortable: true, dataIndex: 'ativo', renderer: formataAtivo},
					{id:'data', width:'20', header: "Data", hidden: true,  sortable: true, dataIndex: 'data'},
					{id:'razao_social', width:'20', header: "Razao Social", hidden: true,  sortable: true, dataIndex: 'razao_social'},
					{id:'cedula', width:'20', header: "Data", hidden: true,  sortable: true, dataIndex: 'cedula'},
					{id:'endereco', width:'20', header: "Data", hidden: true,  sortable: true, dataIndex: 'endereco'},
					{id:'fax', width:'20', header: "Data", hidden: true,  sortable: true, dataIndex: 'fax'},
					{id:'celular', width:'20', header: "Celular", hidden: true,  sortable: true, dataIndex: 'celular'},
					{id:'limite', width:'20', header: "Limite", hidden: true,  sortable: true, dataIndex: 'limite'},
					{id:'email', width:'20', header: "Email", hidden: true,  sortable: true, dataIndex: 'email'},
					{id:'obs', width:'20', header: "Obs", hidden: true,  sortable: true, dataIndex: 'obs'},
					{id:'saldo_devedor', width:'20', header: "Saldo Devedor", hidden: true,  sortable: true, dataIndex: 'saldo_devedor'},
					{id:'cidade', width:'20', header: "Cidade", hidden: true,  sortable: true, dataIndex: 'cidade'}
					
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
			width:785,
			height: 359,
	        stripeRows:true,
	      //  title:'Search results',
	        iconCls:'icon-grid',
	     //   renderTo: "res_curva",
	        autoHeight:false,
			listeners: {
			keypress: function(e){
				
			if(e.getKey()  >47 && e.getKey() < 58 || e.getKey() >64 && e.getKey() < 91 || e.getKey() >95 && e.getKey() < 106 ){	
				
 	   					 Ext.get('query').focus();
			
				
			}}}
			
		
			
	    });	

//Criando Janela Exibicao Resultado
win_listacli = new Ext.Window({
		id: 'win_listacli',
		title: 'Selecionar Cliente',
		width:800,
		height:510,
		autoScroll: false,
		shim:true,
		closable : true,
		html: '<div id=\'CA\'></div><br /><div id=\'CB\'></div><br /><div id=\'CC\'></div>',
		layout: 'anchor',
		resizable: false,
		draggable: true, //Movimentar Janela
		plain: true,
		modal: false, //Bloquear tela do fundo
		items:[simple,grid_listacli],
		focus: function(){
 	   					 Ext.get('query').focus();
		},  
		 buttons: [
           	{
            text: 'Cerrar',
            handler: function(){ // fechar	
     	    win_listacli.destroy();
			//document.getElementById("cod").focus();
  			 }
			 
        }]
	});
win_listacli.show();	

grid_listacli.on('rowdblclick', function(grid, row, e) {
										
	tabs_cli.show();					 
	// Carrega O formulario Com os dados da linha Selecionada
	top.getForm().loadRecord(ds.getAt(row));	
			dsContatos.baseParams.id = Ext.getCmp("controle").getValue();
			dsContatos.load();
			
			//dsPedidosCli.load({params:{acao: 'listarPedidos', start: 0, limit: 10, id: Ext.getCmp("controle").getValue()}});
			dsPedidosCli.baseParams.id = Ext.getCmp("controle").getValue();
			dsPedidosCli.load();

}); 


////////CONTATOS/////////////////////////////////////////////



});
});         
