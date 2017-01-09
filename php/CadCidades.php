<?php
include "../config.php";
require_once("../biblioteca.php");
conexao();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


if(isset($_POST['acao'])){
$acao = $_POST['acao'];
if($acao == "alterar"){
$campo = $_POST['campo'];
if($campo == "1"){
$campo = "nomecidade";
}
$valor = $_POST['valor'];
$idcidade = $_POST['idcidade'];
	
	$sql_per = "UPDATE cidades SET $campo = UCASE('$valor') WHERE idcidade = $idcidade ";
	$exe_per = mysql_query($sql_per) or die (mysql_error()) ;

	
	}
	
if($acao == "novacidade"){	
$nomecidade = $_POST['nomecidade'];

	$sql_ins = "INSERT INTO cidades
	(nomecidade)
	VALUES(UCASE('$nomecidade'))";
	$exe_ins = mysql_query($sql_ins, $base)  or die (mysql_error());
	
	echo "{success:true, response: 'Nova Cidade Cadastrada' }"; 
	exit();
}

if($acao == "excluir"){
$idcidade = $_POST['idcidade'];
	
	$rs    = mysql_query("SELECT cidadeid FROM obras WHERE cidadeid = $idcidade  ")or die (mysql_error().'-'.$rs);
	$totalcidade = mysql_num_rows($rs);
	
	if($totalcidades == 0){
	$sql_del = "DELETE FROM cidades WHERE idcidade = $idcidade ";
	$exe_del = mysql_query($sql_del, $base)or die (mysql_error().'-'.$sql_del);
	echo "{success:true, response: 'CidadeExcluida' }"; 
	}
	else{
	echo "{success:true, response: 'LancamentoExistente' }"; 
	}
	exit();
}
////////////////////////////////////////////////////////////////////////////////

	
}


$id = isset($_POST['idcidade']) ? $_POST['idcidade'] : '' ;

	$rs    = mysql_query("SELECT idcidade, nomecidade FROM cidades ORDER BY nomecidade ASC ")or die (mysql_error().'-'.$rs);
	$totalPlanos = mysql_num_rows($rs);
	
	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		
	}
	echo '({"totalcidades":"'.$totalPlanos.'","Cidades":'.json_encode($arr).'})'; 

?>