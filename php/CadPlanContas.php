<?php
include "../config.php";
conexao();
//include "../control.php";

 mysql_query("SET NAMES 'utf8'");
 mysql_query('SET character_set_connection=utf8');
 mysql_query('SET character_set_client=utf8');
 mysql_query('SET character_set_results=utf8');

if(isset($_POST['acao'])){
$acao = $_POST['acao'];
if($acao == "alterar"){
$campo = $_POST['campo'];
if($campo == "1"){
$campo = "nome_despesa";
}
$valor = $_POST['valor'];
$idDespesa = $_POST['idDespesa'];
	
	$sql_per = "UPDATE despesa SET $campo = UCASE('$valor') WHERE despesa_id = $idDespesa ";
	$exe_per = mysql_query($sql_per) or die (mysql_error()) ;

	
	}
	
if($acao == "novoPlano"){	
$nome_despesa = $_POST['nome_despesa'];
$receita = $_POST['receita'];

	$sql_ins = "INSERT INTO despesa
	(nome_despesa, receita_id)
	VALUES(UCASE('$nome_despesa'), '2')";
	$exe_ins = mysql_query($sql_ins, $base)  or die (mysql_error());
	
	echo "{success:true, response: 'Nono Plano Cadastrado' }"; 
	exit();
}

if($acao == "excluir"){
$idDespesa = $_POST['idDespesa'];
$user = $_POST['user'];


	$rs    = mysql_query("SELECT id_lanc_despesa, despesa_id FROM lanc_despesa WHERE despesa_id = $idDespesa  ")or die (mysql_error().'-'.$rs);
	$totalDespesas = mysql_num_rows($rs);
	
	if($totalDespesas == 0){
	$sql_del = "DELETE FROM despesa WHERE despesa_id = $idDespesa ";
	$exe_del = mysql_query($sql_del, $base)or die (mysql_error().'-'.$sql_del);
	echo "{success:true, response: 'PlanoExcluido' }"; 
	}
	else{
	echo "{success:true, response: 'LancamentoExistente' }"; 
	}
	exit();
}

	
}







$id = isset($_POST['id']) ? $_POST['id'] : '' ;

	$rs    = mysql_query("SELECT * FROM despesa  ")or die (mysql_error().'-'.$rs);
	$totalPlanos = mysql_num_rows($rs);
	
	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		
	}
	echo '({"totalPlanos":"'.$totalPlanos.'","Planos":'.json_encode($arr).'})'; 
//} 
?>