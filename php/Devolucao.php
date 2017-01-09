<?php
require_once("../verifica_login.php");
include "../config.php";
conexao();
include_once("json/JSON.php");
$json = new Services_JSON();
header("Content-Type: text/html; charset=iso-8859-1");
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


$acao = $_POST['acao'];
$pedido = $_POST['Pedido'];
$idIten = $_POST['idIten'];
//$qtdDev = $_POST['dtdDev'];
$id_usuario = $_POST['user'];

//////////////////////////////////////////////////////////////////////////////////////////////
if($acao == 'listar'){

	$sql_lista =  "SELECT * FROM pedido WHERE id = '$pedido' AND situacao = 'F' ";
	$exe_lista = mysql_query($sql_lista, $base)or die (mysql_error().'-'.$sql_lista);
	$reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC);
	$row = mysql_num_rows($exe_lista);
	
	$pedido = $reg_lista['id'];
	
	$sql_listant =  "SELECT * FROM nota_credito WHERE idpedido = '$pedido' ";
	$exe_listant = mysql_query($sql_listant, $base)or die (mysql_error().'-'.$sql_listant);
	$reg_listant = mysql_fetch_array($exe_listant, MYSQL_ASSOC);
	$rownt = mysql_num_rows($exe_listant);
	if($rownt > 0 ){
		$idntcredito = $reg_listant['idnota_credito'];
	}
	if($rownt == 0 ){
		$idntcredito = 0;
	}
	
	
		if($row ==0){
			echo "{success: true,response: 'PedidoNaoEncontrado'}";
			}
		else{
			echo "{success: true,response: $pedido, ntcredito: $idntcredito }";
			}
}

/////////////////////////////////////////////////////////////////////////////////////////////
if($acao == 'ListaItens'){

	$rs    = mysql_query("SELECT it.*, round(sum(p.desconto / (p.desconto + p.total_nota) * 100 ),2) AS percentual FROM itens_pedido it, pedido p WHERE it.id_pedido = '$pedido' 
		AND p.id = it.id_pedido  GROUP BY it.id ORDER BY id DESC ")or die (mysql_error());
	$total = mysql_num_rows($rs);
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '({"total":"'.$total.'","Itens":'.json_encode($arr).'})'; 
} 

//////////////////////////////////////////////////////////////////////////////////////////////
if($acao == 'Devolver'){
$pedido = $_POST['pedido'];
$dados = $json->decode($_POST['data']);

						$sql = "SELECT p.controle_cli, v.id FROM pedido p, venda v WHERE p.id = '$pedido' AND p.id = v.pedido_id ";
						$rs = mysql_query($sql) or die (mysql_error() .' '.$sql);
						$reg = mysql_fetch_array($rs, MYSQL_ASSOC);
						$cod_cliente = $reg['controle_cli'];
						$venda_id = $reg['id'];

						$sql_nota = "INSERT INTO nota_credito (idcliente,idpedido,idvenda,idctreceber,iduser,dtlcto,status,vlcredito)
								VALUES ('$cod_cliente', '$pedido', '$venda_id', '".$reg_cr['id']."', '$id_usuario', NOW(), 'A','$vlcredito' )";
						$exe_nota = mysql_query($sql_nota, $base) or die (mysql_error().'-'.$sql_nota);
					
						$idnotacredito = mysql_insert_id();
						
 
	for($i = 0; $i < count($dados); $i++){
	
	$idIten    = isset($dados[$i]->id) ? $dados[$i]->id : false;
	$Codigo  = $dados[$i]->Codigo;
	$Descricao = $dados[$i]->Descricao;
	$qtd  = $dados[$i]->qtd;
	$qtdDev = $qtd;
	$valor  = $dados[$i]->valor;

			//PESQUISA O TOTAL  DE PRODUTOS QUE ESTA NA TABELA ITENS_PEDIDOS
			$sql_pes_qtd_itens_prod	= "SELECT p.id AS pid,p.situacao,p.controle_cli, it.* 
			FROM pedido p, itens_pedido it WHERE it.id = '$idIten' AND it.id_pedido = p.id ";
			$rs_pes_qtd_itens_prod 	= mysql_query($sql_pes_qtd_itens_prod) or die (mysql_error().'-'.$sql_pes_qtd_itens_prod);
			$row_pes_qtd_itens_prod = mysql_fetch_array($rs_pes_qtd_itens_prod);
            
			$qtdatual_pedido = $row_pes_qtd_itens_prod['qtd_produto'];
			//$vl_venda = $row_pes_qtd_itens_prod['prvenda'];
			$vl_venda = $valor;
			$situacao = $row_pes_qtd_itens_prod['situacao'];
			$referencia_prod = $row_pes_qtd_itens_prod['referencia_prod'];
			$descricao_prod  = $row_pes_qtd_itens_prod['descricao_prod'];
			$cod_cliente = $row_pes_qtd_itens_prod['controle_cli'];
			$idproduto = $row_pes_qtd_itens_prod['id_prod'];
			
			$total_do_iten = $valor * $qtdDev;
			$vlcredito += $valor * $qtdDev;
	
			if($qtdatual_pedido < $qtdDev){
				echo "{success: true,response: 'Quantidade nao Confere'}";
				exit();
				}
			
			if($situacao == "A"){
				echo "{success: true,response: 'Pedido todavia no faturado'}";
				exit();
				}

			if($situacao == "F"){
				$sql_qtd2 = "UPDATE produtos SET  Estoque = Estoque + '$qtdDev' WHERE id = '$idproduto'  ";
				$exe_qtd2 = mysql_query($sql_qtd2, $base) or die (mysql_error().'-'.$sql_qtd2);
				}
				
					
						$sql_itens_nota = "INSERT INTO itens_ntcredito (id_credito,idproduto,referenciaprod,descricaoprod,vliten,qtdproduto)
										VALUES('$idnotacredito', '$idproduto', '$referencia_prod', '$descricao_prod', '$vl_venda', '$qtdDev'  )";
						$exe_itens_nota = mysql_query($sql_itens_nota, $base) or die (mysql_error().'-'.$sql_itens_nota);
						$rows_affected = mysql_affected_rows();			
						if ($rows_affected) $count++;
												
						$sql_qtd3 = "UPDATE nota_credito SET  vlcredito = $vlcredito WHERE idnota_credito = '$idnotacredito'  ";
						$exe_qtd3 = mysql_query($sql_qtd3, $base) or die (mysql_error().'-'.$sql_qtd3);
				}
				if ($count) {
				echo "{success: true,response: 'Produto Devolvido', ntcredito: $idnotacredito}";		
				}
					
						
		
						
						
						
					
				
				
}





?>