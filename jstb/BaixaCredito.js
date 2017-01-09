// JavaScript Document
// JavaScript Document
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

BaixaCred = function(){



var xgPedidoNT = Ext.grid;
var winDevCred;

var action = new Ext.ux.grid.RowActions({
    header:'Credito'
 //  ,anchor: '10%'
  ,width: 50
  ,autoWidth: false
   ,actions:[{
       iconCls:'icon-delete'
      ,tooltip:'Usar Credito'
	//  ,width: 1
   }] 
});

action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	  vlcredito = record.data.vlcredito;
	  devolvido = record.data.devolvido;
	  creditofinal = vlcredito - devolvido;
	  creditofinal = creditofinal.toFixed(2);
	  idcredito = record.data.idnota_credito;
	  ncredito = idcredito;
//	  console.info(ncredito);
	  
	  winDevCred.show();
	 // FormBaixa.getForm().findField('valordev').setValue(creditofinal);
	  FormBaixa.getForm().findField('valordev').focus();
	 
   }
});


dsNTCredito = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: '../php/NotasCredito.php',
        method: 'POST'
    }),   

reader:  new Ext.data.JsonReader({
			root: 'results',
			id: 'idnota_credito',
			remoteSort: true,
			fields: [
					 {name: 'idnota_credito',  type: 'string' },
					 {name: 'idcliente',  type: 'string' },
					 {name: 'idpedido',  type: 'string' },
                     {name: 'nome',  type: 'string' },
                     {name: 'dtlcto',  type: 'string' },
					 {name: 'vlcredito',  type: 'string'},
					 {name: 'devolvido',  type: 'string' },
					 {name: 'saldo', type: 'float'}
					 //{name: 'action1', type: 'string'},
   			         //{name: 'action2', type: 'string'}

					 ]
			})
		})
///////////// FIM STORE ////////////////////////
///////////// INICIO DA GRID //////////////////

	     var gridNTCredito = new Ext.grid.GridPanel({
	        store: dsNTCredito, // use the datasource
	       cm: new xgPedidoNT.ColumnModel([
		       
		        	//expander,
		            {id:'idnota_credito', width:40, header: "Nota Cred",  sortable: true, dataIndex: 'idnota_credito'},
					{ width:50, header: "Pedido",  sortable: true, dataIndex: 'idpedido'},
					{ width:50, header: "Cliente",  sortable: true, dataIndex: 'idcliente'},
					{ width:130, header: "Nombre",  sortable: true, dataIndex: 'nome'},
					{ width:80, header: "Data", align: 'right', sortable: true, dataIndex: 'dtlcto'},
					{ width:85, header: "Valor", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'vlcredito'},
					{ width:85, header: "Devolvido", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'devolvido'},
					{header: "Credito", width: 100, align: 'right', sortable: true, dataIndex: 'totalcol', 
						renderer: function Cal(value, metaData, rec, rowIndex, colIndex, store) {
						return  Ext.util.Format.usMoney(rec.data.vlcredito - rec.data.devolvido);
						}
						},
					action

					
		        ]), 
	        viewConfig:{ 
			forceFit:true
			},
			plugins : action,
           // id: 'gridFatPedido',
			animCollapse: false,
			enableColLock: false,
			loadMask:true,
			closable: true,
			autoWidth:true,
			height: 300,
	        stripeRows:true
	});
	
	Baixar = function(){
		Ext.Ajax.request({ 
						waitMsg: 'Executando...',
						url: 'php/BaixaCredito.php',
						params: { 
							acao: 'Devolver',
							ncredito: ncredito,
							recibo: FormBaixa.getForm().findField('recibo').getValue(),
							valor: FormBaixa.getForm().findField('valordev').getValue(),
							user: id_usuario
						},
						success: function(result, request){//se ocorrer correto 
						var jsonData = Ext.util.JSON.decode(result.responseText);
						if(jsonData.response){
							Ext.MessageBox.alert('Aviso',jsonData.response); //aki uma funcao se necessario);
							dsNTCredito.reload();
						};
						
						}, 
						failure:function(response,options){
							Ext.MessageBox.alert('Alerta', 'Erro...');
						}         
					}); 
	}
	
	
	var	FormBaixa = new Ext.FormPanel({
			layout      : 'form',
			closable: true,
			labelAlign: 'top',
	        frame:true,
			border: true,
	        bodyStyle:'padding:5px 5px 0',
			items: [
				{
				xtype: 'textfield',
	            fieldLabel: 'Recibo',
	            name: 'recibo',
				emptyText: 'Numero del recibo',
				width: 200
				},
				{
				xtype: 'moneyfield',
	            fieldLabel: 'Valor Devolver',
	            name: 'valordev',
				emptyText: 'Informe el valor',
				width: 200,
				fireKey : function(e){//evento de tecla   
                    if(e.getKey() == e.ENTER) {//precionar enter 
						Baixar();
					}	
				}  
				},
				{
				xtype: 'button',
           		text: 'Grabar',
				name: 'devolverok',
				align: 'left',
				iconCls: 'icon-save',
            	handler: function(){ // fechar	
					Baixar();
  			 	}
				}
				]
			});
	
	
if (winDevCred == null){
				winDevCred = new Ext.Window({
					title: 'Informe el valor a devolver' 
	                , layout: 'form'
	                , width: 400
	                , closeAction :'hide'
	                , plain: true
					, resizable: false
					, modal: true
					, items:[FormBaixa]
					,buttons: [
								{
            					text: 'Cerrar',
            					handler: function(){ // fechar	
     	    					winDevCred.hide();
								FormBaixa.getForm().reset();
								}
  			 					}
							]					

				});
			}


var	FormBaixaCred = new Ext.FormPanel({
			layout      : 'form',
			closable: true,
			title:'Bajar Credito',
	        frame:true,
			border: true,
	        bodyStyle:'padding:5px 5px 0',
			items: [gridNTCredito]
			});

dsNTCredito.load(({params:{'acao': 'listarNotas'}}));


Ext.getCmp('tabss').add(FormBaixaCred);
Ext.getCmp('tabss').setActiveTab(FormBaixaCred);
FormBaixaCred.doLayout();
			
}
