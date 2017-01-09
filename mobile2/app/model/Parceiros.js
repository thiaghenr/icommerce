Ext.define('app.model.Parceiros', {
    extend: 'Ext.data.Model',
    config: {
        fields: [
			{name:'title'}, 
			{name:'CardCode'}, 
			{name:'seq'},
			{name:'endereco'}, 
			{name:'leaf'}
			]
    }
});
