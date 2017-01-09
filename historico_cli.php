<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

//$data= date("d/m/Y"); // captura a data
//$hora= date("H:i:s"); //captura a hora
//$mes= date("m");
//echo  $id_grupo;

//echo $mydate;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Historico de Clientes- <? echo $title ?></title>


<link rel="stylesheet" href="/js/jquery/calendario/calendario.css"/>
<script type="text/javascript" src="/js/jquery/jquery/jquery.js"></script>
<script type="text/javascript" src="/js/jquery/calendario/jquery-calendar.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-numeric.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-floatnumber.js"></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" /> 

<script type="text/javascript">
	$(document).ready(function() {
		$("#data_ini").calendar({buttonImage: "images/calendar.gif"});
		$("#data_fim").calendar({buttonImage: "images/calendar.gif"});		
	
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
	background: #FFFF99;
	color: #797268;
}

td.espc {
	background: #FFFF99;
	color: #797268;
	line-height: 2%;
}

td.spece {
	background: #B1C3D9;
	color: #797268;
	
}

td.lina{
	background: #fff;
	color: #797268;
	line-height: 5pt;
	}

th.spec {
	border-left: 1px solid #C1DAD7;
	border-top: 0;
	background: #fff ;
	font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	line-height: 2%;
}

th.specalt {
	border-left: 1px solid #C1DAD7;
	border-top: 0;
	background: #f5fafa ;
	font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	color: #797268;
	line-height:  5%;
}
.Estilo17 {font-size: 9px}
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
.style3 {
	color: #333333;
	font-weight: bold;
}
.style4 {color: #333333}
.style5 {
	color: #000000;
	font-weight: bold;
}
</style>


</head>
<body>
<table width="100%" border="0">
  <tr>
    <td class="spece"><div align="center" class="style2">HISTORICO DE COMPRAS Y PAGOS DEL CLIENTE</div></td>
  </tr>
</table>

<form id="form1" name="form1" method="post" action="">
  <table width="67%" border="0">
    <tr>
      <td colspan="3" class="calendar_today style3">Buscar Cliente por:
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label></label>
        &nbsp;&nbsp;
        <label>Periodo:</label></td>
    </tr>
    <tr>
      <td width="38%" height="48" class="calendar_today">Nome:
        <input type="text" size="50" id="nome" name="nome" value="<?=$_POST['nome']?>" /></td>
      <td width="19%" class="calendar_today">Data Inicial:
      <input type="text" id="data_ini" name="data_ini" value='<?=$_POST['data_ini']?>' /></td>
      <td width="43%" class="calendar_today">Data Final:
      <input type="text" id="data_fim" name="data_fim" value="<?=$_POST['data_fim']?>"  /></td>
    </tr>
  </table>
  <label> 
  <input type="submit" name="Submit" value="Buscar" />
  <br />
  </label>
  <label><br />
  </label>
</form>
<table width="77%" border="1">
  <tr>
    <td width="17%" class="calendar_inline"><span class="style3">Data</span></td>
    <td width="15%" class="calendar_inline"><div align="center"><span class="style3">Venda</span></div></td>
    <td width="14%" class="calendar_inline"><div align="center"><span class="style3">Pedido</span></div></td>
    <td width="16%" class="calendar_inline"><div align="center"><span class="style3">Boleta</span></div></td>
    <td width="17%" class="calendar_inline"><div align="center" class="style5">Situacao</div></td>
    <td width="14%" class="calendar_inline"><div align="right"><span class="style3">Total</span></div></td>
    <td width="7%" class="calendar_inline style4">&nbsp;</td>
  </tr>
  <? 
	$codigo = $_POST['codigo'];
	$nome = $_POST['nome'];
	$dt_ini = converte_data('2',$_POST['data_ini']);
	$dt_fim = converte_data('2',$_POST['data_fim']);
	
	if (!empty ($nome) && !empty ($dt_ini) && !empty ($dt_fim) ) {
	
		$sql_venda = "SELECT v.*, cl.controle,nome FROM venda v, clientes cl WHERE cl.nome = '$nome' AND cl.controle = v.controle_cli AND v.data_venda BETWEEN '$dt_ini' AND '$dt_fim'     ";
		$exe_venda = mysql_query($sql_venda);
		while ($reg_venda = mysql_fetch_array($exe_venda, MYSQL_ASSOC)) { 
		
		$data2 = $reg_venda['data_venda'];
		$hora2 = $reg_venda['data_venda'];
		//Formatando data e hora para formatos Brasileiros.
		$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
		$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
				
		if ($reg_venda['st_venda'] == "A"){
			$situacao = "Pendente";
			}
		else{
			$situacao = "Quitado";
			}
	
?>
  <tr>
    <td height="18" class="calendar_inline"><?=$novadata?>
      &nbsp;</td>
    <td class="calendar_inline"><div align="center">
      <?=$reg_venda['id']?>
    </div></td>
    <td class="calendar_inline"><div align="center">
      <?=$reg_venda['pedido_id']?>
    </div></td>
    <td class="calendar_inline"><div align="center">
      <?=$reg_venda['num_boleta']?>
    </div></td>
    <td class="calendar_inline"><div align="center">
      <?=$situacao?>
    </div>
    <div align="center"></div></td>
    <td class="calendar_inline"><div align="right">
      <?=guarani($reg_venda['valor_venda'])?>
    </div></td>
    <td class="calendar_inline"></td>
  </tr>
  <? } }?>
</table>

  <script type='text/javascript'>
	
	$("#codigo").autocomplete("pesquisa_codigo.php", {
		width: 260,
		selectFirst: false
	});		
	$("#nome").autocomplete("pesquisa_nome.php", {
		width: 260,
		selectFirst: false
	});		
  </script>
</p>
</body>
</html>
