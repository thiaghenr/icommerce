<?
require_once("verifica_login.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora

$cod = $_GET['id'];
$nom = $_GET['nom'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</script>
<style type="text/css">
<!--
.Estilo2 {
	color: #0000FF;
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


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Catastro Proveedor</title>
<style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<?php

			$sql_prod = "SELECT * FROM proveedor WHERE id = '$cod' ";
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
<body  onload="document.getElementById('cod').focus()">
<table width="54%" height="46%" border="0">

<table width="100%" border="0" bordercolor="#ECE9D8" bgcolor="#FF0000">
    <tr>
      <td height="22"><div align="center" class="Estilo1">Catastro de Proveedores </div></td>
    </tr>
</table>
  <table width="100%" border="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="59%" height="46%" border="0">
  <tr>
    <td height="22" colspan="3" bgcolor="#FFFFFF"><span class="Estilo2">Codigo:
      <?=$reg_prod['id']?>
    </span></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" colspan="3" bgcolor="#CCCCCC"><strong>Proveedor</strong></td>
    <td width="29%" bgcolor="#CCCCCC"><strong>Fecha Catastro</strong></td>
    <td width="35%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="26" colspan="3">
      <label></label><?=$reg_prod['nome']?></td>
    <td><?=$novadata?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="3" bgcolor="#CCCCCC"><strong>Fantasia</strong></td>
    <td height="23" bgcolor="#CCCCCC"><strong>Fecha Ult. Comp.</strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="3" bgcolor="#FFFFFF"><?=$reg_prod['fantasia']?></td>
    <td height="23" bgcolor="#FFFFFF"><?=$reg_prod['dt_ult_compra']?></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="3" bgcolor="#CCCCCC"><strong>Direcci&oacute;n</strong></td>
    <td height="23" bgcolor="#CCCCCC"><strong>Bairro</strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="30" colspan="3"><?=$reg_prod['endereco']?></td>
    <td><?=$reg_prod['bairro']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="10%" height="23" bgcolor="#CCCCCC"><strong>DDD</strong></td>
    <td width="13%" bgcolor="#CCCCCC"><strong>Tel&eacute;fono</strong></td>
    <td width="13%" bgcolor="#CCCCCC"><strong>CEP</strong></td>
    <td bgcolor="#CCCCCC"><strong>Fax</strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23"><?=$reg_prod['ddd']?></td>
    <td height="23"><?=$reg_prod['telefone']?></td>
    <td height="23"><?=$reg_prod['cep']?></td>
    <td><?=$reg_prod['fax']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="3" bgcolor="#CCCCCC"><strong>RUC</strong></td>
    <td bgcolor="#CCCCCC"><strong>Cedula ID </strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="3"><?=$reg_prod['ruc']?></td>
    <td><?=$reg_prod['cedula']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="3" bgcolor="#CCCCCC"><strong>Razao Social </strong></td>
    <td bgcolor="#CCCCCC"><strong>Cidade</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="3"><?=$reg_prod['razao_social']?></td>
    <td><?=$reg_prod['cidade']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="3" bgcolor="#CCCCCC"><strong>CGC</strong></td>
    <td bgcolor="#CCCCCC"><strong>Pais</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="3"><?=$reg_prod['cgc']?></td>
    <td><?=$reg_prod['pais']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="3" bgcolor="#CCCCCC"><strong>Inscricao Estadual </strong></td>
    <td bgcolor="#CCCCCC"><strong>Tipo Prov. </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="3"><?=$reg_prod['insc_est']?></td>
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
      <td width="81%"><?=$reg_prod['contato1']?></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto2</strong></td>
      <td><?=$reg_prod['contato2']?></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto3</strong></td>
      <td><?=$reg_prod['contato3']?></td>
    </tr>
  </table>
  <table width="382" border="0">
  <tr>
    <td width="249" bgcolor="#CCCCCC"><strong>E-mail</strong></td>
    <td width="171" bgcolor="#CCCCCC"><strong>Celular</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><?=$reg_prod['email']?></td>
    <td><?=$reg_prod['celular']?></td>
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
<table width="35%" border="0">
  <tr>
    <td><strong>Alterar outro cadastro </strong></td>
  </tr>
</table>
<table width="38%" border="0">
  <tr>
    <td width="49%" bgcolor="#85C285"><strong>Codigo:</strong></td>
    <td width="51%" bgcolor="#85C285"><strong>Descripcion:</strong></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="result_prov.php">
      <input type="text" name="cod" id="cod" />
    </form></td>
    <td><form id="form2" name="form2" method="post" action="result_prov.php">
      <input type="text" name="nome" id="nome"/>
    </form></td>
  </tr>
</table>
<table width="24%" border="0">
  <tr>
    <td width="31%"><font face="Arial">
      <input name="button2" type="button" onclick="window.close()" value="Cerrar" />
    </font></td>
    <td width="23%">&nbsp;</td>
    <td width="46%"></td>
  </tr>
</table>
<?php

}
?>
  <label></form>


<p>&nbsp;</p>
</body>
</html>
