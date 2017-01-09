<?php
require_once("../verifica_login.php");
include "../config.php";
conexao();

$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 30 ;
$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';

if($acao == 'listarFornecedor'){
	$rs    = mysql_query("SELECT id,nome FROM proveedor");

	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '({"fornecedores":'.json_encode($arr).'})'; 
} 
?>