<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();
$mes= date("m");
$nom = $_POST['nom'];
$ped = $_POST['ped'];
$tela = lista_usu;
/*
	$sql_tela = "SELECT * FROM telas WHERE tela = '$tela' ";
	$exe_tela = mysql_query($sql_tela);
	$reg_tela = mysql_fetch_array($exe_tela);
	
	$perfil_tela = $reg_tela['perfil_tela'];
	
	if ($perfil_tela < $perfil_id) {
	echo "Acesso nao Autorizado";
	exit;
	}
*/
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/clearbox.css" rel="stylesheet" type="text/css" />
<script src="js/clearbox.js" type="text/javascript"></script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lista de Usuarios - <? echo $title ?></title>
<style type="text/css">
body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #f2f1e2;
border-width:2px;
border-style:solid;
border-color:#a2bfe9;
}
.Estilo1 {color: #CCCCCC}
.Estilo4 {color: #000000; font-weight: bold; }
.Estilo5 {font-weight: bold}
.Estilo6 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo47 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Estilo51 {font-size: 14px; font-family: Geneva, Arial, Helvetica, sans-serif; color: #666666; }
.Estilo54 {font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 14px; }


</style>
</head>

<body">
<table width="100%" border="0">
  <tr>
    <td bgcolor="#OEEAEO"><div align="center" class="Estilo1">
      <p class="Estilo6">USUARIOS </p>
    </div></td>
  </tr>
</table>
<pre><strong></strong></pre>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td width="8%" bgcolor="#OEEAEO"><span class="Estilo6">Codigo</span></td>
    <td width="36%" bgcolor="#OEEAEO"><span class="Estilo6">Nome</span></td>
    <td width="26%" bgcolor="#OEEAEO"><div align="right" class="Estilo6">
      <div align="left">Identificacao</div>
    </div></td>
    <td width="19%" bgcolor="#OEEAEO"><div align="right" class="Estilo6">
      <div align="left">Login</div>
    </div></td>
  </tr>
  <?
	
		
	
	$sql_lista =  "SELECT * FROM usuario ORDER BY id_usuario asc ";
	$exe_lista = mysql_query($sql_lista, $base);
	$num_lista = mysql_num_rows($exe_lista);
			$i=0;
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
		if ($i%2==0) 
				$cor = "#FFFFFF";
			else 
				$cor = "#e5f1f4";	
		
			?>
  <tr bgcolor="<? echo $cor?>"> 
    <td width="8%" height="21"><span class="Estilo51">
      <?=$reg_lista['id_usuario']?>
    </span></td>
    <td width="36%" ><span class="Estilo51">
      <?=$reg_lista['nome']?>
    </span></td>
    <td width="26%" ><div align="right" class="Estilo51">
      <div align="left">
        <?=$reg_lista['nome_user']?>
        </div>
    </div></td>
    <td width="19%" ><div align="right" class="Estilo51">
      <div align="left">
        <?=$reg_lista['usuario']?>
        </div>
    </div></td>
    <td width="11%" ><div align="center"><a href="alterar_usu.php?idu=<?=$reg_lista['id_usuario']?>" class="Estilo47"><img src="images/alterar.png" width="19" height="19" border="0"/></a></div></td>
  </tr>
  <?
  $i++;
			}

	?>
</table>
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()"
    value="Cerrar" />
</font></p>
<p>&nbsp;</p>
</body>
</html>
