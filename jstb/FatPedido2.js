// JavaScript Document



FatPedido = function(){
    
Ext.form.Field.prototype.msgTarget = 'side';
Ext.form.FormPanel.prototype.bodyStyle = 'padding:5px';
Ext.form.FormPanel.prototype.labelAlign = 'right';
Ext.QuickTips.init();
	
	
var xgPedido = Ext.grid;

var selecione = function(){
Ext.MessageBox.alert('Alerta', 'Por favor selecione um pedido');
}
	
/////////////////////// INICIO STORE //////////////////////////////////
dsFatPedido = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({
	    url: '../php/FatPedido.php',
        method: 'POST'
    }),   

reader:  new Ext.data.JsonReader({
			totalProperty: 'total',
			root: 'results',
			id: 'id',
			remoteSort: true,
			fields: [
					 {name: 'idPedido',  type: 'string', mapping: 'id' },
					 {name: 'CodCli',  type: 'string', mapping: 'controle_cli' },
                     {name: 'total_nota',  type: 'string' },
                     {name: 'idforma',  type: 'string' },
					 {name: 'ClienteEndereco',  type: 'string', mapping: 'endereco' },
					 {name: 'ClientePedido',  type: 'string', mapping: 'nome_cli' },
					 {name: 'totalPedido',  type: 'string', mapping: 'totalitens' },
					 {name: 'dataPedido',  type: 'string', mapping: 'data' },
					 {name: 'formaPago',  type: 'string', mapping: 'descricao'},
					 {name: 'usuarioPedido',  type: 'string', mapping: 'nome_user' }
					 //{name: 'action1', type: 'string'},
   			         //{name: 'action2', type: 'string'}

					 ]
			})	,
			baseParams:{acao: 'listarPedidos'}
		})
///////////// FIM STORE ////////////////////////
///////////// INICIO DA GRID //////////////////

	     var gridFatPedido = new Ext.grid.GridPanel({
	        store: dsFatPedido, // use the datasource
	       cm: new xgPedido.ColumnModel([
		       
		        	//expander,
		            {id:'idPedido', width:40, header: "Pedido",  sortable: true, dataIndex: 'idPedido'},
					{id:'ClientePedido', width:130, header: "Cliente",  sortable: true, dataIndex: 'ClientePedido'},
					{id:'totalPedido', width:60, header: "Total", align: 'right', renderer: Ext.util.Format.usMoney,  sortable: true, dataIndex: 'totalPedido'},
					{id:'dataPedido', width:60, header: "Data", align: 'right', sortable: true, dataIndex: 'dataPedido'},
					{id:'formaPago', width:40, header: "Forma Pago", align: 'right',  sortable: true, dataIndex: 'formaPago'},
					{id:'usuarioPedido', width:40, header: "Usuario",align: 'right',  sortable: true, dataIndex: 'usuarioPedido'}
					//action

					
		        ]), 
	        viewConfig:{ 
			forceFit:true
			},
			collapsible: true,
            id: 'gridFatPedido',
			animCollapse: false,
			enableColLock: false,
			loadMask:true,
			title: 'Pedidos Pendentes',
			closable: true,
			autoWidth:true,
			height: 300,
	        stripeRows:true,
			bbar: new Ext.PagingToolbar({
				store: dsFatPedido,
				displayInfo: true,
				displayMsg: 'Mostrando registro de {0} a {1} total de {2} ',
				emptyMsg: "Não tem dados",
				pageSize: 5,
				beforePageText : "P&aacute;gina",    
				afterPageText : "de {0}",    
				firstText : "Primeira P&aacute;gina",    
				prevText : "P&aacute;gina Anterior",    
				nextText : "Proxima P&aacute;gina",    
				lastText : "Ultima P&aacute;gina",    
				refreshText : "Atualizar",    
			//	paramNames : {start: 0, limit: 5},
				items:['-', '<b> * Duplo click para abrir</b>'  ]
			}),
			listeners:{
				destroy: function() {
                          // FormPedido.destroy();
					tabs.remove('FormPedido');	 
         				}
			         }
		});
		dsFatPedido.load({params:{acao: 'listarPedidos',start: 0, limit: 5}});
	
		 PedidoTemplate = 
		                  [
							'</br>'
							,'<b>Pedido: &nbsp;</b>{idPedido}<br/>'
							,'<b>Codigo: &nbsp;</b>{CodCli}&nbsp;&nbsp;'
							,'<b>Nome: &nbsp;</b>{ClientePedido}&nbsp;&nbsp;'
							,'<b>Endereco: &nbsp;</b>{ClienteEndereco}<br/>'
                            ,'<b>Total: &nbsp;</b>{total_nota}<br/>'
							,'</br>'
							];
                            
		PedidoTpl = new Ext.XTemplate(PedidoTemplate);
	

 		dsPedidoItens = new Ext.data.Store({
                url: '../php/FatPedido.php',
                method: 'POST',
        reader:  new Ext.data.JsonReader({
				root: 'Itens',
				//totalProperty: 'total',
				id: 'id',
				fields: [
				   {name: 'id'},
				   {name: 'refer_prod', mapping: 'referencia_prod'},
		           {name: 'desc_prod', mapping: 'descricao_prod'},
		           {name: 'qtd_produto', mapping: 'qtd_produto'},
                   {name: 'pr_venda', mapping: 'prvenda'},
                   {name: 'total_iten', mapping: 'total_iten'}
				
			]
			})
		});
         var gridFatItens = new Ext.grid.GridPanel({
	        store: dsPedidoItens, // use the datasource
	       cm: new xgPedido.ColumnModel([
		       
		            {id:'id', width:40, header: "id", hidden: true, sortable: true, dataIndex: 'id'},
					{id:'refer_prod', width:100, header: "Codigo",  sortable: true, dataIndex: 'refer_prod'},
					{id:'desc_prod', width:130, header: "Descricao",  sortable: true, dataIndex: 'desc_prod'},
					{id:'qtd_produto', width:60, header: "Qtd", align: 'right', sortable: true, dataIndex: 'qtd_produto'},
					{id:'pr_venda', width:80, header: "Valor", align: 'right',  sortable: true, dataIndex: 'pr_venda'},
					{id:'total_iten', width:80, header: "Total",align: 'right',  sortable: true, dataIndex: 'total_iten'}
		
		        ]), 
	        viewConfig:{ 
			forceFit:true
			},
			collapsible: false,
			animCollapse: false,
			enableColLock: false,
			loadMask:true,
			autoWidth:true,
			height: 150,
	        stripeRows:true
            
            });
	
	var formtplPedido = new Ext.Panel({
        frame:false,
        border: true,
		items:[]
	});
	

	var FormPedido = new Ext.FormPanel({
        title: 'Faturar Pedido',
        id: 'FormPedido',
        autoWidth: true,
        autoEl: 'div',
		layout:'form',
		closable:true,
        labelAlign: 'right',
        autoScroll: true,
        items: [ 
                formtplPedido,
                gridFatItens,           
                    new Ext.ux.MaskedTextField({
                    fieldLabel: 'Subtotal',
                    id: 'subtotalFat',
                    readOnly: true,
                    labelWidth: 50,
                    width: 100,
               	    mask:'decimal',
                    textReverse : true
                }),
                
                {
                    xtype: 'numberfield',
                    id: 'valor_entrada',
                    fieldLabel: 'Valor Entrada',
                    col: true,
                    labelWidth: 180,
                    width: 100,
                    allowBlank: false,
                    labelWidth: 100,
                    paddingLeft: 10,
                    mask:'decimal',
                    textReverse : true,
                    enableKeyEvents: true,
                    listeners:{
                    keyup: function(e,type){						
					      CalculaTotal();
			             	}
                    }
                },
                new Ext.ux.MaskedTextField({
                    id: 'valor_debitar',
                    fieldLabel: '<b>Valor Debitar</b>',
                    col: true,
                    labelWidth: 160,
                    readOnly: true,
                    labelAlign: 'right',
                    style: 'color: #E18325',
                    width: 100,
                    paddingLeft: 18,
                    mask:'decimal',
                    textReverse : true
                }),
                {
			     xtype: 'button',
			     id: 'faturar',
                 text: 'Faturar',
                 scale: 'large',
			     width: 20,
			     handler: function(){
			     FormPedido.getForm().submit({
				        url: "php/FatPedido.php",
                        params: {
						  user: id_usuario,
						  acao: 'Faturar',
                          idpedido: idpedidoFat,
                          idForma: idforma
						}
				    , waitMsg: 'Faturando'
				    , waitTitle : 'Aguarde....'
				    , scope: this
				    , success: OnSuccess
				    , failure: OnFailure
			     }); 
			function OnSuccess(form,action){
			     Ext.Msg.alert('Confirmacao', action.result.response);
                 Ext.getCmp('tabss').remove(FormPedido);
                 FatPedido();
			}
			
			function OnFailure(form,action){
			//	alert(action.result.msg);
			}
			}
        }
        ],
        listeners:{
					destroy: function() {
							 sul.remove('gridFatPedido');
         				}
			
		}
		});
        
        CalculaTotal = function(){
                       
            entrada = Ext.getCmp('valor_entrada').getValue();
            if(parseFloat(entrada) > parseFloat(total_nota)){
                alert('Valor maior que o devido, verifique');
                Ext.getCmp('valor_entrada').setValue();
            }
            var valor = parseFloat(total_nota) - parseFloat(entrada);
            Ext.getCmp('valor_debitar').setValue(Ext.util.Format.usMoney(valor));
            
        }
	
	gridFatPedido.on('rowdblclick', function(grid, row, e) {  
					
	Ext.getCmp('tabss').add(FormPedido);
	Ext.getCmp('tabss').setActiveTab(FormPedido);
	FormPedido.doLayout();
	
   PedidoTpl.overwrite(formtplPedido.body, dsFatPedido.getAt(row).data);
       
    idpedidoFat = dsFatPedido.getAt(row).data.idPedido;
    total_nota = dsFatPedido.getAt(row).data.total_nota;
    idforma = dsFatPedido.getAt(row).data.idforma;
    dsPedidoItens.load({params:{acao: 'listarItens',idpedido: idpedidoFat }});
    
    Ext.getCmp('valor_entrada').setDisabled(false);
    FormPedido.getForm().reset();
    Ext.getCmp('valor_entrada').focus();
    
    Ext.getCmp('subtotalFat').setValue(total_nota);
    if(idforma == '1' || idforma == '2' ){
    Ext.getCmp('valor_debitar').setValue(Ext.util.Format.usMoney(total_nota));
    Ext.getCmp('valor_entrada').setDisabled(true);
    }

}); 

	
     FormPedidosFaturar = new Ext.FormPanel({
			id: 'FormPedidosFaturar',
            title       : 'Pedidos Pendentes',
			labelAlign: 'left',
			frame		: true,
			closable:true,
            autoWidth   : true,
			//height	: 350,
            collapsible : false,
			layout:'form',
            items:[gridFatPedido],
            listeners:{
					destroy: function() {
							 tabs.remove('FormPedido');
         				   }
		              }
            });
		
 //   Ext.getCmp('tabss').add(formtplPedido,);
 //   Ext.getCmp('tabss').setActiveTab(formtplPedido);
 //   formtplPedido.doLayout();		
	
	
Ext.getCmp('sul').add(gridFatPedido);
Ext.getCmp('sul').setActiveTab(gridFatPedido);
gridFatPedido.doLayout();	
	
	
	
	
	
}