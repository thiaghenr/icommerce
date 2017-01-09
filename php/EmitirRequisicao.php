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


$acao = $_POST['acao'];

if($acao == "FinReq"){
$dados = $json->decode($_POST["dados"]);
$host = $_POST["host"];
$user = $_POST["user"];
$idForn = $_POST["idForn"];

//echo json_encode($dados) ;


	$sqlr = "INSERT INTO requisicao(idprovedor,datareq,user)
						VALUES('$idForn', NOW(), '$user')";
	$exer = mysql_query($sqlr, $base) or die (mysql_error() .' '.$sqlr);
	
	$idrequisicao = mysql_insert_id();

	for($i = 0; $i < count($dados); $i++){
	
	$idprod = $dados[$i]->idprod;
	$codprod = $dados[$i]->codprod;
	$descprod  = $dados[$i]->descprod; 
	$qtdprod  = $dados[$i]->qtdprod;
	$obsprod  = $dados[$i]->obsprod;
	
	$sql = "INSERT INTO itens_requisicao (idrequisicao,idproduto,qtdproduto,refproduto,descproduto,valorproduto,obsproduto)
				VALUES('$idrequisicao', '$idprod', '$qtdprod', '$codprod', '$descprod', '0', '$obsprod')";
	$exe = mysql_query($sql, $base);
	$rows_affected = mysql_affected_rows();	
	if ($rows_affected) $count++;

	}
	if ($count) {
	$response = array('success'=>'true', 'del_count'=>$count, 'Requisicao'=>$idrequisicao);			
	echo json_encode($response);
	} else {
	echo '{failure: true}';
	}








}






?>