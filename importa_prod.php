<?
include "config.php";
conexao();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?
	if ( 1 > 3) { 

	$sql = "SELECT * FROM plan2 group by Codigo  order by Codigo ";
	$exe = mysql_query($sql) or die (mysql_error().'-'.$sql);
	while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)) {
	
	$inserir = "INSERT INTO produtos (Codigo,Descricao) VALUES( '".$reg['Codigo']."' , '".$reg['Descricao']."') ";
	$exe_inserir = mysql_query($inserir) or die (mysql_error().'-'.$inserir);
	
	}
	}
	
?>