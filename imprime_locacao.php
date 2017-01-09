<?
require_once("verifica_login.php");
include "config.php";
conexao();
$mes= date("m");

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Imprimir Locação de Produtos - <? echo $cabecalho; ?></title>
<style type="text/css">
	
	.style { 
	border: 1px solid #D8E1EF;
	}
	
	body {
	color: #006;
	padding:3px 0px 3px 8px;
	background-color: #EBEADE;
	border-width:2px;
	border-style:solid;
	border-color:#a2bfe9;
	}
.Estilo1 {color: #FFFFFF}
.Estilo5 {font-weight: bold}
</style>
</head>

<body onload="document.getElementById('ped').focus()">
<p align="center" class="Estilo5"><? echo $cabecalho; ?></p>
<table width="80%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#FF0000"><div align="center" class="Estilo1">
      <p><strong>Imprimir Locaçao de Produtos </strong></p>
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
    <td><form id="form1" name="id" method="post" action="imprime_locacao.php">
      <label>
      <input type="text" name="ped" />
      </label>
    </form>    </td>
    <td><form id="form2" name="nome_cli" method="POST" action="imprime_locacao.php">
      <label>
        <input type="text" size="40" name="nom" />
        </label>
    </form>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table border="1" bordercolor="#000000" style="border-collapse: collapse" width="100%">
  <tr>
    <td width="8%" bgcolor="#ECE9D8"><strong>Cotizacion</strong></td>
    <td width="50%" bgcolor="#ECE9D8"><strong>Cliente</strong></td>
    <td width="10%" bgcolor="#ECE9D8"><strong>Total</strong></td>
    <td width="11%" bgcolor="#ECE9D8"><strong>Data</strong></td>
    <td width="8%" bgcolor="#ECE9D8"><strong>Situacao</strong></td>
    <td width="9%" bgcolor="#ECE9D8"><strong>Vendedor<strong></strong></strong></td>
  </tr>
  <?
$nom = $_POST['nom'];
$ped = $_POST['ped'];
		

	$sql_lista = "SELECT * FROM cotacao WHERE id LIKE '%$ped%' AND nome_cli LIKE '%$nom%' ORDER BY id DESC limit 0,18 ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
			$data2 = $reg_lista['data_car'];
			$hora2 = $reg_lista['data_car'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			
			?>
  <tr>
    <td width="8%" bgcolor="#E8EEFA"><?=$reg_lista['id']?></td>
    <td width="50%"  bgcolor="#E8EEFA"><?=$reg_lista['nome_cli']?></td>
    <td width="10%"  bgcolor="#E8EEFA"><?=$reg_lista['total_nota']?></td>
    <td width="11%"  bgcolor="#E8EEFA"><?=$novadata?></td>
    <td width="8%"  bgcolor="#E8EEFA"><?=$reg_lista['situacao']?></td>
    <td width="9%"  bgcolor="#E8EEFA">&nbsp;</td>
    <td width="4%" bgcolor="#E8EEFA"><a href="vis_imprime_locacao.php?acao=add&ide=<?=$reg_lista['id']?>"><img src="images/visualizar.bmp" width="12" height="14" border="0"/></a></td>
  </tr>
  <?
			}
	
	?>
</table>
<p>&nbsp;</p>
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()"
    value="Cerrar" />
</font></p>
</body>
</html>
