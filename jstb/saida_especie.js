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

saida_especie = function(vlcompra,fatura,emissaofat){

vlcompra = vlcompra;
fatura = fatura;
emissaofat = emissaofat;

if(typeof devolvido != 'undefined'){
devolucao = devolvido;
}
else{
devolucao = 0.00;
}

if(typeof vlcompra != 'undefined' || vlcompra != 'NaN'){

vlcompra = vlcompra.replace(/\./g,"");
vlcompra = vlcompra.replace(",", ".");
//console.info(vlcompra);

vlcompraori = vlcompra
}
else{
vlcompra = 0;
//console.info(vlcompra);
}

 storeEntEspecie = new Ext.data.GroupingStore({
			    proxy: new Ext.data.HttpProxy({
                url: 'php/saida_especie.php',
				autoLoad: false,
                method: 'POST'
				}),
				groupField:'id',
				sortInfo:{field: 'id', direction: "DESC"},
				nocache: true,
 reader:  new Ext.data.JsonReader({
				totalProperty: 'totalPedido',
				url: 'php/saida_especie.php',
				method: 'POST',
				root: 'resultados',
				id: 'id',
				fields: [
						 
						 {name: 'id'},
						 {name: 'valor', type: 'float'},
						 {name: 'totals', type: 'float'},
						 {name: 'totalEspecies', type: 'float'}
						 ]
			})					    
		});
		
	// define a custom summary function
     Ext.grid.GroupSummary.Calculations['totalEspecies'] = function(v, record, field){
	//	precio = record.data.valorB;
	//	precio = precio.replace(".","");
		var v = v+ (parseFloat(record.data.valor));   //toNum
					
		subtotal =  v ;
		return v;
		
    }

var editor = new Ext.ux.grid.RowEditor();
var summary = new Ext.grid.GroupSummary(); 
var gridEntEspecie = new Ext.grid.GridPanel({
		plugins: [summary,editor],
		store: storeEntEspecie,
		height      : 500,
		tbar: [{
				text: 'Adicionar Pago',
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
				value: vlcompra,
				readOnly: true
				}
				
				],

	columns: [
		{
			header: 'id', dataIndex: 'id', name: 'id', 
			editor: {
			xtype: 'numberfield',
			value: idcompranova,
			allowBlank: true
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
		
			{
                header: "Total",
                width: 100,
				align: 'right',
                sortable: false,
				name: 'totals',
				fixed:true,
                groupable: false,
                renderer: function(v, params, record){
                val = Ext.util.Format.usMoney( (parseFloat(record.data.valor)) )
				 return val;
                },
				id:'totalEspecies',
                dataIndex: 'totalEspecies',
                summaryType:'totalEspecies',
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


var FormEntEspecie = new Ext.FormPanel({
			frame: true,
			closable: true,
			bodyStyle:'background-color:#CDB5CD',
			width       : '100%',
			items: [gridEntEspecie]
	});
  winEntEspecie = new Ext.Window({
				title: 'Entrada de Pago al Contado',
				width:340,
				height:250,
				//autoWidth: true,
				//autoHeight: true,
				plain: true,						
				collapsible: false,
				resizable: false,
				closeAction:'close',
				closable: false,
				modal: true,
				border: false,
				items: [FormEntEspecie],
				focus: function(){
				//	Ext.get('queryPedidoprod').focus(); 
				},
				buttons: [
				{
				text: 'Concluir',
				iconCls: 'icon-save',
				handler: function(){
					if(subtotal <= vlcompra){	
					
					// Extraindo os dados do Grid
					var jsonData = [];
					// Percorrendo o Store do Grid para resgatar os dados
					storeEntEspecie.each(function( record ){
						// Recebendo os dados
						jsonData.push( record.data );
					});
						jsonData = Ext.encode(jsonData);
							 Ext.Ajax.request({
								url: 'php/saida_especie.php',
								method: 'POST',
								remoteSort: true,
								params: {
								acao: 'CadContVista', 
								user: id_usuario,
								dados: jsonData,
								host: host,
								total_nota: vlcompraori,
								idforn: idforn,
								nmfatura: fatura,
								emissaofat: emissaofat,
								idCompra: idcompranova
								},
								callback: function (options, success, response) {
										if (success) { 
											//Ext.MessageBox.alert('OK', response.responseText);
											var jsonData = Ext.util.JSON.decode(response.responseText);
											if(jsonData.avista > 0){
											Ext.MessageBox.alert('OK', 'Pago Catastrado: '+ jsonData.avista, function(btn){
												if(btn == "ok"){
													tipopgto = "especie";
												//	dsCompras.reload();
												//	formCompras.getForm().items.each(function(itm){itm.setDisabled(true)});
													winEntEspecie.hide();
													dsCompraPgto.load(({params:{acao: 'ListaPgto', idcompranova: idcompranova,  'start':0, 'limit':5}}));

												} });
											
											}
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										}
						  });
					}
				
				else{
					Ext.MessageBox.alert('Erro','Verifique Total.');
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
								devolucao = 0.00;
								creditofinal = 0.00;
								winEntEspecie.close();
								//dsCompraPgto.load();
								dsCompraPgto.load(({params:{acao: 'ListaPgto', idcompranova: idcompranova,  'start':0, 'limit':5}}));
							}
							})	
					 }
        			}
				],
				 listeners:{
                // creditofinal = 0.00;
				  }
			})

winEntEspecie.show();


}