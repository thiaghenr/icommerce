<?
require_once("verifica_login.php");
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
  window.location.href='';
 }
 else if(lugar=='Nueva'){
  window.location.href='\imprime_locacao.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Imprimir Locaçao - <? echo $cabecalho; ?></title>
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
      <div align="center" class="Estilo14">COTIZACION</div>
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="0" width="100%">
   <tr>
     <td width="13%" bgcolor="#ECE9D8"><strong>Pedido</strong></td>
     <td width="13%" bgcolor="#ECE9D8"><strong>Cod. Cliente<strong></strong></strong></td>
     <td width="41%" bgcolor="#ECE9D8"><strong>Nome<strong></strong></strong></td>
     <td width="12%" bgcolor="#ECE9D8"><strong>Data</strong></td>
     <td width="8%" bgcolor="#ECE9D8"><strong>Situacao</strong></td>
     <td width="13%" bgcolor="#ECE9D8"><strong>Vendedor<strong></strong></strong></td>
   </tr>
   <?
	$ide = $_GET['ide'];		
				
			
	$sql_lista = "SELECT * FROM cotacao WHERE id = '$ide' ";
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
			
			?>
   <tr>
     <td width="13%" bgcolor="#FFCCFF"><?=$reg_lista['id']?></td>
     <td width="13%" bgcolor="#FFCCFF"><?=$reg_lista['controle_cli']?></td>
     <td width="41%" bgcolor="#FFCCFF"><?=$reg_lista['nome_cli']?></td>
     <td width="12%" bgcolor="#FFCCFF"><?=$novadata ?></td>
     <td width="8%" bgcolor="#FFCCFF"><?=$reg_lista['situacao']?></td>
     <td width="13%" bgcolor="#FFCCFF"><?=$reg_lista['vendedor']?></td>
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
              <td width="6%"><strong>Cant</strong></td>
              <td width="16%"><strong>Cod Producto</strong></td>
              <td width="50%"><strong>Descripcion</strong></td>
              <td width="13%"><strong>Loca&ccedil;&atilde;o</strong></td>
			  <td width="9%">&nbsp;</td>
   </tr>
			
            <?
	
			
	$sql_lista = "SELECT ip.*, p.* FROM itens_cotacao ip, produtos p WHERE ip.id_cotacao = '$ide' AND  p.Codigo = ip.referencia_prod ORDER BY referencia_prod ASC ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	//if ($num_lista > 0) {
		
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
						
			?>
			 <tr>
              <td width="6%"><?=$reg_lista['qtd_produto']?></td>
              <td width="16%"><?=$reg_lista['referencia_prod']?></td>
              <td width="50%"><?=$reg_lista['descricao_prod']?></td>
              <td width="13%"><?=$reg_lista['local']?></td>
			  <td width="9%">&nbsp;</td>
             </tr>
			
			<?
		//}
	}
	?>
            <tr>
              <td height="23" colspan="3"><div align="right"></div></td>
              <td height="23"><strong><strong></strong></strong></td>
              <td height="23"><strong><strong></td>
              <td width="6%">&nbsp;</td>
            </tr>
</table>
		  
		  
		  
		  
		  
		  
          <p>&nbsp;</p>
      </table>
</p>
		<hr color="#ECE9D8" width="100%" size="14" noshade="noshade" />
		<p><a href="javaScript:window.print()">Imprimir</a>&nbsp;
		  <input type="button" value="Nueva pesquiza" name="LINK12" onclick="navegacao('Nueva')" />
		</p>
</body>
</html>


</body>

</html>