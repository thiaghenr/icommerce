// JavaScript Document

  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
  Ext.QuickTips.init();
  Ext.form.Field.prototype.msgTarget = 'side';
  
   RelMens = function(){
  
//    if(perm.relatorio_mensal.acessar == 0){
//return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
//}

var gera_rel;								  
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
			{header: "Janeiro", align: 'right',renderer: Ext.util.Format.usMoney, sortable: true, dataIndex: '1', fixed:true},
			{header: "Fevereiro", align: 'right',renderer: Ext.util.Format.usMoney, sortable: true, dataIndex: '2', fixed:true},
			{header: "Marco", align: 'right',renderer: Ext.util.Format.usMoney, sortable: true, dataIndex: '3', fixed:true},
			{header: "Abril", align: 'right',renderer: Ext.util.Format.usMoney, sortable: true, dataIndex: '4', fixed:true},
			{header: "Maio", align: 'right',renderer: Ext.util.Format.usMoney, sortable: true, dataIndex: '5', fixed:true},
			{header: "Junho", align: 'right',renderer: Ext.util.Format.usMoney, sortable: true, dataIndex: '6', fixed:true},
			{header: "Julho", align: 'right',renderer: Ext.util.Format.usMoney, sortable: true, dataIndex: '7', fixed:true},
			{header: "Agosto", align: 'right',renderer: Ext.util.Format.usMoney, sortable: true, dataIndex: '8', fixed:true},
			{header: "Setembro", align: 'right',renderer: Ext.util.Format.usMoney, sortable: true, dataIndex: '9', fixed:true},
			{header: "Outubro", align: 'right',renderer: Ext.util.Format.usMoney, sortable: true, dataIndex: '10', fixed:true},
			{header: "Novembro", align: 'right',renderer: Ext.util.Format.usMoney, sortable: true, dataIndex: '11', fixed:true},
			{header: "Dezembro", align: 'right',renderer: Ext.util.Format.usMoney, sortable: true, dataIndex: '12', fixed:true}
			],
        autoWidth: true,
        height: 385,   
		border: false,
		autoScroll:false,
        iconCls: 'icon-grid',
		tbar: [],
		bbar: [],
        listeners:{ 
	    celldblclick: function(grid, rowIndex, columnIndex, e){
            record = grid.getStore().getAt(rowIndex); // Pega linha 
            mes = columnIndex;
            ano = record.id;
			dsMensal.baseParams.mes = mes;
            dsMensal.baseParams.ano = ano;
			dsMensal.load();
        
       winRelCaixa.show();
         
         }
		
	}

    });

	var ano;
	//////////////// INICIO PDF /////////////////////////////////////////////////////////////////	
    //var imprimir = function(){
	var win_RL_PDF = new Ext.Window({
					id: 'imprimeRL',
					title: 'Relatorio Mensal',
					width: 650,
					height: 500,
					shim: false,
					animCollapse: false,
					constrainHeader: true,
					maximizable: false,
					layout: 'form',
					items: { html: "<iframe height='600' width='100%' src='../pdf_relatorio_mensal.php?ano="+ano+"' > </iframe>" },
					buttons: [
           						{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					win_RL_PDF.destroy();
  			 					}
			 
        					}]
				});
	//	win_RL_PDF.show();
	//}
/////////FIM PDF ///////////////////////////////////////////////////////////////////////////////				
  


  
    dsMensal = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: 'php/relatorio_mensal.php',
        method: 'POST'
    }),
    reader:  new Ext.data.JsonReader({
			root: 'results',
			remoteSort: true,
			fields: [
					 {name: 'VendasVista'},
					 {name: 'TotalCompras'},
                     {name: 'TotalRec'},
                     {name: 'TotalForn'},
					 {name: 'TotalDesp'},
					 {name: 'TotalLiq'},
					 {name: 'VendasPrazo'},
					 {name: 'ComprasPrazo'}
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
                            ,'<legend><font color=#EF8621 >Compras e Vendas Realizadas no Meees</font></legend>'
                            ,'</br>'
							,'<b>Ventas: &nbsp;{TotalVendas}</b><br/>'
							,'<br/>'
                            ,'<b>Compras: &nbsp;{TotalCompras}</b><br/>'
							,'<br/>'
							,'<b>Despesas Gerais: &nbsp;{TotalDesp}</b><br/>'
                            ,'</br>'
                            ,'</fieldset>'
                            ,'<fieldset>'
                            ,'<legend><font color=#EF8621 >Entradas/Saidas de Caixa</font></legend>'
                            ,'<br/>'
                            ,'Venta al Contado: &nbsp;{VendasVista}<br/>'
							,'Carteira a Recibir: &nbsp;{CartReceber}<br/>'
							,'<b>Total: &nbsp;</b>{TotalEnt}<br/>'
                            ,'<br/>'
							,'Pago Proveedores: &nbsp;{CartPagar}<br/>'
							,'Pago Despesas: &nbsp;{PagoDesp}<br/>'
							,'Retiradas: &nbsp;{TotalRet}<br/>'
							,'<b>Total: &nbsp;</b>{TotalSaidas}<br/>'
                            ,'</fieldset>'

							]
		var button = {
            					text: 'Imprimir',
            					handler: function(){ // fechar	
     	    					win_RL_PDF.show();
								alert('oi');
  			 					}
							}; 
							           
		MensalTpl = new Ext.XTemplate(MensalTemplate);
        
       	var formtplMensal = new Ext.Panel({
        frame:false,
        border: true,
		items:[MensalTpl]
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
		bbar: [{
           			    text: 'imprimir',
						id: 'printer',
						align: 'left',
						iconCls: 'icon-print',
            			handler: function(){ // fechar	
						function popup(){
window.open('pdf_relatorio_mensal.php?ano='+ano +'&mes='+mes +'','popup','width=850,height=500,scrolling=auto,top=0,left=0')
}
popup();
     	    			//win_RL_PDF.show();
  			 			}
						}],
        listeners:{
        destroy: function() {
				//	sul.remove('FormRelMen');	 
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


winRelCaixa = new Ext.Window({
		title: 'Fluxo',
		width:500,
		height:400,
		shim:true,
		closable : true,
		resizable: false,
		closeAction: 'hide',
		draggable: true, //Movimentar Janela
		plain: true,
		modal: true, //Bloquear tela do fundo
		items:[FormMensal]
		
	});





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
