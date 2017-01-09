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

$user = $_POST['user'];
$host = $_POST['host'];
$idEnt = $_POST['idforn'];
$emissaofat = substr($_POST['emissaofat'],0,10);
$idCompra = $_POST['idCompra'];
$total_nota = $_POST['total_nota'];
$nmfatura = $_POST['nmfatura'];
$dados = $json->decode($_POST['dados']);


	
if($acao == "CadChequeEmit"){	
$acao = $_POST['acao'];

	for($i = 0; $i < count($dados); $i++){
		$conta = $dados[$i]->conta;
		$valor  = $dados[$i]->valor;
		$idmoeda  = $dados[$i]->idmoeda;
		$cbcompra  = $dados[$i]->cbcompra;
		if($idmoeda == 1){
			$total += ($valor * $cbcompra);
		}
		else{
			$total += $valor;
		}
		
		
		$total += $valor;		
	}
		
	$update = "INSERT INTO compra_pgto (compra_id, pgto_id, vltotal_compra, vlpgto, status, user)
								VALUES( '$idCompra', '2', '$total_nota', '$total', 'A', '$user') ";
	$exe_update = mysql_query($update, $base) or die (mysql_error().'-'.$update);
	$idpgto = mysql_insert_id(); 
		
	for($i = 0; $i < count($dados); $i++){
	
	//$idIten    = isset($dados[$i]->id) ? $dados[$i]->id : false;
	$conta = $dados[$i]->conta;
	$num_cheque  = $dados[$i]->num_cheque;
	$data_validade  = substr($dados[$i]->data_validade,0,10);
	$emissor  = $dados[$i]->emissor;
	$idmoeda  = $dados[$i]->idmoeda;
	$cbcompra  = $dados[$i]->cbcompra;
	$valor  = $dados[$i]->valor;
	
	$total += $valor;
	
			$re = mysql_query("select count(*) as total from cheque_emit where numerocheque = '$num_cheque'  ");
			$totalconsulta = mysql_result($re, 0, "total");
			
			if (0 == 0) {
			$sql_per = "INSERT INTO cheque_emit (contabancoid, numerocheque, vlcheque, dtemissao, dtvencimento, compraid, entid, user, situacao, totalcheques, idpgto, moedaid, vlcambio) 
			VALUES( '$conta', UCASE('$num_cheque'), '$valor', NOW(), '$data_validade', '$idCompra', '$idEnt', '$user', 'A', '$total', '$idpgto', '$idmoeda', '$cbcompra' )";
				$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
				$rows_affected = mysql_affected_rows();			
			if ($rows_affected) $count++;
			
			
			}
		}
		
		if ($count) {
		echo "{success:true, cheques: ".$count.", response: 'Cheque Cadastrado' }"; 
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