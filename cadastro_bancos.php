<?
require_once("verifica_login.php");
include "config.php";
conexao();
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
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Cadastro de Bancos - <? echo $cabecalho; ?></title>
    
<link rel="stylesheet" href="/js/jquery/calendario/calendario.css"/>
<script type="text/javascript" src="/js/jquery/jquery/jquery.js"></script>
<script type="text/javascript" src="/js/jquery/calendario/jquery-calendar.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-numeric.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery-floatnumber.js"></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" /> 
<link href="css/clearbox.css" rel="stylesheet" type="text/css" />
<script src="js/clearbox.js" type="text/javascript"></script>
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
	.style3 {	color: #333333;
	font-weight: bold;
}
    .Estilo21 {font-size: 12px}
.Estilo6 {color: #FFFFFF}

body {
	font: normal 11px auto "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	color: #4f6b72;
	background: #E6EAE9;
}

a {
	color: #c75f3e;
}

#mytable {
	width: 700px;
	padding: 0;
	margin: 0;
}

caption {
	padding: 0 0 5px 0;
	width: 700px;	 
	font: italic 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	text-align: right;
}

th {
	font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	color: #4f6b72;
	border-right: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	border-top: 1px solid #C1DAD7;
	letter-spacing: 2px;
	text-transform: uppercase;
	text-align: left;
	padding: 6px 6px 6px 12px;
	
}

th.nobg {
	border-top: 0;
	border-left: 0;
	border-right: 1px solid #C1DAD7;
	background: none;
}

td {
	border-right: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	background: #fff;
	padding: 6px 6px 6px 12px;
	color: #4f6b72;
}


td.alt {
	background: #FFFF99;
	color: #797268;
}

td.espc {
	background: #FFFF99;
	color: #797268;
	line-height: 2%;
}

td.spece {
	background: #B1C3D9;
	color: #797268;
	
}

td.lina{
	background: #fff;
	color: #797268;
	line-height: 5pt;
	}

th.spec {
	border-left: 1px solid #C1DAD7;
	border-top: 0;
	background: #fff ;
	font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	line-height: 2%;
}

th.specalt {
	border-left: 1px solid #C1DAD7;
	border-top: 0;
	background: #f5fafa ;
	font: bold 10px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	color: #797268;
	line-height:  5%;
}
.Estilo17 {font-size: 9px}
.style3 {
	color: #333333;
	font-weight: bold;
}
    </style>
	<script type="text/javascript">
		function deletar(id_banco){
			if(confirm("Tem certeza que deseja excluir o registro?")){
				window.location = "cadastro_bancos.php?acao=del&id_banco="+id_banco;
			}
		}	
	</script>
</head>

<body  onload="document.getElementById('codigo_banco').focus()">
<table width="100%" border="0">
  <tr>
    <td height="26" bgcolor="#a2bfe9"><div align="center" class="calendar_today"><strong>Cadastro de Bancos </strong></div></td>
  </tr>
</table>
<form action="cadastro_bancos.php?acao=insere" onSubmit="return false" method="POST">
<?


	if (isset ($_GET['acao'])) {
		if ($_GET['acao'] == "insere") {
			$codigo_banco = $_POST['codigo_banco'];
			$nome_banco = $_POST['nome_banco'];
			
			echo $codigo_banco;
			echo $nome_banco;
						
			$re = mysql_query("select count(*) as total from banco where codigo_banco = '$codigo_banco'");
			$total = mysql_result($re, 0, "total");
			
			if ($total == 0) {
				$sql_per = "INSERT INTO banco (codigo_banco,nome_banco) VALUES( UCASE('$codigo_banco'), UCASE('$nome_banco') )";
				$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
			}
			else{
				echo "<strong>Banco ja cadastrado</p>";
				echo " </p>\n";
				echo " </p>\n";
				echo " <a href=cadastro_bancos.php>Voltar</a>";
				exit;
			}
		}
	}
	
		if ($_GET['acao'] == "del") {
		if (isset($_GET['id_banco'])) {
			if ($_GET['id_banco']) {
				$id_banco = $_GET['id_banco'];
						
				$sql_verifica = "SELECT COUNT(*) AS n_prod FROM cheque WHERE id_banco = '".$id_banco."'"; 
				$exe_verifica = mysql_query($sql_verifica, $base) or die (mysql_error());			
				$reg_verifica = mysql_fetch_array($exe_verifica, MYSQL_ASSOC);
				
				if ($reg_verifica['n_prod'] == 0) {	
					$sql_del = "DELETE FROM banco WHERE id_banco = '$id_banco'   "; 
					$exe_del = mysql_query($sql_del, $base) or die (mysql_error());
			
				}
				else {
					echo '<strong>Operacion no permitida, ha cheques cadastrados con banco</strong>' ;
				}
				
		}
	}	
	}		
?>
<table width="29%" border="0">
  <tr>
    <td colspan="3" class="calendar_today style3">Cadastrar Banco:
      <label>
      <label></label>
      &nbsp;&nbsp;
      <label></label></td>
  </tr>
  <tr>
    <td width="14%" height="48" class="calendar_today">Codigo Banco:
      <input type="text" size="20" id="codigo_banco" name="codigo_banco" value="<?=$_POST['codigo_banco']?>" /></td>
    <td width="43%" class="calendar_today">Nome Banco:
      <input type="text" id="nome_banco" name="nome_banco" value='<?=$_POST['nome_banco']?>' /></td>
    <td width="43%" class="calendar_today">&nbsp;</td>
  </tr>
</table>
<p>
  <label>
  <input type="button" name="button" id="button" onClick="this.form.submit()" value="Submit" />
  </label>
<td width="25%"><a href="cadastro_bancos.php?acao=add&id=<?=$reg_lista['referencia']?>"></a></p>
<p>

<table border="0" width="51%">
<tr>
	<td width="30%" bgcolor="#ECE9D8" class="calendar_inline"><strong>Codigo:</strong></td>
    <td width="70%" bgcolor="#ECE9D8" class="calendar_inline"><strong>Banco:<strong></strong></strong></td>
</tr>
</table>
<div id="atualiza" style="overflow-x: scroll; height:250px; overflow:auto; overflow-y: scroll; width:500px">
<table border="0" width="96%">
			
<?
	
			
	$sql_lista = "SELECT * FROM banco"; 
	$exe_lista = mysql_query($sql_lista, $base)or die (mysql_error());
	//$num_lista = mysql_num_rows($exe_lista);
	
			while ($reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC)) {
		
			$data2 = $reg_lista['data'];
			$hora2 = $reg_lista['data'];
			//Formatando data e hora para formatos Brasileiros.
			$novadata = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);
			$novahora = substr($hora2,11,2) . "h " .substr($hora2,14,2) . " min";
			
			?>
<tr> 								
              <td width="30%" bgcolor="#FFCCFF" class="calendar_inline"><?=$reg_lista['codigo_banco']?></td>
              <td width="55%" bgcolor="#FFCCFF" class="calendar_inline"><?=$reg_lista['nome_banco']?></td>
	    <td width="7%" bgcolor="#F2F1E2" class="calendar_inline"><a href="#" onclick="deletar('<?=$reg_lista['id_banco']?>')" /><img src="images/delete.gif" width="12" border="0"height="14" />            
	    <td width="8%" bgcolor="#F2F1E2" class="calendar_inline"><a href="cadastro_bancos.php?acao=descontar&id=<?=$reg_lista['id_banco']?>&estado=show"><img src="images/edit.png" alt="Alterar" width="16" height="17" border="0"  onclick="$('#m_div').show('slow')"  /></a>      </tr>
			
			<?
			}
	//echo '<p>Cantidad de Bancos Cadastrados: '.$num_lista.'</p>';
	?>
</table>
</div>
</form>
<div id="m_div" style="display:<?=$abre?> ">
  <?php
//$clis = $_POST['cli'];
//$ide = $_GET['id'];

		if ($_GET['acao'] == "desconto") {
		//if (isset($_GET['ide'])) {
			if ($_GET['ide']) {
			$ides = $_GET['ide'];
			$nome = $_POST['nome'];
			$codigo = $_POST['codigo'];
		
		$sql_desconto = "UPDATE banco SET codigo_banco = UCASE('$codigo'), nome_banco = UCASE('$nome') WHERE id_banco = '$ides' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());	
		
		echo "<script language='javaScript'>window.location.href='cadastro_bancos.php?cli=".$_SESSION['cli']."'</script>";
					
	//	}
	}
}
?>
  <?php
  		if ($_GET['acao'] == "descontar") {
		$id = $_GET['id'];
  		
		$sql_desconto = "SELECT * FROM banco where id_banco = '$id' ";
		$exe_desconto = mysql_query($sql_desconto) or die (mysql_error());
		$reg_desconto = mysql_fetch_array($exe_desconto, MYSQL_ASSOC); 
			
			$id_banco = $reg_desconto['id_banco'];
			$codigo = $reg_desconto['codigo_banco'];
			$nome = $reg_desconto['nome_banco'];
			
			
?>
  <table width="41%" border="0">
    <tr>
      <td width="37%" height="21" bgcolor="#CCCCCC" class="calendar_inline"><span class="Estilo4 Estilo21">CODIGO DO BANCO</span></td>
      <td width="63%" bgcolor="#CCCCCC" class="calendar_inline"><span class="Estilo4 Estilo21">NOME DO BANCO</span></td>
    </tr>
    <tr>
      <td height="18" bgcolor="#FFFFFF" class="calendar_inline"><span class="Estilo4">
        <?=$codigo?>
      </span></td>
      <td bgcolor="#FFFFFF" class="calendar_inline"><span class="Estilo4">
        <?=$nome?>
      </span></td>
    </tr>
  </table>
  <?
}
?>
  <form action="cadastro_bancos.php?acao=desconto&amp;ide=<?=$id_banco?>" method="post">
    <table width="41%" border="0">
      
      <tr>
        <td  bgcolor="#0EEAE0" class="calendar_inline"><strong>CODIGO:</strong></td>
        <td class="calendar_inline"><input type="text" id="codigo" name="codigo" value="<?=$codigo?>"  /></td>
      </tr>
      <tr>
        <td width="18%"  bgcolor="#0EEAE0" class="calendar_inline"><strong>NOME:</strong></td>
        <td width="82%" class="calendar_inline"><span class="Estilo4">
          <label>
            <input type="text" size="40" id="nome" name="nome" value="<?=$nome?>"  />
          </label>
        </span></td>
      </tr>
    </table>
    <p class="calendar_inline">&nbsp;</p>
    <p class="calendar_inline">&nbsp;</p>
    <p>
      <input type="submit" name="Submit" value="Alterar" />
    </p>
  </form>
  </p>
</div>
<p>&nbsp;</p>
</body>
</html>
