<?php
include "../config.php";
conexao();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

require_once("../verifica_login.php");
require_once("../biblioteca.php");
$sql_caixa_balcao = "SELECT * FROM caixa_balcao WHERE usuario_id = ". $id_usuario." AND st_caixa = 'A'";
$rs_caixa_balcao = mysql_query($sql_caixa_balcao);
$linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao, MYSQL_ASSOC);
$caixa_id = $linha_caixa_balcao['id'];

//$cotacao = $_GET['cotacao'];
$acao = $_POST['acao'];

if($acao == "ListaContas"){  //2171-2512-284653
$rs    = mysql_query("SELECT cl.nome,cl.controle,cl.ruc,cl.telefone1, sum(round(crp.valorpg,2)) AS valor_recebido, sum(cr.vl_parcela - cr.desconto - cr.vl_recebido ) AS valor_parcela,
cr.status, cr.vl_recebido, cr.id
FROM entidades cl, contas_receber cr
LEFT JOIN contas_recparcial crp ON crp.contas_rec_id = cr.id
WHERE cr.status = 'A' AND cl.controle = cr.clientes_id  
GROUP BY cr.clientes_id
ORDER BY cl.nome asc")or die (mysql_error());	
$arr = array();
$total = mysql_num_rows($rs);
while($obj = mysql_fetch_object($rs))
{	

	//echo $obj['valor_parcela'];
	$arr[] = $obj;
	
	
}

//echo $_GET['callback'].'({"result":'.json_encode($arr).'})'; 
echo '({"totalClientes":'.$total.',"Clientes":'.json_encode($arr).'})'; 
}

if($acao == "ListaLcto"){
$idCli = $_POST['idCli'];

$rs    = mysql_query("SELECT cr.id, cr.nm_total_parcela, cr.nm_parcela, cr.vl_ntcredito, cr.clientes_id, cr.venda_id, 
cr.vl_parcela, cr.vl_recebido, cr.status, cr.desconto, cr.juros, sum(round(rp.valorpg,2)) AS valor_recebido, cr.vl_restante, cr.vl_multa, cr.perc_juros, 
date_format(cr.dt_vencimento, '%d/%m/%Y') AS dt_vencimento, date_format(cr.dt_lancamento, '%d/%m/%Y') AS dt_lancamento, 
datediff( NOW(), cr.dt_vencimento) AS dias_atrazo, round((cr.vl_parcela * cr.perc_juros / 30) * (datediff( NOW(), cr.dt_vencimento) / 100),2 ) As valor_juros, 
cr.perc_juros,  cl.controle,cl.nome 
FROM entidades cl, contas_receber cr
LEFT JOIN contas_recparcial rp ON rp.idctreceber = cr.id
WHERE cr.clientes_id = '$idCli' AND cr.clientes_id = cl.controle AND cr.status = 'A' GROUP BY cr.id  ");
$arr = array();
while ($obj = mysql_fetch_array($rs)){

	$valor_recebido = $obj['valor_recebido'] ? $obj['valor_recebido'] : 0.00;
	$valor_recebido = $valor_recebido + $obj['vl_recebido'];

	$arr[] = array('id'=>$obj['id'], 'dt_lancamento'=>$obj['dt_lancamento'], 'dt_vencimento'=>$obj['dt_vencimento'], 'nm_total_parcela'=>$obj['nm_total_parcela'],
					'vl_ntcredito'=>$obj['vl_ntcredito'], 'nome'=>$obj['nome'], 'venda_id'=>$obj['venda_id'], 'vl_parcela'=>$obj['vl_parcela'], 'desconto'=>$obj['desconto'],
					'perc_juros'=>$obj['perc_juros'], 'valor_recebido'=>$valor_recebido );
	}
	
echo '({"Facturas":'.json_encode($arr).'})'; 

}
////UPDATE NA TABELA //////////////////////////////////////////////

if($acao == "Receber"){

$valor = ajustaValor($_POST['valor']);
$id = $_POST['idPagare'];

			$sql_listap = "SELECT cr.*, round((cr.vl_parcela * cr.perc_juros / 30) * (datediff( NOW(), cr.dt_vencimento) / 100),2 ) As valor_juros,
			sum(round(rp.valorpg,2)) AS valor_recebido, clientes_id
			FROM contas_receber cr  
			LEFT JOIN contas_recparcial rp ON rp.idctreceber = cr.id
			WHERE cr.status = 'A' AND cr.id = '$id' "; 
			$exe_listap = mysql_query($sql_listap, $base) or die (mysql_error());
			$linhap = mysql_fetch_array($exe_listap, MYSQL_ASSOC);
			
			if($linhap['valor_juros'] < 0){
			$valorJuro = 0.00; } else{ $valorJuro = $linhap['valor_juros']; };
			$liquidop = ($linhap['vl_parcela'] - ($linhap['desconto'] + $linhap['valor_recebido']));
     		$restante =  round($liquidop - $linhap['vl_recebido'],2);
			
			$venda_idp = $linhap['venda_id'];
			$receber_idp = $linhap['id'];
			$cliente =  $linhap['clientes_id'];
			
			$totalJuros = $valorJuro;
			
    		$recebido_anterior = $linhap['valor_recebido'];
			$total = $recebido_anterior + $valor;
			
			$fechamento = round($restante - $valor,2);
			
		//	$sql_desconto = "UPDATE contas_receber SET vl_recebido = $liquidop, juros = $totalJuros, status = 'P' WHERE id = '$id' ";
		//	$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());	

		if($fechamento >= 0){
			
			$sql = "INSERT INTO contas_recparcial (idctreceber, valorpg, datapg, usuarioid) VALUES('$id', '$valor', NOW(), '$id_usuario' )";
			$exe = mysql_query($sql, $base);

			$sql_lancar_parcial = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id,contas_receber_id) 
												VALUES('1', '$caixa_id', NOW(), '$valor', '$venda_idp', '$receber_idp')";
			$exe_lancar_parcial = mysql_query($sql_lancar_parcial, $base) or die (mysql_error());
			$caixaid = mysql_insert_id();
			
			$sql_plan = "INSERT INTO lanc_contas (plano_id,plan_codigo,documento,dt_lanc_desp,desc_desp,valor,usuario_id,receita_id,valor_total,entidade_id,caixaid) ";
			$sql_plan.= "VALUES ('25', '1.01.02.00.000.00', '$vendaid', NOW(), 'Recibimiento de Cuentas', '$valor', ". $id_usuario.", '1', '$valor', '$cliente', '$caixaid' )";
			mysql_query($sql_plan) or die (mysql_error());	
			
			if($fechamento == 0){
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
		echo "{success:true, response: 'Nopodesrecibir'}";
	}

}

$campo = $_POST['campo'];
if($campo == '9'){
	$id = $_POST['id'];
	
			$valor = ajustaValor($_POST['valor']);
			
			$rs    = mysql_query("SELECT cr.id, cr.venda_id, cr.vl_parcela, cr.vl_recebido, cr.desconto, sum(round(rp.valorpg,2)) AS valor_recebido, cr.vl_restante,  
								cl.controle,cl.nome 
								FROM entidades cl, contas_receber cr
								LEFT JOIN contas_recparcial rp ON rp.idctreceber = cr.id
								WHERE cr.id = '$idCli' AND cr.clientes_id = cl.controle AND cr.status = 'A' GROUP BY cr.id  ");
			while ($obj = mysql_fetch_array($rs)){

			$valor_recebido = $obj['valor_recebido'] ? $obj['valor_recebido'] : 0.00;
	    	$valor_recebido = $valor_recebido + $obj['vl_recebido'];

			}
			
			
		
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