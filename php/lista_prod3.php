<?php
//header("Content-type: txt/html, charset='utf-8'");
require_once("../biblioteca.php");
include "../config.php";
conexao();


mysql_query("SET NAMES 'utf8'");mysql_query('SET character_set_connection=utf8');mysql_query('SET character_set_client=utf8');mysql_query('SET character_set_results=utf8');

$marca = isset($_POST['marca']) ? $_POST['marca'] : '';
$grupo = isset($_POST['grupo']) ? $_POST['grupo'] : '';

//echo $_POST['acao'];

$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 50 ;
$campo = isset($_POST['campo']) ? $_POST['campo'] : '1' ;
$order = isset($_POST['dir']) ? $_POST['dir'] : 'desc' ;
$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';
$Codigo = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '%' ;

$idprod = $_POST['idProduto'];
$idcontato   = isset($_POST['id']) ? $_POST['id'] : '';

if($campo == 1 || $campo == ''){ $campo = 'Codigo';}
if($campo == 2){ $campo = 'Descricao';}

if($acao != 'ListaItens'){
$consulta = "$campo Like '$Codigo%'";
$grmr ='INNER JOIN marcas m ON m.id = p.marca INNER JOIN grupos g ON g.id = p.grupo';


if(!empty($marca) && empty($grupo)){ 
$consulta = "p.marca = '$marca'";
}
if(empty($marca) && !empty($grupo)){ 
$consulta = "p.grupo = '$grupo'";
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
	$rs    = mysql_query("SELECT p.Codigo,p.Descricao,p.Estoque, p.imagem, p.qtd_bloq, round(p.custo,0) AS custo, p.marca AS marcaid, p.grupo AS grupoid, p.id, (p.valor_a) AS valorA, 
	(p.valor_b) AS valorB, (p.valor_c) AS valorC, m.id AS idm,m.nom_marca,
	g.id AS idg,g.nom_grupo
	FROM produtos p
	LEFT JOIN marcas m ON m.id = p.marca LEFT JOIN grupos g ON g.id = p.grupo
	WHERE $consulta GROUP BY p.$campo ORDER BY p.$campo $order  LIMIT $inicio, $limite")or die (mysql_error().'-'.$rs);




	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		
	}
	echo '({"totalProdutos":"'.$totalProdutos.'","Produtos":'.json_encode($arr).'})'; 
	
} 

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if($acao == 'ListaItens'){
	//echo $idprod;
//	$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio FROM cambio_moeda cm WHERE cm.moeda_id = 3 group by cm.id DESC";
//    $rs_cambio = mysql_query($sql_cambio);
//    $linha_cambio = mysql_fetch_array($rs_cambio);
//    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
	
		$rs    = mysql_query("SELECT round(p.pr_min,0) AS pr_min, p.Descricaoes, p.Codigo_Fabricante, p.Codigo_Fabricante2, p.Codigo_Fabricante3, m.nom_marca, p.Codigo,p.Descricao, 
		p.Estoque, p.qtd_bloq, p.marca AS marcaid, p.grupo AS grupoid, g.nom_grupo, p.cod_original, p.cod_original2, (p.margen_a) AS margen_a, (p.margen_b) AS margen_b, 
		(p.margen_c) AS margen_c, round(p.custo,0) AS custo, p.grupo, p.qtd_min, p.embalagem, p.local, p.iva, p.obs, p.id, round(p.valor_a,0) AS valorA, 
	round(p.valor_b,0) AS valorB, round(p.valor_c,0) AS valorC, m.id AS idm,m.nom_marca,
	g.id AS idg,g.nom_grupo
	FROM produtos p
	LEFT JOIN marcas m ON m.id = p.marca 
	LEFT JOIN grupos g ON g.id = p.grupo
	WHERE p.id = '$idprod' ")or die (mysql_error().'-'.$rs);
		
		$arr = array();
		$count = 0;
		while($obj = mysql_fetch_object($rs)){
		$arr[] = $obj;
		}
		
		echo '({"Produtos":'.(json_encode($arr)).'})'; 

	}

?>