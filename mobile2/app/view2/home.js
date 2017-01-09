Ext.define('app.view.home', {
	extend: 'Ext.Panel',
	xtype: 'homePage',
	config: {
	scrollable: true,
	scroll: 'vertical',
	html: [
					'<br>',
						'<br>',
						'<br>',
						'<br>',
                        '<img width=260 src="/imagens/logos/logo_sider.png" />',
                        '<h1>iCommerce</h1>',
                        "<p>Integracion ERP</p>",
                        '<h2>SiderAgro, TI</h2>'
                    ].join("")
	},
initialize: function() {
this.callParent(arguments);
 
//console.log('homeView:initialize');
},
});