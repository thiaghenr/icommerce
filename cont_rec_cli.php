<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();
$tela = cont_rec_cli;

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
$cli = $_GET['cli'];
$_SESSION['cli'] = $cli;
$estado = $_GET['estado'];
if (empty ($estado)){
$abre = "none";
}
else {
$abre = $_GET['show'];
}

$estadob = $_GET['estadob'];
if (empty ($estadob)){
$abreb = "none";
}
else {
$abreb = $_GET['show'];
}

$sql_caixa_balcao = "SELECT * FROM caixa_balcao WHERE usuario_id = ". $id_usuario." AND st_caixa = 'A'";
$rs_caixa_balcao = mysql_query($sql_caixa_balcao);
$linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao, MYSQL_ASSOC);
$caixa_id = $linha_caixa_balcao['id'];


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
  window.location.href='\contas_receber.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='\contas_receber.php';
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

function Limpar(valor, validos) {
// retira caracteres invalidos da string
var result = "";
var aux;
for (var i=0; i < valor.length; i++) {
aux = validos.indexOf(valor.substring(i, i+1));
if (aux>=0) {
result += aux;

}
}
return result;
}


function Formata(campo,tammax,teclapres,decimal) {
var tecla = teclapres.keyCode;
vr = Limpar(campo.value,"0123456789");
tam = vr.length;
dec=decimal;

if (tam < tammax && tecla != 8){
tam = vr.length + 1 ;

}

if (tecla == 8 ){
tam = tam - 1 ;

}

    if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <=
105 )
    {

        if ( tam <= dec ){
        campo.value = vr ;
        }

        if ( (tam > dec) && (tam <= 5) ){
        campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec,
tam ) ;
        }
        if ( (tam >= 6) && (tam <= 8) ){
        campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3
) + "," + vr.substr( tam - dec, tam ) ;
        }
        if ( (tam >= 9) && (tam <= 11) ){
        campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3
) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ;
        }
        if ( (tam >= 12) && (tam <= 14) ){
        campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11,
3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," +
vr.substr( tam - dec, tam ) ;
        }
        if ( (tam >= 15) && (tam <= 17) ){
        campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14,
3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." +
vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;
        }
    }

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
.style1 {color: #0000FF}
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
		
			$sql_listaz = "SELECT * FROM contas_receber  WHERE id = '$pagare' "; 
			$exe_listaz = mysql_query($sql_listaz, $base) or die (mysql_error());
			$linha = mysql_fetch_array($exe_listaz, MYSQL_ASSOC);
			
			$liquidob = ($linha['vl_parcela'] - $linha['desconto']);
			$liquido =  $liquidob - $linha['vl_recebido'];
			
			$venda_id = $linha['venda_id'];
			$receber_id = $linha['id'];
						
			if ($linha['status'] == 'A') {
			$sql_lancamento_caixa_balcao = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id,contas_receber_id) 
            VALUES ('1','$caixa_id', NOW(), '$liquido','$venda_id','$receber_id')";
            $exe_lancamento_caixa_balcao = mysql_query($sql_lancamento_caixa_balcao) or die ("SU CAJA ESTA CERRADO"); //mysql_error());
			
			$sql_total_devido = "UPDATE clientes SET saldo_devedor = saldo_devedor - '$valor_recebido' ";
			$exe_total_devido = mysql_query($sql_total_devido) or die (mysql_error());
			
			$sql_receber = "UPDATE contas_receber SET status = 'P' WHERE id = '$pagare'  ";
			$exe_receber = mysql_query($sql_receber, $base) or die (mysql_error().'-'.$sql_receber);
			}
			$sql_cont = "SELECT COUNT(*) AS aberto FROM contas_receber WHERE status = 'A' AND venda_id = '$venda_id' ";
			$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
			$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
						
			if ($reg_cont['aberto'] == 0) {
			$sql_fecha = "UPDATE venda SET st_venda = 'F' WHERE id = '$venda_id' ";
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
    <td bgcolor="#0EEAE0"><div align="center" class="Estilo7">RECIBIMENTO DE CUENTAS CLIENTE</div></td>
  </tr>
</table>
<p align="center" class="Estilo5">&nbsp;</p>
<table width="100%" border="0" cellpadding="0" cellspacing="1" style="border: 1px solid blue; border-collapse: collapse">
  <tr>
    <td width="9%" height="21" bgcolor="#OEEAEO"><span class="Estilo6"><strong>Cod Cliente</strong></span></td>
    <td width="25%" bgcolor="#OEEAEO"><span class="Estilo6"><strong>Cliente</strong></span></td>
    <td width="11%" bgcolor="#OEEAEO"><span class="Estilo6"><strong>Valor Total Devido </strong></span></td>
  </tr>
  
  
  
  <?

	
		$sql_listas = "SELECT ct.*, c.* FROM contas_receber ct, clientes c WHERE c.controle = '".$_SESSION['cli']."' AND ct.clientes_id = c.controle AND ct.status = 'A' ";
		$exe_listas = mysql_query($sql_listas, $base);
	while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)){
		
		$total_desconto += $reg_listas['desconto'];
		$total_devidob += $reg_listas['vl_parcela'];
		$total_pago += $reg_listas['vl_recebido'];
		$total_devido = $total_devidob - $total_pago - $total_desconto;
		}	
		
		$sql_listas2 = "SELECT * FROM clientes WHERE controle = '".$_SESSION['cli']."' ";
		$exe_listas2 = mysql_query($sql_listas2, $base);
		$reg_listas2 = mysql_fetch_array($exe_listas2, MYSQL_ASSOC);
		
				
?>
  <tr>
    <td width="9%" bgcolor="#FFFFFF"><?=$reg_listas2['controle']?>&nbsp;</td>
    <td width="25%" bgcolor="#FFFFFF"><?=$reg_listas2['nome']?></td>
    <td width="11%" bgcolor="#FFFFFF"><?=number_format($total_devido,2,",",".")?>&nbsp;</td>
  </tr>
</table>

<form id="form1" name="form1" method="post" action="relatorio_cli.php?cli=<?=$_SESSION['cli']?>">
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
    <td width="5%" bgcolor="#0EEAE0" class="Estilo21"><span class="Estilo6 Estilo10 Estilo19"><strong>Pedido</strong></span></td>
    <td width="5%" bgcolor="#0EEAE0" class="Estilo21"><span class="Estilo6 Estilo10 Estilo19"><strong> Venda </strong></span></td>
    <td width="8%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo20"><span class="Estilo6"><strong>Total  Venda </strong></span></div></td>
    <td width="10%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo20"><span class="Estilo6"><strong>Data Compra </strong></span></div></td>
    <td width="4%" bgcolor="#0EEAE0" class="Estilo21"><div align="center" class="Estilo20"><span class="Estilo6"><strong>QTs </strong></span></div></td>
    <td width="11%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo20"><span class="Estilo6"><strong>Vencimento </strong></span></div></td>
    <td width="10%" bgcolor="#0EEAE0" class="Estilo21"><div align="center" class="Estilo20"><span class="Estilo6"><strong>Nota Credito </strong></span></div></td>
    <td width="9%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo20"><span class="Estilo6"><strong>Valor</strong></span></div></td>
    <td colspan="2" bgcolor="#0EEAE0" class="Estilo21"><div align="center" class="Estilo20"><span class="Estilo6"><strong>Recebido</strong></span></div></td>
    <td colspan="2" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo6 Estilo14 Estilo19"><strong>Descuento</strong></div></td>
    <td width="9%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo6 Estilo19"><strong>Total</strong></div></td>
    <td width="8%" bgcolor="#0EEAE0" class="Estilo21">&nbsp;</td>
  </tr>
  <?php	
	
$sql_lista = "SELECT c.*, DATEDIFF(NOW(), c.dt_vencimento) AS diferenca, v.id AS idv ,v.pedido_id FROM contas_receber c, venda v WHERE c.clientes_id = '$cli' AND c.status = 'A' AND c.venda_id = v.id GROUP BY c.id"; 
	$exe_lista = mysql_query($sql_lista, $base) or die (mysql_error());
	$num_lista = mysql_num_rows($exe_lista);
		
		$i=0;
		while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
			$total_liquidoa = ($reg_lista['vl_parcela'] - $reg_lista['desconto']  );
			$total_liquido =  $total_liquidoa  - $reg_lista['vl_recebido'];
		
			if ($i%2==0) 
				$cor = "#FFFFFF";
			else 
				$cor = "#C5D6FC";
				
			if ($reg_lista['diferenca'] >= 0)
				$cor = "#FF0000";
				
		//	$vl_parcelado = $reg_lista['vl_parcela'] * $reg_lista['nm_total_parcela'] ;
			
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
			
			?>
  <tr bgcolor="<? echo $cor?>" onmouseover="style.background='#FFDE9F'" onmouseout="style.background='<? echo $cor?>'">
    <td width="5%" height="19" class="Estilo8"><span class="Estilo17">
      <?=$reg_lista['pedido_id']?>
    </span></td>
    <td width="5%" class="Estilo8"><span class="Estilo17">
      <?=$reg_lista['venda_id']?>
    </span></td>
    <td width="8%" class="Estilo8"><div align="right" class="Estilo17">
      <?=number_format($reg_lista['vl_total'],2,",",".")?>
    </div></td>
    <td width="10%" class="Estilo8"><div align="right" class="Estilo17">
      <?=$novadata?>
    </div></td>
    <td width="4%" class="Estilo8"><div align="center" class="Estilo17">
      <?=$reg_lista['nm_total_parcela']?>
    </div></td>
    <td width="11%" class="Estilo8"><div align="right" class="Estilo17">
      <?=$novadata2?>
    </div></td>
    <td width="10%" class="Estilo8"><div align="center" class="Estilo17">
      <?=$reg_lista['vl_ntcredito']?>
    </div></td>
    <td width="9%" class="Estilo8"><div align="right" class="Estilo17">
      <?=number_format($reg_lista['vl_parcela'],2,",",".")?>
    </div></td>
    <td width="1%" class="Estilo17"><div align="right"> <a href="cont_rec_cli.php?acao=recpar&id=<?=$reg_lista['id']?>&cli=<?=$cli?>&estadob=show"><img src="images/desconto.jpg" alt="Receber Parcial" width="16" height="17" border="0"  onclick="$('#m_divb').show('slow')"  /></a>
            <div align="center"></div>
    </div></td>
    <td width="9%" class="Estilo17"><?=number_format($reg_lista['vl_recebido'],2,",",".")?></td>
    <td width="1%"><a href="cont_rec_cli.php?acao=descontar&id=<?=$reg_lista['id']?>&cli=<?=$cli?>&estado=show"><img src="images/desconto.jpg" alt="Conceder Descuento" width="16" height="17" border="0"  onclick="$('#m_div').show('slow')"  /></a>
        <div align="center"></div></td>
    <td width="10%"><span class="Estilo17">
      <?=number_format($reg_lista['desconto'],2,",",".")?>
    </span></td>
    <td width="9%" class="Estilo8"><div align="right" class="Estilo18"><span class="Estilo10">
      <?=number_format($total_liquido,2,",",".")?>
    </span></div></td>
    <td width="8%" class="Estilo8"><div align="center" class="Estilo17"><a href="cont_rec_cli.php?acao=receber&pagare=<?=$reg_lista['id']?>&cli=<?=$_SESSION['cli']?>">recibir</a></div></td>
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
			$valorb = str_replace('.', '',$_POST['valor']);
			$valor = str_replace(',', '.',$valorb);
			$id = $_GET['ide'];
		
		$sql_desconto = "UPDATE contas_receber SET desconto = $valor WHERE id = '$id' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());	
		
		echo "<script language='javaScript'>window.location.href='cont_rec_cli.php?cli=".$_SESSION['cli']."'</script>";
					
		}
	}
}
?>

  <?php
  		if ($_GET['acao'] == "descontar") {
		$id = $_GET['id'];
  		
		$sql_desconto = "SELECT * FROM contas_receber where id = '$id' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());
			$reg_desconto = mysql_fetch_array($exe_desconto, MYSQL_ASSOC); 
			
			$desconto = $reg_desconto['id'];
			$valor_final = $reg_desconto['vl_parcela'] - $reg_desconto['desconto'] - $reg_desconto['vl_recebido'];
			
			$data2 = $reg_desconto['dt_lancamento'];
			$hora2 = $reg_desconto['dt_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$data3 = $reg_desconto['dt_vencimento'];
			$hora3 = $reg_desconto['dt_vencimento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
			$novahora2 = substr($hora3,11,2) . "h " .substr($hora3,14,2) . " min";
?>
<table width="100%" border="0">
  <tr>
    <td width="7%" height="21" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">PAGARE</span></td>
    <td width="6%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">VENDA</span></td>
    <td width="13%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">TOTAL VENDA </span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">DT COMPRA </span></td>
    <td width="3%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">QTs</span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">VENCIMENTO</span></td>
    <td width="9%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">NT CREDITO </span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">VALOR </span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">INTERES</span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">DESCUENTO</span></td>
    <td width="12%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">TOTAL</span></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$desconto?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$reg_desconto['venda_id']?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=number_format($reg_desconto['vl_total'],2,",",".")?>
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
      <?=$reg_desconto['vl_ntcredito']?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=number_format($reg_desconto['vl_parcela'],2,",",".")?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=number_format($reg_desconto[''],2,",",".")?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=number_format($reg_desconto['desconto'],2,",",".")?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=number_format($valor_final,2,",",".")?>
    </span></td>
  </tr>
</table>
<?
}
?>

<form action="cont_rec_cli.php?acao=desconto&ide=<?=$id?>&cli=<?=$cli?>" method="post">
<table width="36%" border="0">
  <tr>
    <td colspan="2" bgcolor="#0EEAE0"><span class="Estilo6"><strong>INFORME O VALOR DO DESCONTO</strong></span></td>
  </tr>
  <tr>
    <td width="18%"  bgcolor="#0EEAE0"><span class="Estilo6"><strong>VALOR:</strong></span></td>
    <td width="82%"><span class="Estilo4">
      <label>
      <input type="text" id="valor" name="valor" onKeydown="Formata(this,10,event,2);" />
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
<div id="m_divb" style="display:<?=$abreb?> ">
  <p>
    <?php
//$clis = $_POST['cli'];
//$ide = $_GET['id'];

		if ($_GET['acao'] == "recpar") {
		if (isset($_GET['ide'])) {
			if ($_GET['ide']) {
			$valordescb =  str_replace('.', '',$_POST['valordesc']);
			$valordesc =  str_replace(',', '.',$valordescb);
			$id = $_GET['ide'];
			
			$sql_listap = "SELECT * FROM contas_receber  WHERE status = 'A' AND id = '$id' "; 
			$exe_listap = mysql_query($sql_listap, $base) or die (mysql_error());
			$linhap = mysql_fetch_array($exe_listap, MYSQL_ASSOC);
			
			$liquidopp = ($linhap['vl_parcela'] - $linhap['desconto']);
			$liquidop =  $liquidopp - $linhap['vl_recebido'];
			
			$venda_idp = $linhap['venda_id'];
			$receber_idp = $linhap['id'];
			$recebido_anterior = $linhap['vl_recebido'];
			$total_recpar = $recebido_anterior + $valordesc;
		
		if($valordesc <= $liquidop && $valordesc > 0){
		$sql_desconto = "UPDATE contas_receber SET vl_recebido = $total_recpar WHERE id = '$id' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());	
		
		$sql_lancar_parcial = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id,contas_receber_id) VALUES('1', '$caixa_id', NOW(), '$valordesc', '$venda_idp', '$receber_idp')";
		$exe_lancar_parcial = mysql_query($sql_lancar_parcial, $base) or die (mysql_error());
		
		echo "<script language='javaScript'>window.location.href='cont_rec_cli.php?cli=".$_SESSION['cli']."'</script>";
		}
		else{
		$msgn = "O Valor informado é maior do que o valor devido, verifique";
		}
		if($valordesc == $liquidop){
		$sql_quitar = "UPDATE contas_receber SET status = 'P' WHERE id = '$id' ";
		$exe_quitae = mysql_query($sql_quitar) or die (mysql_error());
		}
		}
	}
}
?>
    <?php
  		if ($_GET['acao'] == "recpar") {
		$id = $_GET['id'];
  		
		$sql_desconto = "SELECT * FROM contas_receber where id = '$id' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());
			$reg_desconto = mysql_fetch_array($exe_desconto, MYSQL_ASSOC); 
			
			$desconto = $reg_desconto['id'];
			$valor_final = $reg_desconto['vl_parcela'] - $reg_desconto['desconto'] - $reg_desconto['vl_recebido'];
			
			$data2 = $reg_desconto['dt_lancamento'];
			$hora2 = $reg_desconto['dt_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$data3 = $reg_desconto['dt_vencimento'];
			$hora3 = $reg_desconto['dt_vencimento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
			$novahora2 = substr($hora3,11,2) . "h " .substr($hora3,14,2) . " min";
?>
  </p>
  <table width="100%" border="0">
    <tr>
      <td width="7%" height="21" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">PAGARE</span></td>
      <td width="6%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">VENDA</span></td>
      <td width="13%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">TOTAL VENDA </span></td>
      <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">DT COMPRA </span></td>
      <td width="3%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">QTs</span></td>
      <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">VENCIMENTO</span></td>
      <td width="6%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">N. QT </span></td>
      <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">VALOR </span></td>
      <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">RECEBIDO</span></td>
      <td width="9%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">DESCUENTO</span></td>
      <td width="16%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">TOTAL</span></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><span class="Estilo4">
        <?=$desconto?>
      </span></td>
      <td bgcolor="#FFFFFF"><span class="Estilo4">
        <?=$reg_desconto['venda_id']?>
      </span></td>
      <td bgcolor="#FFFFFF"><span class="Estilo4">
        <?=number_format($reg_desconto['vl_total'],2,",",".")?>
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
        <?=number_format($reg_desconto['vl_parcela'],2,",",".")?>
      </span></td>
      <td bgcolor="#FFFFFF"><span class="Estilo4">
        <?=number_format($reg_desconto['vl_recebido'],2,",",".")?>
      </span></td>
      <td bgcolor="#FFFFFF"><span class="Estilo4">
        <?=number_format($reg_desconto['desconto'],2,",",".")?>
      </span></td>
      <td bgcolor="#FFFFFF"><span class="Estilo4">
        <?=number_format($valor_final,2,",",".")?>
      </span></td>
    </tr>
  </table>
  <?
}
?>
  <form action="cont_rec_cli.php?acao=recpar&amp;ide=<?=$id?>&amp;cli=<?=$cli?>" method="post">
    <table width="26%" border="0">
      <tr>
        <td colspan="2" bgcolor="#FFFFCC"><span class="Estilo6 style1"><strong>INFORME O VALOR RECEBIDO </strong></span></td>
      </tr>
      <tr>
        <td width="29%"  bgcolor="#FFFFCC"><span class="Estilo6"><strong><span class="style1">VALOR:</span>:</strong></span></td>
        <td width="71%"><span class="Estilo4">
          <label>
            <input type="text" id="valordesc" name="valordesc" onKeydown="Formata(this,10,event,2);">
          </label>
        </span></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <p>
      <input type="submit" name="Submit2" value="Enviar" />
    </p>
  </form>
  </p>
</div>
<p></p>
</body>
</html>
