Ext.define('app.store.Parceiros', {
 extend: 'Ext.data.TreeStore',
    config: {
		model: 'app.model.Parceiros',
        storeId: 'Parceiros', // use this as the value of the 'store' property in your list
        type: 'jsonp',
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

