<?php
include "../config.php";
require_once("../biblioteca.php");
conexao();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

if (isset ($_POST['acao'])) {
	if ($_POST['acao'] == "cadastra" && empty($_POST['Codigo']) ) {
	
    $nome = $_POST['nomeprov'];
	$endereco = $_POST['enderecoCad'];
	$telefone = $_POST['telefonecomCad'];
	$fax = $_POST['faxCad'];
	$ruc = $_POST['rucCad'];
	$cedula = $_POST['cedulaCad'];
    $razao_social = $_POST['razaoCad'];
    $cidade = $_POST['cidade'];
	$cgc = $_POST['cgc'];
    $celular = $_POST['celularCad'];
    $email = $_POST['emailCad'];
    $obs = $_POST['obsprovCad'];
	$Codigo = $_POST['Codigo'];  
	$idcidade = $_POST['idcidade'];
	
	if($nome != ""){ 
	
	$sql_per = "INSERT INTO proveedor (nome,data_cad,endereco,telefone,fax,ruc,cedula,razao_social,cidade,cgc,email,celular,obs) 
				VALUES(UCASE('$nome'),NOW(),UCASE('$endereco'),UCASE('$telefone'),UCASE('$fax'),UCASE('$ruc'),UCASE('$cedula'),UCASE('$razao_social'),
				'$idcidade',UCASE('$cgc'),UCASE('$email'),UCASE('$celular'),UCASE('$obs') )";
	$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	
	$cod = mysql_insert_id();
	echo "{success: true,msg: 'O Codigo do Proveedor cadastrado: $cod'}";	
	}
	else{
	  echo "{success: true,msg: 'Informe un nombre para el proveedor'}";
	  
	}
	exit();
	}
	
	if ($_POST['acao'] == "cadastra" && !empty($_POST['Codigo']) ) {
	
		$sql_per = "UPDATE proveedor SET nome=UCASE('$nome') WHERE id = '".$Codigo."' "; 
		$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	
		 echo "{success: true,msg: 'Update Sucesso'}";
	
exit();
}	
}
	
	
	$rs    = mysql_query("SELECT p.id,p.nome,p.ruc,p.endereco,p.telefone,p.email,p.cidade,p.celular,p.cedula,
						p.obs,p.fax,p.razao_social,p.cgc,c.nomecidade FROM proveedor p
						LEFT JOIN cidades c ON c.idcidade = p.cidade 
						ORDER BY p.id DESC ")or die (mysql_error().'-'.$rs);
	$total = mysql_num_rows($rs);
	
	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		
	}
	echo '{"total":"'.$total.'","results":'.json_encode($arr).'}'; 	
	
	

	
?>