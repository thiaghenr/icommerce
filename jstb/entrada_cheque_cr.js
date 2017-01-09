// JavaScript Document
// Create user extensions namespace (Ext.ux)
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

ent_cheque = function(entrada,idPagare){

//var total_nota;
entrada = entrada;
entradaori = entrada;
idPagare = idPagare;

 storeEntChequeCR = new Ext.data.GroupingStore({
			    proxy: new Ext.data.HttpProxy({
                url: '../json.php',
				autoLoad: false,
                method: 'POST'
				}),
				groupField:'id_banco',
				sortInfo:{field: 'id_banco', direction: "DESC"},
				nocache: true,
 reader:  new Ext.data.JsonReader({
				totalProperty: 'totalPedido',
				root: 'resultados',
				id: 'id_banco',
				fields: [
						 
						 {name: 'id_banco'},
						 {name: 'nome_banco'},
						 {name: 'agencia' },
						 {name: 'conta' },
						 {name: 'num_cheque'},
						 {name: 'valor', type: 'float'},
						 {name: 'data_validade'},
						 {name: 'emissor'},
						 {name: 'moeda'},
						 {name: 'moeda_id'},
						 {name: 'subTotalCheque', type: 'float'},
						 {name: 'totalCheques', type: 'float'}
						 ]
			})					    
		});
		
	// define a custom summary function
     Ext.grid.GroupSummary.Calculations['totalCheques'] = function(vc, record, field){
	//	precio = record.data.valorB;
	//	precio = precio.replace(".","");
		vc = vc+ parseFloat(record.data.valor);   //toNum
		subtotal =  vc;
		return vc;
				
    }

var editor = new Ext.ux.grid.RowEditor();
var summary = new Ext.grid.GroupSummary(); 
var gridEntCheque = new Ext.grid.GridPanel({
		plugins: [summary,editor],
		store: storeEntChequeCR,
		height      : 500,
		tbar: [{
				text: 'Adicionar Cheques',
				iconCls: 'icon-add',
				handler: function(){
				editor.newRecord();
				}
				},
				'-',
				{
				xtype:'label',
				text: 'Total Devido:',
				style: 'font-weight:bold;color:yellow;text-align:left;' 
				},
				{
				xtype:'textfield',
				fieldLabel: 'Total Devido',
				labelWidth: 60,
				width: 100,
				id: 'totaldevido',
				name: 'totaldevido',
				value: entrada,
				readOnly: true
				}
				
				],

	columns: [
		{
			header: 'id_banco', dataIndex: 'id_banco', name: 'id_banco', 
			editor: {
			xtype: 'numberfield',
			value: idpedidoFat,
			allowBlank: true
			}
		},
		{ header: '<b>Banco</b>', dataIndex: 'ref', width: 200,
			editor: {
                    xtype:'combo',
					hideTrigger: false,
					emptyText: 'Selecione',
					allowBlank: true,
					editable: true,
				//	mode: 'remote',
					triggerAction: 'all',
					dataField: ['id_banco','nome_banco'],
					loadingText: 'Consultando Banco de Dados',
					selectOnFocus: true,
					//id: 'comp',
					minChars: 2,
					name: 'id_banco',
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
					var	id_banco = record.data.id_banco;
					var	nome_banco = record.data.nome_banco;
						this.collapse();
						this.setValue(nome_banco);
					}
	                }
		},
		{ header: '<b>Agencia</b>', dataIndex: 'agencia', width: 180, name: 'agencia',
			editor: {
			xtype: 'textfield',
			allowBlank: true
			}
		},
		{ header: '<b>Cuenta</b>', dataIndex: 'conta', width: 200, name: 'conta',
			editor: {
			xtype: 'textfield',
			allowBlank: false
			}
		},
		{ header: '<b>Num Cheque</b>', dataIndex: 'num_cheque', width: 200, name: 'num_cheque',
			editor: {
			xtype: 'textfield',
			allowBlank: false
			}
		},
		{ header: '<b>Moneda</b>', dataIndex: 'moeda', name: 'moeda',width: 210,
			editor: {
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: false,
				mode: 'remote',
				triggerAction: 'all',
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				//id: 'sitID',
				minChars: 2,
                emptyText: 'Moneda',
				forceSelection: true,
				store: new Ext.data.JsonStore({
							url: 'pesquisa_moeda.php',
							root: 'resultados',
							type: 'POST',
							totalProperty: 'total',
							baseParams: {
							acao: 'ListaMoedasCheque',
							padrao: 'N'
							},
							fields:[
							{name: 'vl_cambio'},
							{name: 'nm_moeda'},
							{name: 'moeda_id'}
							]
						}),
 
						hiddenName: 'moeda_id',
						valueField: 'nm_moeda',
						displayField: 'nm_moeda',
						fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('grupo').focus();
                            }},
				onSelect: function(record){
						vl_cambio = record.data.vl_cambio;
						nm_moeda = record.data.nm_moeda;
						moeda_id = record.data.moeda_id;
						this.collapse();
						this.setValue(moeda_id);
						if(nm_moeda != "DOLAR"){
						Ext.getCmp('totaldevido').setValue(Ext.util.Format.usMoney(vl_cambio*entrada));
						entrada = entrada * vl_cambio;
						}
						else{
						Ext.getCmp('totaldevido').setValue(Ext.util.Format.usMoney(entradaori));
						entrada = entradaori;
						}
						
					}
                }
				},
		{ header: '<b>Valor</b>', dataIndex: 'valor', align: 'right', width: 200, name: 'valor', 
			editor: {
			xtype: 'moneyfield',
			decimalPrecision : 2,
			style:'{text-align:right;}',
			allowBlank: false			
			}
		}, 
		{ header: '<b>Vencimiento</b>', dataIndex: 'data_validade', width: 215, name: 'data_validade',
			editor: {
			xtype: 'datefield',
			allowBlank: false			
			}
		},
		{ header: '<b>Emissor</b>', dataIndex: 'emissor', width: 280, name: 'emissor',
			editor: {
			xtype: 'textfield',
			allowBlank: true,
			emptyText: 'Mismo'
			}
		},
		
			{
                header: "Total",
                width: 100,
				align: 'right',
                sortable: false,
				name: 'subTotalCheque',
				fixed:true,
                groupable: false,
                renderer: function(v, params, record){
                val = Ext.util.Format.usMoney( (parseFloat(record.data.valor)) )
				 return val;
                },
				id:'totalCheques',
                dataIndex: 'totalCheques',
                summaryType:'totalCheques',
				fixed:true,
                summaryRenderer: Ext.util.Format.usMoney
            }
	],
	view: new Ext.grid.GroupingView({
            forceFit:true,
            showGroupName: false,
            enableNoGroups:false, // REQUIRED!
            hideGroupedColumn: true
        }),
	listeners:{
	 
	
	}
	
	
})


var FormEntCheque = new Ext.FormPanel({
			frame: true,
			id: 'FormReq',
			closable: true,
			bodyStyle:'background-color:#CDB5CD',
			width       : '100%',
			items: [gridEntCheque]
	});
  winEntCheque = new Ext.Window({
				title: 'Entrada de cheques',
				width:800,
				height:320,
				//autoWidth: true,
				//autoHeight: true,
				plain: true,						
				collapsible: false,
				resizable: false,
				closeAction:'close',
				closable: false,
				modal: true,
				border: false,
				items: [FormEntCheque],
				focus: function(){
				//	Ext.get('queryPedidoprod').focus(); 
				},
				buttons: [
					{
					text: 'Concluir',
					iconCls: 'icon-save',
					handler: function(){
						
						if(subtotal == entrada){	
					
						// Extraindo os dados do Grid
						var jsonData = [];
						// Percorrendo o Store do Grid para resgatar os dados
						storeEntChequeCR.each(function( record ){
							// Recebendo os dados
							jsonData.push( record.data );
						});
							jsonCheq = Ext.encode(jsonData);
							winEntCheque.close();		
							
						}		
						}
					},
					'-',
					{
					text: 'Cerrar',
					handler: function(){ 
						Ext.MessageBox.confirm('Alerta', 'Deseja Cerrar Sin Facturar ?', function(btn) {
							if(btn == "yes"){
								creditofinal = 0.00;
								entrada = 0.00;
								creditofinal = 0.00;
							//	Ext.getCmp('labelnota').setText('');
							//	 Ext.getCmp('labelvalor').setText('');
							//	 Ext.getCmp('totalfaturar').setText('');
								winEntCheque.close();
								formRecValor.getForm().findField('caixapagoconta').reset();
							}
							})	
					 }
        			}
				],
				 listeners:{
                // creditofinal = 0.00;
				  }
			})



winEntCheque.show();


}