<?php
require_once("../verifica_login.php");
require_once("../biblioteca.php");
include "../config.php";
conexao();
include_once("json/JSON.php");
$json = new Services_JSON();
$id = $_POST['id'];
$jsonCheq = $json->decode($_POST['jsonSaidaCheque']);

$sql_caixa = "SELECT * FROM caixa WHERE status = 'A'";
$rs_caixa = mysql_query($sql_caixa);
$linha_caixa = mysql_fetch_array($rs_caixa, MYSQL_ASSOC);
$caixa_id = $linha_caixa['id'];

$sql_caixab = "SELECT id FROM caixa_balcao WHERE st_caixa = 'A' AND usuario_id = '$id_usuario' ";
$rs_caixab = mysql_query($sql_caixab);
$linha_caixab = mysql_fetch_array($rs_caixab, MYSQL_ASSOC);
$caixa_user = $linha_caixab['id'];


///// INICIO PAGAMENTO ////////////////////////////OBS:  PENDENTE FAZER VERIFICACAO DE VALOR
if(isset($_POST['acao'])){

function caixa($caixa_id,$valor,$compra_id,$idctpag,$recibo,$fornecedor,$idlanc){
$sql_lancamento_caixa = "INSERT INTO lancamento_caixa (receita_id, idlanc, caixa_id,data_lancamento,valor,compra_id,contas_pagar_id,num_nota,
			fornecedor_id,lanc_despesa_id,despesa_cod,historico,data_lancamentob)
            VALUES ('2', '$idlanc', '$caixa_id', NOW(), '$valor','$compra_id','$idctpag','$recibo','$fornecedor','136', 
			'2.01.05.02.000.00','Pago de Proveedores', NOW() )";
            $exe_lancamento_caixa = mysql_query($sql_lancamento_caixa) or die (mysql_error().'-'.$sql_lancamento_caixa);
			global $caixaid;
			$caixaid = mysql_insert_id();
}
function caixa_balcao($caixa_user,$valor,$compra_id,$idctpag,$recibo,$fornecedor,$idlanc){
$sql_lancamento_caixa = "INSERT INTO lancamento_caixa_balcao (receita_id, idlanc, caixa_id,dt_lancamento,descricao,vl_pago,compra_id,
							contas_pagar_id,entidade_id,num_nota,lanc_despesa_id,despesa_cod,dt_lancamentob)
            VALUES ('2', '$idlanc', '$caixa_user', NOW(), 'Pago de Proveedores', '$valor','$compra_id','$idctpag','$fornecedor','$recibo','136', '2.01.05.02.000.00', NOW() )";
            $exe_lancamento_caixa = mysql_query($sql_lancamento_caixa) or die (mysql_error().'-'.$sql_lancamento_caixa);
			global $caixaid;
			$caixaid = mysql_insert_id();
}
function cheques($jsonCheq,$fornecedor,$compra_id,$id_usuario,$valor,$idctpag,$recibo,$idlanc){

	for($i = 0; $i < count($jsonCheq); $i++){
	
	$conta = $jsonCheq[$i]->conta;
	$num_cheque  = $jsonCheq[$i]->num_cheque;
	$data_validade  = substr($jsonCheq[$i]->data_validade,0,10);
	$valor  = $jsonCheq[$i]->valor;
	$moeda  = $jsonCheq[$i]->idmoeda;
	$cbcompra  = $jsonCheq[$i]->cbcompra;
	
		$total += $valor;
	
			$re = mysql_query("select count(*) as total from cheque where conta = '$conta' AND num_cheque = '$num_cheque' ");
			$totalconsulta = mysql_result($re, 0, "total");
			
			if (0 == 0) {
			$sql_per = "INSERT INTO cheque_emit (idlanc,contabancoid, numerocheque, vlcheque, dtemissao, dtvencimento, compraid, 
			entid, user, situacao, totalcheques, idplano, moedaid, vlcambio, historico, dt_lcto) 
			VALUES( '$idlanc', '$conta', UCASE('$num_cheque'), '$valor', NOW(), '$data_validade', '$compra_id', '$fornecedor', ".$id_usuario.", 'COMPENSADO', 
			'$total', '136', '$moeda', '$cbcompra', 'Pago de Proveedores', NOW() )";
				$exe_per = mysql_query($sql_per) or die (mysql_error().'-'.$sql_per);
				$rows_affected = mysql_affected_rows();			
			$idCheque = mysql_insert_id();
			if ($rows_affected) $count++;
			
			$sql_upc = "INSERT INTO conta_bancaria_lanc (idcontabancaria,dtlancamentoconta,valorlancamento,tipolancamento,historico,
								user,host,statuslancamento,idcheque_emit,contab,lctosis)
								VALUES('$conta', '$dt_fatura', '$valor', '2', 'Emision. Cheque $num_cheque', '$user', '$host', 'DISP', '$idCheque', 'N', NOW() )";
			$exe_upc = mysql_query($sql_upc, $base) or die (mysql_error().'-'.$sql_upc);
			
			
			}
	}

}

if($_POST['acao'] == 'novopg'){
	if($_POST['formapgto'] == "cxuser" && $caixa_user == ""){
			echo "{success:true, response: 'Usuario sin caja abierto'}";
			exit();
		}
$idctpag = $_POST['idctpag'];
$data = substr($_POST['data_ct_parcial'],0,10);
$recibo = $_POST['numero_recibo'];
$valor = ($_POST['valor_parcial']);


$sql_verif = "SELECT cp.vl_parcela, cp.vl_pago, cp.vl_juro, cp.vl_multa, cp.vl_desconto, cp.id, cp.fornecedor_id, cp.compra_id, 
cpp.idcontas_pagarParcial, cpp.contas_pagar_id, sum(cpp.valor_parcial) AS ValorParcial 
FROM contas_pagar cp, contas_pagarparcial cpp WHERE cp.id = '$idctpag' AND cp.id = cpp.contas_pagar_id ";
$exe_verif = mysql_query($sql_verif, $base);
$reg_verif = mysql_fetch_array($exe_verif, MYSQL_ASSOC);

$compra_id = $reg_verif['compra_id'];
$fornecedor = $reg_verif['fornecedor_id'];

$ValorPagoParcial = $reg_verif['ValorParcial'];
$ValorParcela = $reg_verif['vl_parcela'];
$ValorJuro = $reg_verif['vl_juro'];
$ValorMulta = $reg_verif['vl_multa'];
$ValorDesconto = $reg_verif['vl_desconto'];

  $total_nota = ($ValorParcela + $ValorJuro + $ValorMulta) - ($ValorPagoParcial + $ValorDesconto);

if($total_nota >= $valor){ 
$sql_ins = "INSERT INTO contas_pagarparcial (contas_pagar_id, valor_parcial, data_ct_parcial, numero_recibo, user_id)
										VALUES('$idctpag', '$valor', '$data', '$recibo', '".$id_usuario."' ) ";
$exe_ins = mysql_query($sql_ins) or die (mysql_error().'-'.$sql_ins);

function lancContas($caixapgto,$recibo,$valor,$id_usuario,$data,$fornecedor){
		$sql_plan = "INSERT INTO lanc_contas (plano_id,tipo_pgto_id,plan_codigo,documento,dt_lanc_desp,desc_desp,valor,
		usuario_id,receita_id, dt_fatura_desp, valor_total,entidade_id, dt_lanc_despb) ";
		$sql_plan.= "VALUES ('136', '$caixapgto', '2.01.05.02.000.00', '$recibo', NOW(), 'Pago de Proveedores', '$valor', 
		'".$id_usuario."', '2', '$data', '$valor', '$fornecedor', NOW() )";
		mysql_query($sql_plan) or die (mysql_error());	
		global $idlanc;
		$idlanc = mysql_insert_id();
		}
		
		
		if($_POST['formapgto'] == "cxempr"){
		$caixapgto = '4';
		lancContas($caixapgto,$recibo,$valor,$id_usuario,$data,$fornecedor);
		caixa($caixa_id,$valor,$compra_id,$idctpag,$recibo,$fornecedor,$idlanc);
		//$caixaori = "caixaid_emp";
		}
		if($_POST['formapgto'] == "cxuser"){
		$caixapgto = '4';
		lancContas($caixapgto,$recibo,$valor,$id_usuario,$data,$fornecedor);
		caixa_balcao($caixa_user,$valor,$compra_id,$idctpag,$recibo,$fornecedor,$idlanc);
		//$caixaori = "caixaid";
		}
		if($_POST['formapgto'] == "cheque"){
		$caixapgto = '2';
		lancContas($caixapgto,$recibo,$valor,$id_usuario,$data,$fornecedor);
		cheques($jsonCheq,$fornecedor,$compra_id,$id_usuario,$valor,$idctpag,$recibo,$idlanc);
		}
	
	if($total_nota == $valor){

	$sql_grava = "UPDATE contas_pagar SET status = 'P' WHERE id = '$idctpag' ";
	$exe_grava = mysql_query($sql_grava, $base);
	}
	
	echo "{success:true, response: 'Pagado'}";
}

if($valor > $total_nota){
echo "{success:true, response: 'Valor mayor que la deuda'}";
exit();
}
			$sql_cont = "SELECT COUNT(*) AS aberto FROM contas_pagar WHERE status = 'A' AND compra_id = '$compra_id' ";
			$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
			$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
						
			if ($reg_cont['aberto'] == 0) {
			$sql_fecha = "UPDATE compras SET status = 'F' WHERE id_compra = '$compra_id' ";
			$exe_fecha = mysql_query($sql_fecha);
			}


}
}
////////////// FIM PAGAMENTO ////////////////////////////////////////////

/////////INICIO DELETAR /////////////////////////////////////////////////
if(isset($_POST['acao'])){
if($_POST['acao'] == 'deletar'){
$selectedRows = json_decode(stripslashes($_POST['id_pago']));
$count        = 0;		

foreach($selectedRows as $row_id)
{
	$id  = (int) $row_id;
	$sql = "DELETE FROM contas_pagarparcial WHERE idcontas_pagarParcial = %d";	
	$sql = sprintf($sql, $id);
	mysql_query($sql);
	$rows_affected = mysql_affected_rows();			
	if ($rows_affected) $count++;
}

if ($count) {
	$response = array('success'=>'true', 'del_count'=>$count);			
	echo json_encode($response);
} else {
	echo '{failure: true}';
}

}}
////////FIM DELETAR


if(isset($_POST['acao'])){
if($_POST['acao'] == 'listarDados'){
$id = $_POST['id'];

$rs    = mysql_query("SELECT cpp.idcontas_pagarParcial, cpp.contas_pagar_id, sum(cpp.valor_parcial) AS totalpago, cpp.numero_recibo, 
cpp.user_id, cpp.compra_id,   date_format(cpp.data_ct_parcial, '%d/%m/%Y')AS datapgto, cp.id, cp.compra_id  
FROM contas_pagarparcial cpp, contas_pagar cp 
WHERE cp.id = '$id' AND cp.id = cpp.contas_pagar_id GROUP BY cpp.idcontas_pagarParcial asc")or die (mysql_error());	

$arr = array();
$total = mysql_num_rows($rs);
while($obj = mysql_fetch_object($rs))
{	
	$arr[] = $obj;
	
}

//echo $_GET['callback'].'({"result":'.json_encode($arr).'})'; 
echo '({"total":'.$total.',"result":'.json_encode($arr).'})'; 
}
}
?>