<?php
require_once("../verifica_login.php");
require_once("../biblioteca.php");
include "../config.php";
conexao();
$id = $_POST['id'];

$sql_caixa = "SELECT * FROM caixa WHERE status = 'A'";
$rs_caixa = mysql_query($sql_caixa);
$linha_caixa = mysql_fetch_array($rs_caixa, MYSQL_ASSOC);
$caixa_id = $linha_caixa['id'];


///// INICIO PAGAMENTO ////////////////////////////OBS:  PENDENTE FAZER VERIFICACAO DE VALOR
if(isset($_POST['acao'])){
if($_POST['acao'] == 'novopg'){

$idctpag = $_POST['idctpag'];
$data = converte_datat('2',$_POST['data_ct_parcial']);
$recibo = $_POST['numero_recibo'];
$valor = ajustaValor($_POST['valor_parcial']);

$sql_verif = "SELECT cp.vl_parcela, cp.vl_pago, cp.vl_juro, cp.vl_multa, cp.vl_desconto, cp.id, cp.fornecedor_id, cp.compra_id, cpp.idcontas_pagarParcial, cpp.contas_pagar_id, sum(cpp.valor_parcial) AS ValorParcial FROM contas_pagar cp, contas_pagarparcial cpp WHERE cp.id = '$idctpag' AND cp.id = cpp.contas_pagar_id ";
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

$sql_lancamento_caixa = "INSERT INTO lancamento_caixa (receita_id,caixa_id,data_lancamento,valor,venda_id,contas_pagar_id,num_nota,fornecedor_id,lanc_despesa_id)
            VALUES ('2','$caixa_id', NOW(), '$valor','$compra_id','$idctpag','$recibo','$fornecedor','$despesa_id ')";
            $exe_lancamento_caixa = mysql_query($sql_lancamento_caixa) or die (mysql_error().'-'.$sql_lancamento_caixa);

$sql_grava = "UPDATE contas_pagar SET vl_pago =  (vl_pago + '$valor') WHERE id = '$idctpag' ";
$exe_grava = mysql_query($sql_grava, $base);
}
 
 
 
if($total_nota == $valor){

$sql_grava = "UPDATE contas_pagar SET status = 'P', vl_pago = '$valor' WHERE id = '$idctpag' ";
$exe_grava = mysql_query($sql_grava, $base);
}
			$sql_cont = "SELECT COUNT(*) AS aberto FROM contas_pagar WHERE status = 'A' AND compra_id = '$compra_id' ";
			$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
			$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
						
			if ($reg_cont['aberto'] == 0) {
			$sql_fecha = "UPDATE compras SET status = 'F' WHERE id_compra = '$compra_id' ";
			$exe_fecha = mysql_query($sql_fecha);
			}

echo '{sucess: true}'; 
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

$rs    = mysql_query("SELECT cpp.idcontas_pagarParcial, cpp.contas_pagar_id, sum(cpp.valor_parcial) AS totalpago, cpp.numero_recibo, cpp.user_id, cpp.compra_id,   date_format(cpp.data_ct_parcial, '%d/%m/%Y')AS datapgto, cp.id, cp.compra_id  FROM contas_pagarparcial cpp, contas_pagar cp WHERE cp.id = '$id' AND cp.id = cpp.contas_pagar_id GROUP BY cpp.idcontas_pagarParcial asc")or die (mysql_error());	

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