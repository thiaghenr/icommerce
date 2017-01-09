<?
require_once("verifica_login.php");
include "config.php";
conexao();
require_once("biblioteca.php");

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
 $controle = $_GET['controle'];
?>
<?php
if(!empty($controle)){
        $sql = "SELECT * FROM clientes WHERE controle = '$controle'" ;
        $rs = mysql_query($sql);
    	$num_reg = mysql_num_rows($rs);
    	
    	   while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
   $_SESSION['controle'] = $row['controle'];
	/*
			$_SESSION['controleCli2'] = $row['controle'];
    		$_SESSION['nome'] = $row['nome'];
			$_SESSION['razao_social'] = $row['razao_social'];
			$_SESSION['data'] = $row['data'];
			$_SESSION['controle'] = $row['controle'];
    		$_SESSION['endereco'] = $row['endereco'];
			$_SESSION['dt_ult_compra'] = $row['dt_ult_compra'];
    		$_SESSION['telefonecom'] = $row['telefonecom'];
			$_SESSION['fax'] = $row['fax'];
			$_SESSION['celular'] = $row['celular'];
			$_SESSION['ruc'] = $row['ruc'];
			$_SESSION['cedula'] = $row['cedula'];
			$_SESSION['limite'] = $row['limite'];
			$_SESSION['limite_disp'] = $row['limite_disp'];
			$_SESSION['contato1'] = $row['contato1'];
			$_SESSION['contato2'] = $row['contato2'];
			$_SESSION['contato3'] = $row['contato3'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['obs'] = $row['obs'];
	*/		
      //  }
   // }
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
<body  onload="document.getElementById('cod').focus()" >
<form name="nome_cli" method="post" action="pesquiza_cli_alt.php">

<table width="100%" border="0" bordercolor="#ECE9D8" bgcolor="#FF0000">
    <tr>
      <td height="21"><div align="center" class="Estilo1">Alteracao Efetuada com Exito </div></td>
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
    <td bgcolor="#CCCCCC"><strong>Abrv.</strong></td>
    <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td> <?=$row['nome']?></td>
    <td bgcolor="#FFFFFF"><?=$row['abrv']?></td>
    <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td width="34%" height="22" bgcolor="#CCCCCC"><strong>Razao Social </strong></td>
    <td width="19%" bgcolor="#CCCCCC"><strong>Fecha Catastro</strong></td>
    <td colspan="2" bgcolor="#CCCCCC"><strong>C&oacute;digo</strong>:</td>
  </tr>
  <tr>
      <td> <?=$row['razao_social']?></td>
      <td> <?=$novadata?> </td>
      <td colspan="2"> <?=$row['controle']?></td>
  </tr>
  <tr>
    <td height="23" bgcolor="#CCCCCC"><strong>Direcci&oacute;n</strong></td>
    <td bgcolor="#CCCCCC"><strong>Vendedor</strong></td>
    <td colspan="2" bgcolor="#CCCCCC"><strong>Fecha Ult. Comp.</strong> </td>
  </tr>
  <tr>
    <td><?=$row['endereco']?></td>
    <td></td>
    <td colspan="2"><?=$novadata2?></td>
  </tr>
  <tr>
    <td height="23" bgcolor="#CCCCCC"><strong>Tel&eacute;fono</strong></td>
    <td bgcolor="#CCCCCC"><strong>Fax</strong></td>
    <td colspan="2" bgcolor="#CCCCCC"><strong>Celular</strong></td>
  </tr>
  <tr>
    <td><?=$row['telefonecom']?></td>
    <td><?=$row['fax']?></td>
    <td colspan="2"><?=$row['celular']?></td>
  </tr>
  <tr>
    <td height="21" bgcolor="#CCCCCC"><strong>RUC</strong></td>
    <td bgcolor="#CCCCCC"><strong>C&eacute;dula ID. </strong></td>
    <td bgcolor="#CCCCCC"><strong>Limite</strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="21" bgcolor="#CCCCCC"><?=$row['ruc']?></td>
    <td bgcolor="#CCCCCC"><?=$row['cedula']?></td>
    <td bgcolor="#CCCCCC"><?=guarani($row['limite'])?></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="21" bgcolor="#CCCCCC"><strong>FRETE A COBRAR</strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td width="25%" bgcolor="#CCCCCC">&nbsp;</td>
    <td width="22%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td><?=($row['frete'])?> %</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
</table>
<table width="55%" border="0">
    <tr>
      <td width="11%" bgcolor="#CCCCCC"><strong>Contacto1</strong></td>
      <td width="42%"><?=$row['contato1']?></td>
      <td width="25%" bgcolor="#CCCCCC"><strong>Saldo Devedor  </strong></td>
      <td width="22%" bgcolor="#CCCCCC"><strong>Lim. Disponivel </strong></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto2</strong></td>
      <td><?=$row['contato2']?></td>
      <td><?=guarani($row['saldo_devedor'])?></td>
      <td><?=guarani($row['limite_disp'])?></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto3</strong></td>
      <td><?=$row['contato3']?></td>
      <td>&nbsp; </td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="382" border="0">
  <tr>
    <td width="249" bgcolor="#CCCCCC"><strong>E-mail:</strong></td>
    <td width="171" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><?=$row['email']?></td>
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
      <textarea name="obs" readonly="readonly" id="obs" value="<?=$row['obs']?>" cols="60" rows="3"></textarea>
      <?php
}
}
?> 
      </label>    </td>
  </tr>
</table>
<table width="35%" border="0">
  <tr>
    <td>Alterar outro cadastro </td>
  </tr>
</table>
<table width="38%" border="0">
  <tr>
    <td width="49%" bgcolor="#85C285"><strong>Codigo:</strong></td>
    <td width="51%" bgcolor="#85C285"><strong>Nombre:</strong></td>
  </tr>
  <tr>
   <td><form id="form1" name="form1" method="post" action="">
     <input type="text" name="cod" /> </td>
   </form>
  
   <td><form id="form2" name="form2" method="post" action="pesquiza_cli_alt.php">
      <input type="text" name="nom" />
    </form>
</td>
  </tr>
</table>
<table width="24%" border="0">
  <tr>
    <td width="31%"><font face="Arial">
      <input name="button" type="button" onclick="window.close()" value="Cerrar" />
    </font></td>
    <td width="23%">&nbsp;</td>
    <td width="46%">
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p></p>
</p>
<p align="center">
<p align="center"><hr width="100%" size="14" noshade="noshade" />
<p align="center">BRSoft - Todos los Derechos Reservados </p>
<p>&nbsp;</p>
</body>
</html>
