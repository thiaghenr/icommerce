Ext.define('app.model.PedidosItensModel', {
    extend: 'Ext.data.Model',
    config: {
		fields: [
			{name:'ItemCode'}, 
			{name:'Dscription'}, 
			{name:'Quantity'}
			]
      /*  fields: ['ItemCode','Dscription','leaf','Quantity',{
                            name: 'leaf',
                            defaultValue: true
                        }] */
			
    }
});