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

CadastroCli = function(){
	
if(perm.cadastro_clientes.acessar == 0){
return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
}


Ext.QuickTips.init();

Ext.form.Field.prototype.msgTarget = 'side';
Ext.form.FormPanel.prototype.bodyStyle = 'padding:5px';
Ext.form.FormPanel.prototype.labelAlign = 'right';


    var FormCadastraCli = new Ext.FormPanel({
        labelAlign: 'left',
        frame:true,
        title: 'Cadastro de Entidades',
        bodyStyle:'padding:5px 5px 0',
        autoWidth: true,
		split: true,
		closable: true,
		layout: 'form',
		autoScroll:true,
        items: [{
            layout:'column',
            items:[{
                columnWidth:.5,
                layout: 'form',
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Nombre',
                    name: 'nomeCad',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   //document.getElementById('razaoCad').focus();
                            }}

                }, 
					{
                    xtype:'textfield',
                    fieldLabel: 'Ruc',
                    name: 'rucCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   //document.getElementById('cedulaCad').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Direccion',
                    name: 'enderecoCad',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   //document.getElementById('emailCad').focus();
                            }}
                },
				{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				dataField: ['idcidade','nomecidade'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Cidade',
				minChars: 2,
				name: 'idCidadesCli',
                resizable: true,
				anchor:'65%',
                listWidth: 300,
				store: new Ext.data.JsonStore({
				url: 'php/pesquisa_cidade.php',
				root: 'resultados',
				fields: [ 'idcidade', 'nomecidade' ]
				}),
					hiddenName: 'idcidade',
					valueField: 'idcidade',
					displayField: 'nomecidade',
					fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
						  document.getElementById('cgc').focus();
						}
					}
							
                },	
                   {
                    xtype:'numberfield',
                    fieldLabel: 'Telefono',
                    name: 'telefonecomCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('faxCad').focus();
                            }}
                },
					
                   {
                    xtype:'numberfield',
                    fieldLabel: 'Celular',
                    name: 'celularCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('datnasc').focus();
                            }}
                },
				{
                    xtype:'datefield',
                    fieldLabel: 'Fecha Nasc.',
                    name: 'datnasc',
                    width:130,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('cedulaCad').focus();
                            }}
                }
					
					
					
					]
            },
				{
                columnWidth:.5,
                layout: 'form',
                items: [
					{
                    xtype:'numberfield',
                    fieldLabel: 'Cedula',
                    name: 'cedulaCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   //document.getElementById('enderecoCad').focus();
                            }}
                },
					{
                    xtype:'textfield',
                    fieldLabel: 'Email',
                    name: 'emailCad',
                    vtype:'email',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  // document.getElementById('telefonecomCad').focus();
                            }}
                },
					
                    {
                    xtype:'numberfield',
			//		mask:'phone',
                    fieldLabel: 'Fax',
					id: 'faxCad',
                    name: 'faxCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('celularCad').focus();
                            }}
                },
                    {
                    xtype:'moneyfield',
					textReverse : true,
                    fieldLabel: 'Limite',
					id: 'limiteCad',
                    name: 'limiteCad',
                    anchor:'65%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('contato1Cad').focus();
                            }}
                }
				
				
				]
            }]
        },
			{
            xtype:'htmleditor',
            id:'obscliCad',
			name: 'obscliCad',
            fieldLabel:'Observacion',
            height:120,
            anchor:'82%'
        },
		{
			xtype: 'button',
			id: 'cadastrar',
            text: 'Cadastrar',
			width: 20,
			handler: function(){
			FormCadastraCli.getForm().submit({
				url: "php/cadastra_cliente.php"
				, waitMsg: 'Cadastrando'
				, waitTitle : 'Aguarde....'
				, scope: this
				, success: OnSuccess
				, failure: OnFailure
			}); 
			function OnSuccess(form,action){
				alert(action.result.msg);
			}
			
			function OnFailure(form,action){
				alert(action.result.msg);
			}
			}
        },
		{	xtype: 'button',
            text: 'Limpiar',
			col:true,
			handler: function(){ // Fun??o executada quando o Button ? clicado
			FormCadastraCli.getForm().reset();
			Ext.get('nomeCad').focus();
  			 }

        }]
    });



Ext.getCmp('tabss').add(FormCadastraCli);
Ext.getCmp('tabss').setActiveTab(FormCadastraCli);
FormCadastraCli.doLayout();	
//Ext.get('nomeCad').focus();
		//	console.log(id_usuario);

}