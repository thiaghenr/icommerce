<?php
include "../config.php";
conexao();
//require_once("../verifica_login.php");

//require_once("../biblioteca.php");


////UPDATE NA TABELA //////////////////////////////////////////////
if(isset($_POST['campo'])){

$campo = $_POST['campo'];
$valor = $_POST['valor'];
$id = $_POST['id'];
$pedido = $_POST['pedido'];


$sql_pedido = "SELECT id,situacao FROM pedido WHERE id = '$pedido' ";
$exe_pedido = mysql_query($sql_pedido, $base) or die (mysql_error());
$reg_pedido = mysql_fetch_array($exe_pedido, MYSQL_ASSOC);
if ($reg_pedido['situacao'] == 'F'){
echo "Impossivel excluir este pedido, O mesmo ja se encontra Faturado";
exit;
}



if($campo == 5){
$sql_per = "UPDATE itens_pedido SET prvenda = '$valor' WHERE id = '$id' ";
$exe_per = mysql_query($sql_per) or die (mysql_error().'-'.$sql_per);

						//ATUALIZA TOTAL DA NOTA EM PEDIDO
						$sql_total = "SELECT id_pedido, sum(prvenda * qtd_produto) AS totalPedido FROM itens_pedido WHERE id_pedido = '$pedido' ";
						$exe_total = mysql_query($sql_total, $base);
						$reg_total = mysql_fetch_array($exe_total, MYSQL_ASSOC);
		
	    				$totalPedido = ($reg_total['totalPedido']);
		
						$total_pedido = "UPDATE pedido SET total_nota = '$totalPedido' WHERE id = '$pedido' ";
						$exe_total_pedido = mysql_query($total_pedido, $base);

						echo 'success';
}
////////////////////////////////////////////////////date_format(dt_abertura, '%d/%m/%Y') AS dt_abertura

if($campo == 6){

						$sql_pes_qtd_itens_prod	= "SELECT qtd_produto,id,referencia_prod FROM itens_pedido WHERE id = '$id' ";
						$rs_pes_qtd_itens_prod 	= mysql_query($sql_pes_qtd_itens_prod) or die (mysql_error().'-'.$sql_pes_qtd_itens_prod);
						$row_pes_qtd_itens_prod = mysql_fetch_array($rs_pes_qtd_itens_prod);
						$total_atual_itens_prod = $row_pes_qtd_itens_prod['qtd_produto'];
						$referencia_prod = $row_pes_qtd_itens_prod['referencia_prod'];
													
						//PESQUISA O TOTAL DE PRDUTOS QUE ESTAO BLOQUEADOS
						$sql_pes_prod = "SELECT qtd_bloq,Estoque,Codigo FROM produtos WHERE Codigo = '".$referencia_prod."' ";
						$rs_pes_prod = mysql_query($sql_pes_prod, $base) or die (mysql_error().'-'.$sql_pes_prod);
						$row_pes_prod = mysql_fetch_array($rs_pes_prod);
						//echo $sql_pes_prod;
						$total_prod_bloq = $row_pes_prod['qtd_bloq'];
						$total_prod_estoq = $row_pes_prod['Estoque'];
					
						//if(empty($total_prod_bloq)){
						//	$total_prod_bloq = 0 ;
						//}
						//CALCULA O TOTAL DE PRODUTOS PARA SER BLOQUEADO
						$total = ($total_prod_bloq - $total_atual_itens_prod) + $valor;
						$total_estoq = ($total_prod_estoq + $total_atual_itens_prod)  - $valor; 
						
						//ATUALIZA QUANTIDAE ITENS_PEDIDO
						$sql_alt = "UPDATE itens_pedido SET qtd_produto = '$valor' WHERE id = '$id' ";
						$exe_alt = mysql_query($sql_alt, $base) or die (mysql_error().'-'.$sql_alt);
								 
						//ATUALIZA  BLOQUEADOS NO ESTOQUE
						$sql_prod_bloquiados = "UPDATE produtos SET qtd_bloq = '".$total."' WHERE Codigo = '".$referencia_prod."' "; 
						$exe_prod_bloquiados = mysql_query($sql_prod_bloquiados, $base) or die (mysql_error().'-'.$sql_prod_bloquiados);
						//echo $sql_prod_bloquiados;
						
						//ATUALIZA QUANTIDADE NO ESTOQUE
						$sql_qtd = "UPDATE produtos SET  Estoque = '".$total_estoq."' WHERE Codigo = '".$referencia_prod."' "; 
						$exe_qtd = mysql_query($sql_qtd, $base) or die (mysql_error().'-'.$sql_qtd);
						//echo $sql_qtd;
						
						//ATUALIZA TOTAL DA NOTA EM PEDIDO
						$sql_total = "SELECT id_pedido, sum(prvenda * qtd_produto) AS totalPedido FROM itens_pedido WHERE id_pedido = '$pedido' ";
						$exe_total = mysql_query($sql_total, $base);
						$reg_total = mysql_fetch_array($exe_total, MYSQL_ASSOC);
		
	    				$totalPedido = ($reg_total['totalPedido']);
		
						$total_pedido = "UPDATE pedido SET total_nota = '$totalPedido' WHERE id = '$pedido' ";
						$exe_total_pedido = mysql_query($total_pedido, $base);
}

}

if(isset($_POST['acao'])){
$acao = $_POST['acao'];
$idProd = $_POST['idProd'];
$pedido = $_POST['pedido'];
if($acao == "addProd"){

	
	$sql_prod = "SELECT id,Codigo,Descricao,Estoque,valor_b FROM produtos WHERE id = '$idProd' ";
	$exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
	$row_prod = mysql_num_rows($exe_prod);
	$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC);
	
	
	
	$id = $reg_prod['id'];
	$Codigo = $reg_prod['Codigo'];
	$Descricao = $reg_prod['Descricao'];
	$valor = $reg_prod['valor_b'];
	$estoque = $reg_prod['Estoque'];
	$qtd_bloq = $reg_prod['qtd_bloq'];

				$sql_cont = "SELECT COUNT(*) AS n_prod FROM itens_pedido WHERE referencia_prod = '$Codigo' AND id_pedido = '$pedido' ";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
			    if ($reg_cont['n_prod'] > 0) {
					echo "{success:true, response: 'ProdutoJaAdicionado'}"; 
				}
				else{
				
				$sql_add = "INSERT INTO itens_pedido
							(id_pedido, referencia_prod, descricao_prod, prvenda, qtd_produto, id_prod)
							VALUES
						('".$pedido."','".mysql_escape_string($Codigo)."', '".mysql_escape_string($Descricao)."', '".$valor."', '1',  '".$id."' )";
				$exe_add = mysql_query($sql_add, $base) or die (mysql_error().'-'.$sql_add);	
					
  		$sql_qtd1 = "UPDATE produtos SET  qtd_bloq = qtd_bloq + '1' WHERE id = '".$id."'  ";
		$exe_qtd1 = mysql_query($sql_qtd1, $base) or die (mysql_error());
		$sql_qtd2 = "UPDATE produtos SET  Estoque = Estoque - '1' WHERE id = '".$id."'  ";
		$exe_qtd2 = mysql_query($sql_qtd2, $base) or die (mysql_error());
		
		$sql_total = "SELECT id_pedido, sum(prvenda * qtd_produto) AS totalPedido FROM itens_pedido WHERE id_pedido = '$pedido' GROUP BY id_pedido ";
		$exe_total = mysql_query($sql_total, $base);
		$reg_total = mysql_fetch_array($exe_total, MYSQL_ASSOC);
		
	    $totalPedido = ($reg_total['totalPedido']);
		
		$total_pedido = "UPDATE pedido SET total_nota = '$totalPedido' WHERE id = '$pedido' ";
		$exe_total_pedido = mysql_query($total_pedido, $base);
		
					echo "{success:true, response: 'ProdutoAdicionado'}";
				}
}
}
?>