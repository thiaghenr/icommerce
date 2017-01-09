<?php
require_once("../biblioteca.php");
include "../config.php";
conexao();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


$query = $_POST['query'];
$acao_nome = $_GET['acao_nome'];
$acao = $_POST['acao'];
$CodCliente = $_POST['CodCliente'];
	
		    $controle = $_POST['controle'];
		    $nome = $_POST['nomecliLista'];
		    $ruc = $_POST['ruccli'];  
		    $fantasia = $_POST['fantasia'];
		    $telefone1 = $_POST['telefone1'];
		    $endereco = $_POST['endereco'];
		    $cedula = $_POST['cedulacli'];
		    $celular = $_POST['celular'];
		    $cidade = $_POST['idcidade'];
		    $email = $_POST['emailcli'];
		    $fax = $_POST['fax'];
		    $limite = $_POST['lim_credito'];
		    $obs = $_POST['obs'];
		    $saldo_devedor = $_POST['saldo_devedor'];
			$ativo = $_POST['ativo'];
			$datnasc = converte_data('2',$_POST['datnasc']);
		
	$sql_update = "UPDATE entidades SET nome = UCASE('$nome'), ruc = '$ruc', telefone1 = '$telefone1', endereco =  UCASE('$endereco'), 
	cedula = '$cedula', celular = '$celular', cidade =  UCASE('$cidade'), email = '$email', fax = '$fax', 
	fantasia = UCASE('$fantasia'), lim_credito = '$limite', obs = '$obs', ativo = '$ativo', datnasc = '$datnasc'
	WHERE controle = '$controle' ";
	$exe_update = mysql_query($sql_update, $base)or die (mysql_error());		
		
		
    echo "{success: true,msg: 'Operaчуo realizada com sucesso'}";
	
	
?>