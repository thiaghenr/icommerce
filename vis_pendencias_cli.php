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
  window.location.href='\pendencias_cli.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='\pendencias_cli.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pendencia Cliente - <? echo $cabecalho; ?></title>
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
.Estilo13 {
	font-size: 36px;
	font-weight: bold;
}
.Estilo14 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<p align="center" class="Estilo13"><? echo $cabecalho; ?></p>
<?php

if ($_GET['acao'] == "del") {
		if (isset($_GET['id'])) {
			if ($_GET['id']) {
				$id_prod = addslashes(htmlentities($_GET['id']));
	$sql_lista2 = "SELECT * FROM itens_pendencias WHERE produtos_codigo = '$id_prod' "; 
	$exe_lista2 = mysql_query($sql_lista2, $base);
		
	$reg_lista2 = mysql_fetch_array($exe_lista2, MYSQL_ASSOC) ;
				
							
	$sql_del = "DELETE FROM itens_pendencias WHERE produtos_codigo = '$id_prod'   "; 
				$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
				}
			}
		}


?>

<table width="100%" border="0">
  <tr>
    <td width="10%" bgcolor="#OEEAEO"><div align="left" class="Estilo12">
      <div align="center" class="Estilo14">PRODUTOS PENDENTES PARA O CLIENTE </div>
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
     <td width="8%" bgcolor="#999999"><strong>Situacao</strong></td>
     <td width="13%" bgcolor="#999999"><strong>Vendedor<strong></strong></strong></td>
   </tr>
   <?
	$ide = $_GET['ide'];		
				
			
	$sql_listaz = "SELECT p.*, c.controle,nome FROM pendencias p, clientes c WHERE p.id = '$ide' AND p.clientes_controle = c.controle ";
	$exe_listaz = mysql_query($sql_listaz, $base);
	$num_listaz = mysql_num_rows($exe_listaz);
	//if ($num_lista > 0) {
		//$total_carrinho = 0;
			$reg_listaz = mysql_fetch_array($exe_listaz, MYSQL_ASSOC) ;
			//$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
			
			// Pegando data e hora.
			$data2 = $reg_listaz['data'];
			//$hora = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";
			
			
			
			?>
   <tr>
     <td width="13%" bgcolor="#CCCCCC"><?=$reg_listaz['id']?></td>
     <td width="13%" bgcolor="#CCCCCC"><?=$reg_listaz['clientes_controle']?></td>
     <td width="41%" bgcolor="#CCCCCC"><?=$reg_listaz['nome']?></td>
     <td width="12%" bgcolor="#CCCCCC"><?=$novadata ?></td>
     <td width="8%" bgcolor="#CCCCCC"><?=$reg_listaz['st_pendencia']?></td>
     <td width="13%" bgcolor="#CCCCCC"><?=$reg_listaz['usuario_id']?></td>
   </tr>
 
   <tr>
     <td>&nbsp;</td>
   </tr>
</table>
 <table border="0" width="100%">
            <tr>
              <td width="7%"><strong>Qtd</strong></td>
              <td width="13%"><strong>Codigo<strong></strong></strong></td>
              <td width="45%"><strong>Descricao<strong></strong></strong></td>
              <td width="14%"><div align="right"><strong>Valor</strong></div></td>
			  <td width="12%"><div align="right"><strong>Subtotal</strong></div></td>
			  <td width="7%">&nbsp;</td>
   </tr>
			
            <?
	
			
	$sql_lista = "SELECT it.*, p.Codigo,Descricao FROM itens_pendencias it, produtos p WHERE it.pendencias_id = '$ide' AND it.produtos_codigo = p.Codigo ORDER BY it.produtos_codigo ASC ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	//if ($num_lista > 0) {
		$total_carrinho = 0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
			$total_carrinho += ($reg_lista['vl_preco']*$reg_lista['qtd']);
			
			?>
			 <tr>
              <td width="7%"><?=$reg_lista['qtd']?></td>
              <td width="13%"><?=$reg_lista['produtos_codigo']?></td>
              <td width="45%">
                <div align="left">
                  <?=substr($reg_lista['Descricao'],0,45)?>
               </div></td>
              <td width="14%"><div align="right">
                <?=guarani($reg_lista['vl_preco'])?>
              </div></td>
			  <td width="12%"><div align="right">
			    <?=guarani($reg_lista['vl_preco']*$reg_lista['qtd'])?>
			  </div></td>
			  <td width="7%"> <div align="center"><a href="vis_pendencias_cli.php?acao=del&id=<?=$reg_lista['Codigo']?>&ide=<?=$reg_listaz['id']?>"><img src="images/delete.gif" alt="Eliminar da Pendencia" width="12" height="14" border="0"/></a> </div></td>
             </tr>
			
			<?
		//}
	}
	?>
            <tr>
              <td height="23" colspan="3"><div align="right"></div></td>
              <td height="23"><div align="right"><strong>Total:&nbsp;</strong></div></td>
              <td><div align="right">
                <?=guarani($total_carrinho)?>
              </div></td>
              <td height="23"><strong><strong></td>
              <td width="2%">&nbsp;</td>
            </tr>
</table>
		  
		  
		  
		  
		  
	    <p>&nbsp;</p>
		<p>&nbsp;</p>
		<p><a href="javaScript:window.print()">Imprimir</a>&nbsp;
		  <input type="button" value="Nueva pesquiza" name="LINK12" onclick="navegacao('Nueva')" />
</p>
		<hr width="100%" size="14" noshade="noshade" />
		<p>&nbsp;        </p>
		
</body>
</html>



</html>