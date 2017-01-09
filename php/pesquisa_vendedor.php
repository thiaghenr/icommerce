<?	
	require_once ("../config.php");
	conexao();
	
	
$r = mysql_query ("SELECT * FROM usuario ORDER BY id_usuario ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$id_user = mysql_result ($r,$i,"id_usuario");
	$usuario = mysql_result ($r,$i, "nome_user");
	
	if($i == ($l-1)) {
		$vendedor .= '{idvendedor:'.$id_user.', nome_vendedor:"'.$usuario.'"}';
	}else{
		$vendedor .= '{idvendedor:'.$id_user.', nome_vendedor:"'.$usuario.'"},';
	}
}

echo ('{resultados: [ '.$vendedor.']}');

?>