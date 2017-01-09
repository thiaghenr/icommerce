<?
require_once("verifica_login.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cadastro de Vendedores</title>
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
</head>
<body>
<table width="54%" height="46%" border="0">
<span class="Estilo2"><? echo $cabecalho ; ?></span>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" bordercolor="#ECE9D8" bgcolor="#FF0000">
    <tr>
      <td height="21"><div align="center" class="Estilo1">Registro Vendedores </div></td>
    </tr>
  </table>
  <table width="100%" border="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="59%" height="19%" border="0">
  <tr>
    <td width="54%" height="26" bgcolor="#CCCCCC"><strong>Nombre</strong></td>
    <td width="21%" bgcolor="#CCCCCC"><strong>Fecha Catastro</strong></td>
    <td width="25%" bgcolor="#CCCCCC"><strong>C&oacute;digo</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="26">
      <label></label>
    <input type="text" size="50" name="textfield32" /></td>
    <td><input type="text" size="15" name="textfield2" /></td>
    <td><input type="text" size="15" name="textfield20" /></td>
  </tr>
</table>
   <table width="59%" border="0">
     <tr>
       <td width="17%" bgcolor="#CCCCCC"><strong>% Comisi&oacute;n </strong></td>
       <td width="43%" bgcolor="#CCCCCC">Tipo Vendedor </td>
       <td width="19%">&nbsp;</td>
       <td width="21%">&nbsp;</td>
     </tr>
     <tr>
       <td><input type="text" size="15" name="textfield222" /></td>
       <td> <label>
         <input name="radiobutton" type="radio" value="radiobutton" />
       </label>
       Balcon 
       <label>
       <input name="radiobutton" type="radio" value="radiobutton" />
       </label>
       Mayorista 
       <label>
       <input name="radiobutton" type="radio" value="radiobutton" />
       </label>
       Exterior  </td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
   </table>
   <p>
   
   <table width="102" border="0">
  <tr>
    <td bgcolor="#CCCCCC"><strong>Observacion</strong></td>
  </tr>
</table>
<table width="383" border="0">
  <tr>
    <td width="377" bgcolor="#FFFFFF">
      <label>
      <textarea name="textarea" cols="60" rows="3"></textarea>
      </label>
      </td>
  </tr>
</table>
  <label>
  <p>
    <input type="button" name="Submit" value="Grabar" />
    <input type="button" name="Submit2" value="Modificar" />
    <input type="button" name="Submit3" value="Eliminar" />
    <input type="button" name="Submit32" value="salir" /> 
  </p>
</form>

<p>&nbsp;</p>
<hr width="100%" size="14" noshade="noshade" />
<p align="center">BRSoft - Todos los Derechos Reservados </p>
</body>
</html>
