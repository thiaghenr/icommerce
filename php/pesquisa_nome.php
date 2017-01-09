<?	
	require_once ("../config.php");
	conexao();
	$query = $_POST['query'];
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');
	
$r = mysql_query ("SELECT controle,nome FROM entidades where nome LIKE '%$query%' ORDER BY nome ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$id = mysql_result ($r,$i,"controle");
	$marca = mysql_result ($r,$i, "nome");
	
	if($i == ($l-1)) {
		$nomes .= '{idcli:'.$id.', nome:"'.$marca.'"}';
	}else{
		$nomes .= '{idcli:'.$id.', nome:"'.$marca.'"},';
	}
}

echo ('{resultados: [ '.$nomes.']}');

?>