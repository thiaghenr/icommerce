<?
  require_once("verifica_login.php");
  require_once("biblioteca.php");
  include "config.php";
  conexao();

  $sql_caixa_balcao = "SELECT * FROM caixa_balcao WHERE usuario_id = " . $id_usuario." AND st_caixa = 'A'";
  $rs_caixa_balcao = mysql_query($sql_caixa_balcao);
  $num_caixa = mysql_num_rows($rs_caixa_balcao);

  $ide = $_GET['ide'];
  $data= date("Y/m/d"); // captura a data
  $hora= date("H:i:s"); //captura a hora

  $sql_cambio = "SELECT m.sigla_moeda, cm.vl_cambio FROM cambio_moeda cm INNER JOIN moeda m ON (cm.moeda_id = m.id)";
  $rs_cambio = mysql_query($sql_cambio);

  $cambios = array();
  $cambio_dolar;
  $cambio_guarani;
  $cambio_real;

  while($linha_cambio=mysql_fetch_array($rs_cambio)){
    $cambios[] = $linha_cambio['vl_cambio'];
  }
  $cambio_dolar = $cambios[0];
  $cambio_real = $cambios[1];
  $cambio_guarani = $cambios[2];


  $sql_total = "SELECT prvenda, qtd_produto FROM itens_pedido WHERE id_pedido = '$ide' ";
  $rs_total = mysql_query($sql_total) or die(mysql_error().''. $sql_total);

  $total_pedido = 0;

  while ($linha_total = mysql_fetch_array($rs_total)) {
      
  }

  $sql_pedido = "SELECT * FROM pedido WHERE id = $ide";
  $rs_pedido = mysql_query($sql_pedido);
  $linha_pedido = mysql_fetch_array($rs_pedido);
  $total_pedido = $linha_pedido['total_nota'];
  $forma_pgto_id = $linha_pedido['forma_pagamento_id'];
  $frete =  $linha_pedido['frete'];

  $sql_forma_pgto = "SELECT * FROM forma_pagamento WHERE id = $forma_pgto_id";
  $rs_forma_pgto = mysql_query($sql_forma_pgto);
  $linha_forma_pgto = mysql_fetch_array($rs_forma_pgto);
  $nm_total_parcela = $linha_forma_pgto['nm_total_parcela'];
  $ck_entrada = $linha_forma_pgto['ck_entrada'];

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Finalizar Venta</title>
<script type='text/javascript' src="js/jquery/jquery/jquery.js"></script>
<script type='text/javascript' src="js/jquery/mascara/jquery-numeric.js"></script>
<script type='text/javascript' src="js/jquery/mascara/jquery-floatnumber.js"></script>
<script type='text/javascript' src="js/funcoes.js"></script>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 36px;
	font-weight: bold;
}
.Estilo2 {
	color: #FFFFFF;
	font-weight: bold;
}
body {
	background-color: #F6F5F0;
}
-->
</style>
<script type="text/javascript">
var vl_cambio_dolar = "<?=$cambio_dolar?>";
var vl_cambio_guarani = "<?=$cambio_guarani?>";
var vl_cambio_real = "<?=$cambio_real?>";

function lancarVenda(id_pedido_param){
    $("#id_pedido").val(id_pedido_param)
    $("#formVenda").submit();
}

function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='\result_pedido.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='\pesquisa_pedido_venda.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>

</head>

<body  onload="document.getElementById('vl_pago').focus()">
<form id='formVenda' name='formVenda' method="post" action="lancamento_venda_controller.php">
    <input type='hidden' name="id_pedido" id='id_pedido' value="<?=$ide?>"/>
    <input type='hidden' name="forma_pgto_id" id='forma_pgto_id' value='<?=$forma_pgto_id?>'/>


<div align="center" class="Estilo1"><? echo $cabecalho ?></div>
<p>&nbsp;</p>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#FF0000" colspan="2">
        <div align="center"><span class="Estilo2"><strong>Lancar Venda</strong></span></div>
    </td>
  </tr>
  <tr>
  <? if($nm_total_parcela==0){?>
    <td>
    <input type='hidden' name="tipo_venda" id='tipo_venda' value='VA'/>
      <fieldset>
        <legend>Laçamento</legend>

        <table>
            <tr>
                <td>Total</td>
                <td>
                    <input type='text' name='vl_total' id='vl_total' value='<?=number_format($total_pedido,2,",",".")?>' class='numeric'/>
                </td>
            </tr>
            <tr>
                <td>Valor Pago</td>
                <td>
                    <input type='text' name='vl_pago' id='vl_pago'/>
                </td>
            </tr>
            <tr>
                <td>Moeda</td>
                <td>
                    <input type='radio' name='moeda[]' id='moeda_reais' class='radios'/>Guarani&nbsp;
                    <input type='radio' name='moeda[]' id='moeda_reais' class='radios'/>Dolar&nbsp;
                    <input type='radio' name='moeda[]' id='moeda_reais' class='radios' checked='checked'/>Reais&nbsp;
                </td>
            </tr>
        </table>
      </fieldset>
    </td>
    <td>
      <fieldset>
        <legend>Troco</legend>
        <table>
            <tr>
                <td>Guarani</td>
                <td><input type='text' name='vl_troco_guarani' id='vl_troco_guarani'/></td>
            </tr>
            <tr>
                <td>Dólar</td>
                <td><input type='text' name='vl_troco_dolar' id='vl_troco_dolar'/></td>
            </tr>
            <tr>
                <td>Real</td>
                <td><input type='text' name='vl_troco_real' id='vl_troco_real'/></td>
            </tr>
        </table>
      </fieldset>
    </td>
    <?}else{
        if($ck_entrada==0){
        ?>
        <td>
            <input type='hidden' name="tipo_venda" id='tipo_venda' value="PSE"/>
           <table>
                <tr>
                    <td>Valor Total</td>
                    <td>
                        <?=number_format($total_pedido,2,",",".")?>
                        <input type="hidden" name='vl_total' id='vl_total' value='<?=number_format($total_pedido,2,",",".")?>' class='numeric'/>

                    </td>
                </tr>
           </table>
        </td>
        <?
        }
        else{
        ?>
        <td>
            <input type='hidden' name="tipo_venda" id='tipo_venda' value="PCE"/>
           <table>
                <tr>
                    <td>Valor Total</td>
                    <td>
                        <?=($total_pedido)?>
                        <input type='hidden' name='vl_total' id='vl_total' value='<?=number_format($total_pedido,2,",",".")?>' class='numeric'/>
                    </td>
                </tr>
                <tr>
                    <td>Valor Entrada</td>
                    <td><input type='text' name="vl_entrada" id='vl_entrada'/></td>
                </tr>
           </table>
        </td>
    <?  }
    }
    ?>
  </tr>
</table>
<table border="0" width="100%">
  <tr>
    <td width="5%" bgcolor="#85C285"><span class="Estilo2">Pedido</span></td>
    <td width="13%" bgcolor="#85C285"><span class="Estilo2">Cod. Cliente</span></td>
    <td width="33%" bgcolor="#85C285"><span class="Estilo2">Nome</span></td>
    <td width="13%" bgcolor="#85C285"><span class="Estilo2">Data</span></td>
    <td width="13%" bgcolor="#85C285"><span class="Estilo2">Vendedor</span></td>
  </tr>
   
  <?
	$sql_lista = "SELECT * FROM pedido WHERE id = '$ide' ";
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
    <td width="13%" bgcolor="#CCCCCC"><?=$reg_lista['id']?></td>
    <td width="13%" bgcolor="#CCCCCC"><?=$reg_lista['controle_cli']?></td>
    <td width="13%" bgcolor="#CCCCCC"><?=$reg_lista['nome_cli']?></td>
    <td width="13%" bgcolor="#CCCCCC"><?=$novadata ?></td>
    <td width="13%" bgcolor="#CCCCCC"><?=$reg_lista['vendedor']?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table border="1" bordercolor="#000000" style="border-collapse: collapse" width="100%">
  <tr>
    <td width="6%"><strong>Rem</strong></td>
    <td width="17%"><strong>Cod Producto</strong></td>
    <td width="43%"><strong>Descripcion<strong></strong></strong></td>
    <td width="10%"><div align="right"><strong>Valor<strong></strong></strong></div></td>
    <td width="10%"><div align="right"><strong>Qtd</strong></div></td>
    <td width="14%"><div align="right"><strong>Subtotal</strong></div></td>
  </tr>
  <?
	$sql_listas = "SELECT * FROM itens_pedido WHERE id_pedido = '$ide' ";
	$exe_listas = mysql_query($sql_listas, $base);
	$num_listas = mysql_num_rows($exe_listas);
	//if ($num_lista > 0) {

   	while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)) {
	$total_carrinho += ($reg_listas['prvenda']*$reg_listas['qtd_produto']);
  ?>
  <tr>
    <td width="6%"><a href="lancar_venda.php?acao=del&amp;id=<?=$reg_listas['referencia_prod']?>"><img src="images/delete.gif" width="12" height="14" border="0"/></a></td>
    <td width="17%"><?=$reg_listas['referencia_prod']?></td>
    <td width="43%"><?=substr($reg_listas['descricao_prod'],0,38)?></td>
    <td width="10%"><div align="right">
      <?=number_format($reg_listas['prvenda'],2,",",".")?>
    </div></td>
    <td width="10%"><div align="right">
      <?=$reg_listas['qtd_produto']?>
    </div></td>
    <td width="14%"><div align="right">
      <?=number_format($reg_listas['prvenda']*$reg_listas['qtd_produto'],2,",",".")?>
    </div></td>
  </tr>
  <?
		//}
	}
	?>
  <tr>
    <td height="23" colspan="4">&nbsp;</td>
    <td height="23">&nbsp;</td>
    <td height="23"><div align="right"><strong>Subtotal:
      <?=number_format($total_carrinho,2,",",".")?>
    </strong></div></td>
  </tr>
  <tr>
    <td height="23" colspan="4">&nbsp;</td>
    <td height="23">&nbsp;</td>
    <td height="23"><div align="right"><strong>Frete: 
      <?=number_format($frete,2,",",".")?>
    </strong></div></td>
  </tr>
  <tr>
    <td height="23" colspan="4"><div align="right"></div></td>
    <td height="23">&nbsp;</td>
    <td height="23"><strong>
      <div align="right"><strong>Total:&nbsp;</strong> 
        <?=number_format($total_pedido,2,",",".")?>
      </div></td>
  </tr>
</table>
   <?
if ($_GET['acao'] == "del") {
		if (isset($_GET['id'])) {
			if ($_GET['id']) {
				$id_prod = addslashes(htmlentities($_GET['id']));
				$sql_del = "DELETE FROM itens_pedido WHERE referencia_prod = '$id' AND id_pedido = '$ide' ";
				$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
			}
		}
	}

?>

<p>
    <? if($num_caixa){?>
    <input name="button" type='button' onclick=lancarVenda("<?=$reg_lista['id']?>") value='GRAVAR'/>
    <?
    }else
        echo "<div align='center'><font color='#ff0000'>Caixa não aberto! Abra um novo caixa</font></div>";
    }
    ?>
</p>

 <table width="5%" border="0">
   <tr>
     <td><input type="button" value="Nueva pesquiza" name="LINK12" onclick="navegacao('Nueva')" /></td>
   </tr>
 </table>
<p><a href="/pesquisa_pedido_venda.php?acao=lanca&id=<?=$reg_lista['id']?>"><strong></a></p>

<p>&nbsp;</p>
<p>&nbsp;</p>
</form>
</body>
</html>