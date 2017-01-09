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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pedido - <? echo $title; ?></title>
<style type="text/css">
<!--
.Estilo3 {
	color: #000000;
	font-weight: bold;
}
.Estilo4 {
	color: #FFFFFF;
	font-family: Geneva, Arial, Helvetica, sans-serif;
}
.Estilo7 {font-size: 12px}
.Estilo13 {
	font-size: 36px;
	font-weight: bold;
}
-->
</style>


<script>
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='\pesquiza_cot.php';
 }
 else if(lugar=='CJ'){
  window.location.href='http://';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}
</script>

</head>
<body>
<p align="center" class="Estilo13"><? echo $cabecalho; ?></p>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#FF0000"><div align="center">
      <p class="Estilo3 Estilo2 Estilo4">Cotizaciones</p>
    </div></td>
  </tr>
</table>
<p>
  <?php
$nom = $_POST['nom'];
$ped = $_POST['ped'];
 

//$descricao = trim($descricao);

//$descricao = addslashes($descricao);

$sql_lista = "SELECT * FROM cotacao WHERE id LIKE '%$ped%' AND nome_cli LIKE '%$nom%' ";
$exe_lista = mysql_query($sql_lista) or die (mysql_error() .' - '. $sql_lista);
$num_lista = mysql_num_rows($exe_lista);

echo '<p>Cantidad de cotizaciones encontradas: '.$num_lista.'</p>';
echo "<table border='1' bordercolor='white' bgcolor='#ECE9D8' cellspacing='' width='100%'>\n";
echo " <tr>\n";
echo " <td width='8%'><strong>Pedido<br/> \n";
echo " </td>\n";
echo " <td width='37%'><strong>Cliente<br/>\n";
echo " <b></b>\n";
echo " </td>\n";
echo " <td width='15%'><strong>Data<br/>\n";
echo " <b></b>\n";
echo " </td>\n";
echo " <td width='10%'><strong>Situacao<br/>\n";
echo " <b></b>\n";
echo " </td>\n";
echo " <td width='10%'><strong>Total<br/></td>\n";
echo " <b></b>\n";
echo " </td>\n";
echo " <td width='15%'><strong>Vendedor</td><br/>\n";
echo " <td width='15%' bgcolor='#FFFFFF'><strong>Visualizar</td><br/>\n";



if ($num_lista > 0) {
		while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		?>
</p><?
// Pegando data e hora.
$data2 = $reg_lista['data_car'];
//$hora = date("H:i:s");
//Formatando data e hora para formatos Brasileiros.
$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
$novahora = substr($hora,0,2) . "h" .substr($hora,3,2) . "min";
?>

<tr>	
			<td width="8%" bgcolor="#FFCCFF"><?=$reg_lista['id']?></td>
			<td width="37%" bgcolor="#FFCCFF"><?=$reg_lista['nome_cli']?></td>
			<td width="15%" bgcolor="#FFCCFF"><?=$novadata ?></td>
			<td width="10%" bgcolor="#FFCCFF"><?=$reg_lista['situacao']?></td>
			<td width="15%" bgcolor="#FFCCFF"><?=number_format($reg_lista['total_nota'],2,",",".")?></td>
			<td width="10%" bgcolor="#FFCCFF"><?=$reg_lista['user']?></td>
			<td width="3" bgcolor="#FFFFFF"><a href="vis_cotizacion.php?acao=add&ide=<?=$reg_lista['id']?>"><img src="images/visualizar.bmp" width="12" height="14" border="0"/></a>
</tr>	
		<p>
		  <?
		}

	}





//echo "<td colspan='2'><input type='submit' value='Enviar'/></td>\n";
?>
		  </td>
            </tr>
          </table>
</p>
		<form id="form1" name="form1" method="post" action="">
		  <label>
		   <input type="button" value="Volver" name="LINK1" OnClick="navegacao('voltar')">
	      </label>
</form>
		<p>&nbsp;</p>
		<p><a href="javaScript:window.print()">Imprimir</a>&nbsp;</p>
		<hr width="100%" color='#ECE9D8' size="14" noshade="noshade" />
        <ul>
          <li>
            <div align="center" class="Estilo7">BRSoft - Ciudad Del Este</div>
          </li>
          <li>
            <div align="center" class="Estilo7">Todos los Derechoa Reservados </div>
          </li>
        </ul>
        <p>&nbsp;        </p>
</body>
</html>
			
 




</body>

</html>
