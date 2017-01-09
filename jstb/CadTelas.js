// JavaScript Document
CadTela = function(){

/*
if(perm.CadTelas.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}
*/
    Ext.QuickTips.init();
    Ext.form.Field.prototype.msgTarget = 'side';
	
	var FormCadTelas = new Ext.FormPanel({
        labelAlign: 'left',
		id: 'FormCadTelas',
        frame:true,
        title: 'Cadastro de Telas',
        bodyStyle:'padding:5px 5px 0',
        autoWidth: true,
		split: true,
		labelWidth: 140,
		labelAlign: 'right',
		closable: true,
		layout: 'form',
		autoScroll:true,
		allowBlank:false,
		onSubmit: Ext.emptyFn,
		blankText: 'Preencha o campo',
        items: [{
                    xtype:'textfield',
                    fieldLabel: 'Nome do Arquivo',
                    name: 'nome_tela',
					id: 'nome_tela',
					allowBlank: false,
                    width: 250,
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('nome_menu').focus() ; 

						}}
					}
                },
				{
                    xtype:'combo',
					hideTrigger: false,
					allowBlank: false,
					editable: true,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idtelas_grupo','nome_telagrupo'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
					fieldLabel: 'Menu',
					id: 'menu',
					minChars: 2,
					name: 'menu',
					width: 250,
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/ControleAcesso.php?acao=menu',
					root: 'resultados',
					autoLoad: true,
					fields: [ {name:'idtelas_grupo'}, {name:'nome_telagrupo'} ]
					}),
						hiddenName: 'idtelas_grupo',
						valueField: 'idtelas_grupo',
						displayField: 'nome_telagrupo'
						
                },
				{
                    xtype:'textfield',
                    fieldLabel: 'Localizacao no menu',
					id: 'nome_menu',
                    name: 'nome_menu',
					allowBlank: false,
                    width: 350,
					listeners: {
						keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.ENTER)){ 
							   Ext.getCmp('menu').focus() ; 

						}}
					}
                },
					{
					style: 'margin-top:30px',
					float:'left'
					 },
					{
					xtype:'button',
					text: 'Cadastrar',
					iconCls: 'icon-tela',
					tooltip: 'Cadastrar tela',
					handler: function(){
							FormCadTelas.getForm().submit({
								url: 'php/ControleAcesso.php', 
									params: {
										acao: 'CadTela'
										}
									, waitMsg: 'Salvando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
								}); 
							function OnSuccess(form,action){
								//alert(action.result.msg);
								dsControl.reload();
							}
			
							function OnFailure(form,action){
								//alert(action.result.msg);
							}
							}
					}
				]
		
	
	
	});
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
Ext.getCmp('tabss').add(FormCadTelas);
Ext.getCmp('tabss').setActiveTab(FormCadTelas);
FormCadTelas.doLayout();		
	
	
}