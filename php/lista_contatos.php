<?php
include "../config.php";
conexao();
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 10 ;
$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';
$idcontato   = isset($_POST['id']) ? $_POST['id'] : '';

//if($acao == 'listarContatos'){
	$rs    = mysql_query("SELECT * FROM contatos WHERE clienteid = '$idcontato' ")or die (mysql_error());
	$totalContatos = mysql_num_rows($rs);
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '({"totalContatos":"'.$total.'","contatos":'.json_encode($arr).'})'; 
//} 
?>