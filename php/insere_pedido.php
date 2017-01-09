<?php
 require_once("../config.php");
 conexao();
 include_once("json/JSON.php");
 $json = new Services_JSON();
 function ajustaValor($v) {
		$v = str_replace("$","",$v);
	//	$v = str_replace(".","",$v);
		$v = str_replace(",","",$v);
		
		return $v;
	}
 
 mysql_query("SET NAMES 'utf8'");
 mysql_query('SET character_set_connection=utf8');
 mysql_query('SET character_set_client=utf8');
 mysql_query('SET character_set_results=utf8');
 
$dados = $json->decode($_POST["dados"]);
$acao = $_POST["acao"];
$controle = $_POST["clienteIns"];
$formaPgto = $_POST["formaPgto"];
$host = $_POST["host"];
$passvend = $_POST["passvend"];
$user = $_POST["usuario_id"];
$vendedor = $_POST["vendedor"];
$desconto = ajustaValor($_POST["desconto"]);
$subtotal = $_POST["subtotal"];

if($acao == 'FinPedido'){

	$sql = "SELECT * FROM usuario WHERE id_usuario = '$user' AND senha = '".sha1($passvend)."' ";
  	$rs = mysql_query($sql) or die (mysql_error() .' '.$sql);
  	$num_rows = mysql_num_rows($rs);
	if($num_rows == 0){
	echo "{success:true, response: 'Confirme su password'}";
	exit();
	}

	
	$total_carrinho = $subtotal - $desconto;
	
	$sql_prod = "SELECT nome FROM entidades WHERE controle = '$controle' ";
	$exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
	$num_prod = mysql_num_rows($exe_prod);
	$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );
	$nomecli = $reg_prod['nome'];
	$sql_add = "INSERT INTO pedido
					(controle_cli, nome_cli, sessao_car, data_car, situacao, usuario_id, forma_pagamento_id, frete, vendedor_id, desconto)
					VALUES
					('$controle', '$nomecli', '".session_id()."', NOW(), 'A', '$user', '$formaPgto', '$valor_frete', '$vendedor', '$desconto' )";
	$exe_add = mysql_query($sql_add, $base) or die (mysql_error().'-'.$sql_add);				
					
	$id_pedido = mysql_insert_id();
	
	for($i = 0; $i < count($dados); $i++){
	
	$idprod = $dados[$i]->idprod;
	$codigo = $dados[$i]->codigo;
	$descricao  = $dados[$i]->descricao; 
	$qtd_produto  = $dados[$i]->qtd_produto;
	$prvenda  = $dados[$i]->prvenda;
	$prvenda = ajustaValor($prvenda);
	
	$total_carrinho +=  $qtd_produto * $prvenda;
//	$total_carrinho = $total_carrinho - $desconto;
	
	
						
	$sql_ins = "INSERT INTO itens_pedido (id_pedido,referencia_prod,descricao_prod,prvenda,qtd_produto,id_prod)
							VALUES('$id_pedido', '$codigo', '$descricao', '$prvenda', '$qtd_produto', '$idprod')";
	$exe_ins = mysql_query($sql_ins, $base)or die (mysql_error().'-'.$sql_ins);	
	$rows_affected = mysql_affected_rows();			
	if ($rows_affected) $count++;
		
	$sql_up_estoque_prod = "UPDATE produtos SET Estoque = Estoque - '$qtd_produto' , qtd_bloq = qtd_bloq + '$qtd_produto' WHERE id = '$idprod' ";
	$exe_up_estoque_prod = mysql_query($sql_up_estoque_prod, $base)or die (mysql_error().'-'.$sql_up_estoque_prod);	
	
	}
	$sqlsum = "SELECT sum(qtd_produto * prvenda) AS total_carrinho FROM itens_pedido WHERE id_pedido = '$id_pedido' ";
	$exesum =  mysql_query($sqlsum, $base)or die (mysql_error().'-'.$sqlsum);
	$regsum = mysql_fetch_array($exesum, MYSQL_ASSOC);
	$total_carrinho = ($regsum['total_carrinho'] - $desconto);
	
	$sql_up_pedido = "UPDATE pedido SET total_nota = '$total_carrinho' WHERE id = '$id_pedido' ";
	$exe_up_pedido = mysql_query($sql_up_pedido, $base)or die (mysql_error().'-'.$sql_up_pedido);	
	
	if ($count) {
	$response = array('success'=>'true', 'del_count'=>$count, 'Pedido'=>$id_pedido);			
	echo json_encode($response);
	} else {
	echo '{failure: true}';
	}
	
	exit();
	

 }
 
 
 
?>