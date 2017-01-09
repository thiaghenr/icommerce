<?
require_once("verifica_login.php");
include "config.php";
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
echo $_SESSION['idu'] = $_GET['idu'] ;
//$nome_user = $_SESSION['nome_user'] ;
$tela = alterar_usu;

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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Alterar Registro de usuario do sistema - <? echo $title ?></title>
<link rel="stylesheet" type="text/css" href="/css/style.css" />
<script>
function navegacao(lugar){
 if(lugar=='voltar'){
  window.location.href='\lista_usu.php';
 }
 else if(lugar=='Nueva'){
  window.location.href='\lista_usu.php';
 }
 else if(lugar=='Curso'){
  window.location.href='http://';
 }
}

</script>

<style type="text/css">
.barra  {  
background: #666 url('/images/barra.jpg') no-repeat center center;	
}
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style1 {
	color: #000000;
	font-weight: bold;
}
.style4 {
	color: #0099FF;
	font-weight: bold;
}
-->
</style>
</head>
<body  onload="document.getElementById('nome_us').focus()">
  <table width="100%" border="0" class="style1" >
    <tr>
      <td height="21" class="barra"  ></td>
  </tr>
</table>
  <table width="100%" border="0">
    <tr>
      <td><div align="center" class="style4">Alterar Registro de Usuario</div></td>
    </tr>
  </table>
  <p><? echo $nome_user ?>&nbsp;</p>
 
<?  
  $sql_lista =  "SELECT * FROM usuario WHERE id_usuario = '".$_SESSION['idu']."' ";
	$exe_lista = mysql_query($sql_lista, $base);
	$reg_lista = mysql_fetch_array($exe_lista, MYSQL_ASSOC);
	
	
?>
 <form action="alterar_usu.php?acao=altera" onSubmit="return false" method="post" id="commentform">
  <input type="hidden" size="35"  name="id_usuario" value="<?=$reg_lista['id_usuario']?>" />
  <table width="41%" border="0">
    <tr>
      <td width="53%"><span class="style1">Identificacao no Sistema:</span></td>
      <td width="47%"><input type="text" size="20" name="nome_us" id="nome_us" value="<?=$reg_lista['nome_user']?>"/></td>
    </tr>
  </table>
  <table width="30%" border="0">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="59%" height="46%" border="0">
  <tr>
    <td height="21"><strong>Login:</strong>
      <input type="text" size="20" name="usuario" value="<?=$reg_lista['usuario']?>" /></td>
    <td><strong>Senha: ************
     
    </strong></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td height="22"><strong>Perfil:
      <input type="text" size="20" name="perfil" value="<?=$reg_lista['perfil_id']?>" />
    </strong></td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td width="57%" height="22"><strong>Nombre</strong></td>
    <td width="34%"><strong>Fecha Catastro</strong></td>
    <td width="9%" >&nbsp;</td>
  </tr>
  <tr>
    <td height="26" >
      <label></label>
    <input type="text" size="50" name="nome" value="<?=$reg_lista['nome']?>" /></td>
    <td ><input type="text" size="15" name="data" value="<?=$reg_lista['data']?>" readonly="readonly" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td height="23"><strong>Direcci&oacute;n</strong></td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr >
    <td height="23"><input type="text" size="50" name="endereco" value="<?=$reg_lista['endereco']?>" /></td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td height="23"><strong>Tel&eacute;fono</strong></td>
    <td><strong>Celular</strong></td>
    <td >&nbsp;</td>
  </tr>
  <tr >
    <td height="23"><input type="text" size="30" name="telefone" value="<?=$reg_lista['telefone']?>"/></td>
    <td><input type="text" size="20" name="celular" value="<?=$reg_lista['celular']?>"/></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td height="21"><strong>RUC</strong></td>
    <td><strong>C&egrave;dula ID </strong></td>
    <td >&nbsp;</td>
  </tr>
  <tr >
    <td height="23"><input type="text" size="30" name="ruc" value="<?=$reg_lista['ruc']?>"/></td>
    <td><input type="text" size="20" name="cedula" value="<?=$reg_lista['cedula']?>" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr >
    <td height="23"><strong>Comissao %:</strong></td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr >
    <td height="23"><input type="text" size="20" name="comissao" value="<?=$reg_lista['comissao']?>"/></td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
</table>
  <table width="382" border="0">
  <tr>
    <td width="249"><strong>E-mail</strong></td>
    <td width="171" > <label></label></td>
  </tr>
  <tr >
    <td><input type="text" size="40" name="email" value="<?=$reg_lista['email']?>"/></td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="102" border="0">
  <tr>
    <td><strong>Observaciones</strong></td>
  </tr>
</table>
<table width="383" border="0">
  <tr>
    <td width="377" >
      <label>
      <textarea name="obs" cols="60" value="<?=$reg_lista['obs']?>" rows="3"></textarea>
      </label>      </td>
  </tr>
</table>
  <label>
  <p>
    <input type="button" name="Submit" onclick="this.form.submit()" value="Atualizar"/>
    <input type="button" value="Voltar" name="LINK12" onclick="navegacao('Nueva')" />     
    <input name="button" type="button" onclick="window.close()" value="Sair" />
  </p>
</form>


<?
	if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "altera") {

	$id_usuario = $_POST['id_usuario'];
	$comissao = $_POST['comissao'];
	$nome_us = $_POST['nome_us'];
	$usuario = $_POST['usuario'];
	$nome = $_POST['nome'];
	$endereco = $_POST['endereco'];
	$cedula = $_POST['cedula'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$ruc = $_POST['ruc'];
	$cedula = $_POST['cedula'];
	$email = $_POST['email'];
	$obs = $_POST['obs'];
	$perfil = $_POST['perfil'];
echo $ide;

	
	if ( $perfil != 0) {
	

		
	$sql_per = "UPDATE usuario SET porcentagem=UCASE('$comissao'), nome_user=UCASE('$nome_us'), usuario=UCASE('$usuario'),  nome=UCASE('$nome'), endereco='$endereco', telefone='$telefone', celular=UCASE('$celular'), ruc=UCASE('$ruc'), cedula=UCASE('$cedula'), email=UCASE('$email'), obs=UCASE('$obs'), perfil_id=('$perfil') WHERE id_usuario = '".$id_usuario."' ";
	$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	
	echo $_SESSION['idu'] ;
	echo 'Alteração efetuada com sucesso';
	echo $_SESSION['idu'] ;
	echo $endereco;


   echo "<script language='javaScript'>window.location.href='lista_usu.php'</script>";

}
		

		}
	
else {
echo "Entre com um Perfil para o usuario";
}	
}

//echo $_SESSION['idu'] ;
?>
</body>
</html>
