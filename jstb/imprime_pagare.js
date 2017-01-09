

PrintPagare = function(){



var imprimirPagarePDF = function(){
var selectedKeys = Ext.getCmp('pedidoid').getValue();
if(selectedKeys.length > 0){	
																
var win_PagarePDF = new Ext.Window({
					title: 'Pedido',
					width: 650,
					height: 500,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='../pagare.php?id_pedido="+selectedKeys +"' > </iframe>" },
					buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_PagarePDF.destroy();
  			 					}
			 
        					}]
				});
				win_PagarePDF.show();
			}
else{
 Ext.Msg.alert('Erro','Informe el numero del pedido.');
}
}


FormPagare = new Ext.FormPanel({
            title       : 'Imprime Pagare',
			labelAlign: 'left',
			frame		: true,
			closable:true,
            autoWidth   : true,
			//height	: 350,
            collapsible : false,
			//layout:'border',
			items: [
				{
				xtype       : 'fieldset',
				title       : 'Informe numero del pedido',
				collapsible : false, 
				collapsed   : false,
				labelWidth: 50,
				autoHeight  : true,
				width		: 230,
				forceLayout : true,
				items: [
		  		{
			    xtype: 'textfield',
			    fieldLabel: 'Pedido',
			    name: 'pedidoid',
			    id: 'pedidoid',
				fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter 
									var selectedKeys = Ext.getCmp('pedidoid').getValue();
									imprimirPagarePDF();
									}
								}
			  },
		     {
			  xtype: 'button',
			  text: 'Gerar PDF',
			  iconCls: 'icon-pdf',
			  name: 'buscar',
			  handler: function(){ 
			  imprimirPagarePDF();
			  }
		  }
		   ]}
		   ]
		   
});



Ext.getCmp('tabss').add(FormPagare);
Ext.getCmp('tabss').setActiveTab(FormPagare);
FormPagare.doLayout();



}