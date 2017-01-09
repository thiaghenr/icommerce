<?
require_once("verifica_login.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$mes= date("m");


?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pesquiza Cotizaciones - <? echo $title ?></title>
<style type="text/css">
<style type="text/css">
	
	.style { 
	border: 1px solid #D8E1EF;
	}
	.Estilo4 {font-size: 12px}
	
	body {
	color: #006;
	padding:3px 0px 3px 8px;
	background-color: #EBEADE;
	border-width:2px;
	border-style:solid;
	border-color:#a2bfe9;
	}
	.Estilo16 {
	color: #000000;
	font-weight: bold;
	font-family: "Courier New", Courier, monospace;
}
.Estilo17 {
	color: #0000FF;
	font-weight: bold;
}
.Estilo18 {
	color: #FFFFFF;
	font-weight: bold;
}
</style>
<script language="javascript">
function edita(){
		document.getElementById('frmItens').action = 'pesquiza_cot.php?acao=edita';
		document.getElementById('frmItens').submit();
	}
</script>
</head>

<body  onload="document.getElementById('ped').focus()">
<p align="center" class="Estilo5 Estilo2">&nbsp;</p>
<table width="80%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#FF0000"><div align="center" class="Estilo1">
      <p>Pesquiza Produtos </p>
    </div></td>
  </tr>
</table>
<pre><strong>Pesquizar Por</strong>:</pre>
<table width="80%" border="0">
  <tr>
    <td width="19%" bgcolor="#ECE9D8"><strong>N. Cotizacion: </strong></td>
    <td width="34%" bgcolor="#ECE9D8"><strong>Nombre del Cliente: </strong></td>
    <td width="13%" bgcolor="#ECE9D8">&nbsp;</td>
    <td width="34%" bgcolor="#ECE9D8">&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="id" method="post" action="result_cotacao.php">
      <label>
      <input type="text" name="ped" />
      </label>
    </form>    </td>
    <td><form id="form2" name="nome_cli" method="POST" action="result_cotacao.php">
      <label>
        <input type="text" size="40" name="nom" />
        </label>
    </form>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="0" width="87%">
  <tr>
    <td width="8%" bgcolor="#ECE9D8"><strong>id</strong></td>
    <td width="18%" bgcolor="#ECE9D8"><strong>Codigo</strong></td>
    <td width="41%" bgcolor="#ECE9D8"><strong>Descricao</strong></td>
    <td width="11%" bgcolor="#ECE9D8"><strong>custo</strong></td>
  </tr>
  <?
	
			
	$sql_lista = "SELECT * FROM produtos4 "; //where Descricao = '' ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
			$data2 = $reg_lista['data_car'];
			$hora2 = $reg_lista['data_car'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			/*
			$id = $reg_lista['id'];
			$codigo = $reg_lista['Codigo'];
			$descricao = mysql_escape_string($reg_lista['Descricao']);
			
			$sql_per = "UPDATE produtos SET Descricao= '$descricao' where Codigo = '".$reg_lista['Codigo']."'  ";
			$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
			
			*/
			
			
			?>
  <tr>
    <td width="8%" bgcolor="#FFCCFF"><?=$reg_lista['id']?></td>
    <td width="18%" bgcolor="#FFCCFF"><?=$reg_lista['Codigo']?></td>
    <td width="41%" bgcolor="#FFCCFF"><?=$reg_lista['Descricao']?></td>
    <td width="11%" bgcolor="#FFCCFF"><?=$reg_lista['custo']?></td>
  </tr>
  <?
			}
	echo '<p>Produtos encontrados: '.$num_lista.'</p>';
	
			
	
	
	?>
</table>
<form action="entrada_produtos.php?acao=edita" method="post" name="frmItens" id='frmItens'/>

<p>&nbsp;</p>
<p>&nbsp;</p>
<hr width="100%" size="14" noshade="noshade" />
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()" value="Cerrar" />
</font></p>
</body>
</html>
