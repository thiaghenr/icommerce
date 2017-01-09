<?php
require_once("verifica_login.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pedido</title>

	<link rel="stylesheet" type="text/css" href="ext-3.2.1/resources/css/ext-all.css" />
	<script type="text/javascript" src="ext-3.2.1/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="ext-3.2.1/ext-all.js"></script>
	<script type="text/javascript" src="js/override.js"></script>
    <script type="text/javascript" src="js/MaskedTextField-0.5.js"></script>
	<link rel="stylesheet" type="text/css" href="css/forms.css"/>
	
	<link rel="stylesheet" type="text/css" href="css/summary.css"/>
	<link rel="stylesheet" type="text/css" href="css/Ext.ux.grid.RowActions.css"/>
	<script type="text/javascript" src="js/Ext.ux.grid.RowActions.js"></script>
	<script type="text/javascript" src="js/GroupSummary.js"></script>
    <link rel="stylesheet" type="text/css" href="resources/css/xtheme-slate.css" />
	

</head>
<style type="text/css">
body {
font-family: "Trebuchet MS", Verdana, Arial;
font-size: 12px;
color: #006;
background-image: url(images/fundo.gif);
}
</style>

<script language="javascript">
Ext.onReady(function() {
    Ext.QuickTips.init();
    Ext.form.Field.prototype.msgTarget = 'side';
Ext.BLANK_IMAGE_URL = "ext-3.1.1/resources/images/default/s.gif";	

Ext.override(Ext.Button, {
		initComponent: Ext.Button.prototype.initComponent.createSequence(function(){
		
			if(this.menu){
				this.menu.ownerBt = this;
			}
		})
	})
	
	 Ext.state.Manager.setProvider(new Ext.state.CookieProvider());

id_usuario = "<?=$_SESSION['id_usuario']?>";
nome_user = "<?=$_SESSION['nome_user']?>";
host = "<?=$_SERVER['REMOTE_ADDR']?>"; 

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
// Função que trata exibição do Ativo S = Sim e N = Não
var formataAtivo = function(value){
	if(value=='S')
		  return 'Sim';
		else if(value=='N')
		  return '<span style="color: #FF0000;">N&atilde;o</span>';
		else
		  return 'Desconhecido'; 
};
function change(val){
        if(val > 0){
            return '<span style="color:green;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;">' + val + '</span>';
        }
        return val;
    };
	
function FDesconto(){

			var desconto = tot.getForm().findField('Desconto').getValue(); //Ext.getCmp('Desconto').getValue();
			alert(desconto);
		    var subtotal = Ext.getCmp('SubTotal').getValue();
			desconto = desconto.replace(",",".");
				if(parseFloat(desconto) > 100){
					Ext.MessageBox.alert('Alerta', 'Descuento no Permitido', function(btn){
						if(btn == "ok"){
							Ext.getCmp('Desconto').focus();
						} })
				}
				if(desconto < 100){ 
					desconto = (parseFloat(subtotal) * parseFloat(desconto)) / 100;
										
					Ext.getCmp('valorDesc').setValue(Ext.util.Format.usMoney(desconto));
					Geral = subtotal - desconto;
					Ext.getCmp('Total').setValue(Ext.util.Format.usMoney(Geral));
				//	dsProds.reload();
					Ext.getCmp('CodigoProduto').focus();
					}

					}
function f(arr){
    var elements = []
        for (var x=0; x<arr.length; x++){
            var gambi = arr[x].toFixed(2)
            gambi = gambi.toString()
            elements.push(gambi.replace(/\./, ","))
        }
        return elements        
    }
function FdescVal(){
					valorDesc = (Ext.getCmp('valorDesc').getValue());
					valorDesc = valorDesc.replace(",",".");
					subtotal = parseFloat(Ext.getCmp('SubTotal').getValue());
					
					if(parseFloat(valorDesc) > parseFloat(subtotal)){
					Ext.MessageBox.alert('Alerta', 'Descuento no Permitido', function(btn){
						if(btn == "ok"){
							Ext.getCmp('Desconto').focus();
						} })
					}
				
					if(valorDesc < subtotal){ 
					porcentagem = ((parseFloat(valorDesc) / subtotal) * 100) ;
										
					//Ext.getCmp('Desconto').setValue(porcentagem);
					Geral = subtotal - valorDesc;
					Ext.getCmp('Total').setValue(Ext.util.Format.usMoney(Geral));
				//	dsProds.reload();
					Ext.getCmp('CodigoProduto').focus();
					}


}



Ext.override(Ext.grid.EditorGridPanel, {
initComponent: Ext.grid.EditorGridPanel.prototype.initComponent.createSequence(function(){
this.addEvents("editcomplete");
}),
onEditComplete: Ext.grid.EditorGridPanel.prototype.onEditComplete.createSequence(function(ed, value, startValue){
this.fireEvent("editcomplete", ed, value, startValue);
})
});

function showResultProd(btn){
       Ext.get('CodigoP').focus();
    }		
function showResultCli(btn){
       Ext.get('controleCliP').focus();
    }	
function showResultNew(btn){
       Ext.get('CodigoProduto').focus();
    }	

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
     // Ext.Msg.alert('Ação', String.format('Ação disparada: {0}<br> linha: {1}<br> coluna: {2}', action, row, record) );  console.info(record);
	  dsProds.remove(record);
	  Ext.getCmp("CodigoProduto").focus();
	 
   }
});

 var xgCli = Ext.grid;
 var xgProdPesquisa = Ext.grid;
 var xgProdPesquisa;
// var controle;
 var xgprod = Ext.grid;
 var expander;
 var msg;
 var dsProds;
 var idData;
 var imagem;
 var Codigo = "codigo";
 var Nome = "nomecli";
 
FinPedido = function(){
	if( Ext.get("idforma").getValue() != '' && Ext.get("usuario_id").getValue() != ''){	
			
	var jsonData = [];
	// Percorrendo o Store do Grid para resgatar os dados
	dsProds.each(function( record ){
    // Recebendo os dados
    jsonData.push( record.data );
	});
	jsonData = Ext.encode(jsonData)
		 Ext.Ajax.request({
           					url: 'php/insere_pedido.php',
							method: 'POST',
							remoteSort: true,
           					params: {
							acao: 'FinPedido', 
							user: id_usuario,
							desconto: tot.getForm().findField('valorDesc').getValue(), //Ext.get("valorDesc").getValue(),
							subtotal: Ext.get("SubTotal").getValue(),
							dados: jsonData,
							host: host,
							formaPgto: Ext.get("idforma").getValue(),
			    			clienteIns: controle,
							usuario_id:  formFinalisar.getForm().findField('idusuario').getValue(),
							vendedor: Ext.get("idvendedor").getValue(),
							passvend: Ext.getCmp("password").getValue()
            					},
								callback: function (options, success, response) {
										if (success) { 
											Ext.MessageBox.alert('OK', response.responseText);
											var jsonData = Ext.util.JSON.decode(response.responseText);
												if(jsonData.del_count){
													
													mens = jsonData.del_count + " Itens Inseridos. Pedido N: " + jsonData.Pedido;
													window.open('impressao.php?id_pedido='+jsonData.Pedido +'','popup','width=750,height=500,scrolling=auto,top=0,left=0');
													window.location.reload();
												}
												 if(jsonData.response == 'Confirme su password'){ 
												//	alert(jsonData.response);
												Ext.getCmp('password').focus();
												}
											//	Ext.MessageBox.alert('Alerta', mens);
											//	window.location.reload();
											
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										//	if(jsonData.response == 'Confirme su password'){ 
										//	alert(jsonData.response);
										//	Ext.getCmp('password').focus();
										//	}
										}
								
							//	dsProds.removeAll();
							//	dsProdVend.removeAll();
							//	formCliente.form.reset();
							//	formFinalisar.form.reset();
							//	tot.form.reset();
							//	Ext.getCmp('fin').setDisabled(true);
							//	finalisar.hide();
							//	window.open('impressao.php?id_pedido='+jsonData.Pedido +'','popup','width=750,height=500,scrolling=auto,top=0,left=0')
							//	}
								
							//	}
						  });
	}
	else{
		Ext.MessageBox.alert('Erro','Campo Obligatorio.');
	}
	}
	
	FinConsig = function(){
//	mov = formConsignacao.getForm().findField('movcons').getValue();
	vend = formConsignacao.getForm().findField('idvendedor').getValue();
	if(vend != ''){	
		
	var jsonData = [];
	// Percorrendo o Store do Grid para resgatar os dados
	dsProds.each(function( record ){
    // Recebendo os dados
    jsonData.push( record.data );
	});
	jsonData = Ext.encode(jsonData)
		 Ext.Ajax.request({
           					url: 'php/insere_consignacao.php',
							method: 'POST',
							remoteSort: true,
           					params: {
							acao: 'FinConsig', 
							user: id_usuario,
							total: Ext.get("SubTotal").getValue(),
							dados: jsonData,
							movimento: 'Salida',
							host: host,
			    			clienteIns: controle,
							vendedor: vend,
							passvend: formConsignacao.getForm().findField('passwordcons').getValue()
            					},
								callback: function (options, success, response) {
										if (success) { 
											Ext.MessageBox.alert('OK', response.responseText);
											var jsonData = Ext.util.JSON.decode(response.responseText);
												if(jsonData.del_count){
													
													mens = jsonData.del_count + " Itens Inseridos. Consignacion N: " + jsonData.Pedido;
													window.open('consig_imp.php?id_pedido='+jsonData.Pedido +'','popup','width=750,height=500,scrolling=auto,top=0,left=0');
													window.location.reload();
												}
												 if(jsonData.response == 'Confirme su password'){ 
												//	alert(jsonData.response);
												Ext.getCmp('password').focus();
												}
											//	Ext.MessageBox.alert('Alerta', mens);
											//	window.location.reload();
											
											}
											else {
												Ext.MessageBox.alert('Sorry, please try again. [Q304]',response.responseText);
											}
										//	if(jsonData.response == 'Confirme su password'){ 
										//	alert(jsonData.response);
										//	Ext.getCmp('password').focus();
										//	}
										}
								
							//	dsProds.removeAll();
							//	dsProdVend.removeAll();
							//	formCliente.form.reset();
							//	formFinalisar.form.reset();
							//	tot.form.reset();
							//	Ext.getCmp('fin').setDisabled(true);
							//	finalisar.hide();
							//	window.open('impressao.php?id_pedido='+jsonData.Pedido +'','popup','width=750,height=500,scrolling=auto,top=0,left=0')
							//	}
								
							//	}
						  });
	
	}
	
	else{
		Ext.MessageBox.alert('Erro','Campo Obligatorio.');
	
	}
		}
	
		var storeCliente = new Ext.data.Store({
	 	  url: 'php/lista_cli.php',
          waitMsg:'Carregando...',
          method: 'POST',
          baseParams:{acao: "BuscaCodigo"},
		  listeners:{
   				load:function(){
      			formCliente.getForm().loadRecord( storeCliente.getAt(0) );
				descmax = storeCliente.getAt(0).get('descmax');
  			 }
			},
		  reader: new Ext.data.JsonReader({
             root: 'results',
			 remoteSort: true,
             fields: [
              {name: 'controleCliP', mapping: 'controle'},
              {name: 'nome'},
              {name: 'endereco'},
			  {name: 'ruc'},
			  {name: 'descmax'}
              ]
            })
			

	});		
	
	var formCliente = new Ext.FormPanel({
        labelAlign: 'left',
		renderTo: 'formCli',
		ds: storeCliente,
        frame:true,
        title: 'Datos del Cliente',
        bodyStyle:'padding:5px 5px 0',
		height: 55,
		width: '100%',
		iconCls:'user-red',
		autoScroll:false,
        items: [{
                    xtype:'textfield',
                    fieldLabel: 'Codigo',
                    name: 'controleCliP',
					dataIndex: 'controleCliP',
					height: 16,
					id: 'controleCliP',
					labelWidth: 40,
                    width: 50,
					//width: 200,
					fireKey: function(e,type){
							if(e.getKey() == e.ENTER && Ext.get('controleCliP').getValue() != '') {
								controle = Ext.getCmp('controleCliP').getValue();
					  			setTimeout(function(){
                      			storeCliente.load({params: {query: controle}});
								 }, 250);
							}
							if(e.getKey() == e.ENTER ) {
							     controle = Ext.getCmp('controleCliP').getValue();
							//Ext.getCmp('sitCodigoPedido').setValue('controle');
								// Ext.getCmp('queryPedido').setValue(controle);
							 Ext.getCmp('queryPedido').setValue(Ext.getCmp('controleCliP').getValue());
							 Ext.getCmp('CodigoProduto').focus(); 
							 
							}	
				}
                }
				,
				{
                    xtype:'textfield',
                    fieldLabel: 'Nombre',
                    name: 'nome',
					id: 'nome',
					dataIndex:'nome',
					height: 16,
                    width: 120,
					labelWidth: 45,
					col: true,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							  select_cli_pedido.show();
							  nomecliente = Ext.getCmp('nome').getValue();
							  campo = 'nome';
							 //  Ext.getCmp('sitCodigoPedido').setValue('nome');
							 //  Ext.getCmp('queryPedido').setValue(nomecliente);
							   Ext.getCmp('queryPedido').setValue(Ext.getCmp('nome').getValue());
							   dsCliPedido.load({params:{query: Ext.getCmp('nome').getValue(), combo: campo}});
                            }}
                
				
				},
				
				{
                    xtype:'textfield',
                    fieldLabel: 'Ruc',
					height: 16,
                    name: 'ruc',
					id: 'ruc',
					labelWidth: 22,
                    width: 100,
					col: true,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('Descricao').focus();
                            	}
								}
                		}
					
				]
				
	});
	//	 storeCliente.on('load', function(grid, record, action, row, col, rowIndex) {
	//	 descmax = storeCliente.getAt(0).get('descmax');
	//	 console.info(descmax);
	//	 });
	
			dsCliPedido = new Ext.data.Store({
			url: 'php/lista_cli.php',
		    method: 'POST',
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
						 {name: 'cidade',  type: 'string' },
						 {name: 'descmax',  type: 'string' }
						 ]
			})					    
			
		})			
		
		     var grid_listacli = new Ext.grid.GridPanel({
	        store: dsCliPedido, // use the datasource
	        cm: new xgCli.ColumnModel(
		        [
		        	//expander,
		            {id:'controleCliP', width: 40, header: "Codigo",  sortable: true, dataIndex: 'controleCliP'},
		            {id:'nome', width: 200, header: "Nome",  sortable: true, dataIndex: 'nome'},
					{id:'telefonecom', width: 90, header: "Fone",  sortable: true, dataIndex: 'telefonecom'},
					{id:'ruc', width: 90, header: "Ruc",  sortable: true, dataIndex: 'ruc'},
					{id:'ativo', width: 20, header: "Ativo",  sortable: true, dataIndex: 'ativo', renderer: formataAtivo},
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
					{id:'cidade', width:'20', header: "Cidade", hidden: true,  sortable: true, dataIndex: 'cidade'},
					{id:'descmax', width:'20', header: "descmax", hidden: true,  sortable: true, dataIndex: 'descmax'}
					
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
	        iconCls:'icon-grid',
			listeners: {
			keypress: function(e){
				
			if(e.getKey() >47 && e.getKey() < 58 || e.getKey() >64 && e.getKey() < 91 || e.getKey() >95 && e.getKey() < 106 ){
 	   					Ext.get('queryPedido').focus(); 
			}
			else if(e.getKey() == e.ENTER) {//
			// Carrega O formulario Com os dados da linha Selecionada
			record = grid_listacli.getSelectionModel().getSelected();
			
			formCliente.getForm().loadRecord(record);	
			idName = grid_listacli.getColumnModel().getDataIndex(0); // Get field name
			controle = record.get(idName);
			//controle = dsCliPedido.getAt(0).get('controleCliP');
		//	console.info(controle);
			descmax = dsCliPedido.getAt(0).get('descmax');
//console.info(descmax);
			select_cli_pedido.hide() 
			dsProds.load(({params:{'cliente':controle, 'user': id_usuario}}));
		//	addnovoProd();
			setTimeout(function(){
			Ext.get('CodigoProduto').focus();
			}, 250);
			
			}
			}}
			
	    });
		
//////////////////// GRID DA PESQUISA DE PRODUTOS //////////////////////////////////////////////////////////////

 		dsProdPedido = new Ext.data.Store({
                url: 'php/lista_prod_pedido.php',
              //  method: 'POST'
								
            reader:  new Ext.data.JsonReader({
				totalProperty: 'totalProdutos',
				root: 'resultsProdutos',
				id: 'id',
				fields: [
				   {name: 'id'},
				   {name: 'custo'},
				   {name: 'Codigo_Fabricante'},
				   {name: 'Codigo'},
		           {name: 'Descricao'},
		           {name: 'Estoque'},
				   {name: 'peso'},
		           {name: 'qtd_bloq'},
		           {name: 'valorA', mapping: 'valor_a'},
				   {name: 'valorB', mapping: 'valor_b'}
				
			]
			})					    
			
		})
 	     var grid_listaProdDetalhes = new Ext.grid.GridPanel({
	        store: dsProdPedido, // use the datasource
	        cm: new xgProdPesquisa.ColumnModel(
		        [
		        	//expander,
		           		{id:'id',header: "id", hidden: true, width: 2, sortable: true, dataIndex: 'id'},
						{header: "custo", hidden: true, width: 2, sortable: true, dataIndex: 'custo'},
						{header: "Referencia",width: 70, hidden: false, dataIndex: 'Codigo_Fabricante'},
						{header:'Codigo', width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descricao", width: 200, sortable: true, dataIndex: 'Descricao'},
						{header: "Peso", width: 55, sortable: true, dataIndex: 'peso'},
						{header: "Disponivel", width: 55, align: 'right', sortable: true, dataIndex: 'Estoque', renderer: change},
						{header: "Bloqueados", width: 55,  align: 'right',  sortable: true, dataIndex: 'qtd_bloq'},
						{header: "Valor A", width: 80, align: 'right', sortable: true, dataIndex: 'valorA', renderer: 'usMoney'},
						{header: "Valor B", width: 80, align: 'right', sortable: true, dataIndex: 'valorB'}	        
					
		        ]
	        ), 
	        viewConfig: 
	        {
	            forceFit:true
	        },
	        
	        plugins: expander,
			//collapsible: true,
			animCollapse: false,
			deferRowRender : false,
			height: 200,
			//autoHeight: true,
	        stripeRows:true,
			//selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
			listeners: {
			keypress: function(e){
						if(e.getKey() == e.ENTER) {//
						// Carrega O formulario Com os dados da linha Selecionada
						record = grid_listaProdDetalhes.getSelectionModel().getSelected();
						//tabs.getForm().loadRecord(record);	
						var idName = grid_listaProdDetalhes.getColumnModel().getDataIndex(0); // Get field name
						var idData = record.get(idName);
						
						var Record = Ext.data.Record.create(['idprod','codigo', 'grupo','descricao','qtd_produto','prvenda','lucro','custo','totals']);
					//	precio = record.data.valorB;
					//	precio = parseFloat(precio.replace(".",""));
					//	custoa =  record.data.custo;
					//	valorvenda = record.data.valorA;
					//	valorlucro = valorvenda - custoa;
					//	lucroini = 100*valorlucro/custo;
					//	lucroini = lucroini.toFixed(2);
						var dados = new Record({
								"idprod":record.data.id,
								"codigo":record.data.Codigo, 
								"descricao":record.data.Descricao,
								"qtd_produto":"1",
								"grupo": Ext.getCmp('controleCliP').getValue(),
								"prvenda": record.data.valorA,
								"custo": record.data.custo,
								"totals":record.data.precio,
								"totalProds":""
								});
								//secondGrid.startEditing(0,3);
								record = grid_listaProdDetalhes.getSelectionModel().getSelected();
							//	console.info(dados);
								dsProds.insert(0,dados);
								gridProd.startEditing(0,6);
								Ext.getCmp('fin').setDisabled(false)			
	
							}
						}
			
					}
				    });	
		

		
		grid_listaProdDetalhes.addListener('keydown',function(event){
		   getItemRow(this, event);
		});

function getItemRow(grid, event){
			key = getKey(event);
			//console.info(event);
			var idData = prodId; 
			   if(key >47 && key < 58 || key >64 && key < 91 ){
							Ext.getCmp("DescricaoProduto").focus();
   }
	else if(key >95 && key < 106 ){
		Ext.getCmp("CodigoProduto").focus();
   }
  else if(key==120){
	 //gridDetProd.hide();
	 //gridDetProdVend.hide();
   }
   
  // else if(key==75){ win_list.show(); }
}
	

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
	        frame:false,
	        bodyStyle:'padding:5px 5px 0',
	        defaults: {width: 230},
	        defaultType: 'textfield',
			items: [
				
					{
					xtype:'textfield',
	                fieldLabel: 'Nombre',
	                name: 'queryPedido',
					id: 'queryPedido',
	                allowBlank:true,
						fireKey: function(el,type){
							if(el.getKey() == 40  ){//seta pra baixo  
							   grid_listacli.getSelectionModel().selectFirstRow();
							   grid_listacli.getView().focusEl.focus();
                            }
							if(el.getKey() == el.ENTER) {
							var theQuery= Ext.getCmp('queryPedido').getValue();
							//if(theQuery.length > 2)
							dsCliPedido.load({params:{query: theQuery, combo: 'nome'}});
						}
					}
	            }
	        ]	
 });

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
		
		var	PesquisaProd = new Ext.FormPanel({
		    width:'100%',
			title: 'Produtos',
			id: 'PesquisaProd',
			layout      : 'form',
			renderTo: 'DivPesquisaProd',
	       // frame:true,
			border: false,
	        bodyStyle:'padding:5px 5px 0',
			items: [
	 				{
            layout:'column',
			border: false,
            items:[{
                columnWidth:.2,
                layout: 'form',
				labelWidth: 30,
				labelWidth: 40,
				border: false,
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Codigo',
                    name: 'CodigoProduto',
					id: 'CodigoProduto',
					selectOnFocus: true,
                    width: 100,
					fireKey: function(e,type){
							if(e.getKey() == e.ENTER && Ext.getCmp('CodigoProduto').getValue() == '') {
							 //dsProdPedido.load({params:{query: theQueryProds,combo: combo01Pedidoprod.getValue()}});
							}
							var theQueryProds = Ext.getCmp('CodigoProduto').getValue(this);
							if(e.getKey() == e.ENTER && Ext.getCmp('CodigoProduto').getValue() != '') {
							dsProdPedido.load({params:{query: theQueryProds,combo: 'Codigo'}});
							}
							if(e.getKey() == 40  ){//seta pra baixo  
							   grid_listaProdDetalhes.getSelectionModel().selectFirstRow();
							   grid_listaProdDetalhes.getView().focusEl.focus();
                            }
						}
                }
				]
				},
				{
                columnWidth:.3,
                layout: 'form',
				labelAlign: 'left',
				labelWidth: 65,
				border: false,
                items: [{
                    xtype:'textfield',
                    fieldLabel: 'Descripcion',
                    name: 'DescricaoProduto',
					id: 'DescricaoProduto',
					selectOnFocus: true,
					width: 200,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							var theQueryProds = Ext.getCmp('DescricaoProduto').getValue(this);
							dsProdPedido.load({params:{query: theQueryProds,combo: 'Descricao'}});
                            }
							if(e.getKey() == 40  ){//seta pra baixo  
							   grid_listaProdDetalhes.getSelectionModel().selectFirstRow();
							   grid_listaProdDetalhes.getView().focusEl.focus();
                            }
							}
                }
				]
				}
				
				]
				},grid_listaProdDetalhes]
					
					 
					 });


 var gridFormItens = new Ext.BasicForm(
		Ext.get('form8'),
		{
			});
			///////GRID DOS PRODUTOS/////////////////////
 dsProds = new Ext.data.GroupingStore({
			 proxy: new Ext.data.HttpProxy({
                url: 'php/lista_car_pedido.php',
                method: 'POST'
				}),
				groupField:'grupo',
				sortInfo:{field: 'idprod', direction: "DESC"},
				nocache: true,
 reader:  new Ext.data.JsonReader({
				totalProperty: 'totalProd',
				root: 'resultProd',
				id: 'idprod',
				fields: [
						 {name: 'action1', type: 'string'},
						 {name: 'idprod',  mapping: 'idprod',  type: 'string' },
						 {name: 'codigo',  mapping: 'Codigo' },
						 {name: 'grupo' },
						 {name: 'descricao',  type: 'string' },
						 {name: 'prvenda', type: 'float' },
						 {name: 'qtd_produto'},
						 {name: 'totals'},
						 {name: 'lucro',type:'percent'},
						 {name: 'custo'},
						 {name: 'totalProds'}
						 ]
			})					    
		});

	// define a custom summary function
     Ext.grid.GroupSummary.Calculations['totalProds'] = function(v, record, field){
	//	precio = record.data.valorB;
	//	precio = precio.replace(".","");
		var v = v+ (parseFloat(record.data.prvenda) * parseFloat(record.data.qtd_produto));   //toNum
		Ext.getCmp("SubTotal").setValue((v));
	   // subnota =  Ext.get("SubTotal").getValue();
		//var frete = Ext.get("Frete").getValue();
		//var desc = Ext.get("valorDesc").getValue();

	
		//var freteA = frete.replace(".","");
		//var freteB = freteA.replace(",",".");
				
		subtotal =  v ;
		//geral = totalnota - desc
		Ext.getCmp("Total").setValue(Ext.util.Format.usMoney(v));
		return v;
		
    }
		
function formata(){
var val_01 = "32.345";
var val_02 = "678.90";

var soma=val_01+val_02;

var pon=soma.indexOf(".");


document.nome_do_formulario.nome_do_campo.value=soma.substr(0,pon+3);

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
		{id: 'codigo', header: 'Codigo', summaryType: 'count', width: 180, dataIndex: 'codigo' },
		{id: 'grupo', header: 'grupo', width: 200, dataIndex: 'grupo', hidden: true },
		{id: 'idprod', header: 'idprod',  width: 200, hidden: true, dataIndex: 'idprod'},		
		{id: 'descricao',  header: 'Descripcion', width: 270, dataIndex: 'descricao'},
		{id: 'prvenda', header: "Precio", dataIndex: 'prvenda',  width: 100, align: 'right',renderer: 'usMoney',
			editor: new Ext.form.NumberField(  
						{
						allowBlank: false,
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
		{id: 'lucro',  header: 'Lucro', width: 70, dataIndex: 'lucro',renderer: function(v, params, record){
                lucroini =  (100*(record.data.prvenda-record.data.custo))/record.data.custo;
				lucroini = lucroini.toFixed(2);
				return lucroini+'%';
                }},
		{id: 'custo',  header: 'custo', width: 70, dataIndex: 'custo',hidden: true },
				{
	  			id: 'totals',
                header: "Total",
                width: 100,
				align: 'right',
                sortable: false,
				fixed:true,
                groupable: false,
                renderer: function(v, params, record){
                val = Ext.util.Format.usMoney( (parseInt(record.data.prvenda)) * (parseFloat(record.data.qtd_produto)))
				 return val;
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
   height:228,
   title: 'Itens del Pedido',
   border: true,
   renderTo: 'gridPedidos',
   moveEditorOnEnter: true,
   plugins: [summary,action],
   loadMask: true,
   clicksToEdit:1,
   listeners:{
      afteredit:function(e){
        
	      },
	  editcomplete:function(ed,value){
	  setTimeout(function(){
	  if(ed.col == 7){				
	 	  Ext.getCmp("CodigoProduto").focus();
	  }
	  if(ed.col == 6 ){				
	  gridProd.startEditing(ed.row,ed.col+1);
	  //ed.value = 5000;
	  }
	   }, 250);
	  },
	  celldblclick: function(grid, rowIndex, columnIndex, e){
           
		}
   		}
}); 

grid_listacli.on('rowdblclick', function(grid, row, e) {
	// Carrega O formulario Com os dados da linha Selecionada
	formCliente.getForm().loadRecord(dsCliPedido.getAt(row));	
	descmax = dsCliPedido.getAt(row).get('descmax');
	controle = dsCliPedido.getAt(row).get('controleCliP');
//console.info(controle);
			record = grid_listacli.getSelectionModel().getSelected();
			var idName = grid_listacli.getColumnModel().getDataIndex(0); // Get field name
			var idData = record.get(idName);
			
			
			
	select_cli_pedido.hide()
	dsProds.load(({params:{'cliente':idData, 'user': id_usuario}}));
	Ext.get('CodigoProduto').focus();
		
}); 

gridProd.getSelectionModel().on('cellselect', function(sm, rowIndex, colIndex) {
    var record = gridProd.getStore().getAt(rowIndex);
	idcar = record.data.idcarrinho;
	
	}, this);
	
//////// INICIO DA GRID DOS VENDIDOS ////////
var dsProdVend = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod_det_vend.php',
			method: 'POST'
		}), 
		listeners:{
   				load:function(){
				//imagem = dsProdVend.getAt(0).get('imagem');
				// console.info(imagem);
  			 }
			},  
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
				   {name: 'imagem'},
				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		remoteSort: true		
	});
	
 var gridProdVend = new Ext.grid.EditorGridPanel({
	        store: dsProdVend, // use the datasource
	        columns:[
						{id:'id',header: "Pedido", width: 50, sortable: true, dataIndex: 'idped'},
						{header: 'Codigo', width: 80, sortable: true, dataIndex: 'controle_cli'},
						{header: "Nome", width: 230, sortable: true, dataIndex: 'nome_cli'},
						{header: "Data", width: 90, align: 'right', sortable: true, dataIndex: 'data_car', renderer: change},
						{header: "Qtd", width: 80,  align: 'right',  sortable: true, dataIndex: 'qtd_produto'},
						{header: "Valor", width: 90, align: 'right', sortable: true, dataIndex: 'prvenda', renderer: 'usMoney'}
			 ],
	        viewConfig:{
	            forceFit:true
	        },
			width:'100%',
			id: 'prodsVd',
			height: 101,
			ds: dsProdVend,
			loadMask: true,
			enableColLock: false,
	        stripeRows:true,
			autoScroll: true
		});
 ////////FIM GRID DOS DETALHES ///////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////
var Barrafinal = new Ext.Panel({
			frame: false,
			//bodyStyle:'background-color:#4e79b2',
			width       : '100%',
			//height      : 27,
			renderTo 	: 'formFinal',
			items: [],
			bbar : new Ext.Toolbar({ 
			items: [			   
         	            
           				{
						xtype:'button',
           			    text: 'Venta',
						id: 'fin',
						align: 'left',
						scale: 'large',
						iconCls: 'icon-save',
						disabled: true,
            			handler: function(){
							finalisar.show();	
					}						
  			 		},
					'-',
						{
						xtype:'button',
           			    text: 'Cancelar',
						id: 'canc',
						align: 'left',
						iconCls: 'icon-cancel',
            			handler: function(){ // fechar	
     	    			CancPedido();
						}
  			 			},
						'-',
						{
						xtype:'button',
           			    text: 'Consignacion',
						align: 'left',
						iconCls: 'icon-consig',
            			handler: function(){ // fechar	
     	    			Consignacao.show();
						}
  			 			}
						
						,'-'
						, '<b>&nbsp;&nbsp;&nbsp;Usuario Logado:</b>',nome_user
		
		] 
						   }) 
			});
			
	var xd = Ext.data;	

 	 var tot = new Ext.FormPanel({
			title       : '',
            region    : 'south',
			frame: true,
			renderTo: 'formSul',
			width       : '100%',
			height      :100,
			items: {
            xtype:'tabpanel',
			id: 'TabSul',
			//height: 100,
            activeTab: 0,
			//////////// INICIO DAS ABAS /////////////////////
            items:[
				{
                title:'Faturamento',
				id: 'TabSul_A',
				autoHeight: true,
				iconCls: 'icon-money',
				bodyStyle:'padding:5px 5px 0',
                layout:'form',
                //defaults: {width: 230},
				//aki
				items:[		// ABRE A
				   
				{
				xtype:'textfield',
                fieldLabel: 'SubTotal',
				id: 'SubTotal',
                name: 'SubTotal',
				//mask:'decimal',
				//textReverse : true,
				readOnly: true,
				emptyText: '0,00',
                width: 70
					
               } // FECHA XTYPE
           
				,
			
				  new Ext.ux.MaskedTextField({
                    fieldLabel: '',
					id: 'Frete',
                    name: 'Frete',
					mask:'decimal',
					col: true,
					textReverse : true,
					width: 70,
					hidden: true,
					emptyText: '0.00',
                   //anchor:'40%',
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							   document.getElementById('Desconto').focus();
                            }}
                })
				
				,
			
				  new Ext.ux.MaskedTextField({
                    fieldLabel: 'Descuento %',
					labelWidth: 80,
					id: 'Desconto',
                    name: 'Desconto',
					readOnly: false,
					col: true,
					mask:'decimal',
					textReverse : true,
					emptyText: '0,00',
					selectOnFocus:true,
					width: 50,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter   
							     FDesconto();
                            }}
                   
                }),
					{
					xtype: 'displayfield',
                    fieldLabel: '<b>Valor Descuento</b>',
					labelWidth: 115,
					id: 'valorDesc',
                    name: 'valorDesc',
					col:true,
                    width: 100,
					fireKey : function(e){//evento de tecla   
                            if(e.getKey() == e.ENTER) {//precionar enter 						
							FdescVal();
							}
							}
                },
				{
				   xtype:'textfield',
                    fieldLabel: '<b>Total</b>',
					id: 'Total',
                    name: 'Total',
					readOnly: true,
					emptyText: '0,00',
                    width: 100
                }			   
				]  // FECHA A
            }
			////////// FIM ABA PRIMEIRA ////////////////////////////////
			////// INICIO ABA SEGUNDA ////////////////////////////////
				
		///////////// Terceira aba /////////////////////////
		]}
	    });
			
		 
grid_listaProdDetalhes.getSelectionModel().on('rowselect', function(sm, rowIndex, colIndex) {
    var record = grid_listaProdDetalhes.getStore().getAt( rowIndex );
	prodId = record.id;
	custo = record.data.custo;
	Codigo_Fabricante = record.data.Codigo_Fabricante;
	
	//console.info(record.data.custo);
	
	
}, this);


 storelistaProd = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({
			url: 'php/lista_prod_det.php',
			method: 'POST'
		}),   
		reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			totalProperty: 'totalProdutos',
			id: 'id'
		},
			[
				   {name: 'id'},
				   {name: 'Codigo'},
		           {name: 'custo'}				
			]
		),
		sortInfo: {field: 'Codigo', direction: 'ASC'},
		//id: 9,
		remoteSort: true		
	});
	
 
 ////////FIM GRID DOS DETALHES ///////////////////////////////////////////////////

	var vendedorcons = new Ext.form.ComboBox({
					typeAhead: true,
					lazyRender: true,
					hideTrigger: false,
					allowBlank: false,
					emptyText: 'Selecione',
					editable: false,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idvendedor','nome_vendedor'],
					loadingText: 'Consultando Banco de Dados',
					fieldLabel: 'Usuario',
				//	id: 'vendedor_id',
					name: 'vendedorcons',
					width: 120,
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_vendedor.php',
					root: 'resultados',
					fields: [ 'idvendedor', 'nome_vendedor' ]
					}),
						hiddenName: 'idvendedor',
						valueField: 'idvendedor',
						displayField: 'nome_vendedor'
	
	
	});
	  
	  
	 var formFinalisar = new Ext.FormPanel({
			frame: true,
			labelAlign: 'left',
			//bodyStyle:'background-color:#4e79b2',
			width       : '100%',
			height      : 268,
			items: [{
                    xtype:'combo',
					typeAhead: true,
					lazyRender: true,
					hideTrigger: false,
					allowBlank: false,
					emptyText: 'Selecione',
					editable: false,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idforma','forma'],
					loadingText: 'Consultando Banco de Dados',
					fieldLabel: 'Forma Pgto',
					id: 'formaPgto',
					name: 'formaPgto',
					anchor:'80%',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_fpgto.php',
					root: 'resultados',
					fields: [ 'idforma', 'forma' ]
					}),
						hiddenName: 'idforma',
						valueField: 'idforma',
						displayField: 'forma'


							
                }
			/*	,{
					xtype: 'radiogroup'
					,hideLabel: false
					,fieldLabel: 'Impressao'
					,name: 'ents'
					,id: 'ents'
			    	,items: [
						 {
							 boxLabel: 'Guarani'
							 , inputValue: 'GR'
							 , name: 'radio'
							 , checked: true
							
					    },
						{
							boxLabel: 'Dolar'
							, inputValue: 'US'
							, name: 'radio'
							
							
						}	
					]
				}, */
				,{
					xtype       : 'fieldset',
					title       : 'Identificacion',
					labelAlign: 'top',
					layout      : 'form',
					collapsible : false,                    
					collapsed   : false,
					autoHeight  : true,
					items:[
				{
                    xtype:'combo',
					typeAhead: true,
					lazyRender: true,
					hideTrigger: false,
					allowBlank: true,
					emptyText: 'Selecione',
					editable: false,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idvendedor','nome_vendedor'],
					loadingText: 'Consultando Banco de Dados',
					fieldLabel: 'Vendedor',
					id: 'vendedor_id',
					name: 'vendedor_id',
					anchor:'80%',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_vendedor.php',
					root: 'resultados',
					fields: [ 'idvendedor', 'nome_vendedor' ]
					}),
						hiddenName: 'idvendedor',
						valueField: 'idvendedor',
						displayField: 'nome_vendedor'


							
                },
				{
                    xtype:'combo',
					typeAhead: true,
					lazyRender: true,
					hideTrigger: false,
					allowBlank: false,
					emptyText: 'Selecione',
					editable: false,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idusuario','nome_usuario'],
					loadingText: 'Consultando Banco de Dados',
					fieldLabel: 'Usuario',
					id: 'usuario_id',
					name: 'usuario_id',
					anchor:'50%',
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_usuario.php',
					root: 'resultados',
					fields: [ 'idusuario', 'nome_usuario' ]
					}),
						hiddenName: 'idusuario',
						valueField: 'idusuario',
						displayField: 'nome_usuario'


							
                },
				{
				xtype:'textfield',
                fieldLabel: 'Password',
				inputType:'password',
				id: 'password',
                name: 'password',
				emptyText: 'Informe tu password'
               // width: 70
					
               } // FECHA XTYPE]
			   ]},
			   			{
						xtype:'button',
           			    text: 'Confirmar',
						id: 'confirma',
						align: 'left',
						scale: 'large',
						iconCls: 'icon-save',
            			handler: function(){ // fechar	
     	    			FinPedido();
						}
						
  			 			}
			   ]
			});
			
	  
	 var  finalisar = new Ext.Window({
				title: 'Confirmacion',
				width:300,
				height:290,
				//autoWidth: true,
				//autoHeight: true,
				plain: true,						
				collapsible: false,
				resizable: false,
				closeAction:'hide',
				closable: true,
				modal: true,
				border: false,
				items: [formFinalisar],
				focus: function(){
				//	Ext.get('queryPedidoprod').focus(); 
				}			
			})
	
	 formConsignacao = new Ext.form.FormPanel({
			frame: true,
		//	id: 'formConsignacao',
			labelAlign: 'left',
			bodyStyle:'background-color:#99bbe8',
			width       : '100%',
		//	height      : 268,
			items: [
			/*
			{
				xtype:'combo',
				hideTrigger: false,
				allowBlank: false,
				editable: false,
				mode: 'local',
				triggerAction: 'all',
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: true,
				fieldLabel: 'Movimento',
				minChars: 2,
				name: 'movcons',
                emptyText: 'Selecione',
				width: 120,
				forceSelection: true,
				store: [
                            ['Entrada','Entrada'],
                            ['Salida','Salida']
                            ]
                },
				*/
				{
					xtype:'combo',
				    typeAhead: true,
					lazyRender: true,
					hideTrigger: false,
					allowBlank: false,
					emptyText: 'Selecione',
					editable: false,
					mode: 'remote',
					triggerAction: 'all',
					dataField: ['idvendedor','nome_vendedor'],
					loadingText: 'Consultando Banco de Dados',
					fieldLabel: 'Usuario',
				//	id: 'vendedor_idc',
					name: 'idvendedor',
					width: 120,
					forceSelection: true,
					store: new Ext.data.JsonStore({
					url: 'php/pesquisa_vendedor.php',
					root: 'resultados',
					fields: [ 'idvendedor', 'nome_vendedor' ]
					}),
						hiddenName: 'idvendedor',
						valueField: 'idvendedor',
						displayField: 'nome_vendedor'
				},
				{
				xtype:'textfield',
                fieldLabel: 'Password',
				inputType:'password',
                name: 'passwordcons',
				emptyText: 'Informe tu password',
                width: 100
					
               }// FECHA XTYPE]
				
				
				]
	});
	

			var  Consignacao = new Ext.Window({
				title: 'Salida por Consignacion',
				width:300,
				//height:270,
				//autoWidth: true,
				//autoHeight: true,
				collapsible: false,
				resizable: false,
				closeAction:'hide',
				closable: false,
				modal: true,
				border: true,
				items: [formConsignacao],
				focus: function(){
				//	Ext.get('queryPedidoprod').focus(); 
				},
				buttons: [
				{
				xtype: 'button',
				text: '<b>Gravar</b>',
				iconCls: 'icon-save',
				handler: function(){
				FinConsig();
				}
				},
				{
				text: '<b>Salir</b>',
				handler: function(){
				Consignacao.hide();
				}
				}
				
				]
				})
		
	
Ext.get('controleCliP').focus();
//Ext.getCmp('Frete').setVisible(false);
//Ext.getCmp('Desconto').setVisible(false);
		
	


});
</script>

<body>
<div id="formCli"> </div>
<div id="DivPesquisaProd" width="100%" ></div>
<div id="gridPedidos"></div>
<div id="formSul"> </div>
<div id="formFinal"></div>
</body>
</html>
