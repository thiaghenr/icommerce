Ext.define('app.model.ParceirosPedidosModel', {
    extend: 'Ext.data.Model',
    config: {
		fields: [
			{name:'DocNum'}, 
			{name:'DocDate'}, 
			{name:'DocTotal'},
			{name:'status'}, 
		//	{name:'leaf'}
			]
      /*  fields: ['DocNum','DocDate','DocTotal', 'leaf', 'status',{
                            name: 'leaf',
                            defaultValue: true
                        }] */
			
    }
});