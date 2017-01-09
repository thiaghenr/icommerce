<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();
$mes= date("m");

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pendencias Cliente - <? echo $cabecalho; ?></title>
<style type="text/css">
body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #f2f1e2;
border-width:2px;
border-style:solid;
border-color:#a2bfe9;
}
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo5 {
	font-size: 36px;
	font-weight: bold;
}
.Estilo9 {color: #000000; font-weight: bold; }
-->
</style>
</head>

<body onload="window.focus()">
<p align="center" class="Estilo5"><? echo $cabecalho; ?> </p>
<table width="80%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#OEEAEO"><div align="center" class="Estilo1">
      <p>VERIFICAR PENDENCIAS </p>
    </div></td>
  </tr>
</table>
<pre><strong>Pesquizar Por</strong>:</pre>
<table width="80%" border="0">
  <tr>
    <td width="19%" bgcolor="#CCCCCC"><span class="Estilo9">N. Cotizacion </span></td>
    <td width="34%" bgcolor="#CCCCCC"><span class="Estilo9">Nombre del Cliente: </span></td>
    <td width="13%" bgcolor="#F2F1E2">&nbsp;</td>
    <td width="34%" bgcolor="#F2F1E2">&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="id" method="post" action="result_pedido.php">
      <label>
      <input type="text" name="ped" />
      </label>
    </form>    </td>
    <td><form id="form2" name="nome_cli" method="POST" action="result_pedido.php">
      <label>
        <input type="text" size="40" name="nom" />
        </label>
    </form>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td width="38%"><div align="right">Lista Geral de Produtos Pendentes: </div></td>
    <td width="62%"><a href="pendencias_geral.php"><img src="images/lista_geral.gif" width="48" height="48" /></a></td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="0" width="86%">
  <tr>
    <td width="12%" bgcolor="#CCCCCC"><strong>Pedido</strong></td>
    <td width="11%" bgcolor="#CCCCCC"><strong>Cod. Cliente </strong></td>
    <td width="44%" bgcolor="#CCCCCC"><strong>Cliente</strong></td>
    <td width="13%" bgcolor="#CCCCCC"><div align="right"><strong>Data</strong></div></td>
  </tr>
  <?
	
		
	//$sql_lista = "SELECT  id, nome_cli, total_nota, data_car, vendedor FROM pedido"; 
	$sql_lista = "SELECT p.*, c.controle,nome FROM pendencias p, clientes c WHERE p.clientes_controle = c.controle  ORDER BY p.data ASC "; // WHERE MONTH(data_car) = '$mes' ORDER BY data_car ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
			$data2 = $reg_lista['data'];
			$hora2 = $reg_lista['data'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			
			?>
  <tr>
    <td width="12%" bgcolor="#CCFFFF"><?=$reg_lista['cotacao_id']?></td>
    <td width="11%" height="21" bgcolor="#CCFFFF"><?=$reg_lista['controle']?></td>
    <td width="44%" bgcolor="#CCFFFF"><?=$reg_lista['nome']?></td>
    <td width="13%" bgcolor="#CCFFFF"><div align="right">
      <?=$novadata?>
    </div></td>
    <td width="20%" bgcolor="#F2F1E2"><a href="vis_pendencias_cli.php?ide=<?=$reg_lista['id']?>"><img src="images/visualizar.bmp" width="12" height="14" border="0"/></a></td>
  </tr>
  <?
			}
	
	?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<hr color="#CCCCCC" width="100%" size="14" noshade="noshade" />
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()"
    value="Cerrar" />
</font></p>
<p>&nbsp;</p>
</body>
</html>
