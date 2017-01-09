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
-->
</style>
</head>

<body>
<p align="center" class="Estilo13"><? echo $cabecalho ?></p>
<table width="100%" border="0">
  <tr>
    <td width="10%" bgcolor="#FF0000"><div align="left" class="Estilo12">
      <div align="center" class="Estilo14">PEDIDO</div>
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="0" width="100%">
   <tr>
     <td width="13%" bgcolor="#999999"><strong>Pedido</strong></td>
     <td width="13%" bgcolor="#999999"><strong>Cod. Cliente<strong></strong></strong></td>
     <td width="41%" bgcolor="#999999"><strong>Nome<strong></strong></strong></td>
     <td width="12%" bgcolor="#999999"><strong>Data</strong></td>
     <td width="8%" bgcolor="#999999"><strong>Cotacao</strong></td>
     <td width="13%" bgcolor="#999999"><strong>Vendedor<strong></strong></strong></td>
   </tr>
   <?
	$ide = $_GET['ide'];		
				
			
	$sql_lista = "SELECT * FROM pedido WHERE id = '$ide' ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	//if ($num_lista > 0) {
		//$total_carrinho = 0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
			//$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
			
			// Pegando data e hora.
			$data2 = $reg_lista['data_car'];
			//$hora = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";
			
			$frete = $reg_lista['frete'];
			$total_nota  = $reg_lista['total_nota'];
			
			?>
   <tr>
     <td width="13%" bgcolor="#CCCCCC"><?=$reg_lista['id']?></td>
     <td width="13%" bgcolor="#CCCCCC"><?=$reg_lista['controle_cli']?></td>
     <td width="41%" bgcolor="#CCCCCC"><?=$reg_lista['nome_cli']?></td>
     <td width="12%" bgcolor="#CCCCCC"><?=$novadata ?></td>
     <td width="8%" bgcolor="#CCCCCC"><?=$reg_lista['cotacao_id']?></td>
     <td width="13%" bgcolor="#CCCCCC"><?=$reg_lista['vendedor']?></td>
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
              <td width="47%"><strong>Descripcion<strong></strong></strong></td>
              <td width="11%"><strong>Cod.<strong></strong></strong></td>
              <td width="16%"><div align="right"><strong>Valor</strong></div></td>
			  <td width="11%"><div align="right"><strong>Subtotal</strong></div></td>
   </tr>
			
            <?
	
			
	$sql_lista = "SELECT * FROM itens_pedido WHERE id_pedido = '$ide' ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	//if ($num_lista > 0) {
		$total_carrinho = 0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
			$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
			
			?>
			 <tr>
              <td width="8%"><?=$reg_lista['qtd_produto']?></td>
              <td width="47%"><?=substr($reg_lista['descricao_prod'],0,34)?></td>
              <td width="11%">
                <div align="left">
                  <?=$reg_lista['referencia_prod']?>
                </div></td>
              <td width="16%"><div align="right">
                <?=guarani($reg_lista['prvenda'])?>
              </div></td>
			  <td width="11%"><div align="right">
			    <?=guarani($reg_lista['prvenda']*$reg_lista['qtd_produto'])?>
			  </div></td>
             </tr>
			
			<?
		//}
	}
	?>
            <tr>
              <td height="23" colspan="3" rowspan="4"><div align="right"></div></td>
              <td height="10">&nbsp;</td>
              <td height="-3">&nbsp;</td>
              <td width="7%" rowspan="4">&nbsp;</td>
            </tr>
            <tr>
              <td height="10"><div align="right"><strong>Total Itens:&nbsp;</strong></div></td>
              <td height="-3"><strong><strong>
              </strong>
                <div align="right"><strong>
                <?=guarani($total_carrinho)?>                
                </strong></div>
                <strong><strong></strong></td>
            </tr>
            <tr>
              <td height="11"><div align="right"><strong>Frete:</strong></div></td>
              <td height="-1"><div align="right"><strong>
              <?=guarani($frete)?>
              </strong></div></td>
            </tr>
            <tr>
              <td height="23"><div align="right"><strong>Total Geral:</strong></div></td>
              <td height="23"><div align="right"><strong>
              <?=guarani($total_nota)?>
              </strong></div></td>
            </tr>
</table>
		  
		  
		  
		  
		  
		  
<p>&nbsp;</p>
<hr width="100%" size="14" noshade="noshade" />
		<p>&nbsp;        </p>
</body>
</html>


</body>

</html>