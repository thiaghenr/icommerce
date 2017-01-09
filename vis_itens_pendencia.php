<?
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
  window.location.href='pendencias_cli.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='pendencias_cli.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pendencias - <? echo $cabecalho; ?></title>
<style type="text/css">
<!--
.Estilo13 {
	font-size: 36px;
	font-weight: bold;
}
.Estilo14 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<p align="center" class="Estilo13"><? echo $cabecalho; ?></p>
<table width="100%" border="0">
  <tr>
    <td width="10%" bgcolor="#FF0000"><div align="left" class="Estilo12">
      <div align="center" class="Estilo14">PENDENCIAS PARA O CLIENTE </div>
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="0" width="100%">
   <tr>
     <td width="5%" bgcolor="#ECE9D8"><strong>Cotizacion</strong></td>
     <td width="13%" bgcolor="#ECE9D8"><strong>Cod. Cliente<strong></strong></strong></td>
     <td width="33%" bgcolor="#ECE9D8"><strong>Nome<strong></strong></strong></td>
     <td width="13%" bgcolor="#ECE9D8"><strong>Data</strong></td>
     <td width="13%" bgcolor="#ECE9D8"><strong>Vendedor<strong></strong></strong></td>
   </tr>
   <?
	$ide = $_GET['ide'];		
				
			
	$sql_listas = "SELECT p.*, c.nome FROM pendencias p, clientes c WHERE p.id = '$ide' AND c.controle = p.clientes_controle ";
	$exe_listas = mysql_query($sql_listas, $base);
	$num_listas = mysql_num_rows($exe_listas);
	//if ($num_lista > 0) {
		//$total_carrinho = 0;
			while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)) {
			//$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
			
			// Pegando data e hora.
			$data2 = $reg_listas['data'];
			//$hora = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";
			
			?>
   <tr>
     <td width="13%" bgcolor="#FFCCFF"><?=$reg_listas['id']?></td>
     <td width="13%" bgcolor="#FFCCFF"><?=$reg_listas['clientes_controle']?></td>
     <td width="13%" bgcolor="#FFCCFF"><?=$reg_listas['nome']?></td>
     <td width="13%" bgcolor="#FFCCFF"><?=$novadata ?></td>
     <td width="13%" bgcolor="#FFCCFF"><?=$reg_listas['vendedor']?></td>
   </tr>
   <?
		//}
	}
	?>
   <tr>
     <td>&nbsp;</td>
   </tr>
</table>
 <table border="1" width="100%">
   <tr>
     <td width="6%"><strong>Cant</strong></td>
     <td width="9%"><strong>Codigo<strong></strong></strong></td>
     <td width="59%"><strong>Descripcion<strong></strong></strong></td>
     <td width="8%"><strong>Precio</strong></td>
     <td width="9%"><strong>Subtotal</strong></td>
	 <td width="9%"><strong>Remover</strong></td>
   </tr>
   <?
	
			
	$sql_lista = "SELECT it.*, p.Descricao FROM itens_pendencias it, produtos p WHERE it.pendencias_id = '$ide' AND p.Codigo = it.produtos_codigo ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	//if ($num_lista > 0) {
		$total_carrinho = 0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
			$total_carrinho += ($reg_lista['vl_preco']*$reg_lista['qtd']);
			
			?>
   <tr>
     <td width="6%"><?=$reg_lista['qtd']?></td>
     <td width="9%"><?=$reg_lista['produtos_codigo']?></td>
     <td width="59%"><?=$reg_lista['Descricao']?></td>
     <td width="8%"><?=guarani( $reg_lista['vl_preco'])?></td>
     <td width="9%"><?=guarani($reg_lista['vl_preco']*$reg_lista['qtd'])?></td>
	  <td width="9%"><a href="vis_itens_pendencia.php?acao=del&amp;id=<?=$reg_lista['produtos_codigo']?>"><img src="images/delete.gif" alt="rem" width="12" border="0"/></a></td>
	 
   </tr>
   <?
		//}
	}
	?>
   <tr>
     <td height="23" colspan="3"><div align="right"></div></td>
     <td height="23"><strong>Total:&nbsp;</strong></td>
     <td height="23"><strong><?=guarani($total_carrinho)?><strong></strong></strong></td>
     <td width="9%">&nbsp;</td>
   </tr>
 </table>
 <p>&nbsp;</p>
      </table>
</p>
		<p>&nbsp;</p>
<p><a href="javaScript:window.print()"></a>&nbsp;</p>
		<hr width="100%" size="14" noshade="noshade" />
		<p><a href="javaScript:window.print()">Imprimir</a> 
		  <input type="button" value="Nueva pesquiza" name="LINK12" onclick="navegacao('Nueva')" />
		</p>
</body>
</html>


</body>

</html>