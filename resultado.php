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
    <td width="567" valign="top"><img src="01.jpg" width="633" height="144"></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="68" colspan="2"><div align="center" class="Estilo1">Resultados da Pesquisa </div></td>
  </tr>
  <tr>
    <td height="78" colspan="2" bgcolor="#CCCCCC"><?php
$desc = $_POST['desc'];
$ref = $_POST['ref'];

//if(!$desc){
//  echo "<p><font color=red><strong>Você não entrou com os dados necessários.
//  Volte a página anterior e tente novamente</font</p>";
//  exit; 
//} 

$descricao = trim($descricao);

$descricao = addslashes($descricao);

@$db = mysql_pconnect(localhost,'root','010477');
if(!$db){
  echo "Erro: Não foi feita a conexão com o banco de dados. Tente novamente.";
}

mysql_select_db('vendas');

$query = "SELECT * FROM produtos WHERE descricao LIKE '%$desc%' AND referencia LIKE '%$ref%'";
$consulta = mysql_query($query) or die (mysql_error() .' - '. $sql);

$linhas = mysql_num_rows($consulta);

echo '<p>Quantidade de produtos encontrado: '.$linhas.'</p>';
echo "<table border='1' bordercolor='black' bgcolor='white' width='100%'>\n";
echo " <tr>\n";
echo " <td width='30%'><strong>REFERENCIA<br/> \n";
echo " </td>\n";
echo " <td width='45%'><strong>DESCRIPCION<br/>\n";
echo " <b></b>\n";
echo " </td>\n";
echo " <td width='10%'><strong>ESTOQUE<br/>\n";
echo " <b></b>\n";
echo " </td>\n";
echo " <td width='15%'><strong>VALOR UNITARIO<br/>\n";
echo " <b></b>\n";
echo " </td>\n";
echo " <td width='10%'><strong>SELECIONE<br/>\n";
echo " <b></b>\n";
echo " </tr>\n";


for($n = 0; $n < $linhas; $n++){
  $registro = mysql_fetch_array($consulta);
  // Cria o cabeçalho da tabela de resultados
  
echo "<table border='0' bordercolor='' bgcolor='white' width='100%'>\n";
echo " <tr>\n";
echo " <td width='30%'>\n";
echo  ''.htmlspecialchars(stripslashes($registro['referencia'])).'<br>';
echo " </td>\n";
echo " <td width='45%'>\n";
echo " <b></b>\n";
echo ''.stripslashes($registro['descricao']).'<br>';
echo " </td>\n";
echo " <td width='10%'>\n";
echo " <b></b>\n";
echo ''.stripslashes($registro['qtdestoque']).'<br>';
echo " </td>\n";
echo " <td width='10%'>\n";
echo " <b></b>\n";
echo ''.stripslashes($registro['prvenda']).'<br>';
echo " </td>\n";
echo " <td width='10%'>\n";
echo " </tr>\n";
echo "<td><input type='checkbox' name='prod[]' value='".$registro['referencia']."'/>\n";
echo " </td>\n";
echo " </tr>\n";



  echo '<p>'.($n+1).'.';
 // echo 'referencia :'.htmlspecialchars(stripslashes($registro['referencia'])).'<br>';
 // echo 'descricao  :'.stripslashes($registro['descricao']).'<br>';
 // echo 'prvenda   :'.stripslashes($registro['prvenda']).'<br>'; 
}

?></td>
  </tr>
</table>
</body>
</html>

