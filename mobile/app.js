// Main application entry point
//Ext.Loader.setConfig({enabled:true});
Ext.application({
	requires : [
		'app.view.Viewport',
		'app.view.contact',
		'app.view.home',
		'app.view.NestParceiros',
		'app.view.ProdutosView',
		'app.view.ParceirosPedidos',
		//'app.view.PedidosItens'
	],
	 //requires: ['app.store.ParceirosDetalhesStore'],
	name: 'app',
	controllers: ['Application'],
	//views: ['home'],
	models: [ 'Parceiros','ProdutosModel','ParceirosDetalhesModel','ParceirosPedidosModel'],
	stores: [ 'Parceiros','ProdutosStore','ParceirosDetalhesStore','ParceirosPedidosStore'],
	autoCreateViewport: true,
	launch: function() {
//console.log('app:launch');
Ext.create("app.view.Viewport");
 }
});







/*global Ext:false 
Ext.application({
    launch: function () {
        var contactForm = Ext.create('Ext.form.FormPanel', {
            fullscreen: true,
            items: [{
                xtype: 'titlebar',
                title: 'FormPanel example',
                docked: 'top'
            }, {
                xtype: 'fieldset',
                items: [{
                    xtype: 'textfield',
                    name: 'fname',
                    label: 'First name:'
                }, {
                    xtype: 'textfield',
                    name: 'lname',
                    label: 'Last name:'
                }] // items
            }, {
                xtype: 'toolbar',
                layout: {
                    pack: 'center'
                }, // layout
                ui: 'plain',
                items: [{
                    xtype: 'button',
                    text: 'Reset',
                    ui: 'decline',
                    handler: function (btn, evt) {
                        Ext.Msg.confirm('', 'Are you sure you want to reset this form?', function (btn) {
                            if (btn === 'yes') {
                                contactForm.setValues({
                                    fname: '',
                                    lname: ''
                                }); // contactForm()
                            } // switch
                        }); // confirm()
                    }
                }, {
                    xtype: 'button',
                    text: 'Submit',
                    ui: 'confirm',
                    handler: function (btn, evt) {
                        var values = contactForm.getValues();
                        Ext.Msg.alert('Welcome', Ext.String.format('{0} {1}', values.fname, values.lname));
                    } // handler
                }] // items (toolbar)
            }] // items (formpanel)
        }); // create()
    } // launch
}); // application()

*/