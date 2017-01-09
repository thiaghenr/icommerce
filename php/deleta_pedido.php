<?php
 require_once("../config.php");
 conexao();

$selectedRows = json_decode(stripslashes($_POST['id']));
$count        = 0;		

foreach($selectedRows as $row_id)
{
	$id  = (int) $row_id;
	
	$sql_pedido = "SELECT * FROM pedido WHERE id = '$id' AND situacao = 'A' ";
	$exe_pedido = mysql_query($sql_pedido, $base) or die (mysql_error());
	while ($reg_pedido = mysql_fetch_array($exe_pedido, MYSQL_ASSOC)){
	
		$pedido = $reg_pedido['id'];
	
	$sql_prod = "SELECT * FROM itens_pedido WHERE id_pedido = '$pedido' ";
    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
	while ($reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC)){
	
		$total_itens = $reg_prod['qtd_produto'];
		$codigo = $reg_prod['referencia_prod'];
		
		//ATUALIZA  BLOQUEADOS NO ESTOQUE
		$sql_prod_bloquiados = "UPDATE produtos SET qtd_bloq =  qtd_bloq - '".$total_itens."' WHERE Codigo = '".$codigo."' "; 
		$exe_prod_bloquiados = mysql_query($sql_prod_bloquiados, $base) or die (mysql_error().'-'.$sql_prod_bloquiados);
		//echo $sql_prod_bloquiados;
						
		//ATUALIZA QUANTIDADE NO ESTOQUE
		$sql_qtd = "UPDATE produtos SET  Estoque = Estoque + '".$total_itens."' WHERE Codigo = '".$codigo."' "; 
		$exe_qtd = mysql_query($sql_qtd, $base) or die (mysql_error().'-'.$sql_qtd);
		//echo $sql_qtd;
	
	$sql = "UPDATE pedido SET status = 'C' WHERE id = '$id' AND situacao = 'A' ";	
	$sql = sprintf($sql, $id);
	mysql_query($sql);
	$rows_affected = mysql_affected_rows();			
	if ($rows_affected) $count++;
	
		}
	}
}

if ($count) {
	$response = array('success'=>'true', 'del_count'=>$count);			
    echo "{success: true,response: 'PEDIDO ELIMINADO'}";
} else {
    echo "{success: false,response: 'Impossivel, Pedido ja Faturado'}";
}
?>