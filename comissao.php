<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
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
.style6 {color: #4F6B72; font-weight: bold; }
</style>


</head>
<body>
<table width="100%" border="0">
  <tr>
    <td class="spece"><div align="center" class="style2">VENDAS POR VENDEDOR</div></td>
  </tr>
</table>

<form id="form1" name="form1" method="post" action="">
  <table width="67%" border="0">
    <tr>
      <td colspan="3" class="calendar_today style3">Entre com a identificacao do vendedor:
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label></label>
        &nbsp;&nbsp;
        <label>Periodo:</label></td>
    </tr>
    <tr>
      <td width="40%" height="48" class="calendar_today">Identificacao:
        <input type="text" size="50" id="nome" name="nome" value="<?=$_POST['nome']?>" /></td>
      <td width="22%" class="calendar_today">Data Inicial:      
      <input type="text" id="data_ini" name="data_ini" value='<?=$_POST['data_ini']?>' /></td>
      <td width="38%" class="calendar_today">Data Final:
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
    <td width="8%" height="18" class="calendar_inline"><strong>Pedido</strong></td>
    <td width="8%" class="calendar_inline"><div align="center"><strong>Data</strong></div></td>
    <td width="11%" class="calendar_inline"><div align="right"><span class="style3">Valor</span></div></td>
    <td width="15%" class="calendar_inline"><div align="center"><strong>Contas a Receber</strong></div></td>
    <td width="11%" class="calendar_inline"><div align="center" class="style6">Liberado</div></td>
    <td width="3%" class="calendar_inline style4">&nbsp;</td>
  </tr>
</table>
<div id="atualiza" style="overflow-x: scroll; height:450px; overflow:auto; overflow-y: scroll;">
  <table width="98%" border="1">
    <? 
  	if (empty ($_POST['data_ini'])) { $dt_ini = "2008-01-01"; }
	else { $dt_ini = converte_data('2',$_POST['data_ini']);}
    
	if (empty ($_POST['data_fim'])) { $dt_fim = $data; }
	else { $dt_fim = converte_data('2',$_POST['data_fim']); }
	
	//AND v.data_venda BETWEEN '$dt_ini' AND '$dt_fim'
		
	$codigo = $_POST['codigo'];
	$nome = $_POST['nome'];
	
	if (!empty ($nome) && !empty ($dt_ini) && !empty ($dt_fim) ) {
	
		$sql_venda = "SELECT v.*, c.*, p.* FROM venda v, comissao m, itens_venda it WHERE cl.nome = '$nome'  AND v.data_venda BETWEEN '$dt_ini' AND '$dt_fim' AND it.id_venda = v.id AND it.referencia_prod LIKE '%$codigo%' AND v.controle_cli = cl.controle order by it.descricao_prod asc   ";
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
      <td width="8%" height="18" class="calendar_inline"><?=$reg_venda['referencia_prod']?>
        &nbsp;</td>
      <td width="8%" class="calendar_inline"><div align="center"><a href="vis_itens_venda_hist.php?ide=<?=$reg_venda['id']?>"  rel="clearbox(800,600,click)">
        <?=$reg_venda['id']?>
      </a></div></td>
      <td width="11%" class="calendar_inline"> <div align="right"><a href="vis_itens_venda_hist.php?ide=<?=$reg_venda['id']?>"  rel="clearbox(800,600,click)">
        <?=$reg_venda['id']?>
      </a> </div></td>
      <td width="15%" class="calendar_inline"><div align="center">
        <?=$novadata ?>
      </div></td>
      <td width="11%" class="calendar_inline">
        <div align="center">
          <?=guarani($reg_venda['prvenda'])?>
          </div>
        <div align="center"></div></td>
      <td width="3%" class="calendar_inline"></td>
    </tr>
    <? } }?>
  </table>
</div>
<table width="98%" border="1">
  <tr>
    <td width="87%" class="calendar_inline"><div align="center" class="style5">
      <div align="right">Total:</div>
    </div></td>
    <td width="13%" class="calendar_inline style4"><div align="right">
      <?=guarani($total)?>
    </div></td>
  </tr>
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
