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

	
if($acao_nome == "DescProd"){	
$r = mysql_query ("SELECT id,Descricao,Codigo FROM produtos where Descricao LIKE '%$query%' ORDER BY Descricao ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$idprod = mysql_result ($r,$i,"id");
	$descprod = mysql_result ($r,$i, "Descricao");
	$codigo = mysql_result ($r,$i, "Codigo");

	
	if($i == ($l-1)) {
		$nomes .= '{idprod:'.$idprod.',  descprod:"'.$descprod.' - '.$codigo.'"}';
	}else{
		$nomes .= '{idprod:'.$idprod.',  descprod:"'.$descprod.' - '.$codigo.'"},';
	}
}

echo ('{resultados: [ '.$nomes.']}');
}
?>