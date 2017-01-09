<?php
include "config.php";
conexao();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>

<form id="acesso" name="acesso" action="margens.php?acao=alter" onSubmit="return false" method="post">

<?php

	$sql_prod = "SELECT * FROM produtos  ";
				    $exe_prod = mysql_query($sql_prod, $base) or die (mysql_error());
				    $num_prod = mysql_num_rows($exe_prod);
				while ($reg_prod = mysql_fetch_array($exe_prod, MYSQL_ASSOC)) {
					 
					 
 		$custo = $reg_prod['custo'] ;


	if ($_GET['acao'] == "alter") {

	$margen_a = 40 ;
	$margen_b = 40 ;
	$margen_c = 40 ;
	
	
	$percentual_a = $margen_a / 100;
	$valor_a = $custo + ($percentual_a * $custo);
	
	$percentual_b = $margen_b / 100;
	$valor_b = $custo + ($percentual_b * $custo);
	
	$percentual_c = $margen_c / 100;
	$valor_c = $custo + ($percentual_c * $custo);

	$sql_per = "UPDATE produtos SET valor_a='$valor_a', valor_b='$valor_b', valor_c='$valor_c' where id = '".$reg_prod['id']."' AND id = '".$reg_prod['id']."'  " ;
	$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);

	//	echo 'Alteração efetuada com sucesso';

	}
	}
?>
</form>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Click em Enviar para alterar margens de lucro . </p>
<form id="form1" name="form1" method="post" action="margens.php?acao=alter">
  <input type="submit" name="Submit" value="Enviar" />
</form>
<p>&nbsp;</p>
  </body>
</html>


