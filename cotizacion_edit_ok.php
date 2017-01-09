<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><script language="JavaScript" type="text/javascript">
  moveBy (0, -20);
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cotizacion Efectuada con exicto - <? echo $cabecalho; ?></title>
<script language="JavaScript">
<!--
function mmLoadMenus() {
  if (window.mm_menu_1227170409_0) return;
                            window.mm_menu_1227170409_0_1 = new Menu("Pedido",114,18,"",12,"#FFFFFF","#FFFFFF","#FF6600","#000084","left","middle",3,0,1000,-5,7,true,false,true,0,true,true);
    mm_menu_1227170409_0_1.addMenuItem("Efetuar&nbsp;Pedido","location='cotizacion.php'");
    mm_menu_1227170409_0_1.addMenuItem("Pesquizar","location='pesquisa_cotizacion.php'");
     mm_menu_1227170409_0_1.fontWeight="bold";
     mm_menu_1227170409_0_1.hideOnMouseOut=true;
     mm_menu_1227170409_0_1.bgColor='#555555';
     mm_menu_1227170409_0_1.menuBorder=1;
     mm_menu_1227170409_0_1.menuLiteBgColor='#FFFFFF';
     mm_menu_1227170409_0_1.menuBorderBgColor='#777777';
  window.mm_menu_1227170409_0 = new Menu("root",67,18,"",12,"#FFFFFF","#FFFFFF","#FF6600","#000084","left","middle",3,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_1227170409_0.addMenuItem(mm_menu_1227170409_0_1);
   mm_menu_1227170409_0.fontWeight="bold";
   mm_menu_1227170409_0.hideOnMouseOut=true;
   mm_menu_1227170409_0.childMenuIcon="arrows.gif";
   mm_menu_1227170409_0.bgColor='#555555';
   mm_menu_1227170409_0.menuBorder=1;
   mm_menu_1227170409_0.menuLiteBgColor='#FFFFFF';
   mm_menu_1227170409_0.menuBorderBgColor='#777777';

mm_menu_1227170409_0.writeMenus();
} // mmLoadMenus()
//-->
</script>
<script language="JavaScript" src="mm_menu.js"></script>
<style type="text/css">
<!--
.Estilo13 {
	font-size: 36px;
	font-weight: bold;
}
.Estilo15 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo17 {font-size: small}
-->
</style>


</head>

<body>
<script language="JavaScript1.2">mmLoadMenus();</script>
<p align="center" class="Estilo13"><? echo $cabecalho; ?></p>
<table width="100%" border="0">
  <tr>
    <td height="21" bgcolor="#00FF00"><div align="center" class="Estilo15">COTIZACION DEL PRESUPUESTO </div></td>
  </tr>
</table>
<p>
  <?
	//$ide = $_GET[.session_id().;		
				
			
	$sql_lista = "SELECT ct.*, cl.endereco, cl.telefonecom,abrv FROM cotacao ct, clientes cl WHERE ct.id = ".$_GET['id_cotacao']." AND ct.controle_cli = cl.controle ";

	$exe_lista = mysql_query($sql_lista, $base) or die (mysql_error()." - $sql_lista");
	$num_lista = mysql_num_rows($exe_lista);
	//if ($num_lista > 0) {
		//$total_carrinho = 0;
			$reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC);
			//$total_carrinho += ($reg_lista['prvenda']*$reg_lista['qtd_produto']);
			$ide3 = $reg_lista['controle_cli'];
			// Pegando data e hora.
			$data2 = $reg_lista['data_car'];
			$hora2 = $reg_lista['data_car'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			//Guia para raciocinio: 2007-12-31 14:39:36
			?>
			
			<?
			//$sql_lista2 = "SELECT * FROM clientes WHERE  controle = '$ide3'"    ;
///	$exe_lista2 = mysql_query($sql_lista2, $base);
	//$num_lista2 = mysql_num_rows($exe_lista2);
//	while ($reg_lista2 = mysql_fetch_array($exe_lista2, MYSQL_ASSOC)) {
	
	?>
</p>
<table border="0" width="100%">
   <tr>
     <td width="19%" bgcolor="#FFFFFF"><strong>OR&Ccedil;AMENTO N:</strong></td>
     <td width="40%" bgcolor="#FFFFFF"><?=$reg_lista['id']?></td>
     <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
     <td width="8%" bgcolor="#FFFFFF"><strong>FECHA:</strong></td>
     <td width="4%" bgcolor="#FFFFFF"><?=$novadata ?></td>
     <td width="6%" bgcolor="#FFFFFF"><div align="right">Hora:</div></td>
     <td width="21%" bgcolor="#FFFFFF"><?=$novahora ?></td>
   </tr>
   
   <tr>
     <td bgcolor="#FFFFFF"><strong>CLIENTE:<strong></strong></strong></td>
     <td bgcolor="#FFFFFF"><?=$reg_lista['abrv']?></td>
     <td bgcolor="#FFFFFF">&nbsp;</td>
     <td bgcolor="#FFFFFF">&nbsp;</td>
     <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
   </tr>
   <tr>
     <td width="19%" bgcolor="#FFFFFF">&nbsp;</td>
     <td width="40%" bgcolor="#FFFFFF">&nbsp;</td>
     <td width="2%" bgcolor="#FFFFFF">&nbsp;</td>
     <td width="8%" bgcolor="#FFFFFF">&nbsp;</td>
     <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
   </tr>
</table>
 <table border="1" bordercolor="#000000" style="border-collapse: collapse" width="100%">
            <tr>
              <td width="7%" height="22"><strong>CT.</strong></td>
              <td width="15%"><strong>N.FABRICA<strong></strong></strong></td>
              <td width="51%"><strong>DESCRIPCION DEL PRODUTO <strong></strong></strong></td>
              <td width="14%"><div align="right"><strong>UNITARIO</strong></div></td>
			  <td width="12%"><div align="right"><strong>SUBTOTAL</strong></div></td>
   </tr>
   
			
            <?
	
			
	$sql_list = "SELECT c.*, ic.*  FROM cotacao c, itens_cotacao ic WHERE c.id = '".$reg_lista['id']."' AND ic.id_cotacao = '".$reg_lista['id']."' GROUP BY referencia_prod ASC";
	$exe_list = mysql_query($sql_list)  or die (mysql_error());
	$num_list = mysql_num_rows($exe_list);
	
		//if ($num_lista > 0) {
		$total_carrinho = 0;
			while ($reg_list = mysql_fetch_array($exe_list, MYSQL_ASSOC)) {
			$total_carrinho += ($reg_list['prvenda']*$reg_list['qtd_produto']);
			
			?>
			 <tr>
              <td width="7%">                <span class="Estilo17">
              <?=$reg_list['qtd_produto']?>
              </span> </td>
              <td width="15%">                <span class="Estilo17">
              <?=$reg_list['referencia_prod']?>
              </span> </td>
              <td width="51%">                <span class="Estilo17">
              <?=substr($reg_list['descricao_prod'],0,45)?>
              </span> </td>
              <td width="14%"><div align="right" class="Estilo17">
                <?=guarani($reg_list['prvenda'])?>
              </div></td>
			  <td width="12%"><div align="right" class="Estilo17">
			    <?=guarani($reg_list['prvenda']*$reg_list['qtd_produto'])?>
			  </div></td>
             </tr>
		
			<?
		//}
	}
	
	?>
            <tr>
              <td height="23" colspan="3"><div align="right"></div></td>
              <td height="23"><div align="right"><strong>Total :&nbsp;</strong></div></td>
              <td height="23"><strong><strong>
              <div align="right">
                <?=guarani($total_carrinho)?>
              </div></td>
            
            </tr>
</table>
		  
		  
		  
		  
		  
		  
          <p>&nbsp;</p>
      </table>
</p>
		<p>&nbsp;</p>
	    <!-- O Script Termina aqui -->
        </p>
        </p>
<hr width="100%" size="14" noshade="noshade" />
<p>&nbsp;        </p>
</body>
</html>


</body>

</html>