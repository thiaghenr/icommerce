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
                    this.currency = ' �';
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

LancDespesa = function(){


	Ext.form.Field.prototype.msgTarget = 'side';
	//Ext.form.FormPanel.prototype.bodyStyle = 'padding:5px';
	//Ext.form.FormPanel.prototype.labelAlign = 'right';
	Ext.QuickTips.init();
	Ext.ns('Ext.ux.tree');
	
	var treePlano = new Ext.tree.TreePanel({
    id:'treePlano'
    ,autoScroll:true
    ,rootVisible:false
    ,root:{
    nodeType:'async'
    ,id:'root'
    ,text:'Plano de Contas'
    ,expanded:true
    }
    ,loader: {
    url:'php/PlanoContas.php'
    ,baseParams:{
    cmd:'getChildren'
    ,treeTable:'tree2'
    ,treeID:1
	,acao: 'despesa'
    }
    },
	listeners: {
            click: function(n) {
                //Ext.Msg.alert('Navigation Tree Click', 'You clicked: "' + n.attributes.text + '"');
				if(n.attributes.leaf === true){
				formFornecedor.getForm().findField('nomedesp').setValue(n.attributes.cod);
				idnode = n.attributes.id;
				cod = n.attributes.cod;
				}
				else{
				formFornecedor.getForm().findField('nomedesp').setValue("");
				}
            }
        }
    ,plugins:[new Ext.ux.state.TreePanel()]
    }); // eo tree
	 
var SelectForn = function(){
   						Ext.Ajax.request({
           					url: 'php/LancContas.php',
							remoteSort: true,
           					params: {
							acao: 'fornCod',
							user: id_usuario,
			    			CodForn: formFornecedor.getForm().findField('idFornecedor').getValue()
            					},
								success: function(response){//se ocorrer correto 
								var jsonData = Ext.decode(response.responseText);
								 forn = Ext.decode( response.responseText);
								 idforn = forn;
								 if(forn){
								 nomeFornec = forn.nome;
								 Ext.getCmp('nomeforn').setValue(nomeFornec);
								 Ext.getCmp('nomedesp').focus();
								 
								 }
								 else{ 
								 Ext.getCmp('nomeforn').setValue();
								 Ext.MessageBox.alert('Aviso', 'Fornecedor nao encontrado'); }
								 
								}
								
							});
						}
	
		var dsDespesas = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/LancContas.php',
			method: 'POST'
		}),
		baseParams:{
			acao: 'ListarDesp'
			},
		reader:  new Ext.data.JsonReader({
			root: 'Despesas',
			id: 'id_lanc_despesa'
		},
			[
				   {name: 'id_lanc_despesa'},
				   {name: 'nome_despesa'},
		           {name: 'documento'},
		           {name: 'dt_lanc_desp'},
		           {name: 'venc_desp'},
		           {name: 'desc_desp'},
				   {name: 'valor'},
				   {name: 'nome_user'},
				   {name: 'nome'},
				   {name: 'valor_total'}
				
			]
		),
		sortInfo: {field: 'id_lanc_despesa', direction: 'DESC'},
		remoteSort: true,
		autoLoad: true
	});
	 var gridDespesas = new Ext.grid.GridPanel({
	        store: dsDespesas, 
	        columns:
		        [
						{id:'id_lanc_despesa',header: "id_lanc_despesa", hidden: true, width: 2, sortable: true, dataIndex: 'id_lanc_despesa'},
						{header:'Plano Conta', width: 200, sortable: true, dataIndex: 'nome_despesa'},
						{header: "Documento", width: 80, sortable: true, dataIndex: 'documento'},
						{header: "Dt Lancamento", width: 90, align: 'left', sortable: true, dataIndex: 'dt_lanc_desp'},
						{header: "Vencimento", width: 80, align: 'left', sortable: true, dataIndex: 'venc_desp'},
						{header: "Descricao", width: 150, align: 'left', sortable: true, dataIndex: 'desc_desp'},
						{header: "Valor", width: 90, align: 'right', sortable: true, dataIndex: 'valor', renderer: 'usMoney'},
						{header: "Usuario", width: 80, align: 'right', sortable: true, dataIndex: 'nome_user'},	        
						{header: "Fornecedor", width: 150, align: 'left', sortable: true, dataIndex: 'nome'},
						{header: "Total", width: 90, align: 'right', sortable: true, dataIndex: 'valor_total', renderer: 'usMoney'}
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				autoExpandColumn: true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
			id: 'gridDespesas',
			stripeRows : true,
			height: 150,
			ds: dsDespesas,
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			closable: true
	});

						
	var formFornecedor = new Ext.FormPanel({
        labelAlign: 'top',
		id: 'formFornecedor',
        frame: true,
        title: 'Lancar Cuenta',
		//width: 400,
		height: 310,
		tabWidth: '100%',
		closable: true,
		autoScroll: true,
		border : true,
		layout: 'form',
        items: [
				{
				xtype:'textfield',
				fieldLabel: 'Codigo',
				labelWidth: 70,
				allowBlank: false,
				width: 100,
				name: 'idFornecedor',
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER && formFornecedor.getForm().findField('idFornecedor').getValue() != '') {
							CodForn = formFornecedor.getForm().findField('idFornecedor').getValue();
							setTimeout(function(){
							//
							 }, 250);
							SelectForn();
				   //nav.form.findField('fin')setDisabled(false);
						}
						if(e.getKey() == e.ENTER && formFornecedor.getForm().findField('idFornecedor').getValue() === '') {
							Ext.Msg.alert('Alerta', 'Erro, Entre com o Codigo');
						}	
					}
				},
				{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				//dataField: ['idforn','nomeforn', 'endereco'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Entidade',
				id: 'nomeforn',
				minChars: 2,
				name: 'nomeforn',
				width: 200,
                resizable: true,
                listWidth: 350,
				col: true,
				forceSelection: true,
				store: new Ext.data.JsonStore({
				url: 'php/LancDespesa.php?acao_nome=fornNome',
				root: 'resultados',
				fields: [ 'idforn', 'nomeforn', 'endereco' ]
				}),
					hiddenName: 'idforn',
					valueField: 'idforn',
					displayField: 'nomeforn',
					fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
						  Ext.getCmp('documento').focus();
						}
					},
					onSelect: function(record){
						idforn = record.data.idforn;
						nomeforn = record.data.nomeforn;
						this.collapse();
						this.setValue(nomeforn);
						formFornecedor.getForm().findField('idFornecedor').setValue(idforn);
					}
							
                },
				{
				xtype:'textfield',
				fieldLabel: 'Cuenta',
				emptyText: 'Seleccione la cuenta',
				labelWidth: 100,
				allowBlank: false,
				readOnly: true,
				width: 250,
				col: true,
				name: 'nomedesp',
				id: 'nomedesp',
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('dtfatura').focus();
						}
				}
				},
				{
				xtype:'textfield',
				fieldLabel: 'Documento',
				labelWidth: 100,
				width: 100,
				//col: true,
				name: 'documento',
				id: 'documento',
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('dtfatura').focus();
						}
				}
				},
				{
				xtype:'datefield',
				fieldLabel: 'Data Fatura',
				labelWidth: 70,
				width: 100,
				allowBlank: false,
				name: 'dtfatura',
				id: 'dtfatura',
				col: true,
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('vltotal').focus();
						}
				}
				},
				{
							xtype:'moneyfield',
							fieldLabel: '<b>Valor Total</b>',
							name: 'vltotal',
							id: 'vltotal'
				},
				/*
				new Ext.ux.MaskedTextField({
				fieldLabel: 'Valor Total',
				mask:'decimal',
				textReverse : true,
				width: 100,
				allowBlank: false,
				name: 'vltotal',
				id: 'vltotal',
				fireKey: function(e,type){
						if(e.getKey() == e.ENTER) {
							Ext.getCmp('obsDesp').focus();
						}
				}
				}),
				
				{
				xtype: 'checkbox',
				fieldLabel: 'Al Contado',
				boxLabel: '- marcar para ir directo al caja',
				labelAlign: 'right',
				id: 'ckbVista',
				width: 200,
				checked: true,
				col: true,
				handler: function() {
     
						}
				},
				*/
				{
							xtype: 'radiogroup'
							,hideLabel: true
							,bodyStyle: 'padding-top: 10px;'
							,width: 400
							,col: true
							
							,items: [
								{
								boxLabel: 'Caja Usuario'
								, name: 'caixapagoconta'
								, inputValue: 'cxuser'
								, checked: true
								
								},
								{
								boxLabel: 'Caja General'
								, name: 'caixapagoconta'
								, inputValue: 'cxempr'
								//, handler: function(){
								
								//}
								},
								{
								boxLabel: 'Credito'
								, name: 'caixapagoconta'
								, inputValue: 'credito'
								,listeners: {
									check: function (ctl, val) {
										if(val == true){
											abrewinentradacred = function(){Ext.Load.file('jstb/saida_crediario_desp.js', function(obj, item, el, cache){saida_crediario(
											formFornecedor.getForm().findField('vltotal').getValue()
											);},this)}
											abrewinentradacred();
										}
									}
								}
								},
								{
								boxLabel: 'Cheque'
								, name: 'caixapagoconta'
								, inputValue: 'cheque'
								,listeners: {
									check: function (ctl, val) {
										if(val == true){
											abrewinentradacheque = function(){Ext.Load.file('jstb/saida_cheque_inf.js', function(obj, item, el, cache){saida_cheque(
											formFornecedor.getForm().findField('vltotal').getValue()
											);},this)}
											abrewinentradacheque();
										}
									}
								}
								}								
							]
		
							
					//		, handler: function(){
					//			console.info('oi');
					//			}
							},
				{
				xtype:'textfield',
				fieldLabel: 'Observacion',
				labelWidth: 70,
				width: 350,
				name: 'obsDesp',
				id: 'obsDesp'
			//	col: true
				},
				
				{
				xtype:'button',
				text: 'Enviar',
				id: 'btnGravar',
				iconCls: 'icon-save',
				scale: 'large',
				col: true,
				handler:function(){
					if(typeof jsonCheques == 'undefined')
						jsonCheques = '1';
					if(typeof jsonCred == 'undefined')
						jsonCred = '1';
					formFornecedor.getForm().submit({
										url: "php/LancContas.php",
										params: {
												user: id_usuario,
												acao: 'Cadastra',
												index: index,
												idnode: idnode,
												jsonCheques: jsonCheques,
												jsonCred: jsonCred
										}
										, waitMsg: 'Cadastrando'
										, waitTitle : 'Aguarde....'
										, scope: this
										, success: OnSuccess
										, failure: OnFailure
									}); 
								function OnSuccess(form,action){
										Ext.Msg.alert('Confirmacao', action.result.msg);
									
									//	formFornecedor.getForm().reset();
									//	jsonCheques = [];
									}
								function OnFailure(form,action){
									//	alert(action.result.msg);
									}

								}
				},
				{
					style: 'margin-top:10px',
					float:'left'
					 }
			   ]
	});

 var index = 0;
    while(index < 0){
        addText();
    }
    function addText(){
        formFornecedor.add(
{
layout:'column',
labelAlign: 'top',
items:[
	   {
	   columnWidth:.2,
       layout: 'form',
	   labelAlign: 'top',
       items: [
				{
				xtype: 'datefield',
				autoDestroy: true,
            	fieldLabel: 'Parcela ' + (++index),
				id : 'data' + (index),
				width: 100,
				labelAlign: 'left'
				}
			]
	  },
	 {
	 columnWidth:.2,
	 layout: 'form',
	 labelAlign: 'top',
	 items: [
			new Ext.ux.MaskedTextField({
            fieldLabel: 'Valor ',
			id : 'vlparc' + (index),
			width: 100,
			mask:'decimal',
			textReverse : true,
			labelAlign: 'left'
	   		})
			]
	}
			]
			}
	   		
			
			);				
    }	
	

		var formpanel = new Ext.Panel({
		title: 'Plano de Contas'
		,id:'formpanel'
		,closable: true
		,layout:'border'
		,width:600
		,height:400
		,items:[{
				region:'center'
				,layout:'border'
				,frame:true
				,border:false
				,items:[{
				region:'center'
				,layout:'fit'
				,height: 200
				,frame:true
				,border:false
				,items:[formFornecedor]
				},{
				region:'south'
				,title: 'Ultimos Lanzamientos'
				,id: 'plan'
				,collapsible: true
				,collapsed: true
				,layout:'form'
				,border:false
				,height: 200
				,frame:true
				,items:[gridDespesas]
				}]
				},{
				region:'west'
				,layout:'fit'
				,frame:true
				,border:false
				,width:320
				,split:true
				,title: 'Cuentas'
				,collapsible:true
				,collapseMode:'mini'
				,items:[treePlano]
			}]
		});
		
	
	
	
Ext.getCmp('tabss').add(formpanel);
Ext.getCmp('tabss').setActiveTab(formpanel);
formpanel.doLayout();	
formFornecedor.getForm().findField('idFornecedor').focus();
/*
Ext.getCmp('sul').add(gridDespesas);
Ext.getCmp('sul').setActiveTab(gridDespesas);
gridDespesas.doLayout();	
*/
}