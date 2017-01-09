




CaixaChange = function(){

var formataStatus = function(value){
	
	if(value=='0')
		  return '<span style="color: #FF0000;">No</span>';
		else if(value=='1')
		  return  '<span style="color: #00000;">ENVIADO A CUENTA</span>';
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

var action = new Ext.ux.grid.RowActions({
    header:'Informar Cheque'
 //  ,anchor: '10%'
  ,width: 90
  ,autoWidth: false
   ,actions:[{
       iconCls:'icon-edit'
      ,tooltip:'Informar Cheque'
	//  ,width: 1
   }] 
});

action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	  idlcto = record.data.idl;
	  vlcompra = record.data.vl_pago;
	  emissaofat = record.data.dt_lancamento;
	  historico = record.data.descricao;
	  changes = record.data.changes;
	  //console.info(changes);
	  if(changes == '0'){
	  var abrewinentradacheque = function(){Ext.Load.file('jstb/saida_cheque_inf.js', function(obj, item, el, cache){saida_cheque(idlcto,vlcompra,emissaofat,historico);},this)}
							abrewinentradacheque();
		}
		else{
			Ext.MessageBox.alert('AVISO', 'Valor ya enviado a cuenta');
		}
   
   }
});
		///COMECA A GRID DOS ITENS ///////////////////////////////////////////////
	  storeLancCaixaChange = new Ext.data.GroupingStore({
      proxy: new Ext.data.HttpProxy({method: 'POST', url: 'php/caixaChange.php'}),
      groupField:'receita_id',
      sortInfo:{field: 'idl', direction: "asc"},
      reader: new Ext.data.JsonReader({
		 totalProperty: 'total',
	     root:'result',
	     fields: [
			{name: 'idl'},
			{name: 'changes'},
			{name: 'receita_id' ,type: 'string'},
			{name: 'caixa_id'},
			{name: 'dt_lancamento'},
			{name: 'vl_pago', type:'float' },
	        {name: 'pedido_id'},
			{name: 'descricao'},
			{name: 'nome'},
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
     gridLancCaixaChange = new Ext.grid.EditorGridPanel({
	    store: storeLancCaixaChange,
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
					{header: 'Entidade',width: 100,align: 'left', sortable: true, dataIndex: 'nome',name: 'nome'},
					{header: 'Ct Recibir',width: 100,align: 'right',dataIndex: 'contas_receber_id',	name: 'contas_receber_id',fixed:true},
					{header: 'Ct Pagar',width: 100,align: 'right',dataIndex: 'contas_pagar_id',name: 'contas_pagar_id',fixed:true},
					{header: "Valor",width: 150,align: 'right',	sortable: true,	dataIndex: 'vl_pago',summaryType: 'sum',renderer: Ext.util.Format.usMoney,fixed:true},
					{header: "Cheque",width: 150,align: 'right',sortable: true,	dataIndex: 'changes',renderer: formataStatus},
					action
				],
        view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true
        }),

        plugins: [action,summary],
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
				] 
		})
});


	formCaixaChange = new Ext.FormPanel({
		    autoWidth:true,
		//	autoScroll: true,
			border: false,
	        frame:true,
			//autoHeight: true,
			//height: 300,
			closable: true,
			layout: 'form',
	        title: 'Informar Cheque',
			autoScroll:true,
			items: [gridLancCaixaChange],
			listeners:{
				destroy: function() {
                             //grid_ItensPedido.destroy();
							 //sul.remove('FormGridPedidosEdit');
							 
         				}
			         }	
 });

 storeLancCaixaChange.load();


Ext.getCmp('tabss').add(formCaixaChange);
Ext.getCmp('tabss').setActiveTab(formCaixaChange);
formCaixaChange.doLayout();	


};
