// JavaScript Document


AltSenha = function(e){
							   

Ext.QuickTips.init();

var TemplateSenha = [
'<SenhaTpl for=".">',
'</br>'
,'<b>Nome: </b>{nome}<br/>'
,'<b>Usuario: </b>{usuario}<br/>'
,'</SenhaTpl>'
];

//var meuSenhaTpl = new Ext.Template(meuTemplate);
SenhaTpl = new Ext.XTemplate(TemplateSenha)

var focou = function(){
setTimeout(function(){
Ext.get('usuario').focus();
}, 450);
}
var focon = function(){
Ext.get('nsenha').focus();
}
var foco = function(){
usuario = '';
Ext.getCmp('NovaSenha').setVisible(false);
SenhaTpl.overwrite(formSenhaTpl.body, {nome:'', usuario:''});
setTimeout(function(){
Ext.get('senhaAlt').focus();
}, 450);
}

	dsAltSenha = new Ext.data.Store({
    url: 'funcionarios/AltSenha.php',
    method: 'POST',
    reader:  new Ext.data.JsonReader({
				root: 'User',
				id: 'id_usuario',
				fields: [
				   {name: 'id_usuario'},
				   {name: 'nome'},
		           {name: 'nome_user'}
					]
			})					    
			
		})
 formSenhaTpl = new Ext.Panel({
 html: SenhaTpl.apply({nome:'', usuario:''})
	})

FormPass = new Ext.FormPanel({
			url: 'funcionarios/AltSenha',
			method: 'POST',
			id: 'FormPass',
			//baseCls: 'x-plain',
			//bodyStyle: 'padding: 2px;',
			frame:true,
			height: 300,
			closable: true,
			title: 'Alterar Senha',
			layout: 'form',	
			items:[
					{
					xtype       : 'fieldset',
					title       : 'Entre com o Seu Usuario e Senha',
					collapsible : false,   
					labelWidth: 50,
					labelAlign:'left',
					collapsed   : false,
					autoHeight  : true,
					forceLayout : true,
			items:[
				   {
                    xtype:'textfield',
                    fieldLabel: 'Usuario',
					id: 'usuario',
                    name: 'usuario',
                    width: 150,
					fireKey: function(e,type){
								//keydown:function(field, key){ //alert(key.getKey());
									if(e.getKey() == e.ENTER) {
            							Ext.get('senhaAlt').focus();
				 				//	}         
								}
					 }
				   },
				   {
                    xtype:'textfield',
                    fieldLabel: 'Senha',
					id: 'senhaAlt',
                    name: 'senhaAlt',
					inputType: 'password',
                    width: 150,
					fireKey: function(e,type){
								//keyup:function(field, key){ //alert(key.getKey());
									if(e.getKey() == e.ENTER) {
            							dsAltSenha.load({params:{usuario: Ext.get('usuario').getValue(), senha: Ext.get('senhaAlt').getValue(), acao:'verifica'}});
									}
								//}
					}
				   },
				   formSenhaTpl
				   ]
			},
			{
					xtype       : 'fieldset',
					title       : 'Entre com a nova senha',
					id: 'NovaSenha',
					labelWidth: 110,
					labelAlign:'right',
					collapsible : false,                    
					collapsed   : false,
					autoHeight  : true,
					forceLayout : true,
			items:[
				   {
                    xtype:'textfield',
                    fieldLabel: 'Nova Senha',
					id: 'nsenha',
                    name: 'nsenha',
					inputType: 'password',
                    width: 150,
					fireKey: function(e,type){
								//keyup:function(field, key){ //alert(key.getKey());
									if(e.getKey() == e.ENTER) {
            							Ext.get('csenha').focus();
				 					}         
								//}
					 }
				   },
				   {
                    xtype:'textfield',
                    fieldLabel: 'Confirmar',
					id: 'csenha',
                    name: 'csenha',
					inputType: 'password',
                    width: 150,
					fireKey: function(e,type){
							//	keyup:function(field, key){ //alert(key.getKey());
									if(e.getKey() == e.ENTER) {
										if(Ext.get('nsenha').getValue() == Ext.get('csenha').getValue()){
            							Ext.Ajax.request({ 
											waitMsg: 'Executando...',
											url: 'funcionarios/AltSenha.php',		
											params: { 
												usuario: usuario,
												nsenha: Ext.get('nsenha').getValue(),
												csenha:  Ext.get('csenha').getValue(),
												acao: 'AltSenha'
												},
									    callback: function (options, success, response) {
										if (success) { 
											var json = Ext.util.JSON.decode(response.responseText);
											if(json.response == 'Alterado'){
												Ext.getCmp('NovaSenha').setVisible(false);
												FormPass.getForm().reset();
												SenhaTpl.overwrite(formSenhaTpl.body, {nome:'', usuario:''});
												Ext.MessageBox.alert('Aviso', 'Senha alterada com Sucesso', focou);
											}
											if(json.response == 'Impossivel'){
												Ext.MessageBox.alert('Alerta', 'Nao foi possivel alterar, verifique');
											}
											} else{
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										}
									 });		
				 					} 
									else{
									Ext.MessageBox.alert('Alerta', 'As duas Senhas digitadas nao Conferem', focon);
								}
								}
								//}
								
					 }
				   },
				   {
					html: 
				   '* Enter para confirmar',
				   frame:true,
				   width: 265
				   }
				   ]
			}
			],
			listeners:{
			show: function(){	
			Ext.getCmp('NovaSenha').setVisible(false);
			}
			}
			});

dsAltSenha.on('load', function(){
	if(dsAltSenha.getTotalCount() > 0){
	usuario = dsAltSenha.getAt(0).get('id_usuario');
	SenhaTpl.overwrite(formSenhaTpl.body, dsAltSenha.reader.jsonData.User);
   	Ext.getCmp('NovaSenha').setVisible(true);
	Ext.get('nsenha').focus();
	}
	else{
		Ext.MessageBox.alert('Alerta', 'Dados nao Conferem', foco);
	}
    });

/*
AltPass = new Ext.Window({
		id: 'AltPass',
		title: 'Alterar Senha',
		width:600,
	    autoHeight: true,
		autoScroll: true,
		shim:true,
		closable : true,
		resizable: false,
		draggable: true, //Movimentar Janela
		plain: true,
		modal: false, //Bloquear tela do fundo
		items:[FormPass],
		buttons: [
           	{
            text: 'Fechar',
            handler: function(){ // fechar	
     	    AltPass.destroy();
  			 }
			 
        }],
		focus: function(){
				Ext.get('usuario').focus();
				}
		
	});
*/
/*
AltPass.on('show', function(){
		//	SenhaTpl.overwrite(formSenhaTpl.body, {nome:'', usuario:''});
		Ext.getCmp('NovaSenha').setVisible(false);
			});
*/

Ext.getCmp('tabss').add(FormPass);
Ext.getCmp('tabss').setActiveTab(FormPass);
FormPass.doLayout();
Ext.get('usuario').focus();

}
