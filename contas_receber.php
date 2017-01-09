<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();
$tela = contas_receber;
/*
	$sql_tela = "SELECT * FROM telas WHERE tela = '$tela' ";
	$exe_tela = mysql_query($sql_tela);
	$reg_tela = mysql_fetch_array($exe_tela);
	
	$perfil_tela = $reg_tela['perfil_tela'];
	
	if ($perfil_tela < $perfil_id) {
	echo "Acesso nao Autorizado";
	exit;
	}
*/
$data= date("Y-m-d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$mes= date("m");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Contas Receber - <? echo $title ?> </title>
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
.Estilo1 {color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {color: #FFFFFF}
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
.Estilo19 {
	font-size: 12px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo20 {font-size: 12px}
.Estilo22 {font-family: Geneva, Arial, Helvetica, sans-serif}
.Estilo26 {color: #666666; font-size: 12px; font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; }
-->
</style>
</head>

<body>

<table width="100%" border="0">
  <tr>
    <td bgcolor="#OEEAEO"><div align="center" class="Estilo1 Estilo6"><strong>Contas Recibir  </strong></div></td>
  </tr>
</table>
<table width="100%" border="0">
	<tr>
		 <td width="53%" bordercolor="#0EEAE0" bgcolor="#FFFFFF"><p>
		   <?php
	
		$sql_total = "SELECT * FROM contas_receber WHERE status = 'A' "; 
		$exe_total = mysql_query($sql_total, $base);
		while  ($reg_total = mysql_fetch_array($exe_total)){
		
		$total_receber += $reg_total['vl_parcela'];
	
	}
	
	echo "<strong>Total a Receber =</strong>&nbsp; ".guarani($total_receber)." <br>";
	
		$sql_vencido = "SELECT * FROM contas_receber WHERE dt_vencimento < NOW() AND status = 'A' "; 
		$exe_vencido = mysql_query($sql_vencido, $base);
		while  ($reg_vencido = mysql_fetch_array($exe_vencido)){
		
		$total_vencido += $reg_vencido['vl_parcela'];
	
	}	
	
	echo "<strong>Total Vencido &nbsp;&nbsp;&nbsp;=</strong>&nbsp; ".guarani($total_vencido)." <br>";
	
?>
		   </p>
		   <p><img src="images/imp_hp.jpg" width="37" height="33" /> <span class="Estilo20"></span><a href="relatorio_cli_imp.php">Imprimir Vencidos </a></p>
      </td>
  </tr>
</table>

<p>&nbsp;</p>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td width="14%" height="21" bgcolor="#OEEAEO"><span class="Estilo22 Estilo20 Estilo6"><strong>Cod Cliente</strong></span></td>
    <td width="45%" bgcolor="#OEEAEO"><span class="Estilo22 Estilo20 Estilo6"><strong>Cliente</strong></span></td>
    <td width="16%" bgcolor="#OEEAEO"><span class="Estilo22 Estilo20 Estilo6"><strong>Valor Total Devido </strong></span></td>
    <td bgcolor="#OEEAEO"></td>
  </tr>
  
  <?
	
		
	$sql_lista = "SELECT cr.*, cl.nome FROM contas_receber cr, clientes cl WHERE cr.status = 'A' AND cr.clientes_id = cl.controle GROUP BY cr.clientes_id ORDER BY cl.nome ASC "; 
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
			$i=0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {

$sql_listaX = "SELECT *, DATEDIFF(NOW(), dt_vencimento) AS diferenca FROM contas_receber  WHERE clientes_id = '".$reg_lista['clientes_id']."' AND status = 'A' GROUP BY CLIENTES_ID "; 
$exe_listaX = mysql_query($sql_listaX, $base);
$num_listaX = mysql_num_rows($exe_listaX);
while ($reg_listaX = mysql_fetch_array($exe_listaX, MYSQL_ASSOC)) {
			
			if ($i%2==0) 
				$cor = "#33FFFF";
			else 
				$cor = "#FFFFFF";
				
			if ($reg_listaX['diferenca'] >= 0)
				$cor = "#FF0000";	
		
			$data2 = $reg_lista['dt_lancamento'];
			$hora2 = $reg_lista['dt_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$data3 = $reg_lista['dt_vencimento'];
			$hora3 = $reg_lista['dt_vencimento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
			$novahora2 = substr($hora3,11,2) . "h " .substr($hora3,14,2) . " min";
	$i++;		
	
			?>
  <?

	$sql_listas = "SELECT  SUM(vl_parcela) as total FROM contas_receber where clientes_id = '".$reg_lista['clientes_id']."' AND status = 'A'  ";
	$exe_listas = mysql_query($sql_listas, $base);
	$num_listas = mysql_num_rows($exe_listas);
	while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)) {
 
	
?>

   <tr bgcolor="<? echo $cor?>" onmouseover="style.background='#FFDE9F'" onmouseout="style.background='<? echo $cor?>'">
    <td width="14%"><span class="Estilo26">
      <?=$reg_lista['clientes_id']?>
     &nbsp;</span></td>
    <td width="45%"><span class="Estilo26">
      <?=$reg_lista['nome']?>
    </span></td>
    <td width="16%"><span class="Estilo26">
      <?=guarani($reg_listas['total'])?>
     &nbsp;</span></td>
    <td width="11%"><a href="cont_rec_cli.php?acao=vis&cli=<?=$reg_lista['clientes_id']?>" class="Estilo19"><img src="images/lupa.gif" width="12" height="14" border="0"/></a></td>
  </tr>
  <?
  }
  }
  }			
	?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>

<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()" value="Cerrar" />
</font
	  ></p>
<p></p>
</body>
</html>
