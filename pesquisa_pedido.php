<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();


$mes= date("m");
$nom = $_POST['nom'];
$ped = $_POST['ped'];
//$senha = "3366";
//echo $senha = sha1(stripslashes($senha));
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
<title>Pesquiza Pedido - <? echo $title ?></title>

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
background-color: ;
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
</style>
</head>

<body onload="document.getElementById('ped').focus()">
<table width="100%" border="0" bordercolor="#FF00FF">
  <tr>
    <td background="images/barramsn.jpg" bgcolor="#0EEAE0"><div align="center" class="Estilo1">
      <p class="Estilo6 style7">PESQUISA DE PEDIDOS</p>
    </div></td>
  </tr>
</table>
<pre><strong>Pesquizar Por</strong>:</pre>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td> </td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td>Somente Faturados</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="18%" background="images/barramsn.jpg" bgcolor="#0EEAE0"><span class="style7">N. Pedido: </span></td>
    <td width="24%" bordercolor="#0EEAE0" background="images/barramsn.jpg" bgcolor="#0EEAE0"><span class="style7">Nombre del Cliente: </span></td>
    <td width="8%">&nbsp;</td>
    <td width="13%" background="images/barramsn.jpg" bgcolor="#0EEAE0"><span class="style7">Data Inicial</span></td>
    <td width="12%"><span class="style7"></span></td>
    <td width="12%" background="images/barramsn.jpg" bgcolor="#0EEAE0"><span class="style7">Data Final</span></td>
    <td width="13%">&nbsp;</td>
  </tr>
  <tr>
    <td><form action="pesquisa_pedido.php" method="post" name="id" class="Estilo54" id="form1">
      <label>
      <input type="text" id="ped" name="ped" />
      </label>
    </form>    </td>
    <td><form action="pesquisa_pedido.php" method="POST" name="nome_cli" class="Estilo54" id="form2">
      <label>
        <input type="text" size="40" name="nom" />
        </label>
    </form>    </td>
    <td>&nbsp;</td>
    <form action="pesquisa_pedido.php" method="post" name="id" class="Estilo54" id="form1">
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
<?
	if ($_GET['acao'] == "del") {
		if ($_GET['situacao'] == "FATURADO"){ echo "<strong>A EXCLUSAO DESTE PEDIDO ACARRETARIA EM GRAVES ERROS, POIS JA FOI FATURADO</strong>"; }
		else{
		if (isset($_GET['ide'])) {
			if ($_GET['ide']) {
				$id_ped = $_GET['ide'];
				
			//PESQUISA O TOTAL  DE PRODUTOS QUE ESTA NA TABELA ITENS_PEDIDOS
			$sql_pes_qtd_itens_prod	= "SELECT * FROM itens_pedido WHERE id_pedido = '$id_ped' ";
			$rs_pes_qtd_itens_prod 	= mysql_query($sql_pes_qtd_itens_prod) or die (mysql_error().'-'.$sql_pes_qtd_itens_prod);
					while ($row_pes_qtd_itens_prod = mysql_fetch_array($rs_pes_qtd_itens_prod)){
        	$row_pes_qtd_itens_prod['referencia_prod'];
		 
													
			//PESQUISA O TOTAL DE PRDUTOS QUE ESTAO BLOQUEADOS
			$sql_pes_prod = "SELECT qtd_bloq,Estoque FROM produtos WHERE Codigo = '".$row_pes_qtd_itens_prod['referencia_prod']."'";
			$rs_pes_prod = mysql_query($sql_pes_prod) or die (mysql_error().'-'.$sql_pes_prod);
			while ($row_pes_prod = mysql_fetch_array($rs_pes_prod)){
	 	    $total_prod_bloq = $row_pes_prod['qtd_bloq'];
			$total_prod_estoq = $row_pes_prod['Estoque'];
			
			if(empty($total_prod_bloq)){
							$total_prod_bloq = 0 ;
						}
			//CALCULA O TOTAL DE PRODUTOS PARA SER BLOQUEADO
			$total = ($row_pes_prod['qtd_bloq'] - $row_pes_qtd_itens_prod['qtd_produto']) ;
			$total_estoq = ($row_pes_prod['Estoque'] + $row_pes_qtd_itens_prod['qtd_produto']) ;
			
			//ATUALIZA  BLOQUEADOS NO ESTOQUE
			$sql_prod_bloquiados = "UPDATE produtos SET qtd_bloq = ".$total." WHERE Codigo='".$row_pes_qtd_itens_prod['referencia_prod']."'"; 
			mysql_query($sql_prod_bloquiados);
						
			//ATUALIZA QUANTIDADE NO ESTOQUE
			$sql_qtd2 = "UPDATE produtos SET  Estoque = ".$total_estoq." WHERE Codigo='".$row_pes_qtd_itens_prod['referencia_prod']."'"; 
			$exe_qtd2 = mysql_query($sql_qtd2, $base) or die (mysql_error());
				
			$sql_delp = "DELETE FROM pedido WHERE id = '$id_ped'"; 
			$exe_delp = mysql_query($sql_delp, $base) or die (mysql_error());
					
			$sql_deli = "DELETE FROM itens_pedido WHERE id_pedido = '$id_ped'"; 
			$exe_deli = mysql_query($sql_deli, $base) or die (mysql_error());
				}
				}
				}
				else {
					echo '<strong>Operacion no permitida, ha productos cadastrados con esta marca</strong>' ;
				}
			}
		}	
	}		
	//}
?>	


<table width="100%" border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td colspan="2" bgcolor="#OEEAEO"><span class="Estilo6">Pedido</span></td>
    <td width="24%" bgcolor="#OEEAEO"><span class="Estilo6">Cliente</span></td>
    <td width="7%" bgcolor="#OEEAEO"><div align="right" class="Estilo6">Nota</div></td>
    <td width="6%" bgcolor="#OEEAEO"><div align="right" class="Estilo6">Descuento</div></td>
    <td width="7%" bgcolor="#OEEAEO"><span class="Estilo6">Total</span></td>
    <td width="9%" bgcolor="#OEEAEO"><span class="Estilo6">Data</span></td>
    <td width="10%" bgcolor="#OEEAEO"><div align="center" class="Estilo6">Situacao</div></td>
    <td width="11%" bgcolor="#OEEAEO"><span class="Estilo6">Forma de pago </span></td>
    <td width="9%" bgcolor="#OEEAEO"><span class="Estilo6">Vendedor</span></td>
  </tr>
  <?
		
	$sql_lista =  "SELECT p.*, u.* FROM usuario u
	RIGHT JOIN pedido p ON p.vendedor = u.id_usuario
	 WHERE p.id LIKE '%$ped' AND p.nome_cli LIKE '%$nom%'  GROUP BY p.id ORDER BY CAST(id AS UNSIGNED) desc limit 0,50 ";
	$exe_lista = mysql_query($sql_lista, $base)or die (mysql_error().'-'.$sql_lista);
    
	 $_POST['data_ini']."<br>";
	
	if (!empty ($_POST['data_ini']) && !empty ($_POST['data_fim'])) {
	
	$dt_ini = converte_data('2',$_POST['data_ini']);
	$dt_fim = converte_data('2',$_POST['data_fim'] );
	
	$sql_lista =  "SELECT p.*, u.* FROM usuario u
	RIGHT JOIN pedido p ON p.vendedor = u.id_usuario
	 WHERE   p.data_car BETWEEN '$dt_ini' AND '$dt_fim' GROUP BY p.id ORDER BY CAST(id AS UNSIGNED) desc ";
	$exe_lista = mysql_query($sql_lista, $base)or die (mysql_error().'-'.$sql_lista);
	}
	
	
			$i=0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
			
			$totalNota = $reg_lista['total_nota'] - $reg_lista['desconto'];
			
			$descontos += $reg_lista['desconto'];
			$nota += $reg_lista['total_nota'];
			
			$total_pedidos = $nota - $descontos;
		
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
				$situacao = 'PENDENTE';
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
    <td width="1%" height="21"><a href="pesquisa_pedido.php?acao=del&ide=<?=$reg_lista['id']?>&situacao=<?=$situacao?>"  class="Estilo47"><img src="images/delete.gif" width="12" height="14" border="0"/></a></td>
    <td width="5%"><span class="style4">
      <?=$reg_lista['id']?>
    </span></td>
    <td width="24%" ><span class="style4">
      <?=$reg_lista['nome_cli']?>
    </span></td>
    <td width="7%" ><div align="right" class="style4">
      <?=guarani($reg_lista['total_nota'])?>
    </div></td>
    <td width="6%" ><div align="right" class="style4">
      <?=guarani($reg_lista['desconto'])?>
    </div></td>
    <td width="7%" ><div align="right" class="style4">
      <?=guarani($totalNota)?>
    </div></td>
    <td width="9%" ><div align="center"><span class="style4">
      <?=$novadata?>
    </span></div></td>
    <td width="10%"><div align="center" class="style4">
      <?=$situacao?>
    </div></td>
    <td width="11%"><span class="style4">
      <?=$forma?>
    </span></td>
    <td width="9%"><span class="style4">
      <?=$reg_lista['nome_user']?>
    </span></td>
    <td width="3%"><a href="vis_pedido.php?acao=add&ide=<?=$reg_lista['id']?>" rel="clearbox(820,600,click)" class="Estilo47"><img src="images/visualizar.bmp" width="12" height="14" border="0"/></a></td>
    <td width="3%" ><a href="vis_pedido_edit.php?ide=<?=$reg_lista['id']?>" rel="clearbox(850,600,click)" class="Estilo47"><img src="images/edit.png" width="18" height="14" border="0"/></a></td>
      <td width="3%" ><a href="impressao.php?id_pedido=<?=$reg_lista['id']?>" class="Estilo47"><img src="images/imp.jpg" width="19" height="19" border="0"/></a></td>
    <td width="2%" ><a href="javascript:abrir('\pedido_ok.php?id_pedido=<?=$reg_lista['id']?>');" class="Estilo47"><img src="images/pdf.JPG" width="19" height="19" border="0"/></a></td>
  </tr>
  <?
  $i++;
			}

	?>
</table>
<table width="48%" border="1">
  <tr>
    <td width="73%"><div align="right" class="style5">Tota Liquido:</div></td>
    <td width="27%"><div align="right" class="style5"><span class="style6">
      <?=guarani($total_pedidos)?>
    </span></div></td>
  </tr>
</table>
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()"
    value="Cerrar" />
</font></p>

  <label>
 

  </label>

<p>&nbsp;</p>
</body>
</html>
