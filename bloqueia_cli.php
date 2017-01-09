<?
	require_once("biblioteca.php");
 	require_once("config.php");
    conexao();
	$cli = $_GET['cli'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bloqueia Cliente</title>
	<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css" />
</head>

<body>

<form id="form1" name="form1" method="post" action="bloqueia_cli.php?acao=atualiza&cli=<?=$cli?>">
<table width="73%" border="0">
  <tr>
    <td width="6%" class="x-grid3-cell-selected">Codigo</td>
    <td width="42%" class="x-grid3-cell-selected">Nombre</td>
    <td width="17%" class="x-grid3-cell-selected">Telefono</td>
    <td width="17%" class="x-grid3-cell-selected">Ruc</td>
    <td width="18%" class="x-grid3-cell-selected">&nbsp;</td>
  </tr>
  <?
  		$sql_cli = "SELECT * FROM clientes WHERE controle = '$cli' ";
		$exe_cli = mysql_query($sql_cli, $base) or die (mysql_error());
		while ($reg_cli = mysql_fetch_array($exe_cli, MYSQL_ASSOC)){
  
  		$status = $reg_cli['ativo'];
		$nom = $reg_cli['nome'];
		
  
  ?>
  <tr>
    <td class="x-box-mc"><?=$reg_cli['controle']?></td>
    <td class="x-box-mc"><?=$reg_cli['nome']?></td>
    <td class="x-box-mc"><?=$reg_cli['controle']?></td>
    <td class="x-box-mc"><?=$reg_cli['controle']?></td>
    <td class="x-box-mc">
    <?
	if($status == 'S'){
	?>
     <input type="submit" name="button" id="button" value="Bloquear Cliente" />
     <?
	 }
	 else{
	 ?>
     <input type="submit" name="button" id="button" value="Liberar Cliente" />
     <?
	 }
	 ?>
     </td>
  </tr>
  <?
  }
  ?>
</table>
<?
	if($_GET['acao'] == 'atualiza'){
	
		if($status == 'S'){
		
			$sql_bloq = "UPDATE clientes SET ativo = 'N' WHERE controle = '$cli' ";
			$exe_bloq = mysql_query($sql_bloq, $base);
			 echo "<script language='javaScript'>window.location.href='lista_cli.php'</script>";
			}
		else{
			$sql_bloq = "UPDATE clientes SET ativo = 'S' WHERE controle = '$cli' ";
			$exe_bloq = mysql_query($sql_bloq, $base);
			 echo "<script language='javaScript'>window.location.href='lista_cli.php'</script>";
			}
		
}
?>


 </form>






</body>
</html>