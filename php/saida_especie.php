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


	
if($acao == "CadContVista"){	
$acao = $_POST['acao'];

	for($i = 0; $i < count($dados); $i++){
		$valor  = $dados[$i]->valor;
		$total += $valor;
	}
	
	/*
	$update = "UPDATE compras SET fornecedor_id = '$idEnt', nm_fatura = '$nmfatura', dt_emissao_fatura = '$emissaofat', vl_total_fatura = '$total_nota',
				status = 'A', data_lancamento = NOW(), usuario_id = '$user' WHERE id_compra = '$idCompra' ";
	$exe_update = mysql_query($update, $base) or die (mysql_error().'-'.$update);
	*/
	
		$update = "INSERT INTO compra_pgto (compra_id, pgto_id, vltotal_compra, vlpgto, status, user)
								VALUES( '$idCompra', '4', '$total_nota', '$total', 'A', '$user') ";
		$exe_update = mysql_query($update, $base) or die (mysql_error().'-'.$update);
		$idpgto = mysql_insert_id(); 
		
	for($i = 0; $i < count($dados); $i++){
	
	//$idIten    = isset($dados[$i]->id) ? $dados[$i]->id : false;
	$conta = $dados[$i]->conta;
	$num_cheque  = $dados[$i]->num_cheque;
	$data_validade  = substr($dados[$i]->data_validade,0,10);
	$emissor  = $dados[$i]->emissor;
	$moeda  = $dados[$i]->moeda;
	$valor  = $dados[$i]->valor;
	
					
			$sql_per = "INSERT INTO pgto_temp (idcompra, compraid_pgto, ident, valor, nmfatura, user, formapgto  ) 
			VALUES( '$idCompra', '$idpgto', '$idEnt',  '$valor',  '$nmfatura',  '$user', '4' )";
				$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
				$rows_affected = mysql_affected_rows();			
			if ($rows_affected) $count++;
			
	}
	
		if ($count) {
		echo "{success:true, avista: ".$count.", response: 'Pago Catastrado' }"; 
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