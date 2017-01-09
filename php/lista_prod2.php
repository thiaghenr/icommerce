<?php
include "../config.php";
conexao();
header("Content-Type: text/html; charset=iso-8859-1");

$marca = isset($_POST['marca']) ? $_POST['marca'] : '';
$grupo = isset($_POST['grupo']) ? $_POST['grupo'] : '';

$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 150 ;
$Codigo = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : 112. ;
$campo = isset($_POST['campo']) ? $_POST['campo'] : '1' ;
$order = isset($_POST['dir']) ? $_POST['dir'] : 'ASC' ;
$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';
$idcontato   = isset($_POST['id']) ? $_POST['id'] : '';
if($campo == 1 || $campo == ''){ $campo = 'Codigo';}
if($campo == 2){ $campo = 'Descricao';}

$consulta = "$campo Like '%$Codigo%' OR Codigo_Fabricante LIKE '%$Codigo%' OR cod_original LIKE '%$Codigo%' OR cod_original2 LIKE '%$Codigo%' ";
$grmr ='LEFT JOIN marcas m ON m.id = p.marca INNER JOIN grupos g ON g.id = p.grupo';

if(!empty($marca) && empty($grupo)){ 
$consulta = "p.marca = '$marca'";
}
if(empty($marca) && !empty($grupo)){ 
$consulta = "p.grupo = '$grupo' ";
}
if(!empty($marca) && !empty($grupo)){ 
$consulta = "p.marca = '$marca' AND p.grupo = '$grupo'";
}


//if(empty($marca) && empty($grupo)){
// 	$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio FROM cambio_moeda cm WHERE cm.moeda_id = 3 group by cm.id DESC";
//    $rs_cambio = mysql_query($sql_cambio);
//    $linha_cambio = mysql_fetch_array($rs_cambio);
//    $vl_cambio_guarani = $linha_cambio['vl_cambio'];

	$rs    = mysql_query("SELECT id FROM produtos WHERE '$Codigo' = '$Codigo' ")or die (mysql_error().'-'.$rs);
	$totalProdutos = mysql_num_rows($rs);
	$rs    = mysql_query("SELECT p.Codigo,p.Descricao,p.Estoque, p.qtd_bloq, p.marca, p.grupo, p.id, CEILING(p.valor_a) AS valorA, 
	CEILING(p.valor_b) AS valorB, CEILING(p.valor_c) AS valorC, m.id AS idm,m.nom_marca,
	g.id AS idg,g.nom_grupo
	FROM produtos p
	INNER JOIN marcas m ON m.id = p.marca INNER JOIN grupos g ON g.id = p.grupo
	WHERE $consulta GROUP BY p.$campo ORDER BY p.$campo $order  LIMIT $inicio, $limite")or die (mysql_error().'-'.$rs);




	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		
	}
	
	if ($arr)
	echo '({"totalProdutos":"'.$totalProdutos.'","Produtos":'.json_encode($arr).'})'; 
//} 
?>