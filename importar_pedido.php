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
<title>Importar Pedido - <? echo $cabecalho; ?></title>
<style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo4 {font-size: 12px}
.Estilo5 {
	font-size: 36px;
	font-weight: bold;
}
-->
</style>

<link rel="stylesheet" href="/js/jquery/calendario/calendario.css"/>
<script type="text/javascript" src="/js/jquery/jquery/jquery.js"></script>
<script type="text/javascript" src="/js/jquery/calendario/jquery-calendar.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-numeric.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-floatnumber.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#data_ini").calendar({buttonImage: "images/calendar.gif"});
		$("#data_fim").calendar({buttonImage: "images/visualizar.JPG"});		
	
		$(".numeric").numeric(",");
	    $(".numeric").floatnumber(",",2);
	});	
</script>
<style type="text/css">
<!--
.Estilo6 {color: #FFFFFF}
-->
</style>
<script>
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='\result_pedido.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='\pesquisa_pedido_venda.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>





</head>

<body onload="window.focus()">
<p align="center" class="Estilo5"><? echo $cabecalho; ?></p>
<table width="80%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="80%" border="0">
  <tr>
    <td height="21" bgcolor="#FF0000"><div align="center" class="Estilo1">
      <p>Importar  Pedidos </p>
    </div></td>
  </tr>
</table>
<pre>&nbsp;</pre>
<p>&nbsp;</p>
<table border="0" width="70%">
  <tr>
    <td width="7%" bgcolor="#85C285"><span class="Estilo1">Pedido</span></td>
    <td width="39%" bgcolor="#85C285"><span class="Estilo1">Cliente</span></td>
    <td width="18%" bgcolor="#85C285"><span class="Estilo6"><strong>Tota</strong>l</span></td>
    <td width="20%" bgcolor="#85C285"><span class="Estilo6"><strong>Data</strong></span></td>
    <td width="12%" bgcolor="#85C285"><strong><span class="Estilo6">Vendedor<strong></strong></span></strong></td>
  </tr>
   <?
	$idv = $_POST['id'];
	$ped = $_POST['ped'];
	$nom = $_POST['nom']; 
?>
<?
	
	if ($_GET['acao'] == "ide") {
  
	$sql_lista = "SELECT * FROM pedido WHERE id LIKE '%$idv%'  AND nome_cli LIKE '%$nom%' AND situacao = 'P' ORDER BY data_car ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	}
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
			$data2 = $reg_lista['data_car'];
			$hora2 = $reg_lista['data_car'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			?>
  <tr>
    <td width="7%" bgcolor="#CCCCCC"><?=$reg_lista['id']?></td>
    <td width="39%" bgcolor="#CCCCCC"><?=$reg_lista['nome_cli']?></td>
    <td width="18%" bgcolor="#CCCCCC"><?=$reg_lista['total_nota']?></td>
    <td width="20%" bgcolor="#CCCCCC"><?=$novadata?></td>
    <td width="12%" bgcolor="#CCCCCC">&nbsp;</td>
    <td width="4%" bgcolor="#FFFFFF"><a href="lancar_venda.php?acao=add&ide=<?=$reg_lista['id']?>"><img src="images/lupa.gif" width="12" height="14" border="0"/></a></td>
  </tr>
  <?
  
			}
	echo '<p>Pedidos Efectuados hoy: '.$num_lista.'</p>';
	?>
</table>
<p>&nbsp;</p>
<p>
  <input type="button" value="Nueva pesquiza" name="LINK12" onclick="navegacao('Nueva')" />
</p>
<p>&nbsp;</p>
<hr width="100%" size="14" noshade="noshade" />
<ul>
  <li>
    <div align="center" class="Estilo4">BRSoft - Ciudad Del Este </div>
  </li>
  <li>
    <div align="center" class="Estilo4">Todos los Derechos Reservados </div>
  </li>
</ul>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
