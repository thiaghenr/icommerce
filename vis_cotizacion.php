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
  window.location.href='pesquiza_cot.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='pesquiza_cot.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cotizacion - <? echo $title ?></title>
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
<p align="center" class="Estilo13"><? echo $fantasia ?></p>
<table width="100%" border="0">
  <tr>
    <td width="10%" bgcolor="#FF0000"><div align="left" class="Estilo12">
      <div align="center" class="Estilo14">COTIZACION</div>
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
				
			
	$sql_listas = "SELECT * FROM cotacao WHERE id = '$ide' ";
	$exe_listas = mysql_query($sql_listas, $base);
	$num_listas = mysql_num_rows($exe_listas);
	//if ($num_lista > 0) {
		//$total_carrinho = 0;
			while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)) {
			//$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
			
			// Pegando data e hora.
			$data2 = $reg_listas['data_car'];
			//$hora = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";
			
			?>
   <tr>
     <td width="13%" bgcolor="#FFCCFF"><?=$reg_listas['id']?></td>
     <td width="13%" bgcolor="#FFCCFF"><?=$reg_listas['controle_cli']?></td>
     <td width="13%" bgcolor="#FFCCFF"><?=$reg_listas['nome_cli']?></td>
     <td width="13%" bgcolor="#FFCCFF"><?=$novadata ?></td>
     <td width="13%" bgcolor="#FFCCFF"><?=$reg_listas['vendedor']?></td>
   </tr>
   <?
		//}
	//}
	?>
   <tr>
     <td>&nbsp;</td>
   </tr>
</table>
 <table border="1" bordercolor="#000000" style="border-collapse: collapse" width="100%">
            <tr>
              <td width="8%"><strong>Cant</strong></td>
              <td width="11%"><strong>Codigo<strong></strong></strong></td>
              <td width="49%"><strong>Descripcion<strong></strong></strong></td>
              <td width="13%"><div align="right"><strong>Precio</strong></div></td>
			  <td width="19%"><div align="right"><strong>Subtotal</strong></div></td>
   </tr>
			
            <?
	
			
	$sql_lista = "SELECT * FROM itens_cotacao WHERE id_cotacao = '$ide' ORDER BY referencia_prod";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	//if ($num_lista > 0) {
		$total_carrinho = 0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
			$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
			
			?>
			 <tr>
              <td width="8%"><?=$reg_lista['qtd_produto']?></td>
              <td width="11%"><?=$reg_lista['referencia_prod']?></td>
              <td width="49%"><?=$reg_lista['descricao_prod']?></td>
              <td width="13%"><div align="right">
                <?=guarani( $reg_lista['prvenda'])?>
              </div></td>
			  <td width="19%"><div align="right">
			    <?=guarani($reg_lista['prvenda']*$reg_lista['qtd_produto'])?>
			  </div></td>
             </tr>
			
			<?
		}
	}
	?>
            <tr>
              <td height="23" colspan="3"><div align="right"></div></td>
              <td height="23">&nbsp;</td>
              <td height="23"><strong><strong>
              <div align="right"><strong>Total:&nbsp;</strong>
                <?=guarani($total_carrinho)?>
              </div></td>
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