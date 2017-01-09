<?
require_once("verifica_login.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language='JavaScript' type='text/javascript'>
function confirmLink() {
  if( confirm( 'Tem certeza que desejafazer isso?' ) ) {
    alert( 'Sim, você tem certeza!' );
  } else {
    alert( 'É, você não tem certeza!' );
  } 
}
</script>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Formas de Pagamento - Todo Camiones</title>
<style type="text/css">
<!--
.Estilo14 {	font-size: 36px;
	font-weight: bold;
}
.Estilo15 {	color: #FFFFFF;
	font-weight: bold;
}
.Estilo4 {font-size: 12px}
-->
</style>
</head>

<body>
<p align="center" class="Estilo14">TODO CAMIONES</p>
</table>
<p>&nbsp;</p>
<table width="80%" border="0">
  <tr>
    <td bgcolor="#FF0000"><div align="center" class="Estilo15">Formas de Pagamento </div></td>
  </tr>
</table>
<?


	if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "insere") {
	
	$re = mysql_query("select count(*) as total from forma_pagamento where descricao = '$descricao'");
	$total = mysql_result($re, 0, "total");
	
	if ($total == 0) {	
		
	$sql_per = "INSERT INTO forma_pagamento (descricao, qtd_parcela,intervalo_parcela) VALUES('$descricao', '$qtd_parcela', '$intervalo_parcela' )";
	$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	
		}
		
		else{

echo "<strong>Forma de pagamento ja cadastrada</p>";

echo '<a href="formas_pag.php">Voltar</a>' ;

echo " </p>\n";
echo " </p>\n";
//echo " <a href=cadastro_marcas.php>Voltar</a>";
exit;
}
		
}		
	}
	
		if ($_GET['acao'] == "del") {
		if (isset($_GET['descricao'])) {
			if ($_GET['descricao']) {
				$id_prod = addslashes(htmlentities($_GET['descricao']));
				
	$sql_del = "DELETE FROM forma_pagamento WHERE descricao = '$id_prod'   "; 
				$exe_del = mysql_query($sql_del) or die (mysql_error());
				
		}
	}	
	}		
?>


<form id="form1" name="deescricao" method="post" action="formas_pago.php?acao=insere&id" />
<table width="80%" border="0">
  <tr>
    <td width="30%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="23%">&nbsp;</td>
    <td width="22%">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#D4D0C8"><strong>Forma Pagamento :</strong></td>
    <td bgcolor="#CCCCCC"><strong>Cantidad quotas: <strong></strong></strong></td>
    <td bgcolor="#CCCCCC"><strong>Intervalo de Dias: </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text" name="descricao" /></td>
    <td>&nbsp;
    <input type="text" name="qtd_parcela" /></td>
    <td><input type="text" name="intervalo_parcela" /></td>
	<td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>
  <input type="submit" name="marcas" value="Cadastrar" /> </form>
<table border="0" width="62%">
            <tr>
			  <td width="29%" bgcolor="#999999"><strong>Forma Pagamento </strong></td>
              <td width="20%" bgcolor="#999999"><strong>Cantidad quotas: <strong></strong></strong></td>
			  <td width="25%" bgcolor="#999999"><strong>Intervalo de Dias: <strong></strong></strong></td>
              <td width="26%"><a href="formas_pag.php?acao=add&id=<?=$reg_lista['descricao']?>"></a></td>
            </tr>
   			
<?
	
	$sql_lista = "SELECT * FROM forma_pagamento"; 
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
			$data2 = $reg_lista['data'];
			$hora2 = $reg_lista['data'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			?>
			 <tr> 								
              <td width="29%" height="20" bgcolor="#CCCCCC"><?=$reg_lista['descricao']?></td>
              <td width="20%" bgcolor="#CCCCCC"><?=$reg_lista['qtd_parcela']?></td>
			  <td width="25%" bgcolor="#CCCCCC"><?=$reg_lista['intervalo_parcela']?></td>
			  <td width="26%" bgcolor="#FFFFFF"><a href="formas_pago.php?acao=del&descricao=<?=$reg_lista['descricao']?>" onclick='function confirmLink()'/><img src="images/delete.gif" width="12" border="0"height="14" />
			 </tr>
			
			<?
			}
	echo '<p>Cantidad de formas de pagamento cadastradas: '.$num_lista.'</p>';
	
	
$Minutos = 60;// segundos
$Horas = 60*$Minutos;
$Dias = 24*$Horas;
//quero fazer que ele coloque no prazo 30 dias então :
$Prazo = 30;
$DataFinaldoPrazo = 
date("d/m/Y",time()+$Prazo*$Dias);
echo $DataFinaldoPrazo;
	
 ?>           
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<hr width="100%" size="14" noshade="noshade" />
<ul><li><div align="center" class="Estilo4">BRSoft - Ciudad Del Este </div>
  </li>
  <li>
    <div align="center" class="Estilo4">Todos los Derechos Reservados </div>
  </li>
</ul>
<p></p>
<p>&nbsp;</p>
</body>
</html>
