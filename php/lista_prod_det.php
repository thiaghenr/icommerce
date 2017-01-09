<?php
include "../config.php";
conexao();

$Codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '' ;

	$rs    = mysql_query("SELECT pr.marca,pr.grupo, pr.Codigo_Fabricante, pr.Codigo_Fabricante2, pr.cod_original, pr.cod_original2, pr.custo, g.nom_grupo, g.id AS idg, m.nom_marca,m.id AS idm FROM produtos pr, grupos g, marcas m WHERE pr.id = '$Codigo' AND pr.grupo = g.id AND pr.marca = m.id ")or die (mysql_error().'-'.$rs);
	$totalProdutos = mysql_num_rows($rs);
	
	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		
	}
	echo '({"totalProdutos":"'.$totalProdutos.'","Produtos":'.json_encode($arr).'})'; 
//} 
?>