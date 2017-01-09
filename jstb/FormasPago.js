// JavaScript Document


FomPgto = function(){


function formatDate(value){
        return value ? value.dateFormat('M d, Y') : '';
    }

var dsFormasPago = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/FormasPago.php',
			method: 'POST'
		}),   
		baseParams:{acao: "Listar"},
		reader:  new Ext.data.JsonReader({
			root: 'Formas',
			totalProperty: 'totalFormas',
			id: 'id'
		},
			[
				   {name: 'id'},
				   {name: 'descricao'},
		           {name: 'nm_total_parcela'},
		           {name: 'dt_vencimento', type:'date',  dateFormat: 'Y-m-d'}
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		autoLoad: true,
		remoteSort: true		
	});

	 var gridFormas = new Ext.grid.EditorGridPanel({
	        store: dsFormasPago, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "Pedido", hidden: true, width: 50, sortable: true, dataIndex: 'id'},
						{header: 'Descripcion', width:200, sortable: true, dataIndex: 'descricao'},
						{header: "Total de Quotas", width: 80, sortable: true, dataIndex: 'nm_total_parcela'},
						{header: "Vencimento", width: 120, align: 'right', sortable: true, renderer: Ext.util.Format.dateRenderer('d/m/Y'), dataIndex: 'dt_vencimento',
						 editor: new Ext.form.DateField({
														 allowBlank: false,
														 selectOnFocus:true,
														 allowNegative: false	
														 })
						}
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			width: 550,
			id: 'gridFormas',
			height: 148,
			ds: dsFormasPago,
			selModel: new Ext.grid.CellSelectionModel({singleSelect:false}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar : new Ext.Toolbar({ 
			items: [
			{
					xtype: 'label',
					text: 'Click sobre Vencimento para editar: ',
					style: 'font-weight:bold;color:yellow;text-align:left;' 
					}
					]
			}),
			listeners:{ 
        	afteredit:function(e){
			dsFormasPago.load(({params:{valor: e.value, acao: 'alterar', id: e.record.get('id'), campo: e.column}}));
	  		}
			}
			
		
});

var	FormasPago = new Ext.FormPanel({
		    width:'50%',
			layout      : 'form',
			closable: true,
			title:'Formas de Pago',
	        frame:true,
			border: true,
	        bodyStyle:'padding:5px 5px 0',
			items: [gridFormas]
			});



Ext.getCmp('tabss').add(FormasPago);
Ext.getCmp('tabss').setActiveTab(FormasPago);
FormasPago.doLayout();	

}