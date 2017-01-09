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
		           {name: 'estoque_produto', mapping: 'Estoque'}
				
			]
			})					    
			
		})

	     var grid_AcertaEstoque = new Ext.grid.GridPanel({
	        store: dsProdAcerta, // use the datasource
	        cm: new xgProdPesquisa.ColumnModel(
		        [
		        	//expander,
		           		{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header:'Codigo', width: 80, sortable: true, dataIndex: 'codigo_produto'},
						{header: "Descricao", width: 200, sortable: true, dataIndex: 'descricao_produto'},
						{header: "Disponivel", width: 55, align: 'right', sortable: true, dataIndex: 'estoque_produto', renderer: change}
					
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
				
			if(e.getKey() >47 && e.getKey() < 58 || e.getKey() >64 && e.getKey() < 91 || e.getKey() >95 && e.getKey() < 106 ){
 	   					FormAcerto.getForm().findField('cod_prod').focus(); 
			}
			else if(e.getKey() == e.ENTER) {//
			// Carrega O formulario Com os dados da linha Selecionada
			record = grid_AcertaEstoque.getSelectionModel().getSelected();
			
			tabs_prod.show();	
			AcertoTpl.overwrite(formtpl.body, record.data);
			
			idprod = record.data.id;
			
	setTimeout(function(){
	FormAcerto.getForm().findField('cod_prod').focus();
	}, 250);
			
			}
			}}
})

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
			    	,items: [
						 {
							 boxLabel: 'Entrada'
							 , name: 'tipo'
							 , inputValue: 'EN'
							
					    },
						{
							boxLabel: 'Saida'
							, inputValue: 'SA'
							, name: 'tipo'
							, checked: true
							
						}	
					]
				},
				   {
                    xtype:'textfield',
                    fieldLabel: 'Quantidade',
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
										qtd: topprod.getForm().findField('qtd').getValue(),
										tipo: topprod.getForm().findField('tipo').getValue(),
										idProduto: idprod
           								 },
										 success: function(result, request){//se ocorrer correto  
										var jsonData = Ext.util.JSON.decode(result.responseText);
										resposta = jsonData.response;
											//Ext.MessageBox.alert('Aviso', resposta);
											if(jsonData.response == 'Alterado com Sucesso'){
											tabs_prod.hide();
											//FormAcerto.getForm().findField('cod_prod').focus();
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
, closable: false
, frame: true
, width: 400
, autoHeight: true
, closeAction :'hide' //com close a informa��o se perde, com hide n�o.
, plain: true
, modal: true              /* Faz o fundo se tornar n�o editavel*/
, resizable: true
, items: [formtpl,topprod],
	buttons: [{
            text: 'Cerrar',
			handler: function(){
				tabs_prod.hide();
			}
			}
			]
//, focus: function(){
//   Ext.get('qtd').focus();
//}

});


grid_AcertaEstoque.on('rowdblclick', function(grid, row, e) {
										
	tabs_prod.show();					 
    AcertoTpl.overwrite(formtpl.body, dsProdAcerta.getAt(row).data);
		
	idprod = dsProdAcerta.getAt(row).data.id;
		
	setTimeout(function(){
	//top.getForm().findField('qtd').focus();
	}, 250);

}); 
	
tabs_prod.on('hide', function(){
FormAcerto.getForm().findField('cod_prod').focus();
});
	
var FormAcerto = new Ext.FormPanel({
			frame		: true,
            split       : true,
			id			: 'FormAcerto',
			closable	: true,
			title		: 'Acerto Estoque',
            autoWidth   : true,
			//autoHeight	: true,
			labelWidth: 120,
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
                    name: 'cod_prod',
                    width: 250,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
            							dsProdAcerta.load({params:{pesquisa: FormAcerto.getForm().findField('cod_prod').getValue(), acao: 'acao'}});
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
        }); 	
	

Ext.getCmp('tabss').add(FormAcerto);
Ext.getCmp('tabss').setActiveTab(FormAcerto);
FormAcerto.doLayout();	
FormAcerto.getForm().findField('cod_prod').focus();			
}