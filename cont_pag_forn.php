<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$data= date("Y-m-d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$mes= date("m");
$cli = $_GET['cli'];
$_SESSION['cli'] = $cli;
$estado = $_GET['estado'];
if (empty ($estado)){
$abre = "none";
}
else {
$abre = $_GET['show'];
}

$sql_caixa = "SELECT * FROM caixa WHERE status = 'A'";
$rs_caixa = mysql_query($sql_caixa);
$linha_caixa = mysql_fetch_array($rs_caixa, MYSQL_ASSOC);
$caixa_id = $linha_caixa['id'];


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Contas a Pagar - <? echo $title ?> </title>
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

<script type="text/javascript">
	$(document).ready(function() {
		$("#data_ini").calendar({buttonImage: "images/calendar.gif"});
		$("#data_fim").calendar({buttonImage: "images/visualizar.JPG"});		
	
		$(".numeric").numeric(",");
	    $(".numeric").floatnumber(",",2);
	});	
</script>
<script>
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='\cont_pagar.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='\cont_pagar.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}

function setaFoco(){
		valor = '<?=$estado?>'
		if(valor.length > 0 )
			document.getElementById('valor').focus();
}

</script>
<style type="text/css">
<!--
.Estilo7 {
	color: #FFFF00;
	font-weight: bold;
}
.Estilo8 {font-family: "Times New Roman", Times, serif}
.Estilo10 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo14 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo17 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; }
.Estilo18 {font-size: 14px}
.Estilo19 {font-size: 14}
.Estilo20 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14; }
.Estilo21 {font-size: 12px}
-->
</style>
</head>

<body onLoad="setaFoco()">

<p>
  <? 
  
 if ($_GET['acao'] == "receber") {
		if (isset($_GET['pagare'])) {
			if ($_GET['pagare']) {
				$pagare = $_GET['pagare'];
		
			$sql_listaz = "SELECT * FROM contas_pagar  WHERE id = '$pagare' "; 
			$exe_listaz = mysql_query($sql_listaz, $base) or die (mysql_error());
			$linha = mysql_fetch_array($exe_listaz, MYSQL_ASSOC);
			
			$liquido = ($linha['vl_parcela'] - $linha['vl_desconto']);
			$compra_id = $linha['compra_id'];
			$pagar_id = $linha['id'];
			$nota = $linha['num_fatura'];
	echo		$fornecedor = $linha['fornecedor_id'];
						
			if ($linha['status'] == 'A') {
			$sql_lancamento_caixa_balcao = "INSERT INTO lancamento_caixa (receita_id,caixa_id,data_lancamento,valor,venda_id,contas_pagar_id,num_nota,fornecedor_id) 
            VALUES (2,$caixa_id, NOW(), $liquido,$compra_id,$pagar_id,$nota,$fornecedor)";
            $exe_lancamento_caixa_balcao = mysql_query($sql_lancamento_caixa_balcao) or die (mysql_error().'-'.$sql_lancamento_caixa_balcao);
			
		//	$sql_total_devido = "UPDATE clientes SET saldo_devedor = saldo_devedor - '$valor_recebido' ";
		//	$exe_total_devido = mysql_query($sql_total_devido) or die (mysql_error());
			
			$sql_receber = "UPDATE contas_pagar SET status = 'P' WHERE id = '$pagare'  ";
			$exe_receber = mysql_query($sql_receber, $base) or die (mysql_error().'-'.$sql_receber);
			}
			$sql_cont = "SELECT COUNT(*) AS aberto FROM contas_pagar WHERE status = 'A' AND compra_id = '$compra_id' ";
			$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
			$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
						
			if ($reg_cont['aberto'] == 0) {
			$sql_fecha = "UPDATE compras SET status = 'F' WHERE id_compra = '$compra_id' ";
			$exe_fecha = mysql_query($sql_fecha);
					
					
			
				}
			}
  		}
  	}
?>
</p>
<p>&nbsp;</p>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#0EEAE0"><div align="center" class="Estilo7">PAGAMENTO  DE CUENTAS </div></td>
  </tr>
</table>
<p align="center" class="Estilo5">&nbsp;</p>
<table width="100%" border="0" cellpadding="0" cellspacing="1" style="border: 1px solid blue; border-collapse: collapse">
  <tr>
    <td width="9%" height="21" bgcolor="#OEEAEO"><span class="Estilo6"><strong>Cod Proveedor</strong></span></td>
    <td width="25%" bgcolor="#OEEAEO"><span class="Estilo6"><strong>Proveedor</strong></span></td>
    <td width="11%" bgcolor="#OEEAEO"><span class="Estilo6"><strong>Valor Total Devido </strong></span></td>
  </tr>
  
  
  
  <?

	
		$sql_listas = "SELECT cp.*, p.* FROM contas_pagar cp, proveedor p WHERE p.id = '".$_SESSION['cli']."' AND cp.fornecedor_id = p.id AND cp.status = 'A' ";
		$exe_listas = mysql_query($sql_listas, $base);
	while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)){
		
		$total_devido += $reg_listas['vl_parcela'];
		}	
		
		$sql_listas2 = "SELECT * FROM proveedor WHERE id = '".$_SESSION['cli']."' ";
		$exe_listas2 = mysql_query($sql_listas2, $base);
		$reg_listas2 = mysql_fetch_array($exe_listas2, MYSQL_ASSOC);
		
				
?>
  <tr>
    <td width="9%" bgcolor="#FFFFFF"><?=$reg_listas2['id']?>&nbsp;</td>
    <td width="25%" bgcolor="#FFFFFF"><?=$reg_listas2['nome']?></td>
    <td width="11%" bgcolor="#FFFFFF"><?=number_format($total_devido,2,",",".")?>&nbsp;</td>
  </tr>
</table>

<form id="form1" name="form1" method="post" action="relatorio_forn.php?cli=<?=$_SESSION['cli']?>">
  <label>
  <input name="imprimir" type="radio" value="todos" checked/>
    Todos</label>
  <label>
  <input name="imprimir" type="radio" value="vencidos" />
  Vencidos</label>  

  <label>
  <input type="image" src="images/imp.jpg" value="submit" width="21" height="20" >

  </label>
</form>
<table width="100%" border="0" cellpadding="0" cellspacing="1" style="border: 1px solid blue; border-collapse: collapse">
  <tr>
    <td width="5%" bgcolor="#0EEAE0" class="Estilo21"><span class="Estilo6 Estilo10 Estilo19"><strong>Pagare</strong></span></td>
    <td width="6%" bgcolor="#0EEAE0" class="Estilo21"><span class="Estilo6 Estilo10 Estilo19"><strong> Compra </strong></span></td>
    <td width="10%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo20"><span class="Estilo6"><strong>Total Compra   </strong></span></div></td>
    <td width="10%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo20"><span class="Estilo6"><strong>Data Compra </strong></span></div></td>
    <td width="4%" bgcolor="#0EEAE0" class="Estilo21"><div align="center" class="Estilo20"><span class="Estilo6"><strong>QTs </strong></span></div></td>
    <td width="10%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo20"><span class="Estilo6"><strong>Vencimento </strong></span></div></td>
    <td width="7%" bgcolor="#0EEAE0" class="Estilo21"><div align="center" class="Estilo20"><span class="Estilo6"><strong>N.  Qt</strong></span></div></td>
    <td width="10%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo20"><span class="Estilo6"><strong>Valor</strong></span></div></td>
    <td width="12%" bgcolor="#0EEAE0" class="Estilo21"><div align="center" class="Estilo20"><span class="Estilo6"><strong>Interes</strong></span></div></td>
    <td colspan="2" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo6 Estilo14 Estilo19"><strong>Descuento</strong></div></td>
    <td width="9%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo6 Estilo19"><strong>Total</strong></div></td>
    <td width="8%" bgcolor="#0EEAE0" class="Estilo21">&nbsp;</td>
  </tr>

<?php	
	
$sql_lista = "SELECT *, DATEDIFF(NOW(), dt_vencimento_parcela) AS diferenca FROM contas_pagar  WHERE fornecedor_id = '$cli' AND status = 'A'  "; 
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
		
		$i=0;
		while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
			$total_liquido = ($reg_lista['vl_parcela'] - $reg_lista['vl_desconto']);
		
			if ($i%2==0) 
				$cor = "#FFFFFF";
			else 
				$cor = "#C5D6FC";
				
			if ($reg_lista['diferenca'] >= 0)
				$cor = "#FF0000";
				
		//	$vl_parcelado = $reg_lista['vl_parcela'] * $reg_lista['nm_total_parcela'] ;
			
			$data2 = $reg_lista['dt_emissao_fatura'];
			$hora2 = $reg_lista['dt_emissao_fatura'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$data3 = $reg_lista['dt_vencimento_parcela'];
			$hora3 = $reg_lista['dt_vencimento_parcela'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
			$novahora2 = substr($hora3,11,2) . "h " .substr($hora3,14,2) . " min";
			
			?>
  <tr bgcolor="<? echo $cor?>" onmouseover="style.background='#FFDE9F'" onmouseout="style.background='<? echo $cor?>'">

    <td width="5%" height="19" class="Estilo8"><span class="Estilo17">
      <?=$reg_lista['id']?>
    </span></td>
    <td width="6%" class="Estilo8"><span class="Estilo17">
      <?=$reg_lista['compra_id']?>
    </span></td>
    <td width="10%" class="Estilo8""><div align="right" class="Estilo17">
      <?=($reg_lista['vl_total_fatura'])?>
    </div></td>
    <td width="10%" class="Estilo8"><div align="right" class="Estilo17">
      <?=$novadata?>
    </div></td>
    <td width="4%" class="Estilo8"><div align="center" class="Estilo17">
      <?=$reg_lista['nm_total_parcela']?>
    </div></td>
    <td width="10%" class="Estilo8"><div align="right" class="Estilo17">
      <?=$novadata2?>
    </div></td>
    <td width="7%" class="Estilo8"><div align="center" class="Estilo17">
      <?=$reg_lista['nm_parcela']?>
    </div></td>
    <td width="10%" class="Estilo8"><div align="right" class="Estilo17">
      <?=($reg_lista['vl_parcela'])?>
    </div></td>
    <td width="12%" class="Estilo17">&nbsp;</td>
    <td width="2%"> <a href="cont_pag_forn.php?acao=descontar&id=<?=$reg_lista['id']?>&cli=<?=$cli?>&estado=show"><img src="images/desconto.jpg" alt="Conceder Descuento" width="16" height="17" border="0"  onclick="$('#m_div').show('slow')"  /></a>
      <div align="center"></div>
    <div align="center"></div>
    <div align="center"></div>
    <div align="center"></div>
    <div align="center"></div></td>
    <td width="7%"><span class="Estilo17">
      <?=$reg_lista['vl_desconto']?>
    </span></td>
    <td width="9%" class="Estilo8"><div align="right" class="Estilo18"><span class="Estilo10">
      <?=number_format($total_liquido,2,",",".")?>
    </span></div></td>
    <td width="8%" class="Estilo8"><div align="center" class="Estilo17"><a href="cont_pag_forn.php?acao=receber&pagare=<?=$reg_lista['id']?>&cli=<?=$_SESSION['cli']?>">pagar</a></div></td>
  </tr>
  <?
  $i++;
  }
   ?>
</table>
<p>&nbsp;</p>
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()"
    value="Cerrar" />
</font>
  <input type="button" value="Nueva pesquiza" name="LINK12" onclick="navegacao('Nueva')" />

<!-- <button id="btn1" onclick="$('#m_div').show('fast')">Exibir</button> 
<button id="btn2" onclick="$('#m_div').hide('slow')">Ocultar</button> -->
<p>
</p>
<p>
</p>
<div id="m_div" style="display:<?=$abre?> "> 
<?php
//$clis = $_POST['cli'];
//$ide = $_GET['id'];

		if ($_GET['acao'] == "desconto") {
		if (isset($_GET['ide'])) {
			if ($_GET['ide']) {
			$valor = $_POST['valor'];
			$id = $_GET['ide'];
		
		$sql_desconto = "UPDATE contas_pagar SET vl_desconto = $valor WHERE id = '$id' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());	
		
		echo "<script language='javaScript'>window.location.href='cont_pag_forn.php?cli=".$_SESSION['cli']."'</script>";
					
		}
	}
}
?>

  <?php
  		if ($_GET['acao'] == "descontar") {
		$id = $_GET['id'];
  		
		$sql_desconto = "SELECT * FROM contas_pagar where id = '$id' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());
			$reg_desconto = mysql_fetch_array($exe_desconto, MYSQL_ASSOC); 
			
			$desconto = $reg_desconto['id'];
			$valor_final = $reg_desconto['vl_parcela'] - $reg_desconto['desconto'];
			
			$data2 = $reg_desconto['dt_emissao_fatura'];
			$hora2 = $reg_desconto['dt_emissao_fatura'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$data3 = $reg_desconto['dt_vencimento_parcela'];
			$hora3 = $reg_desconto['dt_vencimento_parcela'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
			$novahora2 = substr($hora3,11,2) . "h " .substr($hora3,14,2) . " min";
?>
<table width="100%" border="0">
  <tr>
    <td width="7%" height="21" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">PAGARE</span></td>
    <td width="6%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">COMPRA</span></td>
    <td width="13%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">TOTAL COMPRA </span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">DT COMPRA </span></td>
    <td width="3%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">QTs</span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">VENCIMENTO</span></td>
    <td width="6%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">N. QT </span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">VALOR </span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">INTERES</span></td>
    <td width="9%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">DESCUENTO</span></td>
    <td width="16%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">TOTAL</span></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$desconto?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$reg_desconto['compra_id']?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=($reg_desconto['vl_total_fatura'])?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$novadata?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$reg_desconto['nm_total_parcela']?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$novadata2?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$reg_desconto['nm_parcela']?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=($reg_desconto['vl_parcela'])?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$reg_desconto['']?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=($reg_desconto['vl_desconto'])?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=number_format($valor_final,2,",",".")?>
    </span></td>
  </tr>
</table>
<?
}
?>

<form action="cont_pag_forn.php?acao=desconto&ide=<?=$id?>&cli=<?=$cli?>" method="post">
<table width="40%" border="0">
  <tr>
    <td colspan="2" bgcolor="#0EEAE0"><span class="Estilo6"><strong>INFORME O VALOR DO DESCONTO CEDIDO</strong></span></td>
  </tr>
  <tr>
    <td width="18%"  bgcolor="#0EEAE0"><span class="Estilo6"><strong>VALOR:</strong></span></td>
    <td width="82%"><span class="Estilo4">
      <label>
      <input type="text" id="valor" name="valor"  />
      </label>
    </span></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>
   <input type="submit" name="Submit" value="Enviar" />
  </p></form>
</p>

</div>
<p></p>
</body>
</html>
