// JavaScript Document
Ext.ns('Ext.ux.form');

/**
  * @class Ext.ux.form.XDateField
  * @extends Ext.form.DateField
  */
Ext.ux.form.XDateField = Ext.extend(Ext.form.DateField, {
     submitFormat:'Y-m-d'
    ,onRender:function() {

        // call parent
        Ext.ux.form.XDateField.superclass.onRender.apply(this, arguments);

        var name = this.name || this.el.dom.name;
        this.hiddenField = this.el.insertSibling({
             tag:'input'
            ,type:'hidden'
            ,name:name
            ,value:this.formatHiddenDate(this.parseDate(this.value))
        });
        this.hiddenName = name; // otherwise field is not found by BasicForm::findField
        this.el.dom.removeAttribute('name');
        this.el.on({
             keyup:{scope:this, fn:this.updateHidden}
            ,blur:{scope:this, fn:this.updateHidden}
        }, Ext.isIE ? 'after' : 'before');

        this.setValue = this.setValue.createSequence(this.updateHidden);

    } // eo function onRender

    ,onDisable: function(){
        // call parent
        Ext.ux.form.XDateField.superclass.onDisable.apply(this, arguments);
        if(this.hiddenField) {
            this.hiddenField.dom.setAttribute('disabled','disabled');
        }
    } // of function onDisable

    ,onEnable: function(){
        // call parent
        Ext.ux.form.XDateField.superclass.onEnable.apply(this, arguments);
        if(this.hiddenField) {
            this.hiddenField.dom.removeAttribute('disabled');
        }
    } // eo function onEnable

    ,formatHiddenDate : function(date){
        if(!Ext.isDate(date)) {
            return date;
        }
        if('timestamp' === this.submitFormat) {
            return date.getTime()/1000;
        }
        else {
            return Ext.util.Format.date(date, this.submitFormat);
        }
    }

    ,updateHidden:function() {
        this.hiddenField.dom.value = this.formatHiddenDate(this.getValue());
    } // eo function updateHidden

}); // end of extend

// register xtype
Ext.reg('xdatefield', Ext.ux.form.XDateField);

// eof 

CadGrupos = function(){

	if(perm.CadGrupos.acessar == 0){
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

var PrecoGrupo;
var selectedKeys;
var cad_grupos;
var NovoGrupo;
var print_grupos;
var gruposel;
var win_relatorio_grupo;

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
			{name: 'itens'},
			{name: 'comstok'},
			{name: 'ctatual'},
			{name: 'vlatual'}
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
						{header: "Nombre", width: 150, align: 'left', sortable: true, dataIndex: 'nom_grupo',
						editor: new Ext.form.TextField({
														 allowBlank: false,
														 selectOnFocus:true,
														 allowNegative: false	
														 })
						},
						{id:'data',header: "Cadastrado em", width: 50, dataIndex: 'data'},
						{header: "Itens Cadastrados", width: 50, align: 'left', sortable: true, dataIndex: 'itens'},
						{header: "Itens com Stok", width: 50, align: 'left', sortable: true, dataIndex: 'comstok'},
						{header: "Custo Atual", width: 50, align: 'right', sortable: true, renderer: 'usMoney', dataIndex: 'ctatual'},
						{header: "Valor Atual", width: 50, align: 'right', sortable: true, renderer: 'usMoney', dataIndex: 'vlatual'}
			
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
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
					text: 'Produtos do Grupo',
					style: 'margin-left:7px',
					iconCls: 'icon-print',
					handler: function(){
						relatorioGrupo();
					}
					},
					{
                    xtype:'button',
					text: 'Ventas por periodo',
					style: 'margin-left:7px',
					iconCls: 'icon-periodo',
					handler: function(){
						ventasGrupo();
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
				iconCls:'icon-reajuste',
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
			id			: 'FormGrupos',
            closable	: true,
			frame		: true,
            split       : true,
            autoWidth   : true,
			closeAction: 'destroy',
			layout		: 'form',
			items:[grid_Grupos],
			listeners: {
						destroy: function() {
						//	if(PrecoGrupo instanceof Ext.Window)
                       //     PrecoGrupo.destroy(); 
						//	if(NovoGrupo instanceof Ext.Window)
						//	NovoGrupo.destroy(); 
         				}
			         }
        }); 
 FormGrupos.on('destroy', function(){
				 if(PrecoGrupo instanceof Ext.Window)
                 PrecoGrupo.destroy(); 
				 setTimeout(function(){
				 if(NovoGrupo instanceof Ext.Window)
				 NovoGrupo.destroy(); 
		     	  }, 250);
			  })
 

 FormCadGrupo= new Ext.FormPanel({
            title       : 'Cadastrar Novo Grupo',
			frame		: true,
            split       : true,
            autoWidth   : true,
			closeAction: 'destroy',
			layout		: 'form',
			autoHeight	: true,
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
				   
				   {
				    xtype:'combo',
                    name: 'sitReajusta',
                    id: 'sitReajusta',
                    hideTrigger: false,
                    store: [
                            ['Alta', 'Alta'],
                            ['Baixa', 'Baixa']
                            ],
                    fieldLabel: 'Reajuste',
                    allowBlank: false, //permitir ou não branco, será validado ao sair do campo.
                    displayField: 'sitReajusteD', //campo a ser exibido, de acordo com o mapemanto feito no objeto store
                    hiddenName: 'sitReajustaVal', //nome do campo Hidden que será criado automaticamente para receber o valor do item selecionado no combobox
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

                	},
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

var ventasGrupo = function(){
var selectedKeys = grid_Grupos.selModel.selections.keys;
if(selectedKeys.length > 0){		

var selectedRows = grid_Grupos.selModel.selections.items;
var selectedKeys = grid_Grupos.selModel.selections.keys; 
	
var win_ventas_grupo = new Ext.Window({
					id: 'win_ventas',
					title: 'Relatorio de Ventas por Periodo',
					width: 300,
					height: 160,
					modal: true,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: [
							FormVentasGrupo= new Ext.FormPanel({
							frame		: true,
							id: 'FormVentasGrupo',
							url:        'pdf_ventas_grupo.php',
							split       : true,
							items:[
								   {
									xtype:'datefield',
									fieldLabel: 'De',
									name: 'dtini'
									},
									{
									xtype:'datefield',
									fieldLabel: 'Hasta',
									name: 'dtfim'
									},
									{
									xtype: 'button',
									text: 'Relatorio',
									iconCls: 'icon-pdf',
									handler: function(){
									dtini = FormVentasGrupo.getForm().findField('dtini').getValue();
									dtfim = FormVentasGrupo.getForm().findField('dtfim').getValue(); 
									
									dtini = Ext.util.JSON.encode(dtini);
									dtfim = Ext.util.JSON.encode(dtfim);
									
								jsonDataini = dtini.substring(1,dtini.length-10);
								jsonDatafim = dtfim.substring(1,dtfim.length-10);
									
									function popup(){
											void(open('pdf_ventas_grupo.php?id='+selectedKeys +'&dtini='+jsonDataini +'&dtfim='+jsonDatafim +'','','width=800, height=700'));
											}
									popup();
									}
									}
									]		
						})
						],
						buttons: [
           						{
            					text: 'Salir',
            					handler: function(){ // fechar	
     	    					win_ventas_grupo.destroy();
  			 					}
			 
        					}]
				});
win_ventas_grupo.show();
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
					, autoHeight: true
	                , closeAction :'hide'
	                , plain: true
					, resizable: false
					, modal: true
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
            					text: 'Fechar',
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
	                ,layout: 'form'
	                , width: 400
					, height: 130
	                , closeAction :'hide'
	                , plain: true
					, resizable: true
					, modal: true
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

Ext.getCmp('tabss').add(FormGrupos);
Ext.getCmp('tabss').setActiveTab(FormGrupos);
FormGrupos.doLayout();	
			

}