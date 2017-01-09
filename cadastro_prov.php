<?
require_once("verifica_login.php");
include "config.php";
conexao();
$tela = cadastro_prov;



$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cadastro Proveedor - <? echo $title ?></title>
<style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
</head>
<body  onload="document.getElementById('nome').focus()">
<table width="54%" height="46%" border="0">
<form id="acesso" name="acesso" action="cadastro_prov.php?acao=cadastra" onSubmit="return false" method="post">
<table width="100%" border="0" bordercolor="#ECE9D8" bgcolor="#FF0000">
    <tr>
      <td height="22"><div align="center" class="Estilo1">Registro Proveedor </div></td>
    </tr>
  </table>
  <table width="100%" border="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="59%" height="46%" border="0">
  <tr>
    <td height="22" colspan="2" bgcolor="#CCCCCC"><strong>Proveedor</strong></td>
    <td width="31%" bgcolor="#CCCCCC"><strong>Fecha Catastro</strong></td>
    <td width="5%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="26" colspan="2">
      <label></label>
    <input type="text" size="50" name="nome" value="<?=$_POST['nome']?>" /></td>
    <td><input type="text" size="15" readonly="" name="data_cad" value="<?=$_POST['data_cad']?>"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="2" bgcolor="#CCCCCC"><strong>Direcci&oacute;n</strong></td>
    <td bgcolor="#CCCCCC"><strong>Fecha Ult. Comp.</strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2"><input type="text" size="50" name="endereco" value="<?=$_POST['endereco']?>" /></td>
    <td><input type="text" size="15" readonly="" name="dt_ult_compra" value="<?=$_POST['dt_ult_compra']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="17%" height="23" bgcolor="#CCCCCC"><strong>DDD</strong></td>
    <td width="47%" bgcolor="#CCCCCC"><strong>Tel&eacute;fono</strong></td>
    <td bgcolor="#CCCCCC"><strong>Fax</strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23"><input type="text" size="15" readonly="" name="data_cad2" value="<?=$_POST['ddd']?>"/></td>
    <td height="23"><input type="text" size="30" name="telefone" value="<?=$_POST['telefone']?>"/></td>
    <td><input type="text" size="20" name="fax" value="<?=$_POST['fax']?>"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="2" bgcolor="#CCCCCC"><strong>RUC</strong></td>
    <td bgcolor="#CCCCCC"><strong>Cedula ID </strong></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2"><input type="text" size="30" name="ruc" value="<?=$_POST['ruc']?>"/></td>
    <td><input type="text" size="20" name="cedula" value="<?=$_POST['cedula']?>"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2" bgcolor="#CCCCCC"><strong>Razao Social </strong></td>
    <td bgcolor="#CCCCCC"><strong>Cidade</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2"><input type="text" size="50" name="razao_social" value="<?=$_POST['razao_social']?>" /></td>
    <td><input type="text" size="30" name="cidade" value="<?=$_POST['cidade']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2" bgcolor="#CCCCCC"><strong>CGC</strong></td>
    <td bgcolor="#CCCCCC"><strong>Pais</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2"><input type="text" size="50" name="cgc" value="<?=$_POST['cgc']?>"/></td>
    <td><input type="text" size="30" name="pais" value="<?=$_POST['pais']?>"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2" bgcolor="#CCCCCC"><strong>Inscricao Estadual </strong></td>
    <td bgcolor="#CCCCCC"><strong>Tipo Prov. </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="23" colspan="2"><input type="text" size="50" name="insc_est" value="<?=$_POST['inst_est']?>" /></td>
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
      <td width="81%"><input type="text" size="50" name="contato1" value="<?=$_POST['contato1']?>"/></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto2</strong></td>
      <td><input type="text" size="50" name="contato2" value="<?=$_POST['contato2']?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>Contacto3</strong></td>
      <td><input type="text" size="50" name="contato3" value="<?=$_POST['contato3']?>" /></td>
    </tr>
  </table>
  <table width="382" border="0">
  <tr>
    <td width="249" bgcolor="#CCCCCC"><strong>E-mail</strong></td>
    <td width="171" bgcolor="#CCCCCC"><strong>Celular</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><input type="text" size="40" name="email" value="<?=$_POST['email']?>"/></td>
    <td><input type="text" size="20" name="celular" value="<?=$_POST['celular']?>"/></td>
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
      <textarea name="obs" id="obs" cols="60" rows="3"> <?=$_POST['obs']?> </textarea>
      </label>
      </td>
  </tr>
</table>
  <label>
  <input type="button" name="Submit" onclick="this.form.submit()" value="Gravar" />
  <font face="Arial">
  <input name="button" type="button" onclick="window.close()" value="Cerrar" />
  </font>
</form>
<?

	if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "cadastra") {
	
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
	
	
	
	
	$re = mysql_query("select count(*) as total from proveedor where cgc = '$cgc' ");
	$total = mysql_result($re, 0, "total");
	
	if ($total == 0) {

		
	$sql_per = "INSERT INTO proveedor (nome,data_cad,endereco,dt_ult_compra,telefone,ddd,fax,ruc,cedula,razao_social,cidade,cgc,pais,insc_est,contato1,contato2,contato3,email,celular,obs) 
VALUES(UCASE('$nome'),NOW(),UCASE('$endereco'),'$dt_ult_compra',UCASE('$telefone'),UCASE('$ddd'),UCASE('$fax'),UCASE('$ruc'),UCASE('$cedula'),UCASE('$razao_social'),UCASE('$cidade'),UCASE('$cgc'),UCASE('$pais'),UCASE('$insc_est'),UCASE('$contato1'),UCASE('$contato2'),UCASE('$contato3'),UCASE('$email'),UCASE('$celular'),UCASE('$obs') )";
	$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	
	$codigo = mysql_insert_id();
echo ' O Codigo do Proveedor cadastrado é: '.$codigo.' '; 	
	}
	
	else{

echo "<strong>Proveedor con este CGC ja cadastrado</p>";
echo " </p>\n";
echo " </p>\n";

			}
		}
	}
			
?>

<p>&nbsp;</p>
</body>
</html>
