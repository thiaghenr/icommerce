// JavaScript Document


Caixa = function(){


var formataStatus = function(value){
	
	if(value=='A')
		  return '<span style="color: #FF0000;">Ativo</span>';
		else if(value=='F')
		  return  '<span style="color: #00000;">Cerrado</span>';
   	    else if(value=='D')
		  return 'Cancelado';
		else
		  return '<span style="color: #6EEAE9;">Cerrado</span>'; 

};

var formataReceita = function(value){
	
	if(value=='1')
		  return '<span style="color: #339966;">Entrada</span>';
		else if(value=='2')
		  return  '<span style="color: #00000;">Salida</span>';
   	    else if(value=='3')
		  return 'DEVOLUCION';
		else if(value=='7')
		  return 'TRANSF. CAIXA';
		

};

dsCaixaUsu = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: 'php/CaixaUsu.php',
        method: 'POST'
    }),   

reader:  new Ext.data.JsonReader({
			totalProperty: 'total',
			root: 'results',
			id: 'id',
			fields: [
					 {name: 'id',  type: 'int'},
					 {name: 'dt_abertura'},
					 {name: 'dt_fechamento'},
					 {name: 'vl_abertura'},
					 {name: 'vl_fechamento'},
					 {name: 'vl_mov_entrada'},
					 {name: 'st_caixa',  type: 'string' },
					 {name: 'vl_mov_saida'},
   			         {name: 'vl_transferido_fin'},
					 {name: 'vl_moc_cred_cliente'},
					 {name: 'nome_user'}

					 ]
			}),					    
			baseParams:{acao: 'listarCaixas'},
			autoLoad: true
		})
///////////// FIM STORE ////////////////////////
///////////// INICIO DA GRID //////////////////

	     var gridCaixaUsu = new Ext.grid.GridPanel({
	        store: dsCaixaUsu, // use the datasource
	       columns:[
		       
		        	//expander,
		            {id:'id',width:30, header: "Ident.", sortable: true, dataIndex: 'id'},
					{width:60, header: "Abertura",  sortable: true, dataIndex: 'dt_abertura'},
					{width:60, header: "Fechamento", sortable: true, dataIndex: 'dt_fechamento'},
					{width:60, header: "Saldo Abertura", renderer: Ext.util.Format.usMoney, align: 'right', sortable: true, dataIndex: 'vl_abertura'},
					{width:70, header: "Saldo Fechamento", renderer: Ext.util.Format.usMoney, align: 'right',  sortable: true, dataIndex: 'vl_fechamento'},
					{width:40, header: "Status",renderer: formataStatus, align: 'right',  sortable: true, dataIndex: 'st_caixa'},
					{width:70, header: "Entradas", renderer: Ext.util.Format.usMoney, align: 'right',  sortable: true, dataIndex: 'vl_mov_entrada'},
					{width:70, header: "Saidas", renderer: Ext.util.Format.usMoney, align: 'right',  sortable: true, dataIndex: 'vl_mov_saida'},
					{width:70, header: "Transferido", renderer: Ext.util.Format.usMoney, align: 'right',  sortable: true, dataIndex: 'vl_transferido_fin'},
					{width:40, header: "Usuario",align: 'right',  sortable: true, dataIndex: 'nome_user'}
					
		        ], 
	        viewConfig:{ 
			forceFit:true
			},
			//plugins : action,
			animCollapse: false,
			enableColLock: false,
			loadMask:true,
			autoWidth:true,
			closable: true,
			title: 'Caixa User',
			//autoHeight: true,
			height: 300,
	        stripeRows:true,
			listeners: {
			keypress: function(e){
				
			if(e.getKey()  >47 && e.getKey() < 58 || e.getKey() >64 && e.getKey() < 91 || e.getKey() >95 && e.getKey() < 106 ){	
				
 	   					 Ext.get('queryPedido').focus();
			
				
			}}},
			tbar : new Ext.Toolbar({
			align:'left',
         	buttons: [	
           				{
           			    text: 'PDF',
						name: 'pdf',
						align: 'left',
						iconCls: 'icon-pdf',
            			handler: function(){ // fechar	
     	    			imprimirPedidoPDF();
  			 			}
						},
						'-',
						{
           			    text: 'Abrir Caja',
						name: 'AbCaja',
						iconCls: 'icon-box_open',
            			handler: function(){ // fechar	
								Ext.Ajax.request({ 
									waitMsg: 'Executando...',
									url: 'php/CaixaUsu.php',
									params: { 
											acao: 'AbCaixa',
											user: id_usuario
											},
									success: function(result, request){//se ocorrer correto 
									var jsonData = Ext.util.JSON.decode(result.responseText);
									if(jsonData.response == 'CaixaAberto'){
													Ext.MessageBox.alert('Aviso','Caja Aberto con Sucesso.'); //aki uma funcao se necessario);
												//	dsCaixaUsu.reload(); 
													};
									if(jsonData.response == 'CaixaJaAberto'){
													Ext.MessageBox.alert('Error!','Su Caja ya se Encuentra Abierto.'); //aki uma funcao se necessario);
													};
											}, 
											failure:function(response,options){
												Ext.MessageBox.alert('Alerta', 'Erro...');
													}         
												}) 
  			 			}
						},
						'-',
						{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: true,
				editable: false,
				mode: 'local',
				triggerAction: 'all',
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Pesquisa',
				id: 'sitID',
				minChars: 2,
				name: 'sitID',
                emptyText: 'Usuario',
				width: 120,
				forceSelection: true,
				store: [
                          //  ['id','Pedido'],
                            ['nome_user','Nome']
                           // ['ruc','ruc']
                            ]
                },
						{
					xtype: 'textfield',
	                fieldLabel: 'Pesquisa',
	                name: 'queryCaixa',
					id: 'queryCaixa',
					emptyText: 'Pesquise aqui',
					width: 200,
					//enableKeyEvents: true,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							var theQuery= Ext.getCmp('queryCaixa').getValue();
							 if(e.getKey() == e.ENTER) {//precionar enter   
							dsCaixaUsu.load({params:{query: theQuery, combo: Ext.getCmp('sitID').getValue()}});
							 }
						}				
					}
	            }
						
			 
        ]
    }),
			bbar: new Ext.PagingToolbar({
				store: dsCaixaUsu,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Não tem dados",
				pageSize: 40,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina",    
				refreshText : "Atualizar"
			//	paramNames : {start: 'start', limit: 'limit'}
			})
		});
		//dsCaixaUsu.load({params:{acao: 'listarPedidos',start: 0, limit: 40}});
		
		
		///COMECA A GRID DOS ITENS ///////////////////////////////////////////////
	  var storeLancCaixa = new Ext.data.GroupingStore({
      proxy: new Ext.data.HttpProxy({method: 'POST', url: 'php/lista_lanc_caixa.php'}),
      groupField:'receita_id',
      sortInfo:{field: 'caixa_id', direction: "desc"},
      reader: new Ext.data.JsonReader({
		 totalProperty: 'total',
	     root:'result',
	     fields: [
			{name: 'idl'},
			{name: 'receita_id' ,type: 'string'},
			{name: 'caixa_id'},
			{name: 'dt_lancamento'},
			{name: 'vl_pago', type:'float' },
	        {name: 'pedido_id'},
			{name: 'descricao'},
            {name: 'contas_receber_id'},
			{name: 'contas_pagar_id'}
 			]
		})
   });
  
   // define a custom summary function
    Ext.grid.GroupSummary.Calculations['totalGeral'] = function(v, record, field){
		return v + (parseFloat(record.data.vl_pago) * parseFloat(record.data.vl_pago));
    }

    var summary = new Ext.grid.GroupSummary(); 
     gridLancCaixa = new Ext.grid.EditorGridPanel({
	    store: storeLancCaixa,
		enableColLock: true,
		containerScroll  : true,
		loadMask: {msg: 'Carregando...'},
        columns: [	
					{header: "id",name: 'idl',sortable: true,align: 'left',dataIndex: 'idl',fixed:true,	hidden: false},
					{header: "Caixa",name: 'caixa_id',sortable: true,align: 'left',	dataIndex: 'caixa_id',summaryType: 'count',	fixed:true,width: 150,summaryRenderer: function(v, params, data){
							return ((v === 0 || v > 1) ? '(' + v +' Itens)' : '(1 Iten)');
						}},
					{id: 'receita_id',header: "Receita",width: 150,	sortable: true,	dataIndex: 'receita_id',fixed:true,	renderer: formataReceita},
					{id: 'dt_lancamento',header: "Lancamento",sortable: true,align: 'left',	dataIndex: 'dt_lancamento',	fixed:true,	width: 150,	hidden: false},
					{header: 'Pedido',width: 100,align: 'right',	dataIndex: 'pedido_id',name: 'pedido_id',	fixed:true},
					{header: 'Descripcion',width: 100,align: 'left', sortable: true, dataIndex: 'descricao',name: 'descricao'},
					{header: 'Ct Recibir',width: 100,align: 'right',dataIndex: 'contas_receber_id',	name: 'contas_receber_id',fixed:true},
					{header: 'Ct Pagar',width: 100,align: 'right',dataIndex: 'contas_pagar_id',name: 'contas_pagar_id',fixed:true},
					{header: "Valor",width: 150,align: 'right',	sortable: true,	dataIndex: 'vl_pago',summaryType: 'sum',renderer: Ext.util.Format.usMoney,fixed:true}
				],
        view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true
        }),

        plugins: [summary],
		autoWidth:true,
       // height: 140,
	    autoHeight: true,
		border: true,
        clicksToEdit: 1,
		selectOnFocus: true, //selecionar o texto ao receber foco
        trackMouseOver: false,
        enableColumnMove: false,
		stripeRows: true,
		autoScroll:true,
		bbar : new Ext.Toolbar({ 
			items: [
           			
					 '<b>Saldo Liquido: </b>',
					 {
							xtype: 'textfield',
							fieldLabel: '',
							id: 'TotalCaixa',
							name: 'TotalCaixa',
							disabled: true
							},
							'-',
					'<b>Transferir Saldo: </b>',
					 new Ext.ux.MaskedTextField({
							fieldLabel: '',
							id:'Transf',
							mask:'decimal',
							textReverse : true,
							fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter 
									var vlTrf = Ext.getCmp('Transf').getValue();
									if(typeof(selectedKeys) != "undefined"){
									Ext.Ajax.request({ 
									waitMsg: 'Executando...',
									url: 'php/CaixaUsu.php',
									params: { 
											idCaixa: selectedKeys,
											acao: 'transferir',
											vlTrf: vlTrf,
											user: id_usuario
											},
									success: function(result, request){//se ocorrer correto 
									var jsonData = Ext.util.JSON.decode(result.responseText);
									if(jsonData.response == 'Transferido'){
													Ext.MessageBox.alert('Aviso','Transferido.'); //aki uma funcao se necessario);
												//	storeLancCaixa.reload(); 
												//	dsCaixaUsu.reload();
													};
									if(jsonData.response == 'SaldoInsuficiente'){
													Ext.MessageBox.alert('Aviso','Saldo Insuficiente.'); //aki uma funcao se necessario);
													//storeLancCaixa.reload(); 
													};
									if(jsonData.response == 'UsuarioNaoConfere'){
																Ext.MessageBox.alert('Error','Esta Caja no es Tuyo'); //aki uma funcao se necessario);
																//storeLancCaixa.reload(); 
																};
									if(jsonData.response == 'FinanceiroFechado'){
																Ext.MessageBox.alert('Error','Financiero Indisponible'); //aki uma funcao se necessario);
																//storeLancCaixa.reload(); 
																};
											}, 
											failure:function(response,options){
												Ext.MessageBox.alert('Alerta', 'Erro...');
													}         
												}) 
												}
												else{
													Ext.MessageBox.alert('Alerta', 'Ningum caja seleccionado...');
												}
												
											}	
										}  
							}),
							'-',
							{
							xtype:'button',
							text: 'Encerrar Caja',
							iconCls: 'icon-box_close',
							disabled: false,
							handler: function(){ // fechar	
										if(typeof(selectedKeys) != "undefined"){
										Ext.Ajax.request({ 
										waitMsg: 'Executando...',
										url: 'php/CaixaUsu.php',
										params: { 
												idCaixa: selectedKeys,
												acao: 'encerrar',
												user: id_usuario
												},
												success: function(result, request){//se ocorrer correto 
												var jsonData = Ext.util.JSON.decode(result.responseText);
												if(jsonData.response == 'CaixaEncerrado'){
																Ext.MessageBox.alert('Aviso','Caja Encerrado.'); //aki uma funcao se necessario);
															//	dsCaixaUsu.reload(); 
																};
												if(jsonData.response == 'SaldoAtivo'){
																Ext.MessageBox.alert('Error','Saldo en Caja, Favor Transferir'); //aki uma funcao se necessario);
															//	storeLancCaixa.reload(); 
																};
												if(jsonData.response == 'UsuarioNaoConfere'){
																Ext.MessageBox.alert('Error','Esta Caja no es Tuyo'); //aki uma funcao se necessario);
															//	storeLancCaixa.reload(); 
																};
														}, 
												failure:function(response,options){
												Ext.MessageBox.alert('Alerta', 'Erro...');
													}         
												}) 
												}
												else{
													Ext.MessageBox.alert('Alerta', 'Ningum caja seleccionado...');
												}

						}
						
  			 			}
				
				] 
		})
});

storeLancCaixa.on('load', function(){
	
		Entradas = storeLancCaixa.reader.jsonData.Entradas;
		if(Entradas == ""){
		Entradas = 0.00;
		}
		Saidas = storeLancCaixa.reader.jsonData.Saidas;
		if(Saidas == ""){
		Saidas = 0.00;
		}		
		Trf = storeLancCaixa.reader.jsonData.Trf;
		if(Trf == ""){
		Trf = 0.00;
		}	
		Devs = storeLancCaixa.reader.jsonData.Devs;
		if(Devs == ""){
		Devs = 0.00;
		}	
		var TotalCaixa = parseFloat(Entradas) - parseFloat(Saidas) - parseFloat(Trf) - parseFloat(Devs);
		Ext.getCmp('TotalCaixa').setValue(Ext.util.Format.usMoney(TotalCaixa));	
		});
		

gridCaixaUsu.on('rowclick', function(grid, row, e) {
					 selectedKeys = gridCaixaUsu.selModel.selections.keys;
					if(selectedKeys.length > 0){	
					 selectedRows = gridCaixaUsu.selModel.selections.items;
					 selectedKeys = gridCaixaUsu.selModel.selections.keys;
					
					record = gridCaixaUsu.getSelectionModel().getSelected();
					var colName = gridCaixaUsu.getColumnModel().getDataIndex(4); // Get field name
					var situacao = record.get(colName);
					
					storeLancCaixa.load({params:{caixaid: selectedKeys}});
									
					}
		});

		
///TERMINA A GRID	
    FormGridLancCaixa = new Ext.Panel({
			id: 'FormGridLancCaixa',
            title: 'LANCAMIENTOS DEL CAJA',
			frame		: true,
			closable:true,
            autoWidth   : true,
            split: true,
			//height	: 350,
			autoHeight: true,
			layout:'fit',
            items:[gridLancCaixa],
            listeners:{
					destroy: function() {
							 tabs.remove('simplePedidos');
         				   }
		              }
            });


	formCaixaUsu = new Ext.FormPanel({
		    autoWidth:true,
		//	autoScroll: true,
			border: false,
			id: 'formCaixaUsu',
	        frame:true,
			//autoHeight: true,
			//height: 300,
			closable: true,
			layout: 'form',
	        title: 'Caixa User',
			autoScroll:true,
			items: [gridCaixaUsu,FormGridLancCaixa],
			listeners:{
				destroy: function() {
                             //grid_ItensPedido.destroy();
							 //sul.remove('FormGridPedidosEdit');
							 
         				}
			         }	
 });













Ext.getCmp('tabss').add(formCaixaUsu);
Ext.getCmp('tabss').setActiveTab(formCaixaUsu);
formCaixaUsu.doLayout();	


};
