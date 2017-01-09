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
<title>Cadastro de Entidades  - <? echo $cabecalho; ?></title>
<style type="text/css">
<!--
.Estilo15 {color: #FFFFFF;
	font-weight: bold;
}
.Estilo16 {	font-size: 36px;
	font-weight: bold;
}
-->
</style>
</head>
<form action="cadastro_ent.php?acao=cadastra" onSubmit="return false" method="post">
<body>
<p align="center" class="Estilo16"><? echo $cabecalho; ?> </p>
<p>&nbsp;</p>
<table width="80%" border="0">
  <tr>
    <td bgcolor="#FF0000"><div align="center" class="Estilo15">Cadastro de Entidade - Clientes/Provedores </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="80%" border="0">
  <tr>
    <td width="21%" bgcolor="#CCCCCC"><strong>Entidade de Classe: </strong></td>
    <td width="29%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
  </tr>
  <tr>
    <td>
      <input type="checkbox" name="checkbox" value="checkbox" />
      Provedor
    </td>
    <td>
      <input type="checkbox" name="checkbox2" value="checkbox" />
      Cliente
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="57%" border="0">
  <tr>
    <td width="35%" bgcolor="#CCCCCC"><strong>Codigo:</strong></td>
    <td width="41%" bgcolor="#CCCCCC"><strong>Nombre</strong></td>
    <td width="24%" bgcolor="#CCCCCC"><strong>Tipo:</strong></td>
  </tr>
  <tr>
    <td><input type="text" readonly="" size="15" name="controle" /></td>
    <td><input type="text" size="40" name="nome" /></td>
    <td><select name="tipo">
      <option></option>
      <option>Persona</option>
      <option>Empresa</option>
    </select>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="35%" bgcolor="#CCCCCC"><strong>Razao Social </strong></td>
    <td width="41%" bgcolor="#CCCCCC"><strong>Fantasia:</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="24"><input type="text" size="35" name="razao_social" /></td>
    <td><input type="text" size="35" name="fantasia" /></td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="50%" border="0">
  <tr>
    <td width="180">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="180" bgcolor="#CCCCCC"><strong>Direccion</strong></td>
    <td width="144" bgcolor="#CCCCCC"><p><strong>Ciudad:</strong></p></td>
    <td width="164" bgcolor="#CCCCCC"><strong>Pa&iacute;s</strong></td>
  </tr>
  <tr>
    <td><input type="text" size="30" name="endereco" /></td>
    <td><input type="text" name="cidade" /></td>
    <td><input type="text" name="pais" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<table width="50%" border="0">
  <tr>
    <td width="20%" bgcolor="#CCCCCC"><strong>Telefono1</strong></td>
    <td width="20%" bgcolor="#CCCCCC"><strong>Telefono2</strong></td>
    <td width="22%" bgcolor="#CCCCCC"><strong>Fax:</strong></td>
    <td width="22%" bgcolor="#CCCCCC"><strong>Celular</strong></td>
  </tr>
  <tr>
    <td><input type="text" size="15" name="telefone1" /></td>
    <td><input type="text" size="15" name="telefone2" /></td>
    <td><input type="text" size="15" name="fax" /></td>
    <td><input type="text" size="15" name="celular" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="50%" border="0">
  <tr>
    <td width="29%" bgcolor="#CCCCCC"><strong>RUC</strong></td>
    <td width="25%" bgcolor="#CCCCCC"><strong>Identidad.</strong></td>
    <td width="46%" bgcolor="#CCCCCC"><strong>email:</strong></td>
  </tr>
  <tr>
    <td><input type="text" size="18" name="ruc" /></td>
    <td><input type="text" size="18" name="identidade" /></td>
    <td><input type="text" size="35" name="email" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="42%" border="0">
  <tr>
    <td width="51%" bgcolor="#CCCCCC"><strong>Contato1:</strong></td>
    <td width="49%" bgcolor="#CCCCCC"><strong>Contato2:</strong></td>
  </tr>
  <tr>
    <td><input type="text" size="30" name="contato1" /></td>
    <td><input type="text" size="30" name="contato2" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="50%" border="0">
  <tr>
    <td width="26%" bgcolor="#CCCCCC"><strong>Alterado en: </strong></td>
    <td width="28%" bgcolor="#CCCCCC"><strong>Usu&aacute;rio:</strong></td>
    <td width="46%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text" size="15" readonly="" name="data" /></td>
    <td><input type="text" size="15" readonly="" name="user" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>
  <input type="button" name="Submit" onclick="this.form.submit()" value="Cadastrar" />
  <input type="reset" name="Submit2" value="Limpiar" />
  <font face="Arial">
<input name="button" type="button" onclick="window.close()"
    value="Cerrar" />
</form>
<?

	if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "cadastra") {
	
	$re = mysql_query("select count(*) as total from entidades where ruc = '$ruc'");
	$total = mysql_result($re, 0, "total");
	
	if ($total == 0) {

		
	$sql_per = "INSERT INTO entidades (nome, tipo, razao_social, fantasia, endereco, cidade, pais, telefone1, telefone2, fax, celular, ruc, identidade, email, contato1, contato2, data, user) 
	VALUES('$nome', '$tipo', '$razao_social', '$fantasia', '$endereco', '$cidade', '$pais', '$telefone1', '$telefone2', '$fax', '$celular', '$ruc', '$identidade', '$email', '$contato1', '$contato2', NOW(), '$user'  )";
	$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	
echo "<strong>Cadastro Efectuado com Sucesso !</p>";	
	}
	else{

echo "<strong>Entidade com esse RUC ja cadastrado</p>";
echo " </p>\n";
echo " </p>\n";

}
	
		}
	}
	
		if ($_GET['acao'] == "del") {
		if (isset($_GET['nom_grupo'])) {
			if ($_GET['nom_grupo']) {
				$id_prod = addslashes(htmlentities($_GET['nom_grupo']));
				
	$sql_del = "DELETE FROM grupos WHERE nom_grupo = '$id_prod'   "; 
				$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
				
		}
	}	
	}		
?>
  </font></p>
<p> </p>
<p>&nbsp;</p>
<hr width="100%" size="14" noshade="noshade" />
<ul>
  <li>
    <div align="center" class="Estilo7">Tractopar Repuestos - Ciudad Del Este Km 04 SupeperCarretera, Camino a Hernand&aacute;rias</div>
  </li>
  <li>
    <div align="center" class="Estilo7">Todos los Directos Reservados </div>
  </li>
</ul>
<p></p>
</body>
</html>
