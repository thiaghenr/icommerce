<?	
	require_once ("../config.php");
	conexao();
	
	
$r = mysql_query ("SELECT * FROM forma_pagamento ORDER BY id ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$id = mysql_result ($r,$i,"id");
	$forma = mysql_result ($r,$i, "descricao");
	
	if($i == ($l-1)) {
		$formas .= '{idforma:'.$id.', forma:"'.$forma.'"}';
	}else{
		$formas .= '{idforma:'.$id.', forma:"'.$forma.'"},';
	}
}

echo ('{resultados: [ '.$formas.']}');

?>