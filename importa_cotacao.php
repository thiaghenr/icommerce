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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<script>
function inserirPedido() {
language=window.location.href='importa_cotacao.php?acao=lanca&ide=<?=$ide?>';

}
</script> 
<script>
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='\pesquisa_cot_imp.php';
 }
 else if(lugar=='CJ'){
  window.location.href='http://';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>
<style type="text/css">
.botao {
	height:38px;	
	}
.botaoSubmit {
	height:1px;	
	}	
body {
	color: #006;
	padding:3px 0px 3px 8px;
	background-color: #f2f1e2;
	border-width:2px;
	border-style:solid;
	border-color:#a2bfe9;
	}
	
.h1 {
	font-family: Verdana, Arial, Sans-serif;
	color:#fff;
	font-size:85%;
	background:#EFEFEF;
	padding:5px 0px 5px 10px;
	border: 2px outset #ccc;
	margin-bottom:10px;
	width: auto.0em;
}
p {
	font-family: Verdana, Arial, Sans-serif;
	color: #000;
}
<!--
.Estilo15 {
	color: #0000FF;
	font-weight: bold;
}

.bordaBox {bbackground: ttransparent; width:30%;}
.bordaBox .b1, .bordaBox .b2, .bordaBox .b3, .bordaBox .b4, .bordaBox .b1b, .bordaBox .b2b, .bordaBox .b3b, .bordaBox .b4b {display:block; overflow:hidden; font-size:1px;}
.bordaBox .b1, .bordaBox .b2, .bordaBox .b3, .bordaBox .b1b, .bordaBox .b2b, .bordaBox .b3b {height:1px;}
.bordaBox .b2, .bordaBox .b3, .bordaBox .b4 {background:#CECECE; border-left:1px solid #999; border-right:1px solid #999;}
.bordaBox .b1 {margin:0 5px; background:#999;}
.bordaBox .b2 {margin:0 3px; border-width:0 2px;}
.bordaBox .b3 {margin:0 2px;}
.bordaBox .b4 {height:2px; margin:0 1px;}
.bordaBox .conteudo {padding:5px;display:block; background:#CECECE; border-left:1px solid #999; border-right:1px solid #999;
}

-->
</style>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Importar Cotacao - <? echo $title;?></title>
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
<table width="100%" >
  <tr>
    <td width="10%" bgcolor="#OEEAEO"><div align="left">
      <div align="center" class="Estilo14">CONVERTER EM PEDIDO </div>
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="0" width="100%" class="h1">
   <tr>
     <td width="8%" bgcolor="#00FFFF"><span class="Estilo15">Cotizacion</span></td>
     <td width="12%" bgcolor="#00FFFF"><span class="Estilo15">Cod. Cliente</span></td>
     <td width="33%" bgcolor="#00FFFF"><strong><span class="Estilo16">Nome <? echo $forma_pgto;?></span></strong></td>
     <td width="17%" bgcolor="#00FFFF"><span class="Estilo16"><strong>Data</strong></span></td>
     <td width="14%" bgcolor="#00FFFF"><strong><span class="Estilo16">Vendedor <img src="/images/pinguin.gif" alt="delete" width="12" border="0"/></span></strong></td>
     <td width="16%" bgcolor="#00FFFF" class="Estilo16"><div align="right"><strong>Pagamento</strong></div></td>
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
     <td width="8%" bgcolor="#999999"><?=$cod_cotacao?></td>
     <td width="12%" bgcolor="#999999"><?=$cod_cliente?></td>
     <td width="33%" bgcolor="#999999"><?=$reg_listas['nome_cli']?></td>
     <td width="17%" bgcolor="#999999"><?=$novadata ?></td>
     <td width="14%" bgcolor="#999999"><?=$reg_listas['vendedor']?></td>
     <td width="16%" bgcolor="#999999"><div align="right">
       <select name="formaPgto" id='formaPgto'>
        
         <?
                $sql_forma_pgto= "SELECT * FROM forma_pagamento  ";
                $rs_forma_pgto = mysql_query($sql_forma_pgto);
                while($linha_forma = mysql_fetch_array($rs_forma_pgto)){
                    echo "<option value='".$linha_forma['id']."'>".$linha_forma['descricao']."</option>\n";
                }
				$forma_pgto = $_GET['formaPgto'];
				echo $forma_pgto;
            ?>
			 
       </select>
     </div></td>
   </tr>
   <?
   }
   ?>
   <tr>
     <td>&nbsp;</td>
   </tr>
</table>

<table width="100%" border="0" align="center">
 <!--
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
        <td bgcolor="#CECFCE"><form action="res_pes_forn.php" method="post" name="referencia_prod" id="referencia_prod">
          <input type="text2" name="ref" id='ref' />
        </form></td>
        <td bgcolor="#CECFCE"><form action="res_pes_forn.php" method="post" name="descricao_prod" id="descricao_prod">
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
		if (isset ($_GET['ide'])) {
			if ($_GET['ide']) {
				$id_prod = addslashes(htmlentities($_GET['ide']));

				$sql_cont = "SELECT COUNT(*) AS n_prod FROM itens_cotacao WHERE referencia_prod = '$id_prod'  ";
				$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error().'-'.$sql_cont);
				$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);

				if ($reg_cont['n_prod'] == 0) {
					$sql_prod = "SELECT * FROM produtos WHERE Codigo = '$id_prod'";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					if ($num_prod > 0) {
						$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );

						$qtd_ini =  1;
						
						 $sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 3 AND moeda.id = 3 GROUP BY cm.id DESC limit 0,1 ";
	  					 $rs_cambio = mysql_query($sql_cambio);
	    				 $linha_cambio = mysql_fetch_array($rs_cambio);
	 					 $vl_cambio_guarani = $linha_cambio['vl_cambio'];
						
						 guarani($novovalor = $vl_cambio_guarani * $reg_prod['valor_c']) ;
					

						$sql_add = "INSERT INTO itens_pedido
									(referencia_prod, descricao_prod, prvenda, qtd_produto, sessao)
									VALUES
									('".mysql_escape_string($reg_prod['Codigo'])."', '".mysql_escape_string($reg_prod['Descricao'])."', '$novovalor', '$qtd_ini', '".session_id()."' ";

						$exe_add = mysql_query($sql_add, $base) or die ("Selecione um cliente para esta operacao");
					}
				}
			}
		}
	}
	if ($_GET['acao'] == "del") {
			$sql_del = "DELETE FROM itens_cotacao WHERE referencia_prod = '$ref' AND id_cotacao = '$id' AND id_cotacao = '$ide' ";
			$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
	}
	if ($_GET['acao'] == "altera") {
		if (isset($_POST['qtd'])) {
			if (is_array($_POST['qtd'])) {
				foreach ($_POST['qtd'] as $referencia_prod => $qtd ) {
						$sql_alt = "UPDATE itens_cotacao SET qtd_produto = '$qtd' WHERE
									 referencia_prod = '$referencia_prod' ";
						$exe_alt = mysql_query($sql_alt, $base) or die (mysql_error()) ;
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
}
?>
    </p>
        <form action="importa_cotacao.php?acao=altera" method="post" />
		<input type='hidden' name='ide' id='ide' value='<? echo $ide?> '/>
		<input type='hidden' name='codigo_cliente' id='codigo_cliente' value='<? echo $cod_cliente?> '/>
		<input type='hidden' name='cod_cotacao' id='cod_cotacao' value='<? echo $cod_cotacao?> '/>		
		
		<table border="1" width="100%">
          <tr>
            <td width="6%"><strong>Rem.</strong></td>
            <td width="9%"><strong>REF.<strong></strong></strong></td>
            <td width="44%"><strong>PRODUCTO<strong></strong></strong></td>
            <td width="12%"><strong>PRECIO</strong></td>
            <td width="7%"><strong>CANT.<strong></strong></strong></td>
            <td width="10%"><strong>SUBTOTAL.<strong></strong></strong></td>
			<td width="6%"><strong>STOK</strong></td>
          </tr>
          <?
			if(!$menu){

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
						$qtd_estoque = $row_stok['Estoque'];

		  ?>
          <tr>
            <td width="6%"><a href="importa_cotacao.php?acao=del&amp;ref=<?=$reg_lista['referencia_prod']?>&amp;id=<?=$reg_lista['id_cotacao']?>&amp;ide=<?=$_GET['ide']?>"><img src="/images/delete.gif" alt="delete" width="12" border="0"/></a> </td>
            <td width="9%">
				<?=$reg_lista['referencia_prod']?>
			<input type="hidden" size="9" name="ref_prd_cont[<? echo $i?>]" value="<?=$reg_lista['referencia_prod']?>" />			</td>
            <td width="44%"><?=$reg_lista['descricao_prod']?></td>
            <td width="12%">
				<input type="text" readonly="" size="9" name="prvenda[<?=$reg_lista['referencia_prod']?>]" id="prvenda_<?=$reg_lista['referencia_prod']?>" value="<?=$reg_lista['prvenda']?>"/>
				<input type="hidden" size="9" name="prvenda_cont[<? echo $i?>]" value="<?=$reg_lista['prvenda']?>"  />			</td>
            <td width="7%">
				<input type="text" size="3" readonly="" name="qtd[<?=$reg_lista['referencia_prod']?>]" id="qtd_<?=$reg_lista['referencia_prod']?>" value="<?=$reg_lista['qtd_produto']?>"/>
				<input type="hidden" size="3" name="qtd_cont[<? echo $i?>]" value="<?=$reg_lista['qtd_produto']?>"/>			</td>
            <td width="10%"><?=guarani($reg_lista['prvenda']*$reg_lista['qtd_produto'])?></td>
			<td width="6%"><font color="blue"><?=$qtd_estoque?></font></td>
          </tr>
          <?
				$i++;
					}
				}
			}
			//}
		?>
		
<?php

if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "lanca") {
					$sql_prodp = "SELECT * FROM cotacao WHERE id =  '$ide' ";
				    $exe_prodp = mysql_query($sql_prodp, $base) or die (mysql_error());
				    $num_prodp = mysql_num_rows($exe_prodp);
					if ($num_prodp > 0) {
						
					$reg_prodp = mysql_fetch_array($exe_prodp, MYSQL_ASSOC );
										
					$sql_addv = "INSERT INTO pedido
								(data_car, cotacao_id, total_nota, controle_cli, nome_cli, 
								situacao, usuario_id, forma_pagamento_id, vendedor )
								VALUES
								(NOW(), '".$reg_prodp['id']."', '".$reg_prodp['total_nota']."',  
								'".$reg_prodp['controle_cli']."', '".$reg_prodp['nome_cli']."',
								'A', '$id_usuario', '2', '".$reg_prodp['vendedor']."')";
					$exe_addv = mysql_query($sql_addv, $base) or die (mysql_error().'-'.$sql_addv);				
					$id_pedido = mysql_insert_id();	
										
					$sql_prodc = "SELECT * FROM itens_cotacao WHERE  id_cotacao = '$ide'  " ;
				    $exe_prodc = mysql_query($sql_prodc) or die (mysql_error());
				    $num_prodc = mysql_num_rows($exe_prodc);
					if ($num_prodc > 0) {			
					
				while ($reg_prodc = mysql_fetch_array($exe_prodc, MYSQL_ASSOC )) {			
					
					$sql_addi = "INSERT INTO itens_pedido
								(id_pedido, referencia_prod, descricao_prod, prvenda, qtd_produto)
								VALUES
								('$id_pedido','".$reg_prodc['referencia_prod']."', '".$reg_prodc['descricao_prod']."', '".$reg_prodc['prvenda']."', '".$reg_prodc['qtd_produto']."')";			
																
								$qtd_prod =  $reg_prodc['qtd_produto'] ;
								$exe_addi = mysql_query($sql_addi, $base) or die (mysql_error().'-'.$sql_addi);		
//	$sql_lista = "SELECT v.*, c.* FROM venda v, clientes c WHERE v.id = $idv AND v.controle_cli = c.controle";
					
					
											
		
		$sql_qtd1 = "UPDATE produtos SET qtd_bloq =  qtd_bloq + '$qtd_prod' WHERE Codigo = '$reg_prodc[referencia_prod]' ";
		$exe_qtd1 = mysql_query($sql_qtd1, $base) or die (mysql_error());
		
		$sql_qtd2 = "UPDATE produtos SET  Estoque = Estoque - '$qtd_prod' WHERE Codigo = '$reg_prodc[referencia_prod]'  ";
		$exe_qtd2 = mysql_query($sql_qtd2, $base) or die (mysql_error());	
		//	$sql_alt_status = "UPDATE cotacao SET situacao = 'F' WHERE id = '$ide' "; 
		//	$exe_alt_status = mysql_query($sql_alt_status, $base) or die (mysql_error());	
			
		$sql_del = "DELETE FROM cotacao WHERE id = '".$reg_prodp['id']."'";
		$sql_exe = mysql_query($sql_del)or die (mysql_error());
		
		$sql_itens = "DELETE FROM itens_cotacao WHERE id_cotacao = '".$reg_prodp['id']."'";
		$exe_itens = mysql_query($sql_itens)or die (mysql_error());
					}
				}
			}
			echo "<script language='javaScript'>window.location.href='pesquisa_pedido.php?id_pedido=$id_pedido'</script>";
		}	
	}
?>		
          <tr bgcolor="#FFFFFF" >
            <td height="23" colspan="5"><div align="right">
              Total&nbsp;</div></td>
            <td><?=guarani($total_carrinho)?>   <? echo $forma_pgto ?></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>
            <input name="enviar" id='enviar' value="        " class="botao" style="background:url(/images/handshak.ico)" type="button" onclick="inserirPedido()" /></td>
            <td colspan="5"><input name="submit" type="button" onclick="window.close()" value="Abandonar" />
            <label></label></td>
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
<input type="button" value="Volver" name="LINK1" onclick="navegacao('voltar')" />
<hr width="100%" size="14" noshade="noshade" />
		<p>
		  <input type="submit" name="Submit" value="" class="botaoSubmit" />
</p>
</body>
</html>