<?
require_once("verifica_login.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$estado = $_GET['estado'];
if (empty ($estado)){
$abre = "none";
}
else {
$abre = $_GET['show'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-numeric.js"></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Cadastro de grupos - <? echo $title ?></title>
	<style type="text/css">
	<!--
	.Estilo1 {	color: #FFFFFF;
		font-family: Georgia, "Times New Roman", Times, serif;
		font-size: 12px;
		font-weight: bold;
	}
	.Estilo14 {	font-size: 36px;
		font-weight: bold;
	}
	.Estilo15 {	color: #FFFFFF;
		font-weight: bold;
	}
	.Estilo4 {font-size: 12px}
	-->
	body {
	color: #006;
	padding:3px 0px 3px 8px;
	background-color: #f2f1e2;
	border-width:2px;
	border-style:solid;
	border-color:#a2bfe9;
	}
	.style1 {
	font-size: 12px;
	font-weight: bold;
}
    .Estilo21 {font-size: 12px}
    </style>
	<script type='text/javascript'>
		function setaFoco(){
			document.getElementById('nom_marca').focus()
		}
		
		function deletar(id){
			if(confirm("Tem certeza que deseja excluir o registro?")){
				window.location = "cadastro_marcas.php?acao=del&id	="+id;
			}
		}
	</script>
</head>

<body onload="setaFoco()">
<p align="center" class="Estilo14"><? echo $cabecalho ?></p>
<table width="80%" border="0">
  <tr>
    <td bgcolor="#FF0000"><div align="center" class="Estilo15">Cadastro Marcas</div></td>
  </tr>
</table>
<?
	if (isset ($_GET['acao'])) {
		if ($_GET['acao'] == "insere") {
		
		$nom_marca = $_POST['nom_marca'];
		
		$re = mysql_query("select count(*) as total from marcas where nom_marca = '$nom_marca'");
		$total = mysql_result($re, 0, "total");
		if ($total == 0) {	
				
			$sql_per = "INSERT INTO marcas (nom_marca,data) VALUES(UCASE('$nom_marca'), NOW() )";
			$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
			
		}
		else{
			echo "<strong>marca ja cadastrada</p>";
			echo " </p>\n";
			echo " </p>\n";
			echo " <a href=cadastro_marcas.php>Voltar</a>";
			exit;
		}
		
}		
	}
		if ($_GET['acao'] == "del") {
		if (isset($_GET['id'])) {
			if ($_GET['id']) {
				$id_marca = $_GET['id'];
				
				$sql_verifica = "SELECT COUNT(*) AS n_prod FROM produtos WHERE marca = '".$id_marca."'"; 
				$exe_verifica = mysql_query($sql_verifica, $base) or die (mysql_error());			
				$reg_verifica = mysql_fetch_array($exe_verifica, MYSQL_ASSOC);
				
				if ($reg_verifica['n_prod'] == 0) {	
					$sql_del = "DELETE FROM marcas WHERE id = '".$id_marca."'"; 
					$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
				}
				else {
					echo '<strong>Operacion no permitida, ha productos cadastrados con esta marca</strong>' ;
				}
			}
		}	
	}		
?>
<form id="acesso" name="acesso" action="cadastro_marcas.php?acao=insere" onSubmit="return false" method="post">
<table width="80%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td width="43%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
  </tr>
  <tr>
    <td width="26%" bgcolor="#D4D0C8"><strong>Marca:</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="24"> 
      <input type="text" name="nom_marca" id="nom_marca"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>
  <input type="button" name="Submit" onClick="this.form.submit()" value="Cadastrar"/>
  
<td width="25%"><a href="cadastro_marcas.php?acao=add&id=<?=$reg_lista['referencia']?>"></a></p>
  <table border="0" width="45%">
<tr>
			  <td width="48%" bgcolor="#D4D0C8"><strong>MARCAS:</strong></td>
        <td width="52%" bgcolor="#D4D0C8"><strong>Cadastrado en:<strong></strong></strong></td>
      </tr>
</table>
<div id="atualiza" style="overflow-x: scroll; height:250px; overflow:auto; overflow-y: scroll; width:500px">
  <table border="0" width="99%">
    
            <?

			$sql_lista = "SELECT * FROM marcas"; 
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
              <td width="42%" bgcolor="#FFCCFF"><?=$reg_lista['nom_marca']?></td>
              <td width="45%" bgcolor="#FFCCFF"><?=$novadata?></td>
		     <td width="6%" bgcolor="#F2F1E2"><a href="#" onclick="deletar('<?=$reg_lista['id']?>')" /><img src="images/delete.gif" width="12" border="0"height="14" />			              
		     <td width="7%" bgcolor="#F2F1E2"><a href="cadastro_marcas.php?acao=descontar&id=<?=$reg_lista['id']?>&estado=show"><img src="images/edit.png" alt="Alterar" width="16" height="17" border="0"  onclick="$('#m_div').show('slow')"  /></a>			 </tr>
			<?
			}
	//echo '<p>Cantidad de Marcas Cadastrados: '.$num_lista.'</p>';
	?>
</table>
</div>
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()" value="Cerrar"/>
</font></p>
</form>

<div id="m_div" style="display:<?=$abre?> ">
  <?php
//$clis = $_POST['cli'];
//$ide = $_GET['id'];

		if ($_GET['acao'] == "desconto") {
		//if (isset($_GET['ide'])) {
			if ($_GET['ide']) {
			$ides = $_GET['ide'];
			$marca = $_POST['nom_marca'];
		
		$sql_desconto = "UPDATE marcas SET nom_marca = UCASE('$marca') WHERE id = '$ides' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());	
		
		echo "<script language='javaScript'>window.location.href='cadastro_marcas.php?cli=".$_SESSION['cli']."'</script>";
					
	//	}
	}
}
?>
  <?php
  		if ($_GET['acao'] == "descontar") {
		$id = $_GET['id'];
  		
		$sql_desconto = "SELECT * FROM marcas where id = '$id' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());
		$reg_desconto = mysql_fetch_array($exe_desconto, MYSQL_ASSOC); 
			
			$id_marca = $reg_desconto['id_marca'];
			$marca = $reg_desconto['nom_marca'];
			
			
			
?>
  <table width="41%" border="0">
    <tr>
      <td width="37%" height="21" bgcolor="#CCCCCC" class="calendar_inline">MARCA</td>
    </tr>
    <tr>
      <td height="18" bgcolor="#FFFFFF" class="calendar_inline"><span class="Estilo4">
        <?=$marca?>
      </span></td>
    </tr>
  </table>
  <?
}
?>
  <form action="cadastro_marcas.php?acao=desconto&amp;ide=<?=$id?>" method="post">
    <table width="41%" border="0">
      <tr>
        <td width="18%"  bgcolor="#0EEAE0" class="calendar_inline"><strong>MARCA: </strong></td>
        <td width="82%" class="calendar_inline"><input type="text" id="nom_marca" name="nom_marca" value="<?=$marca?>"  /></td>
      </tr>
    </table>
    <p class="calendar_inline">
      <input type="submit" name="Submit2" value="Alterar" />
    </p>
  </form>
  </p>
</div>
</body>
</html>
