<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();
$mes= date("m");
$nom = $_POST['nom'];
$ped = $_POST['ped'];

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Historico de Compras - <? echo $title ?></title>

<link href="css/clearbox.css" rel="stylesheet" type="text/css" />
<script src="js/clearbox.js" type="text/javascript"></script>
<link rel="stylesheet" href="/js/jquery/calendario/calendario.css"/>
<link rel="stylesheet" href="/js/jquery/themes/spread.css"/>
<script type="text/javascript" src="/js/jquery/jquery/jquery.js"></script>
<script type="text/javascript" src="/js/funcoes.js"></script>
<script type="text/javascript" src="/js/jquery/calendario/jquery-calendar.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-numeric.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-floatnumber.js"></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>

<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" /> 
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery.maskedinput-1.1.4.js"></script>

<script type='text/javascript'>
jQuery(function($){

$("#data_ini").mask("99/99/9999"); // onde #date é o id do campo
$("#data_fim").mask("99/99/9999"); // onde #date é o id do campo

$("#phone").mask("(99) 9999-9999");

$("#cpf").mask("999.999.999-99");
$("#moeda").mask("9.000.000,00");
});

</SCRIPT>

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
.Estilo4 {color: #000000; font-weight: bold; }
.Estilo5 {font-weight: bold}
.Estilo6 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo47 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Estilo51 {font-size: 14px; font-family: Geneva, Arial, Helvetica, sans-serif; color: #666666; }
.Estilo54 {font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 14px; }
.style7 {color: #006666}
.style9 {color: #FFFF00; font-weight: bold; }
.style5 {font-size: 12px}
</style>
</head>

<body onload="document.getElementById('ped').focus()">
<table width="100%" border="0">
  <tr>
    <td bgcolor="#OEEAEO"><div align="center" class="Estilo1">
      <p class="Estilo6">Pesquiza de Compras Efetuadas </p>
    </div></td>
  </tr>
</table>
<pre><strong>Pesquizar Por</strong>:</pre>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#00FFFF"><div align="right" class="style9">PESQUISA POR &nbsp;</div></td>
    <td bgcolor="#00FFFF"><span class="style9">EMISSAO</span></td>
    <td bgcolor="#00FFFF">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="18%" background="images/barramsn.jpg" bgcolor="#0EEAE0"><span class="style7">N. Compra: </span></td>
    <td width="24%" bordercolor="#0EEAE0" background="images/barramsn.jpg" bgcolor="#0EEAE0"><span class="style7">Nome do fornecedor: </span></td>
    <td width="8%">&nbsp;</td>
    <td width="13%" background="images/barramsn.jpg" bgcolor="#0EEAE0"><span class="style7">Data Inicial</span></td>
    <td width="12%"><span class="style7"></span></td>
    <td width="12%" background="images/barramsn.jpg" bgcolor="#0EEAE0"><span class="style7">Data Final</span></td>
    <td width="13%">&nbsp;</td>
  </tr>
  <tr>
    <td><form action="pesquisa_compras.php" method="post" name="id" class="Estilo54" id="form1">
      <label>
        <input type="text" id="ped" name="ped" />
        </label>
    </form></td>
    <td><form action="pesquisa_compras.php" method="post" name="nome_cli" class="Estilo54" id="form2">
      <label>
        <input type="text" size="40" name="nom" />
        </label>
    </form></td>
    <td>&nbsp;</td>
    <form action="pesquisa_compras.php" method="post" name="id" class="Estilo54" id="form1">
      <td><span class="calendar_today">
        <input type="text" id="data_ini" name="data_ini" value='<?=$_POST['data_ini']?>' />
      </span></td>
      <td>&nbsp;</td>
      <td><span class="calendar_today">
        <input type="text" id="data_fim" name="data_fim" value="<?=$_POST['data_fim']?>"  />
      </span></td>
      <td><div align="center">
        <input type="submit" name="Submit" value="Buscar" />
      </div></td>
    </form>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td width="8%" bgcolor="#OEEAEO"><span class="Estilo6">Compra</span></td>
    <td width="12%" bgcolor="#OEEAEO"><span class="Estilo6">N. Fatura</span></td>
    <td width="37%" bgcolor="#OEEAEO"><span class="Estilo6">Proveedor</span></td>
    <td width="12%" bgcolor="#OEEAEO"><div align="right" class="Estilo6">Total</div></td>
    <td width="11%" bgcolor="#OEEAEO"><div align="right" class="Estilo6">Emissao</div></td>
    <td width="10%" bgcolor="#OEEAEO"><span class="Estilo6">Lancamento</span></td>
  </tr>
  <?
	
		
	//$sql_lista = "SELECT  id, nome_cli, total_nota, data_car, vendedor FROM pedido"; 
	$sql_lista =  "SELECT c.fornecedor_id,dt_emissao_fatura,nm_fatura,data_lancamento,vl_total_fatura,id_compra, p.* FROM compras c, proveedor p WHERE c.id_compra LIKE '%$ped%' AND p.nome LIKE '%$nom%' AND p.id = c.fornecedor_id ORDER BY c.id_compra DESC limit 0,40 ";
	$exe_lista = mysql_query($sql_lista, $base)or die (mysql_error() .' '.$sql_caixa);
	$num_lista = mysql_num_rows($exe_lista);
	
	if (!empty ($_POST['data_ini']) && !empty ($_POST['data_fim'])) {
	
	$dt_ini = converte_data('2',$_POST['data_ini']);
	$dt_fim = converte_data('2',$_POST['data_fim'] );
	
	$sql_lista =  "SELECT c.fornecedor_id,dt_emissao_fatura,nm_fatura,data_lancamento,vl_total_fatura,c.id_compra, p.nome FROM compras c, proveedor p WHERE c.dt_emissao_fatura BETWEEN '$dt_ini' AND '$dt_fim' AND c.fornecedor_id = p.id GROUP BY c.id_compra  ORDER BY c.dt_emissao_fatura desc ";
	$exe_lista = mysql_query($sql_lista, $base)or die (mysql_error().'-'.$sql_lista);
	}
	
			$i=0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
			
			$total_pedidos += $reg_lista['vl_total_fatura'];
		
			$data2 = $reg_lista['dt_emissao_fatura'];
			$hora2 = $reg_lista['dt_emissao_fatura'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$data3 = $reg_lista['data_lancamento'];
			$hora3 = $reg_lista['data_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
			$novahora2 = substr($hora3,11,2) . "h " .substr($hora3,14,2) . " min";
			
			if ( $reg_lista['forma_pagamento_id'] != 1){
				$forma = 'CREDITO';
				}
		else {
				$forma = 'CONTADO';
				}
			
		if ( $reg_lista['situacao'] == 'F'){
				$situacao = 'FATURADO';
				}
		else {
				$situacao = 'PENDENTE';
				}
		if ($i%2==0) 
				$cor = "#FFFFFF";
			else 
				$cor = "#e5f1f4";	
		if ($situacao == 'PENDENTE'){
				$cor = "#33FFFF";		
			}
			?>
  <tr bgcolor="<? echo $cor?>"> 
    <td width="8%" height="21"><span class="Estilo51">
      <?=$reg_lista['id_compra']?>
    </span></td>
    <td width="12%" height="21"><span class="Estilo51"><a href="lista_duplicatas.php?comp=<?=$reg_lista['id_compra']?>" rel="clearbox(1000,650,click)"><?=$reg_lista['nm_fatura']?> </a>
    </span></td>
    <td width="37%" ><span class="Estilo51">
      <?=$reg_lista['nome']?>
    </span></td>
    <td width="12%" id="total"><div align="right" class="Estilo51">
      <?=number_format($reg_lista['vl_total_fatura'],2,",",".")?>
    </div></td>
    <td width="11%" ><div align="right" class="Estilo51">
      <?=$novadata?>
    </div></td>
    <td width="10%"><div align="right"><span class="Estilo51">
      <?=$novadata2?>
    </span></div></td>
    <td width="4%"><div align="center"><a href="vis_compra.php?acao=add&ide=<?=$reg_lista['id_compra']?>" rel="clearbox(850,600,click)" class="Estilo47"><img src="images/visualizar.bmp" width="12" height="14" border="0"/></a></div></td>
	 <td width="3%" ><div align="center"><a href="vis_compra_edit.php?ide=<?=$reg_lista['id_compra']?>" rel="clearbox(850,600,click)" class="Estilo47"><img src="images/edit.png" width="12" height="14" border="0"/></a></div></td>
      <td width="3%" >&nbsp;</td>
  </tr>
  <?
  $i++;
			}

	?>
</table>
<table width="48%" border="1">
  <tr>
    <td width="73%"><div align="right" class="style5">Total</div></td>
    <td width="27%"><div align="right" class="style5">
      <?=number_format($total_pedidos,2,",",".")?>
      </span></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()"
    value="Cerrar" />
</font></p>
<p>&nbsp;</p>
<script type='text/javascript'>
	$("#total").autocomplete("pesquisa_total.php", {
		width: 260,
		selectFirst: false
	});	
	
</script>
</body>
</html>
