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


AtCambio = function(){

var moedaId;

var action = new Ext.ux.grid.RowActions({
    header:''
 //  ,anchor: '10%'
  ,width: 15
  ,autoWidth: false
   ,actions:[{
       iconCls:'icon-edit'
      ,tooltip:'Actualizar Cotizacion'
	//  ,width: 1
   }] 
});

action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	  moedaid = record.data.moeda_id;
	  AtCot.show();
	  FormAtMoeda.getForm().findField('atcompra').focus();
   }
});


//////////INICIO DA STORE ////////////////////
var dsCambios = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/AtualizaCambio.php',
			method: 'POST'
			
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'resultados',
			totalProperty: 'totalBancos',
			id: 'idc'
		},
			[
			{name: 'idc'},
			{name: 'moeda_id'},
			{name: 'nm_moeda'},
			{name: 'codigo_banco'},
			{name: 'vl_cambio'},
			{name: 'vl_cambio_compra'}
			]
		),
		sortInfo: {field: 'idc', direction: 'DESC'},
		remoteSort: true,
		baseParams : {
				acao:'ListaMoedas'
			}
	});
//////// FIM STORE //////////////
//////// INICIO DA GRID  ////////
 var grid_Cambios = new Ext.grid.EditorGridPanel(
	    {
	        store: dsCambios, // use the datasource
	        
	        columns:
		        [
						{id:'idc',header: "Num.", align: 'right', width: 20, sortable: true, dataIndex: 'idc'},
						{header: "", width: 130, hidden: true, align: 'left', sortable: true, dataIndex: 'moeda_id'},
						{header: "Moneda", width: 130, align: 'left', sortable: true, dataIndex: 'nm_moeda'},
						{header: "Compra", width:100, align: 'right', sortable: true, dataIndex: 'vl_cambio_compra'},
						{header: "Venta", width:100, align: 'right', sortable: true, dataIndex: 'vl_cambio'},
						{header: "", width:60, align: 'right', sortable: true, dataIndex: ''},
						action
			
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
			plugins: [action],
			height: 183,
			ds: dsCambios,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			/*
			bbar: new Ext.PagingToolbar({
				store: dsCambios,
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
			//	paramNames : {start: 0, acao:'ListaMoedas', limit: 5},
				items:[]
			}),
			*/
			tbar: [
			   {
				text: 'Cadastrar Moneda',
				iconCls:'icon-add',
				tooltip: 'Clique para lancar um novo registro',
				handler: function(){
						NovaMoeda.show();
						} 
				}
			],
			listeners:{ 
        	afteredit:function(e){
			dsCambios.load(({params:{valor: e.value, acao: 'alterar', idGrupo: e.record.get('id'), campo: e.column,  'start':0, 'limit':5}}));
	  		}
			}
		
});
dsCambios.load(({params:{'id':1, 'acao':'ListaMoedas', 'start':0, 'limit':5}}));

		FormAtMoeda = new Ext.FormPanel({
			frame		: true,
            split       : true,
            autoWidth   : true,
			layout		: 'form',
			items:[
					 {
                    xtype:'moneyfield',
                    fieldLabel: 'Compra',
					decimalPrecision : 2,
					style:'{text-align:right;}',
					labelWidth: 50,
					emptText: 'Valor que se Compra la Moneda del Cliente',
                    name: 'atcompra',
                    width: 100
					},
					 {
                    xtype:'moneyfield',
                    fieldLabel: 'Venta',
					decimalPrecision : 2,
					style:'{text-align:right;}',
					labelWidth: 50,
                    name: 'atvenda',
                    width: 100
					}
			
			]
			});
			AtCot = new Ext.Window({
	                  layout: 'form'
	                , width: 400
					, title: 'Actualizar Cotizacion'
					//, height: 200
					, autoHeight	: true
	                , closeAction :'hide'
	                , plain: true
					, modal: true
					, items:[FormAtMoeda]
					,focus: function(){
 	    					//	Ext.get('nome_grupo').focus();
									}
					,buttons: [
								{
            					text: 'Gravar',
								iconCls:'icon-save',
            					handler: function(){ // fechar	
									FormAtMoeda.getForm().submit({
									url: "php/AtualizaCambio.php"
									, params : {
									  acao: 'AtCot',
									  user: id_usuario,
									  moedaid: moedaid
									}
									, waitMsg: 'Cadastrando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
									}); 
								function OnSuccess(form,action){
								dsCambios.reload();
								Ext.MessageBox.alert("Confirmacion!",action.result.response);
								};
			
								function OnFailure(form,action){
								Ext.MessageBox.alert(action.result.msg);
								};
								
									}
        						},
								{
								text: 'Cerrar',
								handler: function(){ // fechar	
								AtCot.hide();
								FormAtMoeda.getForm().reset();
								}
								}
							]
				});

		FormCadMoeda = new Ext.FormPanel({
			frame		: true,
            split       : true,
            autoWidth   : true,
			layout		: 'form',
			items:[
					 {
                    xtype:'textfield',
                    fieldLabel: 'Moneda',
					labelWidth: 50,
                    name: 'nome_moeda',
                    width: 180
					},
				   {
                    xtype:'moneyfield',
                    fieldLabel: 'Compra',
					decimalPrecision : 2,
					style:'{text-align:right;}',
					labelWidth: 50,
					emptText: 'Valor que se Compra la Moneda del Cliente',
                    name: 'compra',
                    width: 100
					},
					 {
                    xtype:'moneyfield',
                    fieldLabel: 'Venta',
					decimalPrecision : 2,
					style:'{text-align:right;}',
					labelWidth: 50,
                    name: 'venda',
                    width: 100
					}
					]		
        }); 

				NovaMoeda = new Ext.Window({
	                  layout: 'form'
	                , width: 400
					, title: 'Catastrar Nueva Moneda'
					//, height: 200
					, autoHeight	: true
	                , closeAction :'hide'
	                , plain: true
					, modal: true
					, items:[FormCadMoeda]
					,focus: function(){
 	    					//	Ext.get('nome_grupo').focus();
									}
					,buttons: [
								{
            					text: 'Gravar',
								iconCls:'icon-save',
            					handler: function(){ // fechar	
									FormCadMoeda.getForm().submit({
									url: "php/AtualizaCambio.php"
									, params : {
									  acao: 'NovaMoeda',
									  user: id_usuario
									}
									, waitMsg: 'Cadastrando'
									, waitTitle : 'Aguarde....'
									, scope: this
									, success: OnSuccess
									, failure: OnFailure
									}); 
								function OnSuccess(form,action){
								dsCambios.reload();
								Ext.MessageBox.alert("Confirmacion!",action.result.response);
								};
			
								function OnFailure(form,action){
								Ext.MessageBox.alert(action.result.msg);
								};
								
									}
        						},
								{
								text: 'Cerrar',
								handler: function(){ // fechar	
								NovaMoeda.hide();
								FormCadMoeda.getForm().reset();
								}
								}
							]
				});
	//////////INICIO DA STORE ////////////////////
var dsCotacoes = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/AtualizaCambio.php',
			method: 'POST'
			
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'resultados',
			totalProperty: 'totalCotacoes',
			id: 'id'
		},
			[
			{name: 'id'},
			{name: 'vl_cambio'},
			{name: 'vl_cambio_compra'},
			{name: 'data'},
			{name: 'hora'},
			{name: 'moeda_id'},
			{name: 'nome_user'}
			]
		),
		sortInfo: {field: 'id', direction: 'DESC'},
		remoteSort: true,
		baseParams : {
				acao:'ListaCotacoes',
				moeda: moedaId
			}
	});
//////// FIM STORE //////////////
//////// INICIO DA GRID  ////////
 var grid_Cotacoes = new Ext.grid.EditorGridPanel({
	        store: dsCotacoes, // use the datasource
	        columns:
		        [
						{id:'id',header: "Num.", align: 'right', width: 30, sortable: true, dataIndex: 'id'},	        
						{header: "Fecha", width: 130, align: 'right', sortable: true, dataIndex: 'data'},
						{header: "Hora", width: 130, align: 'left', sortable: true, dataIndex: 'hora'},
						{header: "Compra", width:100, align: 'right', sortable: true, dataIndex: 'vl_cambio_compra'},
						{header: "Venta", width:100, align: 'right', sortable: true, dataIndex: 'vl_cambio'},
						{header: "Usuario", width:100, align: 'right', sortable: true, dataIndex: 'nome_user'},
						{header: "", width:100, align: 'right', sortable: true, dataIndex: ''}
			
			 ],
	        viewConfig: 
	        {
	            forceFit:true,
				emptyText: 'Nenhum regsitro encontrado' 
	        },
			autoWidth: true,
			autoHeight: true,
			title: 'Historico de Cotizaciones',
			//height: 183,
			ds: dsCotacoes,
			selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dsCotacoes,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Nao tem dados",
				pageSize: 31,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina", 
				refreshText : "Atualizar",
			//	paramNames : {start: 0, acao:'ListaMoedas', limit: 31},
				items:[]
			})
	});
	
	grid_Cambios.on('rowclick', function(grid, row, e) {
	
			record = grid_Cambios.getSelectionModel().getSelected();
			var idmoeda = grid_Cambios.getColumnModel().getDataIndex(1); // Get field name
			moedaId = record.get(idmoeda);
		
	dsCotacoes.load(({params:{'acao':'ListaCotacoes', 'moeda': moedaId, start: 0, limit: 31}}));		
	}); 

var FormCambios = new Ext.FormPanel({
            title       : 'Monedas',
			labelAlign  : 'top',
            closable	: true,
			frame		: true,
            split       : true,
            autoWidth   : true,
			closeAction: 'destroy',
			layout		: 'form',
			items:[grid_Cambios,grid_Cotacoes],
			listeners: {
						destroy: function() {
						//	if(PrecoGrupo instanceof Ext.Window)
                       //     PrecoGrupo.destroy(); 
						//	if(NovoGrupo instanceof Ext.Window)
						//	NovoGrupo.destroy(); 
         				}
			         }
        }); 
		
		
		
Ext.getCmp('tabss').add(FormCambios);
Ext.getCmp('tabss').setActiveTab(FormCambios);
FormCambios.doLayout();	
			

}