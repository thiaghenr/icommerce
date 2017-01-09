<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$dia= date("d");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pesquiza Pedidos Venta - <? echo $title ?></title>
<style type="text/css">
<!--
.Estilo4 {font-size: 12px}
-->
</style>

<link rel="stylesheet" href="/js/jquery/calendario/calendario.css"/>
<script type="text/javascript" src="/js/jquery/jquery/jquery.js"></script>
<script type="text/javascript" src="/js/jquery/calendario/jquery-calendar.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-numeric.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-floatnumber.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#data_ini").calendar({buttonImage: "images/calendar.gif"});
		$("#data_fim").calendar({buttonImage: "images/visualizar.JPG"});		
	
		$(".numeric").numeric(",");
	    $(".numeric").floatnumber(",",2);
	});	
</script>

<style type="text/css">
body {
font-family: "Trebuchet MS", Verdana, Arial;
font-size: 12px;
color: #006;
background-color: #F6F5F0;
}
a:link, a:visited {
color: #00F;
text-decoration: underline overline;
}
a:hover, a:active {
color: #F00;
text-decoration: none;
}
.Estilo7 {
	color: #000000;
	font-weight: bold;
}
.Estilo8 {color: #000000}
</style>



</head>

<body onload="document.getElementById('id').focus()">

<?
$ids = $_GET['id'];
		
if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "lanca") {
							
					$sql_prodp = "SELECT * FROM pedido WHERE id =  '$ids' ";
				    $exe_prodp = mysql_query($sql_prodp, $base) or die (mysql_error());
				    $num_prodp = mysql_num_rows($exe_prodp);
					//if ($num_prodp > 0) {
						
					$reg_prodp = mysql_fetch_array($exe_prodp, MYSQL_ASSOC );
					
					//$sql_user = "SELECT * FROM usuario WHERE id = '$id_usuario' ";
					//$rs_user = mysql_query($sql_user) or die (mysql_error() .'-'.$sql_user);
					//$reg_user = mysql_fetch_array($rs_user, MYSQL_ASSOC);
		
					//$vendedor = $reg_user['nome_user'];
					
					
					
					
					$sql_alt_status = "UPDATE pedido SET situacao = 'A' WHERE id = '$ids' "; 
					$exe_alt_status = mysql_query($sql_alt_status, $base) or die (mysql_error());	
					
									
										
					$sql_addv = "INSERT INTO venda
								(data_venda, pedido_id, num_boleta, valor_venda, imposto_id, controle_cli )
								VALUES
								(NOW(), '".$reg_prodp['id']."', '0', '".$reg_prodp['total_nota']."',  '10', '".$reg_prodp['controle_cli']."')";
					$id_venda = mysql_insert_id();
								
					$exe_addv = mysql_query($sql_addv, $base) or die (mysql_error().'-'.$sql_addv);				
						
					$id_venda = mysql_insert_id();
					
					$sql_prodc = "SELECT * FROM itens_pedido WHERE  id_pedido = '$ids'  " ;
				    $exe_prodc = mysql_query($sql_prodc) or die (mysql_error());
				    $num_prodc = mysql_num_rows($exe_prodc);
					if ($num_prodc > 0) {			
					
				while ($reg_prodc = mysql_fetch_array($exe_prodc, MYSQL_ASSOC )) {			
					
					$sql_addi = "INSERT INTO itens_venda
								(id_venda, referencia_prod, descricao_prod, prvenda, qtd_produto)
								VALUES
								('$id_venda','".$reg_prodc['referencia_prod']."', '".$reg_prodc['descricao_prod']."', '".$reg_prodc['prvenda']."', '".$reg_prodc['qtd_produto']."')";			
																
								$qtd_prod =  $reg_prodc['qtd_produto'] ;
								$exe_addi = mysql_query($sql_addi, $base) or die (mysql_error().'-'.$sql_addi);		
//	$sql_lista = "SELECT v.*, c.* FROM venda v, clientes c WHERE v.id = $idv AND v.controle_cli = c.controle";
					
					
											
		
		$sql_qtd1 = "UPDATE produtos SET qtd_bloq =  qtd_bloq - '$qtd_prod' WHERE Codigo = '$reg_prodc[referencia_prod]' ";
		$exe_qtd1 = mysql_query($sql_qtd1, $base) or die (mysql_error());	
		
		
			
		
					//}
				}
			}
		}	
		}
$Minutos = 60;// segundos
$Horas = 60*$Minutos;
$Dias = 24*$Horas;
//quero fazer que ele coloque no prazo 30 dias então :
$Prazo = 30;
$DataFinaldoPrazo = 
date("d/m/Y",time()+$Prazo*$Dias);
echo $DataFinaldoPrazo;
	
		
		
		
	?>


<? echo $num_prod ;
   echo $total_parcelado ;	
   echo $reg_prodp['controle_cli'] ;
   
 ?>
 <? 
		
	if ($_GET['acao'] == "lancar") {
	echo $_GET['ide'];
	$id = $_GET['ide'];
	echo $_GET['acao'];
	 
							
					$sql_prodp = "SELECT * FROM pedido WHERE id =  '$id' ";
				    $exe_prodp = mysql_query($sql_prodp, $base) or die (mysql_error());
				    $num_prodp = mysql_num_rows($exe_prodp);
					if ($num_prodp > 0) {
						
					$reg_prodp = mysql_fetch_array($exe_prodp, MYSQL_ASSOC );
					
					//$sql_user = "SELECT * FROM usuario WHERE id = '$id_usuario' ";
					//$rs_user = mysql_query($sql_user) or die (mysql_error() .'-'.$sql_user);
					//$reg_user = mysql_fetch_array($rs_user, MYSQL_ASSOC);
		
					//$vendedor = $reg_user['nome_user'];
					
					$sql_comissao = "INSERT INTO comissao
					 (user_id, pedido_id, valor_pedido, data_venda, situacao) 
					 VALUES
					 ('".$reg_prodp['usuario_id']."', '".$reg_prodp['id']."', '".$reg_prodp['total_nota']."', '".$reg_prodp['data_car']."', 'A') ";
					$exe_comissao = mysql_query($sql_comissao, $base) or die (mysql_error());	
					
					}
					}
					
   
   
?>



<table width="80%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#C5D6FC"><div align="center" class="Estilo7">FACTURAR PEDIDOS </div></td>
  </tr>
</table>
<pre><strong>Pesquizar Por</strong>:</pre>
<table width="80%" border="0">
  <tr>
    <td width="19%" bgcolor="#C5D6FC"><span class="Estilo7">N. Pedido: </span></td>
    <td width="34%" bgcolor="#C5D6FC"><span class="Estilo7">Nombre del Cliente:</span></td>
    <td width="22%" bgcolor="#C5D6FC"><span class="Estilo7">Data:</span></td>
    <td width="25%" bgcolor="#F6F5F0">&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="id" method="post" action="importar_pedido.php?acao=ide">
      <label>
        <input type="text" name="id" />
        </label>
    </form></td>
    <td><form id="form2" name="nome_cli" method="post" action="importar_pedido.php?acao=ide">
      <label>
        <input type="text" size="40" name="nom" />
        </label>
    </form></td>
    <td><form id="form3" name="form3" method="post" action="">
     <input type="text" name="data_ini" id="data_ini" value='<?= date("d/m/Y") ?>'/>
    </form>    </td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="0" width="100%">
  <tr>
    <td width="7%" bgcolor="#C5D6FC"><span class="Estilo7">Pedido</span></td>
    <td width="35%" bgcolor="#C5D6FC"><span class="Estilo7">Cliente</span></td>
    <td width="14%" bgcolor="#C5D6FC"><span class="Estilo7">Total</span></td>
    <td width="12%" bgcolor="#C5D6FC"><span class="Estilo7">Data</span></td>
    <td width="11%" bgcolor="#C5D6FC"><strong><span class="Estilo8">Vendedor</span></strong></td>
    <td width="17%" bgcolor="#C5D6FC"><span class="Estilo8"><strong>forma de pago </strong></span></td>
  </tr>
  <?
	
			
//	$sql_lista = "SELECT * FROM pedido WHERE DAY(data_car)= '$dia' AND situacao = 'A' ORDER BY data_car ";
	$sql_lista = "SELECT * FROM pedido WHERE  situacao = 'A' ORDER BY id DESC ";

	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
	
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
			$data2 = $reg_lista['data_car'];
			$hora2 = $reg_lista['data_car'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			$id_usuario = $reg_lista['usuario_id'];
			
			if ( $reg_lista['forma_pagamento_id'] != 1){
				$forma = 'CREDITO';
				}
		else {
				$forma = 'CONTADO';
				}
		$sql_usuario = "SELECT * FROM usuario WHERE id_usuario = '$id_usuario' ";
		$rs_usuario = mysql_query($sql_usuario) or die (mysql_error() .'-'.$sql_usuario);
		$reg_usuario = mysql_fetch_array($rs_usuario, MYSQL_ASSOC);
		
		$user = $reg_usuario['nome_user'];
			
			
			?>
  <tr>
    <td width="7%" bgcolor="#CCCCCC"><?=$reg_lista['id']?></td>
    <td width="35%" bgcolor="#CCCCCC"><?=$reg_lista['nome_cli']?></td>
    <td width="14%" bgcolor="#CCCCCC"><?=number_format($reg_lista['total_nota'],2,",",".")?></td>
    <td width="12%" bgcolor="#CCCCCC"><?=$novadata?></td>
    <td width="11%" bgcolor="#CCCCCC"><?=$user?></td>
    <td width="17%" bgcolor="#CCCCCC"><?=$forma?></td>
    <td width="4%" bgcolor="#F6F5F0"><a href="lancar_venda.php?acao=lanca&amp;ide=<?=$reg_lista['id']?>"><img src="images/lupa.gif" width="12" height="14" border="0"/></a></td>
  </tr>
  <?
			}
	echo '<p>Pedidos Efectuados hoy: '.$num_lista.'</p>';
	?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>



<font face="Arial">
<input name="button" type="button" onclick="window.close()"
    value="Cerrar" />
</font>
<hr width="100%" size="14" noshade="noshade" />
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
