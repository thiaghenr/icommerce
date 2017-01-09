					 
	Ext.SSL_SECURE_URL   = 'public/images/default/s.gif';
	Ext.BLANK_IMAGE_URL = 'public/images/default/s.gif';

	Ext.QuickTips.init();	
	Ext.form.Field.prototype.msgTarget = 'side';
	
	CadUser = function(){

	
	if(perm.index.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}

	var win;
	var FormPanel;	
	
	var dsCargos = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'funcionarios/listar.php',
			method: 'POST'
		}),   
		baseParams:{acao: "listarCargos"},
		reader:  new Ext.data.JsonReader({
			root: 'dados',
			id: 'id_cargo'
		},
			[
				{name: 'id_cargo'},
				{name: 'cargo'}				
			]
		),
		sortInfo: {field: 'cargo', direction: 'DESC'},
		remoteSort: true		
	});
	dsCargos.load();	
	
	var dsEntidade = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/LancDespesa.php?acao_nome=fornNome',
			method: 'POST'
		}),   
		baseParams:{acao_nome: "nomeforn"},
		reader:  new Ext.data.JsonReader({
			root: 'resultados',
			id: 'idforn'
		},
			[
				{name: 'idforn'},
				{name: 'nomeforn'}				
			]
		),
		sortInfo: {field: 'nomeforn', direction: 'DESC'},
		remoteSort: true		
	});
	dsEntidade.load();	
	
	
	var comboCargo = new Ext.form.ComboBox({
		store: dsCargos,
		displayField:'cargo',
		valueField:'id_cargo',
		typeAhead: true,
		mode: 'remote',
		triggerAction: 'all',
		//emptyText:'SEM CARGO',
		selectOnFocus:true,
		id:'cargoUser',
		name:'cargoUser',
		fieldLabel: '<b>Cargos</b>',
		width: 110,
		editable: false,
		dataField: ['id_cargo','cargo'],
		hiddenName: 'id_cargo',
		fireKey : function(e){	
			if(e.getKey() == e.ENTER){
				Ext.getCmp('NovoUser').focus();
			}
		}			
	});
	
	var campoValor = new Ext.ux.MaskedTextField({
		id:'salario',
		name: 'salario',
		mask:'decimal',
		textReverse : true,
		fieldLabel: '<b>Salario</b>',
		width: 100,
		allowNegative: false,
		fireKey : function(e){	
			if(e.getKey() == e.ENTER){
				Ext.getCmp('id_cargo').focus();
			}
		}		
	});
	
	dsUser = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'funcionarios/listar.php',
			method: 'POST'
		}),   
		//baseParams:{acao: "listarDados"},
		reader:  new Ext.data.JsonReader({
			root: 'dados',
			totalProperty: 'total',
			id: 'id_usuario'
		},
			[
				{name: 'id_usuario'},
				{name: 'exibicao', mapping: 'nome_user'},
				{name: 'idforn', mapping: 'entidadeid'},
				{name: 'perfil_id'},
				{name: 'email'},				
				{name: 'nascimento'},
				{name: 'salario'},
				{name: 'id_cargo'},
				{name: 'porcentagem'},				
				{name: 'ativo'},
				{name: 'cedula'},
				{name: 'ruc'},
				{name: 'login', mapping: 'usuario'}
			]
		),
		sortInfo: {field: 'id_usuario', direction: 'DESC'},
		remoteSort: true		
	});
	
	if(!(FormPanel instanceof Ext.form.FormPanel)){
		FormPanel = new Ext.form.FormPanel({
			id: 'form1',
			url: 'funcionarios/salvar',
			method: 'POST',
			baseCls: 'x-plain',
			labelWidth: 110,
			bodyStyle: 'padding: 2px;',
			frame:false,
			labelAlign:'right',					        
			waitMsgTarget: false,					        
			layout: 'form',	
			//onSubmit: Ext.emptyFn,	
			defaultType: 'textfield',
			defaults: {
				width: 100,
				allowBlank:true,
				selectOnFocus: true,
				blankText: 'Preencha o campo'
			},	
			items: [
			{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: true,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				dataField: ['idforn','nomeforn', 'endereco'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: '<b>Entidade</b>',
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
				fields: [ 'idforn', 'nomeforn', 'endereco' ],
				baseParams:{acao_nome: "nomeforn"}
				}),
					hiddenName: 'identidade',
					valueField: 'idforn',
					displayField: 'nomeforn',
					fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
						  Ext.getCmp('documento').focus();
						}
					},
					onSelect: function(record){
						identidade = record.data.idforn;
						nomeforn = record.data.nomeforn;
						this.collapse();
						this.setValue(nomeforn);
					}
							
                },
			
			
				
						
				 	new Ext.ux.MaskedTextField({
					id:'porcentagem',
					name: 'porcentagem',
					mask:'porcentagem',
					textReverse : true,
					fieldLabel: '<b>Comissao</b>',
					fireKey : function(e){	
						if(e.getKey() == e.ENTER){
							Ext.getCmp('cedula').focus();
						}
					}						
				}),
				
				{
					id:'login',
					name: 'login',
					allowBlank: false,
					fieldLabel: '<b>Login</b>',
					fireKey : function(e){	
						if(e.getKey() == e.ENTER){
							Ext.getCmp('senha').focus();
						}
					}						
				},
				{
					id:'senha',
					name: 'senha',							
					fieldLabel: '<b>Password</b>',
					emptyText:'123 ',
					disabled: true,
					fireKey : function(e){	
						if(e.getKey() == e.ENTER){
							Ext.getCmp('exibicao').focus();
						}
					}						
				},
				{
					id:'exibicao',
					name: 'exibicao',	
					allowBlank: false,
					fieldLabel: '<b>Nome Exibicao</b>',
					emptyText:'',
					fireKey : function(e){	
						if(e.getKey() == e.ENTER){
							Ext.getCmp('data_nascimento').focus();
						}
					}						
				},
				
				{
					id:'nascimento',
					name: 'nascimento',							
					fieldLabel: '<b>Data Nascimento</b>',
					xtype: 'datefield',
					fireKey : function(e){	
						if(e.getKey() == e.ENTER){
							Ext.getCmp('salario').focus();
						}
					}						
				},
					campoValor,
					{
                    xtype:'combo',
					hideTrigger: false,
					allowBlank: false,
					editable: true,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['id_cargo','cargo'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
                    fieldLabel: '<b>Cargo</b>',
					id: 'cargos',
					minChars: 2,
                    name: 'cargos',
                    anchor:'60%',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'funcionarios/listar.php',
					root: 'dados',
					autoLoad: true,
					fields: [ {name:'id_cargo', mapping: 'id_cargo'}, {name:'cargo'} ],
					baseParams:{acao: "listarCargos"}
			}),
						hiddenName: 'id_cargo',
						valueField: 'id_cargo',
						displayField: 'cargo',
						listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('custo').focus() ; 

						}}
					}
                }
			],					
			buttonAlign:'center',
			buttons: [
					  {
					id: 'salvar',
					text: 'Salvar',
					iconCls: 'save',
					handler: function(){
							FormPanel.getForm().submit({
								url: 'funcionarios/salvar.php', 
									params: {
										user: id_usuario,
										acao: 'Edita',
										idUser: iduser
										}
									, waitMsg: 'Salvando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
								}); 
							function OnSuccess(form,action){
								//alert(action.result.msg);
								ds.reload();
							}
			
							function OnFailure(form,action){
								//alert(action.result.msg);
							}
						}
					},
					  {
				id:'NovoUser',
				text:'Salvar',
				type: 'submit',
				minButtonWidth: 75,
				handler: function(){
				FormPanel.getForm().submit({
						url: 'funcionarios/salvar.php', 
						params: { 
							acao: "Novo"
						}
						, waitMsg: 'Cadastrando'
						, waitTitle : 'Aguarde....'
						, scope: this
						, success: OnSuccess
						, failure: OnFailure
										   });
						function OnSuccess(form,action){
								ds.reload();
								Ext.MessageBox.alert("Confirma&ccedil;&atilde;o!",action.result.response);
								};
								function OnFailure(form,action){
								Ext.MessageBox.alert(action.result.msg);
								};
				}
			},
			{
				//id: "close",
				text: 'Voltar',
				handler: function(){
					win.hide();
				}
			}
			]
		});
	}
	
	function novo(){		
		if(!(win instanceof Ext.Window)){
			win = new Ext.Window({
				title: 'Cadastro de Funcionarios',
				width:450,
				autoHeight:true,
				plain: true,						
				collapsible: false,
				resizable: false,
				closeAction:'hide',
				closable: true,
				modal: true,
				border: false,
				items: [FormPanel]
			});
		}
		win.show();
	}
	
	ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'funcionarios/listar.php',
			method: 'POST'
		}),   
		//baseParams:{acao: "listarDados"},
		reader:  new Ext.data.JsonReader({
			root: 'dados',
			totalProperty: 'total',
			id: 'id_usuario'
		},
			[
				{name: 'id_usuario'},
				{name: 'nome_user'},
				{name: 'idforn', mapping: 'entidadeid'},
				{name: 'email'},				
				{name: 'data_nascimento', type: 'date', dateFormat: 'd-m-Y'},
				{name: 'salario'},
				{name: 'id_cargo'},
				{name: 'porcentagem'},				
				{name: 'ativo'},
				{name: 'cedula'},
				{name: 'ruc'},
				{name: 'usuario'}
			]
		),
		sortInfo: {field: 'nome', direction: 'DESC'},
		remoteSort: true		
	});
		
	 checkColumn = new Ext.grid.CheckColumn({
		header: "Ativos",
		dataIndex: 'ativo',
		width: 35	
    });
	
	var cm = new Ext.grid.ColumnModel([
		new Ext.grid.RowNumberer(),
		checkColumn,
		{dataIndex: 'id_usuario', header: 'Codigo',	width: 30, hidden: false, hideable: false},
		{dataIndex: 'nome_user', header: 'Nome Exibicion',	width: 45},	
		{dataIndex: 'idforn',	header: 'Entidade',	width: 65,
		renderer: function(value) {
				record = dsEntidade.getById(value);	
				if(record) {
					return record.data.nomeforn;
				} else {
					return 'SIN ENTIDADE';
				}
			}
			},	
		{dataIndex: 'data_nascimento', header: 'Dt Nascimento', width: 45, hidden: true},
		{dataIndex: 'salario', header: 'Salario',width: 45,
			renderer: function(v){
				v = (Math.round((v-0)*100))/100;
				v = (v == Math.floor(v)) ? v + ".00" : ((v*10 == Math.floor(v*10)) ? v + "0" : v);
				v = String(v);
				var ps = v.split('.');
				var whole = ps[0];
				var sub = ps[1] ? '.'+ ps[1] : '.00';
				var r = /(\d+)(\d{3})/;
				while (r.test(whole)) {
					whole = whole.replace(r, '$1' + '.' + '$2');
				}
				v = whole + sub;
				if(v.charAt(0) == '-'){
					return '-$' + v.substr(1);
				}
				return "$ " +  v;			
			}	
		},
		{dataIndex: 'id_cargo', header: "Cargo", width: 45,	
			renderer: function(value) {
				record = dsCargos.getById(value);	
				if(record) {
					return record.data.cargo;
				} else {
					return 'SEM CARGO';
				}
			},
			editor: new Ext.form.ComboBox({ 
				editable: false,
				typeAhead: true, 
				loadingText: 'Carregando...',
				triggerAction: 'all',
				selectOnFocus:true,
				lazyRender: true,
				store: dsCargos,
				displayField: 'cargo',
				valueField: 'id_cargo',
				width:220
			})			
		},
		{dataIndex: 'usuario', header: 'Login', width: 40}
	]);
	cm.defaultSortable = true;
	
	var grid = new Ext.grid.EditorGridPanel({
		id: 'datagrid1',
		ds: ds,
		cm: cm,
		enableColLock: false,
		loadMask: true,
		stripeRows: true,
		plugins: [checkColumn],
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		autoWidth: true,
		closable: true,
		//height: 330,
		title:'Usuarios',
		viewConfig: {
			forceFit:true,
			getRowClass : function (row, index) {				
				var cls = '';
				if(row.data.ativo == false){
					cls = 'corGrid'
				} else {
					cls = ''
				}				
				return cls;
			}	
		},	
	     tbar: [		
			{		
				text: 'Novo',
				iconCls:'icon-add', 
				tooltip: 'Novo Funcionario',
				handler : function(){	
					novo();
					Ext.getCmp('NovoUser').setVisible(true);
					Ext.getCmp('salvar').setVisible(false);
					FormPanel.getForm().reset();
					Ext.getCmp('nomeforn').setVisible(true);
				}
			}, '-',
				
			{
				text: 'Deletar registro',
				tooltip: 'Clique para Deletar um registro(s) selecionado',
				handler: function(){
					var selectedKeys = grid.selModel.selections.keys; 
					if(selectedKeys.length > 0)
					{
						Ext.MessageBox.confirm('Alerta', 'Deseja deletar esse registro?', function(btn) {
							if(btn == "yes"){	
								var selectedRows = grid.selModel.selections.items;
								var selectedKeys = grid.selModel.selections.keys; 
								var encoded_keys = Ext.encode(selectedKeys);
			
								Ext.Ajax.request(
								{ 
									waitMsg: 'Executando...',
									url: 'funcionarios/deletar.php',		
									params: { 
										id_usuario: encoded_keys,
										key: 'id_usuario'										
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
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										},
										
										failure:function(response,options){
											Ext.MessageBox.alert('Alerta', 'Erro...');
										},                                      
										success:function(response,options){
											ds.reload();
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
				iconCls:'icon-delete' 
			}],
				
			bbar: new Ext.PagingToolbar({
				store: ds,
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
			}),
			listeners:{
				destroy: function(){
				if(win)
				win.destroy();
				}
			}
				
	});
	
	dsUser.on('load', function(){
	FormPanel.getForm().loadRecord(dsUser.getAt(0));	
	//Ext.getCmp('salvar').setVisible(true);  
	//Ext.getCmp('Estoque').setDisabled(true);
    	
    });
	
	grid.on('rowdblclick', function(grid, row, e, col) {
	iduser = ds.getAt(row).data.id_usuario;
	dsUser.load(({params:{user: id_usuario, acao: 'ListaUser', idUser: iduser }}));
	novo();
	Ext.getCmp('NovoUser').setVisible(false);
	Ext.getCmp('salvar').setVisible(true);
//	FormPanel.getForm().findField('nomeforn').setVisible(false);
	Ext.getCmp('nomeforn').setVisible(false);
	
	
	});
	
	grid.addListener('afteredit', function(oGrid_Event){
		var gridField = oGrid_Event.field;
		
			if (oGrid_Event.value instanceof Date)
			{   
				var fieldValue = oGrid_Event.value.format('Y-m-d');
			} else
			{
				var fieldValue = oGrid_Event.value;
			}	

            Ext.Ajax.request({
				waitMsg: 'Salvando...',
				url: 'funcionarios/salvar.php', 
				
				params: { 
					acao: "update",
					id_usuario: oGrid_Event.record.data.id_usuario,
					campo: oGrid_Event.field,
					valor: fieldValue,     
					originalValue: oGrid_Event.record.modified						
				},
				failure:function(response,options){
					Ext.MessageBox.alert('Erro', 'Nao pode salvar...');
					ds.rejectChanges();
				},
				
				success:function(response, options){
					ds.commitChanges();						
				}
            });
	});	

	ds.load({params:{start: 0, acao:'listarDados', limit: 30}});

Ext.getCmp('tabss').add(grid);
Ext.getCmp('tabss').setActiveTab(grid);

}




Ext.grid.CheckColumn = function(config){
    Ext.apply(this, config);
    if(!this.id){
        this.id = Ext.id();
    }
    this.renderer = this.renderer.createDelegate(this);
};

Ext.grid.CheckColumn.prototype ={
    init : function(grid){
        this.grid = grid;
        this.grid.on('render', function(){
            var view = this.grid.getView();
            view.mainBody.on('mousedown', this.onMouseDown, this);
        }, this);
    },

    onMouseDown : function(e, t){
        if(t.className && t.className.indexOf('x-grid3-cc-'+this.id) != -1){
            e.stopEvent();
            var index = this.grid.getView().findRowIndex(t);
            var record = this.grid.store.getAt(index);
			var vl = record.data['ativo'] == 0 ? false : true;
			var valor2  = record.data['ativo'] == 0 ? 1 : 0;
			
			record.set(this.dataIndex, !vl);			
			
            Ext.Ajax.request({
				waitMsg: 'Salvando...',
				url: 'funcionarios/salvar.php', 
				
				params: { 
					acao: "update",
					id_usuario: record.data['id_usuario'],
					campo: 'ativo',
					valor: valor2,
					originalValue: record.modified							
				},
				failure:function(response,options){
					Ext.MessageBox.alert('Erro', 'Nao pode salvar...');
					ds.rejectChanges();
				},
				
				success:function(response, options){
					ds.commitChanges();
				}
			});
        }
    },

    renderer : function(v, p, record){
		var check = '';
		if(record.data.ativo == 0) {								
			check = '';
		} else {
			check = '-on';
		}			
		
        p.css += ' x-grid3-check-col-td'; 
        return '<div class="x-grid3-check-col'+( check )+' x-grid3-cc-'+this.id+'">&#160;</div>';
    }
};


