<?PHP
	require_once ("../config.php");
	conexao();
	$query = $_POST['query'];
	
$r = mysql_query ("SELECT idcidade,nomecidade FROM cidades where nomecidade LIKE '%$query%' ORDER BY nomecidade ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$idcidade = mysql_result ($r,$i,"idcidade");
	$nomecidade = mysql_result ($r,$i, "nomecidade");
	
	if($i == ($l-1)) {
		$nomes .= '{idcidade:'.$idcidade.', nomecidade:"'.$nomecidade.'"}';
	}else{
		$nomes .= '{idcidade:'.$idcidade.', nomecidade:"'.$nomecidade.'"},';
	}
}

echo ('{resultados: [ '.$nomes.']}');

?>