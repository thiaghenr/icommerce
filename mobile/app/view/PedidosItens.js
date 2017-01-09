Ext.define('app.view.PedidosItens', {
	extend: 'Ext.dataview.List',
	xtype: 'ItensPedido',
   // requires: [
    //    'Ext.field.Select',
    //    'Ext.field.Search',
	//	'Ext.data.Store'
   // ],
    config: {
		store: 'PedidosItensStore',
		//id: 'itens',
		//layout:    "fit",
		//animation: "slide",
		useTitleAsBackText: false,
		backText: 'Volver',
        displayField: 'ItemCode',
		 itemTpl: [
            '<div class="headshot" style="background-image:url(resources/images/headshots/{headshot});"></div>',
            '{firstName} {lastName}',
            '<span>{title}</span>'
        ].join('')
	},
	initialize: function() {
	console.log('ItensPedido');
	this.callParent(arguments);
	}
});