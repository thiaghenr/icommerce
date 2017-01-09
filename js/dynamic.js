/*
 * Ext JS Library 2.2.1
 * Copyright(c) 2006-2009, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

Ext.onReady(function(){

    Ext.QuickTips.init();

    // turn on validation errors beside the field globally
    Ext.form.Field.prototype.msgTarget = 'side';

    var bd = Ext.getBody();

    /*
     * ================  Form 3  =======================
     */


    var top = new Ext.FormPanel({
        labelAlign: 'top',
        frame:true,
        title: 'Cadastro de Clientes',
        bodyStyle:'padding:5px 5px 0',
        width: 750,
        items: [{
            layout:'column',
            items:[{
                columnWidth:.5,
                layout: 'form',
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Nome',
                    name: 'nome	',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('razao').focus();
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
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('email').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Telefone',
					id: 'fone',
                    name: 'fone',
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
                    fieldLabel: 'Contato1',
					id: 'contato1',
                    name: 'contato1',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('contato2').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Contato2',
					id: 'contato2',
                    name: 'contato2',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('obs').focus();
                            }}
				}
					
					]
            },{
                columnWidth:.5,
                layout: 'form',
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Razao Social',
					id: 'razao',
                    name: 'razao',
                    anchor:'95%',
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
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('fone').focus();
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
                    fieldLabel: 'Limite',
					id: 'limite',
                    name: 'limite',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('contato1').focus();
                            }}
                }
				
				
				]
            }]
        },{
            xtype:'htmleditor',
            id:'obs',
			name: 'obs',
            fieldLabel:'Observacao',
            height:120,
            anchor:'82%'
        }],

        buttons: [{
            text: 'Save'
        },{
            text: 'Cancel'
        }]
    });

    top.render(document.body);

  });