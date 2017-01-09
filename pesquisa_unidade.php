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

	
if($acao_nome == "DescUnid"){	
$r = mysql_query ("SELECT idunidade_medida,desc_medida FROM unidade_medida where desc_medida LIKE '%$query%' ORDER BY idunidade_medida ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$idunidade_medida = mysql_result ($r,$i,"idunidade_medida");
	$desc_medida = mysql_result ($r,$i, "desc_medida");
	
	if($i == ($l-1)) {
		$nomes .= '{idunidade_medida:'.$idunidade_medida.',  desc_medida:"'.$desc_medida.'"}';
	}else{
		$nomes .= '{idunidade_medida:'.$idunidade_medida.',  desc_medida:"'.$desc_medida.'"},';
	}
}

echo ('{resultados: [ '.$nomes.']}');
}
?>