// JavaScript Document

Ext.onReady(function(){   
  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  Ext.QuickTips.init();

Ext.override(Ext.form.RadioGroup, {
  getName: function() {
    return this.items.first().getName();
  },

  getValue: function() {
    var v;

    this.items.each(function(item) {
      v = item.getRawValue();
      return !item.getValue();
    });

    return v;
  },

  setValue: function(v) {
    this.items.each(function(item) {
      item.setValue(item.getRawValue() == v);
    });
  }
});

Ext.override(Ext.grid.EditorGridPanel, {
	initComponent: Ext.grid.EditorGridPanel.prototype.initComponent.createSequence(function(){
		this.addEvents("editcomplete");
	}),
	onEditComplete: Ext.grid.EditorGridPanel.prototype.onEditComplete.createSequence(function(ed, value, startValue){
		this.fireEvent("editcomplete", ed, value, startValue);
	})
})

/// ICONES NA GRID ///////////////////////////////

var action = new Ext.ux.grid.RowActions({
    header:'Excluir'
   ,autoWidth: false
   ,actions:[{
       iconCls:'icon-excluir'
      ,tooltip:'Excluir'
	  ,width: 10
   }] 
});

action.on({
   action:function(grid, record, action, row, col) {
     // Ext.Msg.alert('A��o', String.format('A��o disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	  itenCar = record.data.idcarrinho;
	  acao = 'deletaItenCar';
	  Ext.Ajax.request({ 
			waitMsg: 'Executando...',
			url: 'php/lista_car_pedido.php',		
			params: { 
					itenCar: itenCar,
					acao: acao
					},
			callback: function (options, success, response) {
					  if (success) { 
									Ext.get('CodigoP').focus();
									dsProds.reload();
								   } 
					},
					failure:function(response,options){
						Ext.MessageBox.alert('Alerta', 'Erro...');
					},                                      
					success:function(response,options){
					if(response.responseText == 'Deletado'){
					dsProds.reload();
							}
					}                                      
		})
   }
});
//v = "R$ 1.000,50"
function toNum(v){
	v = String(v);	
	var a = v.replace(/\,/g,'.').replace(/[^\d\.]/g,'');
	if(a.match(/\./g)){
		while(a.match(/\./g).length>1){
			a = a.replace(/\./,'')
		}
	}
	return parseFloat();
}


//Ext.util.Format.usMoney
var calculaTotalPedido = function(){
	//alert('oi');
		var subnotas =  Ext.getCmp("SubTotal").getValue();
		var fretes = Ext.get("Frete").getValue();
		
		var fretesC = fretes.replace(".","");
		var fretesD = fretesC.replace(",",".");
		
		
		//console.log(fretes);
		//console.log(subnotas);
		
		var totalnotas = parseFloat(fretesD) + parseFloat(subnotas);
		
		//console.log(totalnotas);
		
		Ext.getCmp("Total").setValue(Ext.util.Format.usMoney(totalnotas));
		
 }


////////// FORMATACAO REAL //////////
Ext.util.Format.brMoney = function(v) {
	v = Ext.num(v, 0);
	v = (Math.round((v - 0) * 100)) / 100;
	v = (v == Math.floor(v)) ? v + ".00" : ((v * 10 == Math.floor(v * 10)) ? v + "0" : v);
	v = String(v);

	var ps = v.split('.');
	var whole = ps[0];
	var sub = ps[1] ? '.'+ ps[1] : '.00';
	var r = /(\d+)(\d{3})/;

	while (r.test(whole)) {
		whole = whole.replace(r, '$1' + ',' + '$2');
	}

	v = whole + sub;

	if (v.charAt  == '-') {
		return '-R$' + v.substr(1);
	}

	return "R$" + v;
}
//////////////////////////////////////////////////////brGridMoney

//FUNCAO PARA EXIBIR MOEDA NO FORMATO BRASILEIRO NA GRID

var brGridMoney = function(value){
	var value = replace.value(",",".");
	var value = replace.value(".", ",");
	
	return value;
}

// Fun��o que trata exibi��o do Ativo S = Sim e N = N�o
var formataAtivo = function(value){
	
	if(value=='S')
		  return 'Sim';
		else if(value=='N')
		  return '<span style="color: #FF0000;">N&atilde;o</span>';
		else
		  return 'Desconhecido'; 

};
    // example of custom renderer function
    function change(val){
        if(val > 0){
            return '<span style="color:green;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;">' + val + '</span>';
        }
        return val;
    };

    // example of custom renderer function
    function pctChange(val){
        if(val > 0){
            return '<span style="color:green;">' + val + '%</span>';
        }else if(val < 0){
            return '<span style="color:red;">' + val + '%</span>';
        }
        return val;
    };

/*
// EXIBIR IMAGENS NA GRID ///////////////
function getImg(val){
	//alert(val)
   return "<img width='16' height='11' src='"+val+"' border='0'>";
}
*/
 
 var prodId;
 var xgCli = Ext.grid;
 var xgprod = Ext.grid;
 var expander;
 var msg;
 var dsProds;
 var idData;
var  pedido= Ext.get('pedido');
pedido.on('click', function(e){  


//////////////////////////////
	storeCliPedido = new Ext.data.SimpleStore({
        fields: ['sitCodigoPedido','sitDescricaoPedido'],
        data: [
            ['nome', 'Nome'],
            ['controle', 'Codigo'],
			['ruc', 'Ruc'],
			['telefonecom', 'Fone'],
			['cidade', 'Cidade']
        ]
    });
	
    var	clientes_pedidop = new Ext.FormPanel({
		    width:800,
			id: 'clientes_pedidop',
	        labelWidth: 75,
			closeAction: 'hide',
	        frame:true,
	      //  title: 'Live search',
	        bodyStyle:'padding:5px 5px 0',
	        defaults: {width: 230},
	        defaultType: 'textfield',
			items: [
					
					
					combo01Pedido = new Ext.form.ComboBox({
                    name: 'sitCodigoPedido',
                    id: 'sitCodigoPedido',
					readOnly:true,
                    store: storeCliPedido,//origem dos dados
                    fieldLabel: 'Pesquisar por',
                    allowBlank: false, //permitir ou n�o branco, ser� validado ao sair do campo.
                    displayField: 'sitDescricaoPedido', //campo a ser exibido, de acordo com o mapemanto feito no objeto store
                    hiddenName: 'sitCodigoPedidoVal', //nome do campo Hidden que ser� criado automaticamente para receber o valor do item selecionado no combobox
                    typeAhead: true, //auto-selecionar o combo de acordo com o texto digitado
                    valueField: 'sitCodigoPedido',
                    mode: 'local', //localiza��o da origem dos dados.
                    forceSelection: true,//for�ar que s� digite texto que exista em um dos itens. False para permitir qualquer texto.
                    triggerAction: 'all',
                    emptyText: 'Nome', //texto a ser exibido quando n�o possuir item selecionado
                    selectOnFocus: true, //selecionar o texto ao receber foco
	                blankText : 'Nome', 
                    width: 50,
					listeners:{select:{fn:function(combo, value) {
						 combos = combo.getValue();
               // alert(combo);
          }}}

                }),
				  
				
					{
	                fieldLabel: 'Pesquisa',
	                name: 'queryPedido',
					id: 'queryPedido',
	                allowBlank:true,
	  		                            
					listeners: 
					{
						
						keyup: function(el,type)
						{
							if(e.getKey() == 40  ){//seta pra baixo  
							   grid_listacli.getSelectionModel().selectFirstRow();
							   grid_listacli.getView().focusEl.focus();
                            }
							var theQuery=el.getValue();
							
							dsCliPedido.load(
							{
								params: 
								{	
									query: theQuery,
									combo: combo01Pedido.getValue()
									
								}
								
																
							});
							
						}
               
					}
	            }
	        ]	
				
				
				
 });
		////////////////////////////////////////////////////////////////
 		dsCliPedido = new Ext.data.Store({
                url: '../php/lista_cli.php',
              //  method: 'POST'
								
            reader:  new Ext.data.JsonReader({
				totalProperty: 'total',
				root: 'results',
				id: 'controle',
				fields: [
						 {name: 'controleCliP',  mapping: 'controle',  type: 'string' },
						 {name: 'nome',  type: 'string' },
						 {name: 'telefonecom',  type: 'string' },
						 {name: 'ruc',  type: 'string' },
						 {name: 'ativo',  type: 'string' },
						 {name: 'data',  type: 'string' },
						 {name: 'razao_social',  type: 'string'},
						 {name: 'cedula',  type: 'string' },
						 {name: 'endereco',  type: 'string' },
						 {name: 'fax',  type: 'string' },
						 {name: 'celular',  type: 'string' },
						 {name: 'limite',  type: 'string' },
						 {name: 'email',  type: 'string' },
						 {name: 'obs',  type: 'string' },
						 {name: 'saldo_devedor',  type: 'string' },
						 {name: 'cidade',  type: 'string' }
						 ]
			})					    
			
		})
		// Fun��o que trata exibi��o do Ativo S = Sim e N = N�o


	     var grid_listacli = new Ext.grid.GridPanel(
	    {
	        store: dsCliPedido, // use the datasource
	        
	        cm: new xgCli.ColumnModel(
		        [
		        	//expander,
		            {id:'controleCliP', width:'20', header: "Codigo",  sortable: true, dataIndex: 'controleCliP'},
		            {id:'nome', width:'300', header: "Nome",  sortable: true, dataIndex: 'nome'},
					{id:'telefonecom', width:'90', header: "Fone",  sortable: true, dataIndex: 'telefonecom'},
					{id:'ruc', width:'90', header: "Ruc",  sortable: true, dataIndex: 'ruc'},
					{id:'ativo', width:'20', header: "Ativo",  sortable: true, dataIndex: 'ativo', renderer: formataAtivo},
					{id:'data', width:'20', header: "Data", hidden: true,  sortable: true, dataIndex: 'data'},
					{id:'razao_social', width:'20', header: "Razao Social", hidden: true,  sortable: true, dataIndex: 'razao_social'},
					{id:'cedula', width:'20', header: "Data", hidden: true,  sortable: true, dataIndex: 'cedula'},
					{id:'endereco', width:'20', header: "Data", hidden: true,  sortable: true, dataIndex: 'endereco'},
					{id:'fax', width:'20', header: "Data", hidden: true,  sortable: true, dataIndex: 'fax'},
					{id:'celular', width:'20', header: "Celular", hidden: true,  sortable: true, dataIndex: 'celular'},
					{id:'limite', width:'20', header: "Limite", hidden: true,  sortable: true, dataIndex: 'limite'},
					{id:'email', width:'20', header: "Email", hidden: true,  sortable: true, dataIndex: 'email'},
					{id:'obs', width:'20', header: "Obs", hidden: true,  sortable: true, dataIndex: 'obs'},
					{id:'saldo_devedor', width:'20', header: "Saldo Devedor", hidden: true,  sortable: true, dataIndex: 'saldo_devedor'},
					{id:'cidade', width:'20', header: "Cidade", hidden: true,  sortable: true, dataIndex: 'cidade'}
					
		        ]
	        ), 
	        viewConfig: 
	        {
	            forceFit:true
	        },
	        
	        plugins: expander,
			collapsible: true,
			animCollapse: false,
			deferRowRender : false,
			width:785,
			height: 255,
	        stripeRows:true,
	      //  title:'Search results',
	        iconCls:'icon-grid',
			//selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			listeners: {
			keypress: function(e){
				
			if(e.getKey() >47 && e.getKey() < 58 || e.getKey() >64 && e.getKey() < 91 || e.getKey() >95 && e.getKey() < 106 ){
 	   					Ext.get('queryPedido').focus(); 
			}
			else if(e.getKey() == e.ENTER) {//
			// Carrega O formulario Com os dados da linha Selecionada
			record = grid_listacli.getSelectionModel().getSelected();
			tabs.getForm().loadRecord(record);	
			var idName = grid_listacli.getColumnModel().getDataIndex(0); // Get field name
			var idData = record.get(idName);
			

	select_cli_pedido.hide() //url: '../php/lista_car_pedido.php',
	dsProds.load(({params:{'cliente':idData}}));
	setTimeout(function(){
	Ext.get('CodigoP').focus();
	}, 250);
			
			
			}
			}}
			
	    });	
		 
		 
///////GRID DOS PRODUTOS/////////////////////
 dsProds = new Ext.data.GroupingStore({
			 proxy: new Ext.data.HttpProxy({
                url: '../php/lista_car_pedido.php',
                method: 'POST'
				}),
				groupField:'controleCli',
				sortInfo:{field: 'idcarrinho', direction: "DESC"},
				nocache: true,

 reader:  new Ext.data.JsonReader({
				totalProperty: 'totalProd',
				root: 'resultProd',
				id: 'idcarrinho',
				fields: [
						 {name: 'action1', type: 'string'},
						 {name: 'idcarrinho', mapping: 'idcar', type: 'string' },
						 {name: 'idprod',  mapping: 'idprod',  type: 'string' },
						 {name: 'idproduto',  mapping: 'Codigo' },
						 {name: 'controleCli',   type: 'float' },
						 {name: 'descricao',  type: 'string' },
						 {name: 'prvenda' },
						 {name: 'qtd_produto' },
						 {name: 'totals'},
						 {name: 'totalProds'}
						 
						 ]
				

			})					    
			
		});
 var gridFormItens = new Ext.BasicForm(
		Ext.get('form7'),
		{
			});

	// define a custom summary function
     Ext.grid.GroupSummary.Calculations['totalProds'] = function(v, record, field){
		 //gridProd.getBottomToolbar().items.items[3].el.innerHTML = v;
		var v = v+ (parseFloat(record.data.prvenda) * parseFloat(record.data.qtd_produto));   //toNum
		Ext.getCmp("SubTotal").setValue((v));
		
		 var subnota =  Ext.get("SubTotal").getValue();
		 //var subnotaA = subnota.replace(".","");
		 //var subnotaB = subnotaA.replace(",",".");
		var frete = Ext.get("Frete").getValue();
		var freteA = frete.replace(".","");
		var freteB = freteA.replace(",",".");
		//console.log(freteB);
		var totalnota = parseFloat(freteB) + parseFloat(subnota);
		//console.log(totalnota);
		//totalnota = (totalnota);
		Ext.getCmp("Total").setValue(Ext.util.Format.usMoney(totalnota));
        //console.log(totalnota);
		
		return v;
		
    }

var summary = new Ext.grid.GroupSummary(); 
var gridProd = new Ext.grid.EditorGridPanel({
   store: dsProds,
   enableColLock: true,
   containerScroll  : false,
   loadMask: {msg: 'Carregando...'},
     columns: [
	   action,
	  {id: 'idcarrinho', header: 'idcarrinho', hidden: true, width: 10, dataIndex: 'idcarrinho'},	
	  {id: 'idprod', header: 'Codigo', summaryType: 'count', width: 200, dataIndex: 'idprod'},	
	  {id: 'idproduto', header: 'idproduto',  width: 200, hidden: true, dataIndex: 'idproduto'},		
      {id: 'controleCli',  width: 30, hidden: false, dataIndex: 'controleCli'},
      {id: 'descricao',  header: 'Descri��o', width: 300, dataIndex: 'descricao'},
      {id: 'prvenda', header: "Pre�o", dataIndex: 'prvenda',  width: 100, align: 'right', //renderer: "usMoney",
	  editor: new Ext.form.NumberField(
					{
						allowBlank: false,
						textReverse : true,
						//mask:'decimal',
						selectOnFocus:true,
						allowNegative: false	

						}
				)},
	  {id: 'qtd_produto', header: "Qtd", dataIndex: 'qtd_produto', width: 50, align: 'right',   
	  editor: new Ext.form.NumberField(  
					{
						allowBlank: false,
						selectOnFocus:true,
						allowNegative: false
						}
				)
	  },
	  {	
                id: 'totals',
                header: "Total",
                width: 100,
				align: 'right',
                sortable: false,
				fixed:true,
                groupable: false,
                renderer: function(v, params, record){
				//var prvendaA = record.data.prvenda.replace(".","");
				//console.log(prvendaA);
				//var prvendaB = prvendaA.replace(",",".");
				//console.log(prvendaB);
                return Ext.util.Format.usMoney(parseFloat(record.data.prvenda) * parseFloat(record.data.qtd_produto));
				
                },
				id:'totalProds',
                dataIndex: 'totalProds',
                summaryType:'totalProds',
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
   width:901,
   height:243,
   border: true,
   moveEditorOnEnter: true,
   plugins: [summary,action],
   //title:'Itens do Pedido',
   loadMask: true,
   clicksToEdit:1,
   listeners:{
      afteredit:function(e){
         Ext.Ajax.request({
            url: '../php/lista_car_pedido.php',
            params: {
               id: e.record.get('idcarrinho'),
               valor: e.value,
			   campo: e.column
            },
			success: function(){
                           //Ext.example.msg('Informa&ccedil;&atilde;o','Registro atualizado com sucesso');
                           dsProds.commitChanges();
						   Ext.getCmp("TabSul").activate(0);
                        },
			failure: function(){
                           Ext.example.msg('Erro','N&atilde;o foi possivel Alterar.');
                           dsProds.rejectChanges();
                        }
         })
      }, 
	  editcomplete:function(ed){
	  setTimeout(function(){
	  if(ed.col == 7){				
	  Ext.get('CodigoP').focus();
	  }
	  if(ed.col == 6){				
	  gridProd.startEditing(ed.row,ed.col+1);
	  }
	   }, 250);
	  },
	  celldblclick: function(grid, rowIndex, columnIndex, e){
	
            var record = grid.getStore().getAt(rowIndex); // Pega linha 
            var fieldName = grid.getColumnModel().getDataIndex(3); // Pega campo da coluna
            var data = record.get(fieldName); //Valor do campo
			
			var tab = Ext.getCmp("TabSul").getActiveTab().id;
			
			if(tab == 'TabSul_B'){
			dsProdVend.load(({params:{codigo: data, campo: e.column}}));
			}
		}
	 

   		},
  		bbar : new Ext.Toolbar({ 
			items: [			   
         	            
           				{
						xtype:'button',
           			    text: 'Finalisar',
						id: 'fin',
						align: 'left',
						iconCls: 'icon-save',
						disabled: true,
            			handler: function(){ // fechar	
     	    			FinPedido();
						}
						
  			 			},
						{
						xtype:'button',
           			    text: 'Cancelar',
						id: 'canc',
						align: 'left',
						iconCls: 'icon-cancel',
            			handler: function(){ // fechar	
     	    			CancPedido();
						}
						
  			 			}
					//	, '<b>Total=</b>',''
		
		] 
						   }) 
}); 
//////////////////////////////////////////////////////////////////////////
grid_listacli.on('rowdblclick', function(grid, row, e) {
	// Carrega O formulario Com os dados da linha Selecionada
	tabs.getForm().loadRecord(dsCliPedido.getAt(row));	

			record = grid_listacli.getSelectionModel().getSelected();
			var idName = grid_listacli.getColumnModel().getDataIndex(0); // Get field name
			var idData = record.get(idName);
			
	select_cli_pedido.hide()
	dsProds.load(({params:{'cliente':idData}}));
	Ext.get('CodigoP').focus();
	
}); 

gridProd.getStore().on('load', function (){
   if(gridProd.getStore().getTotalCount() > 0){
   Ext.getCmp('fin').setDisabled(false); }
   if(gridProd.getStore().getTotalCount() == 0){
   Ext.getCmp('fin').setDisabled(true); }
});

        // tabs for the center
        var tabs = new Ext.FormPanel({
			url: '../php/lista_cli.php',
          waitMsg:'Carregando...',
          method: 'POST',
          baseParams:{acao: "BuscaCodigo"},
		  reader: new Ext.data.JsonReader({
             root: 'results',
             fields: [
              {name: 'controleCliP', mapping: 'controle'},
              {name: 'nome'},
              {name: 'ruc'}
              ]
            }), 
			title       : 'Cliente',
			labelAlign: 'top',
			ds: dsCliPedido,
			//layout: 'form',
            region    : 'north',
            margins   : '3 3 3 0',
			bodyStyle: 'padding-left:3px;',
			frame: true,
			collapsible : true,
			split       : true,
			autoScroll:false,
			width       : 150,
			height      : 125,
			items:[		// ABRE A
				   {  // ABRE A1
				   layout:'column',
				   border: true,
            	items:[		// ABRE B
					   {   // ABRE B1
                columnWidth:.2,
                layout: 'form',
				border: false,
                items: [  // ABRE C
			
				  {
				   xtype:'datefield',
                    fieldLabel: '<b>Data</b>',
					id: 'user',
                    name: 'user',
                    width: 100,
					hideTrigger: true, readonly: true

                },
				
				{  // ABRE XTYPE
				xtype:'textfield',
                fieldLabel: '<b>Codigo</b>',
				id: 'controleCliP',
                name: 'controleCliP',
                width: 100,
				listeners:{
				keyup:function(field, key){ //alert(key.getKey());
                            if((key.getKey() == key.F8)){ 

							 		select_cli_pedido.show();
									}
							if(key.getKey() == key.ENTER) {
								controle = Ext.get('controleCliP').getValue();
                   		//Ext.getCmp('nome').enable();
                       //	 Ext.getCmp('ruc').enable();
                       tabs.load({params: {query: controle}});
					   var idData =  controle;
					   Ext.get('CodigoP').focus(); 
					   dsProds.load(({params:{'cliente':idData}})); 
					   
					   //nav.form.findField('fin')setDisabled(false);
					   
				 }         
					}
				}
					
					
               } // FECHA XTYPE
           
				] // FECHA C	
				   } ,  // // FECHA B1
				   {   // ABRE B1
                columnWidth:.3,
                layout: 'form',
				border: false,
				height: 95,
				bodyStyle: 'padding-top:48px;',
                items: [  // ABRE C1
				
			
				  {
				   xtype:'textfield',
                    fieldLabel: '<b>Nome</b>',
					id: 'nomeCli',
                    name: 'nome',
                    width: 200
                }
				
				]},
				
				   {   // ABRE B2
                columnWidth:.2,
                layout: 'form',
				border: false,
				bodyStyle: 'padding-top:48px;',
                items: [  // ABRE C2
				  {
				   xtype:'textfield',
                    fieldLabel: '<b>Ruc</b>',
					id: 'rucCli',
                    name: 'ruc',
                    width: 100
                }
				
				] //FECHA C2
				} // FECHAB2
				
				
				
				   ]  // FECHA B
				   
				   } // // FECHA A1
				   ]  // FECHA A
        });
/*tabs.addButton('Load', function(){
        tabs.getForm().load({url:'php/lista_cli.php', waitMsg:'Loading'});
    }); */
        // Panel for the west
        var nav = new Ext.FormPanel({
            title       : 'Pesquisa de Produtos',
			id: 'vav',
			labelAlign: 'left',
            region      : 'center',
            split       : true,
            width       : 200,
			height		: 270,
            collapsible : true,
            margins     : '3 3 0 0',
			bodyStyle: 'padding-left:3px;',
            cmargins    : '3 3 3 3',
			items:[		// ABRE A
				   {  // ABRE A1
				   layout:'column',
				   height: 20,
				   border: false,
            	items:[		// ABRE B
					   {   // ABRE B1
                width:250,
                layout: 'form',
				bodyStyle: 'padding:3px 3px;',
				border: false,
				items: [  // ABRE C
				  {
				   xtype:'textfield',
                    fieldLabel: '<b>Codigo</b>',
					id: 'CodigoP',
                    name: 'CodigoP',
					width: 120,
					listeners: {
					keyup :function(field, key){ 
                            if((key.getKey() == key.ENTER)){  
								//var prodId  = Ext.getCmp("CodigoP").getValue();
         						Ext.Ajax.request({
            					url: '../php/lista_car_pedido.php',
								method: 'POST',
								remoteSort: true,
           						params: {
               					codigoProd: Ext.getCmp("CodigoP").getValue(),
			   					acao: 'inserir',
			   					clienteIns: Ext.getCmp("controleCliP").getValue()
            					}, 
								success: function(result, request){//se ocorrer correto 
								var jsonData = Ext.util.JSON.decode(result.responseText);
								if(jsonData.response == 'Produto ja adicionado'){  Ext.MessageBox.alert('Aviso','Produto ja adicionado.', showResultProd); }
								if(jsonData.response == 'Erro'){Ext.MessageBox.alert('Aviso','Produto nao encontrado.', showResultProd); }
								if(jsonData.response != ''){ 
								
								dsProds.reload();
								Ext.getCmp('CodigoP').setValue('');
								
								setTimeout(function(){
								gridProd.startEditing(0,6);
								dsProdVend.load(({params:{codigo: jsonData.response, campo: e.column}}));
								}, 250);
								Ext.getCmp("TabSul").activate(1);
								}								 
								
								// Ext.example.msg('Informa&ccedil;&atilde;o','Registro atualizado com sucesso');
								},
								 failure: function(){
               					 Ext.example.msg('Erro','N&atilde;o foi possivel enviar a solicitacao');
               					 dsProds.rejectChanges();
            					}
								

         				}) 
						 
                    }} 
                } }
				]
				
				
				
					   }/*,
				 {   // ABRE coluna 2
                width:200,
                layout: 'form',
				border: false,
				items: [ ]// ABRE itens da coluna 2
				
				
				
					   }*/
				]
			},gridProd
		]		
        });
		
function showResultProd(btn){
       Ext.get('CodigoP').focus();
	  // Ext.get('CodigoP').setValue('');
    };		
function showResultCli(btn){
       Ext.get('controleCliP').focus();
    };	

//////// INICIO DA GRID DOS VENDIDOS ////////
var dsProdVend = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod_det_vend.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'idped'},
				   {name: 'controle_cli'},
		           {name: 'nome_cli'},
		           {name: 'data_car'},
		           {name: 'qtd_produto'},
		           {name: 'prvenda'},
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		//id: 9,
		remoteSort: true		
	});
 var gridProdVend = new Ext.grid.EditorGridPanel(
	    {
	        store: dsProdVend, // use the datasource
	        
	        columns:
		        [
						{id:'id',header: "Pedido", width: 50, sortable: true, dataIndex: 'idped'},
						{header: 'Codigo', width: 80, sortable: true, dataIndex: 'controle_cli'},
						{header: "Nome", width: 230, sortable: true, dataIndex: 'nome_cli'},
						{header: "Data", width: 90, align: 'right', sortable: true, dataIndex: 'data_car', renderer: change},
						{header: "Qtd", width: 80,  align: 'right',  sortable: true, dataIndex: 'qtd_produto'},
						{header: "Valor", width: 90, align: 'right', sortable: true, dataIndex: 'prvenda'}
			
			 ],
	       
	        viewConfig: 
	        {
	            forceFit:true
	        },
			width:'100%',
			id: 'prodsVd',
			height: 78,
			//autoHeight: true,
			ds: dsProdVend,
			//selModel: new Ext.grid.CellSelectionModel({singleSelect:false}),
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			autoScroll: true
			
		
});
 ////////FIM GRID DOS DETALHES ///////////////////////////////////////////////////

	 var tot = new Ext.FormPanel({
			title       : '',
            region    : 'south',
			frame: true,
           // margins   : '3 3 3 0',
			//collapsible : true,
			//border      :false,
			//split       : true,
			width       : 700,
			height      : 120,
			items: {
            xtype:'tabpanel',
			id: 'TabSul',
			height: 118,
            activeTab: 0,
            defaults:{autoHeight:false},// bodyStyle:'padding:10px'},
			
			//////////// INICIO DAS ABAS /////////////////////
            items:[
				//////// INICIO ABA PRIMEIRA ////////////////////////////////////   
				{
                title:'Faturamento',
				id: 'TabSul_A',
				autoHeight: true,
				iconCls: 'icon-money',
                layout:'form',
                //defaults: {width: 230},
				
				items:[		// ABRE A
				   {  // ABRE A1
				   layout:'column',
				   border: false,
            	items:[		// ABRE B
					   {   // ABRE B1
                columnWidth:.2,
                layout: 'form',
				labelAlign: 'right',
				//border: false,
                items: [  // ABRE C
						{
							style: 'margin-bottom:6px'
						},
				
				{
				xtype:'textfield',
                fieldLabel: '<b>SubTotal</b>',
				id: 'SubTotal',
                name: 'SubTotal',
				//mask:'decimal',
				//textReverse : true,
				readOnly: true,
				emptyText: '0,00',
                width: 70
					
               } // FECHA XTYPE
           
				] // FECHA C	
				   } ,  // // FECHA B1
				   {   // ABRE B1
                columnWidth:.2,
                layout: 'form',
				labelAlign: 'right',
				border: false,
                items: [  // ABRE C1
				{
					style: 'margin-bottom:6px'
					//float:'left'
					 },
			
				  new Ext.ux.MaskedTextField({
                    fieldLabel: 'Frete',
					id: 'Frete',
                    name: 'Frete',
					mask:'decimal',
					textReverse : true,
					width: 70,
					emptyText: '0.00',
                   //anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('Desconto').focus();
                            }}
                })
				
				]},
				
				   {   // ABRE B2
                columnWidth:.2,
                layout: 'form',
				labelAlign: 'right',
				border: false,
                items: [  // ABRE C2
						{
					style: 'margin-bottom:6px'
					//float:'left'
					 },
			
				  new Ext.ux.MaskedTextField({
                    fieldLabel: 'Desconto',
					id: 'Desconto',
                    name: 'Desconto',
					readOnly: true,
					mask:'decimal',
					textReverse : true,
					emptyText: '0,00',
					width: 70
                   
                })
				
				] //FECHA C2
				}, // FECHAB2
				
				 {   // ABRE B2
                columnWidth:.3,
                layout: 'form',
				labelAlign: 'right',
				border: false,
                items: [  // ABRE C2
						{
					style: 'margin-bottom:6px'
					 },
			
				  {
				   xtype:'textfield',
                    fieldLabel: '<b>Total</b>',
					id: 'Total',
                    name: 'Total',
					//readOnly: true,
					//emptyText: '0,00',
                    width: 100
					
					
					
                }
				
				] //FECHA C2
				} // FECHAB2
				
				
				
				   ]  // FECHA B
				   
				   } // // FECHA A1
				   ]  // FECHA A

				
            },
			////////// FIM ABA PRIMEIRA ////////////////////////////////
			
			
			////// INICIO ABA SEGUNDA ////////////////////////////////
				{
                title:'Vendas do Produto',
				id: 'TabSul_B',
                layout:'form',
				frame: true,
				height: 65,
				hideBorders : true,
				//autoScroll: true,
				iconCls: 'user-red',
                items: [gridProdVend]
            }
			/////////////// FIM ABA SEGUNDA ///////////////////
			
			]
			///////////// FIM DAS ABAS /////////////////////////
        }

					
           
        });


	win_pedido = new Ext.Window({
		id: 'win_pedido',
		title: 'Efetuar Pedido',
		width:930,
		height:640,
		autoScroll: true,
		shim:true,
		closable : true,
		html: '<div id=\'CA\'></div><br /><div id=\'CB\'></div><br /><div id=\'CC\'></div>',
		layout: 'border',
		resizable: false,
		closeAction: 'destroy',
		draggable: true, //Movimentar Janela
		plain: true,
		modal: false, //Bloquear tela do fundo
		items:[nav,tabs,tot],
		focus: function(){
					Ext.get('controleCliP').focus(); 
		},
		buttons: [
           	{
            text: 'Cerrar',
            handler: function(){ // fechar	
     	    win_pedido.destroy();
			select_cli_pedido.destroy();
  			 }
			 
        }]
			 
		
	});
	Ext.getCmp("Frete").on('blur',calculaTotalPedido);
	
	win_pedido.show();
	
/*
var map = new Ext.KeyMap(document, {
        key: Ext.EventObject.Q,
		alt: true,
        fn: function(k,e){
		Ext.get('CodigoP').focus();  
		}
		});
		
var mapd = new Ext.KeyMap(document, {		
        key: Ext.EventObject.W,
		alt: true,
        fn: function(k,e){
		Ext.get('DescricaoP').focus();  
		} 
	});
*/
		select_cli_pedido = new Ext.Window({
		title: 'Selecione o Cliente',
		width:730,
		height:400,
		autoScroll: false,
		modal: true,
		closable: true,
		closeAction: 'hide',
		items:[clientes_pedidop,grid_listacli],
		focus: function(){
					Ext.get('queryPedido').focus(); 
		},
		buttons: [
           	{
            text: 'Cerrar',
            handler: function(){ // fechar	
     	    select_cli_pedido.hide();
  			 }
			 
        }]
		
								});




	}); // final onclik 

}); //////final



/*
//TAMBEM FUNCIONA////
var map = new Ext.KeyMap(document, 
{
key: 'f6',
alt: true,
fn: function(){ alert("D was pressed"); }
/////////////////////// 
*/	