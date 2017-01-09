<? require_once("verifica_login.php");
	require_once("config.php");
	require_once("biblioteca.php");
	conexao();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Transferencia de saldo - <? echo $title; ?></title>
 <script type="text/javascript">
function setaFoco(){
			document.getElementById('valor').focus();
			document.getElementById('valor').select();
	}
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='';
 }
 else if(lugar=='Nueva'){
  window.location.href='caixa.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
    </script>
<style type="text/css">
body {
	font: normal 11px auto "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	color: #4f6b72;
	background: #E6EAE9;
}.style3 {font-size: 12px; font-weight: bold; }
.style4 {
	font-size: 12px;
	font-weight: bold;
	color: #0000FF;
}
.style5 {
	color: #0000FF;
	font-weight: bold;
}
.style6 {
	color: #000000;
	font-weight: bold;
	font-size: 14px;
}
</style>
</head>
<body onload='setaFoco()'>
<p align="center" class="Estilo1"><? echo $cabecalho ?></p>
<form name='form_caixa' id='form_caixa' action='caixa_transf.php?acao=trf' method='post'>
<input type='hidden' name='op' id='op' value='cf'/>
<table width="887" border="0">
  <tr>
    <td bgcolor="#FF0000"><div align="center"><strong><font color="#FFFFFF">TRANSFERENCIA DE SALDO</font></strong></div></td>
  </tr>
</table>
<table width="22%" border="0">
  <tr>
    <td width="41%">USUARIO:</td>
    <td width="59%"><?=$nome_user ?>&nbsp;</td>
  </tr>
</table>
<?php
			//echo $num_rows;
			$sql_caixa = "SELECT * FROM caixa_balcao WHERE st_caixa = 'A' AND usuario_id = '".$id_usuario."' ";
			$rsb = mysql_query($sql_caixa) or die (mysql_error() .' '.$sql_caixa);
			$num_rowsb = mysql_num_rows($rsb);
			if($num_rowsb > 0){
			$saldo_abertura=0.00;
			$linha_caixa = mysql_fetch_array($rsb);
			$id_caixa = $linha_caixa['id'];
			$dt_abertura = $linha_caixa['dt_abertura'];
			$transferido = $linha_caixa['vl_transferido_fin'];
			$saldo_abertura = $linha_caixa['vl_abertura'];
			}
		//	$sql_lancamentos = "SELECT * FROM lancamento_caixa_balcao WHERE caixa_id = '".$id_caixa."' ";
		//	$rsc = mysql_query($sql_lancamentos);
		//	while($reg_linha = mysql_fetch_array($rsc)){ 
			
			$sql_totais2 = "SELECT l.*, c.* FROM lancamento_caixa_balcao l, caixa_balcao c WHERE c.usuario_id = '".$id_usuario."' AND c.st_caixa = 'A' AND c.id = l.caixa_id   ";
			$exe_totais2 = mysql_query($sql_totais2) or die (mysql_error().'-'.$sql_totais2);
			while ($linha_totais2 = mysql_fetch_array($exe_totais2)){
			
			$saldo_saidas=0.00;
			$total_entradas=0.00;
			$total_creditos=0.00;
			$total_devolvidos_cl=0.00;
			$saidas_geral=0.00;
			$saldo_fechamento=0.00;
			
echo	 $receita_id = $linha_totais2['receita_id'];
	
	 $vl_pago = $linha_totais2['vl_pago'];
				
				if($receita_id == 1){
				$entradas += $vl_pago;	
				}
		
				else if($receita_id==7){
					$transf += $vl_pago;
			    }
				else if($receita_id==2){
					$saidas += $vl_pago;
			    }
				
				$saidas_geral = $saidas + $transf;
				$entradas_geral = $entradas;
			
			//$saldo_abertura = $linha_caixa['vl_abertura'];
			$saldo_fechamento = ($saldo_abertura+$entradas_geral) - $saidas_geral;
		
		}	
	//}		
?>
<table border="1" width="100%">
  <tr>
    <td colspan="2" bgcolor="#E6EAE9"><div align="center" class="style5"><span class="style4">Movimenta&ccedil;&atilde;o</span></div></td>
  </tr>
  <tr>
    <td width="43%"><span class="style3">Data Abertura</span></td>
    <td width="57%"><span class="style3">
      <?=ajustaData($dt_abertura)?>
    </span> </td>
  </tr>
  
  <tr>
    <td><span class="style3">Total Entradas </span></td>
    <td><span class="style3">
      <?=formata($entradas)?>
        <input type='hidden' name='vl_mov_entrada' id='vl_mov_entrada' value="<?=$total_entradas?>"/>
    </span></td>
  </tr>
  <tr>
    <td><span class="style3">Total Salidas </span></td>
    <td><span class="style3">
      <?=formata($saidas_geral)?>
      <input type='hidden' name='vl_mov_saida' id='vl_mov_saida' value="<?=$total_saidas?>"/>
    </span></td>
  </tr>
  <tr>
    <td><span class="style3">Total Creditos Clientes</span></td>
    <td><span class="style3">
      <?=formata($total_creditos)?>
      <input type='hidden' name='vl_mov_creditos' id='vl_mov_creditos' value="<?=$total_creditos?>"/>
    </span></td>
  </tr>
  <tr>
    <td><span class="style3">Total Devolucoes por cliente</span></td>
    <td><span class="style3">
      <?=formata($total_devolvidos_cl)?>
      <input type='hidden' name='vl_mov_devolucao' id='vl_mov_devolucao' value="<?=$total_creditos?>"/>
    </span></td>
  </tr>
  <tr>
    <td bgcolor="#E6EAE9"><strong>Total Transferido ao Financeiro</strong></td>
    <td bgcolor="#E6EAE9"><span class="style3">
      <?=formata($transferido)?>
      <input type='hidden' name='vl_mov_transferido_fin' id='vl_transferido_fin' value="<?=$total_creditos?>"/>
    </span></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#E6EAE9"><div align="center" class="style4"><span class="style5">SITUACAO DO  CAIXA ATUAL</span></div></td>
  </tr>
  <tr>
    <td><span class="style3">Saldo Abertura </span></td>
    <td><span class="style3">
      <?=formata($saldo_abertura)?>
    </span></td>
  </tr>
  <tr>
    <td><span class="style3">Saldo Atual</span></td>
    <td><span class="style3">
      <?=formata($saldo_fechamento)?>
        <input type='hidden' name='vl_fechamento' id='vl_fechamento' value="<?=$saldo_fechamento?>"/>
    </span></td>
  </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#E6EAE9">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="1">
  <tr>
    <td><div align="center" class="style6">TRANSFERENCIA PARA O CAIXA GERAL</div></td>
    </tr>
  <tr>
    <td><strong>INFORME O VALOR A TRANSFERIR</strong></td>
    </tr>
  <tr>
    <td><label>
      <input type="text" name="valor" id="valor" />
      <input type="submit" name="button" id="button" value="Transferir" />
      Obs: No use punto o coma, ex: 800000 (Ochocentos mil guaranies)
    </label></td>
    </tr>
</table>
<?php 
		if ($_GET['acao'] == "trf") {
			$valor_trf = $_POST['valor'];
			
			$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 3 AND moeda.id = 3 GROUP BY cm.id DESC limit 0,1 ";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
	
	$valor_cambiado = $valor_trf;
			
			$sqld = "SELECT * FROM caixa WHERE status = 'A'  ";
			$rsd = mysql_query($sqld) or die (mysql_error() .' '.$sqld);
			$num_rowsd = mysql_num_rows($rsd);
			$reg_trf = mysql_fetch_array($rsd);		
			if($num_rowsd > 0){
			$id = $reg_trf['id'];
			
			
			
			if ($saldo_fechamento >= $valor_trf) {
			$sql_trf = "INSERT INTO lancamento_caixa (receita_id,caixa_id,data_lancamento,caixa_balcao_id,valor) VALUES('7', '$id', NOW(), '$id_caixa', '$valor_cambiado') ";
			$exe_trf = mysql_query($sql_trf) or die (mysql_error().'-'.$sql_trf);
			
			$sql_trfb = "INSERT INTO lancamento_caixa_balcao (receita_id,dt_lancamento,caixa_id,vl_pago) VALUES('7', NOW(), '$id_caixa', '$valor_trf') ";
			$exe_trfb = mysql_query($sql_trfb) or die (mysql_error().'-'.$sql_trfb);

			$sql_update = "UPDATE caixa_balcao SET vl_transferido_fin = vl_transferido_fin + '$valor_trf' WHERE id = '".$id_caixa."' ";
			$exe_update = mysql_query($sql_update);
			
			echo "<script language='javaScript'>window.location.href='caixa.php'</script>";
	}
	else {
			echo "<br> <strong>SALDO A TRANSFERIR INSUFICIENTE NO MOMENTO:</br> ".number_format($valor_trf)." </strong>";
			echo "<br> <input type='button' value='Voltar' name='LINK12' onclick='navegacao('Nueva')' />";
			exit;
		}
	}
	echo "<br> <strong>-- CAJA FINANCIERO GERAL ENCERRADO --</br></strong>";
}
?>
<p><strong>------ O VALOR  INFORMADO SER&Aacute; CONVERTIDO EM REAIS CONFORME O CAMBIO ATUAL ------</strong></p>
<p>&nbsp;</p>
<p>
  <input type="button" value="Volver" name="LINK12" onclick="navegacao('Nueva')" />
</p>
</form>
</body>
</html>