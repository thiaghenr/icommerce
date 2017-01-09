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

	
if($acao_nome == "NomeBanco"){	
$r = mysql_query ("SELECT * FROM banco where nome_banco LIKE '%$query%' ORDER BY nome_banco ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$id_banco = mysql_result ($r,$i,"id_banco");
	$nome_banco = mysql_result ($r,$i, "nome_banco");

	
	if($i == ($l-1)) {
		$nomes .= '{id_banco:'.$id_banco.',  nome_banco:"'.$nome_banco.' "}';
	}else{
		$nomes .= '{id_banco:'.$id_banco.',  nome_banco:"'.$nome_banco.' "},';
	}
}

echo ('{resultados: [ '.$nomes.']}');
}
?>