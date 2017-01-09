// JavaScript Document

AcEstoque = function(){

//if(perm.AcertoEstoque.acessar == 0){
//return Ext.MessageBox.alert('Aviso', 'Voce nao tem acesso a esta tela');
//}
	
    Ext.QuickTips.init();
    Ext.form.Field.prototype.msgTarget = 'side';
	Ext.BLANK_IMAGE_URL = "../ext2.2/resources/images/default/s.gif";	
	//var acerto_estok;	
	var xgProdPesquisa = Ext.grid;	
	var xgProdHist = Ext.grid;



function getKey(e){
	var tecla;
	if(!e)
		e = window.event;
	if(e.keyCode)
		tecla = e.keyCode;
	else if(e.which)
		tecla = e.which;
	return tecla;
}

	function change(val){
        if(val > 0){
            return '<span style="color:blue;font-weight: bold;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;font-weight: bold">' + val + '</span>';
        }
        return val;
    };
	
	
	
 AcertoTemplate = [
'</br>'
,'<b>Codigo: &nbsp;</b>{codigo_produto}<br/>'
,'<b>Descricao: &nbsp;</b>{descricao_produto}<br/>'
,'<b>Estoque: &nbsp;</b>{estoque_produto}<br/>'
,'</br>'
,'<b>Responsavel: &nbsp;</b>'+nome_user+'<br/>'
];
 AcertoTpl = new Ext.Template(AcertoTemplate);
	

 		dsProdAcerta = new Ext.data.Store({
                url: '../php/lista_prod.php',
                method: 'POST',
        reader:  new Ext.data.JsonReader({
				totalProperty: 'totalProdutos',
				root: 'Produtos',
				id: 'id',
				fields: [
				   {name: 'id'},
				   {name: 'codigo_produto', mapping: 'Codigo'},
		           {name: 'descricao_produto', mapping: 'Descricao'},
		           {name: 'estoque_produto', mapping: 'Estoque'},
				   {name: 'stok'},
				   {name: 'baruque_foz'}
				
			]
			})					    
			
		})

	     var grid_AcertaEstoque = new Ext.grid.EditorGridPanel({
	        store: dsProdAcerta, // use the datasource
	        cm: new xgProdPesquisa.ColumnModel(
		        [
		        	//expander,
		           		{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header:'Codigo', width: 80, sortable: true, dataIndex: 'codigo_produto'},
						{header: "Descricao", width: 200, sortable: true, dataIndex: 'descricao_produto'},
						{header: "Fisico", width: 55, align: 'right', sortable: true, dataIndex: 'estoque_produto', renderer: change},
						{header: "Baruque Foz", width: 55, align: 'right', sortable: true, dataIndex: 'baruque_foz', renderer: change,
						 editor: new Ext.form.NumberField({
														 allowBlank: false,
														 selectOnFocus:true,
														 allowNegative: false	
														 })
						},
						{header: "Legal", width: 55, align: 'right', hidden: true,  sortable: true, dataIndex: 'stok', renderer: change,
						 editor: new Ext.form.NumberField({
														 allowBlank: false,
														 selectOnFocus:true,
														 allowNegative: false	
														 })
						}
					
		        ]
	        ), 
	        viewConfig: 
	        {
	            forceFit:true
     	   },
			deferRowRender : false,
			autoWidth: true,
			height: 255,
	        stripeRows:true,
			listeners: {
			keypress: function(e){
			/*
				
			if(e.getKey() >47 && e.getKey() < 58 || e.getKey() >64 && e.getKey() < 91 || e.getKey() >95 && e.getKey() < 106 ){
 	   					Ext.get('cod_prod').focus(); 
			}
			else if(e.getKey() == e.ENTER) {//
			// Carrega O formulario Com os dados da linha Selecionada
			record = grid_AcertaEstoque.getSelectionModel().getSelected();
			
			tabs_prod.show();	
			AcertoTpl.overwrite(formtpl.body, record.data);
			
			idprod = record.data.id;
			
	setTimeout(function(){
	Ext.get('qtd').focus();
	}, 250);
			
			}
			*/
			},
			cellclick: function(grid, rowIndex, columnIndex, e){
            // Pega linha
            //records = grid_AcertaEstoque.getStore().getAt(rowIndex);
            // Pega campo da coluna
            fieldName = grid_AcertaEstoque.getColumnModel().getDataIndex(columnIndex);
            //Valor do campo
            //var data = records.get(fieldName);
           // console.info(fieldName);

         },
		 afteredit:function(e){
			//dsProdAcerta.load(({params:{valor: e.value, acao: 'alterar', idProduto: e.record.get('id'), campo: e.column,  'start':0, 'limit':100}}));
			Ext.Ajax.request({
				url: 'php/AcertoEstoque.php',
				params : {
				valor: e.value, 
				acao: 'alterar', 
				idProduto: e.record.get('id'),
				coluna: fieldName
				}
				});
	  		}
      
			
			}
});

var formtpl = new Ext.Panel({
       // bodyStyle:'background-color:#4e79b2',
		items:[AcertoTpl]
	})

var topprod = new Ext.FormPanel({
        labelAlign: 'left',
        frame:true,
        autoWidth: true,
		labelWidth: 80,
		//autoHeight: true,
        items: [
					{
					xtype       : 'fieldset',
					title       : 'Acerto de Produto',
					//layout      : 'form',
					collapsible : false,                    
					collapsed   : false,
					autoHeight  : true,
					forceLayout : true,
			items:[
				   {
					xtype: 'radiogroup'
					,hideLabel: true
					,name: 'tipo'
					,id: 'tipo'
			    	,items: [
						 {
							 boxLabel: 'Entrada'
							 , inputValue: 'EN'
							
					    },
						{
							boxLabel: 'Saida'
							, inputValue: 'SA'
							, checked: true
							
						}	
					]
				},
				   {
                    xtype:'textfield',
                    fieldLabel: 'Quantidade',
					id: 'qtd',
                    name: 'qtd',
                    width: 100,
					enableKeyEvents: true,
					listeners:{
								keyup:function(field, key){ //alert(key.getKey());
									if(key.getKey() == key.ENTER) {
            							Ext.Ajax.request({
            							url: '../php/AcertoEstoque.php', 
            							params : {
			   							user : id_usuario,
										acao: 'Acertar',
										qtd: Ext.getCmp('qtd').getValue(),
										tipo: Ext.getCmp('tipo').getValue(),
										idProduto: idprod
           								 },
										 success: function(result, request){//se ocorrer correto  
										var jsonData = Ext.util.JSON.decode(result.responseText);
										resposta = jsonData.response;
											//Ext.MessageBox.alert('Aviso', resposta);
											if(jsonData.response == 'Alterado com Sucesso'){
											tabs_prod.hide();
											Ext.get('cod_prod').focus();
											dsProdAcerta.reload();
											topprod.form.reset();
										}
										}
														 })
				 					}         
									}
									}
					}
					]
					},
					{
					html: '<b>*Enter para Confirmar</b>'
					}
					]
	})


tabs_prod = new Ext.Window({
 title: "Acertar Estoque"
, layout: 'form'
, frame: true
, width: 400
, autoHeight: true
, closeAction :'hide' //com close a informa��o se perde, com hide n�o.
, plain: true
, modal: true              /* Faz o fundo se tornar n�o editavel*/
, resizable: true
, items: [formtpl,topprod]
//, focus: function(){
//   Ext.get('qtd').focus();
//}

});


grid_AcertaEstoque.on('rowdblclick', function(grid, row, e,columnIndex) {

	if ( fieldName != 'baruque_foz'){
	//console.info(fieldName);
	tabs_prod.show();					 
    AcertoTpl.overwrite(formtpl.body, dsProdAcerta.getAt(row).data);
		
	idprod = dsProdAcerta.getAt(row).data.id;
		
	setTimeout(function(){
	Ext.get('qtd').focus();
	}, 250);
	
	dsAcertaHist.load({params:{idprod: idprod, acao:'listarHist'}});
}
	
}); 
	
tabs_prod.on('hide', function(){
Ext.get('cod_prod').focus();
});
	
		
		dsAcertaHist = new Ext.data.Store({
                url: '../php/AcertoHist.php',
                method: 'POST',
        reader:  new Ext.data.JsonReader({
				root: 'result',
				id: 'idacerto_estoque',
				fields: [
				   {name: 'idacerto_estoque'},
				   {name: 'id_produto'},
		           {name: 'qtd_anterior'},
		           {name: 'qtd_informada'},
				   {name: 'tipo_es'},
				   {name: 'nome_user'},
				   {name: 'qtd_final'},
				   {name: 'data_acerto'},
				   {name: 'motivo'}
				
			]
			})					    
			
		});
		var grid_AcertaHist = new Ext.grid.EditorGridPanel({
	        store: dsAcertaHist, // use the datasource
	        cm: new xgProdHist.ColumnModel(
		        [
		        	//expander,
		           		{id:'idacerto_estoque',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'idacerto_estoque'},
						{header:'Movimento', width: 100, sortable: true, dataIndex: 'tipo_es'},
						{header: "Cant Anterior", width: 60, sortable: true, dataIndex: 'qtd_anterior'},
						{header: "Cant Informada", width: 60, align: 'left', sortable: true, dataIndex: 'qtd_informada'},
						{header: "Cant Nueva", width: 60, align: 'right', sortable: true, dataIndex: 'qtd_final'},
						{header: "Fecha", width: 70, align: 'right', sortable: true, dataIndex: 'data_acerto'},
						{header: "Usuario", width: 60, align: 'right', sortable: true, dataIndex: 'nome_user'},
						{header: "Motivo", width: 150, align: 'left', sortable: true, dataIndex: 'motivo'}
		        ]
	        ), 
	        viewConfig: 
	        {
	            forceFit:true
     	   },
			deferRowRender : false,
			autoWidth: true,
	        stripeRows:true,
			listeners: {
			keypress: function(e){

			},
			cellclick: function(grid, rowIndex, columnIndex, e){

			},
			afteredit:function(e){
			
	  		}
      
			
			}
})
		
	var	FormAcerto = new Ext.FormPanel({
			layout     : 'border',
			title      : 'Acerto Estoque',
		    autoWidth: true,
			closable: true,
			id: 'produtos_pedidopAdd',
	        frame:true,
			items: [
			{
			region: 'north',
			width: '100%',
			layout: 'fit',
			height: 300,
			items:[
				{
					xtype       : 'fieldset',
					title       : 'Entre com o Codigo do Produto',
					collapsible : false,                    
					collapsed   : false,
					autoHeight  : true,
					forceLayout : true,
			items:[
				   {
                    xtype:'textfield',
                    fieldLabel: 'Codigo do Produto',
					id: 'cod_prod',
                    name: 'cod_prod',
                    width: 250,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
            							dsProdAcerta.load({params:{pesquisa: Ext.get('cod_prod').getValue(),campo: 'Codigo', acao: 'acao'}});
				 					}         
									
							if(e.getKey() == 40  ){//seta pra baixo  
							   grid_AcertaEstoque.getSelectionModel().selectFirstRow();
							   grid_AcertaEstoque.getView().focusEl.focus();
                            }
								}
									}
					//}
					
					]
			},
			grid_AcertaEstoque
			]
			},
			{
			region: 'center',
			width: 400,
			//autoHeight: true,
			layout: 'fit',
			autoScroll:true,
			//height: 300,
			items:[grid_AcertaHist]
			}
			],
			listeners:{
					destroy: function() {
							 tabs_prod.destroy();

         				}
			
		}
			});
	

Ext.getCmp('tabss').add(FormAcerto);
Ext.getCmp('tabss').setActiveTab(FormAcerto);
FormAcerto.doLayout();	
}