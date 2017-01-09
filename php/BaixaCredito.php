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

function ajustaValor($v) {
		$v = str_replace(".","",$v);
		$v = str_replace(".","",$v);
		$v = str_replace(".","",$v);
		$v = str_replace(",",".",$v);
		$v = str_replace("$","",$v);
		return $v;
	}

$acao = $_POST['acao'];

//////////////////////////////////////////////////////////////////////////////////////////////
if($acao == 'Devolver'){
$ncredito = $_POST['ncredito'];
$valor = ($_POST['valor']);
$id_usuario = $_POST['user'];
$recibo = $_POST['recibo'];

	$sql_caixa_balcao = "SELECT * FROM caixa_balcao WHERE usuario_id = '$id_usuario' AND st_caixa = 'A'";
	$rs_caixa_balcao = mysql_query($sql_caixa_balcao);
	$linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao, MYSQL_ASSOC);
	$caixa_id = $linha_caixa_balcao['id'];
	if($caixa_id == ""){
		echo "{success:true, response: 'Impossible, Tu caja esta cerrado'}";
		exit;
	}	

	$sql = "SELECT nc.idnota_credito, nc.idvenda, nc.idcliente, nc.idpedido, nc.vlcredito, sum(na.valor_abat) AS valor_abat  FROM nota_credito nc
			LEFT JOIN nc_abatimento na ON na.idntcredito = nc.idnota_credito
			WHERE nc.idnota_credito = '$ncredito' ";
	$exe = mysql_query($sql) or die (mysql_error());
	$reg = mysql_fetch_array($exe, MYSQL_ASSOC);

	$entidade = $reg['idcliente'];
	$venda_idp = $reg['idvenda'];
	$idpedido = $reg['idpedido'];
	$vlcredito =	$reg['vlcredito'];
	$vlabatido =	$reg['valor_abat'];
	$vlcreditofinal = $vlcredito - $vlabatido;	
	$valorRestante = $vlcreditofinal;

	if($valorRestante >= $valor){
	
			$sql_lancar_parcial = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id,lanc_despesa_id,despesa_cod,entidade_id,num_nota,descricao) 
												VALUES('2', '$caixa_id', NOW(), '$valor', '$venda_idp', '161', '2.01.05.05.000.00','$entidade','$recibo','Pago Devolucion Cliente')";
			$exe_lancar_parcial = mysql_query($sql_lancar_parcial, $base) or die (mysql_error());
			$caixaid = mysql_insert_id();
			
			$sql_plan = "INSERT INTO lanc_contas (plano_id,plan_codigo,documento,dt_lanc_desp,desc_desp,valor,usuario_id,receita_id,valor_total,entidade_id,caixaid) ";
			$sql_plan.= "VALUES ('161', '2.01.05.05.000.00', '$recibo', NOW(), 'Pago Devolucion Cliente', '$valor', '$id_usuario', '2', '$valor', '$entidade', '$caixaid' )";
			mysql_query($sql_plan) or die (mysql_error());	
	
			$sql = "INSERT INTO nc_abatimento (idntcredito,identidade,valor_abat,data_abat,user_abat,idpedido,idlcto_caixa)
							VALUES('$ncredito', '$entidade', '$valor', NOW(), '$id_usuario', '$idpedido', '$caixaid' )";
			$exe = mysql_query($sql, $base) or die (mysql_error());
			$devolvido = mysql_insert_id();
			
			if($valorRestante == $valor){
				$sql_qtd3 = "UPDATE nota_credito SET  status = 'F' WHERE idnota_credito = '$ncredito'  ";
				$exe_qtd3 = mysql_query($sql_qtd3, $base) or die (mysql_error().'-'.$sql_qtd3);
			}
	
			echo "{success:true, response: 'Exito, Monto devolvido'}";	
			
	}
	else{
		echo "{success:true, response: 'Impossible, No podes devolver monto mayor que el credito'}";
	}
				
}


?>