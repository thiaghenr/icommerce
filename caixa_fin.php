<? require_once("verifica_login.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Encerramento de Caixa</title>
<script type="text/javascript">
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='';
 }
 else if(lugar=='Nueva'){
  window.location.href='situacao_fin.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
 </script>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 36px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<p align="center" class="Estilo1"><? echo $cabecalho ?></p>
<form name='form_caixa' id='form_caixa' action='caixa_controller_fin.php' method='post'>
<input type='hidden' name='op' id='op' value='cf'/>
<table width="887" border="0">
  <tr>
    <td bgcolor="#FF0000"><div align="center"><strong><font color="#FFFFFF"></font><font color="#FFFFFF">Controle de Caja </font></strong></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="22%" border="0">
  <tr>
    <td width="41%">USUARIO:</td>
    <td width="59%"><?=$nome_user ?>&nbsp;</td>
  </tr>
</table>
<table border="1" width="100%">
  <tr>
    <td colspan="2" bgcolor="#ECE9D8"><div align="center"><strong>MOVIMENTACAO</strong></div></td>
  </tr>
  <tr>
    <td width="43%">Data Abertura</td>
    <td width="57%"><?=ajustaData($dt_abertura)?>    </td>
  </tr>
  <tr>
    <td>Data Encerramento </td>
    <td><?=date('d/m/Y')?></td>
  </tr>
  
  
  <tr>
    <td>Total Entradas </td>
    <td><?=formata($total_entradas)?>
      <input type='hidden' name='vl_mov_entrada' id='vl_mov_entrada' value="<?=$total_entradas?>"/></td>
  </tr>
  <tr>
    <td>Total Salidas </td>
    <td><?=formata($total_saidas)?>
        <input type='hidden' name='vl_mov_saida' id='vl_mov_saida' value="<?=$total_saidas?>"/></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#ECE9D8"><div align="center"><strong>SALDO</strong></div></td>
  </tr>
  <tr>
    <td>Saldo Abertura </td>
    <td><?=formata($saldo_abertura)?></td>
  </tr>
  <tr>
    <td>Saldo Encerramento </td>
    <td><?=formata($saldo_fechamento)?>
        <input type='hidden' name='vl_fechamento' id='vl_fechamento' value="<?=$saldo_fechamento?>"/></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input name="submit2" type='submit' value="Confirmar Encerramento"/></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>
  <input type="button" value="Volver" name="LINK12" onclick="navegacao('Nueva')" />
</p>
</form>
</body>
</html>