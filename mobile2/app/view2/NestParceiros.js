Ext.define('app.view.NestParceiros', {
	extend: 'Ext.NestedList',
	//requires: ['app.store.Parceiros'],
	xtype: 'nest-view',
    requires: [
        'Ext.field.Select',
        'Ext.field.Search',
		'Ext.data.TreeStore'
    ],
    config: {
		store: 'Parceiros',
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
							this.getDetailCard().setHtml(post.get('title'));
							texto = post.get('title');
							menu = post.data.text;
							console.info(texto);
				if (texto == "Catastro"){				
					    return this.getDetailCard().add(
					{
					xtype: 'contactPage',
					title: 'Contact',
					iconCls: 'user',
					dockedItems: [
						{
						xtype: 'toolbar',
						dock: 'top'
						}
					]
					}
					);     
				}
			},
            leafitemtap: function(me, list, index, item) {
				/* console.info(index);
				return this.getDetailCard().add(
					{
					xtype: 'contactPage',
					title: 'Contact',
					iconCls: 'user',
					dockedItems: [
						{
						xtype: 'toolbar',
						dock: 'top'
						}
					]
					}
					); */
            }
        },
		detailCard: {
            xtype: 'panel',
			layout: 'card',
            scrollable: true,
			//leaf: true,
            //styleHtmlContent: true,
			items:[
				{
				xtype: 'toolbar',
				docked: 'bottom',
				items: [
				
				]
				}/* ,
				{
					xtype: 'contactPage',
					title: 'Contact',
					iconCls: 'user',
					dockedItems: [
						{
						xtype: 'toolbar',
						dock: 'top'
						}
					]
				} */
			]			 		
		},
		toolbar: {
			items: [
				{
                xtype: 'searchfield',
                placeHolder: 'Buscar...',
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
							id: 'coluna',
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
								var pesquisa = Ext.getCmp('busca').getValue();
								var coluna = Ext.getCmp('coluna').getValue();
								Ext.getCmp('BuscaProdutos').getStore().load(({params:{'query': pesquisa, 'coluna': coluna}}));
							}
							}							
							
							]
				}
    },


});