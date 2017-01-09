<?
	require_once("verifica_login.php");
	require_once("biblioteca.php");
	include "config.php";
	conexao();
	$data= date("d/m/Y"); // captura a data
	$hora= date("H:i:s"); //captura a hora
	$nome_user = $_SESSION['nome_user'];
	$codigoForn = $_REQUEST['CodigoForn'];

	if(empty($codigoForn))
		$codigoForn = $_POST['cod'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lancamento de Compras</title>
<style type="text/css">
body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #EFEFEF;
border-width:1px;
border-style:solid;
border-color:#a2bfe9;
}
</style>
<link rel="stylesheet" href="/js/jquery/calendario/calendario.css"/>
<script type="text/javascript" src="/js/jquery/jquery/jquery.js"></script>
<script type="text/javascript" src="/js/jquery/calendario/jquery-calendar.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-numeric.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-floatnumber.js"></script>
<script type="text/javascript" src="/js/funcoes.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".data_format").calendar({buttonImage: "images/calendar.gif"});

		$(".numeric").numeric(",");
	    $(".numeric").floatnumber(",",2);
	});	
	
	function teclaPress(event,obj,idForm, acaoForm){
		key = getKey(event);
		if(key==13){
			if(obj.id=='cod'){
				$("#nom").val('');
			}
			else if(obj.id=='nom'){
				$("#cod").val('');
			}			
			submitForm(idForm,acaoForm);
		}
	}
	
	function submitForm(idForm, acaoForm){
		document.getElementById(idForm).action = acaoForm;
		document.getElementById(idForm).submit();			
	}
	
	function setaFoco(){
		menu = '<?=$_GET["menu"]?>';
		acao = '<?=$_GET["acao"]?>';
		foco = '<?=$_GET["foco"]?>';
		if(menu.length>0){
			$("#cod").focus();
		}
		if(acao == 'add'){
			$("#num_fatura").focus();
		}
		if(foco.length > 0){
			$("#"+foco).focus();
		}		
	}
	
	function verificarParcelas(){
		tot = $(".vl_parcela").length;
	
		soma=0.00;
		for(i=1;i<=tot;i++){
			if($("#vl_parcela"+i).val()=='' || $("#dt_vencimento"+i).val()=='' || $("#vl_parcela"+i).val()=='0,00'){
				alert("Preencha todos os campos");
				return false;
			}
			else{
				soma+=moeda2float($("#vl_parcela"+i).val());
			}
		}
		if(soma==moeda2float($("#vl_fatura").val()))
			submitForm('formCompra','contas_pagar.php?acao=cadastrar')	
		else
			alert("A soma das parcelas nao conferem com o valor da fatura");
	}
</script>
</head>

<body onload='setaFoco()'>
<div align="center" class="Estilo1"></div>
<table width="100%" border="1" bordercolor="#ECE9D8" bgcolor="#OEEAEO">
  <tr>
    <td height="22"><div align="center" class="Estilo2">FATURA DE COMPRA</div></td>
  </tr>
</table>
<table width="94%" border="0" cellpadding="0" cellspacing="3">
  <tr>
    <td bgcolor="#ECE9D8"><? echo $data ?> &nbsp;</td>
    <td><div align="right"></div></td>
    <td bgcolor="#EEEEEE"><div align="left"></div></td>
    <td width="129"><div align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Usuario:</strong></div></td>
    <td bgcolor="#ECE9D8" width="146"><?=$nome_user?>
      &nbsp;</td>
  </tr>
  <tr>
    <td width="65">&nbsp;</td>
    <td width="217"><p> <font color="Blue"></font></p></td>
    <td width="180">&nbsp;</td>
    <td width="129">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="19" bgcolor="#ECE9D8"><strong><font color="Blue"> Codigo </font><font color="Blue"> </font></strong></td>
    <td bgcolor="#ECE9D8"><strong><font color="#0000FF"> Nome Fornecedor </font></strong></td>
    <td bgcolor="#ECE9D8"><strong><font color="#0000FF">Endereco</font></strong></td>
    <td bgcolor="#ECE9D8"><font color="#0000FF"><strong> Telefone</strong></font></td>
    <td colspan="2" bgcolor="#ECE9D8"><div align="center"><strong><font color="#0000FF">Vendedor</font></strong></div></td>
  </tr>
  <tr>
	<?
		if(!empty($codigoForn)){
			$sql = "SELECT * FROM proveedor WHERE id = '$codigoForn'" ;	
			$rs = mysql_query($sql);
			$num_reg = mysql_num_rows($rs);
			if($num_reg > 0){
				$row = mysql_fetch_array($rs);
				$nomeForn = $row['nome'];
				$enderecoCli = $row['endereco'];
				$telefoneForn = $row['telefone'];
			}
		}

		?>
	<form id='formCompra' name='formCompra' action='#' method='POST'>		
    <td height="25">
      <input type="text" size="10" name="cod" id="cod" onkeypress="teclaPress(event,this,'formCompra','result_forn.php')" value="<?=$codigoForn?>"/>
    </td>
    <td><label>
        <input type="text" size="36" name="nom" id='nom' value="<?=$nomeForn?>" onkeypress="teclaPress(event,this,'formCompra','result_forn.php')"/>
        </label>
    </td>
    <td>
      <input type="text" size="30" name="direc" value="<?=$enderecoCli?>" readonly="readonly"/>
    </td>
    <td>
      <label>
      <input type="text2" size="10" name="telefone" value="<?=$telefoneForn?>" readonly="readonly"/>
      <label>
    </td>
    <td colspan="2">
      <label>
      <div align="center">
      <input type="text2" name="requerente" value="<?//=$_SESSION['req']?>" />
      <label></label>
    </td>
  </tr>
</table>
<table width="27%" border="0">
  <tr>
    <td width="29%" bgcolor="#ECE9D8"><strong>N. Fatura: </strong></td>
    <td width="71%"><input type="text" name="num_fatura" id='num_fatura' value="<?=$_POST['num_fatura']?>" onkeypress="teclaPress(event,this,'formCompra','contas_pagar.php?foco=dt_fatura')"/></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td width="14%" bgcolor="#ECE9D8"><span class="Estilo3">Data Fatura: </span></td>
    <td width="14%" bgcolor="#ECE9D8"><span class="Estilo3">Valor Fatura: </span></td>
    <td width="14%" bgcolor="#ECE9D8"><span class="Estilo3">Total de Parcelas </span></td>
    <td width="41%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text" name="dt_fatura" id="dt_fatura" value="<?=$_POST['dt_fatura']?>"  class='data_format'/></td>
    <td><input type="text" name="vl_fatura" id="vl_fatura" value="<?=$_POST['vl_fatura']?>" class='numeric' onkeypress="teclaPress(event,this,'formCompra','contas_pagar.php?foco=qtd')"/></td>
    <td><input type="text" size="5" name="qtd" id="qtd" value="<?=$_POST['qtd']?>" onkeypress="teclaPress(event,this,'formCompra','contas_pagar.php?acao=gerar_parcelas&foco=dt_vencimento1')"></td>
    <td> <input type="button" name="gerar_parcelas" id='gerar_parcelas' value="Gerar Contas" onclick="submitForm('formCompra','contas_pagar.php?acao=gerar_parcelas')"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php
	if ($_GET['acao'] == "cadastrar") {
		$qtd = $_POST['qtd'];

		$nm_total_parcela = $qtd;
		$fornecedor_id = $_POST['fornecedor_id'];
		$num_fatura = $_POST['num_fatura'];
		$dt_emissao_fatura = converte_data('2',$_POST['dt_fatura']);
		$vl_total_fatura = str_replace("," , "." , $_POST['vl_fatura']);		
		$status = 'A';
		//echo $vl_total_fatura;
		$z=1;
		
		$sql_compra = "INSERT INTO compras ( fornecedor_id, nm_fatura, dt_emissao_fatura, vl_total_fatura, status, data_lancamento) VALUES ('$codigoForn', '$num_fatura', '$dt_emissao_fatura', '$vl_total_fatura', '$status', NOW() )";
		$exe_compra = mysql_query($sql_compra) or die(mysql_error());
		$compra_id = mysql_insert_id();
		
		while($z <= $qtd) {
			$dt_vencimento_parcela = converte_data('2',$_POST["dt_vencimento$z"]);
			$vl_parcela =  str_replace("," , "." , $_POST["vl_parcela$z"]);			
			$num_parcela = $z."/".$nm_total_parcela;
			
			$sql_pagar = "INSERT INTO contas_pagar (num_fatura,fornecedor_id,dt_emissao_fatura,vl_total_fatura,nm_total_parcela,nm_parcela,status,dt_vencimento_parcela,vl_parcela,compra_id)";
			$sql_pagar.= "VALUES ('$num_fatura','$codigoForn','$dt_emissao_fatura','$vl_total_fatura','$nm_total_parcela','$num_parcela','$status','$dt_vencimento_parcela','$vl_parcela','$compra_id')";
			
			mysql_query($sql_pagar) or die(mysql_error());
			$z++;
		}
		echo "<script type='text/javascript'>
			  alert('Cadastro efetuado com exito!');
		 window.location='prod_cad_exito.php' 
		</script>";
	}
	
	if($_GET['acao']=='gerar_parcelas'){
		$qtd = $_POST['qtd'];
		$z = 0;
		while($z < $qtd) {
		   $z++;
		   echo "<strong>Data $z:<strong>&nbsp; <input type='text' name='dt_vencimento$z' id='dt_vencimento$z' class='data_format'><br>\n";
		   echo "Valor $z: <input type='text' name='vl_parcela$z' id='vl_parcela$z' class='numeric vl_parcela'><br><br>\n";
		}			
		if($z > 0){
?>
			<input type="button" onclick="verificarParcelas()" value="Gravar"/>
<? 
		} 
		else{
?>
		<input type="button"  value="Gravar" disabled="disabled"/>
<?
		}	
	}	
	echo "</form>";
?>
<p>
<td>
</td>
</p>
<input name="button" type="button" onclick="window.close()" value="Abandonar" />
</body>
</html>