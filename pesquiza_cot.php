<?
require_once("verifica_login.php");
require_once("biblioteca.php");
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
<title>Pesquiza Cotizaciones - <? echo $title ?></title>

<link href="css/clearbox.css" rel="stylesheet" type="text/css" />
<script src="js/clearbox.js" type="text/javascript"></script>

<style type="text/css">
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
.Estilo1 {font-size: 14px}
.Estilo2 {font-size: 12px}
.Estilo5 {font-family: Geneva, Arial, Helvetica, sans-serif}
.Estilo13 {font-size: 14px; font-family: Geneva, Arial, Helvetica, sans-serif; color: #666666; }
.Estilo47 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
</style>
<script language="javascript">

 jQuery(document).ready(function($) {
  $('a[rel*=facebox]').facebox()
})

function edita(){
		document.getElementById('frmItens').action = 'pesquiza_cot.php?acao=edita';
		document.getElementById('frmItens').submit();
	}
</script>
</head>

<body  onload="document.getElementById('ped').focus()">
<table width="80%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#CCFF00"><div align="center" class="Estilo1">
      <p><strong>Pesquiza Cotizaciones </strong></p>
    </div></td>
  </tr>
</table>
<pre><strong>Pesquizar Por</strong>:</pre>
<table width="80%" border="0">
  <tr>
    <td width="19%" bgcolor="#OEEAEO"><strong>N. Cotizacion: </strong></td>
    <td width="34%" bgcolor="#OEEAEO"><strong>Nombre del Cliente: </strong></td>
    <td width="13%" bgcolor="#ECE9D8">&nbsp;</td>
    <td width="34%" bgcolor="#ECE9D8">&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="id" method="post" action="pesquiza_cot.php">
      <label>
      <input type="text" name="ped" />
      </label>
    </form>    </td>
    <td><form id="form2" name="nome_cli" method="POST" action="pesquiza_cot.php">
      <label>
        <input type="text" size="40" name="nom" />
        </label>
    </form>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td width="8%" bgcolor="#OEEAEO"><strong>Cotizacion</strong></td>
    <td width="42%" bgcolor="#OEEAEO"><strong>Cliente</strong></td>
    <td width="13%" bgcolor="#OEEAEO"><strong>Total</strong></td>
    <td width="14%" bgcolor="#OEEAEO"><strong>Data</strong></td>
    <td width="15%" bgcolor="#OEEAEO"><strong>Vendedor<strong></strong></strong></td>
    <td width="3%" bgcolor="#OEEAEO"><strong><strong></strong></strong></td>
  </tr>
  <?
	
			
	//$sql_lista = "SELECT  id, nome_cli, total_nota, data_car, vendedor FROM pedido"; 
	$sql_lista = "SELECT * FROM cotacao WHERE id LIKE '%$ped%' AND nome_cli LIKE '%$nom%' ORDER BY id DESC limit 0,30 ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
			$i=0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
			
			if ($i%2==0) 
				$cor = "#FFFFFF";
			else 
				$cor = "#C5D6FC";	
		
		
			$data2 = $reg_lista['data_car'];
			$hora2 = $reg_lista['data_car'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			?>
   <tr bgcolor="<? echo $cor?>">
    <td width="8%"><span class="Estilo13">
      <?=$reg_lista['id']?>
    </span></td>
    <td width="42%"><span class="Estilo13">
      <?=$reg_lista['nome_cli']?>
    </span></td>
    <td width="13%"><span class="Estilo13">
      <?=guarani($reg_lista['total_nota'])?>
    </span></td>
    <td width="14%"><span class="Estilo13">
      <?=$novadata?>
    </span></td>
    <td width="15%"><span class="Estilo13">
      <?=$reg_lista['usuario_id']?>
    </span></td>
    <td width="3%"><a href="vis_cotizacion.php?ide=<?=$reg_lista['id']?>" rel="clearbox(800,600,click)"><img src="images/visualizar.bmp" width="12" height="14" border="0"/></a></td>
    <td width="2%"><a href="cotizacion_edit.php?acao=edita&ide=<?=$reg_lista['id']?>&controleCli=<?=$reg_lista['controle_cli']?>"><img src="images/edit.png" width="12" height="14" border="0"/></a></td>
    <td width="3%"><a href="impressaoc.php?id_cotacao=<?=$reg_lista['id']?>" class="Estilo47"><img src="images/imp.jpg" alt="Imprimir" width="19" height="19" border="0"/></a></td>
  </tr>
  <?
  $i++;
			}
	//echo '<p>Cotizaciones Efectuados hoy: '.$num_lista.'</p>';
	?>
</table>
<form action="entrada_produtos.php?acao=edita" method="post" name="frmItens" id='frmItens'/>

<p>&nbsp;</p>

<hr width="100%" size="14" noshade="noshade" />
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()" value="Cerrar" />
</font></p>
</body>
</html>
