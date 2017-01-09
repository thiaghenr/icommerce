Ext.define('app.view.ParceirosPedidos', {
    extend: 'Ext.NestedList',
    xtype: 'pedidosParceiros',
	requires: [
        'Ext.field.Select',
        'Ext.field.Search',
		'Ext.data.TreeStore'
    ],
    config: {
        title: 'Address Book',
        cls: 'x-contacts',
		layout:    "card",
		animation: "slide",
		useTitleAsBackText: true,
		//backText: 'Pedidos',
		displayField: 'DocNum',
       // variableHeights: true,
        store: 'ParceirosPedidosStore',
        listConfig: {
			itemTpl: new Ext.XTemplate(
			'<table class="ll">'+
				'<tr class="ll">'+
					'<td class="ll"><span>{DocNum}</span></td>' +
					'<td class="ll" width = "3%" style="font-weight:bold;text-align: right; font-size:12px;">{DocDate}</td>'+
				'</tr>'+
                '<tr class="ll">'+
					'<td class="ll" style="font-weight:bold;text-align: left; font-size:12px;">{status}</td>'+
					'<td class="ll" width = "3%" style="font-weight:bold;text-align: right">{DocTotal}</td>'+
				'</tr>'+
			'</table>'
           
       )},
		listeners: {
			back: function() {
				this.getDetailCard().removeAll();
			},
			itemtap: function(me, list, index, element, post) {
				console.log('oi');
				texto = post.get('DocNum');
				idPedido = post.get('DocNum');
				texto = "texto";
				console.info(texto);
				//Ext.getStore('PedidosItensStore').load(({params:{'query': idPedido, 'acao': 'ListaItens', 'coluna': 'DocEntry'}}));
				if (texto == "texto"){		
					var store = list.getStore(),
					record  = store.getAt(index),	
					detailCard = me.getDetailCard();

                    list.setMasked({
                        xtype: 'loadmask',
                        message: 'Loading'
                    });

                    Ext.Ajax.request({
                        url: '/php/lista_itens_pedido.php?query=' + record.get('DocNum'),
                        success: function(response) {
                            detailCard.setHtml(response.responseText);
                            list.unmask();
                        },
                        failure: function() {
                            detailCard.setHtml("Loading failed.");
                            list.unmask();
                        }
                    });
					
				}
			}
		},
		detailCard: {
            xtype: 'panel',
			layout: 'card',
            scrollable: true,
		//	leaf: false,
         //   styleHtmlContent: true,
			items:[
				{
                    xtype: 'button',
                    iconCls: 'add',
                    iconMask: true,
                    text: 'add'
                }
				
			]			 		
		}
    },
 
  
	initialize: function() {
	this.callParent(arguments);
 
	console.log('homeView:initialize');
	}
	
});
