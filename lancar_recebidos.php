<?
	//include_once("mycrypt.php");
	require_once("verifica_login.php");
	require_once("biblioteca.php");
	include "config.php";
	conexao();
	
?>
<?
$sql_caixa_balcao = "SELECT * FROM caixa_balcao WHERE usuario_id = ". $id_usuario." AND st_caixa = 'A'";
$rs_caixa_balcao = mysql_query($sql_caixa_balcao);
$linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao, MYSQL_ASSOC);
$caixa_id = $linha_caixa_balcao['id'];


?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Creditar Recebimentos - <? echo $title; ?></title>
    
    <script type="text/javascript">
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
<link href="css/clearbox.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	font: normal 11px auto "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	color: #4f6b72;
	background: #E6EAE9;
}

a {
	color: #c75f3e;
}

#mytable {
	width: 700px;
	padding: 0;
	margin: 0;
}

caption {
	padding: 0 0 5px 0;
	width: 700px;	 
	font: italic 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	text-align: right;
}

th {
	font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	color: #4f6b72;
	border-right: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	border-top: 1px solid #C1DAD7;
	letter-spacing: 2px;
	text-transform: uppercase;
	text-align: left;
	padding: 6px 6px 6px 12px;
	
}

th.nobg {
	border-top: 0;
	border-left: 0;
	border-right: 1px solid #C1DAD7;
	background: #797268;
}

td {
	border-right: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	background: #fff;
	padding: 6px 6px 6px 12px;
	color: #4f6b72;
}


td.alt {
	background: #F5FAFA;
	color: #797268;
}

th.spec {
	border-left: 1px solid #C1DAD7;
	border-top: 0;
	background: #fff url(../../../../Documents and Settings/Emerson/Desktop/images/bullet1.gif) no-repeat;
	font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
}

th.specalt {
	border-left: 1px solid #C1DAD7;
	border-top: 0;
	background: #f5fafa ;
	font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	color: #797268;
}
.Estilo14 {
	color: #000000;
	font-weight: bold;
}
.Estilo15 {color: #000000}
.style3 {font-size: 10px}
.style4 {
	font-size: 12;
	font-weight: bold;
}
.style6 {font-size: 12}
</style>
</head>

<body onload='setaFoco()'>
<table width="100%" border="0">
  
  <tr>
    <td><div align="center"><strong>LANCAR PAGAMENTO DE CLIENTE</strong></div></td>
  </tr>
</table>

<form id="formCredita" name="formCredita" action="lancar_recebidos.php" method="post">
<table width="92%" height="148" border="0" bgcolor="" >
  <tr>
    <td width="61%" class="fields" height="83"><fieldset>&nbsp; 
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

<table width="92%" height="236" bgcolor="C6D5FD">
<tr class="alt">
    	<td width="891" height="230"><div align="center"></div>
	  <div align="center" class="CB_TextNav">
	    <table width="36%" border="0" bgcolor="#ECE9D8">
          
          <tr>
            <td width="82%" height="42" bgcolor="C6D5FD"><fieldset>
              &nbsp;
              <span class="alt">
              <legend>Entre com o Valor Recebido</legend>
              </span>
              <p class="alt">Guaranies:
                <input type="text" name="valor" id="valor" />
              </p>
              <p>
                <span class="style6">
                <label class="lina">
                  <input type="button" name="button2" id="button2" value="Creditar" onClick="submitForm('formCredita','lancar_recebidos.php?acao=creditar&cod=1')" />
                </label>
                </span></p>
            </fieldset></td>
            <td width="11%">&nbsp;</td>
          </tr>
          <tr>
            <td height="37" colspan="2" class="alt style3">Nao use pontos, ex: 50000 (Cinquenta mil guaranies)</td>
          </tr>
        </table>
	    <p class="CB_ThumbsImg">&nbsp;</p>
	  </div></td>
  </tr>
</table>    
<?php
		if ($_GET['acao'] == "creditar"){
			
			$vl_creditar = $_POST['valor'];
			//$creditar = $vl_creditar;
			
			$sql_conta_receber = "
							SELECT 
								cr.id,
								cr.vl_parcela, 
								cr.vl_recebido, 
								cr.vl_restante,
								cr.venda_id,
								cr.clientes_id 
							FROM 
								contas_receber cr
							WHERE
								status = 'A'
								AND 
							clientes_id = '".$_SESSION['codg']."'
							ORDER BY cr.dt_vencimento";
									
		$ex_cons_cr = mysql_query($sql_conta_receber);
		while ($linha = mysql_fetch_array($ex_cons_cr,MYSQL_ASSOC)){
			$id_conta = $linha['id'];
			$vl_parcela = $linha['vl_parcela'];
			$vl_recebido = $linha['vl_recebido'];
			$vl_restante = $vl_parcela - $vl_recebido;
			$venda = $linha['venda_id'];
			$cliente = $linha['clientes_id'];
			
			//echo "<br>v cr", $vl_creditar, "vl_parcela ", $vl_parcela, " vl_recebido ", $vl_recebido, "vl_restant ", $vl_restante."<br>";
			
			$tot_credito = $vl_creditar - $vl_restante; 
			if($tot_credito < 0){
				$novo_vl_recebido = $vl_recebido + $vl_creditar;
				//$vl_creditar-= $vl_creditar;
				$sql_ins_cr = "UPDATE contas_receber set vl_recebido = ".$novo_vl_recebido. " WHERE id = '$id_conta'";
							
				mysql_query($sql_ins_cr) or die (mysql_error());
				//aqui valor creditar lancamentos caixa = $vl_creditar
				$sql_credita = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id,contas_receber_id) VALUES ('1', '$caixa_id', NOW(), ".$vl_creditar.", '$venda', '$id_conta')  ";
				$exe_credita = mysql_query($sql_credita);
				//echo "antes";
				
				$sql_corrige = "DELETE FROM lancamento_caixa_balcao WHERE vl_pago = '0' AND caixa_id = '$caixa_id' ";
				$exe_corrige = mysql_query($sql_corrige);
				
				break;
			}
			else{
				$novo_vl_recebido = $vl_recebido + $vl_restante;
				$vl_creditar = $vl_creditar - $vl_restante;
				$sql_ins_cr2 = "UPDATE contas_receber set vl_recebido = ".$novo_vl_recebido. ", status = 'P' WHERE id = '$id_conta'";
			echo "depois";	
				mysql_query($sql_ins_cr2); 
				//aqui valor restante = $vl_restante
				$sql_credita2 = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id,contas_receber_id) VALUES ('1', '$caixa_id', NOW(), '$vl_restante', '$venda', '$id_conta')  ";
				$exe_credita2 = mysql_query($sql_credita2);
				
				//$vl_restante = $vl_restante - $novo_vl_recebido;
			}
		}
		if($vl_creditar > 0){
			$sql_credita3 = "INSERT INTO lancamento_caixa_balcao (receita_id,caixa_id,dt_lancamento,vl_pago,venda_id,contas_receber_id) VALUES ('6', '$caixa_id', NOW(), '$vl_creditar', '$venda', '$id_conta')  ";
				$exe_credita3 = mysql_query($sql_credita3);
			
			$sql_credita4 = "UPDATE clientes SET credito = credito + '$vl_creditar'  WHERE controle = '$cliente' ";
			$exe_credita4 = mysql_query($sql_credita4);
			//echo "<br> $vl_creditar -  oque fazer<br>";
		}
		
		echo "<br> LANCAMENTO EFETUADO COM EXITO<br>";
		echo "<br> <input type='button' name='button' onClick='window.close()' value='salir' /><br>";
		
}
echo "</form>";
?>

<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
