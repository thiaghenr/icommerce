<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$data= date("Y-m-d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$mes= date("m");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Relatorio de Ventas - <? echo $title ?> </title>
<style type="text/css">
<!--
.Estilo4 {font-size: 12px}
.Estilo5 {font-size: 36px;
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
<link href="css/clearbox.css" rel="stylesheet" type="text/css" />
<script src="js/clearbox.js" type="text/javascript"></script>

<script type="text/javascript">

	$(document).ready(function() {
		$("#data_ini").calendar({buttonImage: "images/calendar.gif"});
		$("#data_fim").calendar({buttonImage: "images/visualizar.JPG"});		
	
		$(".numeric").numeric(",");
	    $(".numeric").floatnumber(",",2);
	});	
</script>
<style type="text/css">
body {
	font: normal 11px auto "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	color: #4f6b72;
	background: #E6EAE9;
}

a {
	color: #c75f3e;
}

#mytable {
	width: 700px;
	padding: 0;
	margin: 0;
}

caption {
	padding: 0 0 5px 0;
	width: 700px;	 
	font: italic 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	text-align: right;
}

th {
	font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	color: #4f6b72;
	border-right: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	border-top: 1px solid #C1DAD7;
	letter-spacing: 2px;
	text-transform: uppercase;
	text-align: left;
	padding: 6px 6px 6px 12px;
	
}

th.nobg {
	border-top: 0;
	border-left: 0;
	border-right: 1px solid #C1DAD7;
	background: none;
}

td {
	border-right: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	background: #fff;
	padding: 6px 6px 6px 12px;
	color: #4f6b72;
}


td.alt {
	background: #F5FAFA;
	color: #797268;
}

th.spec {
	border-left: 1px solid #C1DAD7;
	border-top: 0;
	background: #fff url(../../../../Documents and Settings/Emerson/Desktop/images/bullet1.gif) no-repeat;
	font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
}

th.specalt {
	border-left: 1px solid #C1DAD7;
	border-top: 0;
	background: #f5fafa url(../../../../Documents and Settings/Emerson/Desktop/images/bullet2.gif) no-repeat;
	font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	color: #797268;
}
.Estilo14 {
	color: #000000;
	font-weight: bold;
}
.Estilo15 {color: #000000}
</style></head>

<body  onload="document.getElementById('num_nota').focus()">
<p align="center" class="Estilo5"><? echo $cabecalho ?> </p>
<table width="100%" border="0">
  <tr>
    <td bordercolor="#3399FF" bgcolor="#3399FF"><div align="center" class="Estilo14 Estilo6"><strong>Pesquiza de Ventas </strong></div></td>
  </tr>
</table>
<pre><strong>Pesquizar Por</strong>:</pre>
<form id="formid" action="vis_vendas.php" method="post">
<table width="100%" border="0">
  <tr>
    <td width="19%" bgcolor="#3399FF"><p class="Estilo14">N. Nota: </p></td>
    <td width="34%" bgcolor="#3399FF"><p class="Estilo6"><strong><span class="Estilo15">Nombre</span> del Cliente:</strong></p></td>
    <td width="22%" bgcolor="#3399FF"><p class="Estilo6"><strong>N. <span class="Estilo15">Formulario</span>: </strong></p></td>
    <td width="12%" bgcolor="#3399FF"><p class="Estilo15"><strong>Data:</strong></p></td>
    <td width="13%" bgcolor="#E6EAE9"><p>&nbsp;</p></td>
  </tr>
  <tr>
    <td height="37" bgcolor="#3399FF">
      <p>
        <label>
        <input type="text" name="num_nota" id="num_nota"/>
        </label>
      </p>
   </td>
    <td bgcolor="#3399FF">
      <p>
        <label>
          <input type="text" size="40" name="nome" id="nome"/>
        </label>
      </p>
   </td>
    <td bgcolor="#3399FF">
      <p>
        <input type="text" name="textfield" />
      </p>
    </td>
    <td bgcolor="#3399FF">
      <p>
        <input type="text" size="9" name="data_ini" id="data_ini"   />
      </p>
    </td>
    <td bgcolor="#3399FF">
      <div align="right">
        <p>
          <input type="submit" name="Submit" value="Buscar" />
        </p>
      </div>
    </td>
  </tr>
</table> </form> 
<p>&nbsp;</p>
<table border="0" width="100%">
  <tr>
    <td width="9%" bgcolor="#ECE9D8" class="selected"><span class="Estilo10">N. Venda </span></td>
    <td width="10%" bgcolor="#ECE9D8" class="selected"><span class="Estilo10">N. Pedido </span></td>
    <td width="39%" bgcolor="#ECE9D8" class="selected"><span class="odd Estilo4">Cliente</span></td>
    <td width="12%" bgcolor="#ECE9D8" class="selected"><span class="Estilo10">Vendedor</span></td>
    <td width="12%" bgcolor="#ECE9D8" class="selected"><span class="Estilo10">Data</span></td>
    <td width="11%" bgcolor="#ECE9D8" class="selected"><div align="right" class="Estilo10">Total</div></td>
  </tr>
  <?
  if (empty ($_POST['num_nota']) && empty ($_POST['data_ini']) && empty ($_POST['nome'])){
  		$sql_lista = "SELECT v.*, c.nome,controle FROM venda v, clientes c WHERE v.controle_cli = c.controle GROUP BY v.id order by v.id desc limit 15  "; 
	$exe_lista = mysql_query($sql_lista, $base);
	}
  
 else if (!empty ($_POST['num_nota'])){
	 $num_nota = $_POST['num_nota'];
	$sql_lista = "SELECT v.*, c.nome,controle FROM venda v, clientes c WHERE v.id = '$num_nota' AND v.controle_cli = c.controle GROUP BY v.id  "; 
	$exe_lista = mysql_query($sql_lista, $base);
	}
	
  else if (!empty ($_POST['nome'])){
	 $nome = $_POST['nome'];
	 $sql_lista = "SELECT v.*, c.nome,controle FROM venda v, clientes c WHERE v.controle_cli = c.controle AND c.nome = '$nome' GROUP BY v.id  "; 
	$exe_lista = mysql_query($sql_lista, $base);
	 }
 
  else if (!empty ($_POST['data_ini'])){
	 $dt_ini = converte_data('2',$_POST['data_ini']);
	 
	  $sql_lista = "SELECT v.*, c.nome,controle FROM venda v, clientes c WHERE v.data_venda LIKE '$dt_ini%' AND v.controle_cli = c.controle GROUP BY v.id  "; 
	$exe_lista = mysql_query($sql_lista, $base);
	 }
	
	
	//$sql_lista = "SELECT * FROM venda WHERE MONTH(data_venda)= '$mes' "; 
	
	
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
			$data2 = $reg_lista['data_venda'];
			$hora2 = $reg_lista['data_venda'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$total_vendas_geral += $reg_lista['valor_venda'] ; 
						

?>
  <tr>
    <td width="9%" height="10" bgcolor="#CCCCCC" class="over"><span class="Estilo4">
      <?=$reg_lista['id']?>
    </span></td>
    <td width="10%" bgcolor="#CCCCCC" class="over"><span class="Estilo4">
      <?=$reg_lista['pedido_id']?>
    </span></td>
    <td width="39%" bgcolor="#CCCCCC" class="over"><span class="Estilo4">
      <?=$reg_lista['nome']?>
    </span></td>
    <td width="12%" bgcolor="#CCCCCC" class="over Estilo4">&nbsp;</td>
    <td width="12%" bgcolor="#CCCCCC" class="over"><span class="Estilo4">
      <?=$novadata?>
    </span></td>
    <td width="11%" bgcolor="#CCCCCC" class="over"><div align="right" class="Estilo4">
      <?=formata($reg_lista['valor_venda'])?>
    </div></td>
    <td width="7%" bgcolor="#4EB6B2" class="over"><a href="vis_itens_venda.php?acao=vis&ide=<?=$reg_listas['id']?>&num=<?=$reg_lista['id']?>"" rel="clearbox(800,600,click)" class="Estilo4"  ><img src="images/lupa.gif" width="12" height="14" border="0"/></a></td>
  </tr>
  <?
	  }
	//}
//}
	
	?>
</table>
<table width="93%" border="0">
  <tr>
    <td width="88%"><div align="right"><strong>Total General: </strong></div></td>
    <td width="12%"><div align="right">
      <strong><?=guarani($total_vendas_geral)?></strong>
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>

<ul>
  <li>
    <div align="center" class="Estilo4">BRSoft </div>
  </li>
</ul>


<p></p>
</body>
</html>
