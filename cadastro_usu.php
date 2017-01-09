<?
require_once("verifica_login.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
//$usuario = $user ;
$nome_user = $_SESSION['nome_user'] ;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registro de usuario do sistema - <? echo $title ?></title>
<style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style1 {
	color: #000000;
	font-weight: bold;
}
-->
</style>
</head>
<body  onload="document.getElementById('nome_user').focus()">
<table width="54%" height="46%" border="0">
<form action="cadastro_usu.php?acao=cadastra" onSubmit="return false" method="post">
  <p>&nbsp;</p>
  <table width="100%" border="0" bordercolor="#ECE9D8" bgcolor="#FF0000">
    <tr>
      <td height="21"><div align="center" class="Estilo1">Registro Usuarios </div></td>
    </tr>
  </table>
  <table width="100%" border="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p><? echo $nome_user ?>&nbsp;</p>
  <table width="37%" border="0">
    <tr>
      <td width="53%"  bgcolor="#CCCCCC"><span class="style1">Identificacao no Sistema:</span></td>
      <td width="47%"  bgcolor="#CCCCCC"><input type="text" size="20" name="nome_user" id="nome_user"/></td>
    </tr>
  </table>
  <table width="30%" border="0">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="59%" height="46%" border="0">
  <tr>
    <td height="21" bgcolor="#CCCCCC"><strong>Login:</strong>
      <input type="text" size="20" name="usuario" /></td>
    <td bgcolor="#CCCCCC"><strong>Senha:
      <input type="text" size="20" name="senha" />
    </strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td width="53%" height="22" bgcolor="#CCCCCC"><strong>Nombre</strong></td>
    <td width="38%" bgcolor="#CCCCCC"><strong>Fecha Catastro</strong></td>
    <td width="9%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="26">
      <label></label>
    <input type="text" size="50" name="nome" /></td>
    <td><input type="text" size="15" name="data" value="<?=$data?>" readonly="readonly" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="23" bgcolor="#CCCCCC"><strong>Direcci&oacute;n</strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23"><input type="text" size="50" name="endereco" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="23" bgcolor="#CCCCCC"><strong>Tel&eacute;fono</strong></td>
    <td bgcolor="#CCCCCC"><strong>Celular</strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23"><input type="text" size="30" name="telefone" /></td>
    <td><input type="text" size="20" name="celular" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="21" bgcolor="#CCCCCC"><strong>RUC</strong></td>
    <td bgcolor="#CCCCCC"><strong>C&egrave;dula ID </strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23"><input type="text" size="30" name="ruc" /></td>
    <td><input type="text" size="20" name="cedula" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" bgcolor="#CCCCCC"><strong>Comissao %:</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23"><input type="text" size="20" name="comissao" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
  <table width="382" border="0">
  <tr>
    <td width="249" bgcolor="#CCCCCC"><strong>E-mail</strong></td>
    <td width="171" bgcolor="#FFFFFF"> <label></label></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><input type="text" size="40" name="email" /></td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="102" border="0">
  <tr>
    <td bgcolor="#CCCCCC"><strong>Observaciones</strong></td>
  </tr>
</table>
<table width="383" border="0">
  <tr>
    <td width="377" bgcolor="#FFFFFF">
      <label>
      <textarea name="obs" cols="60" rows="3"></textarea>
      </label>      </td>
  </tr>
</table>
  <label>
  <p>
    <input type="button" name="Submit" onclick="this.form.submit()" value="Cadastrar"/>
    <input name="button" type="button" onclick="window.close()" value="Sair" />
  </p>
</form>


<?

	$comissao = $_POST['comissao'];
	$nome_user = $_POST['nome_user'];
	$usuario = $_POST['usuario'];
	$senha = sha1(stripslashes($_POST['senha']));
	$nome = $_POST['nome'];
	$data = $_POST['data'];
	$endereco = $_POST['endereco'];
	$cedula = $_POST['cedula'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$ruc = $_POST['ruc'];
	$cedula = $_POST['email'];
	$obs = $_POST['obs'];

	if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "cadastra") {
	
	$re = mysql_query("select count(*) as total from usuario where  usuario = '$usuario' OR nome_user = '$nome_user' ");
	$total = mysql_result($re, 0, "total");
	
	if ($total == 0) {

		
	$sql_per = "INSERT INTO usuario (porcentagem, nome_user, usuario, senha, nome, data, endereco, telefone, celular, ruc,  cedula, email, obs ) 
	VALUES('$comissao', '$nome_user', '$usuario', '$senha', '$nome', NOW(), '$endereco', '$telefone', '$celular', '$ruc', '$cedula', '$email', '$obs'  )";
	$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	}
	else{

echo "<strong>Já existe um usuário com essa identificação</p>";
echo " </p>\n";
echo " </p>\n";

}
	
		}
	}

?>

<p>&nbsp;</p>
<p align="center">&nbsp;</p>
</body>
</html>
