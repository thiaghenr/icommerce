// JavaScript Document

  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
  Ext.QuickTips.init();
  Ext.form.Field.prototype.msgTarget = 'side';
	
	CtPagar = function(){

var w = Ext.getCmp('west-panel');
w.collapse();	
								  
var ContPagar;									  
var winPagar;
var idData;
var totalProd;
var win_ctpg;
var xg = Ext.grid;
 
function formatBoolean(value){
        return value == 1 ? 'Sim' : 'Não';  
    };

///COMECA A GRID /////
	  var storePagar = new Ext.data.GroupingStore({
      proxy: new Ext.data.HttpProxy({method: 'POST', url: 'php/contas_pagar.php'}),
      groupField:'dt_vencimento',
	  type: 'date',
      sortInfo:{field: 'nome', direction: "DESC"},
      reader: new Ext.data.JsonReader({
		 totalProperty: 'total',
	     root:'result',
	     fields: [
			{name: 'idit'},
			{name: 'idct'},
			{name: 'idprov', mapping: 'ctproveedor_id'},
	        {name: 'nome'},
            {name: 'nome_cli'},
            {name: 'description'},
            {name: 'qtd_produto'},
            {name: 'custounit'},
			{name: 'dt_vencimento', dateFormat: 'd-m-Y'},
            {name: 'data_car', dateFormat: 'd-m-Y'},
			{name: 'juros', type:'float',  mapping: 'juros'},
			{name: 'descontos', type:'float'},
			{name: 'totals'},
			{name: 'totalGeral'},
			{name: 'pagoprov', align: 'center', mapping: 'pagoprov', type:'boolean'}
 		]
		})
   });
	
   storePagar.load();
var gridForm = new Ext.BasicForm(
		Ext.get('form1'),
		{
			});
    // define a custom summary function
    Ext.grid.GroupSummary.Calculations['totalGeral'] = function(v, record, field){
		return v + (record.data.qtd_produto * record.data.custounit);
    }

    var summary = new Ext.grid.GroupSummary(); 
    var grid_forn = new Ext.grid.EditorGridPanel({
	    store: storePagar,
		//layout: 'column',
		enableColLock: true,
		containerScroll  : false,
		 loadMask: {msg: 'Carregando...'},
        columns: [
			
			{	
				id: 'idit',
                header: "idit",
                sortable: true,
                dataIndex: 'idit',
				fixed:true,
				hidden: true
            },
			{	
				id: 'idct',
                header: "idct",
                sortable: true,
                dataIndex: 'idct',
				fixed:true,
				hidden: true
            },
			{	
				id: 'idprov',
                header: "idprov",
                sortable: true,
                dataIndex: 'idprov',
				fixed:true,
				hidden: true
            },
            {
                header: "Proveedores",
				name: 'nome',
                sortable: true,
                dataIndex: 'nome',
				fixed:true
            },
			{
                id: 'idprov',
                header: "Cliente",
                width: 200,
                sortable: true,
                dataIndex: 'nome_cli',
                summaryType: 'count',
				fixed:true,
                hideable: false,
                summaryRenderer: function(v, params, data){
                    return ((v === 0 || v > 1) ? '(' + v +' Vencimentos)' : '(1 Vencimento)');
                }
            },
			{
                header: "Vencimento",
                width: 80,
				align: 'right',
				type:'date', 
				dateFormat: 'd-m-Y',
                sortable: true,
                dataIndex: 'dt_vencimento',
				 fixed:true
               
            },
			{
                header: "Data Pedido",
                width: 80,
				align: 'right',
                sortable: true,
                dataIndex: 'data_car',
				 fixed:true
               
            },{
                header: "Qtd",
                width: 60,
				align: 'right',
                sortable: true,
                dataIndex: 'qtd_produto',
				fixed:true,
               // summaryType:'sum',
               // renderer : function(v){
               //     return v ;
              //  },
                editor: new Ext.form.NumberField({
                   allowBlank: false,
                   allowNegative: false
                  // style: 'text-align:left'
                })
            },{
                header: "Custo",
                width: 60,
				align: 'right',
                sortable: true,
				fixed:true,
                renderer: Ext.util.Format.usMoney,
                dataIndex: 'custounit',
              //  summaryType:'average',
                editor: new Ext.form.NumberField({
                   allowBlank: false
                })
            },
			{  
				header: 'Juros',
				width: 60,
				id: 'juros',
				align: 'right',
				renderer: Ext.util.Format.usMoney,
				dataIndex: 'juros',
				name: 'juros',
				fixed:true,
				editor: new Ext.form.NumberField({
						allowBlank : false
						
						
			   })
			},
			{
				header: 'Descontos',
				width: 80,
				align: 'right',
				renderer: Ext.util.Format.usMoney,
				dataIndex: 'descontos',
				name: 'descontos',
				fixed:true,
				editor: new Ext.form.NumberField({
						allowBlank : false
			   })
			},
			
			{	
				dataIndex: 'totals',
                id: 'totals',
                header: "Total",
				name: 'totals',
                width: 90,
				align: 'right',
                sortable: false,
				fixed:true,
                groupable: false,
                renderer: function(v, params, record){
                return Ext.util.Format.usMoney(parseFloat(record.data.juros) + (record.data.qtd_produto * record.data.custounit) - parseFloat(record.data.descontos));
					
                },
				name: 'totalGeral',
                dataIndex: 'totalGeral',
                summaryType:'totalGeral',
				fixed:true,
                summaryRenderer: Ext.util.Format.usMoney
            },
			{
				header: "Pagar",
				dataIndex: 'pagoprov',
				fixed:true,
				width: 50,
				renderer: formatBoolean,
				editor: new Ext.grid.GridEditor(new Ext.form.Checkbox())				
			}
			
        ],

        view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true
        }),

        plugins: summary,
        autoWidth: true,
        height: 385,
		border: false,
        clicksToEdit: 1,
		autoScroll:false,
		tbar: [
			   {
				text: 'Efetuar Pagamento',
				iconCls:'icon-cancel',
				tooltip: 'Clique para gravar alteracoes',
				handler: function(){
					jsonData = "[";
						
						for(d=0;d<storePagar.getCount();d++) {
							record = storePagar.getAt(d);
							if(record.data.newRecord || record.dirty) {
								jsonData += Ext.util.JSON.encode(record.data) + ",";
							}
						}
						
						jsonData = jsonData.substring(0,jsonData.length-1) + "]";
						//alert(jsonData);
							Ext.Ajax.request(
							{
								waitMsg: 'Enviando Cotacão, por favor espere...',
								url:'php/pagar_duplicata.php',
								params:{data:jsonData,user_id:id_usuario},
								success:function(form, action) {
									Ext.Msg.alert('Obrigado', 'Enviado com sucesso!!!!');
									storePagar.reload();
								},
								
								failure: function(form, action) {
									Ext.Msg.alert('Alerta', 'Erro, Tente Novamente');
								}								
							}
						);						
					} }
		],
		 bbar: [
				{
				text: 'Relatório Geral',
				iconCls:'icon-pdf',
				 tooltip: 'Imprimir!',
				handler: function(){
			var win_cont_pagar = new Ext.Window({
					id: 'help',
					title: 'Relatorio',
					width: 650,
					height: 500,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: true,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='../relatorio_forn_imp.php' > </iframe>" },
					buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_cont_pagar.destroy();
  			 					}
			 
        					}]
				});
				win_cont_pagar.show();
			}
				
				
				},
				'-',
				{
				text: 'Contas no Periodo',
				handler: function(){ // fechar	
     	    					win_ctpg.show();
  			 					}
				//iconCls:'icon-pdf'
				
				}
				]
				

 
				
/*		listeners:{
        afteredit:function(e){
         Ext.Ajax.request({
            url: '../php/contas_pagar.php',
            params: {
               id: e.record.get('idit'),
               valor: e.value,
			   campo: e.column

            },
			success: function(){
                           //Ext.example.msg('Informa&ccedil;&atilde;o','Registro atualizado com sucesso');
                           storePagar.commitChanges();
                        },
			failure: function(){
                           Ext.example.msg('Erro','N&atilde;o foi possivel Alterar.');
                           storePagar.rejectChanges();

                        }

         })
      }
   }*/
    });
///TERMINA A GRID	

var relatorioPeriodo = function(){
var dtini = Ext.get('dtinicial').getValue();
var dtfim = Ext.get('dtfinal').getValue();
if(dtini.length > 0){		

var win_relatorio_periodo = new Ext.Window({
					id: 'win_relatorio_periodo',
					title: 'Relatorio no Periodo',
					width: 650,
					height: 500,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'fit',
					items: { html: "<iframe height='100%' width='100%' src='../relatorio_forn_imp_per.php?dtini="+dtini+"&dtfim="+dtfim+"' > </iframe>"},
					buttons: [
           						{
            					text: 'Sair',
            					handler: function(){ // fechar	
     	    					win_relatorio_periodo.destroy();
  			 					}
			 
        					}]
				});
win_relatorio_periodo.show();
}
else{
//selecione();
}			
}



 FormCtPeriodo = new Ext.FormPanel({
			frame		: true,
			layout      : 'form',
			border 		: false,
            split       : true,
			//region      : 'center',
            autoWidth   : true,
			height		: 233,
            collapsible : false,
			items:[{
							 xtype: 'datefield',
                    		 fieldLabel: 'Data Inicial',
							 readOnly: false,
							 id: 'dtinicial',
                    		 name: 'dtinicial'
							 },
							 {
							 xtype: 'datefield',
							 readOnly: false,
                    		 fieldLabel: 'Data Final',
							 id: 'dtfinal',
                    		 name: 'dtfinal'
							 },
							 {
							 style: 'margin-top:30px',
							 float:'left'
					         },
					 		 {
							xtype: 'button',
							text: 'Buscar',
							iconCls:'print',
							tooltip: 'Imprimir!',
							handler: function(){
								relatorioPeriodo();
							}
				}
					 
						]
										   });
							 
							 
							 
if (win_ctpg == null){
				win_ctpg = new Ext.Window({
					id:'win_ctpg'
					, border 	: false
					, title: "Busca por periodo"
	                , layout: 'form'
	                , width: 350
					, height: 250
	                , closeAction :'hide'
	                , plain: true
					, modal: true
					, items:[FormCtPeriodo]
					,buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_ctpg.hide();
								//FormInfPedido.getForm().reset();
  			 					}
        			}
					]
					,focus: function(){
 	   					// Ext.get('qtd_produto').focus();
						}

				});
				
				
			}
	
FormContasPagar = new Ext.FormPanel({
	    title: 'Contas Pagar',
		id: 'FormContasPagar',
		//renderTo: Ext.getCmp(tabAtiva).body,
		layout:'form',
		frame: true,
		closable:true,
		autoWidth: true,
		titleCollapse: false,
		items:[grid_forn]					

});	

Ext.getCmp('tabss').add(FormContasPagar);
Ext.getCmp('tabss').setActiveTab(FormContasPagar);

	}