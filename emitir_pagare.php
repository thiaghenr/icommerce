<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$dia= date("d");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pesquiza Pedidos Venta - <? echo $title ?></title>
<style type="text/css">
<!--
.Estilo4 {font-size: 12px}
-->
</style>

<link rel="stylesheet" href="/js/jquery/calendario/calendario.css"/>
<script type="text/javascript" src="/js/jquery/jquery/jquery.js"></script>
<script type="text/javascript" src="/js/jquery/calendario/jquery-calendar.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-numeric.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-floatnumber.js"></script>

<script type="text/javascript">
		$(document).ready(function() {
		$("#data_emissao").calendar({buttonImage: "/images/calendar.gif"});
		$("#data_validade").calendar({buttonImage: "/images/calendar.gif"});	

		$(".numeric").numeric(",");
	    $(".numeric").floatnumber(",",2);
	});	
	
    	function submitForm(idForm, acaoForm){
            document.getElementById(idForm).action = acaoForm;
            document.getElementById(idForm).submit();			
        }
    function setaFoco(){
		acao = '<?=$_GET['acao']?>';
		codigo = '<?=$_POST['codigo']?>';
		
		if(codigo.length == ''){
			document.getElementById('codigo').focus();
			document.getElementById('codigo').select();
		}
		if(codigo.length>0 ){
			document.getElementById('valor').focus();
			document.getElementById('valor').select();
		}

	}
    </script>

<style type="text/css">
body {
font-family: "Trebuchet MS", Verdana, Arial;
font-size: 12px;
color: #006;
background-color: #F6F5F0;
}
a:link, a:visited {
color: #00F;
text-decoration: underline overline;
}
a:hover, a:active {
color: #F00;
text-decoration: none;
}
.Estilo7 {
	color: #000000;
	font-weight: bold;
}
.Estilo8 {color: #000000}
.style3 {font-size: 10px}
.style4 {	font-size: 12;
	font-weight: bold;
}
.style6 {font-size: 12}
td.alt {	background: #F5FAFA;
	color: #797268;
}
</style>

</head>
<label></label>
<body onload='setaFoco()'>
<form id="formCredita" name="formCredita" action="emitir_pagare.php" method="post">
<table width="92%" height="148" border="0" bgcolor="" >
  <tr>
    <td width="61%" class="fields" height="83"><fieldset>
      &nbsp;
      <legend>Entre com o Codigo do Cliente</legend>
      <p>Codigo:
        <input type="text" name="codigo" id="codigo" />
      </p>
      <p>
        <label>
          <input type="submit" name="button" id="button" value="Buscar" />
        </label>
      </p>
    </fieldset></td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
  </tr>
</table>
<?php
	if (!empty( $_POST['codigo'])){
	$cod = $_POST['codigo'];
		
		$sql_cli = "SELECT * FROM clientes WHERE controle = '$cod'  ";
		$exe_cli = mysql_query($sql_cli);
		$reg_cli = mysql_fetch_array($exe_cli);
	
		$_SESSION['codg'] = $reg_cli['controle'];
		$nome = $reg_cli['nome'];
		$ruc = $reg_cli['ruc'];
		$fone = $reg_cli['telefonecom'];
		$endereco = $reg_cli['endereco'];
		$cidade = $reg_cli['endereco'];
		$deve = $reg_cli['saldo_devedor'];
	
	
	}
?>
<table width="92%" border="0" bgcolor="C6D5FD">
  <tr>
    <td width="32%" class="alt"><span class="style4">Codigo:</span></td>
    <td colspan="2" class="alt style6">&nbsp;</td>
    <td width="22%" class="alt style6">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#fff" class="alt"><span class="style6">
      <?=$cod?>
    </span></td>
    <td colspan="2" class="alt style6">&nbsp;</td>
    <td class="alt style6">&nbsp;</td>
  </tr>
  <tr>
    <td class="alt"><span class="style6"><strong>Ruc:</strong></span></td>
    <td colspan="2" class="alt"><span class="style6"><strong>Telefone:</strong></span></td>
    <td class="alt style6">&nbsp;</td>
  </tr>
  <tr>
    <td class="alt"><span class="style6">
      <?=$ruc?>
    </span></td>
    <td colspan="2" class="alt"><span class="style6">
      <?=$fone?>
    </span></td>
    <td class="alt style6">&nbsp;</td>
  </tr>
  <tr>
    <td class="alt"><span class="style6"><strong>Nome:</strong></span></td>
    <td width="13%" class="alt style6">&nbsp;</td>
    <td width="30%" class="alt"><span class="style6"><strong>Endereco</strong></span></td>
    <td class="alt"><span class="style6"><strong>Cidade:</strong></span></td>
  </tr>
  <tr>
    <td class="alt"><span class="style6">
      <?=$nome?>
    </span></td>
    <td class="alt style6">&nbsp;</td>
    <td class="alt"><span class="style6">
      <?=$endereco?>
    </span></td>
    <td class="alt"><span class="style6">
      <?=$cidade?>
    </span></td>
  </tr>
  <tr>
    <td class="alt"><span class="style3"></span></td>
    <td colspan="2" class="alt"><span class="style3"></span></td>
    <td class="alt"><span class="style3"></span></td>
  </tr>
</table>
<table width="92%" height="165" bgcolor="C6D5FD">
  <tr class="alt">
    <td width="326" height="26">&nbsp;</td>
    <td width="175" height="230" class="calendar_today"></div>
        <p class="style6">VALOR:
          <input type="text" name="valor" id="valor" />
        </p>
      <p class="calendar_today">VENCIMENTO:
        <input type="text" name="data_validade" id="data_validade" value="<?=$_POST['data_validade']?>" />
        </p>
      <p class="style6">
          <input type="button" name="button2" id="button2" value="Lancar" onclick="submitForm('formCredita','emitir_pagare.php?acao=creditar&amp;cod=1')" />
      </p></td>
    <td width="386">&nbsp;</td>
  </tr>
</table>
<?php 
if ($_GET['acao'] == "creditar"){
			
			$vl_creditar = $_POST['valor'];
			$data_validade = converte_data('2',$_POST['data_validade']);
			
			$sql_conta_receber = "INSERT INTO contas_receber (vl_total,vl_parcela,nm_total_parcela,nm_parcela,clientes_id,venda_id,status,dt_lancamento,dt_vencimento)";
        $sql_conta_receber.=" VALUES ($vl_creditar,$vl_creditar,'1','1','".$_SESSION['codg']."' ,'0','A','$data_atual','$data_validade')";

        mysql_query($sql_conta_receber) or die(mysql_error().' - '.$sql_conta_receber);

echo "<br><strong>LANCAMENTO EFETUADO COM EXITO</strong>";
}


?>
</p>
</form>
</body>
</html>
