<?php
include "../config.php";
require_once("../biblioteca.php");
conexao();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


$acao = $_POST['acao'];


if($acao == "ListaBancos"){	

	$rs    = mysql_query("SELECT *	FROM banco ORDER BY id_banco ASC ")or die (mysql_error().'-'.$rs);
	$total = mysql_num_rows($rs);
	
	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		
	}
	echo '({"total":"'.$total.'","resultados":'.json_encode($arr).'})'; 
	
}	
	
if($acao == "NovoBanco"){	
 $CodigoBanco = $_POST['CodigoBanco'];
 $Banco = $_POST['Banco'];

	$sql_ins = "INSERT INTO banco
	(codigo_banco, nome_banco)
	VALUES(UCASE('$CodigoBanco'), UCASE('$Banco'))";
	$exe_ins = mysql_query($sql_ins, $base)  or die (mysql_error());
	
	echo "{success:true, response: 'Novo Banco Catastrado' }"; 
}






?>

