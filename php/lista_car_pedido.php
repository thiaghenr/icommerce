<?php
 //require_once("../verifica_login.php");
 require_once("../config.php");
 conexao();
 require_once("../biblioteca.php");
 include("JSON.php");
 
 mysql_query("SET NAMES 'utf8'");mysql_query('SET character_set_connection=utf8');mysql_query('SET character_set_client=utf8');mysql_query('SET character_set_results=utf8');

//AND sessao = '".session_id()."'
//$acao   = isset($_POST['acao']);
$host = $_POST['host'];
if(isset($_POST['campo'])){

$campo = $_POST['campo'];

if($campo == 6){
$id = $_POST['id'];
$campo = 'prvenda'; 
$valor = ($_POST['valor']);

	$sql_prod = "SELECT pr.id, pr.pr_min, c.id AS idcar, c.codigo_prod FROM produtos pr, carrinho c WHERE c.codigo_prod = pr.id AND c.id = '$id' ";
	$exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
	$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC);
	//echo $reg_prod['pr_min'];
	if( $valor < $reg_prod['pr_min']){
	echo "{success:true, response: 'Valor Abaixo do Custo'}";
	exit();
	}
	else{

$sql_per = "UPDATE carrinho SET $campo = '$valor' WHERE id = '$id' ";
$exe_per = mysql_query($sql_per) or die (mysql_error()) ;

	echo "{success:true}";
	}
}

if($campo == 7){
$campo = 'qtd_produto';
$valor = ($_POST['valor']);

$id = $_POST['id'];
$sql_per = "UPDATE carrinho SET $campo = '$valor' WHERE id = '$id' ";
$exe_per = mysql_query($sql_per) or die (mysql_error()) ;

	echo "{success:true}";

}

if($campo == 2){
$campo = 'Codigo';
$valor = ($_POST['valor']);
$clienteIns = $_POST['clienteIns'];
$idcar = $_POST['id'];
$user = $_POST['user'];

$sql_prod = "SELECT id,Codigo,Descricao,Estoque,valor_a,pr_min FROM produtos WHERE Codigo = '$valor' ";
	$exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
	$row_prod = mysql_num_rows($exe_prod);
	$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC);
	
	$id = $reg_prod['id'];
	$Codigo = $reg_prod['Codigo'];
	$Descricao = $reg_prod['Descricao'];
	$valor = $reg_prod['valor_a'];
		
	if($row_prod == 0){
	echo "{success:false, response: 'ProdutoNaoEncontrado'}";
	}
	else{
	$sql_cont = "SELECT COUNT(*) AS n_prod FROM carrinho WHERE codigo_prod = '$id' AND status = 'A' AND controle = '$clienteIns' AND user_id = '$user' AND host = '$host' ";
	$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
	$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
	
    $reg_cont['n_prod'];

	if ($reg_cont['n_prod'] == 0  && !empty($reg_prod['id'])) {
	$sql_ins = "INSERT INTO carrinho
	(Codigo, descricao, prvenda, qtd_produto, sessao, controle, data, status, codigo_prod, user_id, host)
	VALUES('$Codigo', '$Descricao', '$valor', '1', '".session_id()."', '$clienteIns', NOW(), 'A', '$id', '$user', '$host'  )";
	$exe_ins = mysql_query($sql_ins, $base)  or die (mysql_error());
	
	echo "{success:true, response: 'Update', adicionado: '$id'}"; 
		}
	else{
	echo "{success:true, response: 'ProdutoJaAdicionado'}";
	} 
	}


exit();
}




//}

if($campo == 'addgrid'){
//$campo = 'id';
//$valor = ($_POST['valor']);
$clienteIns = $_POST['clienteIns'];
$idprod = $_POST['id'];
$idprod = $_POST['idcar'];
$user = $_POST['user'];

	$sql_prod = "SELECT id,Codigo,Descricao,Estoque,valor_b,pr_min FROM produtos WHERE id = '$idprod' ";
	$exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
	$row_prod = mysql_num_rows($exe_prod);
	$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC);
	
    $id = $reg_prod['id'];
	$Codigo = $reg_prod['Codigo'];
	$Descricao = $reg_prod['Descricao'];
	$valor = $reg_prod['valor_b'];
		
	if($row_prod == 0){
	echo "{success:false, response: 'ProdutoNaoEncontrado'}";
	}
	else{
	$sql_cont = "SELECT COUNT(*) AS n_prod FROM carrinho WHERE Codigo = '$id' AND status = 'A' AND controle = '$clienteIns' AND user_id = '$user' AND host = '$host' ";
	$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
	$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
	
    $reg_cont['n_prod'];

	if ($reg_cont['n_prod'] == 0  && $reg_prod['id'] != '') {
	$sql_ins = "INSERT INTO carrinho (Codigo, descricao, prvenda, qtd_produto, sessao, controle, data,  status, codigo_prod, user_id, host )
									VALUES('$Codigo', '$Descricao', '$valor', '1', '".session_id()."', '$clienteIns', NOW(), 'A', '$id', '$user', '$host' )";	
	$exe_ins = mysql_query($sql_ins, $base)  or die (mysql_error());
	
	echo "{success:true, response: 'Update', adicionado: '$id'}"; 
		}
	else{
	echo "{success:true, response: 'ProdutoJaAdicionado'}";
	} 
	}


exit();
}




}

// INSERIR PRODUTO//////////////////////////////////////////

if(isset($_POST['acao'])){
$acao = $_POST['acao'];
$codigoProd = $_POST['codigoProd'];
$clienteIns = $_POST['clienteIns'];
$user = $_POST['user'];

if($acao == 'inserir'){

	$sql_prod = "SELECT id,Codigo,Descricao,Estoque,valor_a,pr_min FROM produtos WHERE Codigo = '$codigoProd' ";
	$exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
	$row_prod = mysql_num_rows($exe_prod);
	$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC);
	
	$id = $reg_prod['id'];
	$Codigo = $reg_prod['Codigo'];
	$Descricao = $reg_prod['Descricao'];
	$valor = $reg_prod['valor_a'];
		
	if($row_prod == 0){
	echo "{success:false, response: 'Erro'}";
	}
	else{
	$sql_cont = "SELECT COUNT(*) AS n_prod FROM carrinho WHERE Codigo = '$id' AND status = 'A' AND controle = '$clienteIns' AND user_id = '$user' AND host = '$host' ";
	$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
	$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
	
    $reg_cont['n_prod'];

	if ($reg_cont['n_prod'] == 0  && !empty($reg_prod['id'])) {
	$sql_ins = "INSERT INTO carrinho
	(Codigo, descricao, prvenda, qtd_produto, sessao, controle, data, status, codigo_prod, user_id, host)
	VALUES('$id', '$Descricao', '$valor', '1', '".session_id()."', '$clienteIns', NOW(), 'A', '$Codigo', '$user', '$host'  )";
	$exe_ins = mysql_query($sql_ins, $base)  or die (mysql_error());
	
	echo "{success:true, response: '$id'}"; 
		}
	else{
	echo "{success:true, response: 'ProdutoJaAdicionado'}";
	} 
	}
}
if($acao == 'Cancelar'){

	$sql_del = "DELETE FROM carrinho WHERE controle = '$clienteIns' AND status = 'A' AND user_id = '$user' AND host = '$host' ";
	$exe_del = mysql_query($sql_del, $base) or die (mysql_error());

echo "{success:true, response: 'PedidoCancelado'}";
}

}
////////DELETA ITEN /////////////////////////
if(isset($_POST['acao'])){
$acao = $_POST['acao'];
$itenCar = $_POST['itenCar'];
if($acao == 'deletaItenCar'){

$sql_del = "DELETE FROM carrinho WHERE id = '$itenCar' ";
$exe_del = mysql_query($sql_del, $base) or die (nysql_error());
echo "{success:true, response: 'Deletado'}"; 
}
}

if(isset($_POST['acao'])){
if($_POST['acao'] == 'FirstIten'){
$cliente = $_POST['clienteIns'];
$user =  $_POST['user'];
$FirstIten = $_POST['acao'];

	$sql_contFirst = "SELECT COUNT(*) AS n_prod FROM carrinho WHERE Codigo = '0' AND status = 'A' AND controle = '$cliente' AND user_id = '$user' AND host = '$host' ";
	$exe_contFirst = mysql_query($sql_contFirst, $base) or die (mysql_error());
	$reg_contFirst = mysql_fetch_array($exe_contFirst, MYSQL_ASSOC);
	
    $reg_contFirst['n_prod'];
	
//	if($reg_contFirst['n_prod'] == '0'){
///	$sql_first = "INSERT INTO carrinho (Codigo, data, status, qtd_produto, controle, prvenda, user_id)
//					VALUES('0', NOW(), 'A', '1', '$cliente', '0.00', '$user') ";
///	$exe_first = mysql_query($sql_first, $base)  or die (mysql_error().' '.$sql_first);
//	}
   echo "{success:true, response: 'FirstIten'}"; 
}

}

////////////// ACAO FINALISAR ///////////////////////////////////////////////////////////////////////////
if($_POST['acao'] == 'FinPedido'){
$cliente = $_POST['clienteIns'];
$user =  $_POST['user'];
$FirstIten = $_POST['acao'];
$formaPgto = $_POST['formaPgto'];
$vendedor = $_POST['vendedor'];
$passvend = $_POST['passvend'];


	$sql = "SELECT * FROM usuario WHERE id_usuario = '$vendedor' AND senha = '".sha1($passvend)."' ";
  	$rs = mysql_query($sql) or die (mysql_error() .' '.$sql);
  	$num_rows = mysql_num_rows($rs);
	if($num_rows == 0){
	echo "{success:true, response: 'Confirme su password'}";
	exit();
	}

$sql_cont = "SELECT COUNT(*) AS n_prod FROM carrinho WHERE controle = '$cliente' AND status = 'A' AND user_id = '$user' AND host = '$host' ";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);

			    if ($reg_cont['n_prod'] > 0) {
					$sql_prod = "SELECT c.*, cl.nome, cl.controle AS controleCli FROM carrinho c, entidades cl WHERE c.controle = '$cliente' AND c.status = 'A' AND c.user_id = '$user' AND c.controle = cl.controle ";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					if ($num_prod > 0) {
					while ($reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC )){
					$total_carrinho += ($reg_prod['prvenda']*$reg_prod['qtd_produto']);
					$nomecli = $reg_prod['nome'];
					}
					
					$sql_add = "INSERT INTO pedido
								(controle_cli, nome_cli, sessao_car, data_car, total_nota, situacao, usuario_id, forma_pagamento_id, frete, vendedor)
								VALUES
								('$cliente', '$nomecli', '".session_id()."', NOW(), '$total_carrinho', 'A', '$user', '$formaPgto', '$valor_frete', '$vendedor' )";
					$exe_add = mysql_query($sql_add, $base) or die (mysql_error().'-'.$sql_add);				
					
					$id_pedido = mysql_insert_id();
					
					$sql_prod = "SELECT * FROM carrinho WHERE controle = '$cliente' AND status = 'A' AND user_id = '$user' AND host = '$host' ";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					if ($num_prod > 0) {
					while	($reg_prodx = mysql_fetch_array($exe_prod, MYSQL_ASSOC )) {
					$sql_add = "INSERT INTO itens_pedido
								(id_pedido, referencia_prod, descricao_prod, prvenda, qtd_produto, sessao, id_prod)
								VALUES
								($id_pedido,'".mysql_escape_string($reg_prodx['Codigo'])."', '".mysql_escape_string($reg_prodx['descricao'])."', '".$reg_prodx['prvenda']."', '".$reg_prodx['qtd_produto']."', '".session_id()."', '".$reg_prodx['codigo_prod']."' )";
								
					$qtd_prod =  $reg_prodx['qtd_produto'] ;
					$exe_add = mysql_query($sql_add, $base) or die (mysql_error().'-'.$sql_add);	
					
		$sql_alt_status = "UPDATE carrinho SET status = 'F' WHERE controle = '$cliente' AND status = 'A' AND user_id = '$user' AND host = '$host' ";
		$exe_alt_status = mysql_query($sql_alt_status, $base) or die (mysql_error().'-'.$sql_add);				

  		$sql_qtd1 = "UPDATE produtos SET  qtd_bloq = qtd_bloq + '$qtd_prod' WHERE id = '".$reg_prodx['Codigo']."'  ";
		$exe_qtd1 = mysql_query($sql_qtd1, $base) or die (mysql_error());
		$sql_qtd2 = "UPDATE produtos SET  Estoque = Estoque - '$qtd_prod' WHERE id = '".$reg_prodx['Codigo']."'  ";
		$exe_qtd2 = mysql_query($sql_qtd2, $base) or die (mysql_error());


					}
				}
			}

		}
echo "{success:true, response: 'FinPedido', Pedido: '$id_pedido'}"; 

}

/////////////////////////////////////////////////////////////
//exit();
// FIM PRODUTO/////////////////////////////////////////////

if($_POST['cliente']){
$cliente = $_POST['cliente'];
$user =  $_POST['user'];
 
 $rs    = mysql_query("SELECT c.*,c.id AS idcar, c.controle AS controleCli, p.Codigo AS idprod, p.pr_min FROM carrinho c 
 LEFT JOIN produtos p ON p.id = c.codigo_prod
 WHERE c.controle = '$cliente' AND status = 'A' AND user_id = '$user' AND host = '$host' ORDER BY c.id DESC ")or die (mysql_error());
 $total  = mysql_num_rows($rs);
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	} 
	echo '{"totalProd":'.$total.',"resultProd":'.json_encode($arr).'}'; 
}
?>