<?php
 require_once("../config.php");
 conexao();
 include("JSON.php");
 
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';
if($acao == 'BuscaCodigo'){
 $query = $_POST['query'];
 
 	$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio FROM cambio_moeda cm WHERE cm.moeda_id = 3 group by cm.id DESC";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
 $rs    = mysql_query("SELECT Codigo,Descricao,cod_original,peso FROM produtos WHERE Codigo = '$query' ")or die (mysql_error());
 $total  =mysql_num_rows($rs);
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '{"totalProdutos":'.$total.',"resultsProdutos":'.json_encode($arr).'}'; 
} 


else{

  $_SESSION['combo'] = strtolower($_POST['combo']);
  if(empty($_SESSION['combo'])){ $_SESSION['combo'] = "Codigo"; }
  
	
	function search($query="")
	{
		$payload=array();
		$payload["totalProdutos"]=0;
		$payload["resultsProdutos"]=array();
		
		$sql="";
		if(trim($query)!="")
		{
	$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio FROM cambio_moeda cm WHERE cm.moeda_id = 3 group by cm.id DESC";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
			$sql="SELECT id, Codigo, Descricao, custo, Codigo_Fabricante, peso,
					Estoque, qtd_bloq, valor_a, valor_b
					FROM produtos 
					WHERE " . mysql_real_escape_string(trim($_SESSION['combo'])) . " LIKE '%$query%'";
			
			if($rs=mysql_query($sql) or die (mysql_error() .' '.$sql))
			{
				$payload["totalProdutos"]=mysql_num_rows($rs);
				while($data=mysql_fetch_assoc($rs))
				{
					$payload["resultsProdutos"][]=$data;
				}
			}
		}
		
		$json = new Services_JSON();
		return $json->encode($payload);		
		//return json_encode($payload);
	}
	
	
	
	$searchResults=search();
//	if(conexao("publimar"))
//	{
		if(isSet($_POST["query"]))
		{
			$searchResults=search($_POST["query"]);			
		}
//	}
	
	print $searchResults;
	}
?>