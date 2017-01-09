<?php
require_once("../verifica_login.php");
include "../config.php";
conexao();
include_once("json/JSON.php");
$json = new Services_JSON();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

require_once("../biblioteca.php");
$sql_caixa_balcao = "SELECT * FROM caixa_balcao WHERE usuario_id = ". $id_usuario." AND st_caixa = 'A'";
$rs_caixa_balcao = mysql_query($sql_caixa_balcao);
$linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao, MYSQL_ASSOC);
$caixa_id = $linha_caixa_balcao['id'];

//$cotacao = $_GET['cotacao'];
$acao = $_POST['acao'];
$query = $_POST['query'];

if($acao == "ListaContas"){  //2171-2512-284653
$rs = "SELECT cl.nome,cl.controle,cl.ruc,cl.telefone1, sum(round(crp.valorpg,2)) AS valor_recebido, sum(cr.vl_parcela - cr.desconto - cr.vl_recebido ) AS valor_parcela,
cr.status, cr.vl_recebido, DATEDIFF(NOW(), cr.dt_vencimento) AS diferenca, cr.id
FROM entidades cl, contas_receber cr
LEFT JOIN contas_recparcial crp ON crp.contas_rec_id = cr.id
WHERE ";
if(isset($query)){
$rs .= " cr.status != 'Z' AND cl.nome LIKE '%$query%' ";
} 
else{
$rs .= " cr.status = 'A' ";
}
$rs .= " AND cl.controle = cr.clientes_id  
GROUP BY cr.clientes_id
ORDER BY cl.nome asc";
$exe = mysql_query($rs) or die (mysql_error());	
$arr = array();
$total = mysql_num_rows($exe);
while($obj = mysql_fetch_object($exe))
{	

	//echo $obj['valor_parcela'];
	$arr[] = $obj;
	
	
}

//echo $_GET['callback'].'({"result":'.json_encode($arr).'})'; 
echo '({"totalClientes":'.$total.',"Clientes":'.json_encode($arr).'})'; 
}

if($acao == "ListaLcto"){
$idCli = $_POST['idCli'];

$rs    = mysql_query("SELECT v.pedido_id, DATEDIFF(NOW(), cr.dt_vencimento) AS diferenca, cr.id, cr.nm_total_parcela, cr.nm_parcela, cr.vl_ntcredito, cr.clientes_id, cr.venda_id, 
cr.vl_parcela, cr.vl_recebido, cr.status, cr.desconto, cr.juros, sum(round(rp.valorpg,2)) AS valor_recebido, cr.vl_restante, cr.vl_multa, cr.perc_juros, 
date_format(cr.dt_vencimento, '%d/%m/%Y') AS dt_vencimento, date_format(cr.dt_lancamento, '%d/%m/%Y') AS dt_lancamento, 
datediff( NOW(), cr.dt_vencimento) AS dias_atrazo, round((cr.vl_parcela * cr.perc_juros / 30) * (datediff( NOW(), cr.dt_vencimento) / 100),2 ) As valor_juros, 
cr.perc_juros,  cl.controle,cl.nome 
FROM entidades cl,   contas_receber cr

LEFT JOIN contas_recparcial rp ON rp.idctreceber = cr.id
LEFT JOIN venda v ON v.id = cr.venda_id
WHERE cr.clientes_id = '$idCli' AND cr.clientes_id = cl.controle AND cr.status = 'A' GROUP BY cr.id  ") or die (mysql_error());
$arr = array();
while ($obj = mysql_fetch_array($rs)){

	$valor_recebido = $obj['valor_recebido'] ? $obj['valor_recebido'] : 0.00;
	$valor_recebido = $valor_recebido + $obj['vl_recebido'];

	$arr[] = array('id'=>$obj['id'], 'dt_lancamento'=>$obj['dt_lancamento'], 'dt_vencimento'=>$obj['dt_vencimento'], 'nm_total_parcela'=>$obj['nm_total_parcela'],
					'vl_ntcredito'=>$obj['vl_ntcredito'], 'nome'=>$obj['nome'], 'venda_id'=>$obj['venda_id'], 'vl_parcela'=>$obj['vl_parcela'], 'desconto'=>$obj['desconto'],
					'perc_juros'=>$obj['perc_juros'], 'valor_recebido'=>$valor_recebido, 'pedido_id'=>$obj['pedido_id'], 'diferenca'=>$obj['diferenca'] );
	}
	
echo '({"Facturas":'.json_encode($arr).'})'; 

}
////UPDATE NA TABELA ////////////////////////////////////////////// 

$valor = ($_POST['valor']);
$id = $_POST['idPagare'];
$origem	= $_POST['origem'];
$ncredito = $_POST['ncredito'];
$jsonCheq = $json->decode($_POST['jsonCheq']);


	function ApuraContas($id,$valor){
	
		$sql_listap = "SELECT cr.*, round((cr.vl_parcela * cr.perc_juros / 30) * (datediff( NOW(), cr.dt_vencimento) / 100),2 ) As valor_juros,
			sum(round(rp.valorpg,2)) AS valor_recebido, cr.desconto, cr.clientes_id
			FROM contas_receber cr  
			LEFT JOIN contas_recparcial rp ON rp.idctreceber = cr.id
			WHERE cr.status = 'A' AND cr.id = '$id' "; 
			$exe_listap = mysql_query($sql_listap) or die (mysql_error().'-'.$sql_listap);
			$linhap = mysql_fetch_array($exe_listap, MYSQL_ASSOC);
			
			if($linhap['valor_juros'] < 0){
			$valorJuro = 0.00; } else{ $valorJuro = $linhap['valor_juros']; };
			global $liquidop;
			$liquidop = ($linhap['vl_parcela'] - ($linhap['desconto'] + $linhap['valor_recebido'] + $linhap['vl_ntcredito'] ));
			global $restante;
     		$restante =  round($liquidop - $linhap['vl_recebido'],2);
			
			global $venda_idp;
			$venda_idp = $linhap['venda_id'];
			global $receber_idp;
			$receber_idp = $linhap['id'];
			global $cliente;
			$cliente =  $linhap['clientes_id'];
			
			$totalJuros = $valorJuro;
			
    		$recebido_anterior = $linhap['valor_recebido'];
			
			$restante = round($restante,2);
		
			$restante_valor = round($restante - $valor,2);
			global $final; 
			$final = $liquidop - $restante_valor;
		   
		
		}
$sql_caixa = "SELECT * FROM caixa WHERE status = 'A'";
$rs_caixa = mysql_query($sql_caixa);
$linha_caixa = mysql_fetch_array($rs_caixa, MYSQL_ASSOC);
$caixa_id = $linha_caixa['id'];

$sql_caixab = "SELECT id FROM caixa_balcao WHERE st_caixa = 'A' AND usuario_id = '$id_usuario' ";
$rs_caixab = mysql_query($sql_caixab);
$linha_caixab = mysql_fetch_array($rs_caixab, MYSQL_ASSOC);
$caixa_user = $linha_caixab['id'];

function caixa($caixa_id,$valor,$venda_idp,$receber_idp,$cliente,$idlanc){
$sql_lancamento_caixa = "INSERT INTO lancamento_caixa (receita_id,idlanc,caixa_id,data_lancamento,valor,venda_id,conta_receber_id,
			fornecedor_id,lanc_despesa_id,despesa_cod,historico,data_lancamentob)
            VALUES ('1', '$idlanc', '$caixa_id', NOW(), '$valor','$venda_idp','$receber_idp','$cliente','25', '1.01.02.00.000.00','Recibimiento de Cuentas', NOW() )";
            $exe_lancamento_caixa = mysql_query($sql_lancamento_caixa) or die (mysql_error().'-'.$sql_lancamento_caixa);
			global $caixaid;
			$caixaid = mysql_insert_id();
}
function caixa_balcao($caixa_user,$valor,$venda_idp,$receber_idp,$cliente,$idlanc){
$sql_lancamento_caixa = "INSERT INTO lancamento_caixa_balcao (receita_id,idlanc,caixa_id,dt_lancamento,descricao,vl_pago,venda_id,contas_receber_id,entidade_id,lanc_despesa_id,despesa_cod)
            VALUES ('1', '$idlanc', '$caixa_user', NOW(), 'Recibimiento de Cuentas', '$valor','$venda_idp','$receber_idp','$cliente','25', '1.01.02.00.000.00')";
            $exe_lancamento_caixa = mysql_query($sql_lancamento_caixa) or die (mysql_error().'-'.$sql_lancamento_caixa);
			global $caixaid;
			$caixaid = mysql_insert_id();
}

function cheques($jsonCheq,$cliente,$id_usuario,$idlanc){

	for($i = 0; $i < count($jsonCheq); $i++){
	
	$banco = $jsonCheq[$i]->ref;
	$agencia  = $jsonCheq[$i]->agencia;
	$conta = $jsonCheq[$i]->conta;
	$num_cheque  = $jsonCheq[$i]->num_cheque;
	$emissor  = $jsonCheq[$i]->emissor;
	$data_validade  = substr($jsonCheq[$i]->data_validade,0,10);
	$valor  = $jsonCheq[$i]->valor;
	$moeda  = $jsonCheq[$i]->moeda;
	$moeda_id  = $jsonCheq[$i]->moeda_id;
	$cbcompra  = $jsonCheq[$i]->cbcompra;
	
		$total += $valor;
	//if($moeda == "DOLAR"){ $moeda = 1;} else{ $moeda = 3;}
	
			$re = mysql_query("select count(*) as total from cheque where conta = '$conta' AND num_cheque = '$num_cheque' ");
			$totalconsulta = mysql_result($re, 0, "total");
			
			if (0 == 0) {
			$sql_per = "INSERT INTO cheque (id_banco,idlanc,agencia,conta, num_cheque, valor, data_dia, data_emissao, data_validade, 
			emissor, entidadeid, situacao, moeda, idpedido, user) 
			VALUES( '$banco', '$idlanc', UCASE('$agencia'), UCASE('$conta'), UCASE('$num_cheque'), '$valor', NOW(), NOW(), '$data_validade', 
			UCASE('$emissor'), '$cliente', 'AGUARDANDO', '$moeda', '$idPedido', ".$id_usuario." )";
				$exe_per = mysql_query($sql_per) or die (mysql_error().'-'.$sql_per);
				$rows_affected = mysql_affected_rows();			
			if ($rows_affected) $count++;
			}
	}

}


if($acao == "Receber" && $origem == 'ctreceber'){
		if($_POST['caixapgto'] == "cxuser" && $caixa_user == ""){
			echo "{success:true, response: 'Usuario sin caja abierto'}";
			exit();
		}

		 ApuraContas($id,$valor);
			
		//	$sql_desconto = "UPDATE contas_receber SET vl_recebido = $liquidop, juros = $totalJuros, status = 'P' WHERE id = '$id' ";
		//	$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());	

		if($final <= $liquidop){
		
			$sql = "INSERT INTO contas_recparcial (idctreceber, valorpg, datapg, usuarioid) VALUES('$id', '$valor', NOW(), '$id_usuario' )";
			$exe = mysql_query($sql, $base);
			
			function lancContas($caixapgto,$venda_idp,$valor,$id_usuario,$cliente){
			$sql_plan = "INSERT INTO lanc_contas (plano_id,tipo_pgto_id,plan_codigo,documento,dt_lanc_desp,desc_desp,valor,usuario_id,receita_id,valor_total,entidade_id,caixaid,dt_lanc_despb) ";
			$sql_plan.= "VALUES ('25', '$caixapgto', '1.01.02.00.000.00', '$venda_idp', NOW(), 'Recibimiento de Cuentas', '$valor', ". $id_usuario.", '1', '$valor', '$cliente', '$caixaid', NOW() )";
			mysql_query($sql_plan) or die (mysql_error());	
			global $idlanc;
			$idlanc = mysql_insert_id();
			}
			
			
			if($_POST['caixapgto'] == "cxempr"){
			$caixapgto = '4';
			lancContas($caixapgto,$venda_idp,$valor,$id_usuario,$cliente);
			caixa($caixa_id,$valor,$venda_idp,$receber_idp,$cliente,$idlanc);
			
			}
			if($_POST['caixapgto'] == "cxuser"){
			$caixapgto = '4';
			lancContas($caixapgto,$venda_idp,$valor,$id_usuario,$cliente);
			caixa_balcao($caixa_user,$valor,$venda_idp,$receber_idp,$cliente,$idlanc);
			
			}
			if($_POST['caixapgto'] == "cheque"){
			$caixapgto = '2';
			lancContas($caixapgto,$venda_idp,$valor,$id_usuario,$cliente);
			cheques($jsonCheq,$cliente,$id_usuario,$idlanc);
			
			}
			
			
			
			
			if($restante == $valor){
				$sql_cont = "SELECT COUNT(*) AS aberto FROM contas_receber WHERE status = 'A' AND venda_id = '$venda_idp' ";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
				
				// nao esqecer de descomentar
				$sql_close = "UPDATE contas_receber SET status = 'P' WHERE id = '$id' ";
				$exe_close = mysql_query($sql_close) or die (mysql_error());	
				
				if ($reg_cont['aberto'] == 0) {
					$sql_fecha = "UPDATE venda SET st_venda = 'F' WHERE id = '$venda_idp' ";
					$exe_fecha = mysql_query($sql_fecha);
				}	
			}
			
			echo "{success:true, response: 'Recebido'}";
		}
		else{
				echo "{success:true, response: 'Nopodesrecibir'}";
		}
	

}

if($acao == "Receber" && $origem == "NTCredito"){

	$sql = "SELECT nc.idnota_credito, nc.idcliente, nc.idpedido, nc.vlcredito, sum(na.valor_abat) AS valor_abat  FROM nota_credito nc
			LEFT JOIN nc_abatimento na ON na.idntcredito = nc.idnota_credito
			WHERE nc.idnota_credito = '$ncredito' ";
	$exe = mysql_query($sql) or die (mysql_error());
	$reg = mysql_fetch_array($exe, MYSQL_ASSOC);

	$entidade = $reg['idcliente'];
	$adevolver = $_POST['adevolver'];
	$idpedido = $reg['idpedido'];
	$vlcredito =	$reg['vlcredito'];
	$vlabatido =	$reg['valor_abat'];
	$vlcreditofinal = $vlcredito - $vlabatido;	
	$valor = $vlcreditofinal;

	ApuraContas($id,$valor);
	
	if($final <= $liquidop){
		$valor = $final;
	}
	if($final >= $liquidop){
		$valor = $liquidop;
	}
//	echo $adevolver;
	
	if($valor > $adevolver && $adevolver >0){
	
			$sql = "UPDATE contas_receber SET vl_ntcredito = vl_ntcredito + '$adevolver' WHERE id = '$id' ";
			$exe = mysql_query($sql, $base)or die (mysql_error());
			
		// Alterado, pois como nao entrou especie em caixa nao necessita o lancamento
		
		//	$sql = "INSERT INTO contas_recparcial (idctreceber, valorpg, datapg, usuarioid) VALUES('$id', '$valor', NOW(), '$id_usuario' )";
		//	$exe = mysql_query($sql, $base);		

			/*
			$sql_lancar_parcial = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id,contas_receber_id,entidade_id,descricao) 
												VALUES('1', '$caixa_id', NOW(), '$valor', '$venda_idp', '$receber_idp', '$cliente', 'Recibimiento de Cuentas')";
			$exe_lancar_parcial = mysql_query($sql_lancar_parcial, $base) or die (mysql_error());
			$caixaid = mysql_insert_id();
			
			$sql_lancar_parcial = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id,contas_receber_id,entidade_id,descricao) 
												VALUES('2', '$caixa_id', NOW(), '$valor', '$venda_idp', '$receber_idp', '$cliente','Baja Credito de Clientes')";
			$exe_lancar_parcial = mysql_query($sql_lancar_parcial, $base) or die (mysql_error());
		
		
			$sql_plan = "INSERT INTO lanc_contas (plano_id,plan_codigo,documento,dt_lanc_desp,desc_desp,valor,usuario_id,receita_id,valor_total,entidade_id,caixaid) ";
			$sql_plan.= "VALUES ('25', '1.01.02.00.000.00', '$vendaid', NOW(), 'Recibimiento de Cuentas', '$valor', ". $id_usuario.", '1', '$valor', '$cliente', '$caixaid' )";
			mysql_query($sql_plan) or die (mysql_error());	
		
			$sql_plan = "INSERT INTO lanc_contas (plano_id,plan_codigo,documento,dt_lanc_desp,desc_desp,valor,usuario_id,receita_id,valor_total,entidade_id,caixaid) ";
			$sql_plan.= "VALUES ('69', '2.01.06.00.000.00', '$vendaid', NOW(), 'Baja Credito de Clientes', '$valor', ". $id_usuario.", '2', '$valor', '$cliente', '$caixaid' )";
			mysql_query($sql_plan) or die (mysql_error());	
			*/
			
			$sql = "INSERT INTO nc_abatimento (idntcredito,identidade,valor_abat,data_abat,user_abat,idpedido,id_receber)
							VALUES('$ncredito', '$entidade', '$adevolver', NOW(), '$id_usuario', '$idpedido', '$id' )";
			$exe = mysql_query($sql, $base) or die (mysql_error());
			$devolvido = mysql_insert_id();
	
			if($restante == $valor){
				$sql_cont = "SELECT COUNT(*) AS aberto FROM contas_receber WHERE status = 'A' AND venda_id = '$venda_idp' ";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
				
				$sql_close = "UPDATE contas_receber SET status = 'P' WHERE id = '$id' ";
				$exe_close = mysql_query($sql_close) or die (mysql_error());	
				
				if ($reg_cont['aberto'] == 0) {
					$sql_fecha = "UPDATE venda SET st_venda = 'F' WHERE id = '$venda_idp' ";
					$exe_fecha = mysql_query($sql_fecha);
				}	
			}
			echo "{success:true, response: 'Recebido'}";
		}
		else{
				echo "{success:true, response: 'NopodesrecibirZero'}";
		}
	
}

if($acao == "desconto"){
$campo = $_POST['campo'];
$id = $_POST['id'];
	
			$valor = ($_POST['valor']);
			
			$sql_listap = "SELECT cr.*, sum(round(rp.valorpg,2)) AS valor_recebido FROM contas_receber cr 
			LEFT JOIN contas_recparcial rp ON rp.idctreceber = cr.id
			WHERE cr.status = 'A' AND cr.id = '$id' "; 
			$exe_listap = mysql_query($sql_listap, $base) or die (mysql_error());
			$linhap = mysql_fetch_array($exe_listap, MYSQL_ASSOC);
			
	echo		$liquidopp = ($linhap['vl_parcela']);
			$total_restante =  ($liquidopp - $linhap['valor_recebido']);
			
			$venda_idp = $linhap['venda_id'];
			$receber_idp = $linhap['id'];
			$recebido_anterior = $linhap['valor_recebido'];
			$total_recpar = $recebido_anterior + $valor;
		
		if($valor < $total_restante){
		$sql_desconto = "UPDATE contas_receber SET desconto = $valor WHERE id = '$id' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());

		echo "{success:true, response: 'Desconto'}";
		}
		else{
		echo "{success:true, response: 'DescontoCancel'}";
		}
}







?>