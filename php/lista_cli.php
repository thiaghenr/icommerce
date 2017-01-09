<?php
	//dl("json.so");
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
 
 $rs    = mysql_query("SELECT controle,nome,ruc,endereco FROM entidades WHERE controle = '$query' AND ativo = 'S' ")or die (mysql_error());
 $total  =mysql_num_rows($rs);
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '{"total":'.$total.',"results":'.json_encode($arr).'}'; 
} 


else{

  $_SESSION['combo'] = strtolower($_POST['combo']);
  if(empty($_SESSION['combo'])){ $_SESSION['combo'] = "nome"; }
  
	
	function search($query="")
	{
		$payload=array();
		$payload["total"]=0;
		$payload["results"]=array();
		
		$sql="";
		if(trim($query)!="")
		{
			$sql="SELECT e.*, c.nomecidade FROM entidades e
				LEFT JOIN cidades c ON c.idcidade = e.cidade
				WHERE " . mysql_real_escape_string(trim($_SESSION['combo'])) . " LIKE '%$query%' AND e.ativo = 'S'  ";
			
			if($rs=mysql_query($sql) or die (mysql_error() .' '.$sql))
			{
				$payload["total"]=mysql_num_rows($rs);
				while($data=mysql_fetch_assoc($rs))
				{
					$payload["results"][]=$data;
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