Ext.define('app.view.home', {
	extend: 'Ext.Container',
	xtype: 'homePage',
	//layout:'vbox',
	config: {
	tabBarPosition: 'top',
	scrollable: true,
	scroll: 'vertical',
	layout: 'hbox',
            defaults: {
                margin: '2em',
                flex: .2
            },
            items: [
			{
                xtype: 'container',
                defaults: {
                    margin: '.4em'
                },
                items: [{
                    xtype: 'button',
                    //badgeText: '2',
                    text: 'Parceros',
					iconCls: 'user',
					width: 100,
					itemId: 'editButton',
                    iconAlign: 'top'
                }, {
                    xtype: 'button',
                    text: 'Pedidos',
                    iconCls: 'add',
					iconAlign: 'top',
					width: 100
                }
				/* , {
                    xtype: 'button',
                    text: 'Button',
                    badgeText: '2',
                    iconCls: 'add',
                    iconAlign: 'right',
					width: 100
                }, {
                    xtype: 'button',
                    text: 'Button',
                    iconCls: 'add',
                    iconAlign: 'bottom',
					width: 100
                }, {
                    xtype: 'button',
                    text: 'Button',
                    iconCls: 'user',
                    iconAlign: 'top',
					width: 100
                } */]
            }, {
                xtype: 'container',
                defaults: {
                    margin: '.4em',
                    ui: 'custom' // <-- If you want all buttons in a container to have a new ui class
                },
                items: [{
                    xtype: 'button',
                    text: 'Productos',
					iconAlign: 'top',
					iconCls: 'star',
					itemId: 'loadProds',
					width: 100
                }, 
				/* {
                    xtype: 'button',
                    badgeText: '2',
                    text: 'Button',
                    iconCls: 'add',
					width: 100
                }, {
                    xtype: 'button',
                    text: 'Button',
                    iconCls: 'add',
                    iconAlign: 'right',
					width: 100
                }, {
                    xtype: 'button',
                    text: 'Button',
                    badgeText: '2',
                    iconCls: 'add',
                    iconAlign: 'bottom',
					width: 100
                }, {
                    xtype: 'button',
                    text: 'Button',
                    iconCls: 'user',
					width: 100,
                    iconAlign: 'top'
                } */]
            }]
	/* ,
	html: [
					'<br>',
						'<br>',
						'<br>',
						'<br>',
                        '<img width=260 src="/imagens/logos/logo_sider.png" />',
                        '<h1>iCommerce</h1>',
                        "<p>Integracion ERP</p>",
                        '<h2>SiderAgro, TI</h2>'
                    ].join("") */
	},
initialize: function() {
this.callParent(arguments);
 
//console.log('homeView:initialize');
}
});