<?php
include "../config.php";
require_once("../biblioteca.php");
conexao();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


$acao = $_POST['acao'];
$campo = $_POST['campo'];
if($campo == "3"){
$campo = "dt_vencimento";
}
$valor = $_POST['valor'];
$idforma = $_POST['idforma'];


if($acao == "Listar"){


	$rs = mysql_query("SELECT id,descricao,nm_total_parcela,dt_vencimento 
	FROM forma_pagamento WHERE editavel = 'S' ORDER BY id DESC ")or die (mysql_error().'-'.$rs);
	$totalFormas = mysql_num_rows($rs);
	
	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		
	}
	echo '({"totalFormas":"'.$totalFormas.'","Formas":'.json_encode($arr).'})'; 

}

if($acao == "alterar"){
$campo = $_POST['campo'];
$id = $_POST['id'];
$valor = $_POST['valor'];


		$sql_per = "UPDATE forma_pagamento SET dt_vencimento = '$valor' WHERE id = $id ";
		$exe_per = mysql_query($sql_per) or die (mysql_error()) ;
		



}




if($acao == "alterar"){








}


?>