<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Relatorio de Produtos Vendidos no Periodo</title>

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
<link href="css/clearbox.css" rel="stylesheet" type="text/css" />
<script src="js/clearbox.js" type="text/javascript"></script>

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
.style3 {
	color: #333333;
	font-weight: bold;
}
.barra  {  
background: #666 url('/images/barra.jpg') no-repeat center center;	
	
}
.style6 {color: #FFFFFF}
.style7 {color: #000000}
</style>



</head>

<body>
<table width="100%">  
    <tr>
	  <td class="barra"><div align="center" class="style1 style6">Produtos Vendidos no Periodo</div></td>
	</tr>
</table>
<p>&nbsp;</p>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="1" bordercolor="#FFFF00">
    <tr>
      <td colspan="2" class="calendar_today style3">Relatorio de Produtos Vendidos no perido:
        </td>
    </tr>
    <tr>
      <td width="21%" height="48" class="calendar_today">Data Inicial:      
      <input type="text" id="data_ini" name="data_ini" value='<?=$_POST['data_ini']?>' /></td>
      <td width="21%" class="calendar_today">Data Final:
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
<table width="98%" border="1">
  <tr>
    <td width="17%" height="17" class="calendar_inline"><span class="style3">Codigo</span></td>
    <td width="37%" class="calendar_inline"><div align="center"><span class="style3">Descricao</span></div></td>
    <td width="15%" class="calendar_inline"><div align="center"><span class="style3">Data</span></div></td>
    <td width="13%" class="calendar_inline"><div align="center" class="style7"><strong>Estoque</strong></div></td>
    <td width="12%" class="calendar_inline"><div align="center" class="style5 style7"><strong>Qt. Vendida</strong></div></td>
    <td width="6%" class="calendar_inline style4">&nbsp;</td>
  </tr>
</table>
<div id="atualiza" style="overflow-x: scroll; height:430px; overflow:auto; overflow-y: scroll;">
  <table width="98%" border="1">
    <? 
	if (empty ($_POST['data_ini'])) { $dt_ini = $data; }
	else { $dt_ini = converte_data('2',$_POST['data_ini']);}
    
	if (empty ($_POST['data_fim'])) { $dt_fim = $data; }
	else { $dt_fim = converte_data('2',$_POST['data_fim']); }
	
	
	if (!empty ($dt_ini) && !empty ($dt_fim) ) {
	
	
		$sql_venda = "SELECT v.*, p.Estoque, it.id_venda,referencia_prod,descricao_prod,sum(qtd_produto) AS total FROM venda v, itens_venda it, produtos p WHERE v.id = it.id_venda AND v.data_venda BETWEEN '$dt_ini' AND '$dt_fim' AND it.referencia_prod = p.Codigo GROUP BY it.referencia_prod order by p.Estoque asc   ";
		$exe_venda = mysql_query($sql_venda);
		while ($reg_venda = mysql_fetch_array($exe_venda, MYSQL_ASSOC)) { 
		
		$data2 = $reg_venda['data_venda'];
		$hora2 = $reg_venda['data_venda'];
		//Formatando data e hora para formatos Brasileiros.
		$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
		$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
		
		$total += $reg_venda['prvenda'];		
		
?>
    <tr>
      <td width="17%" height="18" class="calendar_inline"><?=$reg_venda['referencia_prod']?>
        &nbsp;</td>
      <td width="37%" class="calendar_inline"><div align="left">
        <?=$reg_venda['descricao_prod']?>
      </div></td>
      <td width="15%" class="calendar_inline"><div align="center">
        <?=$novadata ?>
      </div></td>
      <td width="13%" class="calendar_inline"><div align="center">
        <?=$reg_venda['Estoque']?>
      </div>
      <div align="center"></div></td>
      <td width="12%" class="calendar_inline">
        <div align="center">
          <?=$reg_venda['total']?>
          </div>
      <div align="center"></div></td>
      <td width="6%" class="calendar_inline"></td>
    </tr>
    <? }} ?>
  </table>
</div>
<table width="98%" border="1">
  <tr>
    <td width="87%" class="calendar_inline"><div align="center" class="style5">
      <div align="right">:</div>
    </div></td>
    <td width="13%" class="calendar_inline style4"><div align="right"></div></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
