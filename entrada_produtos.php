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
			$sql = "SELECT c.*,  f.* FROM compras c, proveedor f WHERE c.id_compra = '$ide' AND f.id = c.fornecedor_id " ;	
			$rs = mysql_query($sql);
			$num_reg = mysql_num_rows($rs);
			if($num_reg > 0){
				$row = mysql_fetch_array($rs);
			
				$_SESSION['id_compra'] = $row['id_compra'];
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
		document.getElementById('frmItens').action = 'entrada_produtos.php?acao=insere';
		document.getElementById('frmItens').submit();
	}
	
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='\bbusca_nf_entrada.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='\bbusca_nf_entrada.php';
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
    <td width="8%" bgcolor="#ECE9D8"><strong>N. Compra </strong></td>
    <td width="12%" bgcolor="#ECE9D8"><strong>Cod. Fornecedor </strong></td>
    <td width="38%" bgcolor="#ECE9D8"><strong>Fornecedor</strong></td>
    <td width="16%" bgcolor="#ECE9D8"><strong>Valor da Compra </strong></td>
    <td width="11%" bgcolor="#ECE9D8"><strong>N. Fatura </strong></td>
    <td width="15%" bgcolor="#ECE9D8"><strong>Data Entrada </strong></td>
  </tr>
  <tr>
    <td width="8%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><?=$_SESSION['id_compra']?></td>
    <td width="12%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><?=$_SESSION['fornecedor_codigo']?></td>
    <td width="38%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><?=substr($_SESSION['Nome'],0,30)?></td>
    <td width="16%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><?=$_SESSION['vl_total_fatura']?></td>
    <td width="11%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><?=$_SESSION['nm_fatura']?></td>
    <td width="15%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><?=$_SESSION['data_lancamento']?></td>
  </tr>
</table>
<table width="100%" height="310" border="0" cellpadding="0" cellspacing="3">
  <tr>
	<th height="39" colspan="6" align="center" valign="middle" bgcolor="#ECE9D8"><p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Pesquisa de Producto </font></strong></p></th>
  </tr>
  <tr>
    <th height="44" colspan="6" align="left" valign="middle" bgcolor="#CECFCE"><table width="883" height="48" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="154" bordercolor="#000000" bgcolor="#CCCCCC"><div><strong>Referencia</strong></div></td>
        <td width="300" bordercolor="#000000" bgcolor="#CECFCE"><div><strong>Descripci&oacute;n</strong></div></td>
        <td width="398" bordercolor="#000000" bgcolor="#CECFCE">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#CECFCE"><form action="res_pes_prod_compra.php" method="post" name="Codigo" id="Codigo">
          <label>
            <input type="text2" name="ref" id='ref' />
            </label>
        </form></td>
        <td bgcolor="#CECFCE"><form action="res_pes_prod_compra.php" method="post" name="Descricao" id="Descricao">
          <label>
            <input type="text" name="desc" size="50" />
            </label>
        </form></td>
        <td align="right" bgcolor="#CECFCE"></form>
        </td>
      </tr>
    </table></th>
  </tr>
  <tr>
    <td height="208" colspan="6" valign="top" bgcolor="#ECE9D8"><p>
      <?
	
if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "add") {
		if (isset ($_GET['id'])) {
			if ($_GET['id']) {
				$id_prod = addslashes(htmlentities($_GET['id']));
				
				$sql_cont = "SELECT COUNT(*) AS n_prod FROM carrinho_compra WHERE produto_codigo = '$id_prod' AND sessao = '".session_id()."' AND fornecedor_codigo = '".$_SESSION['fornecedor_codigo']."' AND status = 'A' ";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
			
				
				if ($reg_cont['n_prod'] == 0) {
					$sql_prod = "SELECT * FROM produtos WHERE Codigo = '$id_prod'" ;
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					
					if ($num_prod > 0) {
						$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );

						$qtd_ini =  1;
									
						
						$sql_add = "INSERT INTO carrinho_compra
									(produto_codigo, descricao, prvenda, qtd_produto, sessao, fornecedor_codigo, data, status)
									VALUES
									('".$reg_prod['Codigo']."', '".$reg_prod['Descricao']."', '".$reg_prod['custo']."', '$qtd_ini', '".session_id()."','".$_SESSION['fornecedor_codigo']."', NOW(),'A')";

						$exe_add = mysql_query($sql_add, $base) or die (mysql_error().'-'.$sql_add);
					}
				}
			}
		}
	}
	if ($_GET['acao'] == "del") {
		if (isset($_GET['id'])) {
			if ($_GET['id']) {
				$id_prod = addslashes(htmlentities($_GET['id']));
				$sql_del = "DELETE FROM carrinho_compra WHERE produto_codigo = '$id_prod' AND sessao = '".session_id()."'";
				$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
			}
		}
	}
	if ($_GET['acao'] == "altera") {
		if (isset($_POST['qtd'])) {
			if (is_array($_POST['qtd'])) {
				foreach ($_POST['qtd'] as $produto_codigo => $qtd) {
						$sql_alt = "UPDATE carrinho_compra SET qtd_produto = '$qtd' WHERE
									 produto_codigo = '$produto_codigo' AND sessao = '".session_id()."'";
						$exe_alt = mysql_query($sql_alt, $base) or die (mysql_error().'-'.$sql_alt) ;
					}
				}
		}
	}

	if ($_GET['acao'] == "altera") {
		if (($_POST['prvenda'])) {
			if (is_array($_POST['prvenda'])) {
				foreach ($_POST['prvenda'] as $produto_codigo => $prc) {
						$sql_per = "UPDATE carrinho_compra SET prvenda = '$prc' WHERE
									 produto_codigo = '$produto_codigo' AND sessao = '".session_id()."'";

						$exe_per = mysql_query($sql_per)  or die (mysql_error().'-'.$sql_per) ;
						}
					}
				}
			}
		}
?>
    </p>
        <form action="entrada_produtos.php?acao=altera" method="post" name="frmItens" id='frmItens'/>
      <input type='hidden' name='campoFoco' id='campoFoco'/>
        <table border="1" width="100%">
          <tr>
            <td width="5%"><strong>Rem.</strong></td>
            <td width="13%"><strong>REF.<strong></strong></strong></td>
            <td width="48%"><strong>PRODUCTO<strong></strong></strong></td>
            <td width="12%"><strong>PRECIO</strong></td>
            <td width="9%"><strong>CANT.<strong></strong></strong></td>
            <td width="13%"><strong>SUBTOTAL.<strong></strong></strong></td>
          </tr>
          <?
			if(!$menu){
				$sql_lista = "SELECT * FROM carrinho_compra WHERE fornecedor_codigo = '".$_SESSION['fornecedor_codigo']."' AND sessao = '".session_id()."' AND status = 'A' order by id desc";
				$exe_lista = mysql_query($sql_lista, $base) or die (mysql_error()."- $sql_lista");
				$num_lista = mysql_num_rows($exe_lista);
				if ($num_lista > 0) {
					$total_carrinho = 0;
						while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
							$total_carrinho  += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
						?>
          <tr>
            <td width="5%"><a href="entrada_produtos.php?acao=del&amp;id=<?=$reg_lista['produto_codigo']?>"><img src="images/delete.gif" alt="aa" width="12" height="14" border="0"/></a> </td>
            <td width="13%"><?=$reg_lista['produto_codigo']?></td>
            <td width="48%"><?=substr($reg_lista['descricao'],0,35)?></td>
            <td width="12%"><input type="text" size="9" name="prvenda[<?=$reg_lista['produto_codigo']?>]" id="prvenda_<?=$reg_lista['produto_codigo']?>" value="<?=$reg_lista['prvenda']?>" onkeypress="nextFocus(event,'frmItens','prvenda_<?=$reg_lista['produto_codigo']?>')" /></td>
            <td width="9%"><input type="text" size="5" name="qtd[<?=$reg_lista['produto_codigo']?>]" id="qtd_<?=$reg_lista['produto_codigo']?>" value="<?=$reg_lista['qtd_produto']?>" onkeypress="nextFocus(event,'frmItens','qtd_<?=$reg_lista['produto_codigo']?>')" /></td>
            <td width="13%"><?=$reg_lista['prvenda']*$reg_lista['qtd_produto']?></td>
          </tr>
          <?
					}
				}
			}
		?>
          <tr>
            <td height="23" colspan="5"><div align="right">Total&nbsp;</div></td>
            <td><?=$total_carrinho?></td>
          </tr>
        </table>
    <p>&nbsp;</p></td>
  </tr>
</table>
<table width="75%" border="0">
  <tr>
    <td width="24%"><input type='button' value='Finalizar' onclick='finaliza()'/></a></td>
    <td width="66%"><span class="Estilo4">Aten&ccedil;&atilde;o: O valor da compra deve coincidir com o total das entradas !!! </span></td>
    <td width="3%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
  </tr>
</table>
<input type="button" value="Nueva pesquiza" name="LINK12" onclick="navegacao('Nueva')" />
<p>
<?
	if (isset ($_GET['acao'])) {
		if ($_GET['acao'] == "insere") {
			$sql_prod = "SELECT * FROM carrinho_compra WHERE sessao = '".session_id()."' AND fornecedor_codigo = ".$_SESSION['fornecedor_codigo']." AND status = 'A' ";
		    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
		    $num_prod = mysql_num_rows($exe_prod);
				if ($num_prod > 0) {			
					while	($reg_prodx = mysql_fetch_array($exe_prod, MYSQL_ASSOC )) {			
						$sql_add = "INSERT INTO itens_compra
						(compra_id, referencia_prod, descricao_prod, prcompra, qtd_produto)
						VALUES ('".$_SESSION['id_compra']."', '".$reg_prodx['produto_codigo']."', '".$reg_prodx['descricao']."', '".$reg_prodx['prvenda']."', '".$reg_prodx['qtd_produto']."' )";			
											
						$qtd_prod =  $reg_prodx['qtd_produto'] ;
									
						$exe_add = mysql_query($sql_add, $base) or die (mysql_error().'-'.$sql_add);	

						$sql_alt_status = "UPDATE carrinho_compra SET status = 'F' WHERE sessao = '".session_id()."' AND fornecedor_codigo = ".$_SESSION['fornecedor_codigo']." AND status = 'A' ";

						$exe_alt_status = mysql_query($sql_alt_status, $base) or die (mysql_error().'-'.$sql_alt_status);	
						
						$sql_status_compra = "UPDATE compras SET status = 'F' WHERE id_compra = '".$_SESSION['id_compra']."' "; 
						$exe_status_compra = mysql_query($sql_status_compra) or die (mysql_error().'-'.$sql_status_compra);
						
						$sql_cons_estoque_prod = "SELECT Estoque,margen_a,margen_b,margen_c,custo FROM produtos WHERE Codigo = '".$reg_prodx['produto_codigo']."'";
						$exe_cons_estoque_prod = mysql_query($sql_cons_estoque_prod) or die (mysql_error().'-'.$sql_cons_estoque_prod);
						$row_cons_estoque_prod = mysql_fetch_array($exe_cons_estoque_prod, MYSQL_ASSOC);
						$qtd_prod_old = $row_cons_estoque_prod['Estoque'];
						$qtd_prod_new =  $qtd_prod_old + $reg_prodx['qtd_produto'];
						$custo_anterior = $row_cons_estoque_prod['custo'];
						$custo_atual = $reg_prodx['prvenda'];
						$custo_medio = ($custo_anterior + $custo_atual) / 2;
						
						
						$percentual_a = $row_cons_estoque_prod['margen_a'] / 100;
						$valor_a = $reg_prodx['prvenda']  + ($percentual_a * $reg_prodx['prvenda']);
						
						$percentual_b = $row_cons_estoque_prod['margen_b'] / 100;
						$valor_b = $reg_prodx['prvenda']  + ($percentual_b * $reg_prodx['prvenda']);
						
						$percentual_c = $row_cons_estoque_prod['margen_c'] / 100;
						$valor_c = $reg_prodx['prvenda']  + ($percentual_c * $reg_prodx['prvenda']);
						
										
						$sql_up_estoque_prod = "UPDATE produtos SET custo = '".$reg_prodx['prvenda']."', Estoque = '".$qtd_prod_new."', valor_a = '$valor_a', valor_b = '$valor_b', valor_c = '$valor_c', custo_anterior = '$custo_anterior', custo_medio = '$custo_medio' WHERE Codigo = '".$reg_prodx['produto_codigo']."'";
						mysql_query($sql_up_estoque_prod);
		    		}
				}
		
		
					echo "<script language='javaScript'>window.location.href='prod_cad_exito.php'</script>";	
	}
	}
?>
</p>
</body>
</html>
