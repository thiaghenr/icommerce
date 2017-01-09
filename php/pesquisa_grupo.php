<?	
	require_once ("../config.php");
	conexao();
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');
	
	
$r = mysql_query ("SELECT * FROM grupos ORDER BY nom_grupo ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$id = mysql_result ($r,$i,"id");
	$grupo = mysql_result ($r,$i, "nom_grupo");
	
	if($i == ($l-1)) {
		$grupos .= '{idgrupo:'.$id.', grupo:"'.$grupo.'"}';
	}else{
		$grupos .= '{idgrupo:'.$id.', grupo:"'.$grupo.'"},';
	}
}

echo ('{resultados: [ '.$grupos.']}');

?>