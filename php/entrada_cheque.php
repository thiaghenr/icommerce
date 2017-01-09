<?php
include "../config.php";
require_once("../biblioteca.php");
conexao();
include_once("json/JSON.php");
$json = new Services_JSON();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


if(isset($_POST['acao'])){ 
$acao = $_POST['acao'];

$user = $_POST['id_user'];
$host = $_POST['host'];
$idEnt = $_POST['idEnt'];
$idPedido = $_POST['idPedido'];
$dados = $json->decode($_POST['dados']);


	
if($acao == "CadChequeCli"){	
$acao = $_POST['acao'];

	for($i = 0; $i < count($dados); $i++){
	
	//$idIten    = isset($dados[$i]->id) ? $dados[$i]->id : false;
	$banco  = $dados[$i]->ref;
	$agencia  = $dados[$i]->agencia;
	$conta = $dados[$i]->conta;
	$num_cheque  = $dados[$i]->num_cheque;
	$data_validade  = substr($dados[$i]->data_validade,0,10);
	$emissor  = $dados[$i]->emissor;
	$moeda  = $dados[$i]->moeda;
	$valor  = $dados[$i]->valor;
	
	$total += $valor;
	if($moeda == "Dolares"){ $moeda = 1;} else{ $moeda = 3;}
	
			$re = mysql_query("select count(*) as total from cheque where conta = '$conta' AND num_cheque = '$num_cheque' ");
			$totalconsulta = mysql_result($re, 0, "total");
			
			if (0 == 0) {
			$sql_per = "INSERT INTO cheque (id_banco,agencia,conta, num_cheque, valor, data_dia, data_emissao, data_validade, 
			emissor, entidadeid, situacao, moeda, idPedido) 
			VALUES( '$banco', UCASE('$agencia'), UCASE('$conta'), UCASE('$num_cheque'), '$valor', NOW(), NOW(), '$data_validade', 
			UCASE('$emissor'), '$idEnt', 'AGUARDANDO', '$moeda', '$idPedido' )";
				$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
				$rows_affected = mysql_affected_rows();			
			if ($rows_affected) $count++;
			
			
			}
		}
		if ($count) {
		echo "{success:true, cheques: ".$count.", response: 'Novo Grupo Cadastrado' }"; 
		}
		else {
			echo '{failure: true}';
		}	
}
//////////////////////////////////////////////////////////////////////////////////////
if($acao == "excluir"){

}


if($acao == "xxxxxx"){


	$totalPlanos = mysql_num_rows($rs);
	
	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		
	}
	echo '({"totalGrupos":"'.$totalPlanos.'","Grupos":'.json_encode($arr).'})'; 
} 
}
?>