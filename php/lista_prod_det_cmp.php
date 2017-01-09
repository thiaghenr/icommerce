<?php
include "../config.php";
conexao();

$Codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '' ;

	$rs    = mysql_query("SELECT ic.*, c.id_compra AS idcmp, c.fornecedor_id, date_format(c.data_lancamento, '%d/%m/%Y') AS data_lancamento, f.id AS fornid, f.nome, p.Codigo, p.id AS prodid FROM itens_compra ic, compras c, proveedor f, produtos p WHERE p.id = '$Codigo' AND ic.compra_id = c.id_compra AND p.Codigo = ic.referencia_prod AND f.id = c.fornecedor_id ORDER BY ic.id DESC limit 0,20 ")or die (mysql_error().'-'.$rs);
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