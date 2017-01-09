<?
require_once("verifica_login.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$mes= date("m");
$nom = $_POST['nom'];
$ped = $_POST['ped'];

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Importar Cotacao - <? echo $title ?></title>
<style type="text/css">
body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #f2f1e2;
border-width:2px;
border-style:solid;
border-color:#a2bfe9;
}
.Estilo1 {color: #CCCCCC}
.Estilo5 {font-weight: bold}
.Estilo6 {
	font-size: 24px;
	font-weight: bold;
}
</style>
</head>

<body  onload="document.getElementById('ped').focus()">
<p align="center" class="Estilo5 Estilo2"><? echo $cabecalho ?></p>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#FF0000"><div align="center" class="Estilo1">
      <p class="Estilo6">Importar Cotacao </p>
    </div></td>
  </tr>
</table>
<pre><strong>Pesquizar Por:</strong></pre>
<table width="80%" border="0">
  <tr>
    <td width="19%" bgcolor="#ECE9D8">N. Cotacao: </td>
    <td width="34%" bgcolor="#ECE9D8">Nombre del Cliente: </td>
    <td width="13%" bgcolor="#F2F1E2">&nbsp;</td>
    <td width="34%" bgcolor="#F2F1E2">&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="id" method="post" action="pesquisa_cot_imp.php">
      <label>
      <input type="text" name="ped" />
      </label>
    </form>    </td>
    <td><form id="form2" name="nome_cli" method="POST" action="pesquisa_cot_imp.php">
      <label>
        <input type="text" size="40" name="nom" />
        </label>
    </form>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table border="0" width="86%">
  <tr>
    <td width="7%" bgcolor="#ECE9D8"><strong>Pedido</strong></td>
    <td width="40%" bgcolor="#ECE9D8"><strong>Cliente</strong></td>
    <td width="17%" bgcolor="#ECE9D8"><strong>Total</strong></td>
    <td width="18%" bgcolor="#ECE9D8"><strong>Data</strong></td>
    <td width="14%" bgcolor="#ECE9D8"><strong>Vendedor<strong></strong></strong></td>
  </tr>
  <?
	
			
	//$sql_lista = "SELECT  id, nome_cli, total_nota, data_car, vendedor FROM pedido"; 
	$sql_lista = "SELECT * FROM cotacao WHERE id LIKE '%$ped%' AND nome_cli LIKE '%$nom%' ORDER BY id DESC limit 0,18 "; // WHERE MONTH(data_car)= '$mes' ORDER BY data_car ";
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
    <td width="7%" bgcolor="#FFCCFF"><?=$reg_lista['id']?></td>
    <td width="40%" bgcolor="#FFCCFF"><?=$reg_lista['nome_cli']?></td>
    <td width="17%" bgcolor="#FFCCFF"><?=$reg_lista['total_nota']?></td>
    <td width="18%" bgcolor="#FFCCFF"><?=$novadata?></td>
    <td width="14%" bgcolor="#FFCCFF"><?=$reg_lista['usuario_id']?></td>
    <td width="2%" bgcolor="#F2F1E2"><a href="/importa_cotacao.php?ide=<?=$reg_lista['id']?>"><img src="images/converter.jpg" width="19" height="18" border="0"/></a></td>
    
  </tr>
  <?
			}
	echo '<p>Ultimas Cotacoes: </p>';
	?>
</table>
<p>&nbsp;</p>
<hr width="100%" size="14" noshade="noshade" />
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()" value="Cerrar" />
</font></p>
</body>
</html>
