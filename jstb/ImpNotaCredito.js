// JavaScript Document


ImpCreditos = function(idpedidoFat,ContReceber){
//idpedidoFat = idpedidoFat;
//console.info(idpedidoFat);


var xgPedidoNT = Ext.grid;
var winNTC;

var action = new Ext.ux.grid.RowActions({
    header:'Credito'
 //  ,anchor: '10%'
  ,width: 50
  ,autoWidth: false
   ,actions:[{
       iconCls:'icon-delete'
      ,tooltip:'Usar Credito'
	//  ,width: 1
   }] 
});

action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	  idpedidofat = idpedidoFat;
	  vlcredito = record.data.vlcredito;
	  devolvido = record.data.devolvido;
	  creditofinal = vlcredito - devolvido;
	  creditofinal = creditofinal.toFixed(2);
	  idcredito = record.data.idnota_credito;
	  ncredito = idcredito;
	  adevolver = record.data.adevolver;
//	  console.info(adevolver);
	  
	  
	  if(typeof total_nota != 'undefined'){
	  totalgeral = parseFloat(total_nota) - parseFloat(creditofinal);
	 // FormPedido.getForm().findField('labelnota').setText(ncredito); 
	 Ext.getCmp('labelnota').setText(ncredito);
	 Ext.getCmp('labelvalor').setText(creditofinal);
	 Ext.getCmp('totalfaturar').setText(totalgeral);
	  }
	  if(typeof ContReceber != 'undefined'){
		origem = 'NTCredito';
		BaixaConta(origem,ncredito,adevolver);
	//  console.info(adevolver);
	  }
	  winNTC.hide();
	 
   }
});


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
					 {name: 'saldo', type: 'float'},
					 {name: 'adevolver', type: 'float'}
					 //{name: 'action1', type: 'string'},
   			         //{name: 'action2', type: 'string'}

					 ]
			})
		})
///////////// FIM STORE ////////////////////////
///////////// INICIO DA GRID //////////////////

	     var gridNTCredito = new Ext.grid.EditorGridPanel({
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
						},
					{header: "Valor a Devolver",width: 150,align: 'right',sortable: true,dataIndex: 'adevolver',renderer : function(v){
                    return Ext.util.Format.usMoney(v);   
						},
						editor: new Ext.form.NumberField({
							allowBlank : true,
							selectOnFocus:true,
							allowNegative: false
						})
					},
					action

					
		        ]), 
	        viewConfig:{ 
			forceFit:true
			},
			plugins : action,
           // id: 'gridFatPedido',
			animCollapse: false,
			enableColLock: false,
			loadMask:true,
			closable: true,
			autoWidth:true,
			height: 300,
	        stripeRows:true
	});
	
	
if (winNTC == null){
				winNTC = new Ext.Window({
					title       : 'Notas de Credito' 
					//, id:'winNTC'
	                , layout: 'form'
	                , width: 850
					, autoHeight: true
	                , closeAction :'hide'
	                , plain: true
					, resizable: false
					, modal: true
					, items:[gridNTCredito]
					,buttons: [
								{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					winNTC.hide();
								}
  			 					}
							]					

				});
			}
winNTC.show();
dsNTCredito.load(({params:{'acao': 'listarNotas'}}));

			
}
