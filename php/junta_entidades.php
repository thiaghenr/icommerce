<?php
include "config.php";
conexao();

/*
$sqlcli = "SELECT * FROM proveedor";
$execli = mysql_query($sqlcli)or die (mysql_error().'-'.$sqlcli);

while ($regcli = mysql_fetch_array($execli, MYSQL_ASSOC)){

	$sqlent = "INSERT INTO entidades (nome,fantasia,endereco,cidade,telefone1,fax,celular,ruc,cedula,email,data,lim_credito,desc_max)
										VALUES('".$regcli['nome']."','".$regcli['nome']."','".$regcli['endereco']."','".$regcli['cidade']."','".$regcli['telefone']."','".$regcli['fax']."',
										'".$regcli['celular']."','".$reg['ruc']."','".$regcli['cedula']."','".$regcli['email']."','".$regcli['data_cad']."','".$regcli['limite']."','".$regcli['desc_max']."'  )";
	$exeent = mysql_query($sqlent)or die (mysql_error().'-'.$sqlent);


}


$sqlcli = "SELECT * FROM clientes";
$execli = mysql_query($sqlcli)or die (mysql_error().'-'.$sqlcli);
while ($regcli = mysql_fetch_array($execli, MYSQL_ASSOC)){

	$sqlent = "INSERT INTO entidades (nome,fantasia,endereco,cidade,telefone1,fax,celular,ruc,cedula,email,data,lim_credito,desc_max)
										VALUES('".$regcli['nome']."','".$regcli['nome']."','".$regcli['endereco']."','".$regcli['cidade']."','".$regcli['telefonecom']."','".$regcli['fax']."',
										'".$regcli['celular']."','".$reg['ruc']."','".$regcli['cedula']."','".$regcli['email']."','".$regcli['data']."','".$regcli['limite']."','".$regcli['desc_max']."'  )";
	$exeent = mysql_query($sqlent)or die (mysql_error().'-'.$sqlent);

}
*/
$sqlcli = "SELECT endereco,ruc,controle FROM clientes";
$execli = mysql_query($sqlcli)or die (mysql_error().'-'.$sqlcli);
while ($regcli = mysql_fetch_array($execli, MYSQL_ASSOC)){

	$sqlent = "UPDATE entidades SET endereco = '".$regcli['endereco']."', ruc = '".$reg['ruc']."'  WHERE controle = '".$reg['controle']."'  ";
	$exeent = mysql_query($sqlent)or die (mysql_error().'-'.$sqlent);

}

/*
$sqluser = "SELECT * FROM usuario";
$exeuser = mysql_query($sqluser)or die (mysql_error().'-'.$sqlcli);
while ($reguser = mysql_fetch_array($exeuser, MYSQL_ASSOC)){

	$sqlent = "INSERT INTO entidades (nome,fantasia,endereco,cidade,telefone1,fax,celular,ruc,cedula,email,data,lim_credito,desc_max)
										VALUES('".$reguser['nome']."','".$reguser['nome']."','".$reguser['endereco']."','".$reguser['cidade']."','".$reguser['telefonecom']."','".$reguser['fax']."',
										'".$reguser['celular']."','".$reguser['ruc']."','".$reguser['cedula']."','".$reguser['email']."','".$reguser['data']."','".$reguser['limite']."','".$reguser['desc_max']."'  )";
	$exeent = mysql_query($sqlent)or die (mysql_error().'-'.$sqlent);


}

*/





?>