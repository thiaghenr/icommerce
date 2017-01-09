<?php
include "../config.php";
conexao();

$Codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '' ;

	$rs    = mysql_query("SELECT ip.*, p.id AS idped, p.nome_cli, p.controle_cli, date_format(p.data_car, '%d/%m/%Y') AS data_car, pr.id AS prodid,pr.Codigo FROM itens_pedido ip, pedido p, produtos pr  WHERE pr.id = '$Codigo' AND ip.id_pedido = p.id AND pr.Codigo = ip.referencia_prod ORDER BY p.id DESC limit 0,20 ")or die (mysql_error().'-'.$rs);
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