<?
	require_once("../verifica_login.php");
	require_once("../config.php");
	require_once("../biblioteca.php");
	conexao();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>

<table width="87%" border="0">
  <tr>
    <td colspan="8" bgcolor="#C5D6FC"><div align="center"><strong>MOVIMENTOS DO CAIXA </strong></div></td>
  </tr>
  <tr>
    <td width="8%" bgcolor="#CCCCCC"><strong>Lanc</strong>.</td>
    <td width="17%" bgcolor="#CCCCCC"><strong>Receita</strong></td>
    <td width="8%" bgcolor="#CCCCCC"><strong>Caixa N&ordm; </strong></td>
    <td width="15%" bgcolor="#CCCCCC"><strong>Data</strong></td>
    <td width="9%" bgcolor="#CCCCCC"><strong>Pagare</strong></td>
    <td width="12%" bgcolor="#CCCCCC"><strong>Despesa</strong></td>
    <td width="16%" bgcolor="#CCCCCC"><strong>Venda</strong></td>
    <td width="15%" bgcolor="#CCCCCC"><strong>Valor</strong></td>
  </tr>
<?php

$idcaixa = $_GET['id'];

		$sql_lancamentos = "SELECT l.id AS idl,l.*, c.* FROM lancamento_caixa_balcao l, caixa_balcao c WHERE l.caixa_id = '$idcaixa' AND l.caixa_id = c.id ORDER BY l.id ";
		$exe_lancamentos = mysql_query($sql_lancamentos) or die(mysql_error().'-'.$sql_lancamentos);
		while ($linha_lancamentos = mysql_fetch_array($exe_lancamentos)) {
		
			$data2 = $linha_lancamentos['dt_lancamento'];
			$hora2 = $linha_lancamentos['dt_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			if ($linha_lancamentos['receita_id'] == 1) {
				$receita = "ENTRADA";
				}
			if ($linha_lancamentos['receita_id'] == 2) {
				$receita = "SALIDA";
				}
			if ($linha_lancamentos['receita_id'] == 3) {
				$receita = "DEVOLUCAO";
				}
			if ($linha_lancamentos['receita_id'] == 6) {
				$receita = "CRED. CLIENTE";
				}
			if ($linha_lancamentos['receita_id'] == 7) {
				$receita = "TRANSF. CAIXA";
				}
		   
			
?>
  
  <tr>
    <td bgcolor="#E9E9E9"><div align="center">
      <?=$linha_lancamentos['idl']?>
    </div></td>
    <td bgcolor="#E9E9E9"><div align="center">
      <?=$receita?>
    </div></td>
    <td bgcolor="#E9E9E9"><div align="center">
      <?=$linha_lancamentos['caixa_id']?>
    </div></td>
    <td bgcolor="#E9E9E9"><div align="right">
      <?=$novadata?>
    </div></td>
    <td bgcolor="#E9E9E9"><div align="center">
      <?=($linha_lancamentos['contas_receber_id'])?>
    </div></td>
    <td bgcolor="#E9E9E9"><div align="center">
      <?=($linha_lancamentos['lanc_despesa_id'])?>
    </div></td>
    <td bgcolor="#E9E9E9"><div align="center">
      <?=($linha_lancamentos['venda_id'])?>
    </div></td>
    <td bgcolor="#E9E9E9"><div align="right">
      <?=number_format($linha_lancamentos['vl_pago'],2,",",".")?>
    </div></td>
  </tr>
  
<?
}
?>
</table>
<?php

	$sql_totais = "SELECT l.*, c.* FROM lancamento_caixa_balcao l, caixa_balcao c WHERE c.id = l.caixa_id AND c.id = '$idcaixa' ";
	$exe_totais = mysql_query($sql_totais) or die (mysql_error().'-'.$sql_totais);
	while ($linha_totais = mysql_fetch_array($exe_totais)){
	
	$receita_id = $linha_totais['receita_id'];
	
	$vl_pago = $linha_totais['vl_pago'];
				if($receita_id == 7){
					$transferencias += $vl_pago;	
				}
				else if($receita_id == 2){
					$saidas += $vl_pago;	
				}
				else if($receita_id == 3){
					$devolucoes += $vl_pago;	
				}
				else if($receita_id == 6){
					$credito_cli += $vl_pago;	
				}
				else if($receita_id == 1){
					$entradas += $vl_pago;	
				}
		}
	$total_saidas = ($transferencias + $devolucoes + $saidas);
	$total_entradas = $entradas + $credito_cli;		
	$total_geral = ($total_entradas - $total_saidas) ;

?>
<table width="76%" border="0">
  <tr>
    <td bgcolor="#F6F5F0">&nbsp;</td>
    <td bgcolor="#F6F5F0">&nbsp;</td>
  </tr>
  <tr>
    <td width="83%" bgcolor="#F6F5F0"><div align="right"> Total de Entradas: </div></td>
    <td width="17%" bgcolor="#F6F5F0"><div align="right"> <strong>
      <?=number_format($total_entradas,2,",",".")?>
    </strong></div></td>
  </tr>
  <tr>
    <td bgcolor="#F6F5F0"><div align="right">Total de Salidas: </div></td>
    <td bgcolor="#F6F5F0"><div align="right"><strong>
      <?=number_format($total_saidas,2,",",".")?>
    </strong></div></td>
  </tr>
  <tr>
    <td bgcolor="#F6F5F0"><div align="right">Total General: </div></td>
    <td bgcolor="#F6F5F0"><div align="right"><strong>
      <?=number_format($total_geral,2,",",".")?>
    </strong></div></td>
  </tr>
  <tr>
    <td bgcolor="#F6F5F0"><font size="2">Total de Devolucoes:
      <?=number_format($devolucoes,2,",",".")?>
    </font></td>
    <td bgcolor="#F6F5F0">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F6F5F0"><div align="left"><font size="2">Total de Tranferencias:
      <?=number_format($transferencias,2,",",".")?>
    </font></div></td>
    <td bgcolor="#F6F5F0"><div align="right"></div></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
