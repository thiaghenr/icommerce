<?
include "config.php";
conexao();
?>

<html>
<head><TITLE>Resultados</TITLE><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url();
}
.Estilo1 {
	font-size: 36px;
	font-weight: bold;
}
-->
</style></head>
<body>
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="97" rowspan="2"><img src="logo_tracto.jpg" width="247" height="198"></td>
    <td width="567" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="68" colspan="2"><div align="center" class="Estilo1">Resultados de la Pesquiza </div></td>
  </tr>
  <tr>
    <td height="78" colspan="2" bgcolor="#CCCCCC"><?php
$desc = $_POST['desc'];
$ref = $_POST['ref'];

 

//$descricao = trim($descricao);

//$descricao = addslashes($descricao);


mysql_select_db('vendas');

$sql_lista = "SELECT * FROM produtos WHERE descricao LIKE '%$desc%' AND referencia LIKE '%$ref%'";
$exe_lista = mysql_query($sql_lista) or die (mysql_error() .' - '. $sql_lista);

$num_lista = mysql_num_rows($exe_lista);

echo '<p>Cantidad de productos encontrados: '.$num_lista.'</p>';
echo "<form action='pedido.php' method='post'>\n\t";
echo "<table border='1' bordercolor='black' bgcolor='white' width='100%'>\n";
echo " <tr>\n";
echo " <td width='30%'><strong>REFERENCIA<br/> \n";
echo " </td>\n";
echo " <td width='45%'><strong>DESCRIPCION<br/>\n";
echo " <b></b>\n";
echo " </td>\n";
echo " <td width='10%'><strong>STOCK<br/>\n";
echo " <b></b>\n";
echo " </td>\n";
echo " <td width='15%'><strong>VALOR UNITARIO<br/>\n";
echo " <b></b>\n";
echo " </td>\n";
echo " </tr>\n";

if ($num_lista > 0) {
		while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		?>
		<tr>
			<td width="25%"><?=$reg_lista['referencia']?></td>
			<td width="25%"><?=$reg_lista['descricao']?></td>
			<td width="25%"><?=$reg_lista['qtdestoque']?></td>
			<td width="25%"><?=number_format($reg_lista['prvenda'],2,",",".")?></td>
			<td width="25%"><a href="pedido.php?acao=add&id=<?=$reg_lista['referencia']?>">Selecionar</a>
		</tr>	
		<?
		}

	}





//echo "<td colspan='2'><input type='submit' value='Enviar'/></td>\n";
?></td>
  </tr>
</table>
</body>
</html>