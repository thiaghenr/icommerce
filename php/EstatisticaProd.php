<?php
include "../config.php";
conexao();
include_once("JSON/JSON.php");
$json = new Services_JSON();


$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 10 ;
$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';

$Codigo = $_POST['codigo'];
$marca = $_POST['marca'];
$grupo = $_POST['grupo'];


//$dados = $json->decode($_POST["data"]);



$sql_busca = " SELECT it.referencia_prod,p.Codigo,p.Descricao,p.grupo,
			p.marca,p.Estoque,p.custo,p.custo_medio,p.custo_anterior, m.nom_marca, g.nom_grupo,
			sum(it.qtd_produto) AS qtd_vendido
			FROM produtos p, grupos g, marcas m, itens_pedido it
			WHERE  it.referencia_prod = p.Codigo AND p.Codigo = it.referencia_prod ";
if ($Codigo != ""){
     $sql_busca .= " AND p.Codigo = '".%$Codigo. "'";
    }
if ($marca != ""){
     $sql_busca .= " AND p.marca = '".$marca. "'";
    }
if ($grupo != ""){
     $sql_busca .= " AND p.grupo = '".$grupo. "'";
    }
$sql_busca .= " GROUP by p.Codigo";	
//echo $sql_busca;

$exe_busca= mysql_query($sql_busca)or die (mysql_error());
$total = mysql_num_rows($exe_busca);
$arr = array();
	while($obj = mysql_fetch_object($exe_busca)){
		$arr[] = $obj;
	}
	echo '({"total":"'.$total.'","Itens":'.json_encode($arr).'})'; 


?>



