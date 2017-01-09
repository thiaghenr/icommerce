<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$datab = date("Y-m-d");
$data= date("d/m/Y"); // captura a data
$estado = $_GET['estado'];
if (empty ($estado)){
$abre = "none";
}
else {
$abre = $_GET['show'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cadastro de Cheques - <? echo $title ?></title>


<link rel="stylesheet" href="/js/jquery/calendario/calendario.css"/>
<script type="text/javascript" src="/js/jquery/jquery/jquery.js"></script>
<script type="text/javascript" src="/js/jquery/calendario/jquery-calendar.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-numeric.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-floatnumber.js"></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" /> 
<link href="css/clearbox.css" rel="stylesheet" type="text/css" />
<script src="js/clearbox.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#data_emissao").calendar({buttonImage: "images/calendar.gif"});
		$("#data_validade").calendar({buttonImage: "images/calendar.gif"});		
	
		$(".numeric").numeric(",");
	    $(".numeric").floatnumber(",",2);
		
	});	

function enviardados(){	
if(document.getElementById('valor')=="" ){
alert( "Preencha o campo Valor!" );
document.getElementById('valor').focus();
return false;

}}
	
	
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cadastro de Cheques</title>
<style type="text/css">
<!--
.style5 {
	color: #FFFFFF;
	font-weight: bold;
}
.style6 {font-size: 12px}
.style7 {font-size: 12}
.style9 {font-size: 11px}
.Estilo21 {font-size: 12px}
.Estilo4 {font-size: 12px}
.style10 {
	color: #0000FF;
	font-weight: bold;
}
.style11 {color: #FFFFFF}
-->
</style>
</head>

<body>
<form id="cadastro" name="cadastro" action="cadastro_cheque.php?acao=insere" onSubmit="return enviardados()" method="POST">
<?


	if (isset ($_GET['acao'])) {
		if ($_GET['acao'] == "insere") {
			$codigo_banco = $_POST['codigo_banco'];
			$agencia = $_POST['agencia'];
			$conta = $_POST['conta'];
			$cheque = $_POST['num_cheque'];
			$valor = $_POST['valor'];
			$dt_emissao = converte_data('2',$_POST['data_emissao']);
			$validade = converte_data('2',$_POST['data_validade']);
			$cliente = $_POST['cliente_id'];
			$emissor = $_POST['emissor'];
			$ruc = $_POST['ruc_emissor'];
			$dig = $_POST['dig_ruc'];
			$banco_id = $_POST['banco_id'];
			$moeda = $_POST['radio'];
			
		//	$sql_banco = " SELECT * FROM banco WHERE id_banco = '$banco_id' ";
		//	$exe_banco = mysql_query($sql_banco);
		//	$reg_banco = mysql_fetch_array($exe_banco);
			
			if ($banco_id == "Selecione"){
				echo "<strong>Selecione um Banco</p>";
				echo " </p>\n";
				echo " </p>\n";
				echo " <a href=cadastro_cheque.php>Voltar</a>";
				exit;}
			else
							
			$re = mysql_query("select count(*) as total from cheque where conta = '$conta' AND num_cheque = '$cheque' ");
			$total = mysql_result($re, 0, "total");
			
			if ($total == 0) {
			$sql_per = "INSERT INTO cheque (id_banco,agencia,conta, num_cheque, valor, data_dia, data_emissao, data_validade, emissor, ruc_emissor, dig_ruc,cliente_id,situacao,moeda) VALUES( '$banco_id', UCASE('$agencia'), UCASE('$conta'), UCASE('$num_cheque'), '$valor', NOW(), '$dt_emissao', '$validade', UCASE('$emissor'), '$ruc', '$dig', '$cliente', 'A', '$moeda' )";
				$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
			}
			else{
				echo "<strong>Cheque ja cadastrado</p>";
				echo " </p>\n";
				echo " </p>\n";
				echo " <a href=cadastro_cheque.php>Voltar</a>";
				exit;
			}
		}
	}
	
		if ($_GET['acao'] == "del") {
		if (isset($_GET['id_banco'])) {
			if ($_GET['id_banco']) {
				$id_banco = $_GET['id_banco'];
						
				$sql_verifica = "SELECT COUNT(*) AS n_prod FROM cheque WHERE id_banco = '".$id_banco."'"; 
				$exe_verifica = mysql_query($sql_verifica, $base) or die (mysql_error());			
				$reg_verifica = mysql_fetch_array($exe_verifica, MYSQL_ASSOC);
				
				if ($reg_verifica['n_prod'] == 0) {	
					$sql_del = "DELETE FROM banco WHERE id_banco = '$id_banco'   "; 
					$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
			
				}
				else {
					echo '<strong>Operacion no permitida, ha cheques cadastrados con banco</strong>' ;
				}
				
		}
	}	
	}		
?>


<table width="100%" border="1">
  <tr>
    <td bgcolor="#a2bfe9"><div align="center" class="style5">CADASTRO DE CHEQUES</div></td>
  </tr>
</table>
<table width="100%" border="0" bordercolor="#8CC6FF" bgcolor="8CC6FF">
  <tr>
    <td width="13%" rowspan="3" bordercolor="#CC6666"><span class="style5">
      <label>
        Banco:        
        <select name="banco_id" id="banco_id">
           <option>Selecione</option>
          <?
                $sql_banco= "SELECT * FROM banco";
                $exe_banco = mysql_query($sql_banco);
                while($linha_banco = mysql_fetch_array($exe_banco)){
                    echo "<option value='".$linha_banco['id_banco']."'>".$linha_banco['nome_banco']."</option>\n";
                }
            ?>
          </select>
      </label>
    </span></td>
    <td width="20%"><span class="style5">
      <label></label>
    </span></td>
    <td width="13%" rowspan="3"><span class="style11 calendar_today"><strong>Agencia: 
        <input type="text" size="20" id="agencia" name="agencia" value="<?=$_POST['agencia']?>" />
    </strong></span></td>
    <td width="13%" rowspan="3"><span class="style11 calendar_today"><strong>Conta: 
        <input type="text" size="20" id="conta" name="conta" value="<?=$_POST['conta']?>" />
    </strong></span></td>
    <td width="14%" rowspan="3"><span class="style11 calendar_today"><strong>Cheque N: 
        <input type="text" size="20" id="num_cheque" name="num_cheque" value="<?=$_POST['num_cheque']?>" />
    </strong></span></td>
    <td width="14%" rowspan="3"><span class="style11 calendar_today"><strong>Valor: 
    	
        <input type="text" size="20" id="valor" name="valor"  value="<?=number_format($_POST['valor'],2,".",".")?>" />
       
    </strong></span></td>
    <td width="13%" rowspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style5">
      <input type="radio" name="radio" id="radio" value="guarani" checked="checked" />
Guarani
  <input type="radio" name="radio" id="radio" value="dolar" />
Dolar</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style11 calendar_today"><strong>Lancamento: 
        <input type="text" size="20" readonly="readonly" id="data_dia" name="data_dia" value="<?=$data?>" />
    </strong></span></td>
    <td><span class="style11 calendar_today"><strong>Emissao: 
        <input type="text" size="15" id="data_emissao" name="data_emissao" value="<?=$_POST['data_emissao']?>" />
    </strong></span></td>
    <td><span class="style11 calendar_today"><strong>Validade: 
        <input type="text" size="15" id="data_validade" name="data_validade" value="<?=$_POST['data_validade']?>" />
    </strong></span></td>
    <td><span class="calendar_today"><span class="style11 Estilo1"><strong>Cod. Cliente: </strong></span>
        <input type="text" size="15" id="cliente_id" name="cliente_id" value="<?=$_POST['cliente_id']?>" />
    </span></td>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" bordercolor="#8CC6FF" bgcolor="8CC6FF">
  <tr>
    <td width="26%"><span class="calendar_today"><span class="style5">Emissor: </span>
        <input type="text" size="40" id="emissor" name="emissor" value="<?=$_POST['emissor']?>" />
    </span></td>
    <td width="14%"><span class="calendar_today"><span class="style5">Ruc Emissor: </span>
        <input type="text" size="10" id="ruc_emissor" name="ruc_emissor" value="<?=$_POST['ruc_emissor']?>" />
    </span></td>
    <td width="6%"><span class="calendar_today"><span class="style5">Digito: </span>
      <input type="text" size="1" id="dig_ruc" name="dig_ruc" value="<?=$_POST['dig_ruc']?>" />
    </span></td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="button" name="button" id="button" onclick="this.form.submit()" value="Cadastrar" />
      <label>
      <input type="reset" name="button2" id="button2" value="Limpar" />
      </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="18%" bordercolor="#99FF00" class="calendar_today">&nbsp;</td>
    <td width="11%" bordercolor="#99FF00" class="calendar_today">&nbsp;</td>
    <td width="6%" bordercolor="#99FF00" class="style10">&nbsp;</td>
    <td width="11%" bordercolor="#99FF00" class="calendar_today">&nbsp;</td>
    <td width="8%" bordercolor="#99FF00" class="calendar_today"><label></label></td>
  </tr>
</table>
</form>
<table border="0" width="98%">
<tr>
	<td width="9%" bgcolor="#ECE9D8" class="calendar_inline style6 style7">Banco</td>
    <td width="18%" bgcolor="#ECE9D8" class="calendar_inline style6">Cliente</td>
    <td width="7%" bgcolor="#ECE9D8" class="calendar_inline style6">Agencia</td>
    <td width="8%" bgcolor="#ECE9D8" class="calendar_inline style6">Conta</td>
    <td width="8%" bgcolor="#ECE9D8" class="calendar_inline style6">Cheque</td>
    <td width="8%" bgcolor="#ECE9D8" class="calendar_inline style6">Emissao</td>
    <td width="8%" bgcolor="#ECE9D8" class="calendar_inline style6">Validade</td>
    <td width="8%" bgcolor="#ECE9D8" class="calendar_inline style6">Moeda</td>
    <td width="8%" bgcolor="#ECE9D8" class="calendar_inline style6">Valor</td>
    <td width="8%" bgcolor="#ECE9D8" class="calendar_inline style6">Situacao</td>
    <td width="3%" bgcolor="#ECE9D8" class="calendar_inline style6">&nbsp;</td>
</tr>
</table>
<div id="atualiza" style="overflow-x: scroll; height:200px; overflow:auto; overflow-y: scroll; width:100%">
<table border="0" width="98%">
			
<?

	if (!empty ($_POST['xeque'])){
		$xeq = $_POST['xeque'];
	echo $xeq;
		$sql_lista = "SELECT ch.*, b.*, c.nome,controle FROM cheque ch, banco b, clientes c WHERE ch.num_cheque = '$xeq' AND ch.id_banco = b.id_banco AND ch.cliente_id = c.controle AND situacao != 'X' "; 
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	}
	else
			
	$sql_lista = "SELECT ch.*, b.*, c.nome,controle FROM cheque ch, banco b, clientes c WHERE ch.id_banco = b.id_banco AND ch.cliente_id = c.controle AND situacao != 'X' "; 
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
			
			$cheque = $reg_lista['id_cheque'];
			$valor = $reg_lista['valor'];
			$moeda = $reg_lista['moeda'];
			$numero = $reg_lista['num_cheque'];
			$nome_banco = $reg_lista['nome_banco'];
			$data_dia = $reg_lista['data_dia'];
			$emissao = $reg_lista['data_emissao'];
			$validade = $reg_lista['data_validade'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata_dia = substr($data_dia,8,2) . "/" .substr($data_dia,5,2) . "/" . substr($data_dia,0,4);
			$novadata_emissao = substr($emissao,8,2) . "/" .substr($emissao,5,2) . "/" . substr($emissao,0,4);
			$novadata_validade = substr($validade,8,2) . "/" .substr($validade,5,2) . "/" . substr($validade,0,4);
			
			if ($reg_lista['situacao'] == "X"){ $situacao = "Descontado"; }
			else if ($reg_lista['situacao'] == "S"){ $situacao = "Devolvido"; }
			else if ($reg_lista['situacao'] == "R"){ $situacao = "Repassado"; }
			else if ($reg_lista['situacao'] == "D"){ $situacao = "Descontar"; }
			else if ($reg_lista['situacao'] == "B"){ $situacao = "Banco"; }
			else if ($validade > $datab) { $situacao = 'Aguardando'; } 
			else if ($reg_lista['data_validade'] < $datab) { $situacao = 'Descontar';}  
			
			if ($reg_lista['moeda'] == 'guarani'){ $valor = guarani($reg_lista['valor']); }
			else { $valor = $reg_lista['valor'];}
			
			
			?>
<tr> 								
              <td width="9%" height="20" bgcolor="#FFCCFF" class="calendar_inline"><span class="style6">
              <?=substr($reg_lista['nome_banco'],0,11)?>
              </span></td>
      <td width="18%" bgcolor="#FFCCFF" class="calendar_inline"><span class="style6">
        <?=substr($reg_lista['nome'],0,20)?>
      </span></td>
      <td width="7%" bgcolor="#FFCCFF" class="calendar_inline"><span class="style6">
        <?=$reg_lista['agencia']?>
      </span></td>
      <td width="8%" bgcolor="#FFCCFF" class="calendar_inline"><span class="style6">
        <?=$reg_lista['conta']?>
      </span></td>
      <td width="8%" bgcolor="#FFCCFF" class="calendar_inline"><span class="style6">
        <?=$reg_lista['num_cheque']?>
      </span></td>
      <td width="8%" bgcolor="#FFCCFF" class="calendar_inline style7"><span class="style6">
        <?=$novadata_emissao?>
      </span></td>
      <td width="8%" bgcolor="#FFCCFF" class="calendar_inline style7"><span class="style6">
        <?=$novadata_validade?>
      </span></td>
      <td width="8%" bgcolor="#FFCCFF" class="calendar_inline style7"><span class="style6">
        <?=$reg_lista['moeda']?>
      </span></td>
      <td width="8%" bgcolor="#FFCCFF" class="calendar_inline style9"><span class="style6">
        <?=$valor?>
      </span></td>
      <td width="8%" bgcolor="#FFCCFF" class="calendar_inline style6"><?=$situacao?></td>
    <td width="3%" bgcolor="#F2F1E2" class="calendar_inline"><a href="cadastro_cheque.php?acao=descontar&id=<?=$cheque?>&estado=show" class="style6"><img src="images/edit.png" alt="Alterar" width="16" height="17" border="0"  onclick="$('#m_div').show('slow')"  /></a>      </tr>
			
			<?
			}
	//echo '<p>Cantidad de Cheques Cadastrados: '.$num_lista.'</p>';
	?>
</table>
</div>
<div id="m_div" style="display:<?=$abre?> ">
  <?php
//$clis = $_POST['cli'];
//$ide = $_GET['id'];

		if ($_GET['acao'] == "desconto") {
		//if (isset($_GET['ide'])) {
			if ($_GET['ide']) {
			$ides = $_GET['ide'];
			$sit = $_POST['select'];
			
			if ($sit ==  "Banco"){ $nova_sit = "B";}
			if ($sit ==  "Aguardando"){ $nova_sit = "A";}
			if ($sit ==  "Descontar"){ $nova_sit = "D";}
			if ($sit ==  "Repassado"){ $nova_sit = "R";}
			if ($sit ==  "Devolvido"){ $nova_sit = "S";}
			if ($sit ==  "Descontado"){ $nova_sit = "X";}
					
		$sql_desconto = "UPDATE cheque SET situacao = '$nova_sit' WHERE id_cheque = '$ides' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());	
		
		echo "<script language='javaScript'>window.location.href='cadastro_cheque.php?st=$sit'</script>";
					
	//	}
	}
}
?>
  <?php
  		if ($_GET['acao'] == "descontar") {
		$id = $_GET['id'];
  		
		$sql_desconto = "SELECT c.*, b.* FROM cheque c, banco b where c.id_cheque = '$id' AND c.id_banco = b.id_banco  ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());
		$reg_desconto = mysql_fetch_array($exe_desconto, MYSQL_ASSOC); 
			
			
			$moeda_cheque = $reg_desconto['moeda'];
			$nome = $reg_desconto['nome_banco'];
			$numero_cheque = $reg_desconto['num_cheque'];
			$valor_cheque = $reg_desconto['valor'];
?>
  <table width="41%" border="0">
    <tr>
      <td width="23%" height="21" bgcolor="#CCCCCC" class="calendar_inline"><span class="Estilo4 Estilo21"> Banco</span></td>
      <td width="35%" bgcolor="#CCCCCC" class="calendar_inline"><span class="Estilo4 Estilo21">Numero Cheque</span></td>
      <td width="21%" bgcolor="#CCCCCC" class="calendar_inline">Moeda</td>
      <td width="21%" bgcolor="#CCCCCC" class="calendar_inline">Valor</td>
    </tr>
    <tr>
      <td height="18" bgcolor="#FFFFFF" class="calendar_inline"><span class="Estilo4">
        <?=substr($nome,0,11)?>
      </span></td>
      <td bgcolor="#FFFFFF" class="calendar_inline"><span class="Estilo4">
        <?=$numero_cheque?>
      </span></td>
      <td bgcolor="#FFFFFF" class="calendar_inline"><span class="Estilo4">
        <?=$moeda_cheque?>
      </span></td>
      <td bgcolor="#FFFFFF" class="calendar_inline"><span class="Estilo4">
        <?=$valor_cheque?>
      </span></td>
    </tr>
  </table>
  <?
}
?>
  <form action="cadastro_cheque.php?acao=desconto&amp;ide=<?=$id?>" method="post">
    <table width="41%" border="0">
      <tr>
        <td width="24%"  bgcolor="#0EEAE0" class="calendar_inline"><strong>SITUACAO:</strong></td>
        <td width="76%" class="calendar_inline"><label>
          <select name="select" id="select">
          <option>Aguardando</option>
          <option>Descontar</option>
          <option>Banco</option>
          <option>Repassado</option>
          <option>Devolvido</option>
          <option>Descontado</option>
          </select>
        </label></td>
      </tr>
    </table>
    <p class="calendar_inline">&nbsp;</p>
    <p class="calendar_inline">&nbsp;</p>
    <p>
      <input type="submit" name="Submit" value="Enviar" />
    </p>
  </form>
  </p>
</div>
<p>&nbsp;</p>
<script type='text/javascript'>
	
	$("#cliente_id").autocomplete("pesquisa_cod_cli.php", {
		width: 260,
		selectFirst: false
	});		
	
</script>

</body>
</html>
