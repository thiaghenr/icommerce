<?
	require_once("biblioteca.php");
 	require_once("config.php");
    conexao();
	$desc = $_POST['desc']; // ORDER BY CAST(Codigo AS UNSIGNED) 
	$ref = $_POST['ref'];
	$cli = $_GET['cli'];
	$_SESSION['cliente'] = $cli;

    $sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio FROM cambio_moeda cm WHERE cm.moeda_id = 3 group by cm.id DESC";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
   
    $id_prod = addslashes(htmlentities($_GET['desc']));
     $sql = "SELECT * FROM produtos WHERE ((Descricao LIKE '$desc%') AND (Codigo LIKE '$ref%')) OR ((cod_original2 LIKE '%$ref%') AND (Descricao LIKE '$desc%') ) OR ((cod_original LIKE '%$ref%') AND (Descricao LIKE '$desc%')) OR ((Codigo_Fabricante LIKE '%$ref%') AND (Descricao LIKE '$desc%')) ORDER BY CAST(Codigo AS UNSIGNED) asc limit 100 ";
    $rs = mysql_query($sql) or die (mysql_error());
	
	$num_prod = mysql_num_rows($rs);
	
    $str_dados="[";
    while($linha=mysql_fetch_array($rs)){
	//$novovalor = $linha['valor_c'] * $vl_cambio_guarani ;
        $str_dados.="['".addslashes($linha['Codigo'])."',";
        $str_dados.="'".addslashes($linha['Descricao'])."',";
        $str_dados.="'".addslashes($linha['Estoque'])."',";
        $str_dados.="'".addslashes($linha['qtd_bloq'])."',";
		$str_dados.="'".addslashes(str_replace(",",".",number_format(($linha['valor_c']*$vl_cambio_guarani))))."',";
		$str_dados.="'".addslashes(str_replace(",",".",number_format(($linha['valor_c']*$vl_cambio_guarani))))."',";
		$str_dados.="'".addslashes(str_replace(",",".",number_format(($linha['valor_c']*$vl_cambio_guarani))))."'],";
    }
    $str_dados = substr($str_dados,0,strlen($str_dados)-1);
    $str_dados.= "]";

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>Grid</title>
	<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />

	<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="ext/ext-all.js"></script>
	<script type="text/javascript" src="js/funcoes.js"></script>
	<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>
    
        <script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" />
    
<div align="center" class="Estilo1">
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
</table>
  <table width="100%" border="0">
    <tr>
      <td bgcolor="#BCD2EF"><div align="center">
          <p class="Estilo3 Estilo2 Estilo4"><strong>PRODUTOS</strong></p>
      </div></td>
    </tr>
  </table>
</div>	
	
	<script type="text/javascript">
		Ext.onReady(function(){
		    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
			var myData = <? echo $str_dados ?>;

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
		    // create the data store
		    var store = new Ext.data.SimpleStore({
		        fields: [
		           {name: 'Codigo'},
		           {name: 'Descripcion'},
		           {name: 'Disp'},
		           {name: 'Bloq'},
		           {name: 'C'},
				   {name: 'C'},
				   {name: 'C'}
		        ]
		    });
		    store.loadData(myData);
		    // create the Grid
		    var grid = new Ext.grid.GridPanel({
		        store: store,
		        columns: [
						{id:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'Codigo'},
						{header: "Descripcion", width: 250, sortable: true, dataIndex: 'Descripcion'},
						{header: "Disp", width: 80, sortable: true, dataIndex: 'Disp'},
						{header: "Bloq", width: 80, sortable: true, dataIndex: 'Bloq'},
						{header: "Valor C", width: 80, sortable: true, dataIndex: 'C'},
						{header: "Valor C", width: 80, sortable: true, dataIndex: 'C'},	        
						{header: "Valor C", width: 80, sortable: true, dataIndex: 'C'}	        
					],
		        stripeRows: true,
		        viewConfig: {forceFit:true},
		        autoExpandColumn: 'company',
		        height:280,
		        width:1000,
		        title:'Consulta'
		    });
		
		    grid.addListener('keydown',function(event){
				getItemRow(this, event)
			});
		    
		    grid.render('grid');
		    
		    grid.getSelectionModel().selectFirstRow();
			
			$('#ext-gen26').focus();			
		});
		
		function getItemRow(grid, event){
			key = getKey(event);
			record = grid.getSelectionModel().getSelected();
			var idName = grid.getColumnModel().getDataIndex(0); // Get field name
			var idData = record.get(idName);		
			
			if(key==13){
				var prodName = grid.getColumnModel().getDataIndex(1); // Get field name
				var prodData = record.get(prodName);
				url = "pedido.php?acao=add&";
				var query = "id=" + idData + "&prod=" + prodData;
				url+=query;
				location.assign(url);
			}
			else if(key==32){
				$.ajax({
				   type: "POST",
				   data: "id_prod="+idData + "&cli=" + <?=$cli?>,
				   url: "cons_det_produto.php",
				   success: function(msg){
					 $("#conteudo").html(msg);
				   }
				 });
			}
			else if(key==119){
				$.ajax({
				   type: "POST",
				   data: "id_prod="+idData,
				   url: "cons_compral.php",
				   success: function(msg){
					 $("#conteudo").html(msg);
				   }
				 });
			}
			
		}    
	</script>
</head>
<body>
	<? echo 'Produtos encontrados = '.$num_prod.'' ; ?>
	<div id="grid"></div>
	<br/><br/>
	<div id='conteudo' style="width:1000px"></div>
<script type='text/javascript'>
	$("#ref").autocomplete("pesquisa_codigo.php", {
		width: 260,
		selectFirst: false
		
	});		
	$("#desc").autocomplete("pesquisa_descricao.php", {
		width: 260,
		selectFirst: false
	});		
</script>
</body>
</html>