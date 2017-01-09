<?php
include "../config.php";
conexao();

$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 30 ;
$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';
$idUser = $_POST['idUser'];

if($acao == 'listarCargos'){
	$rs    = mysql_query("SELECT * FROM cargos");

	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '({"dados":'.json_encode($arr).'})'; 
}
 if($acao == 'listarDados'){
	$rs    = mysql_query("SELECT * FROM usuario");
	$total = mysql_num_rows($rs);
	$rs    = mysql_query("SELECT *  FROM usuario LIMIT $inicio, $limite");

	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}

	echo '({"total":"'.$total.'","dados":'.json_encode($arr).'})'; 
}
 if($acao == 'ListaUser'){
	$rs    = mysql_query("SELECT *,date_format(data_nascimento, '%d/%m/%Y') AS nascimento FROM usuario WHERE id_usuario = '$idUser' ");
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}

	echo '({"dados":'.json_encode($arr).'})'; 
	
}
?>