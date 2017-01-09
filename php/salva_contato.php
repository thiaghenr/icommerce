<?php
require_once("../biblioteca.php");
mysql_connect("localhost", "root", "vertrigo"); 
mysql_select_db("carcil");

$acao  = isset($_POST['acao']) ? $_POST['acao'] : '';

if($acao == 'NovoContato'){
	$nome            = trim($_POST['nome_contato']);
	$email           = strtolower($_POST['email_contato']);
	$cel            = trim($_POST['cel_contato']);
	$data_nascimento = converte_data('2',$_POST['dt_nascimento_contato']);
	$cedula			 = $_POST['cedula_contato'];
	$ruc			 = $_POST['ruc_contato'];
	
	$clienteid			 = $_POST['clienteid'];
	
	
	//$data_nascimento = implode("-", array_reverse(explode("/", $data_nascimento)));	
	
	$sql = "INSERT INTO contatos (
	nomecontato ,
	celcontato ,
	emailcontato ,
	ruccontato ,
	cedulacontato ,
	clienteid,
	dt_nasc_contato
	)
	VALUES ( '%s', '%s', '%s' , '%s', '%s', '%s', '%d')";
	
	$sql = sprintf($sql, $nome, $cel, $email, $ruc,  $cedula, $clienteid, $data_nascimento );
	
	mysql_query($sql) or die (mysql_error());
	echo "{success:true}";	
} elseif($acao == 'update'){
	$campo          = strtolower($_POST['campo']);
	$valor          = strtolower($_POST['valor']);
	$id_usuario = $_POST['id_usuario'];
	mysql_query("UPDATE usuario SET $campo = '$valor' WHERE id_usuario = $id_usuario") or die (mysql_error());
	echo "{success:true}";
}
?>