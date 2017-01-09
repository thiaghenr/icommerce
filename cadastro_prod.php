<?
require_once("verifica_login.php");
include "config.php";
require_once("biblioteca.php");
conexao();

$data= date("Y/m/d"); // captura a data
$hora= date("H:i:s"); //captura a hora
$id_prod = $_GET['id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cadastro de Produtos</title>

<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>
<script type='text/javascript' src='js/dojo.js'></script>
<script type='text/javascript' src='js/funcoes.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/styleb.css" />
<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" />

<script language="javascript">
function getContainer(node) {
    var body = dojo.body();
    while(node && node != body
          && !dojo.hasClass(node, "container")) {
      node = node.parentNode;
    }
    if(dojo.hasClass(node, "container")){
      return node;
    }
    return null;
  }

  dojo.addOnLoad(function() {
    //Do a query for the input nodes
    dojo.query(".container input[type=text]",
      dojo.byId("topLevel"))
    .onfocus(function(evt){
      //Make the background grey when an input gets focus
        dojo.anim(getContainer(evt.target),{backgroundColor: "#ddd"});
      })
    .onblur(function(evt){
      //Make the background white when an input loses focus
        dojo.anim(getContainer(evt.target), {backgroundColor: "#fff"});
      })
    .forEach(function(input){
      //Record the initial value for the input
      input._initialValue = input.value;
    })
    .onkeyup(function(evt){
    //When the user presses a key, check the input
    //value against its initial value. If they are 
    //different, add the class 'changed' to the input.
      var input = evt.target;
      if(input.value == input._initialValue) {
        dojo.removeClass(input, "changed");
      } else {
        dojo.addClass(input, "changed");
      }
    });
  });

</script>


	
<style type="text/css">
<!--
.style3 {color: #FFFFFF}
-->
</style>
</head>

<body onload="document.getElementById('Codigo').focus();">
<div align="center" class="style3">CADASTRO DE PRODUTOS</div>
<form action="cadastro_prod.php?acao=cadastra" method="post" enctype="multipart/form-data" name="acesso" id="commentform" onSubmit="return false">
<table width="100%" border="0">
  <tr>
    <td width="24%"><div id="two">
      <div id="borderbox"><span class="style3">Codigo</span>:</div>
      <div id="borderbox">
        <input name="Codigo" id="Codigo" type="text" value="<?=$_POST['Codigo']?>" onkeypress="getkey(event,this.form.Descricao)" />
      </div>
      <div id="espacov"></div>
      </div></td>
    <td width="24%"><div id="desc">
      <div class="style3" id="borderbox2"><img src="images/paraguay.png" alt="Portugues" width="16" height="16" /> Descricao:</div>
      <div id="borderbox2">
        <input name="Descricao" id="Descricao" value="<?=$_POST['Descricao']?>" onkeypress="getkey(event,this.form.custo)"  type="text" size="43"/>
      </div>
      <div id="espacov2"></div>
      <div id="borderbox2"></div>
    </div></td>
    <td width="23%"><div id="desc2">
      <div id="borderbox3"><span class="style3"> Custo:</span></div>
      <div id="borderbox3">
        <input name="custo" id="custo" value="<?=($_POST['custo'])?>" onkeypress="getkey(event,this.form.marca)" onkeyup="mascaraInteiro(this); Valida('marca');" type="text" />
      </div>
      <div id="espacov3"></div>
      <div id="borderbox3"></div>
    </div></td>
    <td width="29%"><div id="two2">
      <div id="borderbox4"></div>
      <div id="borderbox4"></div>
      <div id="espacov4"></div>
      <div id="borderbox4"><span class="style3">Codigo Original 2:</span></div>
      <div id="borderbox4">
        <input  name="cod_original2" id="cod_original2" value="<?=$_POST['cod_original2']?>" onkeypress="getkey(event,this.form.Codigo_Fabricante)"  type="text" size="25"/>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div class="style3" id="borderbox">
      <div align="left">Marca:</div>
    </div>
      <div id="borderbox6">
        <input name="marca" id="marca" value="<?=$_POST['marca']?>" onkeypress="getkey(event,this.form.grupo)" type="text" />
      </div></td>
    <td width="24%"><div id="borderbox7">
      <div align="left"><span class="style3">Grupo:</span></div>
    </div>
    <input name="grupo" id="grupo" value="<?=$_POST['grupo']?>" onkeypress="getkey(event,this.form.cod_original)" type="text" size="20"/></td>
    <td width="23%"><div id="borderbox8"><span class="style3">Codigo Original :</span>
      <input ame="cod_original" id="cod_original" value="<?=$_POST['cod_original']?>" onkeypress="getkey(event,this.form.cod_original2)"  type="text" size="25"/>
    </div></td>
    <td width="29%">&nbsp;</td>
  </tr>
  <tr>
    <td><div id="borderfab"> <span class="style2">Codigo Fabrica 001:</span>
          <input  name="Codigo_Fabricante" id="Codigo_Fabricante"  value="<?=$_POST['Codigo_Fabricante']?>" onkeypress="getkey(event,this.form.Codigo_Fabricante2)" type="text" size="30"/>
    </div></td>
    <td><div id="borderfab2"> <span class="style2">Codigo Fabrica 002:</span>
          <input  name="Codigo_Fabricante2" id="Codigo_Fabricante2"  value="<?=$_POST['Codigo_Fabricante2']?>" onkeypress="getkey(event,this.form.Codigo_Fabricante3)"  type="text" size="30"/>
    </div></td>
    <td><div id="borderfab3"> <span class="style2">Codigo Fabrica 003:</span>
          <input name="Codigo_Fabricante3" id="Codigo_Fabricante3"  value="<?=$_POST['Codigo_Fabricante3']?>" onkeypress="getkey(event,this.form.margen_a)" type="text" size="30"/>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div id="bordermar"> <span class="style2">% Margen A :</span>
          <input name="margen_a" id="margen_a"  value="<?=$_POST['margen_a']?>" onkeypress="getkey(event,this.form.margen_b)" type="text" size="15" onkeyup="Valida('margen_a')"/>
    </div></td>
    <td><div id="bordermar"><span class="style2">% Margen B :</span>
          <input name="margen_b" id="margen_b"  value="<?=$_POST['margen_b']?>" onkeypress="getkey(event,this.form.margen_c)"  type="text" size="15"onkeyup="Valida('margen_b')"/>
    </div></td>
    <td><div id="bordermar"><span class="style2">% Margen C :</span>
          <input name="margen_c" id="margen_c"  value="<?=$_POST['margen_c']?>" onkeypress="getkey(event,this.form.vla)" type="text" size="15" onkeyup="Valida('margen_c')"/>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div id="bordermar"> <span class="style2">Valor  A : </span>
          <input  name="vla" id="vla"  value="<?=$_POST['vla']?>"  onkeyup="mascaraInteiro(this); Valida('vla');"  onkeypress="getkey(event,this.form.vlb)"  type="text" size="15" />
    </div></td>
    <td><div id="bordermar"><span class="style2">Valor  B :</span>
          <input name="vlb" id="vlb"  value="<?=$_POST['vlb']?>"  onkeyup="mascaraInteiro(this); Valida('vlb');"  onkeypress="getkey(event,this.form.vlc)"  type="text" size="15" />
    </div></td>
    <td><div id="bordermar"><span class="style2">Valor  C :</span>
          <input name="vlc" id="vlc"  value="<?=$_POST['vlc']?>"  onkeyup="mascaraInteiro(this); Valida('vlc');"  onkeypress="getkey(event,this.form.Estoque)" type="text" size="15"/>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div id="bordermar"> <span class="style2">Estoque :</span>
          <input name="Estoque" id="Estoque" value="<?=$_POST['Estoque']?>" onkeypress="getkey(event,this.form.qtd_min)"  type="text" size="15" onkeyup="Valida('Estoque')"/>
    </div></td>
    <td><div id="bordermar"><span class="style2">Qtd.  Min.  :</span>
          <input name="qtd_min"  id="qtd_min" value="<?=$_POST['qtd_min']?>" onkeypress="getkey(event,this.form.pr_min)" type="text" size="15" onkeyup="Valida('qtd_min')"/>
    </div></td>
    <td><div id="bordermar"><span class="style2">Preco min.  :</span>
          <input name="pr_min" id="pr_min" value="<?=($_POST['pr_min'])?>" onkeypress="getkey(event,this.form.embalagem)" onkeydown="Formata(this,10,event,2);"  type="text" size="15" onkeyup="Valida('pr_min')"/>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div id="bordermar"> <span class="style2">Usuario :</span>
          <input readonly="readonly"  value="<?=$nome_user?>"name="nome_user"  type="text" size="15"/>
    </div></td>
    <td><div id="bordermar"><span class="style2">Embalagem  :</span>
          <input name="embalagem" id="embalagem" value="<?=$_POST['embalagem']?>" onkeypress="getkey(event,this.form.local)"  type="text" size="15"/>
    </div></td>
    <td><div id="bordermar"><span class="style2">Locacao  :</span>
          <input name="local" id="local" value="<?=$_POST['local']?>" onkeypress="getkey(event,this.form.iva)" type="text" size="15"/>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div id="bordermar"><span class="style2">% Imposto  :</span>
          <input  name="iva" id="iva" value="<?=$_POST['iva']?>" onkeypress="getkey(event,this.form.Submit)" type="text" size="15" onkeyup="Valida('iva')"/>
    </div></td>
    <td><div id="bordermar2"> <span class="style2">Imagem :</span>
          <label>
          <input type="file" name="foto" value="<?=$_FILES['foto']?>"/>
          </label>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="button" name="Submit" onclick="this.form.submit()" value="Cadastrar"/></td>
    <td><input name="button" type="button" onclick="window.close()" value="Cerrar" />
      <span class="container">
      <?
	if (isset ($_GET['acao'])) {
	if ($_GET['acao'] == "cadastra") {
		$Codigo = $_POST['Codigo'];
	    $Descricao = $_POST['Descricao'];
		$Descricaoes = $_POST['Descricaoes'];
		$part_number = $_POST['part_number'];
		$serial = $_POST['serial'];
		$cod_original = $_POST['cod_original'];
		$Codigo_Fabricante = $_POST['Codigo_Fabricante'];
		$Codigo_Fabricante2 = $_POST['Codigo_Fabricante2'];
		$Codigo_Fabricante3 = $_POST['Codigo_Fabricante3'];
		$pr_mina = str_replace('', '',$_POST['pr_min']);
		$pr_min = str_replace(',', '',$pr_mina);
		$margen_a = $_POST['margen_a'];
		if (empty($_POST['margen_b']) && empty($_POST['margen_c'])) {
		$margen_b = $margen_a;
		$margen_c = $margen_a;}
		else{
		$margen_b = $_POST['margen_b'];
		$margen_c = $_POST['margen_c'];}
		$custoa = str_replace('.', '',$_POST['custo']);
		$custo = str_replace(',', '.',$custoa);
		$valor_a = $_POST['valor_a'];
		$valor_b = $_POST['valor_b'];
		$valor_c = $_POST['valor_c'];
		$Estoque = $_POST['Estoque'];
		$qtd_min = $_POST['qtd_min'];
		$iva = $_POST['iva'];
		$qtd_bloq = $_POST['qtd_bloq'];
		$local = $_POST['local'];
		$embalagem = $_POST['embalagem'];
		$user = $_POST['nome_user'];
		$id = $_POST['id'];
		$cod_original2 = $_POST['cod_original2'];
		$vlaa = str_replace('.', '',$_POST['vla']);
		$vla = str_replace(',', '',$vlaa);
		
		$vlbb = str_replace('.', '',$_POST['vlb']);
		$vlb = str_replace(',', '',$vlbb);
		
		$vlcc = str_replace('.', '',$_POST['vlc']);
		$vlc = str_replace(',', '',$vlcc);
		
		/*INICIO - PEGANDO ID DA MARCA*/
		$marca = $_POST['marca'];
		$sql_marca = "SELECT id FROM marcas WHERE nom_marca = '".$marca."'";
		$rs_marca = mysql_query($sql_marca);
		
		$linha_marca = mysql_fetch_array($rs_marca);
		$id_marca = $linha_marca['id'];
		/*FIM*/
		
		/*INICIO - PEGANDO ID DO GRUPO*/
		$grupo = $_POST['grupo'];
		
		$sql_grupo = "SELECT id FROM grupos WHERE nom_grupo = '".$grupo."' ";
		$rs_grupo = mysql_query($sql_grupo);
		
		$linha_grupo = mysql_fetch_array($rs_grupo);
		$id_grupo = $linha_grupo['id'];
		/*FIM*/
		
		//PEGANDO O VALOR DO CAMBIO
		$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio, nm_moeda FROM cambio_moeda cm, moeda WHERE cm.moeda_id = 3 AND moeda.id = 3 GROUP BY cm.id DESC limit 0,1 ";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
			
		$re = mysql_query("select count(*) as total from produtos where Codigo = '$Codigo'");
		$total = mysql_result($re, 0, "total");
		
		if ($total == 0) {

		if (empty($vla)){
		$percentual_a = $margen_a / 100;
		$valor_a = $custo + ($percentual_a * $custo);
		}
		else{
		$valor_a = $vla;// /  $vl_cambio_guarani;
		//$diferenca = $valor_a - $custo;
		//$margen_aa = $diferenca * 100;
		//$margen_a = $margen_aa / $custo;
		}
		
		if (empty($vlb)){
		$percentual_b = $margen_b / 100;
		$valor_b = $custo + ($percentual_b * $custo);
		}
		else{
		$valor_b = $vlb;// /  $vl_cambio_guarani;
		//$diferenca = $valor_b - $custo;
		//$margen_bb = $diferenca * 100;
		//$margen_b = $margen_bb / $custo;
		}
		if (empty($vlc)){
		$percentual_c = $margen_c / 100;
		$valor_c = $custo + ($percentual_c * $custo);
		}
		else{
		$valor_c = $vlc;// /  $vl_cambio_guarani;
		//$diferenca = $valor_c - $custo;
		//$margen_cc = $diferenca * 100;
		//$margen_c = $margen_cc / $custo;
		}
		
    // verifica se tem imagem sendo cadastrada
    if (trim($_FILES['foto']['tmp_name']) != "") {

        // o arquivo &eacute; gerado com um nome que nunca se repetir&aacute; para evitar que um arquivo existente seja perdido
        // no exemplo, as fotos ficar&atilde;o dentro do diret&oacute;rio "fotos", &eacute; necess&aacute;rio que o mesmo d&ecirc; permiss&atilde;o total de grava&ccedil;&atilde;o
        // para o usu&aacute;rio que roda o Servidor web(nobody, wwwrun s&atilde;o os mais comuns)
        $foto = 'fotos/' . md5(md5($_FILES["name"]) . date("YmdHis")) . strstr(basename($_FILES["foto"]["name"]), '.');

        // arquivo com o local de origem
       $orig = $_FILES["foto"]["tmp_name"];
		
        // copia o arquivo para o destino
        if (!copy($orig, "$foto")) {
            echo "<br><br><center>Problemas no upload do arquivo: " . $_FILES["foto"]["name"] . "...</font><br>";
            $erro = "yes";
            $foto = "";
        } 
    }
}	
		$sql_per = "INSERT INTO produtos (Codigo, Descricao, custo, part_number,  serial, cod_original, Codigo_fabricante, Codigo_fabricante2, Codigo_fabricante3, pr_min, margen_a, margen_b, margen_c, valor_a, valor_b, valor_c, Estoque, qtd_min, iva, qtd_bloq, local, embalagem, user, data, marca, grupo, cod_original2, custo_medio, custo_anterior, imagem) 
		VALUES(UCASE('$Codigo'), UCASE('$Descricao'), UCASE('$custo'), UCASE('$part_number'), UCASE('$serial'), UCASE('$cod_original'), UCASE('$Codigo_Fabricante'), UCASE('$Codigo_Fabricante2'), UCASE('$Codigo_Fabricante3'), '$pr_min', '$margen_a', '$margen_b', '$margen_c', '$valor_a', '$valor_b', '$valor_c', '$Estoque', '$qtd_min', '$iva', '$qtd_bloq', UCASE('$local'), UCASE('$embalagem'), UCASE('$nome_user'), NOW(), '$id_marca', '$id_grupo', UCASE('$cod_original2'), UCASE('$custo'), UCASE('$custo'), '$foto')";
		$exe_per = mysql_query($sql_per, $base) or die (mysql_error().'-'.$sql_per);
	
	$cadastrado = "Cadastro Efetuado com exito.&nbsp;".$Codigo;
	echo "<strong>Cadastro Efetuado com exito.</p>";
	/*echo "<script language='javaScript'>window.location.href='cadastro_prod.php?cadastrado=$cadastrado'</script>";*/
	}
		
	else{
		echo "<strong>Producto con este Codigo ja cadastrado</strong></p>";
		echo "</p>\n";
}
		}
//	}
?>
      </span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
  <script type='text/javascript'>
	$("#marca").autocomplete("pesquisa_marca.php", {
		width: 260,
		selectFirst: false
	});	
	$("#grupo").autocomplete("pesquisa_grupo.php", {
		width: 260,
		selectFirst: false
	});		
</script>