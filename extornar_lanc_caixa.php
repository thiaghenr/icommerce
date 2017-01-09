<?
	require_once("verifica_login.php");
	require_once("config.php");
	require_once("biblioteca.php");
	conexao();
	
	$lanc = $_GET['lanc'];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Extornar Lancamento de Caixa</title>

<script language="javascript">

function submitForm(idForm, acaoForm){
		document.getElementById(idForm).action = acaoForm;
		document.getElementById(idForm).submit();			
	}

function Fecha_Redireciona(link) {
  window.opener.location = link;
  self.close();
 }

</script>

<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-weight: bold;
}
body {
	background-color: #F6F5F0;
}
-->
</style>
</head>

<body>
		
        <p>&nbsp;</p>
        <p>&nbsp;</p>
		<span class="style1">Tem Certeza que Deseja Extornar o Seguinte Lancamento ?        </span>
		<form id='formCaixa' name='formCaixa' action='#' method='POST'>
		<table width="85%" border="1">
          <tr>
            <td width="17%" height="28"><p><strong>Lancamento</strong></p>            </td>
            <td width="12%"><strong>Pagare</strong></td>
            <td width="18%"><strong>Despesa</strong></td>
            <td width="13%"><strong>Venda</strong></td>
            <td width="21%"><strong>Valor</strong></td>
            <td width="19%"><label></label></td>
          </tr>
		  <?
		
			$sql_caixa = "SELECT * FROM lancamento_caixa_balcao WHERE id = '$lanc' ";
			$exe_caixa = mysql_query($sql_caixa);
			$reg_caixa = mysql_fetch_array($exe_caixa, MYSQL_ASSOC);
			
			$id = $reg_caixa['id'];
			$pagare = $reg_caixa['contas_receber_id'];
			$despesa = $reg_caixa['lanc_despesa_id'];
			$venda = $reg_caixa['venda_id'];
			$valor = $reg_caixa['vl_pago'];
			
		?>
          <tr>
            <td>&nbsp;<?=$id?></td>
            <td>&nbsp;<?=$pagare?></td>
            <td>&nbsp;<?=$despesa?></td>
            <td>&nbsp;<?=$venda?></td>
            <td>&nbsp;<?=number_format($valor,2,",",".")?></td>
            <td><input type="submit" name="Submit" value="Extornar" onclick="submitForm('formCaixa', 'extornar_lanc_caixa.php?acao=deletar')" /> <input type="hidden" name="id" id="id" value="<?=$id?>" /></td>
          </tr>
        </table>
		
		<?
			if($_GET['acao'] == 'deletar') {
				$id = $_POST['id'];
			
				$sql_deleta = "DELETE FROM lancamento_caixa_balcao WHERE id = '$id' ";
				$exe_deleta = mysql_query($sql_deleta);
			
				echo "<script language='javaScript'> Fecha_Redireciona('caixa.php');</script>";

			}
		?>	
		
</form>
</body>
</html>
