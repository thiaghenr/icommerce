<?php
require_once("../biblioteca.php");
include "../config.php";
conexao();

$acao  = isset($_POST['acao']) ? $_POST['acao'] : '';


	$nome            = trim($_POST['nome']);
	$email           = strtolower($_POST['email']);
	$salario         = $_POST['salario'];
	$id_cargo        = $_POST['id_cargo'];
	$nascimento = converte_data(2,$_POST['nascimento']);
	$porcentagem     = $_POST['porcentagem'];
	$perfil_id		 = $_POST['perfil_id'];
	$cedula			 = $_POST['cedula'];
	$ruc			 = $_POST['ruc'];
	$login			 = $_POST['login'];
	$exibicao		 = $_POST['exibicao'];
	$senha			 = sha1('123');
	$data_nascimento = implode("-", array_reverse(explode("/", $data_nascimento)));
	$cargoUser		 = $_POST['cargoUser'];
	$idUser			 = $_POST['idUser'];
	$user			 = $_POST['user'];
	$identidade		 = $_POST['identidade'];
	
	$sql_ver = "SELECT nome_user, usuario, id_usuario FROM usuario WHERE usuario = '$login' ";
	$exe_ver = mysql_query($sql_ver, $base);
	$reg_ver = mysql_fetch_array($exe_ver, MYSQL_ASSOC);
	$rowA = mysql_num_rows($exe_ver);
	$id = $reg_ver['id_usuario'];
	
	$sql_verB = "SELECT nome_user, usuario, id_usuario FROM usuario WHERE nome_user = '$exibicao' ";
	$exe_verB = mysql_query($sql_verB, $base);
	$reg_verB = mysql_fetch_array($exe_verB, MYSQL_ASSOC);
	$rowB = mysql_num_rows($exe_verB);
	
	$sql_ver = "SELECT entidadeid FROM usuario WHERE entidadeid = '$identidade' ";
	$exe_ver = mysql_query($sql_ver, $base);
	$rows = mysql_num_rows($exe_ver);

if($acao == 'Novo'){
	
	$sql_ver = "SELECT entidadeid FROM usuario WHERE entidadeid = '$identidade' ";
	$exe_ver = mysql_query($sql_ver, $base);
	$rows = mysql_num_rows($exe_ver);
	if($rows > 0){
	echo "{success:true, response: 'Usuario ja Cadastrado'}";
	exit();
	}
	else{
	
	if($rowA == '0' || $rowB == '0'){
	
	$sql = "INSERT INTO usuario (data_nascimento,salario,id_cargo,ativo,nome_user,usuario,senha,porcentagem,entidadeid)
	VALUES ('$nascimento', '$salario', '$id_cargo', '1', '$exibicao', '$login', '$senha', '$porcentagem', '$identidade')";
	mysql_query($sql) or die (mysql_error());
	$iduser = mysql_insert_id();
	
		$sql_tela = "SELECT * FROM telas_cadastro ";
		$exe_tela = mysql_query($sql_tela);
		while ($reg_tela = mysql_fetch_array($exe_tela, MYSQL_ASSOC)){
	
			$idtela = $reg_tela['idtelas'];
			
			$exe_controle = mysql_query("INSERT INTO telas_controle(telaid,iduser,acessar,alterar,inserir,deletar)
													VALUES('$idtela','$iduser','1','0','0','0')");	
	}
	echo "{success:true, response: 'Cadastrado'}";	
	
	}
	else{
		echo "{success:true, response: 'JaCadastrado'}";
		}
	}
		
} elseif($acao == 'update'){
	$campo          = strtolower($_POST['campo']);
	$valor          = strtolower($_POST['valor']);
	$id_usuario = $_POST['id_usuario'];
	mysql_query("UPDATE usuario SET $campo = '$valor' WHERE id_usuario = $id_usuario");
	echo "{success:true}";
}
if($acao == 'Edita'){
	$sql_verf = "SELECT nome_user, usuario, id_usuario FROM usuario WHERE (usuario = '$login' OR nome_user = '$exibicao') AND id_usuario != '$idUser' ";
	$exe_verf = mysql_query($sql_verf, $base);
	$reg_verf = mysql_fetch_array($exe_verf, MYSQL_ASSOC);
	$rowf = mysql_num_rows($exe_verf);
	$idV = $reg_verf['id_usuario'];
	
	if($idV == $idUser || $rowf == '0'){
	$sql = "UPDATE usuario SET 
								data_nascimento = '$nascimento',
								salario = '$salario',
								id_cargo = '$id_cargo',
								nome_user = UCASE('$exibicao'),
								usuario = UCASE('$login'),
								porcentagem = '$porcentagem' 
								WHERE id_usuario = '$idUser' ";
	$exe = mysql_query($sql, $base);
	echo "{success:true, response: 'SalvoSucesso'}";
	}
	else{
		echo "{success:true, response: 'NaoSucesso'}";
		}
		


}

?>