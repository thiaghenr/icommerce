<?php
require_once("verifica_login.php");
include "config.php";
conexao();
require_once("biblioteca.php");

$tela = caixa;

	$sql_tela = "SELECT * FROM telas WHERE tela = '$tela' ";
	$exe_tela = mysql_query($sql_tela);
	$reg_tela = mysql_fetch_array($exe_tela);
	
	$perfil_tela = $reg_tela['perfil_tela'];
	
	if ($perfil_tela < $perfil_id) {
	echo "Acesso nao Autorizado";
	exit;
	}
$sql = "SELECT * FROM caixa_balcao WHERE usuario_id = '".$id_usuario."' AND st_caixa = 'a'";
		$rs = mysql_query($sql) or die (mysql_error() .' '.$sql);
		$num_rows = mysql_num_rows($rs);
		if($num_rows){
			$msg = "Caixa ja esta Aberto. ";
			
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fluxo de Caixa</title>
<style>
html, body {
	background-image:url(images/fading_background_17.png);
	background-repeat: repeat-x;
	margin: 0;			/* Remove body margin/padding */
	padding: 0;
	overflow: auto;	/* Remove scroll bars on browser window */	
	font: 12px "Lucida Grande", "Lucida Sans Unicode", Tahoma, Verdana;
}
</style>
<!-- In head section we should include the style sheet for the grid -->
<link rel="stylesheet" type="text/css" media="screen" href="themes/sand/grid.css" />

<!-- Of course we should load the jquery library -->
<script src="js/jquery.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/themes/lighting.css" />
<!-- and at end the jqGrid Java Script file -->

<script src="js/jquery.jqGrid.js" type="text/javascript"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/funcoess.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/funcao.js"></script>
<script type="text/javascript" src="/js/jquery/mascara/jquery.maskedinput-1.1.4.js"></script>

<script type="text/javascript">
function controle_caixa(op){
		jQuery("#op").val(op);
		document.getElementById('frm_caixa').submit();
	}
function submitForm(form) {
        /*   
        usa método request() da classe Form da prototype, que serializa os campos   
        do formulário e submete (por POST como default) para a action especificada no form   
        */   
        form.request({   
          onComplete: function(transport){   
              /*   
            se o retorno for diferente de -1, entende-se que não houve problemas, então apaga-se   
            os campos do formulário usando o método reset() da classe Form   
            */		
			//lista(s);    
            if(transport.responseText!=-1)   
                form.reset();   
            }    
        });   
        return false;
  
    }   


function onkeypress (e){
  var keynum;
  if(window.event) // IE
    keynum = window.event.keyCode;
  else if(e.keyCode) // Netscape/Firefox/Opera
    keynum = e.keyCode;
  if(keynum >47 && keynum < 58 || keynum >64 && keynum < 91 || keynum >95 && keynum < 106 ){
				document.getElementById("caixa").focus(); alert(keynum);}
}
jQuery(document).ready(function() {
	jQuery("#data_ini").mask("99/99/9999"); // onde #date é o id do campo
	jQuery("#data_fim").mask("99/99/9999"); // onde #date é o id do campo

});	

function lancamentos(id){
var url = 'php/lista_lancamentos_caixa.php';
var pars = 'id=' + id; 
var myAjax = new Ajax.Updater(
'alvo',
url,
{
method: 'get',
parameters: pars
});
}


jQuery(document).ready(function(){


jQuery("#list9").jqGrid({
	scroll: true,
    // the url parameter tells from where to get the data from server
    // adding ?nd='+new Date().getTime() prevent IE caching
    url:'php/select_caixa.php?caixa=<?=$_POST['caixa']?>&usu=<?=$_POST['usu']?>&data_ini=<?=$_POST['data_ini']?>&data_fim=<?=$_POST['data_fim']?>',
    // datatype parameter defines the format of data returned from the server
    // in this case we use a JSON data
    datatype: "json",
    // colNames parameter is a array in which we describe the names
    // in the columns. This is the text that apper in the head of the grid.
    colNames:['Caixa','DT Abertura', 'DT Fechamento','Valor Abertura','Valor Fechamento','Valor Transferido','Status', 'Usuario'],
    // colModel array describes the model of the column.
    // name is the name of the column,
    // index is the name passed to the server to sort data
    // note that we can pass here nubers too.
    // width is the width of the column
    // align is the align of the column (default is left)
    // sortable defines if this column can be sorted (default true)
    colModel:[
        {name:'Caixa',index:'id', hidden:false, width:60},
        {name:'DT Abertura',index:'dt_abertura', sorttype:"date", width:100},
    	{name:'DT Fechamento',index:'dt_fechamento', sorttype:"date", width:100},
        {name:'Valor Abertura',index:'vl_abertura', sorttype:"float", width:100, align:"right"},
        {name:'Valor Fechamento',index:'vl_fechamento', width:120, align:"right"},
		{name:'Valor Transferido',index:'vl_transferido_fin', width:120, align:"right"},		
        {name:'Status',index:'st_caixa', width:100,align:"center"},		
        {name:'Usuario',index:'usuario_id', width:165, sortable:false}
    ],
    pager: jQuery('#pager9'),
    rowNum:10,
    rowList:[20,30,40],
    imgpath: 'themes/sand/images',
    sortname: 'id',
    viewrecords: 'true',
    sortorder: "desc",
	cellEdit: false,
    caption: "Caixa",
	ondblClickRow : function(rowid) {
			//alert(rowid); 
			lancamentos(rowid);
     }
	}); 
	
jQuery("#m1").click( function() {
  var s;
  s = jQuery("#list9").getGridParam('selarrrow');
   //alert(s);
    lista(s);
    }); 
jQuery("#m1s").click( function() { 
jQuery("#list9").setSelection("13");
 });
  
});
</script>
<style type="text/css">
<!--
-->


	width:90px;
	float:right;
	padding-left:80px;
	text-align: right;
		}
#the-table { border:1px solid #bbb;border-collapse:collapse; }
#the-table td,#the-table th { border:1px solid #ccc;border-collapse:collapse;padding:3px; }
.style17 {color: #CCFF00; font-weight: bold; }
.style20 {color: #666666}
</style>
</head>
<body>
<?php
	if($acao == "trf"){	
		

}
?>
<div align="center">
  <table width="100%" border="0" bordercolor="#FFFFFF">
    <tr>
      <td bgcolor="#B6CEFB"><div align="center"><strong><font color="#000000">Fluxo de Caixa</font></strong></div></td>
    </tr>
  </table>
  <p align="center"><? echo $msg?></p>
</div>
<form id="frm_caixa" name="frm_caixa" method="post" action="caixa_controller.php">
  <p>
    <input type='hidden' name='op' id='op'/>
  </p>
  <table width="100%" border="0">
  <tr>
    <td width="25%" colspan="2" bgcolor="#C5D6FC"><strong><font color="#000000">Usuario logado:</font></strong></td>
    <td colspan="2" bgcolor="#C5D6FC"><strong><font color="#000000">Caixa</font></strong></td>
  </tr>
  <tr>
  	<td colspan="2"><strong>Usuario: </strong>
  	  <?=$nome_user?></td>
    <td colspan="2">
		<? if($num_rows > 0){?>
			<input type="button" name="button" value="Encerrar" onclick="controle_caixa('f')"/>
			<span class="style20">Obs: Transferir Saldo Antes de Encerrar.</span>		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#0000FF">&nbsp;<a href="caixa_transf.php"><font color="#0033CC">Transferir Saldo</font></a></font>
		<? }else{ ?>
			<input type="button" name="abrir" value="Abrir" onclick="controle_caixa('a')"/>
	  <? }?>	</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="64%"></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#C5D6FC"><strong><font color="#000000">Filtros Pesquisa </font></strong></td>
    <td colspan="2" bgcolor="#C5D6FC">&nbsp;</td>
  </tr>
  
	
  <tr><td colspan="2"></tr>
</table>
</form>
<form name="envia" action="extornar_lanc_caixa.php?id=<?=$_POST['lanc']?>" target="popup" onsubmit="window.open('','popup','width=600,height=400')"   method="get">
  <strong>Extornar Lancamento :</strong><br> Lancamento. N: &nbsp;&nbsp;
		<input name="lanc" id="lanc" type="text" size="3" /></form>

<form id="form1" name="form1" method="post" action="caixa.php">
<table width="70%" border="0">
  <tr>
    <td width="35%"><span class="style17">Caixa N. </span></td>
    <td width="29%"><span class="style17">Usuario</span></td>
    <td width="19%"><span class="style17">Data Inicial </span></td>
    <td width="12%"><span class="style17">Data Final </span></td>
    <td width="12%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text" id="caixa" name="caixa" /></td>
    <td><label>
      <input type="text" name="usu" id="usu" />
    </label></td>
    <td><label>
      <input type="text" name="data_ini" id="data_ini" value="<?=$_POST['data_ini']?>" size="10" />
    </label></td>
    <td><label>
      <input type="text" name="data_fim" id="data_fim" value="<?=$_POST['data_fim']?>" size="10" />
    </label></td>
    <td><input type="submit" name="Submit" onclick="atualizar()" value="Buscar" /></td>
  </tr>
</table>
</form>

<!-- the grid definition in html is a table tag with class 'scroll' -->
<table id="list9" class="scroll" cellpadding="0" cellspacing="0" ></table>
<div id="pager9" class="scroll" style="text-align:center; "></div>
<div id="alvo" style="width:929px;"></div>
<div id="caixa" style="width:929px;"></div>

</body>
</html>