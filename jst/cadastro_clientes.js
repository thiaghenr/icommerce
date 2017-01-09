// JavaScript Document


var ClienteWindow;
var tela;

Ext.onReady(function(){
					 
Ext.get("cadastro_clientes").on('click',function(s,e){
    Ext.QuickTips.init();

    Ext.form.Field.prototype.msgTarget = 'side';

    var bd = Ext.getBody();

    var tela = new Ext.FormPanel({
        labelAlign: 'left',
        frame:true,
        title: 'Cadastro de Clientes',
        bodyStyle:'padding:5px 5px 0',
        width: 450,
		height: 470,
        items: [{
            layout:'column',
            items:[{
                columnWidth:.5,
                layout: 'form',
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Nome',
					id: 'nomeCad',
                    name: 'nomeCad',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('razaoCad').focus();
                            }}

                }, 
					{
                    xtype:'textfield',
                    fieldLabel: 'Ruc',
                    name: 'rucCad',
					id: 'rucCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('cedulaCad').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Endereco',
					id: 'enderecoCad',
                    name: 'enderecoCad',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('emailCad').focus();
                            }}
                },
                    new Ext.ux.MaskedTextField({
					mask:'phone',
                    fieldLabel: 'Telefone',
					id: 'telefonecomCad',
                    name: 'telefonecomCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('faxCad').focus();
                            }}
                }),
					
                    new Ext.ux.MaskedTextField({
					mask:'phone',
                    fieldLabel: 'Celular',
					id: 'celularCad',
                    name: 'celularCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('limiteCad').focus();
                            }}
                }),
					{
                    xtype:'textfield',
                    fieldLabel: 'Contato1',
					id: 'contato1Cad',
                    name: 'contato1Cad',
                    anchor:'95%',
					value: '',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('contato2Cad').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Contato2',
					id: 'contato2Cad',
                    name: 'contato2Cad',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('cadastrarCad').focus();
                            }}
				}
					
					]
            },
				{
                columnWidth:.5,
                layout: 'form',
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Razao Social',
					id: 'razaoCad',
                    name: 'razaoCad',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('rucCad').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Cedula',
					id: 'cedulaCad',
                    name: 'cedulaCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('enderecoCad').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Email',
					id: 'emailCad',
                    name: 'emailCad',
                    vtype:'email',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('telefonecomCad').focus();
                            }}
                },
					
                    new Ext.ux.MaskedTextField({
					mask:'phone',
                    fieldLabel: 'Fax',
					id: 'faxCad',
                    name: 'faxCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('celularCad').focus();
                            }}
                }),
                    new Ext.ux.MaskedTextField({
					mask:'decimal',
					textReverse : true,
                    fieldLabel: 'Limite',
					id: 'limiteCad',
                    name: 'limiteCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('contatoCad1').focus();
                            }}
                })
				
				
				]
            }]
        },
			{
            xtype:'htmleditor',
            id:'obscliCad',
			name: 'obscliCad',
            fieldLabel:'Observacao',
            height:120,
            anchor:'82%'
        }],
		
        buttons: [{
			id: 'cadastrar',
            text: 'Cadastrar',
			handler: function(){
			tela.getForm().submit({
				url: "php/cadastra_cliente.php"
				, waitMsg: 'Cadastrando'
				, waitTitle : 'Aguarde....'
				, scope: this
				, success: OnSuccess
				, failure: OnFailure
			}); 
			function OnSuccess(form,action){
				alert(action.result.msg);
			}
			
			function OnFailure(form,action){
				alert(action.result.msg);
			}
			}
        },
		{
            text: 'Fechar',
			handler: function(){ // Fun??o executada quando o Button ? clicado
     	    ClienteWindow.hide();
			tela.getForm().submit();
  			 }

        }]
    });

    if (ClienteWindow == null)
			{
				ClienteWindow = new Ext.Window({
					id:'ClienteWindow'
					, title: "CP SA"
	                , layout: 'fit'
	                , width: '65%'
					, height: 450
				   
	                , closeAction :'hide'
	                , plain: true
					, modal: false
					, items: tela
					,focus: function(){
 	    						Ext.get('nomeCad').focus();
									}
					

				});
			}

  ClienteWindow.show();
			
			
			
			
			
			});	
		});
