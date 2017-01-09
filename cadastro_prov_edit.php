<?
require_once("verifica_login.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora

$idp = $_GET['id'];
$nom = $_GET['nom'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo $cabecalho; ?></title>
<style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo2 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style>
<?php

			$sql_prod = "SELECT * FROM proveedor WHERE id = '$idp' ";
			$exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
			$num_prod = mysql_num_rows($exe_prod);
				while ($reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC)) {
		
		

			$data2 = $reg_prod['data_cad'];
			$hora2 = $reg_prod['data_cad'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
?>



</head>
<body  onload="document.getElementById('nome').focus()">
<table width="54%" height="46%" border="0">
<form id="acesso" name="acesso" action="cadastro_prov_edit.php?acao=alterar" onSubmit="return false" method="post">
<input type="hidden" size="35"  name="id" value="<?=$reg_prod['id']?>" />
<table width="100%" border="0" bordercolor="#ECE9D8" bgcolor="#FF0000">
    <tr>
      <td height="22"><div align="center" class="Estilo1">Registro Proveedor </div></td>
    </tr>
  </table>
  <table width="100%" border="0">
    <tr>
      <td><span class="Estilo2">Codigo</span>: <? echo $idp;?></td>
    </tr>
  </table>
  <table width="59%" height="46%" border="0">
  <tr>
    <td height="22" colspan="2" bgcolor="#CCCCCC"><strong>Proveedor</strong></td>
    <td width="31%" bgcolor="#CCCCCC"><strong>Fecha Catastro</strong></td>
    <td width="6%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="26" colspan="2">
      <label></label>
    <input type="text" size="50" name="nome" value="<?=$reg_prod['nome']?>" /></td>
    <td><input type="text" size="15" readonly="" name="data_cad" value="<?=$novadata?>"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="2" bgcolor="#CCCCCC"><strong>Direcci&oacute;n</strong></td>
    <td bgcolor="#CCCCCC"><strong>Fecha Ult. Comp.</strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2"><input type="text" size="50" name="endereco" value="<?=$reg_prod['endereco']?>" /></td>
    <td><input type="text" size="15" readonly="" name="dt_ult_compra" value="<?=$reg_prod['dt_ult_compra']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="18%" height="23" bgcolor="#CCCCCC"><strong>DDD</strong></td>
    <td width="45%" bgcolor="#CCCCCC"><strong>Tel&eacute;fono</strong></td>
    <td bgcolor="#CCCCCC"><strong>Fax</strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23"><input type="text" size="10" name="fax2" value="<?=$reg_prod['ddd']?>"/></td>
    <td height="23"><input type="text" size="20" name="telefone" value="<?=$reg_prod['telefone']?>"/></td>
    <td><input type="text" size="20" name="fax" value="<?=$reg_prod['fax']?>"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="2" bgcolor="#CCCCCC"><strong>RUC</strong></td>
    <td bgcolor="#CCCCCC"><strong>Cedula ID </strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2"><input type="text" size="30" name="ruc" value="<?=$reg_prod['ruc']?>"/></td>
    <td><input type="text" size="20" name="cedula" value="<?=$reg_prod['cedula']?>"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2" bgcolor="#CCCCCC"><strong>Razao Social </strong></td>
    <td bgcolor="#CCCCCC"><strong>Cidade</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2"><input type="text" size="50" name="razao_social" value="<?=$reg_prod['razao_social']?>" /></td>
    <td><input type="text" size="30" name="cidade" value="<?=$reg_prod['cidade']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2" bgcolor="#CCCCCC"><strong>CGC</strong></td>
    <td bgcolor="#CCCCCC"><strong>Pais</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2"><input type="text" size="50" name="cgc" value="<?=$reg_prod['cgc']?>"/></td>
    <td><input type="text" size="30" name="pais" value="<?=$reg_prod['pais']?>"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2" bgcolor="#CCCCCC"><strong>Inscricao Estadual </strong></td>
    <td bgcolor="#CCCCCC"><strong>Tipo Prov. </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2"><input type="text" size="50" name="insc_est" value="<?=$reg_prod['insc_est']?>" /></td>
    <td><input name="radiobutton" type="radio" value="radiobutton" />
Local
  <input name="radiobutton" type="radio" value="radiobutton" />
Exter..</td>
    <td><label></label></td>
  </tr>
</table>
  <table width="40%" border="0">
    <tr>
      <td width="19%" bgcolor="#CCCCCC"><strong>Contacto1</strong></td>
      <td width="81%"><input type="text" size="50" name="contato1" value="<?=$reg_prod['contato1']?>"/></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto2</strong></td>
      <td><input type="text" size="50" name="contato2" value="<?=$reg_prod['contato2']?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto3</strong></td>
      <td><input type="text" size="50" name="contato3" value="<?=$reg_prod['contato3']?>" /></td>
    </tr>
  </table>
  <table width="382" border="0">
  <tr>
    <td width="249" bgcolor="#CCCCCC"><strong>E-mail</strong></td>
    <td width="171" bgcolor="#CCCCCC"><strong>Celular</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><input type="text" size="40" name="email" value="<?=$reg_prod['email']?>"/></td>
    <td><input type="text" size="20" name="celular" value="<?=$reg_prod['celular']?>"/></td>
  </tr>
</table>
<table width="102" border="0">
  <tr>
    <td bgcolor="#CCCCCC"><strong>Observaciones</strong></td>
  </tr>
</table>
<table width="383" border="0">
  <tr>
    <td width="161" height="72" bgcolor="#FFFFFF">
      <label>
      <textarea name="obs" id="obs" cols="60" rows="3"> <?=$reg_prod['obs']?> </textarea>
      </label>
      </td>
  </tr>
</table>
<?php
}
?>
  <label>
  <input type="button" name="Submit" onclick="this.form.submit()" value="Gravar" />
  <font face="Arial">
  <input name="button" type="button" onclick="window.close()" value="Cerrar" />
  </font>
</form>
<?

	
	if ($_GET['acao'] == "alterar") {
	
	$id = $_POST['id'];
    $nome = $_POST['nome'];
	$data_cad = $_POST['data_cad'];
	$endereco = $_POST['endereco'];
	$dt_ult_compra = $_POST['dt_ult_compra'];
	$telefone = $_POST['telefone'];
	$ddd = $_POST['ddd'];
	$fax = $_POST['fax'];
	$ruc = $_POST['ruc'];
	$cedula = $_POST['cedula'];
    $razao_social = $_POST['razao_social'];
    $cidade = $_POST['cidade'];
	$cgc = $_POST['cgc'];
    $pais = $_POST['pais'];
    $celular = $_POST['insc_est'];
    $contato1 = $_POST['contato1'];
    $contato2 = $_POST['contato2'];
    $contato3 = $_POST['contato3'];
    $email = $_POST['email'];
    $obs = $_POST['obs'];
	$id = $_POST['id'];
	
	echo $id;
	
	$sql_per = "UPDATE proveedor SET nome=UCASE('$nome'), razao_social=UCASE('$razao_social'), endereco=UCASE('$endereco'), telefone=UCASE('$telefone'), ddd=UCASE('$ddd'), fax=UCASE('$fax'), celular=UCASE('$celular'), ruc=UCASE('$ruc'), cgc=UCASE('$cgc'), insc_est=UCASE('$insc_est'), cidade=UCASE('$cidade'), pais=UCASE('$pais'), cedula=UCASE('$cedula'), contato1=UCASE('$contato1'), contato2=UCASE('$contato2'), contato3=UCASE('$contato3'), email=UCASE('$email'), obs=UCASE('$obs')  WHERE id = '".$id."'  ";
	$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	
	
	echo 'Alteração efetuada com sucesso';

   echo "<script language='javaScript'>window.location.href='alterar_prov_ok.php?idp=$id'</script>";
	
	}
						
?>

<p>&nbsp;</p>
</body>
</html>
