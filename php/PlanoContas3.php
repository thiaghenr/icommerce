<?php
require_once("../biblioteca.php");
include "../config.php";
conexao();
include_once("json/JSON.php");
$json = new Services_JSON();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


$acao = $_POST['acao'];
$node = $_POST['node'];
if($acao == "despesa"){
// $subsql = "AND p.idplanocontas != '1'";
}


/*
	$sql = "SELECT p.plancodigo,p.plancodigopai,p.plandescricao,
			p.plancodigopai AS grupoconta,
			p1.plancodigopai
			FROM planocontas p
			INNER JOIN planocontas p1
			ON (p1.plancodigopai = p.plancodigo
			)
			WHERE 1=1 
			";


*/

if(isset($node)){
if($node == "root"){
$node = 0;

$sql = "SELECT p.plancodigo,p.plancodigopai,p.plandescricao,p.idplanocontas
			FROM planocontas p 
			WHERE 1=1 
			AND p.plancodigopai = '$node' $subsql
			GROUP BY p.plancodigopai,p.plancodigo";			
			
			$exe = mysql_query($sql, $base)or die(mysql_error());
	
			$pai = $reg['plancodigopai'];
			$filho = $reg['plancodigo'];
					
	$arr = array();
	while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){

	$arr[] = array('id'=>$reg['idplanocontas'], 'nodeID'=>$reg['idplanocontas'], 'pnodeID'=>$reg['plancodigopai'], 'leaf'=>false,
					'text'=>$reg['plandescricao'],'cod'=>$reg['plancodigo']);
		}
	
	
	echo ''.json_encode($arr).''; 

}

if($node != "root"){

			$sql = "SELECT p.plancodigo,p.plancodigopai,p.plandescricao,p.idplanocontas
			FROM planocontas p 
			WHERE 1=1 
			AND p.idplanocontas = '$node'
			GROUP BY p.plancodigopai,p.plancodigo";			
			$exe = mysql_query($sql, $base)or die(mysql_error());
			$reg = mysql_fetch_array($exe, MYSQL_ASSOC);
			
			$pai = $reg['plancodigopai'];
			$filho = $reg['plancodigo'];
						
			$sql = "SELECT p.plancodigo,p.plancodigopai,p.plandescricao,p.idplanocontas,plantipo
			FROM planocontas p 
			WHERE 1=1 
			AND p.plancodigopai = '$filho'
			ORDER BY p.plancodigo";
			$exe = mysql_query($sql, $base)or die(mysql_error());
	
	$arr = array();
	while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){
	
	if($reg['plantipo'] == 'A'){
		$leaf = true;
	}
	if($reg['plantipo'] == 'S'){
		$leaf = false;
	}
	
	$text = '<b>'.$reg['plancodigo']."</b> - ".$reg['plandescricao'];

	$arr[] = array('id'=>$reg['idplanocontas'], 'nodeID'=>$reg['idplanocontas'], 'pnodeID'=>$reg['plancodigopai'], 'leaf'=>$leaf,
					'text'=>$text, 'cod'=>$reg['plancodigo'],'desc'=>$reg['plandescricao']);
		}
	
	
	echo ''.json_encode($arr).''; 

	}

}


if($acao  == "ListarContas"){ 
$idplano = $_POST['idplano'];

	$sql = "SELECT p.plancodigo,p.plancodigopai,p.plandescricao,p.idplanocontas
			FROM planocontas p 
			WHERE 1=1 
			AND p.idplanocontas = '$idplano'
			GROUP BY p.plancodigopai,p.plancodigo";			
			$exe = mysql_query($sql, $base)or die(mysql_error());
			$reg = mysql_fetch_array($exe, MYSQL_ASSOC);
			
			$pai = $reg['plancodigopai'];
			$filho = $reg['plancodigo'];
						
			$sql = "SELECT p.plancodigo,p.plancodigopai,p.plandescricao,p.idplanocontas,p.plantipo,
			sum(lc.valor) AS valor
			FROM planocontas p, lancamento_caixa lc
			WHERE 1=1 
			AND p.idplanocontas = lc.contaid AND p.idplanocontas = $idplano
			ORDER BY p.plancodigo";
			$exe = mysql_query($sql, $base)or die(mysql_error());
	
	$arr = array();
	while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){
	
	if($reg['plantipo'] == 'A'){
		$plantipo = "Analitico";
	}
	if($reg['plantipo'] == 'S'){
		$plantipo = "Sintetico";
	}
	
	$arr[] = array('idplanocontas'=>$reg['idplanocontas'], 'plancodigo'=>$reg['plancodigo'], 'plandescricao'=>$reg['plandescricao'], 
					'plantipo'=>$plantipo,	'saldo'=>$reg['valor']);
		}
	
	echo '({"Conta":'.json_encode($arr).'})'; 
}

if($acao  == "CadPlan"){
$user = $_POST['user'];
$tipo = $_POST['tipo'];
$idpai = $_POST['idpai'];
$desc = $_POST['NomePlan'];
$codplan = $_POST['codplan'];

if($tipo == "s"){
$tipo = "A";
}
if($tipo == "n"){
$tipo = "S";
}
	
	$sqla = "SELECT p.plancodigo,p.plantipo
			FROM planocontas p 
			WHERE 1=1 
			AND p.idplanocontas = '$idpai' ";			
	$exea = mysql_query($sqla, $base)or die(mysql_error());
	$rega = mysql_fetch_array($exea, MYSQL_ASSOC);
			
			$pai = $rega['plancodigo'];
			$filho = $rega['plancodigo'];
			$plantipo = $rega['plantipo'];
		
	if($plantipo == "S"){
	$sql = "INSERT INTO planocontas (plancodigo,plancodigopai,plandescricao,plantipo,plandatacad,planreceita,planuseralt)
					VALUES('$codplan', '$pai', '$desc', '$tipo', NOW(), '1', '$user'  )		";			
	$exe = mysql_query($sql, $base)or die(mysql_error());
	if(mysql_affected_rows())
	echo "{success: true, response: 'Operacao realizada com sucesso'}";
	}
	else{
	echo "{success: true, response: ' Esta conta solamente lanzamientos'}";
	}

	
}

if($acao  == "Eliminar"){
$idplan = $_POST['idplan'];
$cod = $_POST['cod'];

	$sqla = "SELECT p.plancodigo,p.plantipo
			FROM planocontas p 
			WHERE 1=1 
			AND p.plancodigopai = '$cod' ";			
	$exea = mysql_query($sqla, $base)or die(mysql_error());
	$rows = mysql_num_rows($exea);
	if($rows > 0){
	echo "{success: true, response: 'Cuentas Filhos Existentes'}";
	exit();
	}
	else{

	$sql = "DELETE FROM planocontas WHERE idplanocontas = '$idplan' ";
	$exe = mysql_query($sql, $base);
	if(mysql_affected_rows()){
	echo "{success: true, response: 'Operacao realizada com sucesso'}";
	}
	else{
	echo "{success: true, response: 'Nao foi possivel'}";
	}
}
}

if($acao  == "EditPlan"){
$NomePlan = $_POST['NomePlan'];
$contapai = $_POST['contapai'];
$codplan = $_POST['codplan'];
$tipo = $_POST['tipo'];
$user = $_POST['user'];
$idplan = $_POST['idplan'];
if($tipo == "s"){
$tipo = "A";
}
if($tipo == "n"){
$tipo = "S";
}
	

	$sql = "UPDATE planocontas SET plancodigo='$codplan', plancodigopai='$contapai', plandescricao='$NomePlan',
			plantipo='$tipo' WHERE idplanocontas = '$idplan' ";
	$exe = mysql_query($sql, $base);
	if(mysql_affected_rows()){
	echo "{success: true, response: 'Operacao realizada com sucesso'}";
}

}

?>