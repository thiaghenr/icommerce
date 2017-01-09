<?php
require_once("../biblioteca.php");
include "../config.php";
conexao();
include_once("json/JSON.php");
$json = new Services_JSON();
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

$dataini = substr($_POST['dataini'],0,10);
$datafim = substr($_POST['datafim'],0,10);

// $dataini = converte_data('2',$dataini);
$acao   = $_POST['acao'];
$produto = $_POST['produto'];
$entidade = $_POST['entidade'];


if($acao == 'buscaprods'){

$sqlprod = "SELECT iv.referencia_prod,iv.descricao_prod, sum(iv.qtd_produto) AS total,
			v.id
			FROM itens_venda iv, venda v
			WHERE v.id = iv.id_venda
			AND v.data_venda BETWEEN '$dataini' AND '$datafim 23:59:59.999'
			AND v.controle_cli = '$entidade' ";
if($produto){
$sqlprod .= " AND iv.idproduto = '$produto' ";	
}
$sqlprod .= " GROUP by iv.idproduto ORDER by iv.descricao_prod asc ";
	

$exeprod = mysql_query($sqlprod) or die(mysql_error().'-'.$sqlprod);
$total = mysql_num_rows($exeprod);
$arr = array();
while($obj = mysql_fetch_array($exeprod)){	
	
	$arr[] = array('referencia_prod'=>$obj['referencia_prod'], 'descricao_prod'=>$obj['descricao_prod'], 'total'=>$obj['total']);
	
}
echo '({"total":'.$total.',"results":'.json_encode($arr).'})'; 


}














?>