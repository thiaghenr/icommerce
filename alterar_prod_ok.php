<?
require_once("biblioteca.php");
require_once("verifica_login.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$id_prod = $_GET['id'];

?>
<?php
//if (isset ($_GET['acao'])) {
	//if ($_GET['acao'] == "alt") {
		//if (isset ($_GET['id'])) {
			//if ($_GET['id']) {
				//$id_prod = addslashes(htmlentities($_GET['id']));

				$sql_prod = "SELECT * FROM produtos WHERE id = '$id_prod'";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
					$reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC );
					
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

body {
font-family: "Trebuchet MS", Verdana, Arial;
font-size: 12px;
color: #006;

a:link, a:visited {
color: #00F;
text-decoration: underline overline;
}
a:hover, a:active {
color: #F00;
text-decoration: none;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Produtos - <? echo $cabecalho; ?></title>
</head>
<body onload="document.getElementById('ref').focus()">

<table width="80%" border="0">
  <tr>
    <td bgcolor="#FF0000"><div align="center" class="Estilo15">Alteracion efectuada con exito </div></td>
  </tr>
</table>
<p align="center" class="Estilo16">&nbsp;</p>
<table width="64%" border="0">
  <tr>
    <td width="28%" bgcolor="#CCCCCC"><strong>Codigo</strong></td>
    <td width="56%" bgcolor="#CCCCCC"><strong>Descripcion</strong></td>
    <td width="16%" bgcolor="#CCCCCC"><strong>Custo: </strong></td>
  </tr>
  <tr>
    <td><?=$reg_prod['Codigo']?></td>
    <td><?=substr($reg_prod['Descricao'],0,45)?></td>
    <td><?=number_format($reg_prod['custo'],2,",",".")?></td>
  </tr>
</table>
<table width="64%" border="0">
  <tr>
    <td width="28%">&nbsp;</td>
    <td width="22%">&nbsp;</td>
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
    <td><?=$reg_prod['part_number']?></td>
    <td><?=$nom_marca?></td>
    <td><?=$id_grupo?></td>
    <td><?=$reg_prod['serial']?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="64%" border="0">
  <tr>
    <td width="28%" bgcolor="#CCCCCC"><strong>Cod. Original </strong></td>
    <td width="28%" bgcolor="#CCCCCC"><strong>Cod. Fabricante </strong></td>
    <td width="22%" bgcolor="#CCCCCC">&nbsp;</td>
    <td width="22%" bgcolor="#CCCCCC"><strong>Pr. Min. </strong></td>
  </tr>
  <tr>
    <td><?=$reg_prod['cod_original']?></td>
    <td><?=$reg_prod['Codigo_Fabricante']?></td>
    <td>&nbsp;</td>
    <td><?=number_format($reg_prod['pr_min'],2,",",".")?></td>
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
    <td bgcolor="#CCCCCC"><strong>Preco ant.:</strong></td>
  </tr>
  <tr>
    <td><?=$reg_prod['margen_a']?></td>
    <td><?=$reg_prod['margen_b']?></td>
    <td><?=$reg_prod['margen_c']?></td>
    <td><?=guarani($reg_prod['Preco_Venda'])?></td>
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
    <td width="18%" bgcolor="#CCCCCC"><strong>Cant. Disp. </strong></td>
    <td width="15%" bgcolor="#CCCCCC"><strong>Cant. Min. </strong></td>
    <td width="17%" bgcolor="#CCCCCC"><strong>IVA % </strong></td>
    <td width="18%" bgcolor="#CCCCCC"><strong>Cant. Total: </strong></td>
    <td width="19%" bgcolor="#CCCCCC"><strong>Cant. Bloq </strong></td>
    <td width="24%" bgcolor="#CCCCCC"><strong>Ult.Custo </strong></td>
  </tr>
  <tr>
    <td><?=$reg_prod['Estoque']?></td>
    <td><?=$reg_prod['qtd_min']?></td>
    <td><?=$reg_prod['iva']?></td>
    <td><?=($reg_prod['Estoque'] + $reg_prod['qtd_bloq'])?></td>
    <td><?=$reg_prod['qtd_bloq']?></td>
    <td><?=number_format($reg_prod['ult_custo'],2,",",".")?></td>
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
    <td><?=$reg_prod['local']?></td>
    <td><?=$reg_prod['embalagem']?></td>
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
    <td><?=$novadata?></td>
    <td><?=$reg_prod['user']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="35%" border="0">
  <tr>
    <td><strong>Alterar outro cadastro </strong></td>
  </tr>
</table>
<table width="38%" border="0">
  <tr>
    <td width="49%" bgcolor="#85C285"><strong>Codigo:</strong></td>
    <td width="51%" bgcolor="#85C285"><strong>Descripcion:</strong></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="pesquisa_prod_edit.php">
      <input type="text" name="ref" />
    </form></td>
    <td><form id="form2" name="form2" method="post" action="pesquisa_prod_edit.php">
      <input type="text" name="desc" />
    </form></td>
  </tr>
</table>
<table width="24%" border="0">
  <tr>
    <td width="31%"><font face="Arial">
      <input name="button2" type="button" onclick="window.close()" value="Cerrar" />
    </font></td>
    <td width="23%">&nbsp;</td>
    <td width="46%"></td>
  </tr>
</table>
<p>&nbsp;</p>
<ul><li>
    <div align="center" class="Estilo7 Estilo17">Todos los Directos Reservados </div>
  </li>
</ul>
<p></p>
</body>
</html>
