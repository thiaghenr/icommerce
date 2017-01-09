<?php
include "../config.php";
conexao();
include_once("json/JSON.php");
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

$json = new Services_JSON();
function ajustaValor($v) {
		//$v = str_replace(".","",$v);
		$v = str_replace(",",".",$v);
		return $v;
	}

$dados = $json->decode($_POST["data"]);
$acao = $_POST["acao"];
$idcompra = $_POST["idcompra"];

if($acao == "Entrada"){
	
	
for($i = 0; $i < count($dados); $i++){
	
	$idcp    = isset($dados[$i]->id) ? $dados[$i]->id : false;
	$Codigo  = $dados[$i]->Codigo;
	$Descricao = $dados[$i]->Descricao;
	$Estoque  = $dados[$i]->Estoque;
	$custo  = $dados[$i]->custo;
	$custo = ajustaValor($custo);

	
	$sql_cons_estoque_prod = "SELECT Estoque,custo FROM produtos WHERE id = '$idcp' ";
	$exe_cons_estoque_prod = mysql_query($sql_cons_estoque_prod) or die (mysql_error().'-'.$sql_cons_estoque_prod);
	$row_cons_estoque_prod = mysql_fetch_array($exe_cons_estoque_prod, MYSQL_ASSOC);
	$qtd_prod_old = $row_cons_estoque_prod['Estoque'];
	$qtd_prod_new =  $qtd_prod_old + $Estoque;
	$custo_anterior = $row_cons_estoque_prod['custo'];
	$custo_atual = $custo;
	$custo_medio = ($custo_anterior + $custo_atual) / 2;
	
	$sql_ins = "INSERT INTO itens_compra (compra_id,referencia_prod,descricao_prod,prcompra,qtd_produto,idproduto)
							VALUES('$idcompra', '$Codigo', '$Descricao', '$custo', '$Estoque', '$idcp')";
	$exe_ins = mysql_query($sql_ins, $base);
	$rows_affected = mysql_affected_rows();			
	if ($rows_affected) $count++;
		
	$sql_up_estoque_prod = "UPDATE produtos SET custo = '$custo', Estoque = '$qtd_prod_new', custo_anterior = '$custo_anterior', 
							custo_medio = '$custo_medio' WHERE id = '$idcp' ";
	$exe_up_estoque_prod = mysql_query($sql_up_estoque_prod, $base);
	
	
	
	}
	
	$sql_status_compra = "UPDATE compras SET status = 'F' WHERE id_compra = '$idcompra' "; 
	$exe_status_compra = mysql_query($sql_status_compra) or die (mysql_error().'-'.$sql_status_compra);

	if ($count) {
	$response = array('success'=>'true', 'del_count'=>$count);			
	echo json_encode($response);
	} else {
	echo '{failure: true}';
	}
	exit();
}

	$sql_lista = "SELECT c.id_compra,c.fornecedor_id,c.nm_fatura,date_format(c.dt_emissao_fatura, '%d/%m/%Y') AS dt_emissao_fatura,
	c.vl_total_fatura, f.nome 
	FROM compras c, entidades f WHERE f.controle = c.fornecedor_id  AND c.status = 'A' "; 
	$exe_lista = mysql_query($sql_lista, $base);
	$totalcompras = mysql_num_rows($exe_lista);
		$arr = array();
		while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		$arr[] = $reg_lista;
		}
	
		echo '({"totalcompras":"'.$totalcompras.'","Compras":'.json_encode($arr).'})'; 

?>