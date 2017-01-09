<?
  include "config.php";
  conexao();
  require_once("verifica_login.php");
  $data= date("d/m/Y"); // captura a data
  $hora= date("H:i:s"); //captura a hora
  $nome_user = $_SESSION['nome_user'];
  
  if($perfil_id <= 2){
  
?>  


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo $cabecalho; ?></title>
<style type="text/css">
body {
color: #006;
padding:3px 0px 3px 8px;
background-color: #f2f1e2;
border-width:2px;
border-style:solid;
border-color:#a2bfe9;
}


</style>

</head>

<body onload="document.getElementById('ref').focus()" >
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><table width="100%" border="0">
  <tr>
    <td bgcolor="#FF0000" colspan="2">
        <div align="center"><span class="Estilo2"><strong>Alterar Producto </strong></span></div>
    </td>
  </tr>
  <tr>
    <td width="27%">
      <fieldset>
        <legend>Busca de Producto </legend>
        <table>
            <tr>
                <td width="75">Codigo:</td>
                <td width="299"><form id="form1" name="form1" method="post" action="pesquisa_prod_edit.php">
                  <input type="text" id="ref"  name="ref" />
                </form>
                </td>
            </tr>
            <tr>
                <td>Descripcion:</td>
                <td><form id="form2" name="form2" method="post" action="pesquisa_prod_edit.php">
                  <input type="text" size="30" name="desc" />
                </form>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
      </fieldset>
    </td>
    
  </tr>
</table> </p>
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

<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
