Ext.define('app.model.ParceirosDetalhesModel', {
    extend: 'Ext.data.Model',
    config: {
        fields: [
			{name:'CardCode'}, 
			{name:'title'},
			{name:'seq'},
			{name:'CardFName'}, 
			{name:'CardName'},
			{name:'telefonecom'},
			{name:'ruc'},
			{name:'vendedor'},
			{name:'lista_precos'},
			{name:'endereco'},
			{name:'cidade'},
			{name:'bairro'}
			]
    }
});
