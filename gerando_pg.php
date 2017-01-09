<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>


<form id="gera" name="gera" action="gerando_pg.php" method="POST">
 <input type="text" id="qtd" name="qtd"  />
  <label>
  <input type="submit" name="Submit" value="Enviar" />
  </label>
</form>
<?php

$qtd = $_POST['qtd'];


$z = 0;
while($z < $qtd) {
   $z++;
   echo "Data $z: <input type='text' name='Data$z'><br>\n";
   echo "Valor $z: <input type='text' name='Valor$z'><br><br>\n";
}




?>
 

</body>
</html>
