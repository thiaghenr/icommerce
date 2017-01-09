<?php
 require_once("../config.php");
 conexao();
 include("JSON.php");
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 40 ;
$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';
if($acao == 'listarPedidos' &&  !(isset($_POST['query']))) {
$query = isset($_POST['query']) ? $_POST['query'] : 1;
 
 $rss = mysql_query("SELECT id FROM pedido WHERE status != 'C' ");
 $rs    = mysql_query("SELECT it.id_pedido, p.desconto, sum(it.prvenda * it.qtd_produto) AS totalitens, f.id AS idforma, f.descricao, 
            u.id_usuario, u.nome_user, p.id,p.nome_cli,p.controle_cli, date_format(p.data_car, '%d/%m/%Y') AS data, p.total_nota,  
            p.usuario_id, p.vendedor_id, p.status, p.forma_pagamento_id, p.situacao, imp.nform
            FROM itens_pedido it,  forma_pagamento f, pedido p
			LEFT JOIN usuario u ON  u.id_usuario = p.vendedor_id
			LEFT JOIN im_impressao imp ON  imp.id_pedido = p.id
            WHERE  it.id_pedido = p.id  AND p.forma_pagamento_id = f.id AND p.status != 'C' 
            GROUP BY p.id ORDER BY p.id DESC  LIMIT $inicio, $limite ")or die (mysql_error());
 $total  =mysql_num_rows($rss);
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '{"total":'.$total.',"results":'.json_encode($arr).'}'; 
} 


if($acao == "listarPedidos" && isset($_POST['query']) ){

  $_SESSION['combo'] = strtolower($_POST['combo']);
  if(empty($_SESSION['combo'])){ $_SESSION['combo'] = "id"; }
 // echo $_POST['query'];
	
	function search($query="")
	{
		$payload=array();
		$payload["total"]=0;
		$payload["results"]=array();
		
		$sql="";
		if(trim($query)!="")
		{
			$sql="SELECT it.id_pedido, sum(it.prvenda * it.qtd_produto) AS totalitens, f.id AS idforma, f.descricao, 
            u.id_usuario, u.nome_user, p.desconto, p.id, p.nome_cli, p.controle_cli, date_format(p.data_car, '%d/%m/%Y') AS data, 
            p.situacao, p.total_nota, p.usuario_id, p.vendedor_id, p.status, p.forma_pagamento_id, imp.nform
            FROM itens_pedido it, forma_pagamento f, pedido p
			LEFT JOIN usuario u ON  u.id_usuario = p.vendedor_id
			LEFT JOIN im_impressao imp ON  imp.id_pedido = p.id
            WHERE it.id_pedido = p.id AND  p.forma_pagamento_id = f.id  AND p.status != 'C' 
            AND p." . mysql_real_escape_string(trim($_SESSION['combo'])) . " LIKE '%$query%'  GROUP BY p.id ORDER BY p.id DESC ";
			
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