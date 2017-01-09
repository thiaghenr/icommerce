<?
require_once("verifica_login.php");
include "config.php";
conexao();
require_once("biblioteca.php");


$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
 $controleCli = $_GET['controleCli'];
?>
<?php
if(!empty($controleCli)){
        $sql = "SELECT * FROM clientes WHERE controle = '$controleCli'" ;
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
<script>
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='';
 }
 else if(lugar=='Nueva'){
  window.location.href='lista_cli.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Visualizar Cadastro - <? echo $cabecalho; ?></title>
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
<form id="acesso" name="acesso" action="alt_cadastro_cli.php?acao=alterar" onSubmit="return false" method="post">
<body>
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
    <td bgcolor="#CCCCCC"><strong>Abrv</strong>.</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" bgcolor="#CCCCCC"><input type="text" readonly="" size="50" id="nome<?=$row['nome']?>" name="nome<?=$row['nome']?>" value="<?=$row['nome']?>"/></td>
    <td bgcolor="#FFFFFF"><input type="text" size="15" readonly="" name="controle2" value="<?=$row['abrv']?>" /></td>
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
      <input type="text" readonly="" size="50" name="razao_social" value="<?=$row['razao_social']?>"/>
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
    <td height="23"><input type="text" readonly="" size="50" name="endereco" value="<?=$row['endereco']?>"/></td>
    <td><input type="text" size="15" readonly="" name="vendedor"  /></td>
    <td><input type="text" size="15" readonly="" name="dat_ult_compra" value="<?=$novadata2?>" /></td>
  </tr>
  <tr>
    <td height="23" bgcolor="#CCCCCC"><strong>Tel&eacute;fono</strong></td>
    <td bgcolor="#CCCCCC"><strong>Fax</strong></td>
    <td bgcolor="#CCCCCC"><strong>Celular</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23"><input type="text" readonly="" size="30" name="telefonecom" value="<?=$row['telefonecom']?>" /></td>
    <td><input type="text" readonly="" size="20" name="fax" value="<?=$row['fax']?>" /></td>
    <td><input type="text" readonly="" size="20" name="celular" value="<?=$row['celular']?>" /></td>
  </tr>
  <tr>
    <td height="21" bgcolor="#CCCCCC"><strong>RUC</strong></td>
    <td bgcolor="#CCCCCC"><strong>C&eacute;dula ID. </strong></td>
    <td bgcolor="#CCCCCC"><strong>Limite</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23"><input type="text" readonly="" size="30" name="ruc" value="<?=$row['ruc']?>" /></td>
    <td><input type="text" readonly="" size="20" name="cedula" value="<?=$row['cedula']?>" /></td>
    <td><input type="text" readonly="" size="20" name="limite" value="<?=$_SESSION['limite']?>" /></td>
  </tr>
</table>
  <table width="55%" border="0">
    <tr>
      <td width="11%" bgcolor="#CCCCCC"><strong>Contacto1</strong></td>
      <td width="45%"><input type="text" readonly="" size="40" name="contato1" value="<?=$row['contato1']?>" /></td>
      <td width="22%" bgcolor="#CCCCCC"><strong>Saldo Devedor  </strong></td>
      <td width="22%" bgcolor="#CCCCCC"><strong>Lim. Disponivel </strong></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto2</strong></td>
      <td><input type="text" readonly="" size="40" name="contato2" value="<?=$row['contato2']?>" /></td>
      <td><input type="text" size="15" readonly="" name="limite_disp2" value="<?=guarani($row['saldo_devedor'])?>" /></td>
      <td><input type="text" size="15" readonly="" name="limite_disp" value="<?=guarani($row['limite_disp'])?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto3</strong></td>
      <td><input type="text" readonly="" size="40" name="contato3" value="<?=$row['contato3']?>" /></td>
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
    <td><input type="text" readonly="" size="40" name="email" value="<?=$row['email']?>"/></td>
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
      </label>
    </td>
  </tr>
</table>
<?php
}
}
?>
  <label>
  <input type="button" value="Volver" name="LINK12" onclick="navegacao('Nueva')" />
  <font face="Arial">
  <input name="button" type="button" onclick="window.close()" value="Abandonar" />
  </font>
  </form>

<?

	
	if ($_GET['acao'] == "alterar") {
	
			
	$sql_per = "UPDATE clientes SET nome='$nome', endereco='$endereco', telefonecom='$telefonecom', fax='$fax', celular='$celular', ruc='$ruc', cedula='$cedula', limite='$limite', contato1='$contato1', contato2='$contato2', contato3='$contato4', obs='$obs'  WHERE controle = '".$_SESSION['controle']."' ";
	$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	}
	

//echo "<strong>Ciente con este RUC ou Cedula ja cadastrado</p>";
//echo " </p>\n";
//echo " </p>\n";


?>


<p align="center">
<p align="center"><hr width="100%" size="14" noshade="noshade" />
<p align="center">BRSoft - Todos los Derechos Reservados </p>
<p>&nbsp;</p>
</body>
</html>
