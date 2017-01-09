<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$mes= date("m");

 if($perfil_id <= 2){

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Definir Cambio</title>
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
.Estilo1 {color: #FFFFFF;
	font-weight: bold;
}
.Estilo4 {font-size: 12px}
.Estilo5 {font-size: 36px;
	font-weight: bold;
}
.Estilo6 {color: #FFFFFF}
-->
</style>

</head>

<body>


<p>&nbsp;</p>
<p>&nbsp;</p>

<table width="100%" border="0">
  <tr>
    <td><div align="center"><strong>Entrar com novo cambio </strong></div></td>
  </tr>
</table>

<p>&nbsp;</p>
<table width="50%" border="0">
  <tr><form id="guarani" name="guarani" method="post" action="definir_cambio.php?acao=cadastra_guarani">
    <td>Guarani:</td>
    <td width="17%"><input type="text" name="guarani" /></td>
    <td width="68%"><input type="button" name="guarani" onclick="this.form.submit()" value="Gravar" /></td></form>
  </tr>
  <tr><form id="dolar" name="dolar" method="post" action="definir_cambio.php?acao=cadastra_dolar">
    <td>Dolar:</td>
    <td><input type="text" name="dolar" /></td>
    <td><input type="button" name="dolar" onclick="this.form.submit()" value="Gravar" /></td></form>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?

	if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "cadastra_guarani") {
	   
    $guarani = $_POST['guarani'];
	
	$sql_per = "INSERT INTO cambio_moeda (vl_cambio,moeda_id,data) VALUES('$guarani', '3', NOW())";
	$exe_per = mysql_query($sql_per) or die (mysql_error().'-'.$sql_per);
	
	$codigo = mysql_insert_id();
	
	}
}

	if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "cadastra_dolar") {
	   
    $dolar = $_POST['dolar'];
	
	$sql_per = "INSERT INTO cambio_moeda (vl_cambio,moeda_id,data) VALUES('$dolar', '1', NOW() )";
	$exe_per = mysql_query($sql_per) or die (mysql_error().'-'.$sql_per);
	
	$codigo = mysql_insert_id();
	
	}
}
?>
<p>&nbsp;</p>
<table width="47%" border="0">
  <tr>
    <td bgcolor="#FF0000" colspan="2"><div align="center"><span class="Estilo2"><strong>Cambio atual </strong></span></div></td>
  </tr>
  <tr>
  
    <td width="15%" height="107"><fieldset>
      <legend>Cambio Monedas </legend>
	    <?php

		
		$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 3 AND moeda.id = 3 GROUP BY cm.id DESC limit 0,1 ";
		$exe_cambio = mysql_query($sql_cambio) or die (mysql_error()); 
	  while  ($reg_cambio = mysql_fetch_array($exe_cambio, MYSQL_ASSOC)) {
	  
	  $sql_cambiod = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 1 AND moeda.id = 1 GROUP BY cm.id DESC limit 0,1 ";
		$exe_cambiod = mysql_query($sql_cambiod) or die (mysql_error()); 
	  while  ($reg_cambiod = mysql_fetch_array($exe_cambiod, MYSQL_ASSOC)) {
		
		

?>

		<table width="100%">
		  <tr>
          <td width="14">&nbsp;</td>
          <td width="362"><table width="58%" border="0">
              <tr>
                <td width="21%"><div align="right">
                  <?=$reg_cambio['nm_moeda']?>
                </div></td>
                <td width="79%">
                  
                  <div align="right">
                    <input type="text" id="dolar" size="17" readonly="" name="dolar" value="<?=$reg_cambio['vl_cambio']?>"/>
                  </div></td>
              </tr>
            </table>
            <table width="58%" border="0">
              <tr>
                <td width="21%"><div align="right">
                    <?=$reg_cambiod['nm_moeda']?>
                </div></td>
                <td width="79%"><div align="right">
                    <input type="text" id="dolar2" size="17" readonly="" name="dolar2" value="<?=$reg_cambiod['vl_cambio']?>"/>
                </div></td>
              </tr>
            </table>            <p>&nbsp;</p></td>
        </tr>
        </table>
        <p>
          <?

}
}


?>
</p>
        <p><font face="Arial">
          <input name="button" type="button" onclick="window.close()" value="Cerrar" />
        </font> </p>
<?

}
else{

  echo 'Acesso nao autorizado para este usuário !!! ' ;
  
  ?>
  <br />
  <br />
  <input name="button" type="button" onclick="window.close()" value="Cerrar" />
  <?
}
?>
    </body>
</html>
