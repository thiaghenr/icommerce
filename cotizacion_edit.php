<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora

$ide = $_GET['ide'];
if(empty($ide))
$ide = $_POST['ide'];
$_SESSION['ide'] = $ide;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/clearbox.css" rel="stylesheet" type="text/css" />
<script src="js/clearbox.js" type="text/javascript"></script>

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
<style type="text/css">
<!--
.Estilo15 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cotizacion- <? echo $title ?></title>
<style type="text/css">
<!--
.Estilo14 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo16 {color: #0000FF}
-->
</style>
</head>

<body>
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
     <td width="5%" bgcolor="#999999"><span class="Estilo15">Cotizacion</span></td>
     <td width="13%" bgcolor="#999999"><span class="Estilo15">Cod. Cliente</span></td>
     <td width="33%" bgcolor="#999999"><strong><span class="Estilo16">Nome</span></strong></td>
     <td width="13%" bgcolor="#999999"><span class="Estilo16"><strong>Data</strong></span></td>
     <td width="13%" bgcolor="#999999"><strong><span class="Estilo16">Vendedor</span></strong></td>
   </tr>
   <?
	$sql_listas = "SELECT * FROM cotacao WHERE id = '$ide' ";
	$exe_listas = mysql_query($sql_listas, $base);
	$num_listas = mysql_num_rows($exe_listas);
	
	$cod_cliente;
	while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)) {
			$cod_cliente = $reg_listas['controle_cli'];
			$cod_cotacao = $reg_listas['id'];
			//$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
			// Pegando data e hora.
			$data2 = $reg_listas['data_car'];
			//$hora = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";
	?>
   <tr>
     <td width="13%" bgcolor="#CCCCCC"><?=$cod_cotacao?></td>
     <td width="13%" bgcolor="#CCCCCC"><?=$cod_cliente?></td>
     <td width="13%" bgcolor="#CCCCCC"><?=$reg_listas['nome_cli']?></td>
     <td width="13%" bgcolor="#CCCCCC"><?=$novadata ?></td>
     <td width="13%" bgcolor="#CCCCCC"><?=$reg_listas['vendedor']?></td>
   </tr>
   <?}?>
   <tr>
     <td>&nbsp;</td>
   </tr>
</table>

<table width="100%" border="0" align="center">
 
  <tr>
    <th colspan="6" align="center" valign="middle" bgcolor="#DAE6F8"><p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Adicionar Productos </font></strong></p></th>
  </tr>
  <tr>
    <th colspan="6" align="center" valign="middle" bgcolor="#CECFCE"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="154" bordercolor="#000000" bgcolor="#CCCCCC"><div><strong><font color="#0000FF">Codigo</font></strong></div></td>
        <td width="300" bordercolor="#000000" bgcolor="#CECFCE"><div><strong><font color="#0000FF">Descripci&oacute;n</font></strong></div></td>
        <td width="398" bordercolor="#000000" bgcolor="#CECFCE">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#CECFCE"><form action="res_pes_prodc_edit.php?ide=<?=$_SESSION['ide']?>" rel="clearbox(850,600,click)" method="post" name="referencia_prod" id="referencia_prod">
          <input type="text2" name="ref" id='ref' />
        </form></td>
        <td bgcolor="#CECFCE"><form action="res_pes_prodc_edit.php?ide=<?=$_SESSION['ide']?>" rel="clearbox(850,600,click)" method="post" name="descricao_prod" id="descricao_prod">
          <input type="text" name="desc" size="50" />
        </form></td>
      </tr>
    </table></th>
  </tr>
 
  <tr>
    <td height="197" colspan="5" valign="top" bgcolor="#DAE6F8"><p>
      <?
if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "add") {
		if (isset ($_GET['id'])) {
			if ($_GET['id']) {
				$id_prod = addslashes(htmlentities($_GET['id']));
				$sql_cont = "SELECT COUNT(*) AS n_prod FROM itens_cotacao WHERE referencia_prod = '$id_prod' AND id_cotacao = '$ide'  ";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error().'-'.$sql_cont);
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
			
				if ($reg_cont['n_prod'] == 0) {
					$sql_prod = "SELECT * FROM produtos WHERE Codigo = '$id_prod'";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					if ($num_prod > 0) {
					
					$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );
				
						$qtd_ini =  1;
						
						$sql_add = "INSERT INTO itens_cotacao (id_cotacao, referencia_prod, descricao_prod, prvenda, qtd_produto)
									VALUES ('".$cod_cotacao."', '".mysql_escape_string($reg_prod['Codigo'])."', '".mysql_escape_string($reg_prod['Descricao'])."', '".$reg_prod['valor_c']."', '".$qtd_ini."' )";

						$exe_add = mysql_query($sql_add) or die  (mysql_error().'-'.$sql_add);
					}
				}
			}
		}
	}
	if ($_GET['acao'] == "del") {
		if (isset($_GET['ref'])) {
			if ($_GET['ref']) {
			$id_prod = addslashes(htmlentities($_GET['ref']));
			
			$sql_del = "DELETE FROM itens_cotacao WHERE referencia_prod = '$id_prod'  AND id_cotacao = '$ide' ";
			$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
			
			}	
		}	
	}
	if ($_GET['acao'] == "altera") {
		if (isset($_POST['qtd'])) {
			if (is_array($_POST['qtd'])) {
				foreach ($_POST['qtd'] as $referencia_prod => $qtd ) {
						//PESQUISA O TOTAL  DE PRODUTOS QUE ESTA NA TABELA ITENS_PEDIDOS
						$sql_pes_qtd_itens_prod	= "SELECT qtd_produto FROM itens_cotacao WHERE referencia_prod = '$referencia_prod' ";
						$rs_pes_qtd_itens_prod 	= mysql_query($sql_pes_qtd_itens_prod) or die (mysql_error().'-'.$sql_pes_qtd_itens_prod);
						$row_pes_qtd_itens_prod = mysql_fetch_array($rs_pes_qtd_itens_prod);
						$total_atual_itens_prod = $row_pes_qtd_itens_prod['qtd_produto'];
													
	
						//ATUALIZA QUANTIDAE ITENS_PEDIDO
						$sql_alt = "UPDATE itens_cotacao SET qtd_produto = '$qtd' WHERE
									 referencia_prod = '$referencia_prod' ";
						$exe_alt = mysql_query($sql_alt, $base) or die (mysql_error()) ;
								 
						
						
					}
				}
			}
		}
		if (($_POST['prvenda'])) {
			if (is_array($_POST['prvenda'])) {
				foreach ($_POST['prvenda'] as $referencia_prod => $prc) {
						$sql_per = "UPDATE itens_cotacao SET prvenda = '$prc' WHERE
									 referencia_prod = '$referencia_prod' ";
						$exe_per = mysql_query($sql_per) or die (mysql_error()) ;
			
				
			}
		}
	}
}

?>
    </p>
        <form action="cotizacion_edit.php?acao=altera" method="post" />
		<input type='hidden' name='ide' id='ide' value='<? echo $ide ?> '/>
		<input type='hidden' name='codigo_cliente' id='codigo_cliente' value='<? echo $cod_cliente ?> '/>
		<input type='hidden' name='cod_cotacao' id='cod_cotacao' value='<? echo $cod_cotacao?> '/>		
		
		<table border="1" width="100%">
          <tr>
            <td width="6%"><strong>Rem.</strong></td>
            <td width="9%"><strong>REF.<strong></strong></strong></td>
            <td width="44%"><strong>PRODUCTO<strong></strong></strong></td>
            <td width="12%"><strong>PRECIO</strong></td>
            <td width="7%"><strong>CANT.<strong></strong></strong></td>
            <td width="10%"><strong>SUBTOTAL.<strong></strong></strong></td>
		  </tr>
          <?
			//if(!$menu){

				$sql_lista = "SELECT * FROM itens_cotacao WHERE id_cotacao = '$ide'  ";

				$exe_lista = mysql_query($sql_lista, $base) or die (mysql_error()."- $sql_lista");
				$num_lista = mysql_num_rows($exe_lista);
				if ($num_lista > 0) {
					$total_carrinho = 0;
					$i=0;
					while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
						$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
						
						$sql_stok = "SELECT Estoque FROM produtos WHERE Codigo = '".$reg_lista['referencia_prod']."'  ";
		                $exe_stok = mysql_query($sql_stok) or die (mysql_error()."- $sql_stok"); 
						$row_stok = mysql_fetch_array($exe_stok,MYSQL_ASSOC);
						
						$sql_pedido = "UPDATE cotacao SET total_nota = '".$total_carrinho."' WHERE id = '$ide' ";
						$exe_pedido = mysql_query($sql_pedido);
						

		  ?>
          <tr>
            <td width="6%">
				<a href="cotizacion_edit.php?acao=del&ref=<?=$reg_lista['referencia_prod']?>&ide=<?=$_SESSION['ide']?>"><img src="images/delete.gif" alt="delete" width="12" border="0"/></a></td>
            <td width="9%">
				<?=$reg_lista['referencia_prod']?>
			<input type="hidden" size="9" name="ref_prd_cont[<? echo $i?>]" value="<?=$reg_lista['referencia_prod']?>" />			</td>
            <td width="44%"><?=substr($reg_lista['descricao_prod'],0,33)?></td>
            <td width="12%">
				<input type="text" size="9" name="prvenda[<?=$reg_lista['referencia_prod']?>]" id="prvenda_<?=$reg_lista['referencia_prod']?>" value="<?=$reg_lista['prvenda']?>"/>
				<input type="hidden" size="9" name="prvenda_cont[<? echo $i?>]" value="<?=$reg_lista['prvenda']?>"  />			</td>
            <td width="7%">
				<input type="text" size="3" name="qtd[<?=$reg_lista['referencia_prod']?>]" id="qtd_<?=$reg_lista['referencia_prod']?>" value="<?=$reg_lista['qtd_produto']?>"/>
				<input type="hidden" size="3" name="qtd_cont[<? echo $i?>]" value="<?=$reg_lista['qtd_produto']?>"/>			</td>
            <td width="10%"><?=guarani($reg_lista['prvenda']*$reg_lista['qtd_produto'])?></td>
		  </tr>
          <?
				$i++;
					}
				}
			//}
			//}
		?>
          <tr bgcolor="#FFFFFF" >
            <td height="23" colspan="5"><div align="right">
              Total&nbsp;</div></td>
            <td><?=guarani($total_carrinho)?></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>
            <input name="enviar" id='enviar' value="Enviar" type="submit" /></td>
            <td colspan="5"><input name="button" type="button" onclick="window.close()" value="Abandonar" /></td>
          </tr>
          <tr>
            <td height="2">            </td>
          </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
		
		<!--  <input type="button" value="Nueva pesquiza" name="LINK12" onclick="navegacao('Nueva')" /> -->
</p>
		<input type="button" value="Nova Pesquisa" name="LINK12" onclick="navegacao('Nueva')" />
		<hr width="100%" size="14" noshade="noshade" />
		<p>&nbsp;        </p>
</body>
</html>