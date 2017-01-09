<?php
include "../config.php";
require_once("../biblioteca.php");
conexao();
$mespassado = strftime("%Y-%m-%d", strtotime("-1 month")); // Hoje menos 1 mes
//echo $mespassado;

$mes= date("m");
$ano= date("Y");
$hoje = date("Y-m");

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

$acao = $_POST['acao'];
if(isset($_POST['idconta'])){
$idconta = $_POST['idconta'];
	$sql = "SELECT p.valorlancamento, EXTRACT(MONTH FROM p.dtlancamentoconta) AS MES,  EXTRACT(YEAR FROM p.dtlancamentoconta) AS ANO
	FROM  conta_bancaria_lanc p 
	WHERE p.contab = 'N' AND idcontabancaria = '$idconta' AND p.statuslancamento = 'DISP'
	GROUP BY ANO,MES ORDER BY ANO,MES ASC";  //agrupar por ano e mes, pois precisa saber apenas se existe.
			
	$arr = array();
	$exe = mysql_query($sql);
	$ano = "";
	$periodo = array();
	while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){

	$periodo[] = $reg['ANO'].'-'.$reg['MES'];
	
	}
	foreach ($periodo as $data ) {
  
		if( strtotime($data) < strtotime($hoje) ){				
		
			$sql = "SELECT cl.dtlancamentoconta, cl.idconta_bancaria_lanc,  cl.tipolancamento, cl.idcontabancaria,
					(SELECT sum(cl.valorlancamento) FROM conta_bancaria_lanc cl WHERE cl.idcontabancaria = '$idconta' AND cl.tipolancamento = '1'
					AND  YEAR(cl.dtlancamentoconta) = '".substr($data,0,4)."' AND  MONTH(cl.dtlancamentoconta) = '".substr($data,5,2)."')  AS totalcredito,
					(SELECT sum(cl.valorlancamento) FROM conta_bancaria_lanc cl WHERE cl.idcontabancaria = '$idconta' AND cl.tipolancamento = '2'
					AND  YEAR(cl.dtlancamentoconta) = '".substr($data,0,4)."' AND  MONTH(cl.dtlancamentoconta) = '".substr($data,5,2)."')  AS totaldebito
					FROM  conta_bancaria_lanc cl
					WHERE idcontabancaria = '$idconta' AND  YEAR(cl.dtlancamentoconta) = '".substr($data,0,4)."' AND  MONTH(cl.dtlancamentoconta) = '".substr($data,5,2)."' 
					GROUP BY YEAR(cl.dtlancamentoconta),MONTH(cl.dtlancamentoconta) "; 
			$exe = mysql_query($sql);
			while($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){
			
			 $reg['idconta_bancaria_lanc'];
			 $reg['dtlancamentoconta'];
			 $idconta = $reg['idcontabancaria'];
			 $total = $reg['valorlancamento'];
			 $receita = $reg['tipolancamento'];
			 $totalcredito = $reg['totalcredito'];
			 $totaldebito = $reg['totaldebito'];
			 $totalperiodo = $totalcredito - $totaldebito;
			 
			 $sql = mysql_query("SELECT saldo_apurado FROM conta_bancaria_saldo WHERE idconta_bancaria = '$idconta' ORDER BY idconta_bancaria_saldo DESC limit 0,1");
			 $reg = mysql_fetch_array($sql, MYSQL_ASSOC);
			 $saldo_apurado = $reg['saldo_apurado'];
			 $total = $saldo_apurado + $totalperiodo;
			
			 $sqlins = "INSERT INTO conta_bancaria_saldo (idconta_bancaria,ano_lanc,mes_lanc,dtperiodo,clcredito,cldebito,
						saldo_periodo,saldo_anterior,saldo_apurado,dtfechamento,user,host)
						VALUES('$idconta', '".substr($data,0,4)."', '".substr($data,5,2)."', '".$data.'-00'."', '$totalcredito', '$totaldebito', 
						'$totalperiodo', '$saldo_apurado', '$total', NOW(), '$id_usuario','')";
			 $exeins = mysql_query($sqlins);
			}

			$sqlup = "UPDATE conta_bancaria_lanc SET contab = 'S' WHERE idcontabancaria = '$idconta' 
					AND  YEAR(dtlancamentoconta) = '".substr($data,0,4)."' AND  MONTH(dtlancamentoconta) = '".substr($data,5,2)."' ";
			$exeup = mysql_query($sqlup)or die (mysql_error());
			
		}		
	}
}	


/*
echo	$sqlver = "SELECT * FROM conta_bancaria_saldo WHERE YEAR(dtperiodo) = $ano AND MONTH(dtperiodo) = $mes ";
	$exever = mysql_query($sqlver);
echo	$rows = mysql_num_rows($exever);
	$regver = mysql_fetch_array($exever, MYSQL_ASSOC);
*/
	


if($acao == "novaConta"){	
$idbanco = $_POST['id_banco'];
$nm_agencia = $_POST['nm_agencia'];
$nm_conta = $_POST['nm_conta'];
$limite = $_POST['limite'];
$saldo = $_POST['saldo'];
$moeda = $_POST['moeda'];
$user = $_POST['user'];

	$sql_ins = "INSERT INTO conta_bancaria
	(idbanco,nm_agencia,nm_conta,limite,saldo,moeda,user,dtcadastro)
	VALUES('$idbanco', UCASE('$nm_agencia'), UCASE('$nm_conta'), '$limite', '$saldo', '$moeda', '$user', NOW())";
	$exe_ins = mysql_query($sql_ins, $base)  or die (mysql_error());
	echo "{success:true, response: 'Nueva Cuenta Catastrada' }"; 
	exit();
}

if($acao == "ListaContas"){
$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 5 ;

	$rs    = mysql_query("SELECT c.*, b.nome_banco, m.nm_moeda FROM conta_bancaria c 
			LEFT JOIN banco b ON b.id_banco = c.idbanco
			LEFT JOIN moeda m ON m.id = c.moeda
			WHERE 1=1
			ORDER BY c.idconta_bancaria ASC LIMIT $inicio, $limite ")or die (mysql_error().'-'.$rs);
	$totalContas = mysql_num_rows($rs);
	
	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		
	}
	echo '({"totalContas":"'.$totalContas.'","Contas":'.json_encode($arr).'})'; 
}

if($acao == "Extrato"){
$idconta = $_POST['idconta'];

	$sqlext	=	"SELECT ctl.*, date_format(ctl.dtlancamentoconta, '%d/%m/%Y') AS dtlancamentoconta FROM conta_bancaria_lanc ctl 
				WHERE idcontabancaria = '$idconta' AND contab = 'N' AND ctl.statuslancamento = 'DISP' ";
	$exeext = mysql_query($sqlext);
	$arr = array();
	$dados = array();
	$saldod = array();
	while($obj = mysql_fetch_array($exeext, MYSQL_ASSOC))
	{
		if($obj['tipolancamento'] == 1){
		$Entradas +=  $obj['valorlancamento'];
		}
		if($obj['tipolancamento'] == 2){
		$Saidas +=  $obj['valorlancamento'];
		}
		$SaldoPeriodo = number_format($Entradas - $Saidas, 2, '.', '');
	
		$arr[] = $obj;
			
		$dados = array('Saldo'=>$Saldo, "SaldoPeriodo"=>$SaldoPeriodo);
		
	}
	$sqlsaldo = "SELECT saldo_periodo,saldo_apurado FROM conta_bancaria_saldo WHERE idconta_bancaria = '$idconta' ORDER BY idconta_bancaria_saldo DESC limit 0,1";
	$exesaldo = mysql_query($sqlsaldo);
	$reg = mysql_fetch_array($exesaldo, MYSQL_ASSOC);
	$atual = number_format($reg['saldo_apurado'] + $SaldoPeriodo,2);
	$saldos = array('SaldoAnterior'=>$reg['saldo_apurado'], 'atual'=>$atual);
	
	echo '{"dados":'.json_encode($dados).', "anterior":'.json_encode($saldos).', "Extrato":'.json_encode($arr).'}'; 
	





}

?>