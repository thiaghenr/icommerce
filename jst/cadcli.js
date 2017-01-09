// JavaScript Document

Ext.onReady(function(){
    Ext.QuickTips.init();
	
	
var	cli = Ext.get('cli'); 
cli.on('click', function(e){  
	
	
	

    Ext.form.Field.prototype.msgTarget = 'side';

   var bd = Ext.getBody();

    var top = new Ext.FormPanel({
		//id: 'top',
        labelAlign: 'top',
        frame:true,
//        title: 'Cadastro de Clientes',
        bbodyStyle:'padding:5px 5px 0',
        width: 750,
        items: [{
            layout:'column',
            items:[{
                columnWidth:.5,
                layout: 'form',
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Nome',
					id: 'nome',
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
                    fieldLabel: 'Contato1',
					id: 'contato1',
                    name: 'contato1',
                    anchor:'95%',
					value: '',
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
							   document.getElementById('cadastrar').focus();
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
        },
			{
            xtype:'htmleditor',
            id:'obs',
			name: 'obs',
            fieldLabel:'Observacao',
            height:120,
            anchor:'82%'
        }],
		
        buttons: [{
			id: 'cadastrar',
            text: 'Cadastrar',
			handler: function(){
			top.getForm().submit({
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
        }]
    });
focus('nome');


	//Criando Janela Exibicao Resultado
	win = new Ext.Window({
		id: 'res_curva',
		title: 'Cadastro de Clientes',
		width:768,
		height:628,
		autoScroll: true,
		shim:true,
		closable : true,
		html: '<div id=\'CA\'></div><br /><div id=\'CB\'></div><br /><div id=\'CC\'></div>',
		layout: 'anchor',
		resizable: false,
		draggable: true, //Movimentar Janela
		plain: true,
		modal: false, //Bloquear tela do fundo
		items:[top],
		buttons: [
           	{
            text: 'Cerrar',
            handler: function(){ // fechar	
     	    win.destroy();
			//document.getElementById("cod").focus();
  			 }
			 
        }],
		focus: function(){
 	    Ext.get('nome').focus();
		}
		
	});

	win.show();


	});
  });
  