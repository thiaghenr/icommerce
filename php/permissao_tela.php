<?
//require_once("verifica_login.php");
include "../config.php";
conexao();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>

<?

	$sql_usu = "SELECT id_usuario FROM usuario ";
	$exe_usu = mysql_query($sql_usu);
	while ($reg_usu = mysql_fetch_array($exe_usu, MYSQL_ASSOC)){
	
	$iduser = $reg_usu['id_usuario'];
	
		$exe_telas = mysql_query("SELECT idtelas FROM telas_cadastro");
		while ($reg_telas = mysql_fetch_array($exe_telas, MYSQL_ASSOC)){
	
		$idtela = $reg_telas['idtelas'];
		
			$exe_controle = mysql_query("INSERT INTO telas_controle(telaid,iduser,acessar,alterar,inserir,deletar)
											VALUES('$idtela','$iduser','1','0','0','0')");
	}

}

?>

</body>
</html>
