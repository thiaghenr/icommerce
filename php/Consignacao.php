<?php
require_once("../verifica_login.php");
require_once("../biblioteca.php");
include "../config.php";
conexao();

include_once("json/JSON.php");
$json = new Services_JSON();

header("Content-Type: text/html; charset=iso-8859-1");
 mysql_query("SET NAMES 'utf8'");
 mysql_query('SET character_set_connection=utf8');
 mysql_query('SET character_set_client=utf8');
 mysql_query('SET character_set_results=utf8');
 
 
$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 6 ;
$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';
if($acao == 'Listar' &&  !(isset($_POST['query']))) {
$query = isset($_POST['query']) ? $_POST['query'] : 1;
 
	$rss = mysql_query("SELECT csg_idconsignacao FROM consignacao WHERE csg_status = 'A' ");
	$rs = mysql_query("SELECT c.*, date_format(c.csg_data, '%d/%m/%Y') AS csg_data, e.nome, u.usuario 
	FROM consignacao c, entidades e, usuario u
	WHERE e.controle = c.csg_entidadeid AND c.csg_status = 'A' AND u.id_usuario = c.csg_usuarioid ORDER BY c.csg_idconsignacao DESC  
	LIMIT $inicio, $limite ")or die (mysql_error());
 
	$total  =mysql_num_rows($rss);
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '{"total":'.$total.',"results":'.json_encode($arr).'}'; 
} 

if($acao == 'ListaItens'){
$idconsig = $_POST['idconsig'];
 
	$rs = mysql_query("SELECT it.*, p.Codigo_Fabricante, p.peso,p.id FROM itens_consig it, produtos p 
	WHERE it.itcsg_produtoid = p.id AND it.itcsg_consigid = '$idconsig' ORDER BY it.itcsg_descricao ASC ")or die (mysql_error());
	$total  =mysql_num_rows($rs);
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '{"total":'.$total.',"Itens":'.json_encode($arr).'}'; 
 
 
 
 
 }
 
 if($acao == 'ListaItensEnt'){
$entidade = $_POST['idforn'];
$filtro = $_POST['filtro'];//	sim
$pesquisa = $_POST['pesquisa'];	//04itcsg_referencia
$coluna = $_POST['coluna'];
 
	$sql = "SELECT it.*, date_format(c.csg_data, '%d/%m/%Y') AS csg_data, sum(it.itcsg_qtd - it.itcsg_dev - it.itcsg_fat) AS qtd_pend FROM consignacao c
	LEFT JOIN itens_consig it ON it.itcsg_consigid = c.csg_idconsignacao ";
	$sql .= " WHERE c.csg_entidadeid = '$entidade' ";
	if($filtro == "sim" ){
	$sql .= " AND it.$coluna LIKE '$pesquisa%' ";
	}
	$sql .= " GROUP BY it.itcsg_iditensconsig HAVING qtd_pend != 0 ";
	$rs = mysql_query($sql)or die (mysql_error());
	$total  =mysql_num_rows($rs);
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '{"total":'.$total.',"Itens":'.json_encode($arr).'}'; 
 
 }
 
if($acao == 'Movimentar'){
$entidade = $_POST['idforn'];
$movimento = $_POST['movimento'];
$dados = $json->decode($_POST["dados"]);

$mes_milli = 2592000;
$data_atual = date('Y-m-d');
$dt_atual_milli = strtotime($data_atual);
if($datavencimento == ""){
    $dt_atual_milli = ($dt_atual_milli + $mes_milli);
    $dt_new = date("Y-m-d",($dt_atual_milli));
}
else{
	$dt_new = $datavencimento;
}
	
	
		for($i = 0; $i < count($dados); $i++){
			$id_itid = $dados[$i]->id_itid;
			$idprod = $dados[$i]->idprod;
			$idforn = $dados[$i]->idforn;
			$qtd_produto  = $dados[$i]->qtd_produto; 
			
			if($movimento == "Devolver"){
						
				$sqlup = "UPDATE itens_consig SET itcsg_dev = itcsg_dev + '$qtd_produto', itcsg_transf = itcsg_transf +'$qtd_produto' 
							WHERE itcsg_iditensconsig = '$id_itid' ";
				$exeup = mysql_query($sqlup) or die (mysql_error().'-'.$sqlup);
				$sqlupe = "UPDATE produtos SET Estoque = Estoque + '$qtd_produto' WHERE id = '$idprod' ";
				$exeupe = mysql_query($sqlupe) or die (mysql_error().'-'.$sqlupe);
				$rows_affected = mysql_affected_rows();			
				if ($rows_affected) $count++;
					/*
					if ($count) {
						$response = array('success'=>'true', 'count'=>$count, 'Pedido'=>$id_pedido);			
						echo json_encode($response);
					} 
					else {
						echo '{failure: true}';
					}
					*/
			}
			
			if($movimento == "Facturar"){
			
				$sqlup = "UPDATE itens_consig SET itcsg_fat = itcsg_fat + '$qtd_produto', itcsg_transf = itcsg_transf +'$qtd_produto' 
							WHERE itcsg_iditensconsig = '$id_itid' ";
				$exeup = mysql_query($sqlup) or die (mysql_error());
				
			
			}

		}
		if($movimento == "Devolver"){
			if ($count) {
						$response = array('success'=>'true', 'count'=>$count, 'Pedido'=>$id_pedido);			
						echo json_encode($response);
					} 
					else {
						echo '{failure: true}';
					}
		
		}
		
		
		if($movimento == "Facturar"){
			$exe = mysql_query("SELECT nome FROM entidades WHERE controle = '$entidade' ");
			$reg = mysql_fetch_array($exe, MYSQL_ASSOC);
			$nomecli = $reg['nome'];
			$sql_add = "INSERT INTO pedido
					(controle_cli, nome_cli, sessao_car, data_car, situacao, usuario_id, forma_pagamento_id, vendedor_id)
					VALUES
					('$entidade', '$nomecli', '".session_id()."', NOW(), 'F', '$id_usuario', '2', '$id_usuario')";
			$exe_add = mysql_query($sql_add, $base) or die (mysql_error().'-'.$sql_add);
			$id_pedido = mysql_insert_id();
				 $sql_addv = "INSERT INTO venda
				(data_venda, pedido_id, num_boleta, imposto_id, controle_cli, st_venda)
				VALUES
				(NOW(), '$id_pedido', '0', '10', '$entidade', 'A')";
				$exe_addv = mysql_query($sql_addv) or die (mysql_error().'-'.$sql_addv);
				$id_venda = mysql_insert_id();
			
				$rows_affected = mysql_affected_rows();			
				if ($rows_affected) $count++;
		
			for($i = 0; $i < count($dados); $i++){
				$id_itid = $dados[$i]->id_itid;
				$idprod = $dados[$i]->idprod;
				$idforn = $dados[$i]->idforn;
				$codigo = $dados[$i]->codigo;
				$descricao = $dados[$i]->descricao;
				$prvenda = $dados[$i]->prvenda;
				$qtd_produto  = $dados[$i]->qtd_produto; 
				$total_carrinho +=  $qtd_produto * $prvenda;
				$sql_ins = "INSERT INTO itens_pedido (id_pedido,referencia_prod,descricao_prod,prvenda,qtd_produto,id_prod)
							VALUES('$id_pedido', '$codigo', '$descricao', '$prvenda', '$qtd_produto', '$idprod')";
				$exe_ins = mysql_query($sql_ins, $base)or die (mysql_error().'-'.$sql_ins);	
				$sql_up_pedido = "UPDATE pedido SET total_nota = '$total_carrinho' WHERE id = '$id_pedido' ";
				$exe_up_pedido = mysql_query($sql_up_pedido, $base)or die (mysql_error().'-'.$sql_up_pedido);	
				$sql_addi = "INSERT INTO itens_venda
        	            (id_venda, referencia_prod, descricao_prod, prvenda, qtd_produto, idproduto)
        				VALUES
        				('$id_venda', '$codigo', '$descricao', '$prvenda', '$qtd_produto', '$idprod')";
				$exe_addi = mysql_query($sql_addi) or die (mysql_error().'-'.$sql_addi);
				$sql_up_venda = "UPDATE venda SET valor_venda = '$total_carrinho' WHERE id = '$id_venda' ";
				$exe_up_venda = mysql_query($sql_up_venda, $base)or die (mysql_error().'-'.$sql_up_venda);
			}
			$sql_conta_receber = "INSERT INTO contas_receber (vl_total,vl_parcela,nm_total_parcela,nm_parcela,clientes_id,venda_id,status,dt_lancamento,dt_vencimento)
			VALUES ('$total_carrinho', '$total_carrinho', '1', '1', '$entidade', '$id_venda', 'A', NOW(), '$dt_new')";
			$rec = mysql_query($sql_conta_receber) or die(mysql_error().' - '.$sql_conta_receber);
			
		if ($count) {
			$response = array('success'=>'true', 'count'=>$count, 'Pedido'=>$id_pedido);			
			echo json_encode($response);
		} else {
			echo '{failure: true}';
		}
		}

}
 
 ?>