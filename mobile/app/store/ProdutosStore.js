Ext.define('app.store.ProdutosStore', {
 extend: 'Ext.data.TreeStore',
    config: {
		model: 'app.model.ProdutosModel',
        storeId: 'ProdutosStore', // use this as the value of the 'store' property in your list
        type: 'tree',
        root: { 
			leaf: false 
		},
        proxy: {
            type: 'ajax',
            url: 'php/lista_produtos.php',
            reader: {
                type: 'json',
                rootProperty: 'resultados'
            }
        },
        autoLoad: false
    }
});
