<?php
require_once("verifica_login.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$id_prod = $_GET['id'];

?>
<?php

		$sql_prod = "SELECT * FROM produtos WHERE id = '$id_prod'";
		$exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
		$num_prod = mysql_num_rows($exe_prod);
		while ($reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC)) {
		
	/*INICIO - PEGANDO ID DA MARCA*/
	$sql_marca = "SELECT * FROM marcas WHERE id = '".$reg_prod['marca']."' ";
	$rs_marca = mysql_query($sql_marca);
	$linha_marca = mysql_fetch_array($rs_marca);
	$nom_marca = $linha_marca['nom_marca'];
	/*FIM*/
	
	/*INICIO - PEGANDO ID DO GRUPO*/
	$sql_grupo = "SELECT * FROM grupos WHERE id = '".$reg_prod['grupo']."' ";
	$rs_grupo = mysql_query($sql_grupo);
	
	$linha_grupo = mysql_fetch_array($rs_grupo);
	$id_grupo = $linha_grupo['nom_grupo'];
	/*FIM*/
		
		
?>
<?php
$data2 = $reg_prod['data'];
			$hora2 = $reg_prod['data'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #f2f1e2;
border-width:2px;
border-style:solid;
border-color:#a2bfe9;
}
.botao  {
background-image:url('images/salvar.gif') no-repeat ;
width:30px;  
height:30px;
display:block;
}

</style>

<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-numeric.js"></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" />



<script language='JavaScript'>
function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;
    if((tecla > 47 && tecla < 58)) return true;
    else{
    if (tecla != 8 && tecla != 44 && tecla != 46) return false;
	
    else return true;
    }
}
function deletar(id){
			if(confirm("Tem certeza que deseja excluir o registro?")){
				window.location = "alterar_prod_fim.php?acao=del&id	="+id;
			}
		}
function salvar(id){
				window.location = "alterar_prod_fim.php?acao=alter&id	="+id;
			}

</script>


<script language="javascript">
function UP_Letra(evento, valida, maiuscula) {
 if (evento.target) {
   codigo = evento.target;
 }
 else {
   codigo =  event.srcElement;
 }
 element = codigo.value;
 if (maiuscula == 'true') {
   element = element.toUpperCase();
 }
 var new_element = "";
 for (vIdx=0; vIdx < element.length; vIdx++) {
   if (valida.indexOf(element.substr(vIdx, 1)) != -1
       || (maiuscula == 'false' &&
           valida.toLowerCase().indexOf(element.substr(vIdx, 1)) != -1) ) {
     new_element = new_element + element.substr(vIdx, 1);
   }
 }
 codigo.value = new_element;
}

function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='\result_pedido.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='\pesquisa_prod_edit.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>


</script>


<style type="text/css">


</style>
</head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cadastro Productos - <? echo $cabecalho; ?></title>
<body onload="document.getElementById('Codigo').focus()">
<form id="acesso" name="acesso" action="alterar_prod_fim.php?acao=alter" onSubmit="return false" method="post">
   <input type="hidden" size="35"  name="id" value="<?=$reg_prod['id']?>" />
<table width="80%" border="0">
  <tr>
    <td bgcolor="#FF0000"><div align="center" class="Estilo15 Estilo1">Alteracao de Productos </div></td>
  </tr>
</table>
<table width="67%" border="0">
  <tr>
    <td width="33%" bgcolor="#CCCCCC"><strong>Codigo</strong></td>
    <td width="51%" bgcolor="#CCCCCC"><strong>Descripcion</strong></td>
    <td width="16%" bgcolor="#CCCCCC"><strong>Custo: </strong></td>
  </tr>
  <tr>
    <td><input type="text" name="Codigo" value="<?=$reg_prod['Codigo']?>" /></td>
    <td>
      <input type="text" size="35"  name="Descricao" value="<?=$reg_prod['Descricao']?>" /></td>
    <td><input type="text" size="12" name="custo" onkeypress='return SomenteNumero(event)' class='numeric' value="<?=$reg_prod['custo']?>"/></td>
  </tr>
</table>
<table width="67%" border="0">
  <tr>
    <td width="29%">&nbsp;</td>
    <td width="21%">&nbsp;</td>
    <td width="21%">&nbsp;</td>
    <td width="29%">&nbsp;</td>
  </tr>
  <tr>
    <td height="21" bgcolor="#CCCCCC"><strong>Part. Number </strong></td>
    <td bgcolor="#CCCCCC"><strong>Marca:</strong></td>
    <td bgcolor="#CCCCCC"><strong>Grupo:</strong></td>
    <td bgcolor="#CCCCCC"><p><strong>Serial:</strong></p>    </td>
  </tr>
  <tr>
    <td><input type="text" name="part_number" value="<?=$reg_prod['part_number']?>"/></td>
    <td><input type="text" name="marca" id="marca" value="<?=$nom_marca?>" /></td>
    <td><input type="text" name="grupo" id="grupo" value="<?=$id_grupo?>" /></td>
    <td><input type="text" name="serial" value="<?=$reg_prod['serial']?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="67%" border="0">
  <tr>
    <td width="28%" bgcolor="#CCCCCC"><strong>Cod. Original </strong></td>
    <td width="28%" bgcolor="#CCCCCC"><strong>Cod. Fabricante </strong></td>
    <td width="27%" bgcolor="#CCCCCC"><span class="Estilo20"><strong>Cod. Original </strong><strong>2</strong></span></td>
    <td width="17%" bgcolor="#CCCCCC"><strong>Pr. Min. </strong></td>
  </tr>
  <tr>
    <td><input type="text" size="25" name="cod_original" value="<?=$reg_prod['cod_original']?>" /></td>
    <td><input type="text" size="25" name="Codigo_Fabricante" value="<?=$reg_prod['Codigo_Fabricante']?>" /></td>
    <td><input type="text" size="25" name="cod_original2" value="<?=$reg_prod['cod_original2']?>" /></td>
    <td><input type="text" size="15" name="pr_min" onkeypress='return SomenteNumero(event)' value="<?=number_format($reg_prod['pr_min'],2,",",".")?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>%Margen A: </strong></td>
    <td bgcolor="#CCCCCC"><strong>%Margen B: </strong></td>
    <td bgcolor="#CCCCCC"><strong>%Margen C: </strong></td>
    <td bgcolor="#CCCCCC"><strong>Preco ant.: </strong></td>
  </tr>
  <tr>
    <td><input type="text" size="10" name="margen_a" onkeypress='return SomenteNumero(event)' value="<?=$reg_prod['margen_a']?>" /></td>
    <td><input type="text" size="10" name="margen_b" onkeypress='return SomenteNumero(event)' value="<?=$reg_prod['margen_b']?>" /></td>
    <td><input type="text" size="10" name="margen_c" onkeypress='return SomenteNumero(event)' value="<?=$reg_prod['margen_c']?>" /></td>
    <td><input type="text" size="12" name="Preco_Venda" onkeypress='return SomenteNumero(event)' class='numeric' value="<?=$reg_prod['Preco_Venda']?>"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="59%" border="0">
  <tr>
    <td width="14%" bgcolor="#CCCCCC"><strong>Cant. Disp. </strong></td>
    <td width="15%" bgcolor="#CCCCCC"><strong>Cant. Min. </strong></td>
    <td width="17%" bgcolor="#CCCCCC"><strong>IVA % </strong></td>
    <td width="16%" bgcolor="#CCCCCC"><strong>Cant. Total: </strong></td>
    <td width="19%" bgcolor="#CCCCCC"><strong>Cant. Bloq </strong></td>
    <td width="19%" bgcolor="#CCCCCC"><strong>Ult. Custo </strong></td>
  </tr>
  <tr>
    <td><input type="text" size="10"  name="Estoque" onkeypress='return SomenteNumero(event)' value="<?=$reg_prod['Estoque']?>" /></td>
    <td><input type="text" size="10" name="qtd_min" onkeypress='return SomenteNumero(event)' value="<?=$reg_prod['qtd_min']?>" /></td>
    <td><input type="text" size="10" name="iva" onkeypress='return SomenteNumero(event)' value="<?=$reg_prod['iva']?>" /></td>
    <td><input type="text" size="10" readonly="" name="qtd_total" value="<?=($reg_prod['Estoque'] + $reg_prod['qtd_bloq'])?>" /></td>
    <td><input type="text" size="10" readonly="" name="qtd_bloq" value="<?=$reg_prod['qtd_bloq']?>" /></td>
    <td><input type="text" size="15" readonly="" name="ult_custo" value="<?=number_format($reg_prod['ult_custo'],2,",",".")?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><strong>Loca&ccedil;ao:</strong></td>
    <td bgcolor="#CCCCCC"><strong>Embalagem:</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text" size="10" name="local" value="<?=$reg_prod['local']?>" /></td>
    <td><input type="text" size="10" name="embalagem" value="<?=$reg_prod['embalagem']?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="50%" border="0">
  <tr>
    <td width="26%" bgcolor="#CCCCCC"><strong>Alterado en: </strong></td>
    <td width="28%" bgcolor="#CCCCCC"><strong>Usu&aacute;rio:</strong></td>
    <td width="46%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text" size="25" readonly="" name="data" value="<?=$novadata?>" /></td>
    <td><input type="text" size="25" readonly="" name="user" value="<?=$reg_prod['nome_user']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>
  <?php
}
?>
</p>
<table width="30%" border="0">
  <tr>
    <td width="18%"> <a href="" onclick="window.close()" /><img src="images/fechar.jpg" onclick="window.close()" value="Cerrar" width="32" border="0"height="32" /></td>
    <td width="18%"><a href="alterar_prod_fim.php?acao=del&id=<?=$id_prod?>" /><img src="images/lixeira.jpg" width="32" border="0"height="32" /></td>
    <td width="18%"><font face="Arial">
      <input type="button" class="botao" style="background:url(/images/salvar.jpg)" value="       " name="acesso2"  onclick="this.form.submit()"  />
    </font></td>
    <td width="46%">&nbsp;</td>
  </tr>
</table>
<p>
 </p>
</form>
<?

if ($_GET['acao'] == "del") {
		if (isset($_GET['id'])) {
			if ($_GET['id']) {
				$id_prod = $_GET['id'];
				
			//	$sql_verifica = "SELECT COUNT(*) AS n_prod FROM produtos WHERE marca = '".$id_marca."'"; 
			//	$exe_verifica = mysql_query($sql_verifica, $base) or die (mysql_error());			
			//	$reg_verifica = mysql_fetch_array($exe_verifica, MYSQL_ASSOC);
				
			//	if ($reg_verifica['n_prod'] == 0) {	
					$sql_del = "DELETE FROM produtos WHERE id = '".$id_prod."'"; 
					$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
			//	}
			//	else {
					echo "<script language='javaScript'>window.location.href='alterar_prod.php'</script>";
				}
			}
		}	
	//}		

if ($_GET['acao'] == "alter") {
	//if (isset($_GET['id'])) {
		//	if ($_GET['id']) {
			//	$id_prod = $_GET['id'];

	$Codigo = $_POST['Codigo'];
    $Descricao = $_POST['Descricao'];
    $custo = $_POST['custo'];
	$part_number = $_POST['part_number'];
	$serial = $_POST['serial'];
	$cod_original = $_POST['cod_original'];
	$Codigo_Fabricante = $_POST['Codigo_Fabricante'];
	$pr_min = $_POST['pr_min'];
	$margen_a = $_POST['margen_a'];
	$margen_b = $_POST['margen_b'];
	$margen_c = $_POST['margen_c'];
	$custo = $_POST['custo'];
	$custo = $_POST['custo'];
	$valor_a = $_POST['valor_a'];
	$valor_b = $_POST['valor_b'];
	$valor_c = $_POST['valor_c'];
	$Estoque = $_POST['Estoque'];
	$qtd_min = $_POST['qtd_min'];
	$iva = $_POST['iva'];
	$qtd_bloq = $_POST['qtd_bloq'];
	$local = $_POST['local'];
	$embalagem = $_POST['embalagem'];
	$user = $_POST['nome_user'];
	$id = $_POST['id'];
	$cod_original2 = $_POST['cod_original2'];
	$Preco_Venda = $_POST['Preco_Venda'];
	
	//echo $id ;
	$percentual_a = $margen_a / 100;
	$valor_a = $custo + ($percentual_a * $custo);

	$percentual_b = $margen_b / 100;
	$valor_b = $custo + ($percentual_b * $custo);

	$percentual_c = $margen_c / 100;
	$valor_c = $custo + ($percentual_c * $custo);
	
	/*INICIO - PEGANDO ID DA MARCA*/
	$marca = $_POST['marca'];
	$sql_marca = "SELECT id FROM marcas WHERE nom_marca = '".$marca."'";
	$rs_marca = mysql_query($sql_marca);
	
	$linha_marca = mysql_fetch_array($rs_marca);
	$id_marca = $linha_marca['id'];
	/*FIM*/
	
	/*INICIO - PEGANDO ID DO GRUPO*/
	$grupo = $_POST['grupo'];
	$sql_grupo = "SELECT id FROM grupos WHERE nom_grupo = '".$grupo."' ";
	$rs_grupo = mysql_query($sql_grupo);
	
	$linha_grupo = mysql_fetch_array($rs_grupo);
	$id_grupo = $linha_grupo['id'];
	/*FIM*/

	$sql_per = "UPDATE produtos SET Codigo=UCASE('$Codigo'), Descricao=UCASE('$Descricao'), custo='$custo', part_number=UCASE('$part_number'), marca=UCASE('$marca'), grupo=UCASE('$grupo'), serial=UCASE('$serial'), cod_original=UCASE('$cod_original'), Codigo_Fabricante=UCASE('$Codigo_Fabricante'), pr_min='$pr_min', margen_a='$margen_a', margen_b='$margen_b', margen_c='$margen_c', valor_a='$valor_a', valor_b='$valor_b', valor_c='$valor_c', Estoque='$Estoque', qtd_min='$qtd_min', iva='$iva', qtd_bloq='$qtd_bloq', embalagem=UCASE('$embalagem'), data=NOW(), user=UCASE('$nome_user'), local=UCASE('$local'), marca=UCASE('$id_marca'), grupo=UCASE('$id_grupo'), cod_original2=UCASE('$cod_original2'), Preco_Venda=UCASE('$Preco_Venda') WHERE id = '".$id."' ";


	$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);

	
	echo 'Alteração efetuada com sucesso';

   echo "<script language='javaScript'>window.location.href='alterar_prod_ok.php?id=$id'</script>";

		
	}
?>
</font>  
<p>

<script type='text/javascript'>
	$("#marca").autocomplete("pesquisa_marca.php", {
		width: 260,
		selectFirst: false
	});	
	
		
</script>
</body>
</html>
