// JavaScript Document


ConsigMov = function(){



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
	  dsProdMov.remove(record);
	 // Ext.getCmp('queryCodigoLegal').focus();
	 
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
				   {name: 'itcsg_produtoid'},
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
					{header: "Consig N.", width: 55,  align: 'right',  sortable: true, dataIndex: 'itcsg_consigid'},
					{id:'itcsg_iditensconsig',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'itcsg_iditensconsig'},
					{header: "idprod", sortable: true, hidden: true, dataIndex: 'itcsg_produtoid'},
					{header: "Codigo", width: 80, sortable: true, dataIndex: 'itcsg_referencia'},
					{header: "Descripcion", width: 220, sortable: true, dataIndex: 'itcsg_descricao'},
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
						mov = formMov.getForm().findField('movcons').getValue(); 
						idforn = formMov.getForm().findField('idforn').getValue(); 
						//console.info(idforn);
								if(e.getKey() == e.ENTER){ 
								var theQuery = Ext.getCmp('queryCodigoLegal').getValue();
								dsItensConsig.load({params:{'pesquisa': theQuery, 'coluna': 'itcsg_referencia', 'acao': 'ListaItensEnt',	'idforn': idforn, 'filtro': 'sim'}});	
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
						mov = formMov.getForm().findField('movcons').getValue(); 
						idforn = formMov.getForm().findField('idforn').getValue(); 
								if(e.getKey() == e.ENTER){ 
								var theQuery=Ext.getCmp('queryDescLegal').getValue();
								dsItensConsig.load({params:{'pesquisa': theQuery, 'coluna': 'itcsg_descricao', 'acao': 'ListaItensEnt',	'idforn': idforn, 'filtro': 'sim'}});		
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
			listeners: {
			keypress: function(e){
						if(e.getKey() == e.ENTER) {//
						
						// Carrega O formulario Com os dados da linha Selecionada
						record = gridItensConsig.getSelectionModel().getSelected();
						//tabs.getForm().loadRecord(record);	
						var idName = gridItensConsig.getColumnModel().getDataIndex(0); // Get field name
						var idData = record.get(idName);
						
						var Record = Ext.data.Record.create(['id_itid','idforn', 'codigo', 'descricao','qtd_produto','prvenda', 'idprod','totals']);
						qtdcond = record.data.qtd_pend;
					//	precio = record.data.valorB;
					//	precio = parseFloat(precio.replace(".",""));
						var dados = new Record({
								"id_itid":record.data.itcsg_iditensconsig,
								"idprod":record.data.itcsg_produtoid,
								"idforn":formMov.getForm().findField('idforn').getValue(), 
								"codigo":record.data.itcsg_referencia, 
								"descricao":record.data.itcsg_descricao,
								"qtd_produto": record.data.qtd_pend,
								"prvenda": record.data.itcsg_valor,
								"totals":record.data.precio,
								"totalProds":""
								});
								//secondGrid.startEditing(0,3);
								record = gridItensConsig.getSelectionModel().getSelected();
							//	console.info(dados);
							
							if (dsProdMov.findBy(function (rec) {
							   return rec.get('id_itid') == record.data.itcsg_iditensconsig;
							}) !== -1) {
							   Ext.MessageBox.alert('Imposible', 'Iten ya adicionado');
							}else{
							dsProdMov.insert(0,dados);
								gridProdMov.startEditing(0,5);
							}
							
							
							
								
							//	Ext.getCmp('fin').setDisabled(false)			
							
							}
						}
			
					}
		
});	
	
	var dsProdMov = new Ext.data.GroupingStore({
      proxy: new Ext.data.HttpProxy({method: 'POST', url: 'php/Consignacao.php'}),
      groupField:'idforn',
      sortInfo:{field: 'id_itid', direction: "DESC"},
      reader: new Ext.data.JsonReader({
		 totalProperty: 'total',
	     root:'Itens',
	     fields: [
			{name: 'action1', type: 'string'},
			{name: 'id_itid'},
			{name: 'idforn'},
			{name: 'idprod'},
			{name: 'codigo',  mapping: 'codigo'},
			{name: 'descricao', mapping: 'descricao_prod'},
	        {name: 'prvenda', type: 'float'},
            {name: 'qtd_produto', type: 'float'},
			{name: 'totais'},
			{name: 'totalGeral'}
 			]
		})
   });
   var gridFormItens = new Ext.BasicForm(
		Ext.get('form18'),
		{
			});
    // define a custom summary function
    Ext.grid.GroupSummary.Calculations['totalGeral'] = function(v, record, field){
		return v + (parseFloat(record.data.prvenda) * parseFloat(record.data.qtd_produto));
    }
	
	
	   var summary = new Ext.grid.GroupSummary(); 
     gridProdMov = new Ext.grid.EditorGridPanel({
	    store: dsProdMov,
		enableColLock: true,
		containerScroll  : true,
		loadMask: {msg: 'Carregando...'},
        columns: [
			action,
			{header: "id_itid",name: 'id_itid',sortable: true,align: 'left',dataIndex: 'id_itid',fixed:true,hidden: true},
			{id: 'idforn',header: "idforn",width: 100,sortable: true,dataIndex: 'idforn',summaryType: 'count',fixed:true,hideable: false,summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '(' + v +' Itens)' : '(1 Iten)');
            }},
			{header: "Codigo",name: 'codigo',sortable: true,align: 'left',dataIndex: 'codigo',width: 120},
			{header: "Descricao",sortable: true,align: 'left',dataIndex: 'descricao',width: 200,hidden: false},
			{header: "Valor",width: 100,align: 'right',sortable: true,dataIndex: 'prvenda',renderer: Ext.util.Format.usMoney,editor: new Ext.form.NumberField({
					allowBlank : false,
					selectOnFocus:true,
					allowNegative: false
					})
            },
			{header: 'Cant',width: 85,align: 'right',dataIndex: 'qtd_produto',name: 'qtd_produto',editor: new Ext.form.NumberField({
					allowBlank : false,
					selectOnFocus:true,
					allowNegative: false
					})
			},
			{dataIndex: 'totais',id: 'totais',header: "Total",name: 'totais',width: 105,align: 'right',sortable: false,groupable: false,renderer: function(v, params, record){
                return Ext.util.Format.usMoney(parseFloat(record.data.prvenda) * parseFloat(record.data.qtd_produto));
			},
				name: 'totalGeral',
                dataIndex: 'totalGeral',
                summaryType:'totalGeral',
                summaryRenderer: Ext.util.Format.usMoney
            }
			],
        view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true,
            closable: true
        }),
		plugins: [summary,action],
		loadMask: true,
		//autoWidth:true,
        height: 250,
		border: false,
		title: 'Itens a Mover',
        clicksToEdit: 1,
		selectOnFocus: true, //selecionar o texto ao receber foco
        trackMouseOver: false,
        enableColumnMove: false,
		moveEditorOnEnter: true,
		stripeRows: true,
		autoScroll:true,
		listeners:{ 
			editcomplete:function(ed,value){
	            setTimeout(function(){
	                if(ed.col == 5){				
	                    gridProdMov.startEditing(ed.row,ed.col+1);
	                }
	            }, 250);
				if(ed.col == 6){
				if(value > qtdcond){
					Ext.MessageBox.alert('Imposible', 'Cantid Pendente insuficiente ',function(btn){
						if(btn == "ok"){
							gridProdMov.startEditing(ed.row,ed.col);
						} });
		
					}
				}
	        }
	  }
});

		var formMov = new Ext.FormPanel({
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
						//dsItensConsig.load({params:{'idforn': idforn, 'acao': 'ListaItensEnt'}});
						dsItensConsig.load({params:{'acao': 'ListaItensEnt',	'idforn': idforn, 'filtro': 'nao'}});
						dsProdMov.removeAll();
						
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
                            ['Devolver','Devolver'],
                            ['Facturar','Facturar']
                            ]
                },
				{
				xtype: 'button',
           		text: 'Grabar',
				align: 'left',
				scale: 'large',
				iconCls: 'icon-save',
            	handler: function(){ // fechar	
						mov = formMov.getForm().findField('movcons').getValue(); 
						if(mov != ""){
						if(mov == "Facturar")
							var frase = "facturados al nombre del cliente";
						if(mov == "Devolver")
							var frase = "deduzidos de la consignacion, y volvera al estoque";
						Ext.MessageBox.confirm('Alerta', 'Los itens seran '+frase+' !! </p> Desea Proseguir?', function(btn) {
							if(btn == "yes"){	
						var jsonData = [];
						// Percorrendo o Store do Grid para resgatar os dados
						dsProdMov.each(function( record ){
						// Recebendo os dados
						jsonData.push( record.data );
						});
						jsonData = Ext.encode(jsonData)
						Ext.Ajax.request({
           					url: 'php/Consignacao.php',
							method: 'POST',
							remoteSort: true,
           					params: {
								acao: 'Movimentar', 
								dados: jsonData,
								movimento: mov,
								idforn: idforn
							},
							callback: function (options, success, response) {
										if (success) { 
											//Ext.MessageBox.alert('OK', response.responseText);
											var jsonData = Ext.util.JSON.decode(response.responseText);
												if(jsonData.count){
													mens = jsonData.count + " Itens Movidos. Control N: " + jsonData.Pedido;
														Ext.MessageBox.alert('Alerta', mens);
														dsProdMov.removeAll();
														dsItensConsig.removeAll();
														formMov.getForm().reset();
												}
												 if(jsonData.response == 'Confirme su password'){ 
												//	alert(jsonData.response);
												Ext.getCmp('password').focus();
												}
											//	Ext.MessageBox.alert('Alerta', mens);
											//	window.location.reload();
											
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										
										}
						});
					}	
						});	
				}
				else{
					Ext.MessageBox.confirm('Alerta, Favor Elejir "Movimento" ');
				}
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
			//	,title: 'Itens a Mover'
				,collapsible: false
				,collapsed: false
				,layout:'form'
				,border:false
				//,height: 250
				,autoHeight: true
				,frame:true
				,items:[gridProdMov]
				}]
				},{
				region:'west'
				,layout:'form'
				,frame:true
				,border:false
				,width:250
				,title: 'Entidade'
				,collapsible:true
				,collapseMode:'mini'
				,items:[formMov]
			}]
		});
		
		/*
		 var	formConsig = new Ext.FormPanel({
			layout     : 'border',
			title: 'Facturar / Devolver',
		    autoWidth: true,
			closable: true,
		//	id: 'produtos_pedidopAdd',
	        frame:true,
			items: [
			{
			region: 'north',
			width: '100%',
			layout: 'fit',
			height: 300,
			items:[gridItensConsig]
			},
			{
			region: 'center',
			width: 400,
			//autoHeight: true,
			layout: 'fit',
			autoScroll:true,
			//height: 300,
			items:[gridProdMov]
			},
			{
				region:'west'
				,layout:'form'
				,frame:true
				,border:false
				,width:250
				,title: 'Entidade'
				,collapsible:true
				,collapseMode:'mini'
				,items:[formMov]
			}
			]
			});

*/





Ext.getCmp('tabss').add(formConsig);
Ext.getCmp('tabss').setActiveTab(formConsig);
formConsig.doLayout();	
formMov.getForm().findField('idforn').focus();

};