// JavaScript Document


Cotacao = function(){

function FocoCodigo(){
       Ext.get('controleCliC').focus();
    }
Ext.override(Ext.grid.EditorGridPanel, {
initComponent: Ext.grid.EditorGridPanel.prototype.initComponent.createSequence(function(){
this.addEvents("editcomplete");
}),
onEditComplete: Ext.grid.EditorGridPanel.prototype.onEditComplete.createSequence(function(ed, value, startValue){
this.fireEvent("editcomplete", ed, value, startValue);
})
});


    
var SelectCliCotacao = function(){
   						Ext.Ajax.request({
           					url: 'php/cotacao.php',
							remoteSort: true,
           					params: {
       					    acao: 'codCli',
							user: id_usuario,
			    			CodCliente: Ext.getCmp("controleCliC").getValue()
            					},
								success: function(response){//se ocorrer correto 
								var jsonData = Ext.decode(response.responseText);
								 cli = Ext.decode( response.responseText);
								 if(cli){
								 nomeClien = cli.nome;
								 Ext.getCmp('nomeCliente').setValue(nomeClien);
                                 nomeEndereco = cli.endereco;
								 Ext.getCmp('enderecoCot').setValue(nomeEndereco);
                                 nomeTelefonecom = cli.telefonecom;
								 Ext.getCmp('telefonecomCot').setValue(nomeTelefonecom);
								 //Ext.getCmp('nomedesp').focus();
								 
								 }
								 else{ 
                                 FormCotacao.getForm().reset();
								 Ext.MessageBox.alert('Aviso', 'Cliente nao encontrado', FocoCodigo); }
								}
							});
						}
    
	var formClienteCotacao = new Ext.Panel({
        labelAlign: 'top',
        id: 'formClienteCotacao',
        frame:true,
		autoHeight: true,
		width: '100%',
        border: false,
		autoScroll:true,
        items: [{
            layout:'column',
            items:[{
                columnWidth:.1,
                layout: 'form',
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Codigo',
                    name: 'controleCliC',
					id: 'controleCliC',
                    anchor:'90%',
					fireKey: function(e,type){
						if(e.getKey() == e.ENTER && Ext.get('controleCliC').getValue() != '') {
							CodCliente = Ext.getCmp('controleCliC').getValue();
							setTimeout(function(){
							//
							 }, 250);
							SelectCliCotacao();
				   //nav.form.findField('fin')setDisabled(false);
						}
						if(e.getKey() == e.ENTER && Ext.getCmp('controleCliC').getValue() === '') {
							Ext.Msg.alert('Alerta', 'Erro, Entre com o Codigo');
						}	
					}
                }
				]
				},
				{
                columnWidth:.3,
                layout: 'form',
                items: [
                {
				xtype:'combo',
				allowBlank: false,
                hideTrigger: false,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Nome',
				id: 'nomeCli',
				minChars: 3,
				name: 'nomeCli',
				anchor: '95%',
                resizable: true,
                listWidth: 350,
				forceSelection: true,
				store: new Ext.data.JsonStore({
				url: 'php/cotacao.php?acao_nome=nomeCliente',
				root: 'resultados',
				fields: [ 'controle', 'nome', 'endereco', 'telefonecom' ]
				}),
					hiddenName: 'controle',
					valueField: 'controle',
					displayField: 'nome',
					onSelect: function(record){
						this.collapse();
						this.setValue(record.data.nome);
                        Ext.getCmp('controleCliC').setValue(record.data.controle);
						Ext.getCmp('enderecoCot').setValue(record.data.endereco);
                        Ext.getCmp('telefonecomCot').setValue(record.data.telefonecom);
						Ext.getCmp('CodigoProdutoCot').focus();
					}
							
                }
				]
				},
				{
                columnWidth:.3,
                layout: 'form',
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Direccion',
                    name: 'enderecoCot',
					id: 'enderecoCot',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('Descricao').focus();
                            }}
                }
				]
				},
				{
                columnWidth:.2,
                layout: 'form',
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Telefono',
                    name: 'telefonecomCot',
					id: 'telefonecomCot',
                    anchor:'95%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('Descricao').focus();
                            	}
								}
                		}
					]
				}
				]
				}
                ]
				
	});
    
  ///////GRID DOS PRODUTOS/////////////////////
 dsProds = new Ext.data.GroupingStore({
			 proxy: new Ext.data.HttpProxy({
                url: 'php/lista_car_pedido.php',
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
						 {name: 'pr_min' },
						 {name: 'descricao',  type: 'string' },
						 {name: 'prvenda' },
						 {name: 'qtd_produto' },
						 {name: 'totals'},
						 {name: 'totalProds'}
						 ]
			})					    
		});
 var gridFormItens = new Ext.BasicForm(
		Ext.get('form8'),
		{
			});

	// define a custom summary function
     Ext.grid.GroupSummary.Calculations['totalProds'] = function(v, record, field){
		//Barrafinal.getBottomToolbar().items.items[3].el.innerHTML = nome_user;
		var v = v+ (parseFloat(record.data.prvenda) * parseFloat(record.data.qtd_produto));   //toNum
	//	Ext.getCmp("SubTotal").setValue((v));
	//	var subnota =  Ext.get("SubTotal").getValue();
	//	var frete = Ext.get("Frete").getValue();
	//	var desc = Ext.get("Desconto").getValue();
		
//		var descA = desc.replace(".","");
//		var descB = descA.replace(",",".");
		
//		var freteA = frete.replace(".","");
//		var freteB = freteA.replace(",",".");
		
//		var dsct = subnota * descB / 100;
//		Ext.getCmp('valorDesc').setValue(Ext.util.Format.usMoney(dsct));
		
//		var totalnota = parseFloat(freteB) + parseFloat(subnota) - parseFloat(dsct);
//		Ext.getCmp("Total").setValue(Ext.util.Format.usMoney(totalnota));
		return v;
    }

var summary = new Ext.grid.GroupSummary(); 
var gridProd = new Ext.grid.EditorGridPanel({
   store: dsProds,
   enableColLock: true,
   containerScroll  : false,
   loadMask: {msg: 'Carregando...'},
     columns: [
	   //action,
	  {id: 'idcarrinho', header: '', hidden: false, width: 10, dataIndex: 'idcarrinho'},	
	  {id: 'idprod', header: 'Codigo', summaryType: 'count', width: 150, dataIndex: 'idprod' },
	//  {id: 'pr_min', header: 'pr_min', width: 200, dataIndex: 'pr_min', hidden: true },
	  {id: 'idproduto', header: 'idproduto',  width: 200, hidden: true, dataIndex: 'idproduto'},		
      {id: 'controleCli',  width: 30, hidden: false, dataIndex: 'controleCli'},
      {id: 'descricao',  header: 'Descripcion', width: 350, dataIndex: 'descricao'},
      {id: 'prvenda', header: "Precio", dataIndex: 'prvenda',  width: 100, align: 'right', //renderer: "usMoney",
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
   width:'100%',
   height:243,
   border: true,
   moveEditorOnEnter: true,
   plugins: [summary],//,action],
   loadMask: true,
   clicksToEdit:1,
   listeners:{
      afteredit:function(e){
         Ext.Ajax.request({
            url: 'php/lista_car_pedido.php', 
            params : {
               id: e.record.get('idcarrinho'),
               valor: e.value,
			   campo: e.column,
			   host: host,
			   user : id_usuario,
			   clienteIns: Ext.get('controleCliC').getValue()
            },
			success: function(result, request){//se ocorrer correto 
								var jsonData = Ext.util.JSON.decode(result.responseText);
								if(jsonData.response == 'Update' && jsonData.adicionado != ''){ 
                          			 dsProds.reload();
									 setTimeout(function(){
									 gridProd.startEditing(0,6);
									 }, 250);
						  			 Ext.getCmp("TabSul").activate(1);
									 dsProdVend.load(({params:{codigo: jsonData.adicionado, campo: e.column}}));
									 }
								if(jsonData.response == 'ProdutoNaoEncontrado'){
									 Ext.MessageBox.alert('Aviso','Produto nao encontrado.', showResultNew);
						  			 Ext.getCmp("TabSul").activate(0);
									 }
								if(jsonData.response == 'ProdutoJaAdicionado'){
									 Ext.MessageBox.alert('Aviso','Produto ja Adicionado.', showResultNew);
						  			 Ext.getCmp("TabSul").activate(0);
								     }
								if(jsonData.response == 'Valor Abaixo do Custo'){
									 dsProds.rejectChanges();
									 setTimeout(function(){
									 Ext.MessageBox.alert('Aviso','Valor Abaixo do Custo.', showResultNew);
									 }, 1050);
								}
                        },
			failure: function(){
                           Ext.example.msg('Erro','N&atilde;o foi possivel Alterar.');
                           dsProds.rejectChanges();
                        } 
						 
         }) //alert(params.campo);
	/*	 if(params.campo == 2){
		 Ext.Ajax.request({
            					url: '../php/teste.php',
								method: 'POST',
								remoteSort: true,
           						params: {
               					codigoProd: Ext.getCmp("CodigoP").getValue(),
			   					acao: 'inserir',
			   					clienteIns: Ext.getCmp("controleCliP").getValue()
            					} 
						  })
		 
						  }
		*/ 
		 
      },
	  editcomplete:function(ed,value){
	  setTimeout(function(){
	  if(ed.col == 7){				
	  addnovoProd();
	  Ext.getCmp("TabSul").activate(0);
	  }
	  if(ed.col == 6 ){				
	  gridProd.startEditing(ed.row,ed.col+1);
	  }
	   }, 250);
	  },
	  celldblclick: function(grid, rowIndex, columnIndex, e){
            var record = grid.getStore().getAt(rowIndex); // Pega linha 
            var fieldName = grid.getColumnModel().getDataIndex(3); // Pega campo da coluna
            data = record.get(fieldName); //Valor do campo
			//data = record.data.idproduto;
			var tab = Ext.getCmp("TabSul").getActiveTab().id;
			
			if(tab == 'TabSul_B'){
			dsProdVend.load(({params:{codigo: data, campo: e.column}}));
			}
		}
   		}
}); 


    FormCotacao = new Ext.FormPanel({
			id: 'FormCotacao',
            title       : 'Orçamento',
		//	labelAlign  : 'left',
            border      : false,
			frame		: false,
			closable    :true,
            autoWidth   : true,
			autoHeight	: true,
            collapsible : false,
			layout:'form',
            items:[formClienteCotacao,
                    {
					xtype       : 'fieldset',
				//	title       : 'Busca de Productos',
					layout      : 'form',
                    labelAlign  : 'right',
                    autoWidth   : true,
					collapsible : false,                    
					collapsed   : false,
					autoHeight  : true,
                    items:[
                            {
                            xtype:'textfield',
                            fieldLabel: '<b>Codigo</b>',
                            labelWidth: 70,
                            name: 'CodigoProdutoCot',
                            width: 100,
					        id: 'CodigoProdutoCot',
					        fireKey: function(e,type){
							 if(e.getKey() == e.ENTER && Ext.getCmp('CodigoProdutoCot').getValue() == '') {
								 ListaProdutos();
								 Ext.getCmp('sitCodigoPedidoprod').setValue('Codigo');
							   	 Ext.getCmp('queryPedidoprod').focus(); 
							 
							}
							if(e.getKey() == e.ENTER && Ext.getCmp('CodigoProdutoCot').getValue() != '') {
							Ext.Ajax.request({
										url: 'php/lista_car_pedido.php', 
										params : {
												  // id: e.record.get('idcarrinho'),
												   valor: Ext.get('CodigoProdutoCot').getValue(),
												   campo: '2',
												   user : id_usuario,
												   host : host,
												   clienteIns: Ext.get('controleCliP').getValue()
													},
										success: function(result, request){//se ocorrer correto 
											var jsonData = Ext.util.JSON.decode(result.responseText);
											if(jsonData.response == 'Update' && jsonData.adicionado != ''){ 
													 dsProds.reload();
													 setTimeout(function(){
													 gridProd.startEditing(0,6);
													 }, 2050);
														 Ext.getCmp("TabSul").activate(1);
														 dsProdVend.load(({params:{codigo: jsonData.adicionado, campo: e.column}}));
														 }
											if(jsonData.response == 'ProdutoNaoEncontrado'){
													//	 Ext.MessageBox.alert('Aviso','Produto nao encontrado.', showResultNew);
													ListaProdutos();
													Ext.getCmp('sitCodigoPedidoprod').setValue('Codigo');
													Ext.getCmp('queryPedidoprod').setValue(Ext.getCmp('CodigoProdutoCot').getValue());
													dsProdPedido.load({params:{query: Ext.getCmp('CodigoProdutoCot').getValue(),combo: combo01Pedidoprod.getValue()}});
							   					    Ext.getCmp('queryPedidoprod').focus(); 
														 Ext.getCmp("TabSul").activate(0);
									 					}
											if(jsonData.response == 'ProdutoJaAdicionado'){
														 Ext.MessageBox.alert('Aviso','Produto ja Adicionado.', showResultNew);
														 Ext.getCmp("TabSul").activate(0);
														 }
										},
									failure: function(){
										   Ext.example.msg('Erro','N&atilde;o foi possivel Alterar.');
										//   dsProds.rejectChanges();
                        			} 
         					}) 
							}
						}
                },
				{
                    xtype:'textfield',
                    fieldLabel: '<b>Descrição</b>',
                    name: 'DescricaoProduto',
                    labelWidth: 70,
                    labelAlign  : 'right',
                    col: true,
					id: 'DescricaoProduto',
                    width: 250,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							 ListaProdutos();
							 Ext.getCmp('sitCodigoPedidoprod').setValue('Descricao');
							 Ext.getCmp('queryPedidoprod').setValue(Ext.getCmp('DescricaoProduto').getValue());
							 Ext.getCmp('queryPedidoprod').focus(); 
                            }}
                }
				]
				},
                gridProd
                ],
            listeners:{
					destroy: function() {
						//	 tabs.remove('FormPedido');
         				   }
		              }
            });




















Ext.getCmp('tabss').add(FormCotacao);
Ext.getCmp('tabss').setActiveTab(FormCotacao);
FormCotacao.doLayout();



}