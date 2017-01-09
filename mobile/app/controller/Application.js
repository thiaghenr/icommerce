Ext.define('app.controller.Application', {
    extend: 'Ext.app.Controller',

    config: {
        refs: {
            editButton: 'homePage #editButton',
			navBar: '#navbar', 
			ProdVoltar: '#ProdVoltar',
			openProdutos: 'homePage #loadProds'
        },

        control: {
           
            editButton: {
                tap: 'onContactEdit'
            },
			openProdutos: {
                tap: 'onLoadProds'
            },
			navBar: {
				tap: 'onBack' 
			},
			ProdVoltar: {
				tap: 'onProdVoltar' 
			}
        }
    },
	
	onContactEdit: function() {
		Ext.Viewport.animateActiveItem({
			xtype: 'nest-view'
			},
			{type: 'slide',direction: 'left'});
	},
	onLoadProds: function() {
		Ext.Viewport.animateActiveItem({
			xtype: 'produtos-view'
			},
			{type: 'slide',direction: 'left'});
	},
	onBack: function (view, item) {
		
		Ext.Viewport.animateActiveItem({
			xtype: 'homePage'
			},
			{type: 'slide',direction: 'right'});
	},
	onProdVoltar: function (view, item) {
		Ext.Viewport.animateActiveItem({
			xtype: 'homePage'
			},
			{type: 'slide',direction: 'right'});
	},
	
	
	
	
});