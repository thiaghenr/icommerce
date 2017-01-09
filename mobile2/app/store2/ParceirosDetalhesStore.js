Ext.define('app.store.ParceirosDetalhesStore', {
 extend: 'Ext.data.TreeStore',
    config: {
		model: 'app.model.ParceirosDetalhesModel',
        storeId: 'ParceirosDetalhesStore', // use this as the value of the 'store' property in your list
        type: 'tree',
        root: { leaf: false },
        proxy:{
            type: 'ajax',
            url: '/php/lista_parceiros.php',
            reader: {
                type: 'json',
                rootProperty: 'items'
            }
        },
        autoLoad: true
    }
});

