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
<link href="css/clearbox.css" rel="stylesheet" type="text/css" />
<script src="js/clearbox.js" type="text/javascript"></script>
<link rel="stylesheet" href="/js/jquery/calendario/calendario.css"/>
<link rel="stylesheet" href="/js/jquery/themes/spread.css"/>
<script type="text/javascript" src="/js/jquery/jquery/jquery.js"></script>
<script type="text/javascript" src="/js/funcoes.js"></script>
<script type="text/javascript" src="/js/jquery/calendario/jquery-calendar.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-numeric.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery.maskedinput-1.1.4.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-floatnumber.js"></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" /> 

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DEVOLUCAO DE PEDIDOS FATURADOS - <? echo $title ?></title>

<script type="text/javascript">

/*	$(document).ready(function() {
		$("#data_ini").calendar({buttonImage: "images/calendar.gif"});
		$("#data_fim").calendar({buttonImage: "images/calendar.gif"});		
	
		$(".numeric").numeric(",");
	    $(".numeric").floatnumber(",",2);
	});	
*/	
jQuery(function($){

$("#data_ini").mask("99/99/9999"); // onde #date é o id do campo
$("#data_fim").mask("99/99/9999"); // onde #date é o id do campo

$("#phone").mask("(99) 9999-9999");

$("#cpf").mask("999.999.999-99");
$("#moeda").mask("9.000.000,00");



});

function abrir(URL) {

   var width = 540;
   var height = 480;

   var left = 300;
   var top = 100	;

   window.open(URL,'_blank', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=yes, toolbar=no, location=no, directories=no, menubar=no, resizable=yes, fullscreen=no ');

}
//http://hot.trankera.org/fotos-da-mulher-samambaia-pelada-sem-sensura-fazendo-entrevista-para-o-panico-em-praia-de-nudismo/
//http://omadi.blogspot.com/2008/09/fotos-da-mulher-samambaia-em-praia-de.html

</script>
<style type="text/css">
body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #ffffff;
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
.style4 {font-size: 12px; font-family: Geneva, Arial, Helvetica, sans-serif; color: #666666; }
.style5 {font-size: 12px}
.style6 {color: #666666; font-family: Geneva, Arial, Helvetica, sans-serif;}
.style7 {color: #006666}

.transparent_class {
filter:alpha(opacity=100);
-moz-opacity:0.5;
-khtml-opacity: 0.5;
opacity: 0.5;
}


</style>
</head>

<body onload="document.getElementById('ped').focus()">
<table width="100%" border="0" bordercolor="#FF00FF">
  <tr>
    <td height="17" background="images/barra.jpg" bgcolor="#0EEAE0"><div align="center" class="Estilo1">
      <p class="Estilo6 style5">DEVOLUCAO DE VENDAS</p>
    </div></td>
  </tr>
</table>
<pre><strong>Pesquizar Por</strong>:</pre>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="18%" background="images/barramsn.jpg" bgcolor="#OEEAEO"><span class="style7">N. Pedido: </span></td>
    <td width="8%">&nbsp;</td>
    <td width="12%"><span class="style7"></span></td>
    <td width="13%">&nbsp;</td>
  </tr>
  <tr>
    <td><form action="devolucao.php" method="post" name="id" class="Estilo54" id="form1">
      <label>
      <input type="text" id="ped" name="ped" />
      </label>
    </form>    </td>
    <td><input type="submit" name="Submit" value="Buscar" /></td>
    <form action="devolucao.php" method="post" name="id" class="Estilo54" id="form1">
    <td>&nbsp;</td>
    <td><div align="center"></div></td>
    </form>
  </tr>
</table>
<?

	if ($_GET['acao'] == "dev") {
		
		if (isset($_GET['ide'])) {
			if ($_GET['ide']) {
				$id_ped = $_GET['ide'];
				$estado = $_GET['estado'];
				if ($estado == 'D'){
		
		echo "<strong>ESTE PEDIDO JA FOI DEVOLVIDO</strong>"."<br>";
		}
		else{
				
			//PESQUISA O TOTAL  DE PRODUTOS QUE ESTA NA TABELA ITENS_PEDIDOS
			$sql_pes_qtd_itens_prod	= "SELECT * FROM itens_pedido WHERE id_pedido = '$id_ped' ";
			$rs_pes_qtd_itens_prod 	= mysql_query($sql_pes_qtd_itens_prod) or die (mysql_error().'-'.$sql_pes_qtd_itens_prod);
			while ($row_pes_qtd_itens_prod = mysql_fetch_array($rs_pes_qtd_itens_prod)){
            $row_pes_qtd_itens_prod['qtd_produto'];
		 
													
			//PESQUISA O TOTAL DE PRDUTOS QUE ESTAO NO ESTOQUE
			$sql_pes_prod = "SELECT Estoque FROM produtos WHERE Codigo = '".$row_pes_qtd_itens_prod['referencia_prod']."' ";
			$rs_pes_prod = mysql_query($sql_pes_prod) or die (mysql_error().'-'.$sql_pes_prod);
			while ($row_pes_prod = mysql_fetch_array($rs_pes_prod)){
	 	   
			$total_prod_estoq = $row_pes_prod['Estoque'];
			
			if(empty($total_prod_estoq)){
							$total_prod_estoq = 0 ;
						}
			$total_estoq = $row_pes_qtd_itens_prod['qtd_produto'] + $row_pes_prod['Estoque'];
						
			//ATUALIZA QUANTIDADE NO ESTOQUE
			$sql_qtd2 = "UPDATE produtos SET  Estoque = ".$total_estoq." WHERE Codigo='".$row_pes_qtd_itens_prod['referencia_prod']."'"; 
			$exe_qtd2 = mysql_query($sql_qtd2, $base) or die (mysql_error());
		  $id_ped;		
			$sql_dp = "UPDATE pedido SET situacao = 'D' WHERE id = '".$id_ped."' "; 
			$exe_dp = mysql_query($sql_dp, $base) or die (mysql_error());
			
			$sql_cr = "SELECT c.*, v.id AS vend,pedido_id, p.id AS pedid  FROM contas_receber c, venda v, pedido p WHERE p.id = v.pedido_id AND v.id = c.venda_id AND p.id = '".$id_ped."' group by p.id ";
			$exe_cr = mysql_query($sql_cr, $base) or die (mysql_error());
			$reg_cr = mysql_fetch_array($exe_cr, MYSQL_ASSOC);
		 $linhas = mysql_num_rows($exe_cr)."AKI";
					
			$sql_dv = "UPDATE venda SET st_venda = 'D' WHERE pedido_id = '".$reg_cr['pedido_id']."' "; 
			$exe_dv = mysql_query($sql_dv, $base) or die (mysql_error());
			
			$sql_dcr = "UPDATE contas_receber SET status = 'D' WHERE venda_id = '".$reg_cr['venda_id']."' AND status != 'P' "; 
			$exe_dcr = mysql_query($sql_dcr, $base) or die (mysql_error());
				
				}
				}
				
				}
			}
		}	
	}
?>	


<table width="100%" border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td bgcolor="#OEEAEO"><span class="Estilo6">Pedido</span></td>
    <td width="27%" bgcolor="#OEEAEO"><span class="Estilo6">Cliente</span></td>
    <td width="13%" bgcolor="#OEEAEO"><div align="right" class="Estilo6">Total</div></td>
    <td width="11%" bgcolor="#OEEAEO"><div align="right" class="Estilo6">Data</div></td>
    <td width="10%" bgcolor="#OEEAEO"><div align="center" class="Estilo6">Situacao</div></td>
    <td width="11%" bgcolor="#OEEAEO"><span class="Estilo6">Forma de pago </span></td>
    <td width="9%" bgcolor="#OEEAEO"><span class="Estilo6">Vendedor</span></td>
  </tr>
  <?
		
	$sql_lista =  "SELECT * FROM pedido WHERE id = '$ped'  GROUP BY id ORDER BY CAST(id AS UNSIGNED) desc limit 0,50 ";
	$exe_lista = mysql_query($sql_lista, $base)or die (mysql_error().'-'.$sql_lista);
    
	 $_POST['data_ini']."<br>";
	
	if (!empty ($_POST['data_ini']) && !empty ($_POST['data_fim'])) {
	
	$dt_ini = converte_data('2',$_POST['data_ini']);
	$dt_fim = converte_data('2',$_POST['data_fim'] );
	
	$sql_lista =  "SELECT p.*, u.* FROM pedido p, usuario u WHERE  p.usuario_id = u.id_usuario AND p.data_car BETWEEN '$dt_ini' AND '$dt_fim' GROUP BY p.id ORDER BY CAST(id AS UNSIGNED) desc ";
	$exe_lista = mysql_query($sql_lista, $base)or die (mysql_error().'-'.$sql_lista);
	}
	
	
			$i=0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
			
			$total_pedidos += $reg_lista['total_nota'];
		
			$data2 = $reg_lista['data_car'];
			$hora2 = $reg_lista['data_car'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			if ( $reg_lista['forma_pagamento_id'] != 1){
				$forma = 'CREDITO';
				}
		else {
				$forma = 'CONTADO';
				}
			
		if ( $reg_lista['situacao'] == 'F'){
				$situacao = 'FATURADO';
				}
		else if ( $reg_lista['situacao'] == 'A'){
				$situacao = 'FATURADO';
				}
		else if ( $reg_lista['situacao'] == 'D'){
				$situacao = 'DEVOLUCAO';
				}
				
		if ($i%2==0) 
				$cor = "#FFFFFF";
			else 
				$cor = "#efefef";	
		if ($situacao == 'PENDENTE'){
				$cor = "#dfe8f6";		
			}
			?>
  <tr bgcolor="<? echo $cor?>"> 
    <td width="6%" height="21" class="transparent_class"><span class="style4">
      <?=$reg_lista['id']?>
    </span></td>
    <td width="27%" class="transparent_class" ><span class="style4">
      <?=$reg_lista['nome_cli']?>
    </span></td>
    <td width="13%" class="transparent_class" ><div align="right" class="style4">
      <?=number_format($reg_lista['total_nota'],2,",",".")?>
    </div></td>
    <td width="11%" class="transparent_class" ><div align="right" class="style4">
      <?=$novadata?>
    </div></td>
    <td width="10%" class="transparent_class"><div align="center" class="style4">
      <?=$situacao?>
    </div></td>
    <td width="11%" class="transparent_class"><span class="style4">
      <?=$forma?>
    </span></td>
    <td width="9%" class="transparent_class"><span class="style4">
      <?=$reg_lista['nome_user']?>
    </span></td>
    <td width="3%" class="transparent_class"><a href="vis_pedido.php?acao=add&ide=<?=$reg_lista['id']?>" rel="clearbox(820,600,click)" class="Estilo47"><img src="images/visualizar.bmp" width="12" height="14" border="0"/></a></td>
    <td width="3%" class="transparent_class" ><a href="devolucao.php?acao=dev&ide=<?=$reg_lista['id']?>&estado=<?=$reg_lista['situacao']?>" class="Estilo47"><img src="images/cart_delete.png" width="18" height="14" border="0"/></a></td>
  </tr>
  <?
  $i++;
			}

	?>
</table>
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()"
    value="Cerrar" />
</font></p>

  <label>
 

  </label>

<p>
  <?

?>
</p>
</body>
</html>
