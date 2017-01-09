<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pesquiza de Facturas - <? echo $cabecalho; ?></title>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF;
	font-weight: bold;
}
.Estilo4 {font-size: 12px}
.Estilo5 {font-size: 36px;
	font-weight: bold;
}
.Estilo6 {color: #FFFFFF}
.Estilo7 {
	font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
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
</head>

<body>
<p align="center" class="Estilo5"><? echo $cabecalho; ?> </p>
<p align="center" class="Estilo5">&nbsp;	</p>
<p>&nbsp;</p>
<table border="0" width="100%">
  <tr>
    <td width="7%" bgcolor="#85C285"><span class="Estilo7">N. Venda </span></td>
    <td width="8%" bgcolor="#85C285"><span class="Estilo6"><strong>N. Pedido </strong></span></td>
    <td width="8%" bgcolor="#85C285"><span class="Estilo6"><strong>N. Form. </strong></span></td>
    <td width="30%" bgcolor="#85C285"><span class="Estilo6"><strong>Cliente</strong></span></td>
    <td width="7%" bgcolor="#85C285"><strong><span class="Estilo6">Vendedor<strong></strong></span></strong></td>
    <td width="9%" bgcolor="#85C285"><span class="Estilo6"><strong>Data</strong></span></td>
    <td width="9%" bgcolor="#85C285"><span class="Estilo6"><strong>IVA %</strong></span></td>
	<td width="9%" bgcolor="#85C285"><span class="Estilo6"><strong>Total</strong></span></td>
  </tr>


  <?
	$idv = $_POST['id'];
	$ped = $_POST['ped'];
	$nom = $_POST['nom']; 
?>




<?
	
	if ($_GET['acao'] == "ide") {
	if(!empty($idv)){

	$sql_lista = "SELECT v.*, c.* FROM venda v, clientes c WHERE v.id = $idv AND v.controle_cli = c.controle";
	$exe_lista = mysql_query($sql_lista, $base) or die (mysql_error() .'-'.$sql_lista); 
	$num_lista = mysql_num_rows($exe_lista);
	}
	
	else if(!empty($nom)){
	
	$sql_lista = "SELECT v.*, c.* FROM venda v, clientes c WHERE v.controle_cli = c.controle AND c.nome LIKE '%$nom%' ";
	$exe_lista = mysql_query($sql_lista, $base) or die (mysql_error() .'-'.$sql_lista); 
	$num_lista = mysql_num_rows($exe_lista);
	}
	
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
			$data2 = $reg_lista['data_venda'];
			$hora2 = $reg_lista['data_venda'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
//	$sql_listas = "SELECT * FROM pedido WHERE id = '".$reg_lista[pedido_id]."' ";
//	$exe_listas = mysql_query($sql_listas, $base);
//	$num_listas = mysql_num_rows($exe_listas);
	
	//		while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)) {
	
	
	
		
			?>

  <tr>
    <td width="7%" bgcolor="#CCCCCC"><?=$reg_lista['id']?></td>
	<td width="8%" bgcolor="#CCCCCC"><?=$reg_lista['pedido_id']?></td>
    <td width="8%" bgcolor="#CCCCCC">&nbsp;</td>
    <td width="30%" bgcolor="#CCCCCC"><?=$reg_lista['nome']?></td>
    <td width="7%" bgcolor="#CCCCCC">&nbsp;</td>
    <td width="9%" bgcolor="#CCCCCC"><?=$novadata?></td>
    <td width="9%" bgcolor="#CCCCCC">&nbsp;</td>
    <td width="9%" bgcolor="#CCCCCC"><?=guarani($reg_lista['valor_venda'])?></td>
    <td width="13%" bgcolor="#FFFFFF"><a href="vis_itens_venda.php?acao=vis&ide=<?=$reg_lista['id']?>"><img src="images/lupa.gif" width="12" height="14" border="0"/></a></td> 
  </tr>
 
 
  <?
  }
  }
  //}
//}
		//	}
	echo '<p>Ventas Encontradas: '.$num_lista.'</p>';
	?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>

<hr width="100%" size="14" noshade="noshade" />
<ul>
  <li>
    <div align="center" class="Estilo4">BRSoft </div>
  </li>
  <li>
    <div align="center" class="Estilo4">Todos los Derechos Reservados </div>
  </li>
</ul>
<p>&nbsp;</p>
<p></p>
</body>
</html>
