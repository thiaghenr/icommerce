<?	
	require_once ("../config.php");
	conexao();
	$query = $_POST['query'];
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

	
$r = mysql_query ("SELECT * FROM marcas where nom_marca LIKE '%$query%' ORDER BY nom_marca ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$id = mysql_result ($r,$i,"id");
	$marca = mysql_result ($r,$i, "nom_marca");
	
	if($i == ($l-1)) {
		$marcas .= '{idmarca:'.$id.', marca:"'.$marca.'"}';
	}else{
		$marcas .= '{idmarca:'.$id.', marca:"'.$marca.'"},';
	}
}

echo ('{resultados: [ '.$marcas.']}');

?>