<?php
	require_once("verifica_login.php");
	require_once("biblioteca.php");
	include "config.php";
	conexao();

	$data= date("Y/m/d"); // captura a data
	$hora= date("H:i:s"); //captura a hora

	$ide = $_GET['ide'];
	$nome_user = $_SESSION['nome_user'];
	$id = $_GET['id_prod'];
?>
<?php
	if(!empty($ide)){
			
			//$sql = "SELECT c.*, f.* FROM compras c, fornecedor f WHERE c.id = '$ide' AND f.Codigo = c.fornecedor_id " ;	
			$sql = "SELECT c.vl_total_fatura,nm_fatura,data_lancamento, c.id as compra_id,  f.* FROM compras c, proveedor f WHERE c.id = '$ide' AND f.id = c.fornecedor_id " ;	
			$rs = mysql_query($sql);
			$num_reg = mysql_num_rows($rs);
			if($num_reg > 0){
				$row = mysql_fetch_array($rs);
			
				$_SESSION['compra_id'] = $row['compra_id'];
				$_SESSION['fornecedor_codigo'] = $row['id'];
				$_SESSION['Nome'] = $row['nome'];
				$_SESSION['telefoneCli'] = $row['telefonecom'];
				$_SESSION['data_lancamento'] = $row['data_lancamento'];
				$_SESSION['vl_total_fatura'] = $row['vl_total_fatura'];
				$_SESSION['nm_fatura'] = $row['nm_fatura'];
				$_SESSION['data_lancamento'] = $row['data_lancamento'];
				
			}
		}
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="/js/funcoes.js"></script>
<script type="text/javascript">
    function nextFocus(event,idForm,idCampo){
        document.getElementById('campoFoco').value = idCampo;
        enter(event,idForm);
    }

    function setaFoco(){
        campoSetFoco = "<?=$_POST['campoFoco']?>";
		
		acao = '<?=$_GET['acao']?>'
		
		ide = '<?=$_GET['ide']?>'
		
		prodId = '<?=$_GET['id']?>'
		
		precoId = 'prvenda_<?=$_GET['id']?>'

		if(acao=='del'){
			document.getElementById('ref').focus();
		}
		else{
			//Coloca Foco no campo referencia
			if(ide.length > 0 )
				document.getElementById('ref').focus();

			//Coloca foco no campo preco
			if(prodId.length > 0){
				document.getElementById(precoId).focus();
				document.getElementById(precoId).select();
			}

	        if(campoSetFoco.length > 0){
	            if(campoSetFoco.indexOf('qtd_') > -1){
	                document.getElementById('ref').focus();
	            }
	            else{
	                id_qtde_foco ="qtd_"+campoSetFoco.substr(8);
	                document.getElementById(id_qtde_foco).focus();
					document.getElementById(id_qtde_foco).select();
	            }
	        }
		}
	}
	
	function finaliza(){
		document.getElementById('frmItens').action = 'vis_compra_edit.php?acao=insere';
		document.getElementById('frmItens').submit();
	}
	
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='\vis_compra_edit.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='\vis_compra_edit.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Entrada de Produtos - <? echo $title ?></title>
<style type="text/css">
<!--
.Estilo3 {color: #FFFFFF}
.Estilo4 {color: #0000FF}
.style3 {font-size: 12px; font-weight: bold; }
.style4 {font-size: 12px}
-->
    </style>
</head>
<body onload='setaFoco()'>

<table width="100%" border="0">
  <tr>
    <td width="10%" bgcolor="#FF0000"><div align="left" class="Estilo12">
      <div align="center" class="Estilo14 Estilo3"><strong>Entrada de Produtos </strong></div>
    </div></td>
  </tr>
</table>
<table border="0" width="100%">
  <tr>
    <td width="9%" bgcolor="#ECE9D8"><span class="style3">N. Compra </span></td>
    <td width="13%" bgcolor="#ECE9D8"><span class="style3">Cod. Fornecedor </span></td>
    <td width="36%" bgcolor="#ECE9D8"><span class="style3">Fornecedor</span></td>
    <td width="16%" bgcolor="#ECE9D8"><span class="style3">Valor da Compra </span></td>
    <td width="11%" bgcolor="#ECE9D8"><span class="style3">N. Fatura </span></td>
    <td width="15%" bgcolor="#ECE9D8"><span class="style3">Data Entrada </span></td>
  </tr>
  <tr>
    <td width="9%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><span class="style4">
      <?=$_SESSION['compra_id']?>
    </span></td>
    <td width="13%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><span class="style4">
      <?=$_SESSION['fornecedor_codigo']?>
    </span></td>
    <td width="36%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><span class="style4">
      <?=substr($_SESSION['Nome'],0,30)?>
    </span></td>
    <td width="16%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><span class="style4">
      <?=guarani($_SESSION['vl_total_fatura'])?>
    </span></td>
    <td width="11%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><span class="style4">
      <?=$_SESSION['nm_fatura']?>
    </span></td>
    <td width="15%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><span class="style4">
      <?=$_SESSION['data_lancamento']?>
    </span></td>
  </tr>
</table>
<table width="100%" border="0" align="center">
 
  <tr>
 <!--    <th colspan="6" align="center" valign="middle" bgcolor="#DAE6F8"><p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Adicionar Productos </font></strong></p></th>
  </tr>
  <tr>
    <th colspan="6" align="center" valign="middle" bgcolor="#CECFCE"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="154" bordercolor="#000000" bgcolor="#CCCCCC"><div><strong><font color="#0000FF">Codigo</font></strong></div></td>
        <td width="300" bordercolor="#000000" bgcolor="#CECFCE"><div><strong><font color="#0000FF">Descripci&oacute;n</font></strong></div></td>
        <td width="398" bordercolor="#000000" bgcolor="#CECFCE">&nbsp;</td>
      </tr>
      <tr>
       <td bgcolor="#CECFCE"><form action="vis_compra_edit.php?ide=<?=$_SESSION['ide']?>" rel="clearbox(850,600,click)" method="post" name="referencia_prod" id="referencia_prod">
          <input type="text2" name="ref" id='ref' />
        </form></td>
        <td bgcolor="#CECFCE"><form action="vis_compra_edit.php?ide=<?=$_SESSION['ide']?>" rel="clearbox(850,600,click)" method="post" name="descricao_prod" id="descricao_prod">
          <input type="text" name="desc" size="50" />
        </form></td>
      </tr>
    </table></th>
  </tr>
 -->
  <tr>
    <td height="197" colspan="5" valign="top" bgcolor="#DAE6F8"><p>
      <?
if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "add") {
		if (isset ($_GET['id'])) {
			if ($_GET['id']) {
				$id_prod = addslashes(htmlentities($_GET['id']));
				$sql_cont = "SELECT COUNT(*) AS n_prod FROM itens_compra WHERE referencia_prod = '$id_prod' AND id_compra = '$ide'  ";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error().'-'.$sql_cont);
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
			
				if ($reg_cont['n_prod'] == 0) {
					$sql_prod = "SELECT * FROM produtos WHERE Codigo = '$id_prod'";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					if ($num_prod > 0) {
					
					$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );
				
						$qtd_ini =  1;
						
						$sql_add = "INSERT INTO itens_compra (compra_id, referencia_prod, descricao_prod, prcompra, qtd_produto)
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
			if ($_GET['tot']) {
			$tot = $_GET['tot'];
			$id_prod = addslashes(htmlentities($_GET['ref']));
			
			$sql_del = "DELETE FROM itens_compra WHERE referencia_prod = '$id_prod'  AND compra_id = '".$_SESSION['compra_id']."' ";
			$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
			
			$sql_qtd_del2 = "UPDATE produtos SET  Estoque = Estoque - '$tot' WHERE Codigo = '$id_prod'  ";
			$exe_qtd_del2 = mysql_query($sql_qtd_del2, $base) or die (mysql_error());
			
				}
			}	
		}	
	}
	if ($_GET['acao'] == "altera") {
		if (isset($_POST['qtd'])) {
			if (is_array($_POST['qtd'])) {
				foreach ($_POST['qtd'] as $referencia_prod => $qtd ) {
						//PESQUISA O TOTAL  DE PRODUTOS QUE ESTA NA TABELA ITENS_compras
						$sql_pes_qtd_itens_prod	= "SELECT qtd_produto FROM itens_compra WHERE referencia_prod = '$referencia_prod' AND compra_id = '".$_SESSION['compra_id']."' ";
						$rs_pes_qtd_itens_prod 	= mysql_query($sql_pes_qtd_itens_prod) or die (mysql_error().'-'.$sql_pes_qtd_itens_prod);
						$row_pes_qtd_itens_prod = mysql_fetch_array($rs_pes_qtd_itens_prod);
						
						$total_atual_itens_prod = $row_pes_qtd_itens_prod['qtd_produto'];
													
						//PESQUISA O TOTAL DE PRDUTOS EM ESTOQUE
						$sql_pes_prod = "SELECT Estoque FROM produtos WHERE Codigo = '".$referencia_prod."'";
						$rs_pes_prod = mysql_query($sql_pes_prod) or die (mysql_error().'-'.$sql_pes_prod);
						$row_pes_prod = mysql_fetch_array($rs_pes_prod);
						
						$total_prod_estoq = $row_pes_prod['Estoque'];
					
						if(empty($total_prod_estoq)){
							$total_prod_estoq = 0 ;
						}
						$total_estoq = ($total_prod_estoq - $total_atual_itens_prod)  + $qtd;;
						
						//ATUALIZA QUANTIDAE ITENS_compra
						$sql_alt = "UPDATE itens_compra SET qtd_produto = '$qtd' WHERE
									 referencia_prod = '$referencia_prod' AND compra_id = '".$_SESSION['compra_id']."' ";
						$exe_alt = mysql_query($sql_alt, $base) or die (mysql_error()) ;
						
						//ATUALIZA QUANTIDADE NO ESTOQUE
						$sql_qtd2 = "UPDATE produtos SET  Estoque = ".$total_estoq." WHERE Codigo='".$referencia_prod."'"; 
						$exe_qtd2 = mysql_query($sql_qtd2, $base) or die (mysql_error());
								 
						
						
					}
				}
			}
		}
		if (($_POST['prcompra'])) {
			if (is_array($_POST['prcompra'])) {
				foreach ($_POST['prcompra'] as $referencia_prod => $prc) {
						$sql_per = "UPDATE itens_compra SET prcompra = '$prc' WHERE
									 referencia_prod = '$referencia_prod' AND compra_id = '".$_SESSION['compra_id']."' ";
						$exe_per = mysql_query($sql_per) or die (mysql_error()) ;
			
				
			}
		}
	}
}

?>
    </p>
        <form action="vis_compra_edit.php?acao=altera" method="post" />
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

				$sql_lista = "SELECT * FROM itens_compra WHERE compra_id = '".$_SESSION['compra_id']."'  ";

				$exe_lista = mysql_query($sql_lista, $base) or die (mysql_error()."- $sql_lista");
				$num_lista = mysql_num_rows($exe_lista);
				if ($num_lista > 0) {
					$total_carrinho = 0;
					$i=0;
					while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
						$total_carrinho += ($reg_lista['prcompra']*$reg_lista['qtd_produto']);
						
						$sql_stok = "SELECT Estoque FROM produtos WHERE Codigo = '".$reg_lista['referencia_prod']."'  ";
		                $exe_stok = mysql_query($sql_stok) or die (mysql_error()."- $sql_stok"); 
						$row_stok = mysql_fetch_array($exe_stok,MYSQL_ASSOC);
						

		  ?>
          <tr>
            <td width="6%">
				<a href="vis_compra_edit.php?acao=del&ref=<?=$reg_lista['referencia_prod']?>&ide=<?=$_SESSION['compra_id']?>&tot=<?=$reg_lista['qtd_produto']?>"><img src="images/delete.gif" alt="delete" width="12" border="0"/></a></td>
            <td width="9%">
				<?=$reg_lista['referencia_prod']?>
			<input type="hidden" size="9" name="ref_prd_cont[<? echo $i?>]" value="<?=$reg_lista['referencia_prod']?>" />			</td>
            <td width="44%"><?=substr($reg_lista['descricao_prod'],0,33)?></td>
            <td width="12%">
				<input type="text" size="9" name="prcompra[<?=$reg_lista['referencia_prod']?>]" id="prcompra_<?=$reg_lista['referencia_prod']?>" value="<?=$reg_lista['prcompra']?>"/>
				<input type="hidden" size="9" name="prcompra_cont[<? echo $i?>]" value="<?=$reg_lista['prcompra']?>"  />			</td>
            <td width="7%">
				<input type="text" size="3" name="qtd[<?=$reg_lista['referencia_prod']?>]" id="qtd_<?=$reg_lista['referencia_prod']?>" value="<?=$reg_lista['qtd_produto']?>"/>
				<input type="hidden" size="3" name="qtd_cont[<? echo $i?>]" value="<?=$reg_lista['qtd_produto']?>"/>			</td>
            <td width="10%"><?=number_format($reg_lista['prcompra']*$reg_lista['qtd_produto'],2,",",".")?></td>
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
            <td><?=number_format($total_carrinho,2,",",".")?></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>
        <!--    <input name="enviar" id='enviar' value="Enviar" type="submit" disabled="disabled" /> --> </td>
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
<hr width="100%" size="14" noshade="noshade" />
		<p>&nbsp;        </p>
</body>
</html>