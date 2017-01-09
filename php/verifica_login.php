<?php

require_once("../config.php");
conexao();
include("JSON.php");
require_once("../verifica_login.php");

$usuario = $_SESSION['id_usuario'];

	$sql = "SELECT u.id_usuario, t.tela, tc.acessar,tc.alterar,tc.inserir,tc.deletar FROM
			usuario u, telas_cadastro t, telas_controle tc WHERE u.id_usuario = '$usuario'
			AND u.id_usuario = tc.iduser
			AND tc.telaid = t.idtelas GROUP BY t.tela,tc.telaid  ";
	$exe = mysql_query($sql, $base);
	
	$arr = array();
	while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){
	  $arr[$reg['tela']] = array('acessar' => $reg['acessar']);
	}
	
	echo json_encode($arr);
//$arr[$reg[tela]] = array($reg[ler]);

// create a JSON service
/*
$json = new Services_JSON();

$Usuario = array();

 $responce->Usuario[0]['id_usuario']= $_SESSION['id_usuario'];
 $responce->Usuario[0]['usuario']= $_SESSION['usuario'];
 $responce->Usuario[0]['perfil_id']= $_SESSION['perfil_id'];
 $responce->Usuario[0]['nome_user']= $_SESSION['nome_user'];
 $responce->Usuario[0]['host']= $_SERVER['REMOTE_ADDR'];
	
echo $json->encode($responce);	
*/
		
?>
	
	
	