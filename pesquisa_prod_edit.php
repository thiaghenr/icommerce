<?
	require_once("biblioteca.php");
 	require_once("config.php");
    conexao();
	$desc = $_POST['desc'];
	$ref = $_POST['ref'];

    $sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio FROM cambio_moeda cm WHERE cm.moeda_id = 3 group by cm.id DESC";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
   
    $id_prod = addslashes(htmlentities($_GET['desc']));
    $sql = "SELECT * FROM produtos WHERE ((Descricao LIKE '$desc%') AND (Codigo LIKE '%$ref%')) OR ((cod_original2 LIKE '%$ref%') AND (Descricao LIKE '$desc%') ) OR ((cod_original LIKE '%$ref%') AND (Descricao LIKE '$desc%')) OR ((Codigo_Fabricante LIKE '%$ref%') AND (Descricao LIKE '$desc%')) ORDER BY CAST(Codigo AS UNSIGNED) asc limit 100  ";
    $rs = mysql_query($sql) or die (mysql_error());
	
	$num_prod = mysql_num_rows($rs);
	
    $str_dados="[";
    while($linha=mysql_fetch_array($rs)){
	//$novovalor = $linha['valor_c'] * $vl_cambio_guarani ;
        $str_dados.="['".addslashes($linha['id'])."',";
		$str_dados.="'".addslashes($linha['Codigo'])."',";
		$str_dados.="'".addslashes($linha['cod_original'])."',";
        $str_dados.="'".addslashes($linha['Descricao'])."',";
        $str_dados.="'".addslashes($linha['Estoque'])."',";
        $str_dados.="'".addslashes($linha['qtd_bloq'])."',";
		$str_dados.="'".addslashes(str_replace(",",".",number_format(($linha['valor_a']))))."',";
		$str_dados.="'".addslashes(str_replace(",",".",number_format(($linha['valor_b']))))."',";
		$str_dados.="'".addslashes(str_replace(",",".",number_format(($linha['valor_c']))))."'],";
    }
    $str_dados = substr($str_dados,0,strlen($str_dados)-1);
    $str_dados.= "]";

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>LISTA DE PRODUTOS - </title>
	<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />

	<script type="text/javascript" src="ext/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="ext/ext-all.js"></script>
	<script type="text/javascript" src="js/funcoes.js"></script>
	<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>	
	
<style type="text/css">
body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #EFEFEF;
border-width:2px;
border-style:solid;
border-color:#a2bfe9;
}


</style>
</head>
<div align="center" class="Estilo1">
<table width="49%" border="0">
  <tr>
    <td width="15%" bgcolor="#DCE4F4">Codigo:</td>
	<td width="85%">
	<form name="Descricao" method="POST" action="pesquisa_prod_edit.php">
	<input type="text" size="15" name="ref"></td></form>
    <td width="15%" bgcolor="#DCE4F4">Descripcion:</td>
    <td width="85%">
	<form name="Descricao" method="POST" action="pesquisa_prod_edit.php">
	<input type="text" size="40" name="desc"></td>
  </tr></form>
</table>
  <table width="100%" border="0">
    <tr>
      <td bgcolor="#OEEAEO"><div align="center">
          <p><strong>LISTA GERAL DE PRODUTOS</strong></p>
      </div></td>
    </tr>
  </table>
</div>
<p>
<head>
<script>
function pegaKey(e){
	var tecla;
	if(!e)
		e = window.event;
	if(e.keyCode)
		tecla = e.keyCode;
	else if(e.which)
		tecla = e.which;
	return tecla;
}


function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='';
 }
 else if(lugar=='Nueva'){
  window.location.href='';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>
	
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
		           {name: 'id'},
				   {name: 'Codigo'},
				   {name: 'Cod Original'},
		           {name: 'Descripcion'},
		           {name: 'Disp'},
		           {name: 'Bloq'},
		           {name: 'A'},
				   {name: 'B'},
				   {name: 'C'}
		        ]
		    });
		    store.loadData(myData);
		    // create the Grid
		    var grid = new Ext.grid.GridPanel({
		        store: store,
		        columns: [
						{id:'id',header: "id", width: 30, sortable: true, dataIndex: 'id'},
						{header:'Codigo',header: "Codigo", width: 80, sortable: true, dataIndex: 'Codigo'},
						{header:'Cod Original',header: "Cod Original", width: 80, sortable: true, dataIndex: 'Cod Original'},
						{header: "Descripcion", width: 250, sortable: true, dataIndex: 'Descripcion'},
						{header: "Disp", width: 80, sortable: true, dataIndex: 'Disp'},
						{header: "Bloq", width: 80, sortable: true, dataIndex: 'Bloq'},
						{header: "Valor A", width: 80, sortable: true, dataIndex: 'A'},
						{header: "Valor B", width: 80, sortable: true, dataIndex: 'B'},	        
						{header: "Valor C", width: 80, sortable: true, dataIndex: 'C'}	        
					],
		        stripeRows: true,
		        viewConfig: {forceFit:true},
		        autoExpandColumn: 'company',
		        height:350,
		        width:995,
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
				url = "alterar_prod_fim.php?acao=alt&"; 
				var query = "id=" + idData + "&prod=" + prodData;
				url+=query;
				location.assign(url);
			}
			else if(key==32){
				$.ajax({
				   type: "POST",
				   data: "id_prod="+idData,
				   url: "cons_det_produtol.php",
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
</body>
</html>