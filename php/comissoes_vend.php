<?php
include "../config.php";
conexao();

$acao = $_POST['acao'];
$vendedor = $_POST['vendedor'];
$dtini = substr($_POST['dtini'],0,10);
$dtfim = substr($_POST['dtfim'],0,10);

if($acao == "listaUser"){

	$sql = "SELECT p.id,v.valor_venda, p.vendedor_id,p.nome_cli, date_format(v.data_venda,'%d-%m-%Y') AS data_car, v.st_venda, v.controle_cli,
	 u.id_usuario,u.nome_user, u.porcentagem, round(v.valor_venda * u.porcentagem / 100) AS comissao
	 FROM venda v, usuario u, pedido p
	 WHERE p.vendedor_id = '$vendedor' 
	 AND p.vendedor_id = u.id_usuario 
	 AND v.pedido_id = p.id
	 AND v.data_venda BETWEEN '$dtini' 
	 AND '$dtfim 23:59:59.999' 
	 GROUP BY v.id "; // AND data_venda BETWEEN '$ini' AND '$fim' ";
	 $exe = mysql_query($sql);
	 $total = mysql_num_rows($exe);
	 while ($obj = mysql_fetch_array($exe, MYSQL_ASSOC)){
	 $arr[] = $obj;
	 $totalNotas += $obj['valor_venda'];
	 $totalComissao += $obj['comissao'];
	 $porcentagem = $obj['porcentagem'];
	
	 }
	
	echo '({"totalComissao":"'.$totalComissao.'","total":"'.$total.'", "Percentual":"'.$porcentagem.'", "totalNotas":"'.$totalNotas.'","results":'.json_encode($arr).'})'; 	
		
}
?>