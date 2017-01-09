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


AbreContas = function(){

var SaldoPeriodo;

var selecione = function(){
Ext.MessageBox.alert('Aviso', 'Favor clicar en la cuenta para deposito');
}

//////////INICIO DA STORE ////////////////////
var dsContas = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: '../sistema/php/ContasBanco.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Contas',
			totalProperty: 'totalContas',
			id: 'idconta_bancaria'
		},
			[
			{name: 'idconta_bancaria'},
			{name: 'nome_banco'},
			{name: 'nm_agencia'},
			{name: 'nm_conta'},
			{name: 'limite'},
			{name: 'nm_moeda'}
			]
		),
		sortInfo: {field: 'id', direction: 'ASC'},
		remoteSort: true		
	});
//////// FIM STORE //////////////
//////// INICIO DA GRID  ////////
 var grid_Contas = new Ext.grid.EditorGridPanel(
	    {
	        store: dsContas, // use the datasource
	        
	        columns:
		        [
						{id:'idconta_bancaria',header: "Num.", width: 20, sortable: true, dataIndex: 'idconta_bancaria'},	        
						{header: "Banco", width: 150, align: 'left', sortable: true, dataIndex: 'nome_banco'},
						{header: "Agencia", width: 50, align: 'left', sortable: true, dataIndex: 'nm_agencia'},
						{header: "Cuenta", width: 50, align: 'left', sortable: true, dataIndex: 'nm_conta'},
						{header: "Moeda", width: 50, align: 'right', sortable: true, dataIndex: 'nm_moeda'},
						{header: "Limite", width: 90, align: 'left', sortable: true, dataIndex: 'limite'}
			
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
			height: 170,
			ds: dsContas,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dsContas,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Nao tem dados",
				pageSize: 5,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina", 
				items:[],
				refreshText : "Atualizar",
				paramNames : {start: 0, acao:'ListaContas', limit: 5},
				items:['-',
					{
					xtype: 'label',
					text: 'Doble Click para mostrar extracto: ',
					style: 'font-weight:bold;color:yellow;text-align:left;' 
					}
					]
			}),
			tbar: [
			   {
				text: 'Cadastrar Cuenta',
				iconCls:'icon-add',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
						NovaConta.show();
						} 
				},
				'-',
				{
				text: 'Informar Deposito',
				iconCls:'icon-money',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
					selectedKeys = grid_Contas.selModel.selections.keys; 
					if(selectedKeys.length > 0){
						NovoDeposito.show();
					}
					else
						{
						selecione();
					}
				} 
				}
			],
			listeners:{ 
	    celldblclick: function(grid, rowIndex, columnIndex, e){
            record = grid.getStore().getAt(rowIndex); // Pega linha 
            index = columnIndex;
            idconta = record.id;
            dsExtratoConta.baseParams.idconta = idconta;
			dsExtratoConta.load();
                
         }
		
	}
		
});
dsContas.load(({params:{'id':1, 'acao':'ListaContas', 'start':0, 'limit':5}}));

//////////INICIO DA STORE ////////////////////
var dsExtratoConta = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: '../sistema/php/ContasBanco.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Extrato',
			totalProperty: 'Saldo',
			id: 'idconta_bancaria_lanc'
		},
			[
			{name: 'idconta_bancaria_lanc'},
			{name: 'idcontabancaria'},
			{name: 'dtlancamentoconta'},
			{name: 'valorlancamento'},
			{name: 'tipolancamento'},
			{name: 'historico', type: 'string'},
			{name: 'idcheque'},
			{name: 'idcheque_emit'},
			{name: 'numerocheque'}
			]
		),
		sortInfo: {field: 'idconta_bancaria_lanc', direction: 'ASC'},
		remoteSort: true,
		baseParams:{acao: 'Extrato'}		
	});

	ExtratoTemplate = 
	    [
         '<style>'
         ,'fieldset {'
         ,'width: 50%;'
         ,'margin: 5px 3px 5px 0px;'
         ,'padding: 5px;'
         ,'}'
		 ,'</fieldset>'
         ,'</style>'
         ,'<fieldset>'
         ,'<legend><font color=#EF8621 >Extracto de Cuenta</font></legend>',
         
		 '<table width="450" align=center><tr><td align=center> <strong> <font color="#4682B4"> Saldo en el mes </font> </strong> </td></tr></table><br/>',
		'<table width="650" >',
		'<tr>',
		'<td width=200 align="left"><strong> Fecha </strong> </td>',
		'<td width=200 align="left"> Historico </td>',
		'<td width=200 align="right"> Valor </p></td>',
		'</tr>',
		'<td width=200 align="left"> &nbsp - </td>',
		'<td width=200 align="left"> - Saldo Anterior </td>',
		'<td width=200 align="right"> <tpl for="anterior"> {SaldoAnterior} </tpl> </p></td>',
		'<tpl for="Extrato">',
		'<tr>',
		'<td width=200 align="left">{dtlancamentoconta}</td>',
		'<td width=200 align="left">{historico}</td>',
		'<tpl if="values.tipolancamento == \'1\' ">', 
				'<td width=200 align="right">{valorlancamento} </td>',
			'</tpl>',
		'<tpl if="values.tipolancamento == \'2\' ">', 
				'<td width=200 align="right"> <font color="red">-{valorlancamento} </td>',
			'</tpl>',
		'</tr>',
		'</tpl>',
		'</tr>',
		'<tr>',
		'<td>',
		'<td> &nbsp </td>',
		'<td> &nbsp </td>',
		'<td> &nbsp </td>',
		'</tr>',
		'<tr>',
		'<td width=200 align="left"> &nbsp - </td>',
		'<td width=200 align="left"> - Saldo Periodo </td>',
		'<td width=200 align="right"> <tpl for="dados"> {SaldoPeriodo} </tpl> </p></td>',
		'</tr>',
		'<tr>',
		'<td width=200 align="left"> &nbsp - </td>',
		'<td width=200 align="left"> - Saldo Atual </td>',
		'<td width=200 align="right"> <tpl for="anterior"> {atual} </tpl> </td>',
		'</tr>',
		'</table>',
        ,'</br>'
        ,'</fieldset>'
		]
	ExtratoTpl = new Ext.XTemplate(ExtratoTemplate);
	
	var formtplExtrato = new Ext.Panel({
        frame:false,
		id: 'panelDetail',
		autoHeight: true,
        border: true,
		tpl: ExtratoTpl
	       });
        
	dsExtratoConta.on('load', function(){
	if(idconta > 0){  
	
	//SaldoPeriodo = dsExtratoConta.reader.jsonData.SaldoPeriodo;
	ExtratoTpl.overwrite(formtplExtrato.body, dsExtratoConta.reader.jsonData);
	}
	else{
		Ext.MessageBox.alert('Alerta', 'Seleccione una Cuenta');
	}
    });


		FormDeposito = new Ext.FormPanel({
			frame		: true,
            split       : true,
            //autoWidth   : true,
			layout		: 'form',
			items:[
				{
				xtype: 'moneyfield',
				name: 'vlDeposito',
				fieldLabel: 'Valor',
				labelWidth: 18,
				decimalPrecision : 2,
				style:'{text-align:right;}',
				allowBlank: false			
				}			
			]
		});


		FormCadConta = new Ext.FormPanel({
			frame		: true,
            split       : true,
            autoWidth   : true,
			layout		: 'form',
			items:[
					{
                    xtype:'combo',
					hideTrigger: false,
					emptyText: 'Selecione',
					allowBlank: false,
					editable: true,
					fieldLabel: 'Banco',
					labelWidth: 50,
					width: 130,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['id_banco','nome_banco'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
					minChars: 2,
					name: 'idbanco',
					listWidth: 280,
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: '../sistema/pesquisa_banco.php?acao_nome=NomeBanco',
					root: 'resultados',
					fields: [ 'id_banco', 'nome_banco' ]
					}),
						hiddenName: 'id_banco',
						valueField: 'id_banco',
						displayField: 'nome_banco',
						fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('grupo').focus();
                            }},
					onSelect: function(record){
					var	idbanco = record.data.id_banco;
					var	nome_banco = record.data.nome_banco;
						this.collapse();
						this.setValue(nome_banco);
					}
	                },
				   {
                    xtype:'textfield',
                    fieldLabel: 'Agencia',
					labelWidth: 50,
					col: true,
                    name: 'nm_agencia',
                    width: 100
					},
					{
                    xtype:'textfield',
                    fieldLabel: 'Cuenta',
					labelWidth: 50,
					col: true,
                    name: 'nm_conta',
                    width: 100
					},
					{
					xtype:'combo',
					name: 'moeda',
					fieldLabel: 'Moeda',
					labelWidth: 50,
					hideTrigger: false,
					dataField: ['id','nm_moeda'],
					allowBlank: false,
					editable: false,
					mode: 'local',
					triggerAction: 'all',
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
					minChars: 2,
					emptyText: 'Selecione',
					forceSelection: true,
					store: [
								['1','Dolares'],
							    ['Guaranies','Guaranies']
								],
					hiddenName: 'moeda',
					valueField: 'id',
					displayField: 'nm_moeda'
					},
					{
					xtype: 'moneyfield',
					name: 'limite',
					fieldLabel: 'Limite',
					labelWidth: 48,
					col: true,
					decimalPrecision : 2,
					style:'{text-align:right;}',
					allowBlank: false			
					},
					{
					xtype: 'moneyfield',
					name: 'saldo',
					fieldLabel: 'Saldo Inicial',
					labelWidth: 100,
					col: true,
					decimalPrecision : 2,
					style:'{text-align:right;}',
					allowBlank: false			
					}
					
					]		
        }); 

				NovaConta = new Ext.Window({
	                  layout: 'form'
	                , width: 650
					, title: 'Catastrar Nueva Cuenta'
					//, height: 200
					, autoHeight	: true
	                , closeAction :'hide'
	                , plain: true
					, modal: true
					, items:[FormCadConta]
					,focus: function(){
 	    					//	Ext.get('nome_grupo').focus();
									}
					,buttons: [
								{
            					text: 'Gravar',
								iconCls:'icon-save',
            					handler: function(){ // fechar	
									FormCadConta.getForm().submit({
									url: "../sistema/php/ContasBanco.php"
									, params : {
									  acao: 'novaConta',
									  user: id_usuario
									}
									, waitMsg: 'Cadastrando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
									}); 
								function OnSuccess(form,action){
								dsContas.reload();
								Ext.MessageBox.alert("Confirma&ccedil;&atilde;o!",action.result.response);
								};
			
								function OnFailure(form,action){
								Ext.MessageBox.alert(action.result.msg);
								};
								
									}
        						},
								{
								text: 'Cerrar',
								handler: function(){ // fechar	
								NovaConta.hide();
								FormCadConta.getForm().reset();
								}
								}
							]
				});
				
				NovoDeposito = new Ext.Window({
	                  layout: 'form'
	                , width: 350
					, title: 'Informar Deposito'
					//, height: 200
					, autoHeight	: true
	                , closeAction :'hide'
	                , plain: true
					, modal: true
					, items:[FormDeposito]
					,focus: function(){
 	    					//	Ext.get('nome_grupo').focus();
									}
					,buttons: [
								{
            					text: 'Gravar',
								iconCls:'icon-save',
            					handler: function(){ // fechar	
									FormDeposito.getForm().submit({
									url: "../sistema/php/ContasBanco.php"
									, params : {
									  acao: 'novoDeposito',
									  user: id_usuario,
									  contaid: selectedKeys
									}
									, waitMsg: 'Cadastrando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
									}); 
								function OnSuccess(form,action){
								//dsContas.reload();
								Ext.MessageBox.alert("Confirma&ccedil;&atilde;o!",action.result.response);
								};
			
								function OnFailure(form,action){
								Ext.MessageBox.alert(action.result.msg);
								};
								
									
									}
        						},
								{
								text: 'Cerrar',
								handler: function(){ // fechar	
								NovoDeposito.hide();
								//FormCadConta.getForm().reset();
								}
								}
							]
				});


var FormContas= new Ext.FormPanel({
            title       : 'Cuentas Bancarias',
			labelAlign: 'top',
            closable	: true,
			frame		: true,
            split       : true,
            autoWidth   : true,
			autoScroll: true,
			inline:true,
			layout: 'form',
			closeAction: 'destroy',
			layout		: 'form',
			items:[grid_Contas,formtplExtrato],
			listeners: {
						destroy: function() {
						//	if(PrecoGrupo instanceof Ext.Window)
                       //     PrecoGrupo.destroy(); 
						//	if(NovoGrupo instanceof Ext.Window)
						//	NovoGrupo.destroy(); 
         				}
			         }
        }); 
		
	
Ext.getCmp('tabss').add(FormContas);
Ext.getCmp('tabss').setActiveTab(FormContas);
FormContas.doLayout();	
Ext.getCmp('panelDetail').update('');

}