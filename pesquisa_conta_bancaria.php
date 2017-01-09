<?php
	require_once ("config.php");
    require_once("biblioteca.php");
	conexao();
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
	
	$query = $_POST['query'];
	$acao_nome = $_GET['acao_nome'];
	$acao = $_POST['acao'];
	$CodForn = $_POST['CodForn'];
	$user = $_POST['user'];

	
if($acao_nome == "NomeConta"){	
$r = mysql_query ("SELECT c.idconta_bancaria,c.nm_conta, m.nm_moeda, m.id FROM conta_bancaria c, moeda m where 1=1
					AND m.id = c.moeda ORDER BY c.idconta_bancaria ASC");
$l = mysql_num_rows ($r);



for($i=0;$i<$l;$i++){
	$idconta_bancaria = mysql_result ($r,$i,"idconta_bancaria");	
	$conta = mysql_result ($r,$i, "nm_conta");
	$moeda = mysql_result ($r,$i, "nm_moeda");
	$idmoeda = mysql_result ($r,$i, "id");

	$rs = mysql_query("SELECT vl_cambio,vl_cambio_compra FROM cambio_moeda 
					WHERE moeda_id = '$idmoeda'  ORDER BY id DESC LIMIT 0,1 ")or die (mysql_error().'-'.$rs);
					$objs = mysql_fetch_array($rs, MYSQL_ASSOC);
					$cbcompra = $objs['vl_cambio_compra'];
	
	if($i == ($l-1)) {
		$nomes .= '{idconta_bancaria:"'.$idconta_bancaria.'", cbcompra:"'.$cbcompra.'", idmoeda:"'.$idmoeda.'", conta:"'.$conta.' - '.$moeda.'  "}';
	}else{
		$nomes .= '{idconta_bancaria:"'.$idconta_bancaria.'", cbcompra:"'.$cbcompra.'", idmoeda:"'.$idmoeda.'", conta:"'.$conta.' - '.$moeda.'  "},';
	}
}

echo ('{resultados: [ '.$nomes.']}');
}
?>