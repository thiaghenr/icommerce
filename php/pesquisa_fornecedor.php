<?	
	require_once ("../config.php");
	conexao();
	$query = $_POST['query'];
	
$r = mysql_query ("SELECT id,nome FROM proveedor where nome LIKE '%$query%' ORDER BY nome ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$idforn = mysql_result ($r,$i,"id");
	$nomeforn = mysql_result ($r,$i, "nome");
	
	if($i == ($l-1)) {
		$nomes .= '{idforn:'.$idforn.', nomeforn:"'.$nomeforn.'"}';
	}else{
		$nomes .= '{idforn:'.$idforn.', nomeforn:"'.$nomeforn.'"},';
	}
}

echo ('{resultados: [ '.$nomes.']}');

?>