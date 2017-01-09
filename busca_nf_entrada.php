<?
require_once("verifica_login.php");
include "config.php";
conexao();
$mes= date("m");

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Entrada Produtos - <? echo $title ?></title>
<style type="text/css">

body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #f2f1e2;
border-width:2px;
border-style:solid;
border-color:#a2bfe9;
}

<!--
.Estilo13 {
	font-size: 36px;
	font-weight: bold;
}
.Estilo14 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<p align="center" class="Estilo5"><? echo $title; ?></p>
<table width="80%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#FF0000"><div align="center" class="Estilo1">
      <p>Lancamento de Produtos </p>
    </div></td>
  </tr>
</table>
<!--
<pre><strong>Pesquizar Por</strong>:</pre>
<table width="80%" border="0">
  <tr>
    <td width="19%" bgcolor="#ECE9D8">N. Compra </td>
    <td width="34%" bgcolor="#ECE9D8">N. Fatura </td>
    <td width="13%" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="34%" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="id" method="post" action="">
      <label>
      <input type="text" name="ped" />
      </label>
    </form>    </td>
    <td><form id="form2" name="nome_cli" method="POST" action="">
      <label>
        <input type="text" size="40" name="nom" />
        </label>
    </form>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
-->
<?
if ($_GET['acao'] == "delete") {
		if (isset($_GET['ide'])) {
			if ($_GET['ide']) {
				$ide = $_GET['ide'];
				
				$sql_verifica = "SELECT COUNT(*) AS n_prod FROM itens_compra WHERE compra_id = '$ide' "; 
				$exe_verifica = mysql_query($sql_verifica, $base) or die (mysql_error());			
				$reg_verifica = mysql_fetch_array($exe_verifica, MYSQL_ASSOC);
				
				if ($reg_verifica['n_prod'] == 0) {	
					$sql_del = "DELETE FROM compras WHERE id_compra = '".$ide."' "; 
					$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
					
					$sql_pagar = "DELETE FROM contas_pagar WHERE compra_id = '".$ide."' ";
					$exe_pagar = mysql_query($sql_pagar, $base) or die (mysql_error());
				}
				else {
					echo '<strong>Operacion no permitida, ha productos cadastrados con esta compra</strong>' ;
				}
			}
		}	
	}		
?>
<p>&nbsp;</p>
<table border="0" width="89%">
  <tr>
    <td width="11%" bgcolor="#CCCCCC"><strong>N. Compra </strong></td>
    <td width="14%" bgcolor="#CCCCCC"><strong>Cod. Fornecedor </strong></td>
    <td width="43%" bgcolor="#CCCCCC"><strong>Fornecedor</strong></td>
    <td width="13%" bgcolor="#CCCCCC"><strong>Data Emissao </strong></td>
    <td width="12%" bgcolor="#CCCCCC"><strong>Data Entrada </strong></td>
  </tr>
  <?
	
		
	//$sql_lista = "SELECT  id, nome_cli, total_nota, data_car, vendedor FROM pedido"; 
	$sql_lista = "SELECT c.*, f.id as id_forn, f.nome FROM compras c, proveedor f WHERE f.id = c.fornecedor_id  AND c.status = 'A' "; // ORDER BY data_car ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	
		while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {

		$data2 = $reg_lista['dt_emissao_fatura'];
		$hora2 = $reg_lista['dt_emissao_fatura'];
		//Formatando data e hora para formatos Brasileiros.
		$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
		$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
		
		$data3 = $reg_lista['data_lancamento'];
		$hora3 = $reg_lista['data_lancamento'];
		//Formatando data e hora para formatos Brasileiros.
		$novadata2 = substr($data3,8,2) . "/" .substr($data3,5,2) . "/" . substr($data3,0,4);
		$novahora2 = substr($hora3,11,2) . "h " .substr($hora3,14,2) . " min";
	?>
  <tr>
    <td width="11%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><?=$reg_lista['id_compra']?></td>
    <td width="14%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><?=$reg_lista['id_forn']?></td>
    <td width="43%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><?=$reg_lista['nome']?></td>
    <td width="13%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><?=$novadata?></td>
    <td width="12%" bordercolor="#FFCCFF" bgcolor="#FFCCFF"><?=$novadata2?></td>
   <td width="4%" bgcolor="#FFFFFF"><a href="entrada_produtos.php?ide=<?=$reg_lista['id_compra']?>"><img src="images/entrada.jpg" width="16" height="16" border="0"/></a></td> 
   <td width="3%" bgcolor="#FFFFFF"><a href="busca_nf_entrada.php?acao=delete&ide=<?=$reg_lista['id_compra']?>"><img src="images/delete.gif" width="14" height="14" border="0"/></a></td>
  </tr>
  <?
			}
	echo '<p>Compras à dar entrada: '.$num_lista.'</p>';
	?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<hr color="#CCCCCC" width="100%" size="14" noshade="noshade" />
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()"
    value="Cerrar" />
</font></p>
<p>&nbsp;</p>
</body>
</html>
