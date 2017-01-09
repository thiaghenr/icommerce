// JavaScript Document


MovCaixa = function(){



	
	
	//////// INICIO DA GRID DOS VENDIDOS ////////
var dsMovs = new Ext.data.GroupingStore({
		proxy: new Ext.data.HttpProxy({
			url: 'php/MovCaixa.php',
			method: 'POST'
		}), 
		groupField:'dia',
		sortInfo:{field: 'id', direction: "DESC"},
		nocache: true,
		reader:  new Ext.data.JsonReader({
			//totalProperty: 'totalProd',
			root: 'Movimento',
			id: 'id'
		},
			[
				   {name: 'id'},
				   {name: 'dia'},
				   {name: 'Historico'},
		           {name: 'entidade'},
		           {name: 'doc'},
		           {name: 'data'},
				   {name: 'tipo_pgto_descricao'},
		           {name: 'saida',type: 'float'},
				   {name: 'vl_pago'},
				   {name: 'entrada',type: 'float'},
				   {name: 'saldo'}
			]
		),
		sortInfo: {field: 'id', direction: 'DESC'},
		remoteSort: true,
		autoLoad: true
	});
	
	 Ext.grid.GroupSummary.Calculations['saida','entrada'] = function(v, record, field){
	//	precio = record.data.valorB;
	//	precio = precio.replace(".","");
		var v = v+ (parseFloat(record.data.entrada) - parseFloat(record.data.saida));   //toNum
		Ext.getCmp("SubTotal").setText((v));
		console.log(v);
	   // subnota =  Ext.get("SubTotal").getValue();
		//var frete = Ext.get("Frete").getValue();
		//var desc = Ext.get("valorDesc").getValue();

	
		//var freteA = frete.replace(".","");
		//var freteB = freteA.replace(",",".");
				
		subtotal =  v ;
		//geral = totalnota - desc
		Ext.getCmp("Total").setValue(Ext.util.Format.usMoney(v));
		return v;
		
    }
	
	 var summary = new Ext.grid.GroupSummary(); 
		gridMovs= new Ext.grid.EditorGridPanel({
			enableColLock: true,
			containerScroll  : false,
	        store: dsMovs, // use the datasource
	        columns:[
						{id:'id', width: 50, hidden: true, sortable: true, dataIndex: 'id'},
						{id:'Fecha', width: 50, hidden: true, sortable: true, dataIndex: 'dia'},
						{header: 'Historico', summaryType: 'count', width: 180, sortable: true, dataIndex: 'Historico',
						summaryRenderer: function(v, params, data){
						return ((v === 0 || v > 1) ? '(' + v +' Lanzamientos)' : '(1 Lanzamiento)');
						}},
						{header: "Entidade", width: 180, sortable: true, dataIndex: 'entidade'},
						{header: "Documento", width: 90, align: 'right', sortable: true, dataIndex: 'doc'},
						{header: "Fecha", groupable: true, width: 80,  align: 'right',  sortable: true, dataIndex: 'data'},
						{header: "Tipo Pgto", groupable: true, width: 80,  align: 'left',  sortable: true, dataIndex: 'tipo_pgto_descricao'},
						{header: "Salida", summaryType:'sum', width: 90, align: 'right', sortable: true, dataIndex: 'saida', renderer: 'usMoney'},
						{header: "Entrada", summaryType:'sum', width: 90, align: 'right', sortable: true, dataIndex: 'entrada', renderer: 'usMoney'},
						{header: "Saldo", width: 90, align: 'right', sortable: true, dataIndex: 'saldo', renderer: 'usMoney'}
			 ],
	        viewConfig:{
	            forceFit:true
	        },
			width:'100%',
			height: 300,
			ds: dsMovs,
			view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true
           // getRowClass: MudaCor
			}),
			plugins: summary,
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			autoScroll: true,
			bbar : new Ext.Toolbar({ 
			items: [
					{
					xtype:'button',
           			text: 'Imprimir',
					tooltip: 'Imprimir Relatorio',
					name: 'PrintMovDia',
					align: 'left',
					iconCls: 'icon-pdf',
            		handler: function(){ // fechar	
     	    			var win_rel_mov_dia = new Ext.Window({
						title: 'Movimientos del dia',
						width: 650,
						height: 500,
						shim: false,
						animCollapse: false,
						constrainHeader: true,
						maximizable: false,
						layout: 'fit',
						items: { html: "<iframe height='100%' width='100%' src='../relatorio_mov_dia.php?dia="+Ext.get('data').getValue()+"' > </iframe>" },
						buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_rel_mov_dia.destroy();
  			 					}
			 
        					}]
						});
						win_rel_mov_dia.show();
					}
					},
					'-'
					/*,
					{
					xtype: 'label',
					text: 'Saldo: ',
					style: 'font-weight:bold;color:yellow;text-align:left;'
					},
					{
					xtype: 'label',
					text: ' Saldo: ',
					id: 'SubTotal',
					style: 'font-weight:bold;color:yellow;text-align:left;'
					}
					*/
					]
			})
		});
 ////////FIM GRID DOS DETALHES ///////////////////////////////////////////////////
/*
 Movs = new Ext.FormPanel({
        width: '100%',
     //   activeTab: 0,
        frame:true,
        defaults:{autoHeight: true},
        items:[gridMovs]
				
    });
*/


 Diario = new Ext.FormPanel({
        title: 'Movimientos en efectivo',
       // collapsible:true,
	    id: 'Diario',
		closable: true,
		layout: 'form',
        items:[
				{
			    xtype: 'datefield',
			    fieldLabel: 'Fecha',
			    name: 'data',
			    width: 100
			   },
			   {
				  xtype: 'button',
				  text: 'Buscar',
				  name: 'buscar',
				  col: true,
				  iconcls: 'icon-search',
				  handler: function(){ 
				  dsMovs.load(({params:{'acao': 'MovDia', 'dataini': Diario.getForm().findField('data').getValue() }}));
										}
			  },gridMovs
				]
    });



// var tb = gridMovs.getTopToolbar();
// tb.addText( 'Saldo Anterior' );
 
Ext.getCmp('tabss').add(Diario);
Ext.getCmp('tabss').setActiveTab(Diario);
Diario.doLayout();	


};