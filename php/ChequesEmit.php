<?php
 require_once("../config.php");
 conexao();
 include("json.php");
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');



$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 40 ;
$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';

if($acao == 'listarCheques') {
 
 $rss = mysql_query("SELECT idcheque_emit FROM cheque_emit WHERE situacao != 'COMPENSADO' ");
 $rs    = mysql_query("SELECT ch.*, date_format(ch.dtemissao, '%Y/%m/%d') AS dtemissao, date_format(ch.dtvencimento, '%d/%m/%Y') AS dtvencimento,
			b.nome_banco, e.nome, ct.idconta_bancaria, ct.nm_agencia, ct.nm_conta, ct.nm_agencia, ct.nm_conta, m.nm_moeda
			FROM cheque_emit ch, banco b, entidades e, conta_bancaria ct, moeda m
            WHERE ch.contabancoid = ct.idconta_bancaria AND ch.entid = e.controle  AND ch.situacao != 'COMPENSADO' AND b.id_banco = ct.idbanco AND ct.moeda = m.id
            GROUP BY ch.idcheque_emit ORDER BY ch.dtvencimento DESC  LIMIT $inicio, $limite ")or die (mysql_error());
 $total  =mysql_num_rows($rss);
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '{"total":'.$total.',"results":'.json_encode($arr).'}'; 
} 

if($acao == 'Mover') {
$situacao = $_POST['situacao'];
$idCheque = $_POST['idCheque'];
$user = $_POST['user'];
$host = $_POST['host'];
$valor = $_POST['valor'];
$conta = $_POST['conta'];

$rss = mysql_query("SELECT situacao,moedaid,numerocheque FROM cheque_emit WHERE idcheque_emit = '$idCheque' ");
$exee = mysql_fetch_array($rss, MYSQL_ASSOC );
$statual = $exee['situacao'];
$moedacheque = $exee['moedaid'];
$numerocheque = $exee['numerocheque'];

$rssx = mysql_query("SELECT moeda FROM conta_bancaria WHERE idconta_bancaria = '$conta' ");
$exeex = mysql_fetch_array($rssx, MYSQL_ASSOC );
$moeda = $exeex['moeda'];
/*
	$sql_up = "UPDATE cheque SET situacao = '$situacao', user = '$user' WHERE idcheque_emit = '$idCheque' ";
	$exe_up = mysql_query($sql_up, $base);
	$rows_affected = mysql_affected_rows();
	echo $rows_affected;
	if($rows_affected){
*/

////////////////////////////////////////////////////
		if($situacao == 'COMPENSADO'){
			if($statual == 'A'){  //AGUARDANDO
			$sql_up = "UPDATE cheque_emit SET situacao = '$situacao', user = '$user' WHERE idcheque_emit = '$idCheque' ";
			$exe_up = mysql_query($sql_up, $base);
			$sql_upc = "INSERT INTO conta_bancaria_lanc (idcontabancaria,dtlancamentoconta,valorlancamento,tipolancamento,historico,
								user,host,statuslancamento,idcheque_emit)
								VALUES('$conta', NOW(), '$valor', '2', 'Emision. Cheque $numerocheque', '$user', '$host', 'DISP', '$idCheque' )";
			$exe_upc = mysql_query($sql_upc, $base);
			$rows_affected = mysql_affected_rows();
			if($rows_affected){
				echo "{success:true, response: 'Operacion Realizada con Exito' }"; 
			}
		}
		else{
				echo "{success:true, response: 'Cheque debe estar como AGUARDANDO '}"; 
			}
		}
///////////////////////////////////////////////////////			
///////////////////////////////////////////////////////			
		if($situacao == 'DEVOLVIDO' ){
			if($statual == 'DEPOSITADO'){
					$sql_upc = "UPDATE cheque SET situacao = '$situacao', user = '$user' WHERE idcheque_emit = '$idCheque' ";
					$exe_upc = mysql_query($sql_upc, $base);
					$rows_affected = mysql_affected_rows();
					if($rows_affected){
					$sql_upd = "INSERT INTO conta_bancaria_lanc (idcontabancaria,dtlancamentoconta,valorlancamento,tipolancamento,historico,
								user,host,statuslancamento,idcheque)
								VALUES('1', NOW(), '$valor', '2', 'Dev. Cheque $idCheque', '$user', '$host', 'IND', '$idCheque' )";
					$exe_upd = mysql_query($sql_upd, $base);
					$rows_affected = mysql_affected_rows();
					if($rows_affected){
						echo "{success:true, response: 'Operacion Realizada con Exito' }"; 
					}
				}
		
		}
		else{
				echo "{success:true, response: 'Cheque Todavia no DEPOSITADO '}"; 
			}
		}
		
///////////////////////////////////////////////////
			
		if($situacao == 'AGUARDANDO'){
			if($statual == 'DEVOLVIDO'){
			$sql_upc = "UPDATE cheque SET situacao = '$situacao', user = '$user' WHERE idcheque_emit = '$idCheque' ";
			$exe_upc = mysql_query($sql_upc, $base);
			$rows_affected = mysql_affected_rows();
			if($rows_affected){
				echo "{success:true, response: 'Operacion Realizada con Exito' }"; 
			}
			
		}
		else if($statual == 'AGUARDANDO'){
			echo "{success:true, response: 'Cheque ya se encuentra AGUARDANDO '}"; 
		}
	

}

}

?>