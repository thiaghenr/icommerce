Ext.define('app.view.Viewport', {
	extend: 'Ext.navigation.View',
	config:{
	cls : 'booked-seats', 
	fullscreen: true,
	tabBarPosition: 'top',
	layout: {
            type: 'card',
            animation: {
                type: 'slide',
                direction: 'left',
                duration: 300
            }
    },
	items: [
		{
        xtype: 'toolbar',
        docked: 'bottom',
        title: ''
        },
		{
		xtype: 'homePage',
		title: 'iCommerce',
		iconCls: 'home',
	//	layout: 'vbox'
		}/* ,
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
		}, */
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