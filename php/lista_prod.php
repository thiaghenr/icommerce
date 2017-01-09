<?php
include "../config.php";
conexao();


mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

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
$consulta = "$campo Like '$Codigo%' OR  Codigo_Fabricante LIKE '$Codigo' ";
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


//PEGANDO O VALOR DO CAMBIO
		$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda 
		WHERE cm.moeda_id = 2 AND moeda.id = 2 GROUP BY cm.id DESC limit 0,1 ";
		$rs_cambio = mysql_query($sql_cambio);
		$linha_cambio = mysql_fetch_array($rs_cambio);
 
		$vl_cambio_real = $linha_cambio['vl_cambio'];

	$rs    = mysql_query("SELECT id FROM produtos WHERE '$Codigo' = '$Codigo' ")or die (mysql_error().'-'.$rs);
	$totalProdutos = mysql_num_rows($rs);
	$rs    = mysql_query("SELECT p.Codigo,p.Descricao, p.Descricaoes, p.Estoque,p.Codigo_Fabricante, p.imagem, p.qtd_bloq, custo, 
	p.marca AS marcaid, p.grupo AS grupoid, p.peso,p.ref,
	p.id, (p.valor_a) AS valorA, 
	(p.valor_b) AS valorB, m.id AS idm,  m.nom_marca,
	g.id AS idg,g.nom_grupo
	FROM produtos p
	LEFT JOIN marcas m ON m.id = p.marca 
	LEFT JOIN grupos g ON g.id = p.grupo
	WHERE $consulta GROUP BY p.id ORDER BY p.$campo $order  LIMIT $inicio, $limite")or die (mysql_error().'-'.$rs);




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
		$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda 
		WHERE cm.moeda_id = 2 AND moeda.id = 2 GROUP BY cm.id DESC limit 0,1 ";
		$rs_cambio = mysql_query($sql_cambio);
		$linha_cambio = mysql_fetch_array($rs_cambio);
 
		$vl_cambio_real = $linha_cambio['vl_cambio'];
	
		$rs    = mysql_query("SELECT p.pr_min, p.Codigo_Fabricante, m.nom_marca, p.Codigo,p.Descricao, p.Descricaoes, p.Estoque, 
		p.qtd_bloq, p.marca AS marcaid, p.peso,p.ref,
		p.grupo AS grupoid, g.nom_grupo, (p.margen_a) AS margen_a, (p.margen_b) AS margen_b, 
		round(p.custo,2) AS custo, p.grupo, p.qtd_min, p.embalagem, p.local, p.iva, p.obs, p.id, 
		(p.valor_a) AS valorA, 
	(p.valor_b) AS valorB,  m.id AS idm,m.nom_marca,
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