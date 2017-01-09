<?php
include "../config.php";
conexao();

$Codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '' ;

	$rs    = mysql_query("SELECT id, margen_a, margen_b, margen_c, custo, custo_medio, custo_anterior, custoagr FROM produtos WHERE id = '$Codigo' ")or die (mysql_error().'-'.$rs);
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