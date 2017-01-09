// JavaScript Document

  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
  Ext.QuickTips.init();
  Ext.form.Field.prototype.msgTarget = 'side';
  
   RelMens = function(){
  
//    if(perm.relatorio_mensal.acessar == 0){
//return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
//}
								  
var ContPagar;									  
var winPagar;
var idData;
var totalProd;
var win_ctpg;
var xg = Ext.grid;
 
///COMECA A GRID /////
          storeMensal = new Ext.data.Store({
			url: 'php/relatorio_anual.php',
			method: 'POST',
			autoLoad: true,
		reader:  new Ext.data.JsonReader({
			root: 'result',
			id: 'ANO',
			autoLoad: true
		},
	      [
			{name: 'ANO', type: 'int'},
            {name: '1'},
			{name: '2'},
			{name: '3'},
			{name: '4'},
			{name: '5'},
			{name: '6'},
			{name: '7'},
			{name: '8'},
			{name: '9'},
			{name: '10'},
			{name: '11'},
			{name: '12'}
 		]
		),
        sortInfo: {field: 'ANO', direction: 'DESC'}
   });
	
    var grid_forn = new Ext.grid.EditorGridPanel({
	    store: storeMensal,
		loadMask: {msg: 'Carregando...'},
        columns: [
            {header: "Ano",	name: 'ANO', sortable: true, dataIndex: 'ANO',fixed:true, width: 50},
			{header: "Janeiro", renderer: 'usMoney', align: 'right', sortable: true, dataIndex: '1', fixed:true, width: 70},
			{header: "Fevereiro", renderer: 'usMoney', align: 'right', sortable: true, dataIndex: '2', fixed:true, width: 70},
			{header: "Marco", renderer: 'usMoney', align: 'right', sortable: true, dataIndex: '3', fixed:true, width: 70},
			{header: "Abril", renderer: 'usMoney', align: 'right', sortable: true, dataIndex: '4', fixed:true, width: 70},
			{header: "Maio", renderer: 'usMoney', align: 'right', sortable: true, dataIndex: '5', fixed:true, width: 70},
			{header: "Junho", renderer: 'usMoney', align: 'right', sortable: true, dataIndex: '6', fixed:true, width: 70},
			{header: "Julho", renderer: 'usMoney', align: 'right', sortable: true, dataIndex: '7', fixed:true, width: 70},
			{header: "Agosto", renderer: 'usMoney', align: 'right', sortable: true, dataIndex: '8', fixed:true, width: 70},
			{header: "Setembro", renderer: 'usMoney', align: 'right', sortable: true, dataIndex: '9', fixed:true, width: 70},
			{header: "Outubro", renderer: 'usMoney', align: 'right', sortable: true, dataIndex: '10', fixed:true, width: 70},
			{header: "Novembro", renderer: 'usMoney', align: 'right', sortable: true, dataIndex: '11', fixed:true, width: 70},
			{header: "Dezembro", renderer: 'usMoney', align: 'right', sortable: true, dataIndex: '12', fixed:true, width: 70}
			],
        autoWidth: true,
        height: 385,   
		border: false,
		autoScroll:false,
        iconCls: 'icon-grid',
		tbar: [],
		bbar: []
    /*    listeners:{ 
	    celldblclick: function(grid, rowIndex, columnIndex, e){
            record = grid.getStore().getAt(rowIndex); // Pega linha 
            mes = columnIndex;
            ano = record.id;
			dsMensal.baseParams.mes = mes;
            dsMensal.baseParams.ano = ano;
			dsMensal.load();
        
        Ext.getCmp('tabss').add(FormMensal);
        Ext.getCmp('tabss').setActiveTab(FormMensal);
        FormMensal.doLayout();
         
         }
		
	}*/

    });
    
    dsMensal = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: '../php/relatorio_mensal.php',
        method: 'POST'
    }),
    reader:  new Ext.data.JsonReader({
			root: 'results',
			remoteSort: true,
			fields: [
					 {name: 'TotalVendas'},
					 {name: 'TotalCompras'},
                     {name: 'TotalRec'},
                     {name: 'TotalForn'},
					 {name: 'TotalDesp'},
					 {name: 'TotalLiq'}
					 ]
			}),
	       baseParams:{acao: 'RelMensal'}
		});       
                MensalTemplate = 
		                      [
                                '<style>'
                                ,'fieldset {'
                                ,'width: 50%;'
                                ,'margin: 5px 3px 5px 0px;'
                                ,'padding: 5px;'
                                ,'}'
                                ,'</style>'
                            ,'<fieldset>'
                            ,'<legend><font color=#EF8621 >Compras e Vendas Realizadas no Mes</font></legend>'
                            ,'</br>'
							,'<b>Total Vendas: &nbsp;</b>{TotalVendas}<br/>'
                            ,'<b>Total Compras: &nbsp;</b>{TotalCompras}<br/>'
                            ,'</br>'
                            ,'</fieldset>'
                            ,'<fieldset>'
                            ,'<legend><font color=#EF8621 >Entradas/Saidas de Caixa</font></legend>'
                            ,'<br/>'
                            ,'<b>Total Recebimentos: &nbsp;</b>{TotalRec}<br/>'
                            ,'<br/>'
							,'<b>Pago Fornecedores: &nbsp;</b>{TotalForn}<br/>'
							,'<b>Pago Despesas: &nbsp;</b>{TotalDesp}<br/>'
                            ,'</fieldset>'
                            ,'<br/>'
							,'<b>Total Liquido Efetivo: &nbsp;</b>{TotalLiq}<br/>'
							,'</br>'
							];            
		MensalTpl = new Ext.XTemplate(MensalTemplate);
        
       	var formtplMensal = new Ext.Panel({
        frame:false,
        border: true,
		items:[]
	       });
        
        FormMensal = new Ext.FormPanel({
	    title: 'Relatorio Mensal',
		id: 'FormMensal',
		layout:'form',
		frame: true,
		closable:true,
		autoWidth: true,
		titleCollapse: false,
		items:[formtplMensal],
        listeners:{
        destroy: function() {
					sul.remove('FormRelMen');	 
         				}					
        }					
        });
    
    dsMensal.on('load', function(){
	if(mes > 0){   
	MensalTpl.overwrite(formtplMensal.body, dsMensal.reader.jsonData.results);
	}
	else{
		Ext.MessageBox.alert('Alerta', 'Selecione um Mes');
	}
    });
///TERMINA A GRID	

FormRelMen = new Ext.FormPanel({
	    title: 'Relatorio Anual',
		id: 'FormRelMen',
		layout:'form',
		frame: true,
		closable:true,
		autoWidth: true,
		titleCollapse: false,
		items:[grid_forn],
        listeners:{
        destroy: function() {
                        // FormPedido.destroy();
					tabs.remove('FormMensal');	 
         				}					
        }
});	

Ext.getCmp('tabss').add(FormRelMen);
Ext.getCmp('tabss').setActiveTab(FormRelMen);


 }
