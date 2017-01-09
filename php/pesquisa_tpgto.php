<?	
	require_once ("../config.php");
	conexao();
	
$formapgto = $_POST['formapgto'];	

if($formapgto == 1){
$sql = "SELECT * FROM tipo_pagamento WHERE idtipo_pagamento > '1'  ORDER BY idtipo_pagamento ASC";
}
if($formapgto == 2){
$sql = "SELECT * FROM tipo_pagamento WHERE idtipo_pagamento < '3' ORDER BY idtipo_pagamento ASC";
}
if($formapgto == 3){
$sql = "SELECT * FROM tipo_pagamento WHERE idtipo_pagamento > '1' AND  idtipo_pagamento < '4' ORDER BY idtipo_pagamento ASC";
}
if($formapgto > 3 && $formapgto != 9){
$sql = "SELECT * FROM tipo_pagamento WHERE idtipo_pagamento < '4'  ORDER BY idtipo_pagamento ASC";
}
if($formapgto == 9){
$sql = "SELECT * FROM tipo_pagamento WHERE idtipo_pagamento < '3'  ORDER BY idtipo_pagamento ASC";
}
if($formapgto == 0){
$sql = "SELECT * FROM tipo_pagamento WHERE 1=1 ORDER BY idtipo_pagamento ASC";
}
$r = mysql_query ($sql);
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$idtipo_pagamento = mysql_result ($r,$i,"idtipo_pagamento");
	$tipo_pgto_descricao = mysql_result ($r,$i, "tipo_pgto_descricao");
	
	if($i == ($l-1)) {
		$formas .= '{idtipo_pagamento:'.$idtipo_pagamento.', tipo_pgto_descricao:"'.$tipo_pgto_descricao.'"}';
	}else{
		$formas .= '{idtipo_pagamento:'.$idtipo_pagamento.', tipo_pgto_descricao:"'.$tipo_pgto_descricao.'"},';
	}
}

echo ('{resultados: [ '.$formas.']}');

?>