Ext.define('app.view.NestParceiros', {
	extend: 'Ext.NestedList',
	xtype: 'nest-view',
    requires: [
        'Ext.field.Select',
        'Ext.field.Search',
		'Ext.data.TreeStore'
    ],
    config: {
		store: 'Parceiros',
		layout:    "card",
		animation: "slide",
		useTitleAsBackText: false,
		backText: 'Volver',
        displayField: 'title',
		listConfig: {
		//	itemTpl: new Ext.XTemplate('Nombre:{title} </br> &nbsp&nbsp Ciudad: {endereco}')
		},
		items: [],
        listeners: {
			back: function() {
				this.getDetailCard().removeAll();
			},
			itemtap: function(nestedList, list, index, element, post) {
				//this.getDetailCard().setHtml(post.get('title'));
				texto = post.get('title');
				seq = post.get('seq');
				if(seq == 1){ idParceiro = post.get('CardCode');}
					menu = post.data.text;
					console.info(texto);
				Ext.getStore('ParceirosDetalhesStore').load(({params:{'query': idParceiro, 'coluna': 'CardCode'}}));
				if (texto == "Catastro"){									
					
					  this.getDetailCard().add(
						{
						xtype: 'contactPage',
						title: 'Parceros',
						iconCls: 'user',
						dockedItems: [
							{
							xtype: 'toolbar',
							dock: 'top'
							}
						]
						}
					);    				
					var store = Ext.getStore('ParceirosDetalhesStore');
					var parceiroForm = Ext.getCmp('contactForm');
					parceiroForm.setRecord(store.getAt(0));
					
				}
				if (texto == "Pedidos"){	
					Ext.getStore('ParceirosPedidosStore').load(({params:{'query': idParceiro, 'coluna': 'controle_cli', 'acao': 'PedidosParceiro' }}));
					  this.getDetailCard().add(
						{
						xtype: 'pedidosParceiros',
						title: 'Pedidos',
						iconCls: 'user',
						dockedItems: [
							{
							xtype: 'toolbar',
							title: 'Pedidos',
							dock: 'top'
							}
						]
						}
					);    				
					var storePedidos = Ext.getStore('ParceirosPedidosStore');
				//	var parceiroForm = Ext.getCmp('contactForm');
				//	parceiroForm.setRecord(store.getAt(0));
					
				}
			},
            leafitemtap: function(me, list, index, item) {
			
            }
        },
		detailCard: {
            xtype: 'panel',
			layout: 'card',
            scrollable: null,
			//leaf: true,
            //styleHtmlContent: true,
			items:[
				{
				xtype: 'toolbar',
				docked: 'bottom',
				items: [
				
				]
				}
			]			 		
		},
		toolbar: {
			items: [
				{
				xtype: 'button', 
				text: 'Inicio',
				ui: 'back',
				handler: function(){Ext.Viewport.setActiveItem(Ext.create('app.view.Viewport'));
				}
				},
			/* 	{
                xtype: 'button',
                text: 'Volver',
				ui: 'back',
				id: 'navbar'
                }, */
				{
                xtype: 'searchfield',
                placeHolder: 'Buscar...',
				itemId: 'busca',
				width: '30%',
                listeners: {
                   //    scope: this,
                   //    clearicontap: this.onSearchClearIconTap,
                   //   keyup: this.onSearchKeyUp
                }
				},
				{
				xtype: 'selectfield',
				name: 'coluna',
							itemId: 'coluna',
							label: 'Buscar por',
							valueField: 'coluna',
							displayField: 'title',
							store: {
								data: [
									{ coluna: 'ItemCode', title: 'Codigo'},
									{ coluna: 'CardName', title: 'Descripcion'}
								]
							}
							},
							{
                            xtype: 'button',
                            text: 'Enviar',
                            ui: 'confirm',
                            handler: function() {
								var pesquisa = Ext.ComponentQuery.query('#busca')[0].getValue();
								var coluna =Ext.ComponentQuery.query('#coluna')[0].getValue();
								Ext.getStore('Parceiros').load(({params:{'query': pesquisa, 'coluna': coluna}}));
							}
							}							
							
							]
				}
    },


});