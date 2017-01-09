<?php
 require_once("../config.php");
 conexao();
 include("JSON.php");
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');



$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 40 ;
$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';

if($acao == 'listarCheques') {
 
 $rss = mysql_query("SELECT id_cheque FROM cheque WHERE situacao != 'COMPENSADO' ");
 $rs    = mysql_query("SELECT ch.*, date_format(ch.data_dia, '%Y/%m/%d') AS data_dia, date_format(ch.data_dia, '%d/%m/%Y') AS validade,
			b.nome_banco, e.nome, m.nm_moeda 
			FROM cheque ch, banco b, entidades e, moeda m
            WHERE  ch.id_banco = b.id_banco AND ch.entidadeid = e.controle AND ch.moeda = m.id AND ch.situacao != 'COMPENSADO' 
            GROUP BY ch.id_cheque ORDER BY ch.data_validade DESC  LIMIT $inicio, $limite ")or die (mysql_error());
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

$rss = mysql_query("SELECT situacao,moeda,num_cheque FROM cheque WHERE id_cheque = '$idCheque' ");
$exee = mysql_fetch_array($rss, MYSQL_ASSOC );
$statual = $exee['situacao'];
$moedacheque = $exee['moeda'];
$num_cheque = $exee['num_cheque'];

$rssx = mysql_query("SELECT moeda FROM conta_bancaria WHERE idconta_bancaria = '$conta' ");
$exeex = mysql_fetch_array($rssx, MYSQL_ASSOC );
$moeda = $exeex['moeda'];
/*
	$sql_up = "UPDATE cheque SET situacao = '$situacao', user = '$user' WHERE id_cheque = '$idCheque' ";
	$exe_up = mysql_query($sql_up, $base);
	$rows_affected = mysql_affected_rows();
	echo $rows_affected;
	if($rows_affected){
*/
		if($situacao == 'DEPOSITADO'){
			if($conta != ""){
				if($moedacheque == $moeda){
					$sql_up = "UPDATE cheque SET situacao = '$situacao', user = '$user' WHERE id_cheque = '$idCheque' ";
					$exe_up = mysql_query($sql_up, $base)or die (mysql_error());
					$rows_affected = mysql_affected_rows();
					if($rows_affected){
						$sql_ins = "INSERT INTO conta_bancaria_lanc (idcontabancaria,dtlancamentoconta,valorlancamento,tipolancamento,historico,
									user,host,statuslancamento,idcheque)
									VALUES('$conta', NOW(), '$valor', '1', 'Dep. Cheque $num_cheque', '$user', '$host', 'IND', '$idCheque' )";
						$exe_ins = mysql_query($sql_ins, $base);
						if($rows_affected){
							echo "{success:true, response: 'Operacion Realizada con Exito' }"; 
						}
					}
					else{
						echo "{success:true, response: 'Cheque ya se encuentra DEPOSITADO '}"; 
					}
				}
				else{
					echo "{success:true, response: 'Cuenta con Moneda Diferente'}"; 
				}
			}
			else{
				echo "{success:true, response: 'Informe Cuenta para Deposito'}"; 
			}
		}
////////////////////////////////////////////////////
		if($situacao == 'COMPENSADO'){
			if($statual == 'DEPOSITADO'){
			$sql_up = "UPDATE cheque SET situacao = '$situacao', user = '$user' WHERE id_cheque = '$idCheque' ";
			$exe_up = mysql_query($sql_up, $base);
			$sql_upc = "UPDATE conta_bancaria_lanc SET statuslancamento = 'DISP' WHERE idcheque = '$idCheque' ";
			$exe_upc = mysql_query($sql_upc, $base);
			$rows_affected = mysql_affected_rows();
			if($rows_affected){
				echo "{success:true, response: 'Operacion Realizada con Exito' }"; 
			}
		}
		else{
				echo "{success:true, response: 'Cheque Todavia no DEPOSITADO '}"; 
			}
		}
///////////////////////////////////////////////////////			
///////////////////////////////////////////////////////			
		if($situacao == 'DEVOLVIDO' ){
			if($statual == 'DEPOSITADO'){
					$sql_upc = "UPDATE cheque SET situacao = '$situacao', user = '$user' WHERE id_cheque = '$idCheque' ";
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
			$sql_upc = "UPDATE cheque SET situacao = '$situacao', user = '$user' WHERE id_cheque = '$idCheque' ";
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