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
<link href="tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<script>
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='\result_pedido.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='\vis_vendas.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Vendas - <? echo $title ?></title>
<style type="text/css">
<!--
.Estilo13 {
	font-size: 36px;
	font-weight: bold;
}
.Estilo14 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
}
body {
	background-image: url();
}
.Estilo15 {color: #000000}
.Estilo26 {font-family: Georgia, "Times New Roman", Times, serif; font-weight: bold; font-size: 12px; }
.Estilo27 {font-family: Georgia, "Times New Roman", Times, serif; font-size: 12px; }
.Estilo31 {font-size: 12px; font-weight: bold; }
.Estilo32 {font-size: 12px}
.Estilo33 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<p align="center" class="Estilo13"><? echo $cabecalho ?></p>
<table width="100%" border="0">
  <tr>
    <td width="10%" ></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="0">
   <tr>
     <td width="9%" class="selected"><p class="Estilo26">Venta</p></td>
     <td width="18%" class="selected"><p class="Estilo26">Cod. Cliente</p></td>
     <td width="39%" class="selected"><p class="Estilo26">Nome</p></td>
     <td width="12%" class="selected"><p class="Estilo26">Data</p></td>
     <td width="9%" class="selected"><p class="Estilo26">Situacao</p></td>
     <td width="13%" class="selected"><p class="Estilo26">Vendedor</p></td>
   </tr>
   <?
	$ide = $_GET['ide'];
	$num = $_GET['num'];		
				
/*			
	$sql_lista = "SELECT * FROM venda WHERE id = '$num' ";
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
	*/		
			$sql_listas = "SELECT v.*, c.*  FROM venda v, clientes c WHERE v.id = '$num' AND  v.controle_cli = c.controle  ";

	$exe_listas = mysql_query($sql_listas, $base);
	$num_listas = mysql_num_rows($exe_listas);
	
	while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)) {	
	
			//Pegando data e hora.
			$data2 = $reg_listas['data_venda'];
			$hora2 = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";
		
			$venda = $reg_listas['id'] ;
			?>
   <tr>
     <td width="9%">        <p class="Estilo27">
       <?=$reg_listas['id']?>        
       <br>     
     </p></td>
     <td width="18%">        <p class="Estilo27">
       <?=$reg_listas['controle_cli']?>        
       <br>     
     </p></td>
     <td width="39%">        <p class="Estilo27">
       <?=$reg_listas['nome']?>        
       <br>     
     </p></td>
     <td width="12%">        <p class="Estilo27">
       <?=$novadata ?>        
       <br>     
     </p></td>
     <td width="9%">        <p class="Estilo27">
       <?=$reg_listas['st_venda']?>        
       <br>     
     </p></td>
     <td width="13%">        <p class="Estilo27">
       <?=$reg_listas['vendedor']?>        
       <br>     
     </p></td>
   </tr>
   <?
		//}
	//}
	?>
   <tr>
     <td height="36">&nbsp;</td>
   </tr>
</table>
 <table width="100%" border="0" bordercolor="#ECE9D8">
            <tr>
              <td width="11%" class="selected"><span class="Estilo31">Qtd</span></td>
              <td width="50%" class="selected"><span class="Estilo31">Descripcion</span></td>
              <td width="16%" class="selected"><span class="Estilo31">Cod.</span></td>
              <td width="12%" class="selected"><div align="right" class="Estilo31">Valor</div></td>
			  <td width="11%" class="selected"><div align="right" class="Estilo31">Subtotal</div></td>
   </tr>
			
            <?
	
			
	$sql_lista = "SELECT * FROM itens_venda WHERE id_venda = '$venda' ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	//if ($num_lista > 0) {
		$total_carrinho = 0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
			$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
			
			?>
			 <tr>
              <td width="11%"><span class="Estilo32">
              <?=$reg_lista['qtd_produto']?>
              </span></td>
              <td width="50%"><span class="Estilo32">
              <?=substr($reg_lista['descricao_prod'],0,35)?>
              </span></td>
              <td width="16%"><span class="Estilo32">
              <?=$reg_lista['referencia_prod']?>
              </span></td>
              <td width="12%"><div align="right" class="Estilo32">
                <?=formata($reg_lista['prvenda'])?>
              </div></td>
			  <td width="11%"><div align="right" class="Estilo32">
			    <?=formata($reg_lista['prvenda']*$reg_lista['qtd_produto'])?>
			  </div></td>
             </tr>
			
			<?
		}
	}
	?>
            <tr>
              <td height="23" colspan="3"><div align="right" class="empty"></div></td>
              <td height="23"><div align="right" class="Estilo33">Total:&nbsp;</div></td>
              <td height="23"><strong><strong>
              <div align="right" class="Estilo33">
                <?=guarani($total_carrinho)?>
              </div></td>
              <td width="0%">&nbsp;</td>
            </tr>
</table>
		  
		  
		  
		  
		  
		  
          <p>&nbsp;</p>
</body>
</html>


</body>

</html>