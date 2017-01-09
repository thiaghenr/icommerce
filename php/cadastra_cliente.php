<?php
require_once("../biblioteca.php");
include "../config.php";
conexao();
header("Content-Type: text/html; charset=iso-8859-1");
 mysql_query("SET NAMES 'utf8'");
 mysql_query('SET character_set_connection=utf8');
 mysql_query('SET character_set_client=utf8');
 mysql_query('SET character_set_results=utf8');

//$resultado = $_POST["nome"];

	$frete = $_POST['freteCad'];
    $nome = $_POST['nomeCad'];
	$abrv = $_POST['nomeCad'];
    $razao_social = $_POST['razaoCad'];
    $endereco = $_POST['enderecoCad'];
    $telefonecom = $_POST['telefonecomCad'];
    $fax = $_POST['faxCad'];
    $celular = $_POST['celularCad'];
    $ruc = $_POST['rucCad'];
    $cedula = $_POST['cedulaCad'];
    $limite = $_POST['limiteCad'];
    $contato1 = $_POST['contato1Cad'];
    $contato2 = $_POST['contato2Cad'];
    $contato3 = $_POST['contato3Cad'];
    $email = $_POST['emailCad'];
    $obs = $_POST['obscliCad'];
	$idcidade = $_POST['idcidade'];
	$datnasc = converte_data('2',$_POST['datnasc']);
	
	
	
	
	$re = mysql_query("select count(*) as total from entidades where ruc = '$ruc' ");
	$total = mysql_result($re, 0, "total");
	
	if ($total == 0) {

		
	$sql_per = "INSERT INTO entidades (nome,fantasia,data,endereco,telefone1,fax,celular,ruc,cedula,lim_credito,email,obs,cidade,datnasc) 
				VALUES(UCASE('$nome'),UCASE('$abrv'),NOW(),UCASE('$endereco'),UCASE('$telefonecom'),UCASE('$fax'),UCASE('$celular'),
				UCASE('$ruc'),UCASE('$cedula'),UCASE('$limite'),UCASE('$email'),UCASE('$obs'), '$idcidade', '$datnasc' )";
	$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	
	$codigo = mysql_insert_id();
echo "{success: true,msg: 'O Codigo do cliente e: $codigo'}";
	}
	
	else{

//echo "<strong>Ciente con este RUC ou Cedula ja cadastrado</p>";
echo "{failure: true,msg: 'Cliente com esse RUC ja cadastrado!'}";

}


?>