<?
	require_once("biblioteca.php");
 	require_once("config.php");
    conexao();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>





<?	
	
	$sql_venda = "SELECT p.* FROM planocontas2 p WHERE  idplanocontas > '161' order by p.idplanocontas";		  
	$exe_venda = mysql_query($sql_venda) or die(mysql_error());
	while ($reg_venda = mysql_fetch_array($exe_venda, MYSQL_ASSOC)){
	
	 $id = $reg_venda['idplanocontas'];
	 $pai = $reg_venda['plancodigopai'];
	 $cod = $reg_venda['plancodigo'];
	 $desc = $reg_venda['plandescricao'];
	 $tipo = $reg_venda['plantipo'];
	 $data = $reg_venda['plandatacad'];
	 $dtalt = $reg_venda['plandataalt'];
	 $receita = $reg_venda['planreceita'];
	 $user = $reg_venda['planuseralt'];
	 $padrao = $reg_venda['planpadrao'];
	


  $sql_pedido = "INSERT INTO planocontasbkp ( plancodigo,plancodigopai,plandescricao,plantipo,plandatacad,plandataalt,planreceita,planuseralt,planpadrao )
				VALUES( '$pai', '$cod', '$desc', '$tipo', '$data', '$dtalt', '$receita', '$user', '$padrao' )	";	
  $exe_pedido = mysql_query($sql_pedido)or die(mysql_error());
	
	}
	
?>



</body>
</html>