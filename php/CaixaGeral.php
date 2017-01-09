<?php
require_once("../biblioteca.php");
include "../config.php";
conexao();
require_once("../verifica_login.php");

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');
	
include_once("json/JSON.php");
$json = new Services_JSON();
$data = strftime("%Y-%m-%d", strtotime("-30 days")); // Hoje menos 30 dias
$mes= date("m");
$ano= date("Y");
$hoje = date("Y-m-d");
$dias = 30;
$xdata = "86400" * $dias +mktime(0,0,0,date('m'),date('d'),date('Y'));
$xdata = date("Y-m-d",$xdata);

function ajustaValores($v) {
		$v = str_replace(".","",$v);
		$v = str_replace(".","",$v);
		$v = str_replace(".","",$v);
		$v = str_replace(",",".",$v);
		$v = str_replace("$","",$v);
		return $v;
	}


//echo $xdata;

$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';
//$dataini = isset($_POST['dataini']) ? converte_data('2',$_POST['dataini']) : $data ;
//$datafim = isset($_POST['datafim']) ? converte_data('2',$_POST['datafim']) : $hoje ;
$dataini = converte_data('2',$_POST['dataini']);
$datafim = converte_data('2',$_POST['datafim']);

if($acao == 'ListaLcto'){

	$sql = "SELECT l.receita_id, l.id, l.historico, c.id AS cxid, l.caixa_balcao_id, l.venda_id, l.valor, p.nome,
	u.nome_user, date_format(l.data_lancamento, '%d/%m/%Y') AS datalcto
	FROM caixa_balcao cb, caixa c
	LEFT JOIN usuario u ON u.id_usuario = c.usuario_id
	LEFT JOIN lancamento_caixa l ON c.id = l.caixa_id 
	LEFT JOIN entidades p ON p.controle = l.fornecedor_id 
	LEFT JOIN lancamento_caixa_balcao lb ON lb.id = l.caixa_balcao_id 
	WHERE l.caixa_id = c.id "; 
	if(isset($_POST['dataini']) && isset($_POST['datafim'])){
	$sql .= " AND l.data_lancamento BETWEEN '$dataini' AND '$datafim 23:59:59.999' ";
	}
	else{
	$sql .= " AND MONTH(l.data_lancamento) = $mes AND YEAR(l.data_lancamento) = $ano  ";
	}
	$sql .= " group by l.id order by l.id desc ";
		
		$rs = mysql_query($sql) or die(mysql_error().'-'.$sql);

		$arr = array();
		while($obj = mysql_fetch_array($rs)){
		
		if($obj['receita_id'] == '7'){
		$transf += $obj['valor'];
		}
		if($obj['receita_id'] == '2'){
		$saidas += $obj['valor'];
		}
		if($obj['receita_id'] == '8'){
		$saidasB += $obj['valor'];
		}
		if($obj['receita_id'] == '1'){
		$transf += $obj['valor'];
		}
		$saidas = $saidas + $saidasB;
		//$arr[] = $obj;
		$arr[] = array('caixa_id'=>$obj['cxid'].$w, 'receita_id'=>$obj['receita_id'], 'datalcto'=>$obj['datalcto'], 'venda_id'=>$obj['venda_id'],
					    'valor'=>$obj['valor'], 'historico'=>$obj['historico'], 'nome'=>$obj['nome'], 
						'caixa'=>$obj['caixa_balcao_id'], 'id'=>$obj['id']);
		}
	
	//if ($arr)
	echo '({"saidas":"'.$saidas.'", "transf":"'.$transf.'", "Lcto":'.json_encode($arr).'})'; 

}

if($acao == 'SaldoTotal'){

$sql_lista = "SELECT * FROM caixa ORDER BY id DESC limit 0,1 ";
$exe_lista = mysql_query($sql_lista, $base);
$reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC);
$caixa_atual = $reg_lista['id'];
$status = $reg_lista['status'];
$abertura = $reg_lista['valor_abertura'];
$fechamento = $reg_lista['valor_fechamento'];
//$saldoAnterior = $fechamento - $abertura;

$sql = "SELECT l.id,l.receita_id,l.caixa_id, l.caixa_balcao_id, l.valor, u.nome_user, c.id AS idc, c.valor_abertura, date_format(l.data_lancamento, '%d/%m/%Y') AS datalcto FROM  lancamento_caixa l, caixa c
	LEFT JOIN usuario u ON u.id_usuario = c.usuario_id
	WHERE l.caixa_id = '$caixa_atual'
	   GROUP BY l.id order by l.id desc ";
		$rs = mysql_query($sql) or die(mysql_error().'-'.$sql);

		$arr = array();
		$count = 0;
		while($obj = mysql_fetch_array($rs)){
		
		//echo $obj['valor'];
		
		if($obj['receita_id'] == '7'){
		$entradasGeral += $obj['valor'];
		}
		if($obj['receita_id'] == '1'){
		$outrasEntradas += $obj['valor'];
		}
		if($obj['receita_id'] == '2'){
		$saidasGeralA += $obj['valor'];
		}
		
		if($obj['receita_id'] == '8'){
		$saidasGeralB += $obj['valor'];
		}
		
		
		
		$arr[] = $obj;
		}
	$entradasGeral = $entradasGeral + $outrasEntradas;
	$saidasGeral = ($saidasGeralA + $saidasGeralB);
	$totalAtual = ($entradasGeral + $outrasEntradas )- $saidasGeral;
	$acumulado =  ($abertura + $entradasGeral + $outrasEntradas) - $saidasGeral;
	
	//if ($arr)
	echo '({"saidasGeral":"'.$saidasGeral.'", "saldoAnterior":"'.$abertura.'", "entradasGeral":"'.$entradasGeral.'", "acumulado":"'.$acumulado.'", "caixa":"'.$caixa_atual.'", "status":"'.$status.'", "totalAtual":"'.$totalAtual.'" })'; //,"Lcto":'.json_encode($arra).'})'; 

}

if($acao == 'Encerrar'){
$caixa_id = $_POST['id'];
$user = $_POST['user'];

$sql_lista = "SELECT * FROM caixa WHERE id = '$caixa_id' ";
$exe_lista = mysql_query($sql_lista, $base);
$reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC);

$abertura = $reg_lista['valor_abertura'];
$fechamento = $reg_lista['valor_fechamento'];

$sql = "SELECT id,receita_id,caixa_id,valor FROM lancamento_caixa WHERE caixa_id = '$caixa_id' ";
$exe = mysql_query($sql, $base)or die (mysql_error());
while ($reg =  mysql_fetch_array($exe, MYSQL_ASSOC)){

		if($reg['receita_id'] == '7'){
		$transf += $reg['valor'];
		}
		if($reg['receita_id'] == '2'){
		$saidas += $reg['valor'];
		}
		if($reg['receita_id'] == '8'){
		$retiradas += $reg['valor'];
		}
	}
		$entradas = round($transf,2);
		
		$saidas_geral = round($saidas,2) + round($retiradas,2);
		
		$total = round($abertura,2) + (round($entradas,2) - round($saidas_geral,2));  

$sql_close = "UPDATE caixa SET data_fechamento = NOW(), 
								status = 'F', 
								valor_fechamento = '$total', 
								usuario_fechamento = '$user', 
								valor_mov_entrada = '$transf',
								valor_mov_saida =  '$saidas_geral'
								WHERE id = '$caixa_id' "; 
$exe_close = mysql_query($sql_close, $base);

echo "{success:true, response: 'Caixa Encerrado com Sucesso' }"; 
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($acao == 'ACaixa'){
$user = $_POST['user'];

$sql_lista = "SELECT * FROM caixa WHERE status = 'F' ORDER BY id DESC limit 0,1 ";
$exe_lista = mysql_query($sql_lista, $base);
$reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC);
$row = mysql_num_rows($exe_lista);
if($row == '0'){
echo "{success:true, response: 'Caixa Ja se Encontra Aberto' }"; 
exit();
}
$abertura = $reg_lista['valor_abertura'];
$fechamento = $reg_lista['valor_fechamento'];

$saldo = $abertura - $fechamento;

$sql_abre = "INSERT INTO caixa (usuario_id, data_abertura, status, valor_abertura)
							VALUES( '$user', NOW(), 'A', '$fechamento') ";
$exe_abre = mysql_query($sql_abre, $base);

echo "{success:true, response: 'Caixa Aberto com Sucesso' }"; 

}

if($acao == 'DepConta'){
$user = $_POST['user'];
$idconta = $_POST['idconta_bancaria'];
$valor = ($_POST['vlRetirar']);
$datadep = substr($_POST['datadep'],0,10);
$historico = "Deposito Bancario";

$ex = explode("-", $datadep);
$ano = $ex[0];
$mes = $ex[1];
$dia = $ex[2];
$res = checkdate($mes, $dia, $ano);
if($res == 0){
	echo "Fecha no válida!";
	exit();
}


	$sql_lista = "SELECT id FROM caixa WHERE status = 'A' ORDER BY id DESC limit 0,1 ";
	$exe_lista = mysql_query($sql_lista, $base);
	$reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC);
	$row = mysql_num_rows($exe_lista);
	$idcaixa = $reg_lista['id'];
	if($row == '0'){
		echo "{success:true, response: 'FinanceiroFechado' }"; 
	exit();
	}
	else{
	
			$sql_plan = "INSERT INTO lanc_contas (plano_id, tipo_pgto_id, plan_codigo, dt_lanc_desp, desc_desp, valor, usuario_id, receita_id, valor_total, caixaid, dt_lanc_despb) ";
			$sql_plan.= "VALUES ('72', '4', '2.01.09.00.000.00', '$datadep', 'Transferencias Caja - Banco', '$valor', '".$id_usuario."', '2', '$valor', '$idcaixa', NOW() )";
			mysql_query($sql_plan) or die (mysql_error());	
			$idlanc = mysql_insert_id();
			
			$sql_ret = "INSERT INTO lancamento_caixa (idlanc, receita_id, caixa_id, data_lancamento, valor, historico, data_lancamentob) 
			VALUES('$idlanc', '2', '$idcaixa', NOW(), '$valor', '$historico', NOW() ) ";
			$exe_ret = mysql_query($sql_ret) or die (mysql_error().'-'.$sql_ret);
			
			$sql_ins = "INSERT INTO conta_bancaria_lanc (idcontabancaria,dtlancamentoconta,valorlancamento,tipolancamento,historico,
						user,host,statuslancamento,lctosis)
						VALUES('$idconta', '$datadep', '$valor', '1', 'Dep. Cuenta', ". $id_usuario.", '$host', 'DISP', NOW() )";
			$exe_ins = mysql_query($sql_ins, $base);
			$rows_affected = mysql_affected_rows();
					
		echo "{success:true, response: 'Operacion Realizada con Exito' }"; 
}



}















?>