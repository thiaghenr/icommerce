<html>

<head>
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Lista Geral de Produtos</title>
</head>

<body>

<p><img border="0" src="logo_tracto.jpg" width="247" height="198"><img border="0" src="01.jpg" width="633" height="144"></p>
<p><b><font color="#0000FF">Exibir Productos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
Cotacíon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Venta&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</font></b></p>
<p>&nbsp;</p>

</body>

</html>
<?
// Mensagens de Erro
$msg[0] = "Conexão com o banco falhou!";
$msg[1] = "Não foi possível selecionar o banco de dados!";

// Fazendo a conexão com o servidor MySQL
$conexao = mysql_connect("localhost","root","010477") or die($msg[0]);
mysql_select_db("vendas",$conexao) or die($msg[1]);

// Colocando o Início da tabela
?>
<table produtos="1"><tr>
   <td><b>referencia</b></td>
   <td><b>descricao</b></td>
   <td><b>qtdestoque</b></td>
   <td><b>prvenda</b></td>
</tr>
<?

// Fazendo uma consulta SQL e retornando os resultados em uma tabela HTML

$query = "SELECT referencia,descricao,qtdestoque,prvenda FROM produtos where qtdestoque >0 ORDER BY descricao";
//$query = "SELECT referencia,descricao,prvenda FROM WHERE descricao like '%correia%' produtos ORDER BY descricao";

// WHERE descricao like '%ABRAC%'


$resultado = mysql_query($query,$conexao);
while ($linha = mysql_fetch_array($resultado)) {
   ?>
   <tr>
      <td><? echo $linha['referencia']; ?></td>
      <td><? echo $linha['descricao']; ?></td>
      <td><? echo $linha['qtdestoque']; ?></td>
      <td><? echo $linha['prvenda']; ?></td>
   </tr>
   <?
}
?>
</table>
