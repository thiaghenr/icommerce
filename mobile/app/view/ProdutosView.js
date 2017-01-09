Ext.define('app.view.ProdutosView', {
	extend: 'Ext.NestedList',
	xtype: 'produtos-view',
    requires: [
        'Ext.field.Select',
        'Ext.field.Search',
		'Ext.data.TreeStore'
    ],
    config: {
		
        //xtype: 'produtos-view',
        //title: 'Productos',
		listConfig: {
			itemTpl: new Ext.XTemplate('Cod:{ItemCode} </br>{ItemName} </br>Stk:{OnHand} &nbsp&nbsp Precio: {Price}')
		},
		useTitleAsBackText: false,
		backText: 'Volver',
		//id: 'BuscaProdutos',
        displayField: 'ItemName',
		labelAlign : 'right',
        store: 'ProdutosStore',
        detailCard: {
            xtype: 'panel',
			layout: 'card',
            scrollable: true,
			leaf: true,
            styleHtmlContent: true,
			items:[
				{
				xtype: 'toolbar',
				docked: 'bottom',
				items: [						
						]
				}
			]				
		},			
        listeners: {
			leafitemtap: function(me, list, index, target, record) {
				detailCard = me.getDetailCard();  
				//	detailCard.setHtml(record.get('nome'));
			},
            itemtap: function(nestedList, list, index, element, post) {
			this.getDetailCard().setHtml(post.get('desc'));
			idprod = post.get('DocEntry');
			detailCard = nestedList.getDetailCard();
			list.setMasked({
				xtype: 'loadmask',
				message: 'Loading'
			});
			Ext.Ajax.request({
				url: '/mobile/php/detalhes_produto.php?query=' +idprod,
				success: function(response) {
					detailCard.setHtml(response.responseText);
					list.unmask();
				},
				failure: function() {
					detailCard.setHtml("Verifique Signal.");
					list.unmask();
				}
			});
			}
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
				{
                xtype: 'searchfield',
                placeHolder: 'Buscar...',
				itemId: 'buscaprod',
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
									{ coluna: 'ItemName', title: 'Descripcion'}
								]
							}
							},
							{
                            xtype: 'button',
                            text: 'Enviar',
                            ui: 'confirm',
                            handler: function() {
								 pesquisa = Ext.ComponentQuery.query('#buscaprod')[0].getValue();
								 coluna = Ext.ComponentQuery.query('#coluna')[0].getValue();
								ProdutosStore.load(({params:{'query': pesquisa, 'coluna': coluna}}));
								
							
							}
							}							
							
							]
				}			
                
		}
});