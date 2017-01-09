<?php
	//require_once("biblioteca.php");
 	require_once("config.php");
    conexao();
	$ref = $_POST['ref'];
    $desc = $_POST['desc'];
	if(empty($ref)){
		$ref = '1lKx';
		}
	if(empty($desc)){
		$desc = '2lKx';
	}
	
	$cli = $_GET['cli'];
	$_SESSION['cliente'] = $cli;

   
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>Productos</title>
	
<script type="text/javascript" src="js/funcoes.js"></script>
<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>
<script type="text/javascript" src="js/prototype.js"></script>	
<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" />

    <link rel="stylesheet" type="text/css" href="ext-3.1.1/resources/css/ext-all.css" />
	<script type="text/javascript" src="ext-3.1.1/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="ext-3.1.1/ext-all.js"></script>
	<link rel="stylesheet" type="text/css" href="ext-3.1.1/resources/css/xtheme-access.css" />
	
<div align="left" class="Estilo1">
<table width="49%" border="0">
  <tr>
    <td width="15%" bgcolor="#D4D0C8">Codigo:</td>
	<td width="85%">
	<form name="Descricao" method="POST" action="res_pes_prod.php?cli=<?=$_SESSION['cliente']?>">
	<input type="text" size="15" name="ref" id="ref"></td></form>
    <td width="15%" bgcolor="#D4D0C8">Descripcion:</td>
    <td width="85%">
	<form name="Descricao" method="POST" action="res_pes_prod.php?cli=<?=$_SESSION['cliente']?>">
	<input type="text" size="40" name="desc" id="desc"></td>
  </tr></form>

</div>	
</head>
	
<script type="text/javascript">
				
function lista(id){
//alert(id+"-"+ini+"--"+fim);
var url = 'fotoprod.php';
var pars = 'id=' + id;
var myAjax = new Ajax.Updater(
'conteudo',
url,
{
method: 'get',
parameters: pars
});
}		
		
		Ext.onReady(function(){
		    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
			

		    // example of custom renderer function
		    function change(val){
		        if(val > 0){
		            return '<span style="color:green;">' + val + '</span>';
		        }else if(val < 0){
		            return '<span style="color:red;">' + val + '</span>';
		        }
		        return val;
		    }
		  
		    // create the data store
		     storeprod = new Ext.data.Store({
			proxy: new Ext.data.HttpProxy({
			url: "php/ResPesProd.php?ref="+"<?=$ref?>"+"&desc="+"<?=$desc?>",
			method: 'POST'
			}),
			baseParams:{
			acao: 'ListaProd'
			},
			reader:  new Ext.data.JsonReader({
			root: 'Produtos',
			id: 'id'
			},
			[		
				   {name: 'id'},
				   {name: 'Codigo'},
		           {name: 'Descricao'},
		           {name: 'Estoque'},
		           {name: 'qtd_bloq'},
				   {name: 'valor_a'},
		           {name: 'valor_b'},
		           {name: 'valor_c'}
				
			]
		),
		sortInfo: {field: 'id', direction: 'DESC'},
		remoteSort: true,
		autoLoad: true
	});
		  
		    // create the Grid
		    var gridprod = new Ext.grid.GridPanel({
		        store: storeprod,
		        columns: [
						{header: "id", width: 2, hidden: true, sortable: true, dataIndex: 'id'},
						{header:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descripcion", width: 250, sortable: true, dataIndex: 'Descricao'},
						{header: "Disp", width: 80, sortable: true, dataIndex: 'Estoque'},
						{header: "Bloq", width: 80, sortable: true, dataIndex: 'qtd_bloq'},
						{header: "Valor A", width: 80, sortable: true, dataIndex: 'valor_a'},
						{header: "Valor B", width: 80, sortable: true, dataIndex: 'valor_b'},	        
						{header: "Valor C", width: 80, sortable: true, dataIndex: 'valor_c'}	        
					],
		       // stripeRows: true,
		        viewConfig: {forceFit:true},
		        autoExpandColumn: 'Codigo',
		        height: 280,
		        autoWidth: true,
				autoScroll: true			
		    });
		
		    gridprod.addListener('keydown',function(event){
				getItemRow(this, event)
			});
		   
		   
	var formProdutos = new Ext.FormPanel({
		id: 'formProdutos',
        frame: true,
		labelWidth: 50,
        title: 'Productos',
		renderTo: 'conteudo',
		split: true,
		tabWidth: '100%',
		//autoWidth: true,
		//height: 310,
		border : true,
		layout: 'form',
        items: [
			{
            layout:'column',
            items:[
				{
                columnWidth:.3,
				border: false,
                layout: 'form',
                items: [
				{
				xtype:'combo',
				hideTrigger: true,
				allowBlank: true,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				dataField: ['idprod','codprod'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: false,
				fieldLabel: 'Codigo',
				id: 'codprod',
				typeAhead: false,
				autoSelect: false,
				minChars: 2,
				name: 'codprod',
				width: 200,
                resizable: true,
                listWidth: 300,
				forceSelection: true,
				store: new Ext.data.JsonStore({
				url: 'pesquisa_cod.php?acao_nome=CodProd',
				root: 'resultados',
				fields: ['idprod', 'codprod']
				}),
					hiddenName: 'idprod',
					valueField: 'idprod',
					displayField: 'codprod',
					fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
						ref = Ext.get('codprod').getValue();
						console.info(ref);
						storeprod.load({params: {ref: ref, acao: 'pesquisa'}});						
						setTimeout(function(){
						 gridprod.getSelectionModel().selectFirstRow();
							   gridprod.getView().focusEl.focus();							   
						}, 650);
						}
					},
					onSelect: function(record){
						idprod = record.data.idprod;
						codprod = record.data.codprod;
						this.collapse();
						this.setValue(codprod);
						storeprod.load({params: {ref: codprod, acao: 'pesquisa'}});
						setTimeout(function(){
						gridprod.getSelectionModel().selectFirstRow();
							   gridprod.getView().focusEl.focus();
						}, 650);						   
					}
                }
				]
				},
				
				{
                columnWidth:.3,
				border: false,
				labelWidth: 60,
                layout: 'form',
                items: [
				{
				xtype:'combo',
				hideTrigger: true,
				allowBlank: true,
				editable: true,
				mode: 'remote',
				triggerAction: 'all',
				dataField: ['idprod','descprod'],
				loadingText: 'Consultando Banco de Dados',
				selectOnFocus: false,
				fieldLabel: 'Descricao',
				id: 'descprod',
				typeAhead: false,
				autoSelect: false,
				minChars: 2,
				name: 'descprod',
				width: 200,
                resizable: true,
                listWidth: 300,
				col: true,
				forceSelection: true,
				store: new Ext.data.JsonStore({
				url: 'pesquisa_desc.php?acao_nome=DescProd',
				root: 'resultados',
				fields: ['idprod', 'descprod']
				}),
					hiddenName: 'idprod',
					valueField: 'idprod',
					displayField: 'descprod',
					fireKey : function(e){//evento de tecla   
						if(e.getKey() == e.ENTER) {//precionar enter   
						desc = Ext.get('descprod').getValue();
						storeprod.load({params: {desc: desc, acao: 'pesquisa'}});						
						}
					},
					onSelect: function(record){
						idprod = record.data.idprod;
						descprod = record.data.descprod;
						this.collapse();
						this.setValue(descprod);
						storeprod.load({params: {desc: descprod, acao: 'pesquisa'}});					   
					}
                }
				]
				}
				]
				}
				,
		gridprod
		
		]
		
		});
		
			
			gridprod.on('rowdblclick', function() {
			record = gridprod.getSelectionModel().getSelected();
			var idName = gridprod.getColumnModel().getDataIndex(0); // Get field name
			var idData = record.get(idName);	
			lista(idData);
			});
			
			storeprod.on('load', function(grid, record, action, row, col, rowIndex) {
		    gridprod.getSelectionModel().selectFirstRow();
			gridprod.getView().focusEl.focus();
		    });
			
		});
		
		function getItemRow(gridprod, event){
			key = getKey(event);
			record = gridprod.getSelectionModel().getSelected();
			var idName = gridprod.getColumnModel().getDataIndex(0); // Get field name
			var idData = record.get(idName);
			
			var idNamez = gridprod.getColumnModel().getDataIndex(1); // Get field name
			var idDataz = record.get(idNamez);
			
			if(key==13){
				var prodName = gridprod.getColumnModel().getDataIndex(1); // Get field name
				var prodData = record.get(prodName);
				url = "pedido.php?acao=add&";
				var query = "id=" + idData + "&prod=" + prodData ;
				url+=query;
				location.assign(url);
			}
			else if(key==32){
				jQuery.ajax({
				   type: "POST",
				   data: "id_prod="+idData + "&cli=" + <?=$cli?>,
				   url: "cons_det_produto.php",
				   success: function(msg){
					 jQuery("#conteudo").html(msg);
				   }
				 });
			}
	/*		else if(key==40 || key == 38 ){
				$.ajax({
				   type: "POST",
				   data: "id_prod="+idData,
				   url: "lista_dados_prod.php",
				   success: function(msg){
					 $("#conteudo").html(msg);
				   }
				 });
			}*/
			else if(key >47 && key < 58 || key >64 && key < 91 ){
				Ext.getCmp('descprod').setValue("")
				Ext.getCmp("descprod").focus();
			}
			else if(key >95 && key < 106 ){
				Ext.getCmp('codprod').setValue("")
				Ext.getCmp("codprod").focus();
			}
			else if(key==119){
				jQuery.ajax({
				   type: "POST",
				   data: "id_prod="+idData,
				   url: "cons_compral.php",
				   success: function(msg){
					 jQuery("#conteudo").html(msg);
				   }
				 });
			}
			
		}    
		
	</script>
	

<body>

	
	<div id="grid"></div>
	<div id='div_form' style="width:1000px"></div>
	<div id='conteudo' style="width:1000px"></div>
	<div id="pedido" style="width:1000px"></div>

<script type='text/javascript'>
	jQuery("#ref").autocomplete("pesquisa_codigo.php", {
		width: 260,
		selectFirst: false
		
	});		
	jQuery("#desc").autocomplete("pesquisa_descricao.php", {
		width: 260,
		selectFirst: false
	});		
</script>
</body>
</html>