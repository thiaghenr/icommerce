<?php
 require_once("../config.php");
 conexao();

$iditen = $_POST['iditen'];
$idpedido = $_POST['idpedido'];

$sql_pedido = "SELECT id,situacao FROM pedido WHERE id = '$idpedido' ";
$exe_pedido = mysql_query($sql_pedido, $base) or die (mysql_error());
$reg_pedido = mysql_fetch_array($exe_pedido, MYSQL_ASSOC);
if ($reg_pedido['situacao'] == 'F'){
echo "Impossivel excluir este iten, O pedido ja se encontra Faturado";
exit;
}

						$sql_pes_qtd_itens_prod	= "SELECT qtd_produto,id,referencia_prod FROM itens_pedido WHERE id = '$iditen' ";
						$rs_pes_qtd_itens_prod 	= mysql_query($sql_pes_qtd_itens_prod) or die (mysql_error().'-'.$sql_pes_qtd_itens_prod);
						$row_pes_qtd_itens_prod = mysql_fetch_array($rs_pes_qtd_itens_prod);
						
						$total_atual_itens_prod = $row_pes_qtd_itens_prod['qtd_produto'];
						$referencia_prod = $row_pes_qtd_itens_prod['referencia_prod'];
						$pedido = $row_pes_qtd_itens_prod['id_pedido'];
													
						//PESQUISA O TOTAL DE PRDUTOS QUE ESTAO BLOQUEADOS
						$sql_pes_prod = "SELECT qtd_bloq,Estoque,Codigo FROM produtos WHERE Codigo = '".$referencia_prod."' ";
						$rs_pes_prod = mysql_query($sql_pes_prod, $base) or die (mysql_error().'-'.$sql_pes_prod);
						$row_pes_prod = mysql_fetch_array($rs_pes_prod);
						//echo $sql_pes_prod;
						$total_prod_bloq = $row_pes_prod['qtd_bloq'];
						$total_prod_estoq = $row_pes_prod['Estoque'];
								 
						//ATUALIZA  BLOQUEADOS NO ESTOQUE
						$sql_prod_bloquiados = "UPDATE produtos SET qtd_bloq = qtd_bloq - '".$total_atual_itens_prod."' WHERE Codigo = '".$referencia_prod."' "; 
						$exe_prod_bloquiados = mysql_query($sql_prod_bloquiados, $base) or die (mysql_error().'-'.$sql_prod_bloquiados);
						//echo $sql_prod_bloquiados;
						
						//ATUALIZA QUANTIDADE NO ESTOQUE
						$sql_qtd = "UPDATE produtos SET  Estoque = Estoque + '".$total_atual_itens_prod."' WHERE Codigo = '".$referencia_prod."' "; 
						$exe_qtd = mysql_query($sql_qtd, $base) or die (mysql_error().'-'.$sql_qtd);
						//echo $sql_qtd;
	

						$sql = "DELETE FROM itens_pedido WHERE id = '$iditen' ";	
						$sql = sprintf($sql, $iditen);
						mysql_query($sql);
						$rows_affected = mysql_affected_rows();			
						if ($rows_affected) $count++;
						
						$sql_total = "SELECT id_pedido, sum(prvenda * qtd_produto) AS totalPedido FROM itens_pedido WHERE id_pedido = '$idpedido' GROUP BY id_pedido";
						$exe_total = mysql_query($sql_total, $base) or die (mysql_error().'-'.$sql_total);
						$reg_total = mysql_fetch_array($exe_total, MYSQL_ASSOC);
		
	    				$totalPedido = ($reg_total['totalPedido']);
						$total_pedido = "UPDATE pedido SET total_nota = '$totalPedido' WHERE id = '".$idpedido."' ";
						$exe_total_pedido = mysql_query($total_pedido, $base);

if ($count) {
//if($iditen > 0){
//$count = 1;
	$response = array('success'=>'true', 'del_count'=>$count);			
	echo 'ITEN ELIMINADO';
} else {
	echo '{failure: true}';
}
?>