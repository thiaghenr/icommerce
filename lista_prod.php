<?
	require_once("biblioteca.php");
 	require_once("config.php");
    conexao();
	

 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>LISTA DE PRODUTOS - VALPARTS SA</title>
	<link rel="stylesheet" type="text/css" href="ext-3.4.0/resources/css/ext-all.css" />

	<script type="text/javascript" src="ext-3.4.0/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="ext-3.4.0/ext-all.js"></script>
	<link rel="stylesheet" type="text/css" href="css/forms.css"/>
	<script type="text/javascript" src="js/funcoes.js"></script>
	<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>	
    <script type="text/javascript" src="js/override.js"></script>
	<script type="text/javascript" src="js/prototype.jss"></script>
	<style type="text/css">
body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #EFEFEF;
border-width:2px;
border-style:solid;
border-color:#a2bfe9;
}
#pedido{
	width:800px;
	height:auto;
	float:left;
	}

</style> 	
</head>
<div align="center" class="Estilo1">

</div>
<p>
<head>
<script>
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
		    // example of custom renderer function
		    function pctChange(val){
		        if(val > 0){
		            return '<span style="color:green;">' + val + '%</span>';
		        }else if(val < 0){
		            return '<span style="color:red;">' + val + '%</span>';
		        }
		        return val;
		    }
			function renderBlue(value, metadata, record, rowIndex, colIndex, store){
				  return '<span style="color:blue;font-weight: bold;">' + value + '</span>';
				}
				

		    // create the data store
		  var dsProdList = new Ext.data.Store({
                url: 'php/lista_produtos.php',
                method: 'POST',
				baseParams:{acao: "BuscaCodigo"},				
            reader:  new Ext.data.JsonReader({
				totalProperty: 'totalProdutos',
				root: 'resultsProdutos',
				id: 'id',
		        fields: [
		           {name: 'id'},
				   {name: 'Codigo'},
		           {name: 'Descripcion', mapping: 'Descricao'},
		           {name: 'Disp', mapping: 'Estoque'},
		           {name: 'Bloq', mapping: 'qtd_bloq'},
				   {name: 'total_vendido'},
		           {name: 'A'},
				   {name: 'B'},
				   {name: 'C'}
		        ]
		    }),
		sortInfo: {field: 'Codigo', direction: 'DESC'},
		remoteSort: true
			
		})
		    // create the Grid
		     gridList = new Ext.grid.GridPanel({
		        store: dsProdList,
		        columns: [
						{id:'id',header: "id", width: 2, hidden: true, sortable: true, dataIndex: 'id'},
						{header:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descripcion", width: 250, sortable: true, dataIndex: 'Descripcion'},
						{header: "Disponible", width: 80, sortable: true, dataIndex: 'Disp'},
						{header: "Bloq", width: 80, sortable: true, dataIndex: 'Bloq'},
						{header: "Vendido 6meses", width: 80, sortable: true, dataIndex: 'total_vendido'},
						{header: "Valor A", width: 80, align: 'right', sortable: true, dataIndex: 'A'},
						{header: "Valor B", width: 80, align: 'right', sortable: true, dataIndex: 'B'},
						{header: "Valor C", width: 80, align: 'right', sortable: true, dataIndex: 'C'}
						
					],
		        stripeRows: true,
		        viewConfig: {forceFit:true},
				//autoScrool: true,
				height      : 290,
				enableKeyEvents: true
			
		    });
			
			gridList.on('keydown', function(e){
			if(e.getKey()) {//
						// Carrega O formulario Com os dados da linha Selecionada
						record = gridList.getSelectionModel().getSelected();
						//tabs.getForm().loadRecord(record);	
						var idName = gridList.getColumnModel().getDataIndex(0); // Get field name
						var idData = record.get(idName);
						key = e.getKey();
						
						
						if(key == 119){
							jQuery.ajax({
							   type: "POST",
							   data: "id_prod="+idData,
							   url: "cons_compral.php",
							   success: function(msg){
								 jQuery("#conteudo").html(msg);
							   }
							 });
						}
						if(key==32){
						jQuery.ajax({
						   type: "POST",
						   data: "id_prod="+idData,
						   url: "cons_det_produtol.php",
						   success: function(msg){
							 jQuery("#conteudo").html(msg);
						   }
						 });
					}
					
					if(key >47 && key < 58 || key >64 && key < 91 ){
							PesquisaProdNew.getForm().findField('DescricaoProdutoNew').focus();
					}
					else if(key >95 && key < 106 ){
						PesquisaProdNew.getForm().findField('CProduto').focus();
					}
						
					}
			});
			
		var	PesquisaProdNew = new Ext.FormPanel({
		    width:'100%',
			closable: true,
			title:'Pesquiza de Productos',
	        frame:false,
			iconCls: 'icon-icommerce16',
			renderTo: 'grids',
			border: false,
	        bodyStyle:'padding:5px 5px 0',
	        defaultType: 'textfield',
			items: [{
                    xtype:'textfield',
                    fieldLabel: 'Codigo',
                    name: 'CProduto',
					labelWidth: 50,
					id: 'CProduto',
					fireKey: function(e,type){
							var theQueryProds = Ext.getCmp('CProduto').getValue(this);
							if(e.getKey() == e.ENTER && Ext.getCmp('CProduto').getValue() != '') {
								dsProdList.load({params:{query: theQueryProds, acao: 'Busca', combo: 'Codigo'}});
								PesquisaProdNew.form.reset();
							}
							if(e.getKey() == 40  ){//seta pra baixo  
							   gridList.getSelectionModel().selectFirstRow();
							   gridList.getView().focusEl.focus();
                            }
							}
							},
							
							{
							xtype:'textfield',
							fieldLabel: 'Descripcion',
							name: 'DescricaoProdutoNew',
							id: 'DescricaoProdutoNew',
							labelWidth: 70,
							width: 300,
							col:true,
							fireKey : function(e){//evento de tecla   
								var theQueryProds = Ext.getCmp('DescricaoProdutoNew').getValue(this);
								if(e.getKey() == e.ENTER && Ext.getCmp('DescricaoProdutoNew').getValue() != '') {//precionar enter   
								dsProdList.load({params:{query: theQueryProds, acao: 'Busca', combo: 'Descricao'}});
								PesquisaProdNew.form.reset();
                            }
							if(e.getKey() == 40  ){//seta pra baixo  
							   gridList.getSelectionModel().selectFirstRow();
							   gridList.getView().focusEl.focus();
                            }
							}
							},
							// este apenas para corrigir layout no ie.
							{
							xtype:'label',
							fieldLabel: '',
							disabled: true,
							col:true
							},
							gridList
					]
					
			});
			dsProdList.load();

		});
		
	
	
	</script>
</head>
<body">
	<div id="grids"></div>
	<br/><br/>
	<div id="conteudo" style="width:1000px"></div>
	<div id="pedido" style="width:1000px"></div>


</body>
</html>