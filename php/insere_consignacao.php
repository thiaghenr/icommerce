<?php
 require_once("../config.php");
 conexao();
 include_once("json/JSON.php");
 $json = new Services_JSON();
 mysql_query("SET NAMES 'utf8'");
 mysql_query('SET character_set_connection=utf8');
 mysql_query('SET character_set_client=utf8');
 mysql_query('SET character_set_results=utf8');
 
 function ajustaValor($v) {
		$v = str_replace("$","",$v);
	//	$v = str_replace(".","",$v);
		$v = str_replace(",","",$v);
		
		return $v;
	}

$dados = $json->decode($_POST["dados"]);
$acao = $_POST["acao"];
$controle = $_POST["clienteIns"];
$movimento = $_POST["movimento"];
$host = $_POST["host"];
$passvend = $_POST["passvend"];
$user = $_POST["user"];
$vendedor = $_POST["vendedor"];
$total = $_POST["total"];	
	
if($acao == 'FinConsig'){

	$sql = "SELECT * FROM usuario WHERE id_usuario = '$vendedor' AND senha = '".sha1($passvend)."' ";
  	$rs = mysql_query($sql) or die (mysql_error() .' '.$sql);
  	$num_rows = mysql_num_rows($rs);
	if($num_rows == 0){
	echo "{success:true, response: 'Confirme su password'}";
	exit();
	}
	
	$sql_prod = "SELECT nome FROM entidades WHERE controle = '$controle' ";
	$exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
	$num_prod = mysql_num_rows($exe_prod);
	$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );
	$entidadenome = $reg_prod['nome'];
	$sql_add = "INSERT INTO consignacao
					(csg_entidadeid, csg_entidadenome, csg_data, csg_usuarioid, csg_total, csg_status, csg_situacao,csg_movimento)
					VALUES
					('$controle', '$entidadenome',  NOW(), '$user',  '$total', 'A', 'A', '$movimento' )";
	$exe_add = mysql_query($sql_add, $base) or die (mysql_error().'-'.$sql_add);				
					
	$id_consig = mysql_insert_id();	
	
	for($i = 0; $i < count($dados); $i++){
	
	$idprod = $dados[$i]->idprod;
	$codigo = $dados[$i]->codigo;
	$descricao  = $dados[$i]->descricao; 
	$qtd_produto  = $dados[$i]->qtd_produto;
	$prvenda  = $dados[$i]->prvenda;
	$prvenda = ajustaValor($prvenda);
	
//	$total_carrinho =+  $qtd_produto * $prvenda;
//	$total_carrinho = $total_carrinho - $desconto;
	
	
						
	$sql_ins = "INSERT INTO itens_consig (itcsg_consigid,itcsg_referencia,itcsg_descricao,itcsg_valor,itcsg_qtd,itcsg_produtoid)
							VALUES('$id_consig', '$codigo', '$descricao', '$prvenda', '$qtd_produto', '$idprod')";
	$exe_ins = mysql_query($sql_ins, $base)or die (mysql_error().'-'.$sql_ins);	
	$rows_affected = mysql_affected_rows();			
	if ($rows_affected) $count++;
	
	if($movimento == "Entrada"){
	$sql_up_estoque_prod = "UPDATE produtos SET Estoque = Estoque + '$qtd_produto' WHERE id = '$idprod' ";
	$exe_up_estoque_prod = mysql_query($sql_up_estoque_prod, $base)or die (mysql_error().'-'.$sql_up_estoque_prod);	
	}
	if ($movimento == "Salida"){
	$sql_up_estoque_prod = "UPDATE produtos SET Estoque = Estoque - '$qtd_produto' WHERE id = '$idprod' ";
	$exe_up_estoque_prod = mysql_query($sql_up_estoque_prod, $base)or die (mysql_error().'-'.$sql_up_estoque_prod);	
	}
	
	}
	if ($count) {
	$response = array('success'=>'true', 'del_count'=>$count, 'Pedido'=>$id_consig);			
	echo json_encode($response);
	} else {
	echo '{failure: true}';
	}
	
	exit();

	
	
}	
	
	
	
	
	
	
	
?>