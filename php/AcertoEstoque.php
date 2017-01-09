<?php
include "../config.php";
conexao();

$acao = $_POST['acao'];
$idProduto = $_POST['idProduto'];
$qtd = $_POST['qtd'];
$user = $_POST['user'];
$tipo = $_POST['tipo'];

if($tipo == 'EN'){
$movimento = "Entrada";
}
if($tipo == 'SA'){
$movimento = "Saida";
}

if($acao == 'Acertar'){

	$sql_prod = "SELECT id,Estoque FROM produtos WHERE id = '$idProduto' ";
	$exe_prod = mysql_query($sql_prod, $base);
	$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC);
	
	$estoque = $reg_prod['Estoque'];
	$id = $reg_prod['id'];

	if($tipo == 'EN'){
	$movimento = "Entrada";
	$total = $estoque + $qtd;
	}
	if($tipo == 'SA'){
	$movimento = "Saida";
	$total = $estoque - $qtd;
	}

	$sql_ins = "INSERT INTO acerto_estoque (id_produto, qtd_anterior, qtd_informada, tipo_es, user_resp, qtd_final, data_acerto)
				VALUES('$idProduto', '$estoque', '$qtd', '$movimento', '$user', '$total', NOW() )";
	$exe_ins = mysql_query($sql_ins, $base);
	
	$sql_up = "UPDATE produtos SET Estoque = '$total' WHERE id = '$idProduto' ";
	$exe_up = mysql_query($sql_up, $base);
	
	echo "{success: true,response: 'Alterado com Sucesso', idprod: $id }";

}

?>