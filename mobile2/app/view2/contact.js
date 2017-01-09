Ext.define('app.view.contact', {
	extend: 'Ext.form.Panel',
	requires : [
		'app.store.ParceirosDetalhesStore'],
	 xtype: 'contactPage',
	 //id: 'contactForm',
	 config: {
		//id: 'contactForm',
		//store: 'ParceirosDetalhesStore',
		items:[
			{
			xtype : 'fieldset',
			title : 'Parceros de Negocio',
			items:[
				{
				xtype: 'textfield',
				name: 'CardCode',
				id: 'CardCode',
				label: 'Name',
				//placeHolder: 'Lorenzo Cacerez',
				readOnly: true
				},
				{
				xtype: 'textfield',
				name: 'name_contact',
				label: 'Telefono',
				placeHolder: '0983 340602',
				readOnly: true
				}
			]
			},
			{
			xtype : 'fieldset',
			//title : 'Parceros de Negocio',
			//instructions: 'All fields are required',
			layout: {
				type: 'vbox'
			},
			items:[
				
				{
				xtype: 'textfield',
				name: 'razao',
				label: 'Empresa',
				placeHolder: 'Repuestos San Lorenzo',
				readOnly: true
				},
				{
				xtype: 'textfield',
				name: 'ruc',
				label: 'Ruc',
				placeHolder: '6075078',
				readOnly: true
				},
				{
				xtype: 'textfield',
				name: 'vendedor',
				label: 'Vendedor',
				placeHolder: 'Andre Bogado',
				readOnly: true
				},
				{
				xtype: 'textfield',
				name: 'lista',
				label: 'Lista Precios',
				placeHolder: 'Lista 02',
				readOnly: true
				}
			],
			},
			{
			xtype : 'fieldset',
			//title : 'Parceros de Negocio',
			//instructions: 'All fields are required',
			layout: {
				type: 'vbox'
			},
			items:[
				
				{
				xtype: 'textfield',
				name: 'endereco',
				label: 'Direccion',
				placeHolder: 'Calle Cerro Leon 849',
				readOnly: true
				},
				{
				xtype: 'textfield',
				name: 'cidade',
				label: 'Ciudad',
				placeHolder: 'Ciudad Del Este',
				readOnly: true
				},
				{
				xtype: 'textfield',
				name: 'bairro',
				label: 'Barrio',
				placeHolder: 'San Jose',
				readOnly: true
				}
			]
			}
		]
	},
	initialize: function() {
		this.callParent(arguments);
		console.log('contactView:initialize');
		
		var myForm = Ext.ComponentQuery.query("contactPage")[0];
		// get pointer to first record in store
		var rec = Ext.getStore('ParceirosDetalhesStore');
		// load data from model into form
		// (assume model field names match form field names)
		myForm.setRecord(rec.data); 
		
		
		
		//var store=Ext.getStore("ParceirosDetalhesStore");
		// var record = store.getAt(0);
		 //var form = Ext.getCmp('contactPage');
		 console.info(myForm);
     //form.loadRecord(record);
	//form.load(record);
	}
});