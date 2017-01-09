Ext.define('app.model.ProdutosModel', {
    extend: 'Ext.data.Model',
    config: {
       fields: ['DocEntry','ItemName','ItemCode', 'onHand',{
                            name: 'leaf',
                            defaultValue: true
                        }]
			
    }
});