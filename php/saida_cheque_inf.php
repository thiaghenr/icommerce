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


if($acao == "CadChequeEmit"){	
$total_nota = $_POST['total_nota']; 
$idpgto = $_POST['idpgto']; 
$emissaofat = converte_data('2',$_POST['emissaofat']);
$user = $_POST['user'];
$historico = $_POST['historico'];

	for($i = 0; $i < count($dados); $i++){
			
	}
		
	for($i = 0; $i < count($dados); $i++){
	
	$conta = $dados[$i]->conta;
	$num_cheque  = $dados[$i]->num_cheque;
	$idmoeda  = $dados[$i]->idmoeda;
	$valor  = $dados[$i]->valor;
	$idmoeda  = $dados[$i]->idmoeda;
	$cbcompra  = $dados[$i]->cbcompra;
	if($cbcompra == "")
		$cbcompra = 1;
		if($idmoeda == 1){
			$total += ($valor * $cbcompra);
		}
		else{
			$total += $valor;
		}		
		
	//$total += $valor;
	
			$re = mysql_query("select count(*) as total from cheque_emit where numerocheque = '$num_cheque'  ");
			$totalconsulta = mysql_result($re, 0, "total");
			
			$execompra = mysql_query("SELECT entidade_id FROM lancamento_caixa_balcao WHERE id = '$idpgto' ");
		    $regcompra = mysql_fetch_array($execompra, MYSQL_ASSOC);
			$idEnt = $regcompra['entidade_id'];
			
			if (0 == 0) {
			$sql_per = "INSERT INTO cheque_emit (contabancoid, numerocheque, vlcheque, dtemissao, dtvencimento, compraid, entid, 
						user, situacao, totalcheques, idpgto, moedaid, vlcambio, dt_lcto, historico) 
			VALUES( '$conta', UCASE('$num_cheque'), '$valor', '$emissaofat', '$emissaofat', '$idCompra', '$idEnt', 
			'$user', 'COMPENSADO', '$total', '$idpgto', '$idmoeda', '$cbcompra', NOW(), '$historico' )";
				$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
				$idCheque = mysql_insert_id();
				$rows_affected = mysql_affected_rows();			
			if ($rows_affected) $count++;
			}
		}
		
		if ($count) {
		
			$sqlup = "UPDATE lancamento_caixa_balcao SET changes = '1' WHERE id = '$idpgto' ";
			$exeup = mysql_query($sqlup, $base)or die (mysql_error().'-'.$sqlup);
			
			$sql_upc = "INSERT INTO conta_bancaria_lanc (idcontabancaria,dtlancamentoconta,valorlancamento,tipolancamento,historico,
								user,host,statuslancamento,idcheque_emit,contab,lctosis)
								VALUES('$conta', '$emissaofat', '$valor', '2', 'Emision. Cheque $num_cheque', '$user', '$host', 'DISP', '$idCheque', 'N', NOW() )";
			$exe_upc = mysql_query($sql_upc, $base);
			
		echo "{success:true, cheques: ".$count.", response: 'Cheque Cadastrado' }"; 
		}
		else {
			echo '{failure: true}';
		}	
}
//////////////////////////////////////////////////////////////////////////////////////
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