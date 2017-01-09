<?php
	//dl("json.so");
 require_once("../config.php");
 conexao();
 include("JSON.php");

$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';
if($acao == 'BuscaCodigo'){
 $query = $_POST['query'];
 
 	
 $rs    = mysql_query("SELECT Codigo,Descricao,cod_original FROM produtos WHERE Codigo = '$query' ")or die (mysql_error());
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
	
			$sql="SELECT id, Codigo, Descricao, cod_original, cod_original2, Codigo_Fabricante, Codigo_Fabricante2, Codigo_Fabricante3, Estoque, qtd_bloq, valor_a, valor_b, valor_c FROM produtos WHERE " . mysql_real_escape_string(trim($_SESSION['combo'])) . " LIKE '%$query%'";
			
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