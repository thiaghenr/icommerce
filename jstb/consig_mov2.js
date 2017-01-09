// JavaScript Document


ConsigMov = function(){


function change(val){
        if(val > 0){
            return '<span style="color:blue;font-weight: bold;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;font-weight: bold">' + val + '</span>';
        }
        return val;
};

var action = new Ext.ux.grid.RowActions({
    header:'Excluir'
   ,autoWidth: false
   ,actions:[{
       iconCls:'icon-excluir'
      ,tooltip:'Excluir'
	  ,width: 10
   }] 
});
action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	  dsProds.remove(record);
	  Ext.getCmp("CodigoProduto").focus();
	 
   }
});








		var dsItensConsig = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/Consignacao.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Itens',
			totalProperty: 'total',
			id: 'itcsg_iditensconsig'
		},
			[
				   {name: 'itcsg_iditensconsig'},
				   {name: 'itcsg_referencia'},
		           {name: 'itcsg_descricao'},
				   {name: 'csg_data'},
		           {name: 'itcsg_qtd'},
		           {name: 'devolvido'},
				   {name: 'qtd_pend'},
				   {name: 'itcsg_consigid'},
		           {name: 'itcsg_valor'},
				   {name: 'itcsg_dev'},
				   {name: 'itcsg_fat'}

				
			]
		),
		sortInfo: {field: 'itcsg_iditensconsig', direction: 'ASC'},
		//id: 9,
		remoteSort: false		
		});
		//////// FIM STORE DOS PRODUTOS //////////////
		//////// INICIO DA GRID DOS PRODUTOS ////////
		var gridItensConsig = new Ext.grid.GridPanel({
			store: dsItensConsig, // use the datasource
			columns:[
					{id:'itcsg_iditensconsig',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'itcsg_iditensconsig'},
					{header: "Codigo", width: 80, sortable: true, dataIndex: 'itcsg_referencia'},
					{header: "Descripcion", width: 220, sortable: true, dataIndex: 'itcsg_descricao'},
					{header: "Consig N.", width: 55,  align: 'right',  sortable: true, dataIndex: 'itcsg_consigid'},
					{header: "Fecha", width: 55,  align: 'right',  sortable: true, dataIndex: 'csg_data'},
					{header: "Pendente", width: 55,  align: 'right',  sortable: true, dataIndex: 'qtd_pend', renderer: change},
					{header: "Rectirado", width: 55,  align: 'right',  sortable: true, dataIndex: 'itcsg_qtd'},
					{header: "Devolvido", width: 55,  align: 'right',  sortable: true, dataIndex: 'itcsg_dev'},
					{header: "Facturado", width: 55,  align: 'right',  sortable: true, dataIndex: 'itcsg_fat'},
					{header: "Valor Unitario", width: 80, align: 'right', sortable: true, dataIndex: 'itcsg_valor',renderer: 'usMoney'}
						
			 ],
	        viewConfig:{
	            forceFit:true,
				emptyText: 'Nenhum registro encontrado'
	        },
			width:'100%',
			autoHeight: true,
			autoExpandColumn : 'Codigo',
			loadMask: true,
	        stripeRows:true,
			tbar : new Ext.Toolbar({
				items:[
					{
					xtype: 'label',
					text: 'Codigo: ',
					style: 'font-weight:bold;color:yellow;text-align:left;' 
					},
					{
					xtype: 'textfield',
					name: 'queryCodigoLegal',
					id: 'queryCodigoLegal',
					allowBlank:true,
					enableKeyEvents: true,
					fireKey : function(e){//evento de tecla   
								if(e.getKey() == e.ENTER){ 
								var theQuery = Ext.getCmp('queryCodigoLegal').getValue();
								dsItensConsig.load({	params:{'pesquisa': theQuery,	'campo': 'Codigo' /*, 'deposito': deposito, 'tabela': tabela */}});	
							}				
						}
					},
					'-',
					{
					xtype: 'label',
					text: 'Descripcion: ',
					style: 'font-weight:bold;color:yellow;text-align:left;' 
					},
					{
					xtype: 'textfield',
					name: 'queryDescLegal',
					id: 'queryDescLegal',
					allowBlank:true,
					enableKeyEvents: true,
					fireKey : function(e){//evento de tecla   
								if(e.getKey() == e.ENTER){ 
								var theQuery=Ext.getCmp('queryDescLegal').getValue();
								dsItensConsig.load({	params:{pesquisa: theQuery,	campo: 'Descricao'}});	
							}				
						}
					}	
				
				
				
			/*	{
				text: 'Gravar',
				iconCls:'icon-save',
				tooltip: 'Clique para lancar um registro(s) selecionado',
				handler: function(){
					} } */
				]
				
			}), 
			listeners:{ 
			
			}
		
});	


			///////GRID DOS PRODUTOS/////////////////////
 dsMov = new Ext.data.GroupingStore({
			 proxy: new Ext.data.HttpProxy({
                url: 'php/consig_mov.php',
                method: 'POST'
				}),
				groupField:'grupo',
				sortInfo:{field: 'idprod', direction: "DESC"},
				nocache: true,
 reader:  new Ext.data.JsonReader({
				totalProperty: 'totalProd',
				root: 'resultProd',
				id: 'idprod',
				fields: [
						 {name: 'action1', type: 'string'},
						 {name: 'itcsg_iditensconsig', type: 'int' },
						 {name: 'itcsg_referencia'},
						 {name: 'grupo' },
						 {name: 'custo' },
						 {name: 'itcsg_descricao',  type: 'string' },
						 {name: 'itcsg_valor' },
						 {name: 'itcsg_qtd'},
						 {name: 'totals'},
						 {name: 'totalProds'}
						 ]
			})					    
		});

	// define a custom summary function
     Ext.grid.GroupSummary.Calculations['totalProds'] = function(v, record, field){
	//	precio = record.data.valorB;
	//	precio = precio.replace(".","");
		var v = v+ (parseFloat(record.data.itcsg_valor) * parseFloat(record.data.itcsg_qtd) );   //toNum
		tot.getForm().findField("SubTotal").setValue((v));
		subtotal =  v ;
		
		LimiteFinal = parseFloat(LmtDisponivel) - parseFloat(subtotal);
		//geral = totalnota - desc
		tot.getForm().findField("Total").setValue(Ext.util.Format.usMoney(v));
		return v;
		
    }

var summary = new Ext.grid.GroupSummary(); 
var gridMov = new Ext.grid.EditorGridPanel({
    store: dsMov,
    enableColLock: true,
    containerScroll  : false,
    loadMask: {msg: 'Carregando...'},
    columns: [
		action,
		{id: 'itcsg_iditensconsig', header: 'itcsg_iditensconsig', hidden: true, width: 10, dataIndex: 'itcsg_iditensconsig'},	
		{header: 'Codigo', summaryType: 'count', width: 200, dataIndex: 'itcsg_referencia' },
		{header: 'grupo', width: 200, dataIndex: 'grupo', hidden: true },
		{header: 'Descripcion', width: 300, dataIndex: 'itcsg_descricao'},
		{header: "Precio", dataIndex: 'itcsg_valor',  width: 100, align: 'right', 
			editor: new Ext.form.NumberField(
				{
				allowBlank: false,
				selectOnFocus:true,
				allowNegative: false	
				}
			)
		},
		{header: "Cant", dataIndex: 'itcsg_qtd', width: 50, align: 'right',   
			editor: new Ext.form.NumberField(  
				{
				allowBlank: false,
				selectOnFocus:true,
				allowNegative: false
				}
			)
		},
		{header: "Total",width: 100,align: 'right',sortable: false,fixed:true,groupable: false,
			renderer: function(v, params, record){
                val = Ext.util.Format.usMoney( (parseFloat(record.data.itcsg_valor)) * (parseFloat(record.data.itcsg_qtd)) )
				 return val;
            },
			id:'totalProds', dataIndex: 'totalProds', summaryType:'totalProds',	fixed:true, summaryRenderer: Ext.util.Format.usMoney
        }
	],
	view: new Ext.grid.GroupingView({
        forceFit:true,
        showGroupName: false,
        enableNoGroups:false, // REQUIRED!
        hideGroupedColumn: true
    }),
   // height: 300,
   //autoHeight: true,
   //layout: 'fit',
	moveEditorOnEnter: true,
	plugins: [summary,action],
	loadMask: true,
	clicksToEdit:1,
	listeners:{
		afteredit:function(e){
        
	    },
		editcomplete:function(ed,value){
			setTimeout(function(){
				if(ed.col == 7){				
					Ext.getCmp("CodigoProduto").focus();
				}
				if(ed.col == 6 ){
					//console.info(custo);
					//console.info(value);
				if(value < custo){
					Ext.MessageBox.alert('Imposible', 'No podes vender abajo del costo',function(btn){
					if(btn == "ok"){
						gridMov.startEditing(ed.row,ed.col);
					} 
					});
		
				}
				else{
					gridMov.startEditing(ed.row,ed.col+1);
				}
				}
			}, 250);
		},
		celldblclick: function(grid, rowIndex, columnIndex, e){
           
		}
   	}
}); 



gridMov.getSelectionModel().on('cellselect', function(sm, rowIndex, colIndex) {
    var record = gridMov.getStore().getAt(rowIndex);
	idcar = record.data.idcarrinho;
	
	}, this);

		var formWest = new Ext.FormPanel({
        labelAlign: 'top',
        frame: true,
		autoScroll: true,
		layout: 'form',
        items: [
				{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				//dataField: ['idforn','nomeforn', 'endereco'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Entidade',
			//	id: 'nomeforn',
				minChars: 2,
				name: 'nomeforn',
				width: 200,
                resizable: true,
                listWidth: 350,
				col: true,
				forceSelection: true,
				store: new Ext.data.JsonStore({
				url: 'php/LancDespesa.php?acao_nome=fornNome',
				root: 'resultados',
				fields: [ 'idforn', 'nomeforn', 'endereco' ]
				}),
					hiddenName: 'idforn',
					valueField: 'idforn',
					displayField: 'nomeforn',
					fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
						  Ext.getCmp('documento').focus();
						}
					},
					onSelect: function(record){
						idforn = record.data.idforn;
						nomeforn = record.data.nomeforn;
						this.collapse();
						this.setValue(nomeforn);
						dsItensConsig.load({params:{'entidade': idforn, 'acao': 'ListaItensEnt'}});
					}
							
                },
				{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: false,
				mode: 'local',
				triggerAction: 'all',
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Movimento',
				minChars: 2,
				name: 'movcons',
                emptyText: 'Selecione',
				width: 120,
				forceSelection: true,
				store: [
                         //   ['Devolver','Devolver'],
                            ['Saida','Salida Cliente']
                            ]
                },
				{
				xtype: 'button',
           		text: 'Grabar',
				align: 'left',
				scale: 'large',
				iconCls: 'icon-save',
            	handler: function(){ // fechar	
     	    		//deletarPedido();
				}
  			 	}
			]
				
           				
		});
		
		var formConsig = new Ext.Panel({
		title: 'Facturar / Devolver'
		,closable: true
		,layout:'border'
		,items:[{
				region:'center'
			//	,layout:'border'
				,frame:true
				,border:false
				,items:[{
				region:'center'
				,title: 'Productos Consignados'
				,layout:'form'
				,height: 300
				,frame:true
				,border:false
				,items:[gridItensConsig]
				},{
				region:'south'
				,title: 'Itens a Mover'
				,collapsible: false
				,collapsed: false
				,layout:'fit'
				,border:false
			//	,height: 400
			//	,autoHeight: true
				,frame:true
				,items:[gridMov]
				}]
				},{
				region:'west'
				,layout:'fit'
				,frame:true
				,border:false
				,width:250
				,title: 'Entidade'
				,collapsible:true
				,collapseMode:'mini'
				,items:[formWest]
			}]
		});
		








Ext.getCmp('tabss').add(formConsig);
Ext.getCmp('tabss').setActiveTab(formConsig);
formConsig.doLayout();	


};