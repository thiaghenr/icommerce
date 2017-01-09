<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();
//echo $_SESSION['id_usuario'];
$data= date("Y-m-d"); // captura a data
//$hora= date("H:i:s"); //captura a hora
//$mes= date("m");
//echo  $id_grupo;

//echo $mydate;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Relatorio de Lancamentos no Caixa</title>
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

a {
	color: #c75f3e;
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
.style3 {font-size: 12px; font-weight: bold; color: #0000FF; }
.style4 {font-size: 12px}
</style>

</head>

<body>


<p>&nbsp;</p>
<p>&nbsp;</p>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="1" bordercolor="#FFFF00">
    <tr>
      <td colspan="2" class="calendar_today style3">Lancamentos Efetuados no perido: </td>
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

<p>&nbsp;</p>

<table width="90%" border="1">
  <tr>
    <td width="111"><span class="style3">CAIXA USUARIO:</span></td>
  </tr>
  <tr>
    <td height="21"><strong>CAIXA N.</strong></td>
    <td width="179"><strong>DATA LANCAMENTO</strong></td>
    <td width="114"><strong>DESPESA N. </strong></td>
    <td width="110"><strong>VENDA N.</strong></td>
    <td width="216"><strong>CONTAS RECEBER N.</strong></td>
    <td width="135"><strong>VALOR</strong></td>
  </tr>


<p>
  <?php
  
  	if (empty ($_POST['data_ini'])) { $dt_ini = $data; }
	else { $dt_ini = converte_data('2',$_POST['data_ini']);}
    
	if (empty ($_POST['data_fim'])) { $dt_fim = $data; }
	else { $dt_fim = converte_data('2',$_POST['data_fim']); }
	
	//lcb.dt_lancamento BETWEEN '$dt_ini' AND '$dt_fim' AND cb.usuario_id = '".$_SESSION['id_usuario']."'
	if (!empty ($dt_ini) && !empty ($dt_fim) ) {
  

	$sql_venda = "SELECT l.*, c.*, cl.nome,controle, cr.venda_id AS venda,cr.id AS idcr FROM lancamento_caixa_balcao l, caixa_balcao c,  clientes cl, contas_receber cr WHERE c.st_caixa = 'A' AND c.usuario_id = '$id_usuario' AND c.id = l.caixa_id AND  l.dt_lancamento BETWEEN '$dt_ini' AND '$dt_fim' AND c.usuario_id = '".$_SESSION['id_usuario']."' group by l.id  desc    ";
		$exe_venda = mysql_query($sql_venda)or die (mysql_error().'-'.$sql_venda);
		$row_venda = mysql_num_rows($exe_venda);
		while ($reg_venda = mysql_fetch_array($exe_venda, MYSQL_ASSOC)) { 
		
		$data2 = $reg_venda['dt_lancamento'];
		$hora2 = $reg_venda['dt_lancamento'];
		//Formatando data e hora para formatos Brasileiros.
		$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
		$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
		
		$receita_id = $reg_venda['receita_id'];
		$vl_pago = $reg_venda['vl_pago'];
				if($receita_id == 7){
					$transferencias += $vl_pago;	
				}
				else if($receita_id == 2){
					$saidas += $vl_pago;	
				}
				else if($receita_id == 6){
					$credito_cli += $vl_pago;	
				}
				else if($receita_id == 1){
					$entradas += $vl_pago;	
				}
				
				$total_entradas = $entradas + $credito_cli;
				$total_saidas = $transferencias + $saidas;
		
				
	
		
?>
</p>

  <tr>
    <td width="111" height="21" class="ac_odd"><?=$reg_venda['caixa_id']?></td>
    <td width="179" class="ac_odd"><div align="center">
      <?=$novadata?>
    </div></td>
    <td width="114" class="ac_odd"><?=$reg_venda['lanc_despesa_id']?></td>
    <td width="110" class="ac_odd"><?=$reg_venda['venda_id']?></td>
    <td width="216" class="ac_odd"><?=$reg_venda['contas_receber_id']?>&nbsp;-&nbsp;<?=substr($reg_venda['nomezzz'],0,20)?></td>
    <td width="135" class="ac_odd"><div align="right">
      <?=number_format($reg_venda['vl_pago'],2,",",".")?>
    </div></td>
  </tr>
  <?
  }
  }
  ?>
</table>
<table width="23%" border="1">
  <tr>
    <td colspan="2"><div align="center"><strong>Totais</strong></div></td>
    </tr>
  <tr>
    <td width="28%"><span class="style4">Entradas</span></td>
    <td width="24%"><span class="style4">
      <?="U$ ".number_format($total_entradas,2,",",".")."<br>"?>
    </span></td>
    </tr>
  <tr>
    <td><span class="style4">Saidas</span></td>
    <td><span class="style4">
      <?="U$ ".number_format($total_saidas,2,",",".")."<br>"?>
    </span></td>
    </tr>
  <tr>
    <td height="23"><span class="style4">Total</span></td>
    <td><span class="style4">
      <?="U$ ".number_format($total_geral = $total_entradas - $total_saidas,2,",",".")."<br>"?>
    </span></td>
    </tr>
</table>

<table width="30%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="80%" border="1">
  <tr>
    <td width="17%"><span class="style3">CAIXA GERAL:</span></td>
  </tr>
  <tr>
    <td height="21"><strong>CAIXA N.</strong></td>
    <td width="27%"><strong>DATA LANCAMENTO</strong></td>
    <td width="15%"><strong>COMPRA  N.</strong></td>
    <td width="29%"><strong>CONTAS PAGAR N.</strong></td>
    <td width="12%"><strong>VALOR</strong></td>
  </tr>


<p>
  <?php
  
  	if (empty ($_POST['data_ini'])) { $dt_ini = $data; }
	else { $dt_ini = converte_data('2',$_POST['data_ini']);}
    
	if (empty ($_POST['data_fim'])) { $dt_fim = $data; }
	else { $dt_fim = converte_data('2',$_POST['data_fim']); }
	
	
	if (!empty ($dt_ini) && !empty ($dt_fim) ) {
  

	$sql_compra = "SELECT lc.*, c.id AS idc FROM lancamento_caixa lc, caixa c WHERE lc.data_lancamento BETWEEN '$dt_ini' AND '$dt_fim'  GROUP BY lc.id order by lc.id asc  ";
		$exe_compra = mysql_query($sql_compra)or die (mysql_error().'-'.$sql_compra);
		$row_compra = mysql_num_rows($exe_venda);
		while ($reg_compra = mysql_fetch_array($exe_compra, MYSQL_ASSOC)) { 
		
		$data3 = $reg_compra['data_lancamento'];
		$hora3 = $reg_compra['data_lancamento'];
		//Formatando data e hora para formatos Brasileiros.
		$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
		
		$receita_idb = $reg_compra['receita_id'];
		$vl_pagob = $reg_compra['valor'];
				if($receita_idb == 7){
					$transferenciasb += $vl_pagob;	
				}
				else if($receita_idb == 2){
					$saidasb += $vl_pagob;	
				}
				else if($receita_idb == 6){
					$credito_clib += $vl_pagob;	
				}
				else if($receita_idb == 1){
					$entradasb += $vl_pagob;	
				}
				
				$total_entradasb = $entradasb + $transferenciasb;
				$total_saidasb =  $saidasb;
			
		
?>
</p>

  <tr>
    <td width="124" height="21" class="ac_odd"><?=$reg_compra['caixa_id']?></td>
    <td width="27%" class="ac_odd"><div align="center">
      <?=$novadata2?>
    </div></td>
    <td width="15%" class="ac_odd"><?=$reg_compra['venda_id']?></td>
    <td width="29%" class="ac_odd"><?=$reg_compra['fornecedor_id']?>&nbsp;-&nbsp;<?=substr($reg_compra['nomezzz'],0,20)?></td>
    <td width="12%" class="ac_odd"><div align="right">
      <?=number_format($reg_compra['valor'],2,",",".")?>
    </div></td>
  </tr>
  <?
  }
  }
  ?>
</table>
<table width="21%" border="1">
  <tr>
    <td colspan="2"><div align="center"><strong>Totais</strong></div></td>
    </tr>
  <tr>
    <td width="19%"><span class="style4">Entradas</span></td>
    <td width="25%"><span class="style4">
      <?="U$ ".number_format($total_entradasb,2,",",".")."<br>"?>
    </span></td>
    </tr>
  <tr>
    <td><span class="style4">Saidas</span></td>
    <td><span class="style4">
      <?="U$ ".number_format($total_saidasb,2,",",".")."<br>"?>
    </span></td>
    </tr>
  <tr>
    <td height="23"><span class="style4">Total</span></td>
    <td><span class="style4">
      <?="U$ ".number_format($total_geralb = $total_entradasb - $total_saidasb,2,",",".")."<br>"?>
    </span></td>
    </tr>
</table>
</form>
<p><img src="images/imp_hp.gif" width="37" height="33" /> <span class="Estilo20"></span><a href="relatorio_geral_caixa.php?dt_ini=<?=$dt_ini?>&dt_fim=<?=$dt_fim?>">Imprimir Pesquisa</a></p>
<p>&nbsp;</p>
</body>
</html>
