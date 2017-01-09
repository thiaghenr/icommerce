<?php
	require_once ("../config.php");
    require_once("../biblioteca.php");
	conexao();
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
	
	$acao = $_POST['acao'];
	$idprod = $_POST['idprod'];
	$entidade = $_POST['entidade'];
	$user = $_POST['user'];
	$dataini = !empty($_POST['dataini']) ? $_POST['dataini'] : date("Y-m-d");
	$datafim = !empty($_POST['datafim']) ? $_POST['datafim'] : date("Y-m-d");
	$dataini = substr($dataini,0,10);
	$datafim = substr($datafim,0,10);
	
	if($acao == 'busca'){
	//p.data_car BETWEEN '$dataini' AND '$datafim 23:59:59.999'
		$sql_venda = "SELECT it.referencia_prod, it.descricao_prod, it.prvenda, p.valor_a, avg(it.prvenda) AS media,
		sum(it.qtd_produto) AS qtd_vendido, p.Estoque, p.valor_a
		FROM venda v, itens_venda it, produtos p 
		WHERE 1=1 AND v.data_venda BETWEEN '$dataini' AND '$datafim 23:59:59.999' AND p.id = it.idproduto AND v.id = it.id_venda "; //p.id = it.id_pedido  AND p.data_venda BETWEEN '$dataini' AND '$datafim 23:59:59.999' ";
		if(!empty($entidade)){
		$sql_venda .= " AND v.controle_cli = '$entidade' ";
		}
		if(!empty($_POST['idprod'])){
		$sql_venda .= " AND it.idproduto = '$idprod' ";
		}

		$sql_venda .= " GROUP BY it.idproduto   ";
		$exe_venda = mysql_query($sql_venda) or die(mysql_error().'-'.$sql_venda);
		$total = mysql_num_rows($exe_venda);
		$arr = array();
		while ($reg_venda = mysql_fetch_array($exe_venda, MYSQL_ASSOC)) { 
		
		$arr[] = $reg_venda;
		}
	
		echo '({"totalProdutos":'.$total.',"Produtos":'.json_encode($arr).'})'; 
		
	}
		
		
		
		
		
?>