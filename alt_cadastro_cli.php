<?
require_once("verifica_login.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
 $controleCli = $_GET['controleCli'];
?>
<?php
if(!empty($controleCli)){
        $sql = "SELECT * FROM clientes WHERE controle = '$controleCli'" ;
        $rs = mysql_query($sql);
    	$num_reg = mysql_num_rows($rs);
        $row = mysql_fetch_array($rs, MYSQL_ASSOC);
?>
<?php
$data2 = $row['data'];
			$hora2 = $row['data'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
?>
<?php
$data3 = $row['dt_ult_compra'];
			$hora2 = $row['dt_ult_compra'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
			$novahora2 = substr($hora3,11,2) . "h " .substr($hora3,14,2) . " min";
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registro de Clientes - <? echo $cabecalho; ?></title>
<style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo2 {
	font-size: 36px;
	font-weight: bold;
}
-->
</style>
<hr size="1" width="70%">
<style type="text/css">
body {
font-family: "Trebuchet MS", Verdana, Arial;
font-size: 12px;
color: #006;
background-color: #FFF;
}
a:link, a:visited {
color: #00F;
text-decoration: underline overline;
}
a:hover, a:active {
color: #F00;
text-decoration: none;
}
</style>

</head>
<body  onload="document.getElementById('nome').focus()">
<form id="acesso" name="acesso" action="alt_cadastro_cli.php?acao=alterar" onSubmit="return false" method="post">
<table width="54%" height="46%" border="0">
<span class="Estilo2"><? echo $cabecalho; ?></span>

  <table width="100%" border="0" bordercolor="#ECE9D8" bgcolor="#FF0000">
    <tr>
      <td height="21"><div align="center" class="Estilo1">Registro Cliente </div></td>
    </tr>
  </table>
  <table width="100%" border="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="55%" height="46%" border="0">
  <tr>
    <td height="22" bgcolor="#CCCCCC"><strong>Nombre</strong></td>
    <td bgcolor="#CCCCCC">Abrv</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" bgcolor="#CCCCCC"><input type="text" size="50" name="nome" value="<?=$row['nome']?>"/></td>
    <td bgcolor="#FFFFFF"><input type="text" size="20" name="abrv" value="<?=$row['abrv']?>"/></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td width="36%" height="22" bgcolor="#CCCCCC"><strong>Razao Social </strong></td>
    <td width="15%" bgcolor="#CCCCCC"><strong>Fecha Catastro</strong></td>
    <td width="49%" bgcolor="#CCCCCC"><strong>C&oacute;digo</strong>:</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="26">
      <label>
      <input type="text" size="50" name="razao_social" value="<?=$row['razao_social']?>"/>
      </label></td>
    <td><input type="text" size="15" readonly="" name="data" value="<?=$novadata?>" /></td>
    <td><input type="text" size="15" readonly="" name="controle" value="<?=$row['controle']?>" /></td>
  </tr>
  <tr>
    <td height="23" bgcolor="#CCCCCC"><strong>Direcci&oacute;n</strong></td>
    <td bgcolor="#CCCCCC"><strong>Vendedor</strong></td>
    <td bgcolor="#CCCCCC"><strong>Fecha Ult. Comp.</strong> </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23"><input type="text" size="50" name="endereco" value="<?=$row['endereco']?>"/></td>
    <td><input type="text" size="15" readonly="" name="vendedor"  /></td>
    <td><input type="text" size="15" readonly="" name="dat_ult_compra" value="<?=$novadata2?>" /></td>
  </tr>
  <tr>
    <td height="23" bgcolor="#CCCCCC"><strong>Tel&eacute;fono</strong></td>
    <td bgcolor="#CCCCCC"><strong>Fax</strong></td>
    <td bgcolor="#CCCCCC"><strong>Celular</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23"><input type="text" size="30" name="telefonecom" value="<?=$row['telefonecom']?>" /></td>
    <td><input type="text" size="20" name="fax" value="<?=$row['fax']?>" /></td>
    <td><input type="text" size="20" name="celular" value="<?=$row['celular']?>" /></td>
  </tr>
  <tr>
    <td height="21" bgcolor="#CCCCCC"><strong>RUC</strong></td>
    <td bgcolor="#CCCCCC"><strong>C&eacute;dula ID. </strong></td>
    <td bgcolor="#CCCCCC"><strong>Limite</strong></td>
  </tr>
  <tr>
    <td height="21" bgcolor="#CCCCCC"><input type="text" size="30" name="ruc" value="<?=$row['ruc']?>" /></td>
    <td bgcolor="#CCCCCC"><input type="text" size="20" name="cedula" value="<?=$row['cedula']?>" /></td>
    <td bgcolor="#CCCCCC"><input type="text" size="20" name="limite" value="<?=$_SESSION['limite']?>" /></td>
  </tr>
  <tr>
    <td height="21" bgcolor="#CCCCCC"><strong>FRETE A COBRAR (%)</strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23"><input type="text" size="20" name="frete" value="<?=$row['frete']?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
  <table width="55%" border="0">
    <tr>
      <td width="11%" bgcolor="#CCCCCC"><strong>Contacto1</strong></td>
      <td width="56%"><input type="text" size="50" name="contato1" value="<?=$row['contato1']?>" /></td>
      <td width="11%">&nbsp; </td>
      <td width="22%" bgcolor="#CCCCCC"><strong>Lim. Disponivel </strong></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto2</strong></td>
      <td><input type="text" size="50" name="contato2" value="<?=$row['contato2']?>" /></td>
      <td>&nbsp; </td>
      <td><input type="text" size="15" readonly="" name="limite_disp" value="<?=$row['limite_disp']?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto3</strong></td>
      <td><input type="text" size="50" name="contato3" value="<?=$row['contato3']?>" /></td>
      <td>&nbsp; </td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="382" border="0">
  <tr>
    <td width="249" bgcolor="#CCCCCC"><strong>E-mail</strong></td>
    <td width="171" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><input type="text" size="40" name="email" value="<?=$row['email']?>"/></td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="102" border="0">
  <tr>
    <td bgcolor="#CCCCCC"><strong>Observaciones</strong></td>
  </tr>
</table>
<table width="497" border="0">
  <tr>
    <td width="161" bgcolor="#FFFFFF">
      <label>
      <textarea name="obs" id="obs" cols="60" rows="3"><?=$row['obs']?></textarea>
      </label>
    </td>
  </tr>
</table>
<?php
}
?>
  <label>
  <input type="button" name="acesso" onclick="this.form.submit()" value="Gravar" />
  <font face="Arial">
  <input name="button" type="button" onclick="window.close()" value="Abandonar" />
  </font>
  </form>

<?

	
	if ($_GET['acao'] == "alterar") {
    $controle = $_POST['controle'];
	$frete = $_POST['frete'];
    $nome = $_POST['nome'];
	$abrv = $_POST['abrv'];
    $razao_social = $_POST['razao_social'];
    $endereco = $_POST['endereco'];
    $telefonecom = $_POST['telefonecom'];
    $fax = $_POST['fax'];
    $celular = $_POST['celular'];
    $ruc = $_POST['ruc'];
    $cedula = $_POST['cedula'];
    $limite = $_POST['limite'];
    $contato1 = $_POST['contato1'];
    $contato2 = $_POST['contato2'];
    $contato3 = $_POST['contato3'];
    $email = $_POST['email'];
    $obs = $_POST['obs'];

	$sql_per = "UPDATE clientes SET nome=UCASE('$nome'), abrv=UCASE('$abrv'), razao_social=UCASE('$razao_social'), endereco=UCASE('$endereco'), telefonecom=UCASE('$telefonecom'), fax=UCASE('$fax'), celular=UCASE('$celular'), ruc=UCASE('$ruc'), cedula=UCASE('$cedula'), limite='$limite', contato1=UCASE('$contato1'), contato2=UCASE('$contato2'), contato3=UCASE('$contato3'), email=UCASE('$email'), obs=UCASE('$obs'), frete='$frete'  WHERE controle = '".$controle."' ";
	$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);



	echo 'Alteração efetuada com sucesso';

	echo "<script language='javaScript'>window.location.href='alt_cadastro_cli_ok.php?controle=$controle'</script>";

	//}
?>
<?
}
?>
<p align="center">
<p align="center"><hr width="100%" size="14" noshade="noshade" />
<p align="center">BRSoft - Todos los Derechos Reservados </p>
<p>&nbsp;</p>
</body>
</html>
