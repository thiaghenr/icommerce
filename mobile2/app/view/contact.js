Ext.define('app.view.contact', {
	extend: 'Ext.form.Panel',
	//requires: ['app.store.ParceirosDetalhesStore'],
	 xtype: 'contactPage',
	 config: {
		id: 'contactForm',
	//	store: 'ParceirosDetalhesStore',
		items:[
			{
			xtype : 'fieldset',
			title : 'Parceros de Negocio',
			items:[
				{
				xtype: 'textfield',
				name: 'CardCode',
				label: 'Codigo',
				readOnly: true
				},
				{
				xtype: 'textfield',
				name: 'title',
				label: 'Name',
				readOnly: true
				},
				{
				xtype: 'textfield',
				name: 'telefonecom',
				label: 'Telefono',
			//	placeHolder: '0983 340602',
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
				name: 'CardFName',
				label: 'Empresa',
				readOnly: true
				},
				{
				xtype: 'textfield',
				name: 'ruc',
				label: 'Ruc',
				readOnly: true
				},
				{
				xtype: 'textfield',
				name: 'vendedor',
				label: 'Vendedor',
				readOnly: true
				},
				{
				xtype: 'textfield',
				name: 'lista_precos',
				label: 'Lista Precios',
				readOnly: true
				}
			],
			},
			{
			xtype : 'fieldset',
			//title : 'Parceros de Negocio',
			layout: {
				type: 'vbox'
			},
			items:[
				
				{
				xtype: 'textfield',
				name: 'endereco',
				label: 'Direccion',
				readOnly: true
				},
				{
				xtype: 'textfield',
				name: 'cidade',
				label: 'Ciudad',
				readOnly: true
				},
				{
				xtype: 'textfield',
				name: 'bairro',
				label: 'Barrio',
				readOnly: true
				}
			]
			}
		]
		
	},
	initialize: function() {
	
	this.callParent(arguments);
		
		
		//Ext.create('app.store.ParceirosDetalhesStore');
	//	console.log('contactView:initialize');
	//Ext.getStore('ParceirosDetalhesStore');
	//var newRecord = new app.model.ParceirosDetalhesModel();
   //Ext.getStore('ParceirosDetalhesStore').add(newRecord);
   //var records = Ext.data.StoreManager.lookup('ParceirosDetalhesStore');
  // var myStore = Ext.getStore('ParceirosDetalhesStore');
//	console.log(records);

//		employeeForm = Ext.getCmp('contactForm');
		//store = Ext.create('app.store.ParceirosDetalhesStore');
//		var store = Ext.getStore('ParceirosDetalhesStore');
//		 console.log('sdsd',store.data)
	//	 employeeForm.setRecord(store.data.items[0].data );
	//	console.log(record);
     //projectForm.loadRecord(record);
	//	 var record = ParceirosDetalhesStore.getAt(0);
    
	}
});