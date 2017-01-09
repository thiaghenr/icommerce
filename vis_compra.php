<?php
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();
$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='\result_pedido.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='\pesquisa_pedido.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pedido - <? echo $title ?></title>
<style type="text/css">
<!--
.Estilo13 {
	font-size: 36px;
	font-weight: bold;
}
.Estilo14 {color: #FFFFFF}
.style1 {font-size: 10px}
.style2 {font-size: 12px}
-->
</style>
</head>

<body>
<p align="center" class="Estilo13"><? echo $cabecalho ?></p>
<table width="100%" border="0">
  <tr>
    <td width="10%" bgcolor="#FF0000"><div align="left" class="Estilo12">
      <div align="center" class="Estilo14">COMPRA</div>
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="0" width="100%">
   <tr>
     <td width="8%" bgcolor="#999999"><strong>Compra</strong></td>
     <td width="13%" bgcolor="#999999"><strong>Cod. Proveedor</strong></td>
     <td width="40%" bgcolor="#999999"><strong>Nome<strong></strong></strong></td>
     <td width="15%" bgcolor="#999999"><strong>Emissao</strong></td>
     <td width="12%" bgcolor="#999999"><strong>Lancamento</strong></td>
     <td width="12%" bgcolor="#999999"><strong>Usuario<strong></strong></strong></td>
   </tr>
   <?
	$ide = $_GET['ide'];		
				
			
	$sql_lista = "SELECT c.fornecedor_id,dt_emissao_fatura,nm_fatura,data_lancamento,vl_total_fatura,c.id AS idc, p.* FROM compras c, proveedor p WHERE c.id = '$ide' AND p.id = c.fornecedor_id ORDER BY c.id DESC limit 0,20 ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	//if ($num_lista > 0) {
		//$total_carrinho = 0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
			//$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
			
			// Pegando data e hora.
			$data2 = $reg_lista['data_lancamento'];
			//$hora = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";
			
			$data3 = $reg_lista['dt_emissao_fatura'];
			$hora3 = $reg_lista['dt_emissao_fatura'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
			$novahora2 = substr($hora3,11,2) . "h " .substr($hora3,14,2) . " min";
			
			?>
   <tr>
     <td width="8%" bgcolor="#CCCCCC"><?=$reg_lista['idc']?></td>
     <td width="13%" bgcolor="#CCCCCC"><?=$reg_lista['id']?></td>
     <td width="40%" bgcolor="#CCCCCC"><?=$reg_lista['nome']?></td>
     <td width="15%" bgcolor="#CCCCCC"><?=$novadata2 ?></td>
     <td width="12%" bgcolor="#CCCCCC"><?=$novadata ?></td>
     <td width="12%" bgcolor="#CCCCCC"><?=$reg_lista['vendedor']?></td>
   </tr>
   <?
		//}
	}
	?>
   <tr>
     <td>&nbsp;</td>
   </tr>
</table>
<table border="0" width="100%">
<tr>
              <td width="8%"><strong>Qtd</strong></td>
              <td width="42%"><strong>Descripcion<strong></strong></strong></td>
    <td width="16%"><strong>Cod.<strong></strong></strong></td>
    <td width="12%"><div align="right"><strong>Valor</strong></div></td>
    <td width="12%"><div align="right"><strong>Subtotal</strong></div></td>
   </tr>
			
            <?
	
			
	$sql_lista = "SELECT * FROM itens_compra WHERE compra_id = '$ide' ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	//if ($num_lista > 0) {
		$total_carrinho = 0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
			$total_carrinho += ($reg_lista['prcompra']*$reg_lista['qtd_produto']);
			
			?>
			 <tr>
              <td width="8%"><span class="style2">
              <?=$reg_lista['qtd_produto']?>
              </span></td>
              <td width="42%"><span class="style2">
              <?=substr($reg_lista['descricao_prod'],0,36)?>
              </span></td>
              <td width="16%">
                <div align="left" class="style2">
                  <?=$reg_lista['referencia_prod']?>
               </div></td>
              <td width="12%"><div align="right" class="style2">
                <?=number_format($reg_lista['prcompra'],2,",",".")?>
              </div></td>
			  <td width="12%"><div align="right" class="style2">
			    <?=number_format($reg_lista['prcompra']*$reg_lista['qtd_produto'],2,",",".")?>
			  </div></td>
   </tr>
			
			<?
		//}
	}
	?>
            <tr>
              <td height="23" colspan="3"><div align="right"><span class="style1"><span class="style2"></span></span></div></td>
              <td height="23"><div align="right" class="style2"><strong>Total:&nbsp;</strong></div></td>
              <td height="23"><span class="style2"><strong>
              </span>
                <div align="right" class="style2">
                  <?=number_format($total_carrinho,2,",",".")?>                
                </div>
                <span class="style2"><strong></span></td>
              <td width="10%">&nbsp;</td>
            </tr>
</table>
		  
		  
		  
		  
		  
		  
<p>&nbsp;</p>
</body>
</html>


</body>

</html>