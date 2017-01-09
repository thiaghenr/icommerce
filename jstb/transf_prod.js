// JavaScript Document


TransfProds = function(){

Ext.override(Ext.grid.EditorGridPanel, {
			initComponent: Ext.grid.EditorGridPanel.prototype.initComponent.createSequence(function(){
			this.addEvents("editcomplete");
			}),
			onEditComplete: Ext.grid.EditorGridPanel.prototype.onEditComplete.createSequence(function(ed, value, startValue){
			this.fireEvent("editcomplete", ed, value, startValue);
			})
			});



function change(val){
        if(val > 0){
            return '<span style="color:blue;font-weight: bold;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;font-weight: bold">' + val + '</span>';
        }
        return val;
    };
	
	var dslistaProd = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'id',  mapping : 'id'},
				   {name: 'Codigo'},
		           {name: 'Descricao'},
		           {name: 'Estoque'},
		           {name: 'qtd_bloq'},
		           {name: 'valorA'}
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		remoteSort: false,
		autoLoad: true
	});
//////// FIM STORE DOS PRODUTOS //////////////
//////// INICIO DA GRID DOS PRODUTOS ////////
 var grid_listaProd = new Ext.grid.GridPanel({
	        store: dslistaProd, // use the datasource
	        columns:[
						{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descricao", width: 250, sortable: true, dataIndex: 'Descricao'},
						{header: "Disponivel", width: 55, align: 'right', sortable: true, dataIndex: 'Estoque', renderer: change},
						{header: "Bloqueados", width: 55,  align: 'right',  sortable: true, dataIndex: 'qtd_bloq'},
						{header: "Valor A", width: 80, align: 'right', sortable: true, dataIndex: 'valorA',renderer: 'usMoney'}
			 ],
	        viewConfig:{
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			width:'100%',
			ddGroup          : 'secondGridDDGroup',
			enableDragDrop   : true,
		//	sm: new Ext.grid.RowSelectionModel(),
			height: 250,
			autoExpandColumn : 'id',
			loadMask: true,
			//enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dslistaProd,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Nao tem dados",
				pageSize: 100,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina", 
				refreshText : "Atualizar",
				paramNames : {start: 'start', limit: 'limit'},
				items:[{
                    xtype:'button',
					text: 'Imprimir',
					style: 'margin-left:7px',
					iconCls: 'icon-pdf',
					handler: function(){
						basic_printGrid();
					}
					}]
				
			}),
			listeners:{ 
			
			}
		
});	

	var secondGridStore = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod.phps',
			method: 'POST'
		}),   
		sortInfo:{field: 'Codigo', direction: "DESC"},
		nocache: true,
		
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[		
				   {name: 'id',  mapping : 'id', type: 'string'},
				   {name: 'Codigo', type: 'string'},
		           {name: 'Descricao', type: 'string'},
				   {name: 'qtd', type: 'string'},
				   {name: 'valorB', type: 'string'},
				   {
					name: 'total',
					type: 'float',
					dependencies: ['qtd','valorB'],
					calc: function(r) {
					alert('oi');
						return (r.get('qtd') * r.get('valorB'));
					}
					}
			]
		)	
	});
	
	
    var secondGrid = new Ext.grid.EditorGridPanel({
	        columns:[
						{id:'id',header: "id", hidden: true, sortable: true, dataIndex: 'id'},
						{header:'Codigo',header: "Codigo", width: 120, sortable: true, dataIndex: 'Codigo'},
						{header: "Descricao", width: 270, sortable: true, dataIndex: 'Descricao'},
						{header: "Qtd", width: 80, sortable: true, dataIndex: 'qtd',
							 editor: new Ext.form.NumberField({
								allowBlank: false,
								selectOnFocus:true,
								allowNegative: false
								})
								},
						{header: "Valor B", width: 90, align: 'right', sortable: true, dataIndex: 'valorB',renderer: 'usMoney',
							 editor: new Ext.form.NumberField({
								allowBlank: false,
								selectOnFocus:true,
								allowNegative: false	
								})
						},
						{header: "Total", width: 90, sortable: true, align: 'right', dataIndex: 'total'}     
				 ],
			title			 : 'Itens a Transferir',
			stripeRows       : true,
			//plugins: [summary],
			store			 : secondGridStore,
			sm: new Ext.grid.RowSelectionModel(),
			width 			 : 680,
			height			 : 165,
			autoExpandColumn : 'id',
			listeners:{
				editcomplete:function(ed,value){
					  setTimeout(function(){
					  if(ed.col == 3 ){				
					  secondGrid.startEditing(ed.row,ed.col+1);
					  }
					   }, 250);
					  },
				afteredit:function(e,v, field){   
				//v = record.data.total;
				//Ext.getCmp('TotalSub').setValue(v);
				
				
			//	anterior = Ext.getCmp('TotalSub').getValue();
			//	tot = parseFloat(anterior) + parseFloat(v);
			// 	Ext.getCmp('TotalSub').setValue(tot);
			
			 console.log(record.data.valorB);
			 console.log(record.data.qtd);
				
				}
				}
		});
		
		grid_listaProd.getSelectionModel().on('rowselect', function(sm, rowIndex, colIndex) {
		record = grid_listaProd.getStore().getAt( rowIndex );
		prodId = record.id;
		}, this);
		


var FormlistaProd = new Ext.FormPanel({
           // title       : 'Produtos',
            split       : true,
			autoHeight		: true,
            collapsible : false,
           // margins     : '3 3 3 0',
			//bodyStyle:'padding:5px 5px 0',
            //cmargins    : '3 3 3 3',
			items:[grid_listaProd,secondGrid]		
        }); 



winTransf = new Ext.Window({
	id:'winTransf'
	, title       : 'Transferencia Productos'
	, layout: 'form'
	, width: '80%'
	, closeAction :'hide'
	, plain: true
	, resizable: true
	, height: '500'
	, modal: true
	, items:[FormlistaProd]
	,focus: function(){
 	//	Ext.get('nomedep').focus();
		}
									
	});
winTransf.show();		
	
	
}