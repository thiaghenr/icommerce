<?php
require_once("../biblioteca.php");
include "../config.php";
conexao();
include_once("JSON/JSON.php");
$json = new Services_JSON();

$dados = $json->decode($_POST["data"]);
function ajustaValores($v) {
		$v = str_replace(".","",$v);
		$v = str_replace(".","",$v);
		$v = str_replace(".","",$v);
		$v = str_replace(",",".",$v);
		$v = str_replace("$","",$v);
		return $v;
	}

	
	
	$sql_caixa = "SELECT id,status FROM caixa WHERE status = 'A' order by id desc ";
	$exe_caixa = mysql_query($sql_caixa);
	$reg_caixa = mysql_fetch_array($exe_caixa, MYSQL_ASSOC);
	$caixa = $reg_caixa['id'];	

for($i = 0; $i < count($dados); $i++){
	
	$idcp    = isset($dados[$i]->idcp) ? $dados[$i]->idcp : false;
	$vl_pago  = $dados[$i]->vl_pago;
	$vl_parcela = $dados[$i]->vl_parcela;
	$juros  = $dados[$i]->juros;
	$statuss  = $dados[$i]->statuss ? "TRUE" : "FALSE";
	$descontos  = $dados[$i]->descontos;
	$compra_id  = $dados[$i]->compra_id;
	$fornecedor_id  = $dados[$i]->ctproveedor_id;
	
	$vl_pago = ajustaValores($vl_pago);
	$juros = ajustaValores($juros);
	$descontos = ajustaValores($descontos);
	if($statuss == "TRUE"){ $status = "S";}
	if($statuss == "FALSE") { $status = "A";}
	
	$total = ($vl_parcela + $juros) - $vl_pago - $descontos;
	$total = ajustaValor($total);
	//$ajustaValores = $total * $vl_cambio_guarani;
	
	$sql = "UPDATE contas_pagar SET status = '$status', vl_pago = '$vl_parcela', vl_juro = '$juros', vl_desconto = '$descontos',
	dt_pgto_parcela = NOW()
	WHERE id = '$idcp' ";	
	mysql_query($sql) or die (mysql_error());
	$rows_affected = mysql_affected_rows();			
	if ($rows_affected) $count++;


	if($status == "S"){
		$sql_ins = "INSERT INTO lancamento_caixa (receita_id, caixa_id, data_lancamento, valor, venda_id, contas_pagar_id, fornecedor_id, lanc_despesa_id)
										VALUES('2', '$caixa', NOW(), '$total', '$compra_id', '$idcp', '$fornecedor_id', '$despesa_id' ) ";
	$exe_ins = mysql_query($sql_ins) or die (mysql_error().'-'.$sql_ins);
	}	
	
}	


if ($count) {
	$response = array('success'=>'true', 'del_count'=>$count);			
	echo json_encode($response);
} else {
	echo '{failure: true}';
}
?>