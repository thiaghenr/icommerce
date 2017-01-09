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
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<script>
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='pesquiza_pedido.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='pesquisa_pedido.php';
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
<title>Pedido- <? echo $title ?></title>
<style type="text/css">
<!--
.Estilo14 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo16 {color: #0000FF}
.style2 {font-size: 10px}
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
     <td width="5%" bgcolor="#999999"><span class="Estilo15">Pedido</span></td>
     <td width="13%" bgcolor="#999999"><span class="Estilo15">Cod. Cliente</span></td>
     <td width="33%" bgcolor="#999999"><strong><span class="Estilo16">Nome</span></strong></td>
     <td width="13%" bgcolor="#999999"><span class="Estilo16"><strong>Data</strong></span></td>
     <td width="13%" bgcolor="#999999"><strong><span class="Estilo16">Vendedor</span></strong></td>
   </tr>
   <?
   
   
	$sql_listas = "SELECT p.*, c.* FROM pedido p, clientes c WHERE p.id = '$ide' AND p.controle_cli = c.controle ";
	$exe_listas = mysql_query($sql_listas, $base);
	$num_listas = mysql_num_rows($exe_listas);
	
	$cod_cliente;
	while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)) {
			$cod_cliente = $reg_listas['controle_cli'];
			$cod_cotacao = $reg_listas['id'];
			$_SESSION['freteCli'] = $reg_listas['frete'];
			
			//$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
			// Pegando data e hora.
			$data2 = $reg_listas['data_car'];
			//$hora = date("H:i:s");
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";
			
			$estado = $reg_listas['situacao'];
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
<?

	if ($estado == 'D'){
		
		echo "<strong>ESTE PEDIDO JA FOI DEVOLVIDO</strong>"."<br>";						
		}
	else {	
				
?>
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
        <td bgcolor="#CECFCE"><form action="res_pes_prod_edit.php?ide=<?=$_SESSION['ide']?>" method="post" name="referencia_prod" id="referencia_prod">
        </form></td>
        <td bgcolor="#CECFCE"><form action="res_pes_forn.php" method="post" name="descricao_prod" id="descricao_prod">
        </form></td>
      </tr>
    </table></th>
  </tr>
 
  <tr>
    <td height="197" colspan="5" valign="top" bgcolor="#DAE6F8"><p>
      <?
if (($_POST['frete'])) {
				$frete_novo = $_POST['frete'];
				$sql_frete = "UPDATE pedido SET frete = '$frete_novo' WHERE 
							id = '$cod_cotacao' ";
				$exe_frete = mysql_query($sql_frete) or die (mysql_error()) ;
		}

if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "add") {
		if (isset ($_GET['id'])) {
			if ($_GET['id']) {
				$id_prod = addslashes(htmlentities($_GET['id']));
				$sql_cont = "SELECT COUNT(*) AS n_prod FROM itens_pedido WHERE referencia_prod = '$id_prod' AND id_pedido = '$ide'  ";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error().'-'.$sql_cont);
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
			
				if ($reg_cont['n_prod'] == 0) {
					$sql_prod = "SELECT * FROM produtos WHERE Codigo = '$id_prod'";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					if ($num_prod > 0) {
					
					$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );
				
						$qtd_ini =  1;
						
						$sql_add = "INSERT INTO itens_pedido (id_pedido, referencia_prod, descricao_prod, prvenda, qtd_produto)
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
			
			//PESQUISA O TOTAL  DE PRODUTOS QUE ESTA NA TABELA ITENS_PEDIDOS
			$sql_pes_qtd_itens_prod	= "SELECT qtd_produto,prvenda FROM itens_pedido WHERE referencia_prod = '$id_prod' AND id_pedido = '".$_SESSION['ide']."' ";
			$rs_pes_qtd_itens_prod 	= mysql_query($sql_pes_qtd_itens_prod) or die (mysql_error().'-'.$sql_pes_qtd_itens_prod);
			$row_pes_qtd_itens_prod = mysql_fetch_array($rs_pes_qtd_itens_prod);
			
			$total_atual_itens_prod = $row_pes_qtd_itens_prod['qtd_produto'];
			$total_do_iten = $row_pes_qtd_itens_prod['qtd_produto'] * $row_pes_qtd_itens_prod['prvenda'];
													
			//PESQUISA O TOTAL DE PRDUTOS QUE ESTAO no estoque
			$sql_pes_prod = "SELECT Estoque FROM produtos WHERE Codigo = '".$id_prod."'";
			$rs_pes_prod = mysql_query($sql_pes_prod) or die (mysql_error().'-'.$sql_pes_prod);
			$row_pes_prod = mysql_fetch_array($rs_pes_prod);
			
			$total_prod_estoq = $row_pes_prod['Estoque'];
			
			//CALCULA O TOTAL DE PRODUTOS PARA ir ao estoque
			$total_estoq = ($total_prod_estoq + $total_atual_itens_prod); 
						
			//ATUALIZA QUANTIDADE NO ESTOQUE
			$sql_qtd2 = "UPDATE produtos SET  Estoque = ".$total_estoq." WHERE Codigo='".$id_prod."'"; 
			$exe_qtd2 = mysql_query($sql_qtd2, $base) or die (mysql_error());
				
			//DELETA ITENS_PEDIDO O PRODUTO
			$sql_del = "DELETE FROM itens_pedido WHERE referencia_prod = '$id_prod'  AND id_pedido = '$ide' ";
			$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
			
		
		//ALTERA CONTAS A RECEBER E VENDAS
		$sql_cr = "SELECT c.*, v.id AS vend,pedido_id,venda_id, p.id AS pedid  FROM contas_receber c, venda v, pedido p WHERE p.id = v.pedido_id AND v.id = c.venda_id AND p.id = '".$ide."' group by p.id ";
		$exe_cr = mysql_query($sql_cr, $base) or die (mysql_error());
		$reg_cr = mysql_fetch_array($exe_cr, MYSQL_ASSOC);
		$linhas = mysql_num_rows($exe_cr)."AKI";
		
		$valor_original_contas = $reg_cr['vl_total'];
		$qtd_parcelas = $reg_cr['nm_total_parcela'];
		$valor_final = $valor_original_contas - $total_do_iten;
		//$percentual = ($_SESSION['freteCli'] / 100) ;
		//$valor_do_frete = $valor_sem_frete * $percentual;
		//$valor_final = $valor_sem_frete + $valor_do_frete ;
		$valor_parcelas = $valor_final / $qtd_parcelas;
		
		//ALTERA TOTAL VENDAS			
		$sql_dv = "UPDATE venda SET valor_venda = '$valor_final' WHERE pedido_id = '".$reg_cr['pedido_id']."' "; 
		$exe_dv = mysql_query($sql_dv, $base) or die (mysql_error());
		
		//ALTERA CONTAS A RECEBER
		$sql_dcr = "UPDATE contas_receber SET vl_total = '$valor_final', vl_parcela = '$valor_parcelas' WHERE venda_id = '".$reg_cr['venda_id']."' AND status != 'P' "; 
		$exe_dcr = mysql_query($sql_dcr, $base) or die (mysql_error());
		
		//DELETA ITENS_VENDA O PRODUTO
		$sql_delv = "DELETE FROM itens_venda WHERE referencia_prod = '$id_prod'  AND id_venda = '".$reg_cr['vend']."' ";
		$exe_delv = mysql_query($sql_delv, $base) or die (mysql_error());
			
			}	
		}	
	}
	
	if ($_GET['acao'] == "altera") {
		if (isset($_POST['qtd'])) {
			if (is_array($_POST['qtd'])) {
				foreach ($_POST['qtd'] as $referencia_prod => $qtd ) {
						//PESQUISA O TOTAL  DE PRODUTOS QUE ESTA NA TABELA ITENS_PEDIDOS
						$sql_pes_qtd_itens_prod	= "SELECT qtd_produto,prvenda FROM itens_pedido WHERE referencia_prod = '$referencia_prod' AND id_pedido = '".$_SESSION['ide']."' ";
						$rs_pes_qtd_itens_prod 	= mysql_query($sql_pes_qtd_itens_prod) or die (mysql_error().'-'.$sql_pes_qtd_itens_prod);
						$row_pes_qtd_itens_prod = mysql_fetch_array($rs_pes_qtd_itens_prod);
						$total_atual_itens_prod = $row_pes_qtd_itens_prod['qtd_produto'];
					    	
						if ($total_atual_itens_prod < $qtd) {
						echo "<strong>Voce nao pode agregar itens a esta nota</strong>";
						break;
						}
													
						//PESQUISA O TOTAL DE PRDUTOS QUE ESTAO BLOQUEADOS
						$sql_pes_prod = "SELECT qtd_bloq,Estoque FROM produtos WHERE Codigo = '".$referencia_prod."'";
						$rs_pes_prod = mysql_query($sql_pes_prod) or die (mysql_error().'-'.$sql_pes_prod);
						$row_pes_prod = mysql_fetch_array($rs_pes_prod);
						$total_prod_bloq = $row_pes_prod['qtd_bloq'];
						$total_prod_estoq = $row_pes_prod['Estoque'];
					
						if(empty($total_prod_bloq)){
							$total_prod_bloq = 0 ;
						}
						//CALCULA O TOTAL DE PRODUTOS PARA SER BLOQUEADO
						$total = ($total_prod_bloq - $total_atual_itens_prod) + $qtd;
						$total_estoq = ($total_prod_estoq + $total_atual_itens_prod)  - $qtd;; 
						
						//ATUALIZA QUANTIDAE ITENS_PEDIDO
						$sql_alt = "UPDATE itens_pedido SET qtd_produto = '$qtd' WHERE
									 referencia_prod = '$referencia_prod'  AND id_pedido = '".$_SESSION['ide']."' ";
						$exe_alt = mysql_query($sql_alt, $base) or die (mysql_error()) ;
								 
						//ATUALIZA  BLOQUEADOS NO ESTOQUE
						$sql_prod_bloquiados = "UPDATE produtos SET qtd_bloq = ".$total." WHERE Codigo = '".$referencia_prod."'"; 
						mysql_query($sql_prod_bloquiados);
						
						//ATUALIZA  QAUNTIDADE NO ESTOQUE
						$sql_prod_bloquiados = "UPDATE produtos SET Estoque = ".$total_estoq." WHERE Codigo = '".$referencia_prod."'"; 
						mysql_query($sql_prod_bloquiados);
						
						//ATUALIZA QUANTIDADE NA VENDAS
						$sql_v = "SELECT id,pedido_id FROM venda WHERE pedido_id = '".$_SESSION['ide']."' ";
						$exe_v = mysql_query($sql_v, $base);
						$reg_v = mysql_fetch_array($exe_v, MYSQL_ASSOC);
						$nvenda = $reg_v['id']; 
						$sql_qtdv = "UPDATE itens_venda SET qtd_produto = ".$qtd." WHERE id_venda = '".$nvenda."' AND  					referencia_prod = '".$referencia_prod."' "; 
						$exe_qtdv = mysql_query($sql_qtdv, $base) or die (mysql_error());
						
						}
		$sql_itens_pedido = "SELECT it.*, p.* FROM itens_pedido it, pedido p WHERE it.id_pedido = '".$_SESSION['ide']."' AND p.id = it.id_pedido ";
		$exe_itens_pedido = mysql_query($sql_itens_pedido, $base);
		while ($reg_itens_pedido = mysql_fetch_array($exe_itens_pedido, MYSQL_ASSOC)){
		$frete = $reg_itens_pedido['frete'];
		$nota +=  ($reg_itens_pedido['qtd_produto'] * $reg_itens_pedido['prvenda']) ;
		$tot_nota = $nota + $frete;
		}
		//ATUALIZA TOTAL DA NOTA
		$sql_qtd2 = "UPDATE pedido SET  total_nota = ".$tot_nota." WHERE id = '".$_SESSION['ide']."' "; 
		$exe_qtd2 = mysql_query($sql_qtd2, $base) or die (mysql_error());
		
		//ALTERA CONTAS A RECEBER E VENDAS
		$sql_cr = "SELECT c.*, v.id AS vend,pedido_id,venda_id, p.id AS pedid,total_nota  FROM contas_receber c, venda v, pedido p WHERE p.id = v.pedido_id AND v.id = c.venda_id AND p.id = '".$_SESSION['ide']."' group by p.id ";
		$exe_cr = mysql_query($sql_cr, $base) or die (mysql_error());
		$reg_cr = mysql_fetch_array($exe_cr, MYSQL_ASSOC);
		$linhas = mysql_num_rows($exe_cr);
		
		$valor_original_contas = $reg_cr['vl_total'];
		$total_do_iten = $reg_cr['total_nota'];
		$qtd_parcelas = $reg_cr['nm_total_parcela'];
		$valor_final = $valor_original_contas - $total_do_iten;
		$valor_parcelas = $tot_nota / $qtd_parcelas;
		
		//ALTERA TOTAL VENDAS			
		$sql_dv = "UPDATE venda SET valor_venda = '$tot_nota' WHERE pedido_id = '".$reg_cr['pedido_id']."' "; 
		$exe_dv = mysql_query($sql_dv, $base) or die (mysql_error());
		
		//ALTERA CONTAS A RECEBER
		$sql_dcr = "UPDATE contas_receber SET vl_total = '$tot_nota', vl_parcela = '$valor_parcelas' WHERE venda_id = '".$reg_cr['venda_id']."' AND status != 'P' "; 
		$exe_dcr = mysql_query($sql_dcr, $base) or die (mysql_error());
		
						
			}
		}
				
		
		$ck_pendencias = $_POST['ck_pendencia'];
		$pr_venda = $_POST['prvenda_cont'];
		$produto_id = $_POST['ref_prd_cont'];
		$qtd_produto = $_POST['qtd_cont'];
		$codigo_cliente = $_POST['codigo_cliente'];
		$codigo_cotacao = $_POST['cod_cotacao'];
		
		$tot_pendecias = count($ck_pendencias);
				
		if($tot_pendecias){
			
			$sql_verifica_pendencia = "SELECT * FROM pendencias WHERE cotacao_id = '".$codigo_cotacao."' AND st_pendencia = 'A'";
			$exe_verifica_pendencia = mysql_query($sql_verifica_pendencia) or die (mysql_error());
			$row_verifica_pendencia = mysql_fetch_array($exe_verifica_pendencia);
			if(mysql_num_rows($exe_verifica_pendencia) > 0){
				$pendencia_id = $row_verifica_pendencia['id'];
			}
			else{
					$sql_ins_pendencias = sprintf("INSERT INTO pendencias (clientes_controle,usuario_id,data,st_pendencia,cotacao_id)
										VALUES ('%s','%s','%s','%s','%s')",
										trim($codigo_cliente),$id_usuario,date("Y-m-d"),'A',trim($codigo_cotacao));
					
					mysql_query($sql_ins_pendencias) or die(mysql_error().'-'.$sql_ins_pendencias);
					
					$pendencia_id = mysql_insert_id();
			}
			foreach($ck_pendencias as $key => $value){
				$sql_verifica = "SELECT ip.* FROM itens_pendencias ip, pendencias p WHERE p.cotacao_id = '".trim($codigo_cotacao)."' AND ip.produtos_codigo = '".trim($produto_id[$key])."' AND ip.pendencias_id = p.id AND ip.pendencias_id=".$pendencia_id;
		
				$rs_verifica = mysql_query($sql_verifica) or die (mysql_error().'-'.$sql_verifica);
				if(mysql_num_rows($rs_verifica)){
					$linha_verifica = mysql_fetch_array($rs_verifica);
					$id_verifica = $linha_verifica['id'];
					
					$sql_update = "UPDATE itens_pendencias SET produtos_codigo = ".$produto_id[$key].", qtd = ".$qtd_produto[$key].", vl_preco = ".$pr_venda[$key].", dt_item='".date("Y-m-d")."'";
					$sql_update.=" WHERE id ='".$id_verifica."'";
					
					mysql_query($sql_update) or die(mysql_error().'-'.$sql_update);

				}
				else{
					$sql_itens_pendencias = sprintf("INSERT INTO itens_pendencias (pendencias_id,produtos_codigo,qtd,vl_preco,st_item_pendencia,dt_item)
										VALUES ('%s','%s','%s','%s','%s','%s')",
										trim($pendencia_id),trim($produto_id[$key]),trim($qtd_produto[$key]),trim($pr_venda[$key]),'A',date("Y-m-d"));
					
					mysql_query($sql_itens_pendencias) or die(mysql_error().'-'.$sql_itens_pendencias);
					
				}
			}
		}
	}
	
}
?>
    </p>
        <form action="devolucao_itens_edit.php?acao=altera" method="post" />
		<input type='hidden' name='ide' id='ide' value='<?echo $ide?> '/>
		<input type='hidden' name='codigo_cliente' id='codigo_cliente' value='<?echo $cod_cliente?> '/>
		<input type='hidden' name='cod_cotacao' id='cod_cotacao' value='<?echo $cod_cotacao?> '/>		
		
		<table border="1" width="100%">
          <tr>
            <td width="6%"><strong>Rem.</strong></td>
            <td width="9%"><strong>REF.<strong></strong></strong></td>
            <td width="44%"><strong>PRODUCTO<strong></strong></strong></td>
            <td width="12%"><strong>PRECIO</strong></td>
            <td width="7%"><strong>CANT.<strong></strong></strong></td>
            <td width="10%"><strong>SUBTOTAL.<strong></strong></strong></td>
			<td width="6%"><strong>PEND.<strong></strong></strong></td>
			<td width="6%"><strong>STOK</strong></td>
          </tr>
          <?
			//if(!$menu){

				$sql_lista = "SELECT it.*, p.* FROM itens_pedido it, pedido p  WHERE it.id_pedido = '$ide' AND p.id = it.id_pedido  ";

				$exe_lista = mysql_query($sql_lista, $base) or die (mysql_error()."- $sql_lista");
				$num_lista = mysql_num_rows($exe_lista);
				if ($num_lista > 0) {
					$total_carrinho = 0;
					$i=0;
					while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
						$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
						$frete = $reg_lista['frete'];
						
						$sql_stok = "SELECT Estoque FROM produtos WHERE Codigo = '".$reg_lista['referencia_prod']."'  ";
		                $exe_stok = mysql_query($sql_stok) or die (mysql_error()."- $sql_stok"); 
						$row_stok = mysql_fetch_array($exe_stok,MYSQL_ASSOC);
						$qtd_estoque = $row_stok['Estoque'];
						
						//$percentual = ($_SESSION['freteCli'] / 100) ; 
						//number_format($valor_frete = ($total_carrinho * $percentual),0,'.',''); 
						$total_sem_frete = $total_carrinho + $valor_frete;
						//echo number_format($total_sem_frete,0,'.','');
						
		  ?>
          <tr>
            <td width="6%">
				<a href="devolucao_itens_edit.php?acao=del&ref=<?=$reg_lista['referencia_prod']?>&id=<?=$reg_lista['id_pedido']?>&ide=<?=$_SESSION['ide']?>"><img src="images/delete.gif" alt="delete" width="12" border="0"/></a></td>
            <td width="9%">
				<?=$reg_lista['referencia_prod']?>
			<input type="hidden" size="9" name="ref_prd_cont[<? echo $i?>]" value="<?=$reg_lista['referencia_prod']?>" />			</td>
            <td width="44%"><?=substr($reg_lista['descricao_prod'],0,33)?></td>
            <td width="12%">
				<input type="text" size="9" name="prvenda[<?=$reg_lista['referencia_prod']?>]" id="prvenda_<?=$reg_lista['referencia_prod']?>" value="<?=$reg_lista['prvenda']?>" readonly="readonly"/>
				<input type="hidden" size="9" name="prvenda_cont[<? echo $i?>]" value="<?=$reg_lista['prvenda']?>"  />			</td>
            <td width="7%">
				<input type="text" size="3" name="qtd[<?=$reg_lista['referencia_prod']?>]" id="qtd_<?=$reg_lista['referencia_prod']?>" value="<?=$reg_lista['qtd_produto']?>"/>
				<input type="hidden" size="3" name="qtd_cont[<? echo $i?>]" value="<?=$reg_lista['qtd_produto']?>"/>			</td>
            <td width="10%"><?=number_format($reg_lista['prvenda']*$reg_lista['qtd_produto'],2,",",".")?></td>
			<td width="6%"><input type='checkbox' name='ck_pendencia[<?echo $i?>]' /></td>
			<td width="6%"><font color="blue"><?=$qtd_estoque?></font></td>
          </tr>
          <?
				$i++;
					}
				}
			$total_geral = $total_carrinho + $frete;
			//}
		?>
          <tr bgcolor="#DAE6F8" >
            <td height="23" colspan="5"><div align="right"><strong>Defina a quantidade dos itens que permaneceram na nota.</strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF" >
            <td height="23" colspan="5"><div align="right"><strong>Tota Itens:</strong></div> </td>
            <td><strong>
            <?=number_format($total_carrinho,2,",",".")?>
            </strong></td>
          </tr>
          <tr bgcolor="#FFFFFF" >
            <td height="23" colspan="5"><div align="right"> <span class="style2">(nao use ponto ou virgula)</span> <strong>Frete:</strong></div></td>
            <td>
              <label><?=number_format($frete,2,",",".")?></label>            </td>
          </tr>
          <tr bgcolor="#FFFFFF" >
            <td height="23" colspan="5"><div align="right"><strong>Total Geral:&nbsp;</strong></div></td>
            <td><strong>
            <?=number_format($total_geral,2,",",".")?>
            </strong></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>
            <input name="enviar" id='enviar' value="Enviar" type="submit" /></td>
            <td colspan="5">&nbsp;</td>
          </tr>
          <tr>
            <td height="2">            </td>
          </tr>
    </table></td>
  </tr>
</table>
<? 
}
?>
<p align="center" class="Estilo15">	ATEN&Ccedil;AO</p>
<p class="Estilo16"><strong>!!! SOMENTE FA&Ccedil;A ESSA DEVOLUCAO SE A NOTA AINDA NAO TIVER PAGO !!!</strong></p>
</body>
</html>