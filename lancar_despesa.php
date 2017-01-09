<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$estado = $_GET['estado'];
$codigoForn = $_GET['CodigoForn'];
if (empty ($estado)){
$abre = "none";
}
else {
$abre = $_GET['show'];
}

$sql_caixa_balcao = "SELECT * FROM caixa WHERE  status = 'A'";
$rs_caixa_balcao = mysql_query($sql_caixa_balcao);
$linha_caixa_balcao = mysql_fetch_array($rs_caixa_balcao, MYSQL_ASSOC);
$caixa_id = $linha_caixa_balcao['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-numeric.js"></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" /> 
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery.maskedinput-1.1.4.js"></script>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Cadastro de Plano de Contas - <? echo $title ?></title>
	<style type="text/css">
	<!--
	.Estilo1 {	color: #FFFFFF;
		font-family: Georgia, "Times New Roman", Times, serif;
		font-size: 12px;
		font-weight: bold;
	}
	.Estilo14 {	font-size: 36px;
		font-weight: bold;
	}
	.Estilo15 {	color: #FFFFFF;
		font-weight: bold;
	}
	.Estilo4 {font-size: 12px}
	-->
	body {
	padding:3px 0px 3px 8px;
	background-image:url(images/bg_blue.gif);
	border-width:2px;
	border-style:solid;
	border-color:#a2bfe9;
	font-weight: bold;
	}
    .Estilo21 {font-size: 12px}
    </style>
	<script type='text/javascript'>
		function setaFoco(){
		
			document.getElementById('CodigoForn').focus()
		
		
		}
		
		function deletar(id){
			if(confirm("Tem certeza que deseja excluir o registro?")){
				window.location = "lancar_despesa.php?acao=del&id	="+id;
			}
		}

function getkey(e,frm)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
{
frm.focus();
return false;
}
else
return true;
}

jQuery(function($){

$("#dt_fatura").mask("99/99/9999"); // onde #date é o id do campo
$("#data_fim").mask("99/99/9999"); // onde #date é o id do campo
$("#dt_vencimento1").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento2").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento3").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento4").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento5").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento6").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento7").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento8").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento9").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento10").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento11").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento12").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento13").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento14").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento15").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento16").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento17").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento18").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento19").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento20").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento21").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento22").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento23").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento24").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo
$("#dt_vencimento25").mask("99/99/9999"); // onde #dt_vencimento1 é o id do campo

$("#phone").mask("(99) 9999-9999");

$("#cpf").mask("999.999.999-99");
$("#moeda").mask("9.000.000,00");
});

function Limpar(valor, validos) {
// retira caracteres invalidos da string
var result = "";
var aux;
for (var i=0; i < valor.length; i++) {
aux = validos.indexOf(valor.substring(i, i+1));
if (aux>=0) {
result += aux;

}
}
return result;
}


function Formata(campo,tammax,teclapres,decimal) {
var tecla = teclapres.keyCode;
vr = Limpar(campo.value,"0123456789");
tam = vr.length;
dec=decimal;

if (tam < tammax && tecla != 8){
tam = vr.length + 1 ;

}

if (tecla == 8 ){
tam = tam - 1 ;

}

    if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <=
105 )
    {

        if ( tam <= dec ){
        campo.value = vr ;
        }

        if ( (tam > dec) && (tam <= 5) ){
        campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec,
tam ) ;
        }
        if ( (tam >= 6) && (tam <= 8) ){
        campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3
) + "," + vr.substr( tam - dec, tam ) ;
        }
        if ( (tam >= 9) && (tam <= 11) ){
        campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3
) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ;
        }
        if ( (tam >= 12) && (tam <= 14) ){
        campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11,
3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," +
vr.substr( tam - dec, tam ) ;
        }
        if ( (tam >= 15) && (tam <= 17) ){
        campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14,
3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." +
vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;
        }
    }

} 


function submitForm(idForm, acaoForm){
		document.getElementById(idForm).action = acaoForm;
		document.getElementById(idForm).submit();			
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
			submitForm('formCompra','lancar_despesa.php?acao=insere')	
		else
			alert("A soma das parcelas nao conferem com o valor da fatura");
	}

</SCRIPT>

</head>

<body onload="setaFoco()">
<p align="center" class="Estilo14"><? echo $cabecalho ?></p>
<table width="80%" border="0">
  <tr>
    <td><div align="center" class="Estilo15">LANCAMENTO DE DESPESAS</div></td>
  </tr>
</table>
<?
	if (isset ($_GET['acao'])) {
		if ($_GET['acao'] == "insere") {
		$qtd = $_POST['qtd'];
		
		$plano = $_POST['plano'];
		$ndoc = $_POST['ndoc'];
		$dt_fatura = converte_data('2',$_POST['dt_fatura']);
		$valora = str_replace('.', '',$_POST['vl_fatura']);
		$valor = str_replace(',', '.',$valora);
		$desc = $_POST['desc'];
		$fornecedor_id = $_SESSION['codigoForn'];
		
		$re = "select * from despesa where nome_despesa = '$plano' ";
		$result =mysql_query($re);
		$result_re = mysql_fetch_array($result, MYSQL_ASSOC);
		$idd = $result_re['despesa_id'];
		
		if (isset ($idd)) {
		$nm_total_parcela = $qtd;
		
		$num_fatura = $_POST['num_fatura'];	
		$status = 'A';
		
		$z=1;
		
		while($z <= $qtd) {
			$dt_vencimento_parcela = converte_data('2',$_POST["dt_vencimento$z"]);
			$vl_parcelaa = str_replace("." , "" , $_POST["vl_parcela$z"]);
			$vl_parcela = str_replace("," , "." , "$vl_parcelaa$z");					
			$num_parcela = $z."/".$nm_total_parcela;
			
			
			$sql_per = "INSERT INTO lanc_despesa (receita_id, despesa_id, documento, dt_lanc_desp, venc_desp, dt_fatura_desp, desc_desp, valor, usuario_id, nm_total_parcela, nm_parcela, forn_id, valor_total ) VALUES('2', '$idd', UCASE('$ndoc'), NOW(), '$dt_vencimento_parcela', '$dt_fatura',  UCASE('$desc'), '$vl_parcela', '$id_usuario', '$nm_total_parcela','$num_parcela', '$fornecedor_id', '$valor')";
			$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
			$lanc_desp_id = mysql_insert_id();
			
			$sql_pagar = "INSERT INTO contas_pagar (num_fatura,fornecedor_id,dt_emissao_fatura,vl_total_fatura,nm_total_parcela,nm_parcela,status,dt_vencimento_parcela,vl_parcela,lanc_desp_id)";
			$sql_pagar.= "VALUES ('$ndoc','$fornecedor_id','$dt_fatura','$valor','$nm_total_parcela','$num_parcela','$status','$dt_vencimento_parcela','$vl_parcela','$lanc_desp_id')";
			
			mysql_query($sql_pagar) or die(mysql_error());
			$cont_pag_id = mysql_insert_id();
			
			
			if (isset ($_POST["pagar$z"])){
				$sql_caixa = "INSERT INTO lancamento_caixa (receita_id, caixa_id, data_lancamento, num_nota, despesa_cod, contas_pagar_id, valor, fornecedor_id, lanc_despesa_id) VALUES( '2', '$caixa_id', NOW(), UCASE('$ndoc'), '$idd', '$cont_pag_id', '$vl_parcela', '$fornecedor_id',  '$lanc_desp_id') ";
			$exe_caixa = mysql_query($sql_caixa, $base) or die (mysql_error().'-'.$sql_caixa);
			
			
				}
			
			$z++;
		}
	}
		else{
			echo "<strong>PLANO DE CONTA NAO ENCONTRADO !!</p>";
			echo " </p>\n";
			echo " </p>\n";
			echo " <a href=lancar_despesa.php>Voltar</a>";
			exit;
		}	
	}		
}

?>
<?
		if(!empty($codigoForn)){
			$sql = "SELECT * FROM proveedor WHERE id = '$codigoForn'" ;	
			$rs = mysql_query($sql);
			$num_reg = mysql_num_rows($rs);
			if($num_reg > 0){
				$row = mysql_fetch_array($rs);
				
				$_SESSION['codigoForn'] = $row['id'];
				$_SESSION['fornnome'] = $row['nome'];
				$enderecoCli = $row['endereco'];
				$telefoneForn = $row['telefone'];
			}
		}

		?>
RECEITAS DO TIPO SAIDA
<form action="result_forn_despesa.php" method="post">
  <table width="42%" border="1" bordercolor="#0A246A">
    <tr>
      <td><span class="ac_over">Fornecedor Codigo:</span></td>
      <td><span class="ac_over">Fornecedor Nome :</span></td>
    </tr>
    <tr>
      <td><input type="text" name="CodigoForn" id="CodigoForn"  value="<?=$_SESSION['codigoForn']?>"/></td>
      <td><input type="text" name="fornnome" id="fornnome" value="<?=$_SESSION['fornnome']?>"/></td>
    </tr>
  </table>
  <input name="submit" type="submit"  value="consultar"/>
</form>

<p></p>

<form id="formCompra" name="formCompra" action="lancar_despesa.php?acao=insere" onSubmit="return false" method="post">
<table width="97%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td width="15%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
	<td colspan="2">&nbsp;</td>
</tr>
  <tr>
    <td width="19%" bgcolor="#0A246A"><span class="ac_over">Contas:</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="24"> 
      <input type="text" name="plano" size="30" id="plano"  value="<?=$_POST['plano']?>" onkeypress="getkey(event,this.form.ndoc)"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td colspan="2">&nbsp;</td>
  </tr>
  <tr >
    <td class="ac_over">N. Documento </td>
    <td class="ac_over"><span class="Estilo3">Data Fatura: </span></td>
    <td width="15%" span class="ac_over"><span class="Estilo3">Valor Fatura: </span></span></td>
    <td width="21%"class="ac_over">Descricao:</span></label></td>  
	 <td width="20%"><span class="ac_over"><span class="Estilo3">Total de Parcelas </span></span></td>
	   
	 <td width="10%">&nbsp;</td> 
  </tr>
  <tr>
    <td><label>
      <input type="text" name="ndoc" id="ndoc"  value="<?=$_POST['ndoc']?>" onkeypress="getkey(event,this.form.dt_fatura)" />
    </label></td>
    <td><label>
      <input type="text" name="dt_fatura" id="dt_fatura" value="<?=$_POST['dt_fatura']?>" onkeypress="getkey(event,this.form.vl_fatura)"/>
    </label></td>
    <td><label>
      <input type="text" size="7" name="vl_fatura" id="vl_fatura" value="<?=$_POST['vl_fatura']?>"  onkeypress="getkey(event,this.form.desc)" onKeydown="Formata(this,20,event,2)"/>
    </label></td>
    <td><label>
      <input type="text" name="desc" id="desc"  value="<?=$_POST['desc']?>" size="30" onkeypress="getkey(event,this.form.qtd)"/>
    </label></td>
	 <td><label>
	   <input type="text" size="5" name="qtd" id="qtd" value="<?=$_POST['qtd']?>" onkeypress="getkey(event,this.form.gerar_parcelas)" />
	 </label></td>
	  <td><label>
	    <input type="button" name="gerar_parcelas" id='gerar_parcelas' value="Gerar Contas" onclick="submitForm('formCompra','lancar_despesa.php?acao=gerar_parcelas')"/>
	  </label></td>
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
<?
if($_GET['acao']=='gerar_parcelas'){
		$qtd = $_POST['qtd'];
		$z = 0;
		while($z < $qtd) {
		   $z++;
		   echo "<strong>Data $z:<strong>&nbsp; <input type='text' name='dt_vencimento$z' id='dt_vencimento$z' class='data_format'><br>\n";
		   echo "Valor $z: <input type='text' name='vl_parcela$z' id='vl_parcela$z'  onKeydown='Formata(this,20,event,2)' vl_parcela'><br>";
		   echo "Debitar Agora: <input name='pagar$z' type='checkbox' value='Debita Agora' ><br><br>\n";
		   
		}			
		if($z > 0){
?>
<input type="button" name="Submit" onclick="this.form.submit()" value="Cadastrar"/>
<? 
		} 
		else{
?>
		<input type="button"  value="Cadastrar" disabled="disabled"/>
<?
		}	
	}	

?>

<p>

</form> 
<td width="25%"><a href="lancar_despesa.php?acao=add&id=<?=$reg_lista['referencia']?>"></a></p>
  Ultimos Lancamentos
    <table border="0" width="95%">
<tr class="ac_over">
			  <td width="5%" height="23"><strong>Cod.</strong></td>
			  <td width="21%">Plano de Conta</td>
			  <td width="11%">N. Doc.</td>
			  <td width="13%">Lancamento</td>
        <td width="15%">Vencimento</td>
        <td width="15%"><strong><strong>Valor Total </strong></strong></td>
        <td width="9%">Forn.</td>
        <td width="8%">Valor:</td>
<td width="3%">&nbsp;</td>
</tr>
</table>
<div id="atualiza" style="overflow-x: scroll; height:250px; overflow:auto; overflow-y: scroll; width:950px; color: #CCC;">
<table border="0" width="99%">
            <?
			
  $sql_crial = " CREATE TABLE lanc_despesa (
  id_lanc_despesa int(10) unsigned NOT NULL auto_increment,
  despesa_id int(10) unsigned NOT NULL,
  documento varchar(45) NOT NULL,
  dt_lanc_desp datetime NOT NULL,
  venc_desp datetime NOT NULL,
  dt_fatura_desp datetime NOT NULL,
  desc_desp varchar(45) NOT NULL,
  valor float(8,2) NOT NULL,
  valor_total double NOT NULL,
  usuario_id int(10) unsigned NOT NULL,
  receita_id int(10) unsigned NOT NULL,
  forn_id int(10) unsigned NOT NULL,
  nm_total_parcela int(10) unsigned NOT NULL,
  nm_parcela varchar(10) NOT NULL,
  PRIMARY KEY  (id_lanc_despesa)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC; ";
  $exe_crial = mysql_query($sql_crial, $base);
  
  $sql_crialb = "CREATE TABLE lancamento_caixa_balcao (
  id int(10) unsigned NOT NULL auto_increment,
  receita_id int(10) unsigned NOT NULL,
  caixa_id int(10) unsigned NOT NULL,
  dt_lancamento timestamp NOT NULL default CURRENT_TIMESTAMP,
  descricao varchar(45) NOT NULL,
  vl_pago float(8,2) NOT NULL,
  venda_id int(10) unsigned NOT NULL,
  contas_receber_id int(11) NOT NULL,
  contas_pagar_id int(10) NOT NULL,
  lanc_despesa_id int(11) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1; ";
  $exe_crialb = mysql_query($sql_crialb, $base);
   
  $sql_criact = "CREATE TABLE contas_pagar (
  id int(10) unsigned NOT NULL auto_increment,
  num_fatura char(10) NOT NULL,
  fornecedor_id int(10) unsigned NOT NULL,
  dt_emissao_fatura datetime NOT NULL,
  vl_total_fatura float(8,2) NOT NULL,
  nm_total_parcela int(10) unsigned NOT NULL,
  nm_parcela varchar(10) NOT NULL,
  `status` varchar(1) NOT NULL,
  dt_pgto_parcela datetime NOT NULL,
  dt_vencimento_parcela datetime NOT NULL,
  descricao varchar(20) NOT NULL,
  vl_parcela float(8,2) NOT NULL,
  vl_pago float(8,2) NOT NULL,
  vl_juro float(8,2) NOT NULL,
  vl_multa float(8,2) NOT NULL,
  vl_desconto float(8,2) NOT NULL,
  compra_id int(10) unsigned NOT NULL,
  lanc_desp_id int(10) unsigned NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC; ";
  $exe_criact = mysql_query($sql_criact, $base);
  
  
			$sql_lista = "SELECT lc.*, d.* FROM lanc_despesa lc, despesa d WHERE d.despesa_id = lc.despesa_id order by lc.id_lanc_despesa desc"; 
			$exe_lista = mysql_query($sql_lista, $base);
			$num_lista = mysql_num_rows($exe_lista);
	
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
				
			$lanc = $reg_lista['dt_lanc_desp'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($lanc,8,2) . "/" .substr($lanc,5,2) . "/" . substr($lanc,0,4);
			
			$data3 = $reg_lista['venc_desp'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
				
			?>
			 <tr class="Estilo15"> 								
              <td width="5%" bgcolor="#99CCFF"><?=$reg_lista['despesa_id']?></td>
              <td width="21%" bgcolor="#99CCFF"><?=$reg_lista['nome_despesa']?></td>
              <td width="11%" bgcolor="#99CCFF"><?=$reg_lista['documento']?></td>
              <td width="13%" bgcolor="#99CCFF"><?=$novadata?></td>
              <td width="14%" bgcolor="#99CCFF"><?=$novadata2?></td>
              <td width="14%" bgcolor="#99CCFF"><?=number_format($reg_lista['valor_total'],2,",",".")?></td>
              <td width="9%" bgcolor="#99CCFF"><?=$reg_lista['forn_id']?></td>
              <td width="9%" bgcolor="#99CCFF"><?=number_format($reg_lista['valor'],2,",",".")?></td>
<td width="4%" bgcolor="#99CCFF"><a hhref="lancar_despesa.php?acao=descontar&id=<?=$reg_lista['despesa_id']?>&estado=show"><img src="images/edit.png" alt="Alterar" width="16" height="17" border="0"  onclick="$('#m_div').show('slow')"  /></a>			 </tr>
			<?
			}
	?>
</table>
</div>
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()" value="Fechar"/>
</font><?
echo $teste;
?></p>
</form>

<div id="m_div" style="display:<?=$abre?> ">
  <?php
//$clis = $_POST['cli'];
//$ide = $_GET['id'];

		if ($_GET['acao'] == "desconto") {
		//if (isset($_GET['ide'])) {
			if ($_GET['ide']) {
			$ides = $_GET['ide'];
	echo		$nom_plano = $_POST['nom_plano'];
		
		$sql_desconto = "UPDATE despesa SET nome_despesa = UCASE('$nom_plano') WHERE id = '$ides' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());	
		
		echo "<script language='javaScript'>window.location.href='lancar_despesa.php?cli=".$_SESSION['cli']."'</script>";
					

	}
}
?>
  <?php
  		if ($_GET['acao'] == "descontar") {
		$id = $_GET['id'];
  		
		$sql_desconto = "SELECT * FROM despesa where despesa_id = '$id' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());
		$reg_desconto = mysql_fetch_array($exe_desconto, MYSQL_ASSOC); 
			
			$nome = $reg_desconto['nome_despesa'];
			$codigo = $reg_desconto['cod_despesa'];
			
?>
  <table width="41%" border="0">
    <tr>
      <td width="37%" height="21" bgcolor="#CCCCCC" class="calendar_inline">NOME</td>
    </tr>
    <tr>
      <td height="18" bgcolor="#FFFFFF" class="calendar_inline"><span class="Estilo4">
        <?=$nome?>
      </span></td>
    </tr>
  </table>
  <?
}

?>
  <form action="lancar_despesa.php?acao=desconto&amp;ide=<?=$id?>" method="post">
    <table width="41%" border="0">
      <tr>
        <td width="18%"  bgcolor="#0EEAE0" class="calendar_inline"><strong>NOME: </strong></td>
        <td width="82%" class="calendar_inline"><input type="text" id="nom_plano" name="nom_plano" value="<?=$nome?>"  /></td>
      </tr>
    </table>
    <p class="calendar_inline">
      <input type="submit" name="Submit2" value="Alterar" />
    </p>
  </form>
  </p>
</div>

<script type='text/javascript'>
	$("#plano").autocomplete("pesquisa_despesa.php", {
		width: 260,
		selectFirst: false
	});	
	
</script>

</body>
</html>
