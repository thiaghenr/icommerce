Ext.define('app.model.ProdutosModel', {
    extend: 'Ext.data.Model',
    config: {
       fields: ['DocEntry','ItemName','ItemCode', 'OnHand',{
                            name: 'leaf',
                            defaultValue: true
                        }]
			
    }
});