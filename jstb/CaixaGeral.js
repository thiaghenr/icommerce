// JavaScript Document
Ext.ux.MoneyField = function(config){
                    var defConfig = {
                            autocomplete: 'off',
                            allowNegative: true,
                            format: 'us',
                            currency: '',
                            showCurrency: false
                    };
                    Ext.applyIf(config,defConfig);
        Ext.ux.MoneyField.superclass.constructor.call(this, config);
    };
    Ext.extend(Ext.ux.MoneyField, Ext.form.TextField,{
           
        /*initComponent:function() {
           
        },*/
   
            initEvents : function(){
            Ext.ux.MoneyField.superclass.initEvents.call(this);
                    this.el.on("keydown",this.stopEventFunction,this);
                    this.el.on("keyup", this.mapCurrency,this);
                    this.el.on("keypress", this.stopEventFunction,this);
        },
       
        KEY_RANGES : {
            numeric: [48, 57],
            padnum: [96, 105]
        },
       
        isInRange : function(charCode, range) {
            return charCode >= range[0] && charCode <= range[1];
        },
                 
        formatCurrency : function(evt, floatPoint, decimalSep, thousandSep) {                 
                floatPoint  = !isNaN(floatPoint) ? Math.abs(floatPoint) : 2;
                thousandSep = typeof thousandSep != "string" ? "" : thousandSep;
                decimalSep  = typeof decimalSep != "string" ? "." : decimalSep;
                var key = evt.getKey();    
               
            if (this.isInRange(key, this.KEY_RANGES["padnum"])) {
                key -= 48;
            }
                       
                this.sign = (this.allowNegative && (key == 45 || key == 109)) ? "-" : (key == 43 || key == 107 || key == 16) ? "" : this.sign;
               
                var character = (this.isInRange(key, this.KEY_RANGES["numeric"]) ? String.fromCharCode(key) : "");    
                    var field = this.el.dom;
                    var value = (field.value.replace(/\D/g, "").replace(/^0+/g, "") + character).replace(/\D/g, "");
                    var length = value.length;
                                                                                   
            if ( character == "" && length > 0 && key == 8) {
                    length--;
                    value = value.substr(0,length);
                    evt.stopEvent();
                    }
                   
            if(field.maxLength + 1 && length >= field.maxLength) return false;
           
            length <= floatPoint && (value = new Array(floatPoint - length + 2).join("0") + value);
            for(var i = (length = (value = value.split("")).length) - floatPoint; (i -= 3) > 0; value[i - 1] += thousandSep);
            floatPoint && floatPoint < length && (value[length - ++floatPoint] += decimalSep);
            field.value = (this.showCurrency && this.currencyPosition == 'left' ? this.currency : '' ) +
                                      (this.sign ? this.sign : '') +
                                      value.join("") +
                                      (this.showCurrency && this.currencyPosition != 'left' ? this.currency : '' );           
        },
         
        mapCurrency : function(evt) {       
            switch (this.format) {
                case 'BRL':
                    this.currency = '';
                    this.currencyPosition = 'left';
                    this.formatCurrency(evt, 2,',','.');
                    break;
                   
                case 'EUR':
                    this.currency = ' €';
                    this.currencyPosition = 'right';
                    this.formatCurrency(evt, 2,',','.');
                    break;
                   
                case 'USD':
                    this.currencyPosition = 'left';
                    this.currency = '';
                    this.formatCurrency(evt, 2);
                    break;
                   
                default:
                    this.formatCurrency(evt, 2);
            }
        },
   
            stopEventFunction : function(evt) {
            var key = evt.getKey();
           
            if (this.isInRange(key, this.KEY_RANGES["padnum"])) {
                key -= 48;
            }
           
            if ( (( key>=41 && key<=122 ) || key==32 || key==8 || key>186) && (!evt.altKey && !evt.ctrlKey) ) {
                            evt.stopEvent();
                    }
            },
           
            getCharForCode : function(keyCode){   
                    var chr = '';
                    switch(keyCode) {
                            case 48: case 96: // 0 and numpad 0
                                    chr = '0';
                                    break;
                           
                            case 49: case 97: // 1 and numpad 1
                                    chr = '1';
                                    break;
                           
                            case 50: case 98: // 2 and numpad 2
                                    chr = '2';
                                    break;
                           
                            case 51: case 99: // 3 and numpad 3
                                    chr = '3';
                                    break;
                           
                            case 52: case 100: // 4 and numpad 4
                                    chr = '4';
                                    break;
                           
                            case 53: case 101: // 5 and numpad 5
                                    chr = '5';
                                    break;
                           
                            case 54: case 102: // 6 and numpad 6
                                    chr = '6';
                                    break;
                           
                            case 55: case 103: // 7 and numpad 7
                                    chr = '7';
                                    break;
                           
                            case 56: case 104: // 8 and numpad 8
                                    chr = '8';
                                    break;
                           
                            case 57: case 105: // 9 and numpad 9
                                    chr = '9';
                                    break;
                           
                            case 45: case 189: case 109:
                                    chr = '-';
                                    break;
                           
                            case 43: case 107: case 187:
                                    chr = '+';
                                    break;
                           
                            default:
                                    chr = String.fromCharCode(keyCode); // key pressed as a lowercase string
                                    break;
                    }
                    return chr;
        }
    });
   
    Ext.ComponentMgr.registerType('moneyfield', Ext.ux.MoneyField);

Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
  
Ext.QuickTips.init();
Ext.form.Field.prototype.msgTarget = 'side';


  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  					 					 
CaixaGeral = function(){	

if(perm.CaixaGeral.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}

    Ext.QuickTips.init();
    Ext.form.Field.prototype.msgTarget = 'side';

var w = Ext.getCmp('west-panel');
//w.collapse();
	
// Função que trata exibição do Ativo S = Sim e N = Não
var Receita = function(value){
	
	if(value=='2')
		  return 'Saida';
		else if(value=='7')
		  return '<span style="color: #3333ff;">Transferencia</span>';
		else if(value=='1')
		  return '<span style="color: #3333ff;">Otras Entradas</span>';
		else
		  return 'Desconhecido'; 

};

var NomeCaixa = function(value){
	
	if(value > '0')
		  return 'Caixa ' + value;
		
};

dsTotal = new Ext.data.Store({
			url: '../php/CaixaGeral.php',
          	method: 'POST',
          	//baseParams:{acao: "SaldoTotal"},
		  	reader: new Ext.data.JsonReader({
             	//root: 'Lcto',
             	fields: [
              	{name: 'entradasGeral'},
              	{name: 'saidasGeral'},
              	{name: 'totalGeral'},
				{name: 'saldoAnterior'}
              	]
          })
									 });
 



///////GRID DOS LANCAMENTOS DE CAIXA/////////////////////
 dsLctoCaixa = new Ext.data.GroupingStore({
			 proxy: new Ext.data.HttpProxy({
                url: '../php/CaixaGeral.php',
                method: 'POST'
				}),
				groupField:'caixa_id',
				sortInfo:{field: 'caixa_id', direction: "asc"},
				nocache: true,

 reader:  new Ext.data.JsonReader({
				totalProperty: 'totalLcto',
				root: 'Lcto',
				id: 'id',
				fields: [
						 {name: 'id', type: 'string'},
						 {name: 'saidas'},
						 {name: 'receita_id' },
						 {name: 'caixa_id', type: 'string' },
						 {name: 'datalcto' },
						 {name: 'venda_id'},
						 {name: 'caixa' },
						 {name: 'nome' },
						 {name: 'historico' },
						 {name: 'valor', type: 'float' },
						 {name: 'total_linha'},
						 {name: 'totalGeralCaixa'}
						 
						 ]
				

			})					    
			
		});
 var gridFormItens = new Ext.BasicForm(
		Ext.get('form9'),
		{
			});

	// define a custom summary function
     Ext.grid.GroupSummary.Calculations['totalGeralCaixa'] = function(v, record, field){
		 //gridProd.getBottomToolbar().items.items[3].el.innerHTML = v;
		var v = v+ (parseFloat(record.data.saidas) * parseFloat(record.data.vl_real));   //toNum
	//		Ext.getCmp("entradas").setValue((v));
	//	var record = gridLctoCaixa.getStore().getAt( 'saidas' );
	//	console.log(record);
		// var subnota =  Ext.get("SubTotal").getValue();
		 //var subnotaA = subnota.replace(".","");
		 //var subnotaB = subnotaA.replace(",",".");
	//	var frete = Ext.get("Frete").getValue();
	//	var freteA = frete.replace(".","");
	//	var freteB = freteA.replace(",",".");
		//console.log(freteB);
	//	var totalnota = parseFloat(freteB) + parseFloat(subnota);
		//console.log(totalnota);
		//totalnota = (totalnota);
	//	Ext.getCmp("Total").setValue(Ext.util.Format.usMoney(totalnota));
        //console.log(totalnota);
		
		return v;
		
    }

var summary = new Ext.grid.GroupSummary(); 

 gridLctoCaixa = new Ext.grid.EditorGridPanel({
   store: dsLctoCaixa,
   enableColLock: true,
   containerScroll  : false,
   loadMask: {msg: 'Carregando...'},
     columns: [
	  {id: 'id', header: 'id', hidden: true, dataIndex: 'id'},	
	  {id: 'receita_id', header: 'Receita', width: 100, dataIndex: 'receita_id', renderer: Receita },	
	  {id: 'datalcto', header: 'Data',  width: 100, hidden: false, dataIndex: 'datalcto'},
	  {id: 'caixa_id', header: 'Caixa', width: 80, hidden: false, dataIndex: 'caixa_id', renderer: NomeCaixa},
      {id: 'venda_id', header: 'Compra', width: 80, hidden: false, dataIndex: 'venda_id'},
      {id: 'caixa',  header: 'Caja', width: 80, dataIndex: 'caixa'},
      {id: 'nome', header: "Fornecedor", dataIndex: 'nome',  width: 120, align: 'left'},
	  {id: 'historico', header: "Historico", dataIndex: 'historico',  width: 120, align: 'left'},
	  {id: 'valor', header: "Valor $", dataIndex: 'valor', width: 100, align: 'right', renderer: "usMoney"},
	  {	
                id: 'total_linha',
                header: "Total",
                width: 100,
				align: 'right',
                sortable: false,
				hidden: true,
				fixed:true,
                groupable: false,
                renderer: function(v, params, record){
                return Ext.util.Format.usMoney(parseFloat(record.data.vl_real) * parseFloat(record.data.vl_real));
                },
				id:'totalGeralCaixa',
                dataIndex: 'totalGeralCaixa',
                summaryType:'totalGeralCaixa',
				fixed:true,
				hidden: true,
                summaryRenderer: Ext.util.Format.usMoney
				
            }
	  
   ],
	 view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true
        }),
   autoWidth:true,
   height:300,
   ds: dsLctoCaixa,
   border: true,
   plugins: [summary],
   loadMask: true,
   tbar : new Ext.Toolbar({ 
			items: [
						{
						xtype:'button',
           			    text: 'Extornar Lancamento',
						id: 'extorno',
						align: 'left',
						iconCls: 'icon-undo',
						hidden: true,
            			handler: function(){ 
     	    			//CancPedido();
						}
						
  			 			}
					//	, '<b>Total=</b>',''
		
		] 
		}),
		bbar: new Ext.PagingToolbar({
				store: dsLctoCaixa,
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

//////////////////////////////////////////////////////////////////////////



FormCaixaGeralSul = new Ext.Panel({
			id: 'FormCaixaGeralSul',
            title       : 'Caixa Geral',
			labelAlign: 'left',
			//bodyStyle: 'margin-left: 185',
			frame		: true,
			closable	:true,
            autoWidth   : true,
            collapsible : false,
			layout:'form',
items: [{
    height: 150,
    minSize: 75,
	items: {
            xtype:'tabpanel',
			id: 'TabSulCaixa',
			height: 150,
            activeTab: 0,
            defaults:{autoHeight:false},
			
			//////////// INICIO DAS ABAS /////////////////////
            items:[
				//////// INICIO ABA PRIMEIRA ////////////////////////////////////   
				{
                title:'Saldo no Periodo',
				id: 'Tab_A',
				//iconCls: 'icon-money',
                layout:'form',
				items:[		// ABRE A
					   {  // ABRE A1
					   layout:'column',
					   border: false,
					   items:[		// ABRE B
					   {   // ABRE B1
						columnWidth:.4,
						layout: 'form',
						border: true,
						items: [  // ABRE C
								{
								xtype:'textfield',
								fieldLabel: 'Entradas $',
								id: 'entradasg',
								name: 'entradasg',
								readOnly: true,
								emptyText: '0,00',
								width: 150
							   }, // FECHA XTYPE
							   {
								xtype:'textfield',
								fieldLabel: 'Saidas $',
								name: 'saidasg',
								id: 'saidasg',
								readOnly: true,
								dataIndex: 'saidas',
								//emptyText: '0,00',
								width: 150
							   }, // FECHA XTYPE
							   {
								xtype:'textfield',
								fieldLabel: 'Saldo $',
								id: 'totalg',
								name: 'totalg',
								readOnly: true,
								emptyText: '0,00',
								width: 150
							   } // FECHA XTYPE
           
							] // FECHA C	
				   		} ,  // // FECHA B1
				   	    {   // ABRE B2
						columnWidth:.4,
						layout: 'form',
						border: true,
						items: [  // ABRE C2
								] //FECHA C2
						} // FECHAB2
				   	]  // FECHA B
				   } // // FECHA A1
				   ]  // FECHA A
            },
			////////// FIM ABA PRIMEIRA ////////////////////////////////
			
			////// INICIO ABA SEGUNDA ////////////////////////////////
				{
                title:'Saldo Caixa Atual',
				id: 'Tab_B',
                layout:'fit',
				//width: 350,
				//labelAlign: 'right',
				frame: true,
				//height: 190,
				//hideBorders : true,
				//autoHeight: true,
				//iconCls: 'icon-money',
                items:[		// ABRE A
					   {  // ABRE A1
					   layout:'column',
					   border: false,
            		   items:[		// ABRE B
					   		   {   // ABRE B1
								columnWidth:.3,
								layout: 'form',
								border: false,
								items: [  // ABRE C
											{
											xtype:'textfield',
											fieldLabel: 'Saldo Inicial $',
											id: 'saldoanterior',
											name: 'saldoanterior',
											readOnly: true,
											emptyText: '0,00',
											width: 150
										    } // FECHA XTYPE
           
										] // FECHA C	
				   				} ,  // // FECHA B1
					{   // ABRE B2
					columnWidth:.4,
					layout: 'form',
					border: true,
					items: [  // ABRE C2
							{
							xtype:'textfield',
							fieldLabel: 'Total Entradas $',
							id: 'entradasGeral',
							name: 'entradasGeral',
							//readOnly: true,
							//emptyText: '0,00',
							width: 150
						   }, // FECHA XTYPE
							{
							xtype:'textfield',
							fieldLabel: 'Total Saidas $',
							name: 'saidasGeral',
							id: 'saidasGeral',
							readOnly: true,
							dataIndex: 'saidas',
							//emptyText: '0,00',
							width: 150
						   }, // FECHA XTYPE
						   {
							xtype:'textfield',
							fieldLabel: 'Total Geral $',
							id: 'totalGeral',
							name: 'totalGeral',
							readOnly: true,
							emptyText: '0,00',
							width: 150
						   } // FECHA XTYPE
				
						   ] //FECHA C2
						} // FECHAB2
				   ]  // FECHA B
			   } // // FECHA A1
			]  // FECHA A
            }
			/////////////// FIM ABA SEGUNDA ///////////////////
			
			]
			///////////// FIM DAS ABAS /////////////////////////
		}
		}
		],
		listeners:{
					destroy: function() {
							 tabs.remove('FormCaixaGeral');
         				}
			
		}
 });

	EnviaDeposito = function(){
		var vlRetirar = Ext.getCmp('vlRetirada').getValue();
		datadep = FormCaixaGeral.getForm().findField('datadep').getValue();
		if(idconta_bancaria != "[object HTMLInputElement]"  && vlRetirar != "" && datadep != ""){
			Ext.Ajax.request({ 
				waitMsg: 'Executando...',
				url: 'php/CaixaGeral.php',
				params: { 
					acao: 'DepConta',
					vlRetirar: vlRetirar,
					user: id_usuario,
					datadep: datadep,
					idconta_bancaria: idconta_bancaria
				},
				success: function(result, request){//se ocorrer correto 
					var jsonData = Ext.util.JSON.decode(result.responseText);
					if(jsonData.response == 'Operacion Realizada con Exito'){
						Ext.MessageBox.alert('Aviso','Lancamiento Efectuado con Exito.'); //aki uma funcao se necessario);
						dsLctoCaixa.reload(); 
						dsTotal.reload();
						FormCaixaGeral.getForm().reset();
					};
					if(jsonData.response == 'SaldoInsuficiente'){
						Ext.MessageBox.alert('Aviso','Saldo Insuficiente.'); //aki uma funcao se necessario);
					};
					if(jsonData.response == 'FinanceiroFechado'){
						Ext.MessageBox.alert('Error','Financiero Indisponible'); //aki uma funcao se necessario);
					};
				}, 
				failure:function(response,options){
					Ext.MessageBox.alert('Alerta', 'Erro...');
				}         
			}) 
		}
		else{
			Ext.MessageBox.alert('Erro...', '<b>Verifique Valor y Cuenta</b>');
		}
	}
 
 
 FormCaixaGeral = new Ext.FormPanel({
			//id: 'FormCaixaGeral',
            title       : 'Caixa Geral',
			labelAlign: 'left',
			frame		: true,
			closable:true,
            autoWidth   : true,
			//height	: 350,
            collapsible : false,
			layout:'border',
items: [
		{
	    //title: 'Navigation',
		collapsible: true,
		layout:'form',
		region:'west',
		width: 240,
	    items:[
	   			{
				xtype       : 'fieldset',
				title       : 'Pesquisa por periodo',
				layout      : 'form',
				collapsible : false,                    
				collapsed   : false,
				autoHeight  : true,
				width		: 230,
				forceLayout : true,
				items: [
		  		{
			    xtype: 'datefield',
			    fieldLabel: 'Data incial',
			    name: 'dataini',
			    id: 'dataini',
			    width: 100
			  },
		  	  {
			  xtype: 'datefield',
			  fieldLabel: 'Data final',
			  name: 'datafim',
			  id: 'datafim',
			  width: 100
		  	  },
		     {
			  xtype: 'button',
			  text: 'Buscar',
			  name: 'buscar',
			  handler: function(){ 
			  dsLctoCaixa.load(({params:{'acao': 'ListaLcto', 'dataini': Ext.get('dataini').getValue(), 'datafim':Ext.get('datafim').getValue()}}));
			  						}
		  }
		   ]},
		   
		  {
			  bodyStyle: 'margin-top:18px;'
		  },
		  			{
					xtype       : 'fieldset',
					title       : 'Abrir/Encerrar Caixa',
					layout      : 'form',
					collapsible : false,                    
					collapsed   : false,
					autoHeight  : true,
					width		: 180,
					forceLayout : true,
					items: [{
							xtype: 'numberfield',
							fieldLabel: 'Caixa Atual',
							id: 'caixa_id',
							name: 'caixa_id',
							readOnly: true,
							anchor: '100%'
							},
							 {
							  xtype: 'button',
							  text: 'Abrir',
							  name: 'abrir',
							  id:  'abrir',
							  hidden: true,
							  handler: function(){ 
			  						Ext.Ajax.request({
            						 url: '../php/CaixaGeral.php', 
           							 params : {
			   						 acao: 'ACaixa',
			   						 user: id_usuario
            						},
									success: function(result, request){//se ocorrer correto 
											var jsonData = Ext.util.JSON.decode(result.responseText);
											if(jsonData.response == 'Caixa Aberto com Sucesso'){ 
                          						Ext.MessageBox.alert('Aviso', 'Caixa Aberto com Sucesso');
		 										//Ext.getCmp('abrir').setVisible(false);
												//Ext.getCmp('encerrar').setVisible(true);
												dsLctoCaixa.reload();
												dsTotal.reload();
									 		}
											
                        			},
									failure: function(){
                           					Ext.example.msg('Erro','N&atilde;o foi possivel Alterar.');
                           					dsProds.rejectChanges();
                        					} 
					 	});
			  						}
		  },
		   {
			  xtype: 'button',
			  text: 'Encerrar',
			  name: 'encerrar',
			  id: 'encerrar',
			  hidden: true,
			  handler: function(){ 
			  					Ext.Ajax.request({
            						 url: '../php/CaixaGeral.php', 
           							 params : {
               						 id: caixaid,
			   						 acao: 'Encerrar',
			   						 user: id_usuario
            						},
									success: function(result, request){//se ocorrer correto 
											var jsonData = Ext.util.JSON.decode(result.responseText);
											if(jsonData.response == 'Caixa Encerrado com Sucesso'){ 
                          						Ext.MessageBox.alert('Aviso', 'Caixa Encerrado com Sucesso');
		 										Ext.getCmp('abrir').setVisible(true);
												Ext.getCmp('encerrar').setVisible(false);
									 		}
											
                        			},
									failure: function(){
                           					Ext.example.msg('Erro','N&atilde;o foi possivel Alterar.');
                           					dsProds.rejectChanges();
                        					} 
					 	});
			  
			  						}
		  }
		  ]
					 },
		{
			  bodyStyle: 'margin-top:18px;'
		  },
		  			{
					xtype       : 'fieldset',
					title       : 'Deposito bancario',
					layout      : 'form',
					collapsible : false,                    
					collapsed   : false,
					autoHeight  : true,
					width		: 230,
					labelWidth: 40,
					labelAlign: 'top',
					forceLayout : true,
					items: [
							{
							xtype:'combo',
							hideTrigger: false,
							allowBlank: false,
							editable: true,
							mode: 'remote',
							triggerAction: 'all',
							dataField: ['idconta_bancaria','conta'],
							loadingText: 'Consultando Banco de Dados',
							selectOnFocus: true,
							fieldLabel: 'Cuenta Destino',
							id: 'conta',
							minChars: 2,
							name: 'conta',
							width: 180,
							resizable: true,
							listWidth: 350,
							forceSelection: true,
							store: new Ext.data.JsonStore({
							url: 'pesquisa_conta_bancaria.php?acao_nome=NomeConta',
							root: 'resultados',
							fields: [ 'idconta_bancaria', 'conta' ]
							}),
								hiddenName: 'idconta_bancaria',
								valueField: 'idconta_bancaria',
								displayField: 'conta',
								onSelect: function(record){
									idconta_bancaria = record.data.idconta_bancaria;
									this.collapse();
									this.setValue(idconta_bancaria);
									//Ext.getCmp('idFornecedor').setValue(idforn);
									//Ext.getCmp('nomedesp').focus();
									//console.info(idforn);
								}
										
							},
							{
							xtype: 'datefield',
							fieldLabel: 'Fecha',
							name: 'datadep',
							format: 'Y-m-d',
							//id: 'datadep',
							width: 100
							},
							{
							xtype:'moneyfield',
							fieldLabel: 'Valor',
							id:'vlRetirada',
							//mask:'decimal',
							//textReverse : true,
							width: 110,
							fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter 
								EnviaDeposito();													
											}	
										}  
							},
							{
							  xtype: 'button',
							  text: 'Enviar',
							  handler: function(){ 
								EnviaDeposito();
								}
						  }
							 
		  ]
					 }
			
		  ]
},{
    //title: 'Lancamentos',
    collapsible: false,
    region:'center',
	autoScroll: true,
   // margins: '-42 -42  -42 0',
	//cmargins: '0 0 0 0',
	height: 450,
	layout: 'form',
	items:[gridLctoCaixa,FormCaixaGeralSul]
}]

})
 
 
dsLctoCaixa.load(({params:{'acao': 'ListaLcto', 'start':0, 'limit':200}}));

dsLctoCaixa.on('load', function() {
				
		var totalSaidas = dsLctoCaixa.reader.jsonData.saidas;	
		Ext.getCmp('saidasg').setValue(Ext.util.Format.usMoney(totalSaidas));
		
		var totalEntradas = dsLctoCaixa.reader.jsonData.transf;
		Ext.getCmp('entradasg').setValue(Ext.util.Format.usMoney(totalEntradas));
		
		var total = totalEntradas - totalSaidas;
		Ext.getCmp('totalg').setValue(Ext.util.Format.usMoney(total));
								  });

dsTotal.load(({params:{'acao': 'SaldoTotal'}}));

dsTotal.on('load', function(){
	
		var totalE = dsTotal.reader.jsonData.entradasGeral;
		Ext.getCmp('entradasGeral').setValue(Ext.util.Format.usMoney(totalE));	
		
		var totalS = dsTotal.reader.jsonData.saidasGeral;
		Ext.getCmp('saidasGeral').setValue(Ext.util.Format.usMoney(totalS));		
	
		var totalGeral = dsTotal.reader.jsonData.acumulado;
		Ext.getCmp('totalGeral').setValue(Ext.util.Format.usMoney(totalGeral));	
		
		var saldoAnterior = dsTotal.reader.jsonData.saldoAnterior;
		Ext.getCmp('saldoanterior').setValue(Ext.util.Format.usMoney(saldoAnterior));	
		
		caixaid = dsTotal.reader.jsonData.caixa;
		Ext.getCmp('caixa_id').setValue(caixaid);	
		
		var status = dsTotal.reader.jsonData.status;
		if(status === 'A')
		 Ext.getCmp('encerrar').setVisible(true);
		if(status === 'F')
		 Ext.getCmp('abrir').setVisible(true);

});


Ext.getCmp('tabss').add(FormCaixaGeral);
Ext.getCmp('tabss').setActiveTab(FormCaixaGeral);
FormCaixaGeral.doLayout();
/*
Ext.getCmp('sul').add(FormCaixaGeralSul);
Ext.getCmp('sul').setActiveTab(FormCaixaGeralSul);
FormCaixaGeralSul.doLayout();
*/
	
	
	}	
