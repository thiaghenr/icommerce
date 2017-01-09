<?php
function conexao() {
	global $base;
	global $title;
	$base = mysql_connect("localhost","root","root") or die (mysql_error());
	$db   = mysql_select_db("icommerce",$base) or die(mysql_error());
}
$cabecalho = 'Nelore';
$title = "Nelore - By iCommerce";
$fantasia = 'Nelore' ;

?>
