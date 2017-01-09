<?
  require_once("verifica_login.php");
  require_once("biblioteca.php");
  include "config.php";
  conexao();
  $cod = $_POST['cod'];
  $qtd = $_POST['qtd'];
  
   if($perfil_id <= 2){
 
?>  

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
body {
color: #006;
background-color: #FFEEEE;
}

.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo2 {
	font-size: 36px;
	font-weight: bold;
}
</style>
<script type="text/javascript" src="/js/funcoes.js"></script>
<script type="text/javascript">
	function setaFoco(){
		acao = '<?=$_GET['acao']?>';
		qtd = '<?=$_POST['qtd']?>';
		
		if(acao == 'cad'){
			document.getElementById('qtd').focus();
			document.getElementById('qtd').select();
		}
		if(qtd.length>0 || acao==''){
			document.getElementById('cod').focus();
			document.getElementById('cod').select();
		}

	}
	
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Acerto de Estqoue -  <? echo $cabecalho; ?></title>
</head>

<body onload='setaFoco()'>

<div align="center">
  <?
	//if ($_GET['acao'] == "cad") {
	
	
	
	$sql2 = "SELECT Estoque,Descricao,Codigo FROM produtos WHERE Codigo = '$cod' ";
    $rs2 = mysql_query($sql2) or die (mysql_error());
	$prod2 = mysql_fetch_array($rs2);
	
//	$sql_update = " UPDATE produtos SET Estoque = ('".$qtd."') WHERE Codigo = 6 ";
	//$exe_per = mysql_query($sql_update, $base) or die (mysql_error().'-'.$sql_update);
	

	//}



?>	


  <span class="Estilo2"><? echo $cabecalho; ?></span></div>
<p>&nbsp;</p>
<table width="100%" border="1">
  <tr>
    <td bgcolor="#FF0000"><div align="center" class="Estilo1">ACERTO RAPIDO DE ESTOQUE </div></td>
  </tr>
</table>
<p><strong>Responsavel pela operacao:</strong> <br /><?=$nome_user?>&nbsp;</p>
<form id="form1" name="form1" method="post" action="acerto_estoque.php?acao=cad">
<input type='hidden' name='campoFoco' id='campoFoco'/>
<p>&nbsp;</p>
<table width="70%" border="1">
  <tr>
    <td width="19%">Codigo:</td>
    <td width="54%">&nbsp;</td>
    </tr>
  <tr>
    <td><label>
 <input type="text" name="cod" id="cod"  value="<?=$_POST['cod']?>" onkeypress="teclaPress(event,this,'form1','acerto_estoque.php?foco=qtd')" />
    </label></td>
    <td><strong><?=$prod2['Descricao']?></strong></td>
    </tr>
  <tr>
    <td>Quantidade:</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><input type="text" size="5" name="qtd" id="qtd" value=""/></td>
    <td><label>
      <input type="submit" name="Submit" value="Enviar" />
    </label></td>
    </tr>
</table>
</form>
<p>
  <?php
	
	$cod = $_POST['cod'];
	$qtd = $_POST['qtd'];
	
	if ($_GET['acao'] == "cad") {
		if (!empty ($qtd)) {
			$sql_update = " UPDATE produtos SET Estoque = ('$qtd'), user = ('$nome_user') WHERE Codigo = '$cod' ";
			$exe_per = mysql_query($sql_update, $base) or die (mysql_error().'-'.$sql_update);
			
			if(mysql_affected_rows() > 0){
				echo 'Alteracao efetuada com exito' ;
			}
			else{
				echo 'Não ha registro com este codigo' ;
			}
		
		}
	}
		
		$sql3 = "SELECT Estoque,Descricao FROM produtos WHERE Codigo = '$cod' ";
        $rs3 = mysql_query($sql3) or die (mysql_error());
	    $prod3 = mysql_fetch_array($rs3);
		
?>


</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="50%" border="1">
  <tr>
    <td width="12%">Qtd:</td>
    <td width="88%">Descricao:</td>
  </tr>
  <tr>
    <td><?=$prod3['Estoque']?></td>
    <td><?=$prod3['Descricao']?></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><font face="Arial">
  <input name="button" type="button" onclick="window.close()"
    value="Cerrar" />
</font></p>
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
