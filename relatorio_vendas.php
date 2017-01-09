<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

//$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$mes= date("m");



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Relatorio de Ventas</title>
</head>
<style type="text/css">
	body {
		color: #006;
		padding:3px 0px 3px 8px;
		background-color: #f2f1e2;
		border-width:2px;
		border-style:solid;
		border-color:#a2bfe9;
	}
	INPUT{
		text-transform:uppercase;
	}
.Estilo1 {
	font-size: 18px;
	font-weight: bold;
}
</style>


<body>
<table width="100%" border="0">
  <tr>
    <td><div align="center" class="Estilo1">Acompanhamento Mensual de Ventas </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php
$enero = 01;
$febrero = 02;
$marzo = 03;
$abril = 04;
$mayo = 05;
$junio = 06;
$julio = 07;
$agosto = 08;
$setembro= 09;
$novembro = 10;
$outubro = 11;
$novembro = 12;


		$sql_abril = "SELECT * FROM venda WHERE MONTH(data_venda) = '$abril' "; //, MONTH(data_car), SUM(total_nota) FROM pedido ";// GROUP BY MONTH(data_car) ORDER BY YEAR(data_car) DESC, MONTH(data_car) DESC ";
	
		$exe_abril = mysql_query($sql_abril);
		while ($reg_abril  = mysql_fetch_array($exe_abril, MYSQL_ASSOC)){

	//echo $reg_abril['data_venda'];
	
	$total_abril += $reg_abril['valor_venda'] ;
	
	//echo $total_abril; 
}
?>
<?
$sql_maio = "SELECT * FROM venda WHERE MONTH(data_venda) = '$mayo' "; //, MONTH(data_car), SUM(total_nota) FROM pedido ";// GROUP BY MONTH(data_car) ORDER BY YEAR(data_car) DESC, MONTH(data_car) DESC ";
	
		$exe_maio = mysql_query($sql_maio);
		while ($reg_maio  = mysql_fetch_array($exe_maio, MYSQL_ASSOC)){

	//echo $reg_maio['data_venda'];
	
	$total_maio += $reg_maio['valor_venda'] ;
	
	//echo $total_maio; 
}
?>

<?
$sql_febrero = "SELECT * FROM venda WHERE MONTH(data_venda) = '$febrero' "; //, MONTH(data_car), SUM(total_nota) FROM pedido ";// GROUP BY MONTH(data_car) ORDER BY YEAR(data_car) DESC, MONTH(data_car) DESC ";
	
		$exe_febrero= mysql_query($sql_febrero);
		while ($reg_febrero= mysql_fetch_array($exe_febrero, MYSQL_ASSOC)){

	//echo $reg_febrero['data_venda'];
	
	$total_febrero += $reg_febrero['valor_venda'] ;
	
	//echo $total_febrero; 
}
?>

<?
$sql_enero = "SELECT * FROM venda WHERE MONTH(data_venda) = '$enero' "; //, MONTH(data_car), SUM(total_nota) FROM pedido ";// GROUP BY MONTH(data_car) ORDER BY YEAR(data_car) DESC, MONTH(data_car) DESC ";
	
		$exe_enero = mysql_query($sql_enero);
		while ($reg_enero = mysql_fetch_array($exe_enero, MYSQL_ASSOC)){

	//echo $reg_enero['data_venda'];
	
	$total_enero += $reg_enero['valor_venda'] ;
	
	//echo $total_enero; 
}
?>
<?
$sql_marzo = "SELECT * FROM venda WHERE MONTH(data_venda) = '$marzo' "; //, MONTH(data_car), SUM(total_nota) FROM pedido ";// GROUP BY MONTH(data_car) ORDER BY YEAR(data_car) DESC, MONTH(data_car) DESC ";
	
		$exe_marzo = mysql_query($sql_marzo);
		while ($reg_marzo = mysql_fetch_array($exe_marzo, MYSQL_ASSOC)){

	//echo $reg_marzo['data_venda'];
	
	$total_marzo += $reg_marzo['valor_venda'] ;
	
	//echo $total_marzo; 
}
?>
<?
$sql_junio = "SELECT * FROM venda WHERE MONTH(data_venda) = '$junio' "; //, MONTH(data_car), SUM(total_nota) FROM pedido ";// GROUP BY MONTH(data_car) ORDER BY YEAR(data_car) DESC, MONTH(data_car) DESC ";
	
		$exe_junio = mysql_query($sql_junio);
		while ($reg_junio = mysql_fetch_array($exe_junio, MYSQL_ASSOC)){

	//echo $reg_junio['valor_venda']."<br>";
	
	$total_junio += $reg_junio['valor_venda']."<br>" ;
	
	//echo $total_junio; 
}
?>
<?
$sql_julio = "SELECT * FROM venda WHERE MONTH(data_venda) = '$julio' "; //, MONTH(data_car), SUM(total_nota) FROM pedido ";// GROUP BY MONTH(data_car) ORDER BY YEAR(data_car) DESC, MONTH(data_car) DESC ";
	
		$exe_julio = mysql_query($sql_julio);
		while ($reg_julio = mysql_fetch_array($exe_julio, MYSQL_ASSOC)){

	//echo $reg_junio['data_venda'];
	
	$total_julio += $reg_julio['valor_venda'] ;
	
	//echo $total_junio; 
}
?>

<?
$sql_agosto = "SELECT * FROM venda WHERE MONTH(data_venda) = '$agosto' "; //, MONTH(data_car), SUM(total_nota) FROM pedido ";// GROUP BY MONTH(data_car) ORDER BY YEAR(data_car) DESC, MONTH(data_car) DESC ";
	
		$exe_agosto = mysql_query($sql_agosto);
		while ($reg_agosto = mysql_fetch_array($exe_agosto, MYSQL_ASSOC)){

	//echo $reg_junio['data_venda'];
	
	$total_agosto += $reg_agosto['valor_venda'] ;
	
	//echo $total_junio; 
}
?>
<div id="atualiza" style="width:100%; height:450px; overflow:auto; overflow-y: scroll;">
<table width="100%" border="1" bordercolor="#009933">
  <tr>
    <td width="8%"><strong>Enero</strong></td>
    <td width="8%"><strong>Febrero</strong></td>
    <td width="8%"><strong>Marzo</strong></td>
    <td width="8%"><strong>Abril</strong></td>
    <td width="8%"><strong>Mayo</strong></td>
    <td width="8%"><strong>Junio</strong></td>
    <td width="8%"><strong>Julio</strong></td>
    <td width="8%"><strong>Agosto</strong></td>
    <td width="8%"><strong>Septiembre</strong></td>
    <td width="8%"><strong>Octubre</strong></td>
    <td width="8%"><strong>Noviembre</strong></td>
    <td width="8%"><strong>Diciembre</strong></td>
  </tr>
  <tr>
    <td height="73"><? echo number_format($total_enero,2,",",".") ?></td>
    <td><? echo number_format($total_febrero,2,",",".") ?></td>
    <td><? echo number_format($total_marzo,2,",",".") ?></td>
    <td><? echo number_format($total_abril,2,",",".") ?></td>
    <td><? echo number_format($total_maio,2,",",".") ?></td>
    <td><? echo number_format($total_junio,2,",",".") ?></td>
    <td><? echo number_format($total_julio,2,",",".") ?></td>
    <td><? echo number_format($total_agosto,2,",",".") ?></td>
    <td><? echo number_format($total_setembro,2,",",".") ?></td>
    <td><? echo number_format($total_outubro,2,",",".") ?></td>
    <td><? echo number_format($total_novembro,2,",",".") ?></td>
    <td><? echo number_format($total_dezembro,2,",",".") ?></td>
  </tr>
</table>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
