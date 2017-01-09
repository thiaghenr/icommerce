Ext.define('app.store.PedidosItensStore', {
 extend: 'Ext.data.Store',
    config: {
		model: 'app.model.PedidosItensModel',
        storeId: 'PedidosItensStore', // use this as the value of the 'store' property in your list
        type: 'jsonp',
        root: { leaf: true },
        proxy:{
            type: 'ajax',
            url: '/php/lista_itens_pedido.php',
            reader: {
                type: 'json',
                rootProperty: 'results'
            }
        },
        autoLoad: false
    }
});
