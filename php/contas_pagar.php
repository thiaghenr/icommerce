<?php
include "../config.php";
conexao();
//require_once("../verifica_login.php");

 mysql_query("SET NAMES 'utf8'");
 mysql_query('SET character_set_connection=utf8');
 mysql_query('SET character_set_client=utf8');
 mysql_query('SET character_set_results=utf8');

//require_once("../biblioteca.php");


////UPDATE NA TABELA //////////////////////////////////////////////
if(isset($_POST['campo'])){

$campo = $_POST['campo'];
if($campo == 5){ $campo = 'qtd_produto'; }
if($campo == 6){ $campo = 'custo'; }
if($campo == 7){ $campo = 'juros'; }
if($campo == 8){ $campo = 'descontos'; }
if($campo == 10){ $campo = 'pagoprov'; }

$valor = $_POST['valor'];
if($valor == 'true'){ $valor = 'S';}
if($valor == 'false'){ $valor = 'N';}
$id = $_POST['id'];

//if($campo == 4){
$sql_per = "UPDATE contas_pagar SET $campo = '$valor' WHERE id = '$id' ";
$exe_per = mysql_query($sql_per) or die (mysql_error()) ;

	echo 'success';
}
////////////////////////////////////////////////////date_format(dt_abertura, '%d/%m/%Y') AS dt_abertura


$cotacao = $_GET['cotacao'];

$rs    = mysql_query("SELECT pr.nome,pr.controle AS idprov, cp.vl_total_fatura, cp.fornecedor_id, cp.nm_parcela,
cp.status, date_format(cp.dt_vencimento_parcela, '%d/%m/%Y')AS vencimento, cp.vl_parcela,  
cp.vl_juro, cp.vl_multa, cp.vl_desconto, cp.compra_id, cp.id AS idcp, 
cpp.idcontas_pagarParcial, cpp.contas_pagar_id, sum(cpp.valor_parcial)  AS totalpago  
FROM contas_pagar cp
LEFT JOIN contas_pagarparcial cpp ON cpp.contas_pagar_id = cp.id 
LEFT JOIN entidades pr ON  pr.controle = cp.fornecedor_id
WHERE cp.status = 'A'  
GROUP BY cp.id
ORDER BY pr.controle asc")or die (mysql_error());	
$arr = array();
$total = mysql_num_rows($rs);
while($obj = mysql_fetch_array($rs))
{	
	$arr[] = $obj;
	
}

//echo $_GET['callback'].'({"result":'.json_encode($arr).'})'; 
echo '({"total":'.$total.',"result":'.json_encode($arr).'})'; 
?>