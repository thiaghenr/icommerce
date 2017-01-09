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
background-color: #EEEEEE;
}
a:link, a:visited {
color: #00F;
text-decoration: underline overline;
}
a:hover, a:active {
color: #F00;
text-decoration: none;
}
.Estilo3 {color: #FFFFFF}
</style>
<script language='JavaScript'>
function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;
    if((tecla > 47 && tecla < 58)) return true;
    else{
    if (tecla != 8) return false;
    else return true;
    }
}
</script>



</head>
<form id="acesso" name="acesso" action="cadastro_cli.php?acao=cadastra" onSubmit="return false" method="post">
<body onload="document.getElementById('nome').focus()">
<table width="54%" height="46%" border="0">
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
    <td bgcolor="#CCCCCC"><strong>Abrev.</strong></td>
    <td bgcolor="#EEEEEE">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" bgcolor="#CCCCCC"><input type="text" size="50" name="nome" value="<?=$_POST['nome']?>"/></td>
    <td bgcolor="#FFFFFF"><input type="text" size="20" name="abrv" value="<?=$_POST['abrv']?>"/></td>
    <td bgcolor="#EEEEEE">&nbsp;</td>
  </tr>
  <tr>
    <td width="36%" height="20" bgcolor="#CCCCCC"><strong>Razao Social </strong></td>
    <td width="15%" bgcolor="#EEEEEE"></td>
    <td width="49%" bgcolor="#EEEEEE"></td>
  </tr>
  <tr bgcolor="#EEEEEE">
    <td height="24"><input type="text" size="50" name="razao_social" value="<?=$_POST['razao_social']?>" /></td>
      <label>     
    <td><span class="Estilo3"></span></td>
    <td><span class="Estilo3"></span></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#CCCCCC"><strong>Direcci&oacute;n</strong></td>
    <td bgcolor="#EEEEEE"></td>
    <td bgcolor="#EEEEEE"><span class="Estilo3"></span></td>
  </tr>
  <tr bgcolor="#EEEEEE">
    <td height="23"><input type="text" size="50" name="endereco" value="<?=$_POST['endereco']?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="20" bgcolor="#CCCCCC"><strong>Tel&eacute;fono</strong></td>
    <td bgcolor="#CCCCCC"><strong>Fax</strong></td>
    <td bgcolor="#CCCCCC"><strong>Celular</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23"><input type="text" size="30" name="telefonecom"  value="<?=$_POST['telefonecom']?>"/></td>
    <td><input type="text" size="20" name="fax" value="<?=$_POST['fax']?>"/></td>
    <td><input type="text" size="20" name="celular" value="<?=$_POST['celular']?>"/></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#CCCCCC"><strong>RUC</strong></td>
    <td bgcolor="#CCCCCC"><strong>C&eacute;dula ID. </strong></td>
    <td bgcolor="#CCCCCC"><strong>Limite</strong></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#CCCCCC"><input type="text" size="30" name="ruc" value="<?=$_POST['ruc']?>"/></td>
    <td bgcolor="#CCCCCC"><input type="text" size="20" name="cedula" value="<?=$_POST['cedula']?>"/></td>
    <td bgcolor="#CCCCCC"><input type="text" size="20" name="limite" value="<?=$_POST['limite']?>"/></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#CCCCCC"><strong>FRETE A COBRAR (%)</strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr bgcolor="#EEEEEE">
    <td height="24"><input type="text" size="5" name="frete" value="<?=$_POST['frete']?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="55%" border="0">
    <tr>
      <td width="11%" bgcolor="#CCCCCC"><strong>Contacto1</strong></td>
      <td width="56%"><input type="text" size="50" name="contato1" value="<?=$_POST['contato1']?>" /></td>
      <td width="11%">&nbsp; </td>
      <td width="22%" bgcolor="#EEEEEE">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto2</strong></td>
      <td><input type="text" size="50" name="contato2" value="<?=$_POST['contato2']?>" /></td>
      <td>&nbsp; </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto3</strong></td>
      <td><input type="text" size="50" name="contato3" value="<?=$_POST['contato3']?>"/></td>
      <td>&nbsp; </td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="382" border="0">
  <tr>
    <td width="249" bgcolor="#CCCCCC"><strong>E-mail</strong></td>
    <td width="171" bgcolor="#EEEEEE">&nbsp;</td>
  </tr>
  <tr bgcolor="#EEEEEE">
    <td><input type="text" size="40" name="email" value="<?=$_POST['email']?>" /></td>
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
      <textarea name="obs" id="obs" cols="60" rows="3"> <?=$_POST['obs']?> </textarea>
      </label>
    </td>
  </tr>
</table>
  <label>
 <input type="button" name="Submit" onClick="this.form.submit()" value="Gravar" />
 <font face="Arial">
 <input name="button" type="button" onclick="window.close()" value="Cerrar" />
 </font>
 </form>

<?

	if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "cadastra") {
	
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
	
	
	
	
	$re = mysql_query("select count(*) as total from clientes where ruc = '$ruc' OR cedula = '$cedula' ");
	$total = mysql_result($re, 0, "total");
	
	if ($total == 0) {

		
	$sql_per = "INSERT INTO clientes (nome,abrv,razao_social,data,dt_ult_compra,endereco,telefonecom,fax,celular,ruc,cedula,limite,contato1,contato2,contato3,email,obs,frete) 
VALUES(UCASE('$nome'),UCASE('$abrv'),UCASE('$razao_social'),NOW(),'$dt_ult_compra',UCASE('$endereco'),UCASE('$telefonecom'),UCASE('$fax'),UCASE('$celular'),UCASE('$ruc'),UCASE('$cedula'),UCASE('$limite'),UCASE('$contato1'),UCASE('$contato2'),UCASE('$contato3'),UCASE('$email'),UCASE('$obs'), '$frete' )";
	$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	
	$codigo = mysql_insert_id();
echo ' O Codigo do cliente cadastrado é: '.$codigo.' '; 	
	}
	
	else{

echo "<strong>Ciente con este RUC ou Cedula ja cadastrado</p>";
echo " </p>\n";
echo " </p>\n";

			}
		}
	}
			
?>


<p align="center">
<p align="center"><hr width="100%" size="14" noshade="noshade" />
<p align="center">BRSoft - Todos los Derechos Reservados </p>
<p>&nbsp;</p>
</body>
</html>
