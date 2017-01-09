<?
	require_once("verifica_login.php");
	require_once("config.php");
	require_once("biblioteca.php");
	conexao();
	$sql = "SELECT * FROM caixa WHERE usuario_id = " . $id_usuario." AND status = 'A'";
	$rs = mysql_query($sql) or die (mysql_error() .' '.$sql);
	$num_rows = mysql_num_rows($rs);
	$msg = $_GET['msg'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Controle de Caja -  <? echo $title ?></title>
<script type="text/javascript" src="/js/jquery/jquery/jquery.js"></script>
<script type="text/javascript">
	function controle_caixa(op){
		$("#op").val(op);
		document.getElementById('frm_caixa').submit();
	}
</script>
</head>

<body bgcolor="#F6F5F0">

<div align="center">
  <table width="100%" border="1" bordercolor="#FFFFFF">
    <tr>
      <td bgcolor="#00FF66"><div align="center"><strong><font color="#FFFFFF">ACOMPANHAMENTO DE RECEITAS E DESPESAS</font></strong></div></td>
    </tr>
  </table>
  <p align="center"><? echo $msg?></p>
</div>
<form id="frm_caixa" name="frm_caixa" method="post" action="caixa_controller_fin.php">
  <p>
    <input type='hidden' name='op' id='op'/>
  </p>
  <table width="100%" border="0">
  <tr>
    <td colspan="2" bgcolor="#00FF66"><strong><font color="#000000">Usuario logado:</font></strong></td>
    <td colspan="2" bgcolor="#00FF66"><strong><font color="#000000">ABRIR / ENCERRAR MES</font></strong></td>
  </tr>
  <tr>
  	<td colspan="2"><strong>Usuario: </strong><?=$nome_user?></td>
    <td colspan="2" bordercolor="#0066FF" bgcolor="#F6F5F0">
		<? if($num_rows > 0){?>
			<input type="button" name="button" value="Encerrar" onclick="controle_caixa('f')" disabled="disabled"/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#0000FF">&nbsp;</font>
		<? }else{ ?>
			<input type="button" name="abrir" value="Abrir" onclick="controle_caixa('a')"/>
	  <? }?>	</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#F6F5F0">&nbsp;</td>
    <td width="11%" bgcolor="#F6F5F0">&nbsp;</td>
    <td width="64%" bgcolor="#F6F5F0">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#00FF66"><strong><font color="#000000">Filtros Pesquisa </font></strong></td>
    <td colspan="2" bgcolor="#00FF66"><strong><font color="#000000">Caja </font></strong></td>
  </tr>
  <tr>
    <td width="7%"><strong>Status:</strong></td>
	  <td width="18%"><select name='status' id='status'>
        <option value='a'>Aberto</option>
        <option value='f'>Fechado</option>
      </select></td>
  <tr>
    <td>&nbsp;</td>
	<td><input type="button" name="Submit2" value="Pesquizar" disabled="disabled" /></td>
	<td colspan="2">&nbsp;</td>
  </tr>
	<tr>
	  <td colspan="4" bordercolor="#0066FF" bgcolor="#F6F5F0">&nbsp;</td>
    </tr>
	<tr>
      <td colspan="4" bordercolor="#0066FF" bgcolor="#F6F5F0">&nbsp;</td>
	</tr>
  <tr><td colspan="2"></tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="8"><div align="center"><strong>Lista Cajas </strong></div></td>
    </tr>
  <tr>
    <td width="4%" bgcolor="#00FF66"><strong><font color="#000000">Caja</font></strong></td>
    <td width="12%" bgcolor="#00FF66"><strong><font color="#000000">Fecha Abertura </font></strong></td>
    <td width="13%" bgcolor="#00FF66"><font color="#000000"><strong>Fecha Fechamento</strong></font> </td>
    <td width="14%" bgcolor="#00FF66"><div align="right"><font color="#000000"><strong>Valor Abertura </strong></font></div></td>
    <td width="18%" bgcolor="#00FF66"><div align="right"><strong>Transferido a Banco</strong></div></td>
    <td width="14%" bgcolor="#00FF66"><div align="right"><font color="#000000"><strong>Valor Fechamento</strong></font></div></td>
    <td width="14%" bgcolor="#00FF66"><div align="center"><strong><font color="#000000">Status</font></strong></div></td>
    <td width="11%" bgcolor="#00FF66"><strong><font color="#000000">User</font></strong></td>
  </tr>
  <?
		if($perfil_id == 1){
			$sql_lista = "SELECT * FROM caixa ORDER BY id DESC ";
		}
		else if ($perfil_id == 2){
			$sql_lista = "SELECT c.*, u.nome_user FROM caixa c, usuario u WHERE c.usuario_id=".$id_usuario;	
			$sql_lista.=" AND c.usuario_id = u.id";
		}
		$rs_lista = mysql_query($sql_lista) or die(mysql_error().'-'.$sql_lista);
		$num_rows = mysql_num_rows($rs_lista);
		$i=0;
		while($linha=mysql_fetch_array($rs_lista)){
			if ($i%2==0) 
				$cor = "#CCCCCC";
			else 
				$cor = "#FFFFFF";
	?>
  <tr bgcolor="<? echo $cor?>">
    <td><?=$linha['id']?></td>
    <td><?=ajustaData($linha['data_abertura'])?></td>
    <td><?=ajustaData($linha['data_fechamento'])?></td>
    <td><div align="right">
      <?=number_format($linha['valor_abertura'],2,",",".")?>
    </div></td>
    <td><div align="right">
      <?=number_format($linha['valor_transf_banco'],2,",",".")?>
    </div>
      <div align="right"></div></td>
    <td><div align="right">
      <?=number_format($linha['valor_fechamento'],2,",",".")?>
    </div>
      <div align="right"></div></td>
    <td>
        <div align="center">
          <?
            if($linha['status'] =='F')
                echo "Encerrado";
    		else
                echo "Aberto";
		?>    
        </div></td>
    <td><?=$linha['usuario_id']?></td>
  </tr>
  <? 
		$i++;
	}
	 ?>
</table>
<p>&nbsp;</p>
</form>
<table width="100%" border="0">
  <tr>
    <td colspan="8" bgcolor="#00FF66"><div align="center"><strong>MOVIMIENTOS DE CAJA </strong></div></td>
  </tr>
  <tr>
    <td width="19%" height="23" bgcolor="#CCCCCC"><strong>Receita</strong></td>
    <td width="11%" bgcolor="#CCCCCC"><strong>Documento</strong></td>
    <td width="11%" bgcolor="#CCCCCC"><strong>C.pagar</strong></td>
    <td width="12%" bgcolor="#CCCCCC"><strong>Caixa Balcao</strong></td>
    <td width="12%" bgcolor="#CCCCCC"><strong>Data</strong></td>
    <td width="11%" bgcolor="#CCCCCC"><strong>Caja N&ordm; </strong></td>
    <td width="11%" bgcolor="#CCCCCC"><strong>Fornecedor</strong></td>
    <td width="13%" bgcolor="#CCCCCC"><strong>Valor</strong></td>
  </tr>
<?php

		$sql_lancamentos = "SELECT l.*, c.* FROM lancamento_caixa l, caixa c WHERE c.status = 'A' group by l.id ";
		$exe_lancamentos = mysql_query($sql_lancamentos) or die(mysql_error().'-'.$sql_lancamentos);
		while ($linha_lancamentos = mysql_fetch_array($exe_lancamentos)) {
		
			$data2 = $linha_lancamentos['data_lancamento'];
			$hora2 = $linha_lancamentos['dt_lancamento'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			if ($linha_lancamentos['receita_id'] == '7') {
				$receita = "TRANSF. DE CAIXA";
				}
			else if ($linha_lancamentos['receita_id'] == '2') {
				$receita = "SALIDA";
				}
			else if ($linha_lancamentos['receita_id'] == 6) {
				$receita = "CRED. CLIENTE";
				}
		   
			
?>
  
  <tr>
    <td bgcolor="#E9E9E9"><div align="center">
      <?=$receita?>
    </div></td>
    <td bgcolor="#E9E9E9"><?=$linha_lancamentos['num_nota']?></td>
    <td bgcolor="#E9E9E9"><div align="center">
      <?=$linha_lancamentos['contas_pagar_id']?>
    </div></td>
    <td bgcolor="#E9E9E9"><div align="center">
      <?=$linha_lancamentos['caixa_balcao_id']?>
    </div></td>
    <td bgcolor="#E9E9E9"><div align="right">
      <?=$novadata?>
    </div></td>
    <td bgcolor="#E9E9E9"><div align="center">
      <?=$linha_lancamentos['caixa_id']?>
    </div></td>
    <td bgcolor="#E9E9E9"><div align="center">
      <?=$linha_lancamentos['fornecedor_id']?>
    </div></td>
    <td bgcolor="#E9E9E9"><div align="right">
      <?=number_format($linha_lancamentos['valor'],2,",",".")?>
    </div></td>
  </tr>
  
<?
}
?>
</table>

<?php

	
	$sql_totais2 = "SELECT l.*, c.* FROM lancamento_caixa l, caixa c WHERE  c.status = 'A' AND c.id = l.caixa_id  ";
	$exe_totais2 = mysql_query($sql_totais2) or die (mysql_error().'-'.$sql_totais2);
	while ($linha_lancamentos = mysql_fetch_array($exe_totais2)){
	
	$receita_id = $linha_lancamentos['receita_id'];
	
	$vl_pago = $linha_lancamentos['valor'];
				if($receita_id == 7){
					$total_entradas += $vl_pago;	
				}
				else if($receita_id == 2){
					$total_saidas += $vl_pago;	
				}
				
	$total_geral = ($total_entradas - $total_saidas) ;
}
?>
<table width="84%" border="0">
  <tr>
    <td bgcolor="#F6F5F0">&nbsp;</td>
    <td bgcolor="#F6F5F0">&nbsp;</td>
  </tr>
  <tr>
    <td width="87%" bgcolor="#F6F5F0"><div align="right"> Total de Entradas: </div></td>
    <td width="13%" bgcolor="#F6F5F0"><div align="right">
      <strong>
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
</table>
</body>
</html>