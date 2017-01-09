Ext.define('app.store.ParceirosDetalhesStore', {
 extend: 'Ext.data.Store',
    config: {
		model: 'app.model.ParceirosDetalhesModel',
        storeId: 'ParceirosDetalhesStore', // use this as the value of the 'store' property in your list
        type: 'jsonp',
        root: { leaf: false },
        proxy:{
            type: 'ajax',
            url: '/php/detalhes_parceiros.php',
            reader: {
                type: 'json',
                rootProperty: 'items'
            }
        },
        autoLoad: false
    }
});
