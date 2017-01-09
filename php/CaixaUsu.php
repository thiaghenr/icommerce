<?php
include "../config.php";
conexao();
//require_once("../verifica_login.php");
function ajustaValor($v) {
		$v = str_replace(".","",$v);
		$v = str_replace(".","",$v);
		$v = str_replace(".","",$v);
		$v = str_replace(",",".",$v);
		$v = str_replace("$","",$v);
		return $v;
	}


$query = $_POST['query'];
$acao = $_POST['acao'];
$idCaixa = $_POST['idCaixa'];
$user = $_POST['user'];

if($acao == "listarCaixas"){
$rs = "SELECT  u.nome_user, c.id, date_format(c.dt_abertura, '%d/%m/%Y')AS dt_abertura, date_format(c.dt_fechamento, '%d/%m/%Y')AS dt_fechamento, 
c.vl_abertura, c.vl_fechamento, c.st_caixa, c.st_transferencia, 
(SELECT sum(vl_pago) FROM lancamento_caixa_balcao WHERE receita_id = 7 AND caixa_id = c.id )  AS vl_transferido_fin,
(SELECT sum(vl_pago) FROM lancamento_caixa_balcao WHERE receita_id = 2 AND caixa_id = c.id )  AS vl_mov_saida,
(SELECT sum(vl_pago) FROM lancamento_caixa_balcao WHERE receita_id = 1 AND caixa_id = c.id )  AS vl_mov_entrada
FROM caixa_balcao c
LEFT JOIN usuario u ON u.id_usuario = c.usuario_id 
WHERE 1 = 1 ";
if(isset($query)){
$rs .= " AND u.nome_user LIKE '$query%' ";
}
$rs .= "GROUP BY c.id ORDER BY c.id desc limit 0,62 ";

$exe = mysql_query($rs, $base)or die (mysql_error());
$arr = array();
$total = mysql_num_rows($exe);
while($obj = mysql_fetch_array($exe))
{	
	$arr[] = $obj;
	
}

//echo $_GET['callback'].'({"result":'.json_encode($arr).'})'; 
echo '({"total":'.$total.',"results":'.json_encode($arr).'})'; 
}


if($acao == "transferir"){
$valor_trf = 0.00;
 $valor_trf = ajustaValor($_POST['vlTrf']);
			
			$sqld = "SELECT id FROM caixa WHERE status = 'A' order by id desc ";
			$rsd = mysql_query($sqld) or die (mysql_error() .' '.$sqld);
			$num_rowsd = mysql_num_rows($rsd);
			$reg_trf = mysql_fetch_array($rsd);		
			$id = $reg_trf['id'];
		if($num_rowsd > 0){
		$sql_caixa = "SELECT usuario_id FROM caixa_balcao WHERE id = '".$idCaixa."' "; 
		$exe_caixa = mysql_query($sql_caixa, $base);
		$reg_caixa = mysql_fetch_array($exe_caixa, MYSQL_ASSOC);
		$usuario = $reg_caixa['usuario_id'];
		if($usuario != $user){
			echo "{success:true, response: 'UsuarioNaoConfere' }";
		}
		else{
		$sql_lancamentos = "SELECT cb.vl_abertura, lc.vl_pago, lc.receita_id  
		FROM lancamento_caixa_balcao lc, caixa_balcao cb WHERE cb.id = '$idCaixa' AND cb.id = lc.caixa_id ";
		$exe_lancamentos = mysql_query($sql_lancamentos) or die(mysql_error().'-'.$sql_lancamentos);
		while ($obj = mysql_fetch_array($exe_lancamentos, MYSQL_ASSOC)){
		
		$vl_abertura = $obj['vl_abertura'] ;
		
		if($obj['receita_id'] == 1){
		$Entradas +=  $obj['vl_pago'];
		}
		if($obj['receita_id'] == 2){
		$Saidas +=  $obj['vl_pago'];
		}
		if($obj['receita_id'] == 7){
		$Trf +=  $obj['vl_pago'];
		}
		
		}
	 $saldo = round(($Entradas + $vl_abertura) - ($Saidas + $Trf),2);
		if($saldo < $valor_trf){
			echo "{success:true, response: 'SaldoInsuficiente' }"; 
		exit();
		}
		else{
	
			$sql_trf = "INSERT INTO lancamento_caixa (receita_id,caixa_id,data_lancamento,caixa_balcao_id,valor) 
			VALUES('7', '$id', NOW(), '$idCaixa', '$valor_trf') ";
			$exe_trf = mysql_query($sql_trf) or die (mysql_error().'-'.$sql_trf);
			
			$sql_trfb = "INSERT INTO lancamento_caixa_balcao (receita_id,dt_lancamento,caixa_id,vl_pago)
			VALUES('7', NOW(), '$idCaixa', '$valor_trf') ";
			$exe_trfb = mysql_query($sql_trfb) or die (mysql_error().'-'.$sql_trfb);

			$sql_update = "UPDATE caixa_balcao SET vl_transferido_fin = vl_transferido_fin + '$valor_trf' WHERE id = '".$idCaixa."' ";
			$exe_update = mysql_query($sql_update);
					
			echo "{success:true, response: 'Transferido' }"; 
			}
	}
	}
	else{
	echo "{success:true, response: 'FinanceiroFechado' }"; 
			}
}

if($acao == "encerrar"){

	$sql = "SELECT vl_pago, receita_id FROM lancamento_caixa_balcao WHERE caixa_id = '".$idCaixa."' ";
	$exe = mysql_query($sql, $base) or die (mysql_error());
	while($obj = mysql_fetch_array($exe, MYSQL_ASSOC)){
	
		if($obj['receita_id'] == 1){
		$Entradas +=  $obj['vl_pago'];
		}
		if($obj['receita_id'] == 2){
		$Saidas +=  $obj['vl_pago'];
		}
		if($obj['receita_id'] == 3){
		$Devs +=  $obj['vl_pago'];
		}
		if($obj['receita_id'] == 7){
		$Trf +=  $obj['vl_pago'];
		}
	}
//	echo $Devs;
		$positivo = round($Entradas,2) + round($vl_abertura,2);
		$negativo = round($Saidas,2) + round($Trf,2);
		$Saldo = round($positivo,2) - round($negativo,2);
		
		$sql_caixa = "SELECT usuario_id FROM caixa_balcao WHERE id = '".$idCaixa."' "; 
		$exe_caixa = mysql_query($sql_caixa, $base);
		$reg_caixa = mysql_fetch_array($exe_caixa, MYSQL_ASSOC);
		$usuario = $reg_caixa['usuario_id'];
		if($usuario != $user){
			echo "{success:true, response: 'UsuarioNaoConfere' }";
		}
		else{
		if($Saldo == 0){
		
		$sql = "UPDATE caixa_balcao SET dt_fechamento = NOW(), st_caixa = 'F', vl_mov_entrada = '".$positivo."', vl_mov_saida = '".$Saidas."', vl_transferido_fin = '".$Trf."'
				WHERE id = '".$idCaixa."' ";
		$exe = mysql_query($sql, $base)or die (mysql_error());
		
		echo "{success:true, response: 'CaixaEncerrado' }";
		
		}
		else{
			echo "{success:true, response: 'SaldoAtivo' }"; 
		}
		}
}

if($acao == "AbCaixa"){

		$sql_caixa = "SELECT COUNT(id) AS n_id FROM caixa_balcao WHERE usuario_id = '".$user."' AND st_caixa = 'A' "; 
		$exe_caixa = mysql_query($sql_caixa, $base);
		$reg_caixa = mysql_fetch_array($exe_caixa, MYSQL_ASSOC);
		$n_id = $reg_caixa['n_id'];
		
		if($n_id == 0){
		
		$sql_ins = "INSERT INTO caixa_balcao (dt_abertura, usuario_id, st_caixa)
											 VALUES(NOW(), '".$user."', 'A')";
		$exe_ins = mysql_query($sql_ins, $base) or die (mysql_error());		
				
		echo "{success:true, response: 'CaixaAberto' }";
		}
		else{
		echo "{success:true, response: 'CaixaJaAberto' }";
		}



}



?>