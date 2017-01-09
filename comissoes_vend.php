<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$data= date("Y-m-d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$mes= date("m");
$vend = $_GET['vend'];
$_SESSION['vend'] = $vend;
$estado = $_GET['estado'];
if (empty ($estado)){
$abre = "none";
}
else {
$abre = $_GET['show'];
}

$sql_caixa_balcao = "SELECT * FROM caixa_balcao WHERE usuario_id = ". $id_usuario." AND st_caixa = 'A'";
$rs_caixa_balcao = mysql_query($sql_caixa_balcao);
$linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao, MYSQL_ASSOC);
$caixa_id = $linha_caixa_balcao['id'];


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pagamento de comissoes - <? echo $title ?> </title>
<style type="text/css">
body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #f2f1e2;
border-width:2px;
border-style:solid;
border-color:#a2bfe9;
}
<!--
.Estilo5 {font-size: 36px;
	font-weight: bold;
}
.Estilo6 {color: #FFFFFF}
-->
</style>
<link rel="stylesheet" href="/js/jquery/calendario/calendario.css"/>
<script type="text/javascript" src="/js/jquery/jquery/jquery.js"></script>
<script type="text/javascript" src="/js/jquery/calendario/jquery-calendar.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-numeric.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-floatnumber.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#data_ini").calendar({buttonImage: "images/calendar.gif"});
		$("#data_fim").calendar({buttonImage: "images/visualizar.JPG"});		
	
		$(".numeric").numeric(",");
	    $(".numeric").floatnumber(",",2);
	});	
</script>
<script>
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='\comissoes.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='\comissoes.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}

function setaFoco(){
		valor = '<?=$estado?>'
		if(valor.length > 0 )
			document.getElementById('valor').focus();
}

</script>
<style type="text/css">
<!--
.Estilo7 {
	color: #FFFF00;
	font-weight: bold;
}
.Estilo8 {font-family: "Times New Roman", Times, serif}
.Estilo10 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo14 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo17 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; }
.Estilo18 {font-size: 14px}
.Estilo19 {font-size: 14}
.Estilo20 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14; }
.Estilo21 {font-size: 12px}
.style1 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
</head>

<body onLoad="setaFoco()">

<p>
  <? 
  
 if ($_GET['acao'] == "receber") {
		if (isset($_GET['pagare'])) {
			if ($_GET['pagare']) {
				$pagare = $_GET['pagare'];
		
			$sql_listaz = "SELECT * FROM contas_receber  WHERE id = '$pagare' "; 
			$exe_listaz = mysql_query($sql_listaz, $base) or die (mysql_error());
			$linha = mysql_fetch_array($exe_listaz, MYSQL_ASSOC);
			
			$liquido2 = ($linha['vl_parcela'] - $linha['desconto']);
			$liquido = ($liquido2 - $linha['vl_recebido']);
			$venda_id = $linha['venda_id'];
			$receber_id = $linha['id'];
						
			if ($linha['status'] == 'A') {
			$sql_lancamento_caixa_balcao = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id,contas_receber_id) 
            VALUES (1,$caixa_id, NOW(), $liquido,$venda_id,$receber_id)";
            $exe_lancamento_caixa_balcao = mysql_query($sql_lancamento_caixa_balcao) or die ("SU CAJA ESTA CERRADO"); //mysql_error());
			
			$sql_total_devido = "UPDATE clientes SET saldo_devedor = saldo_devedor - '$valor_recebido' ";
			$exe_total_devido = mysql_query($sql_total_devido) or die (mysql_error());
			
			$sql_receber = "UPDATE contas_receber SET status = 'P' WHERE id = '$pagare'  ";
			$exe_receber = mysql_query($sql_receber, $base) or die (mysql_error().'-'.$sql_receber);
			}
			$sql_cont = "SELECT COUNT(*) AS aberto FROM contas_receber WHERE status = 'A' AND venda_id = '$venda_id' ";
			$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
			$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
						
			if ($reg_cont['aberto'] == 0) {
			$sql_fecha = "UPDATE venda SET st_venda = 'F' WHERE id = '$venda_id' ";
			$exe_fecha = mysql_query($sql_fecha);
					
					
			
				}
			}
  		}
  	}
?>
</p>
<p>&nbsp;</p>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#0EEAE0"><div align="center" class="Estilo7">PAGAMENTOS DE COMISSOES DE VENDEDORES</div></td>
  </tr>
</table>
<p align="center" class="Estilo5">&nbsp;</p>
<table width="100%" border="0" cellpadding="0" cellspacing="1" style="border: 1px solid blue; border-collapse: collapse">
  <tr>
    <td width="9%" height="21" bgcolor="#OEEAEO"><span class="Estilo6"><strong>Cod Cliente</strong></span></td>
    <td width="25%" bgcolor="#OEEAEO"><span class="Estilo6"><strong>Cliente</strong></span></td>
    <td width="11%" bgcolor="#OEEAEO"><span class="Estilo6"><strong>Valor Total Devido </strong></span></td>
  </tr>
  
  
  
  <?

	
		$sql_listas = "SELECT c.*, u.* FROM comissao c, usuario u WHERE c.user_id = u.id AND c.situacao = 'A' GROUP BY u.id "; 
	$exe_listas = mysql_query($sql_listas, $base);
	$num_listas = mysql_num_rows($exe_listas);
			$i=0;
			while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)) {
		
		$total_parcela += $reg_listas['vl_parcela'];
		
		$total_desconto += $reg_listas['desconto'];
		$total_pg_parcial += $reg_listas['vl_recebido'];
		
		$total_menos = $total_desconto + $total_pg_parcial;
		
		$total_devido2 = $total_parcela - $total_menos;
		$total_devido = $total_devido2 ;
		}	
		
		
	$sql_listas = "SELECT  SUM(valor_pedido) as total FROM comissao where user_id = '".$reg_lista['user_id']."' AND situacao = 'A'  ";
	$exe_listas = mysql_query($sql_listas, $base);
	$num_listas = mysql_num_rows($exe_listas);
	while ($reg_listas = mysql_fetch_array($exe_listas, MYSQL_ASSOC)) {
		
	
	
	}			
?>
  <tr>
    <td width="9%" bgcolor="#FFFFFF"><?=$reg_listas2['controle']?>&nbsp;</td>
    <td width="25%" bgcolor="#FFFFFF"><?=$reg_listas2['nome']?></td>
    <td width="11%" bgcolor="#FFFFFF"><?=guarani($total_devido)?>&nbsp;</td>
  </tr>
</table>

<form id="form1" name="form1" method="post" action="relatorio_cli.php?cli=<?=$_SESSION['vend']?>">
  <label>
  <input name="imprimir" type="radio" value="todos" checked/>
    Todos</label>
  <label>
  <input name="imprimir" type="radio" value="vencidos" />
  Vencidos</label>  

  <label>
  <input type="image" src="images/imp.jpg" value="submit" width="21" height="20" >

  </label>
</form>
<table width="100%" border="0" cellpadding="0" cellspacing="1" style="border: 1px solid blue; border-collapse: collapse">
  <tr>
    <td width="5%" bgcolor="#0EEAE0" class="Estilo21"><span class="Estilo6"><strong>Pedido</strong></span></td>
    <td width="6%" bgcolor="#0EEAE0" class="Estilo21"><span class="Estilo6"><strong>Venda</strong></span></td>
    <td width="6%" bgcolor="#0EEAE0" class="Estilo21"><span class="Estilo6 Estilo21 Estilo21"><strong>Pagare</strong></span></td>
    <td width="9%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="style1">Total Venda</div></td>
    <td width="10%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="style1"><strong>Data Compra </strong></div></td>
    <td width="6%" bgcolor="#0EEAE0" class="Estilo21"><div align="center" class="Estilo21"><span class="Estilo6"><strong>QTs </strong></span></div></td>
    <td width="9%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo21"><span class="Estilo6"><strong>Vencimento </strong></span></div></td>
    <td width="7%" bgcolor="#0EEAE0" class="Estilo21"><div align="center" class="Estilo21"><span class="Estilo6"><strong>N.  Qt</strong></span></div></td>
    <td width="9%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo21"><span class="Estilo6"><strong>Valor</strong></span></div></td>
    <td width="7%" bgcolor="#0EEAE0" class="Estilo21"><div align="center" class="Estilo21"><span class="Estilo6"><strong>Pg.Parcial</strong></span></div></td>
    <td colspan="2" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo6 Estilo19 Estilo21 Estilo21 Estilo21"><strong>Descuento</strong></div></td>
    <td width="9%" bgcolor="#0EEAE0" class="Estilo21"><div align="right" class="Estilo6 Estilo19 Estilo21 Estilo21"><strong>Total</strong></div></td>
    <td width="8%" bgcolor="#0EEAE0" class="Estilo21">&nbsp;</td>
  </tr>

<?php	
	
$sql_lista = "
	SELECT 
		ct.*, DATEDIFF(NOW(), 
		dt_vencimento) AS diferenca, 
		v.id AS ide,pedido_id 
		FROM 
			contas_receber ct, 
			venda v 
		WHERE 
			ct.clientes_id = '$cli' 
			AND ct.status = 'A' 
			AND v.id = ct.venda_id "; 
	$exe_lista = mysql_query($sql_lista, $base) or die ('-'.mysql_error());
	$num_lista = mysql_num_rows($exe_lista);
		
		$i=0;
		while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
			$total_parcial = ($reg_lista['vl_parcela'] - $reg_lista['desconto']);
			$total_geral = $total_parcial - $reg_lista['vl_recebido'];
		
			if ($i%2==0) 
				$cor = "#FFFFFF";
			else 
				$cor = "#C5D6FC";
				
			if ($reg_lista['diferenca'] >= 0)
				$cor = "#FF0000";
				
		//	$vl_parcelado = $reg_lista['vl_parcela'] * $reg_lista['nm_total_parcela'] ;
			
			$data2 = $reg_lista['dt_lancamento'];
			$hora2 = $reg_lista['dt_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$data3 = $reg_lista['dt_vencimento'];
			$hora3 = $reg_lista['dt_vencimento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
			$novahora2 = substr($hora3,11,2) . "h " .substr($hora3,14,2) . " min";
			
			?>
  <tr bgcolor="<? echo $cor?>" onmouseover="style.background='#FFDE9F'" onmouseout="style.background='<? echo $cor?>'">

    <td width="5%" height="19" class="Estilo8"><span class="Estilo17">
      <?=$reg_lista['pedido_id']?>
    </span></td>
    <td width="6%" height="19" class="Estilo8"><span class="Estilo17">
      <?=$reg_lista['venda_id']?>
    </span></td>
    <td width="6%" class="Estilo8"><span class="Estilo17">
      <?=$reg_lista['id']?>
    </span></td>
    <td width="9%" class="Estilo8""><div align="right" class="Estilo17">
      <?=guarani($reg_lista['vl_total'])?>
    </div></td>
    <td width="10%" class="Estilo8"><div align="right" class="Estilo17">
      <?=$novadata?>
    </div></td>
    <td width="6%" class="Estilo8"><div align="center" class="Estilo17">
      <?=$reg_lista['nm_total_parcela']?>
    </div></td>
    <td width="9%" class="Estilo8"><div align="right" class="Estilo17">
      <?=$novadata2?>
    </div></td>
    <td width="7%" class="Estilo8"><div align="center" class="Estilo17">
      <?=$reg_lista['nm_parcela']?>
    </div></td>
    <td width="9%" class="Estilo8"><div align="right" class="Estilo17">
      <?=guarani($reg_lista['vl_parcela'])?>
    </div></td>
    <td width="7%" class="Estilo17"><div align="right">
      <?=guarani($reg_lista['vl_recebido'])?>
    </div></td>
    <td width="2%"> <a href="cont_rec_cli.php?acao=descontar&id=<?=$reg_lista['id']?>&vend=<?=$vend?>&estado=show"><img src="images/desconto.jpg" alt="Conceder Descuento" width="16" height="17" border="0"  onclick="$('#m_div').show('slow')"  /></a>
      <div align="center"></div>
    <div align="center"></div>
    <div align="center"></div>
    <div align="center"></div>
    <div align="center"></div></td>
    <td width="7%"><span class="Estilo17">
      <?=guarani($reg_lista['desconto'])?>
    </span></td>
    <td width="9%" class="Estilo8"><div align="right" class="Estilo18"><span class="Estilo10">
      <?=guarani($total_geral)?>
    </span></div></td>
    <td width="8%" class="Estilo8"><div align="center" class="Estilo17"><a href="cont_rec_cli.php?acao=receber&pagare=<?=$reg_lista['id']?>&vend=<?=$_SESSION['vend']?>">recibir</a></div></td>
  </tr>
  <?
  $i++;
  }
   ?>
</table>
<p>&nbsp;</p>
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()"
    value="Cerrar" />
</font>
  <input type="button" value="Nueva pesquiza" name="LINK12" onclick="navegacao('Nueva')" />

<!-- <button id="btn1" onclick="$('#m_div').show('fast')">Exibir</button> 
<button id="btn2" onclick="$('#m_div').hide('slow')">Ocultar</button> -->
<p>
</p>
<p>
</p>
<div id="m_div" style="display:<?=$abre?> "> 
<?php
//$clis = $_POST['cli'];
//$ide = $_GET['id'];

		if ($_GET['acao'] == "desconto") {
		if (isset($_GET['ide'])) {
			if ($_GET['ide']) {
			$valor = $_POST['valor'];
			$id = $_GET['ide'];
		
		$sql_desconto = "UPDATE contas_receber SET desconto = $valor WHERE id = '$id' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());	
		
		echo "<script language='javaScript'>window.location.href='cont_rec_cli.php?cli=".$_SESSION['vend']."'</script>";
					
		}
	}
}
?>

  <?php
  		if ($_GET['acao'] == "descontar") {
		$id = $_GET['id'];
  		
		$sql_desconto = "SELECT * FROM contas_receber where id = '$id' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());
			$reg_desconto = mysql_fetch_array($exe_desconto, MYSQL_ASSOC); 
			
			$desconto = $reg_desconto['id'];
			$valor_final = $reg_desconto['vl_parcela'] - $reg_desconto['desconto'];
			
			$data2 = $reg_desconto['dt_lancamento'];
			$hora2 = $reg_desconto['dt_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$data3 = $reg_desconto['dt_vencimento'];
			$hora3 = $reg_desconto['dt_vencimento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
			$novahora2 = substr($hora3,11,2) . "h " .substr($hora3,14,2) . " min";
?>
<table width="100%" border="0">
  <tr>
    <td width="7%" height="21" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">PAGARE</span></td>
    <td width="6%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">VENDA</span></td>
    <td width="13%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">TOTAL VENDA </span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">DT COMPRA </span></td>
    <td width="3%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">QTs</span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">VENCIMENTO</span></td>
    <td width="6%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">N. QT </span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">VALOR </span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">PG.PARCIAL</span></td>
    <td width="9%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">DESCUENTO</span></td>
    <td width="16%" bgcolor="#CCCCCC"><span class="Estilo4 Estilo21">TOTAL</span></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$desconto?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$reg_desconto['venda_id']?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=guarani($reg_desconto['vl_total'])?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$novadata?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$reg_desconto['nm_total_parcela']?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$novadata2?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$reg_desconto['nm_parcela']?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=guarani($reg_desconto['vl_parcela'])?>
    </span></td>
    <td bgcolor="#FFFFFF"><?=guarani($reg_desconto['vl_recebido'])?></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=$reg_desconto['desconto']?>
    </span></td>
    <td bgcolor="#FFFFFF"><span class="Estilo4">
      <?=guarani($valor_final)?>
    </span></td>
  </tr>
</table>
<?
}
?>

<form action="cont_rec_cli.php?acao=desconto&ide=<?=$id?>&vend=<?=$vend?>" method="post">
<table width="36%" border="0">
  <tr>
    <td colspan="2" bgcolor="#0EEAE0"><span class="Estilo6"><strong>INFORME O VALOR DO DESCONTO</strong></span></td>
  </tr>
  <tr>
    <td width="18%"  bgcolor="#0EEAE0"><span class="Estilo6"><strong>VALOR:</strong></span></td>
    <td width="82%"><span class="Estilo4">
      <label>
      <input type="text" id="valor" name="valor"  />
      </label>
    </span></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>
   <input type="submit" name="Submit" value="Enviar" />
  </p></form>
</p>

</div>
<p></p>
</body>
</html>
