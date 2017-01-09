// JavaScript Document


AbreDevolucao = function(){
//idpedidoFat = idpedidoFat;
//console.info(idpedidoFat);

Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
Ext.QuickTips.init();

var xgPedidoNT = Ext.grid;

dsNTCredito = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: '../sistema/php/NotasCredito.php',
        method: 'POST'
    }),   

reader:  new Ext.data.JsonReader({
			root: 'results',
			id: 'idnota_credito',
			remoteSort: true,
			fields: [
					 {name: 'idnota_credito',  type: 'string' },
					 {name: 'idcliente',  type: 'string' },
					 {name: 'idpedido',  type: 'string' },
                     {name: 'nome',  type: 'string' },
                     {name: 'dtlcto',  type: 'string' },
					 {name: 'vlcredito',  type: 'string'},
					 {name: 'devolvido',  type: 'string' },
					 {name: 'saldo', type: 'float'}
					 //{name: 'action1', type: 'string'},
   			         //{name: 'action2', type: 'string'}

					 ]
			})
		})
///////////// FIM STORE ////////////////////////
///////////// INICIO DA GRID //////////////////

	     var gridNTCredito = new Ext.grid.GridPanel({
	        store: dsNTCredito, // use the datasource
	       cm: new xgPedidoNT.ColumnModel([
		       
		        	//expander,
		            {id:'idnota_credito', width:40, header: "Nota C",  sortable: true, dataIndex: 'idnota_credito'},
					{ width:50, header: "Pedido",  sortable: true, dataIndex: 'idpedido'},
					{ width:50, header: "Cliente",  sortable: true, dataIndex: 'idcliente'},
					{ width:130, header: "Nombre",  sortable: true, dataIndex: 'nome'},
					{ width:80, header: "Fecha", align: 'right', sortable: true, dataIndex: 'dtlcto'},
					{ width:85, header: "Valor", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'vlcredito'},
					{ width:85, header: "Devolvido", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'devolvido'},
					{header: "Saldo", width: 100, align: 'right', sortable: true, dataIndex: 'totalcol', 
						renderer: function Cal(value, metaData, rec, rowIndex, colIndex, store) {
						return  Ext.util.Format.usMoney(rec.data.vlcredito - rec.data.devolvido);
						}
						}			
		        ]), 
	        viewConfig:{ 
			forceFit:true
			},
			//plugins : action,
           // id: 'gridFatPedido',
			animCollapse: false,
			enableColLock: false,
			loadMask:true,
			closable: true,
			autoWidth:true,
			height: 300,
	        stripeRows:true
	});
	
	gridNTCredito.on('rowclick', function(grid, row, e) {
					 selectedKeys = gridNTCredito.selModel.selections.keys;
					if(selectedKeys.length > 0){	
					 selectedKeys = gridNTCredito.selModel.selections.keys; 
					
					record = gridNTCredito.getSelectionModel().getSelected();
					var colName = gridNTCredito.getColumnModel().getDataIndex(4); // Get field name
					
					grid_ItensDev.render('PesquisaDevolucao');
					grid_ItensDev.getView().refresh();
					storeItensDev.load({params:{devid: selectedKeys, acao:'listarItens'}});
													
					}
		});
	
	///COMECA A GRID DOS ITENS ///////////////////////////////////////////////
	  var storeItensDev = new Ext.data.GroupingStore({
      proxy: new Ext.data.HttpProxy({method: 'POST', url: '../sistema/php/NotasCredito.php'}),
      groupField:'id_credito',
      sortInfo:{field: 'id_credito', direction: "ASC"},
      reader: new Ext.data.JsonReader({
	     root:'results',
	     fields: [
			{name: 'iditens_ntcredito'},
			{name: 'id_credito'},
			{name: 'referenciaprod'},
			{name: 'descricaoprod'},
	        {name: 'vliten', type: 'float'},
            {name: 'qtdproduto', type: 'float'},
			{name: 'totais'},
			{name: 'totalGeral'}
 			]
		})
   });
	
var gridFormItens = new Ext.BasicForm(
		Ext.get('form23'),
		{
			});
    // define a custom summary function
    Ext.grid.GroupSummary.Calculations['totalGeral'] = function(v, record, field){
		return v + (parseFloat(record.data.vliten) * parseFloat(record.data.qtdproduto));
    }

    var summary = new Ext.grid.GroupSummary(); 
     grid_ItensDev = new Ext.grid.EditorGridPanel({
	    store: storeItensDev,
       // id: 'grid_ItensDev',
		enableColLock: true,
		containerScroll  : true,
		loadMask: {msg: 'Carregando...'},
        columns: [
			{name: 'iditens_ntcredito', id: 'iditens_ntcredito', sortable: true, align: 'left', dataIndex: 'iditens_ntcredito',fixed:true,hidden: true},
            {header: "N. Credito", width: 100, sortable: true, dataIndex: 'id_credito', summaryType: 'count', fixed:true, 
				summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '(' + v +' Itens)' : '(1 Iten)');
                }
            },
			{header: "Codigo",name: 'referenciaprod',sortable: true, align: 'left',  dataIndex: 'referenciaprod',	fixed:true,	width: 150},
			{header: "Descricao", sortable: true, align: 'left', dataIndex: 'descricaoprod', fixed:true, width: 300},
			{header: "Valor", width: 80, align: 'right', sortable: true, dataIndex: 'vliten', renderer: Ext.util.Format.usMoney, fixed:true},
			{header: 'Cant', width: 55, align: 'right', dataIndex: 'qtdproduto', name: 'qtdproduto', fixed:true},
			{dataIndex: 'totais', header: "Total", name: 'totais', width: 85, align: 'right', sortable: false, fixed:true, groupable: false,
				renderer: function(v, params, record){
                return Ext.util.Format.usMoney(parseFloat(record.data.vliten) * parseFloat(record.data.qtdproduto));
                },
				name: 'totalGeral',
                dataIndex: 'totalGeral',
                summaryType:'totalGeral',
				fixed:true,
                summaryRenderer: Ext.util.Format.usMoney
            }	
        ],
        view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true
        }),

        plugins: [summary],
		autoWidth:true,
	    autoHeight: true,
		border: true,
		selectOnFocus: true, //selecionar o texto ao receber foco
        trackMouseOver: false,
        enableColumnMove: false,
		sm: new Ext.grid.RowSelectionModel({singleSelect: true}),
		stripeRows: true,
		autoScroll:true,
		title: 'Itens de la Devolucion'
});
		

      	PesquisaDevolucao = new Ext.FormPanel({
		    autoWidth:true,
			autoScroll: true,
			border: false,
	        labelWidth: 75,
	        frame:true,
			//autoHeight: true,
			//height: 200,
			closable: true,
			layout: 'form',
	        title: 'Devoluciones',
			items: [gridNTCredito,grid_ItensDev],
			 listeners: {
                        'afterrender': function(){
                                //    grid_ItensDev.renderTo('PesquisaDevolucao');
                        }
            }
 });
 
 
dsNTCredito.load(({params:{'acao': 'listarNotas'}}));


Ext.getCmp('tabss').add(PesquisaDevolucao);
Ext.getCmp('tabss').setActiveTab(PesquisaDevolucao);
PesquisaDevolucao.doLayout();	
			
}
