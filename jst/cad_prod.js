// JavaScript Document

	
	var ContatoWindow;
	var top;
	
		Ext.onReady(function() {
			
		    Ext.get("cadastro_prod").on('click',function(s,e){
			    Ext.QuickTips.init();

    Ext.form.Field.prototype.msgTarget = 'side';

    var bd = Ext.getBody();

    var top = new Ext.FormPanel({
        labelAlign: 'top',
        frame:true,
        title: 'Cadastro de Produtos',
        bodyStyle:'padding:5px 5px 0',
		height: 570,
		width: '70%',
		autoScroll:true,
        items: [{
            layout:'column',
            items:[{
                columnWidth:.3,
                layout: 'form',
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Codigo',
					iconCls:'icon-grid',
                    name: 'Codigo',
					id: 'Codigo',
                    anchor:'70%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   Ext.getCmp('Descricao').focus();
                            }}

                }, 
					{
                    xtype:'textfield',
                    fieldLabel: 'Codigo Fabrica 001',
                    name: 'Codigo_Fabricante',
					id: 'Codigo_Fabricante',
                    anchor:'70%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('Codigo_Fabricante2').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Codigo Original',
					id: 'cod_original',
                    name: 'cod_original',
                    anchor:'70%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('cod_original2').focus();
                            }}
                },
					{
                    xtype:'combo',
					hideTrigger: true,
					allowBlank: true,
					editable: true,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idmarca','marca'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
					fieldLabel: 'Marca',
					id: 'marca',
					minChars: 2,
					name: 'marca',
					anchor:'60%',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_marca.php?acao=1',
					root: 'resultados',
					fields: [ 'idmarca', 'marca' ]
					}),
						hiddenName: 'idmarca',
						valueField: 'idmarca',
						displayField: 'marca',
						fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('grupo').focus();
                            }}


							
                },
				
                    new Ext.ux.MaskedTextField({
                    fieldLabel: '% Margem A',
					id: 'margen_a',
                    name: 'margen_a',
					mask:'porcentagem',
					textReverse : true,
                    anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('margen_b').focus();
                            }}
                }),
				
					new Ext.ux.MaskedTextField({
                    fieldLabel: 'Valor A',
					id: 'vla',
                    name: 'vla',
					mask:'decimal',
					textReverse : true,
					renderer: 'usMoney',
                    anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('vlb').focus();
                            }}
							
                }),
					{
                    xtype:'textfield',
                    fieldLabel: 'Estoque',
					id: 'Estoque',
                    name: 'Estoque',
                    anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('qtd_min').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Embalagem',
					id: 'embalagem',
                    name: 'embalagem',
                    anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('local').focus();
                            }}
				},
				{
				xtype: 'fileuploadfield',
         		emptyText: 'Selecione um arquivo...',
         		fieldLabel: 'Imagem',
         		name: 'foto',
				id:'foto',
				permitted_extensions: ['jpg', 'jpeg', 'gif', 'png'],
				buttonCfg: { text: 'dfdfd', iconCls: 'upload-icon' },
         		anchor:'65%'
      			}
					
					]
            },
			//#################Segunda Coluna ####################################
				{
                columnWidth:.3,
                layout: 'form',
                items: [
				    {
                    xtype:'textfield',
                    fieldLabel: 'Descricao',
					id: 'Descricao',
                    name: 'Descricao',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('Descricaoes').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Codigo Fabrica 002',
					id: 'Codigo_Fabricante2',
                    name: 'Codigo_Fabricante2',
                    anchor:'70%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('Codigo_Fabricante3').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Codigo Original 2',
					id: 'cod_original2',
                    name: 'cod_original2',
                    anchor:'70%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('marca').focus();
                            }}
                },
					{
                    xtype:'combo',
					hideTrigger: true,
					allowBlank: true,
					editable: true,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['id','grupo'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
                    fieldLabel: 'Grupo	',
					id: 'grupo',
					minChars: 2,
                    name: 'grupo',
                    anchor:'60%',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_grupo.php?acao=1',
					root: 'resultados',
					fields: [ 'idgrupo', 'grupo' ]
			}),
						hiddenName: 'idgrupo',
						valueField: 'idgrupo',
						displayField: 'grupo',
						fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('margen_a').focus();
                            }}


							
                },
                    new Ext.ux.MaskedTextField({
                    fieldLabel: '% Margem B',
					id: 'margen_b',
                    name: 'margen_b',
					mask:'porcentagem',
					textReverse : true,
                    anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('margen_c').focus();
                            }}
                }),
				
                    new Ext.ux.MaskedTextField({
                    fieldLabel: 'Valor B',
					id: 'vlb',
                    name: 'vlb',
					mask:'decimal',
					textReverse : true,
                    anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('vlc').focus();
                            }}
                }),
				{
                    xtype:'textfield',
                    fieldLabel: 'Qtd. Min',
					id: 'qtd_min',
                    name: 'qtd_min',
                    anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('pr_min').focus();
                            }}
                },
				{
                    xtype:'textfield',
                    fieldLabel: 'Locacao',
					id: 'local',
                    name: 'local',
                    anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('iva').focus();
                            }}
                }
				
				
				]
            },
			//#################Terceira Coluna #################################### 
			 {
		       columnWidth:.3,
                layout: 'form',
                items: [
				    {
                    xtype:'textfield',
					icon: 'upload-icon',
                    fieldLabel: 'Descricao Esp',
					id: 'Descricaoes',
                    name: 'Descricaoes',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('Codigo_Fabricante').focus();
                            }}
				},
				{
                    xtype:'textfield',
                    fieldLabel: 'Codigo Fabrica 003',
					id: 'Codigo_Fabricante3',
                    name: 'Codigo_Fabricante3',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('cod_original').focus();
                            }}
                },
					{
					style: 'margin-top:88px',
					float:'left'
					 },
					
					new Ext.ux.MaskedTextField({
                    fieldLabel: '% Margem C',
					id: 'margen_c',
					mask:'porcentagem',
					textReverse : true,
                    name: 'margen_c',
                    anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('vla').focus();
                            }}
					
					
                }),
					
					new Ext.ux.MaskedTextField({
                    fieldLabel: 'Valor C',
					id: 'vlc',
                    name: 'vlc',
					mask:'decimal',
					textReverse : true,
                    anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('Estoque').focus();
                            }}
					
					
                }),
				
                    new Ext.ux.MaskedTextField({
                    fieldLabel: 'Preco Min',
					id: 'pr_min',
                    name: 'pr_min',
					mask:'decimal',
					textReverse : true,
                    anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('embalagem').focus();
                            }}
                }),
				{
                    xtype:'textfield',
                    fieldLabel: '% Imposto',
					id: 'iva',
                    name: 'iva',
                    anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('foto').focus();
                            }}
                }
				
				
				]
				}
			
			
			
			]
        },
		
		
		      		
			{
            xtype:'htmleditor',
            id:'obs',
			name: 'obs',
            fieldLabel:'Observacao',
            height:120,
            anchor:'72%'
        }],
		
        buttons: [{
			id: 'cadastrar',
            text: 'Cadastrar',
			handler: function(){
			top.getForm().submit({
				url: "php/cadastra_produto.php"
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
			handler: function(){ // Fun��o executada quando o Button � clicado
     	    ContatoWindow.hide();
  			 }

        }]
    });

    if (ContatoWindow == null)
			{
				ContatoWindow = new Ext.Window({
					id:'ContatoWindow'
					, title: "CP SA"
	                , layout: 'fit'
	                , width: '70%'
				    , autoScroll:true
	                , closeAction :'hide'
					, autoHeight: true
	                , plain: true
					, modal: false
					, items: top
					,focus: function(){
 	   					 Ext.get('Codigo').focus();
						}

				});
			}

  ContatoWindow.show();
			
			
			
			
			
			});	
		});
