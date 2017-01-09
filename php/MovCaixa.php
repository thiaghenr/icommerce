<?php
include "../config.php";
conexao();
require_once("../biblioteca.php");

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

$hoje = date("Y-m-d");
$acao = $_POST['acao'];


if($acao == "MovDia" || $acao == ""){

 $dia = isset($_POST['dataini']) ? $_POST['dataini'] : $hoje;
 $dia = substr($dia,0,10);
   


	$sql_lancamentos = "SELECT l.*, tp.tipo_pgto_descricao, date_format(l.dt_lanc_desp, '%d/%m/%Y %H:%i')AS data, e.nome FROM entidades e, lanc_contas l
	    LEFT JOIN tipo_pagamento tp ON tp.idtipo_pagamento = l.tipo_pgto_id
		WHERE l.dt_lanc_desp LIKE '$dia%' AND l.valor != '0' 
		AND e.controle = l.entidade_id AND l.tipo_pgto_id != '1' ORDER BY  l.dt_lanc_desp ASC ";
		$exe_lancamentos = mysql_query($sql_lancamentos) or die(mysql_error().'-'.$sql_lancamentos);
		$total = mysql_num_rows($exe_lancamentos);
		$arr = array();
		while($obj = mysql_fetch_array($exe_lancamentos, MYSQL_ASSOC)){
		
		$id = $obj['id_lanc_despesa'];
		$Historico = $obj['desc_desp'];
		$entidade = $obj['nome'];
		$doc = $obj['documento'];
		$data = $obj['data'];
		$tipo_pgto_descricao = $obj['tipo_pgto_descricao'];
		
		if($obj['receita_id'] == 1){
		$entrada =  $obj['valor'];
		$saida = 0;
		}
		if($obj['receita_id'] == 2){
		$saida =  $obj['valor'];
		$entrada = 0;
		}
		
		$saldo = $entrada - $saida;
		$saldos += $entrada - $saida;
		
	//	$arr[] = $obj;
		
	//echo '({"total":"'.$total.'","Entradas":"'.$Entradas.'","Saidas":"'.$Saidas.'","Trf":"'.$Trf.'","Movimento":'.json_encode($arr).'})'; 

		 $arr[] = array("id"=>$id, "dia"=>$dia, "entrada"=>$entrada, "saida"=>$saida, "Historico"=>$Historico, "entidade"=>$entidade,
						"doc"=>$doc, "data"=>$data, "tipo_pgto_descricao"=>$tipo_pgto_descricao, "saldo"=>$saldos);
	}
	 echo '({"total":"'.$total.'","Movimento":'.json_encode($arr).'})'; 


}


















?>