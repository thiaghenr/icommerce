<?php
include "../config.php";
conexao();

$acao  = isset($_POST['acao']) ? $_POST['acao'] : '';
$usuario = $_POST['usuario'];
$senha = sha1($_POST['senha']);
$nsenha = sha1($_POST['nsenha']);

if($acao == 'verifica'){
	
		$sql_ver = "SELECT id_usuario,nome,nome_user,senha,usuario FROM usuario WHERE usuario = '$usuario' AND senha = '$senha' ";
		$exe_ver = mysql_query($sql_ver);
		$total = mysql_num_rows($exe_ver);
		$arr = array();
		while($reg_ver = mysql_fetch_array($exe_ver, MYSQL_ASSOC)){
		$arr[] = $reg_ver;
		}
		
		echo json_encode(array('User' => $arr, 'TotalCount' => $total));

}

if($acao == 'AltSenha'){
	if($usuario != ''){
	$sql_upd = "UPDATE usuario SET senha = '$nsenha' WHERE id_usuario = '$usuario' ";
	$exe_upd = mysql_query($sql_upd,$base);
	echo "{success: true,response: 'Alterado'}";
	}
	else{
	echo "{success: true,response: 'Impossivel'}";
	}
}

?>