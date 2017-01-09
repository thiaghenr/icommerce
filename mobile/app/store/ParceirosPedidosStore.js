Ext.define('app.store.ParceirosPedidosStore', {
 extend: 'Ext.data.TreeStore',
    config: {
		model: 'app.model.ParceirosPedidosModel',
        storeId: 'ParceirosPedidosStore', // use this as the value of the 'store' property in your list
        type: 'jsonp',
        root: { leaf: false },
        proxy:{
            type: 'ajax',
            url: '/php/pesquisa_pedido.php',
            reader: {
                type: 'json',
                rootProperty: 'results'
            }
        },
        autoLoad: false
    }
});
