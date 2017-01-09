Ext.define('app.view.Viewport', {
	extend: 'Ext.TabPanel',
 
	config:{
	fullscreen: true,
	tabBarPosition: 'top',
	items: [
		{
		xtype: 'homePage',
		title: 'Inicio',
		iconCls: 'home',
		layout: 'fit'
		},
		{
		xtype: 'nest-view',
		//layout: 'vbox',
		title: 'Parceros',
		iconCls: 'user',
		dockedItems: [
			{
			xtype: 'toolbar',
			dock: 'top'
			}
		]
		},
		{
		xtype: 'produtos-view',
		//layout: 'vbox',
		title: 'Productos',
		iconCls: 'star',
		dockedItems: [
			{
			xtype: 'toolbar',
			dock: 'top'
			}
		]
		},
		/*
		{
		xtype: 'contactPage',
		title: 'Contact',
		iconCls: 'user',
		dockedItems: [
			{
			xtype: 'toolbar',
			dock: 'top'
			}
		]
		}
		*/
	]
	}
})