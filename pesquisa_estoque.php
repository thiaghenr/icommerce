<?
require_once("verifica_login.php");
require_once("biblioteca.php");
include "config.php";
conexao();

$data= date("Y-m-d"); // captura a data
$hora= date("H:i:s"); //captura a hora
//$mes= date("m");
//echo  $id_grupo;

echo $mydate;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type='text/javascript' src='js/jquery/jquery/jquery.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.dimensions.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='js/jquery/autocomplete/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="js/jquery/autocomplete/jquery.autocomplete.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Busca de Productos</title>

<style type="text/css">
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
.style1 {
	color: #333333;
	font-weight: bold;
}
</style>
<!-- <link href="css/styles.css" rel="stylesheet" type="text/css" /> -->
</head>


</head>

<body>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#B1C3D9" class="spece"><div align="center" class="style1">HISTORICO DE PRODUTOS</div></td>
  </tr>
</table>
<p>&nbsp;</p>
<form id="form1" name="form1" method="post" action="">
<table width="65%" border="0">
  <tr>
    <td colspan="4">Buscar Produtos por: 
        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Relatorio Con Base En 
        <label>
        <input type="text" name="mes" size="1" id="mes" value="<?=$mes?>" />
        </label>        
        &nbsp;Meses&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        
        <label></label></td>
  </tr>
  
  <tr>
    <td width="18%" height="48">      Grupo
    :
    <input type="text" id="grupo" name="grupo" /></td>
    <td width="18%">Marca:
    <input type="text" id="marca" name="marca" /></td>
    <td width="16%">Codigo:
    <input type="text" id="codigo" name="codigo" /></td>
    <td width="48%">Descricao:
    <input type="text" size="30" id="descricao" name="descricao" /></td>
  </tr>
</table>

  <label>
  <input type="submit" name="Submit" value="Buscar" />
  </label>
  </form>
  <table width="100%" border="0">
  <tr>
  	<td width="9%" bgcolor="#FFFF99" class="alt">Codigo</td>
    <td width="20%" bgcolor="#FFFF99" class="alt">Descricao</td>
    <td width="11%" bgcolor="#FFFF99" class="alt">Grupo</td>
    <td width="11%" bgcolor="#FFFF99" class="alt">Marca</td>
    <td width="7%" bgcolor="#FFFF99" class="alt">Em Estoque</td>
    <td width="7%" bgcolor="#FFFF99" class="alt">Cant. Vendida</td>
    <td width="7%" bgcolor="#FFFF99" class="alt">Custo Anterior</td>
    <td width="7%" bgcolor="#FFFF99" class="alt">Custo Medio</td>
    <td width="7%" bgcolor="#FFFF99" class="alt">Custo Atual</td>
    <td width="7%" bgcolor="#FFFF99" class="alt">Valor Medio Vendido</td>
    <td width="7%" bgcolor="#FFFF99" class="alt">Lucro M&eacute;dio obtido</td>
  </tr>
  <?php
  		$tempo1 = "mes";
		$tempo2 = "meses";
		$perc = "%";
  		if (empty ($_POST['mes'])){ $mes = 3;}
		else{
  		$mes = $_POST['mes']; }
		echo 'Relatorio con base en ' .$mes.' ';  if ($mes == 1){ echo $tempo1;} else { echo $tempo2;} 
  		$mydate = gmdate("Y-m-d", strtotime("-$mes month "));
		//echo $mydate;

		/*INICIO - PEGANDO ID DA MARCA*/
		if (!empty ($_POST['marca'])){
		$marca = $_POST['marca'];
		$sql_marca = "SELECT id FROM marcas WHERE nom_marca = '".$marca."'";
		$rs_marca = mysql_query($sql_marca);
		
		$linha_marca = mysql_fetch_array($rs_marca);
		$id_marca = $linha_marca['id'];
		}
		/*FIM*/
		
		/*INICIO - PEGANDO ID DO GRUPO*/
		if (!empty ($_POST['grupo'])){
		$grupo = $_POST['grupo'];
		$sql_grupo = "SELECT id FROM grupos WHERE nom_grupo = '".$grupo."' ";
		$rs_grupo = mysql_query($sql_grupo);
		
		$linha_grupo = mysql_fetch_array($rs_grupo);
		$id_grupo = $linha_grupo['id'];
		}
		/*FIM*/
		
		if (!empty ($_POST['codigo'])){
		$codigo = $_POST['codigo'];
		}
		
		if (!empty ($_POST['descricao'])){
		$descricao = $_POST['descricao'];
		}
	// PEGAR POR GRUPO ############################################################################
	if (!empty ($id_grupo) && empty ($id_marca)) { //$pm = 1;
	$sql_busca = " SELECT i.referencia_prod,sum(qtd_produto) as tota, p.Codigo,Descricao,grupo,marca,Estoque,custo,custo_medio,custo_anterior, m.nom_marca, g.nom_grupo FROM itens_pedido i, produtos p, marcas m, grupos g WHERE  ((p.marca = m.id) AND (p.grupo = '$id_grupo') AND (p.Codigo = i.referencia_prod) AND g.id = '$id_grupo') GROUP BY p.Codigo  ";
	$exe_busca= mysql_query($sql_busca);
	}
	
	//PEGAR PELA MARCA #############################################################################
    if (empty ($id_grupo) && !empty ($id_marca)) { 
	$sql_busca = " SELECT i.referencia_prod,sum(qtd_produto) as tota, p.Codigo,Descricao,grupo,marca,Estoque,custo,custo_medio,custo_anterior, m.nom_marca, g.nom_grupo FROM itens_pedido i, produtos p, marcas m, grupos g WHERE  ((p.marca = '$id_marca') AND (p.grupo = g.id) AND (p.Codigo = i.referencia_prod) AND m.id = '$id_marca') GROUP BY p.Codigo  ";
	$exe_busca= mysql_query($sql_busca);
	}

	// PEGAR POR MARCA E POR GRUPO ###################################################################
	if (!empty ($id_grupo) && !empty ($id_marca)) { $pm = 1;
	$checa = " SELECT i.referencia_prod,sum(qtd_produto) as tota, p.Codigo,grupo FROM itens_pedido i, produtos p, grupos g WHERE p.grupo = '$id_grupo' AND g.id = p.grupo AND p.Codigo = i.referencia_prod GROUP BY p.Codigo ";
	$exe_checa= mysql_query($checa);
	$rows = mysql_num_rows($exe_checa);
	$reg_checa = mysql_fetch_array($exe_checa);
	$tota = $reg_checa['tota']; 
	if($rows > 0){ //echo "aki";
	$sql_busca =" SELECT i.referencia_prod,sum(qtd_produto) as tot, p.Codigo,Descricao,grupo,marca,Estoque,custo,valor_b,custo_medio,custo_anterior, m.nom_marca, g.nom_grupo FROM itens_pedido i, produtos p, marcas m, grupos g WHERE p.marca = '$id_marca' AND p.grupo = '$id_grupo' AND  m.id = p.marca AND p.grupo = g.id  GROUP BY p.Codigo ";
	}
	else{ //echo "nao";
	$sql_busca = " SELECT p.Codigo,Descricao,grupo,marca,Estoque,custo,valor_b,custo_medio,custo_anterior, m.nom_marca, g.nom_grupo FROM produtos p, marcas m, grupos g WHERE p.marca = '$id_marca' AND m.id = p.marca AND p.grupo = g.id GROUP BY p.Codigo ";
	}
	$exe_busca= mysql_query($sql_busca);
	}	
	// PEGAR GRERAL   ################################################################################
	if (empty ($id_grupo) && empty ($id_marca)) {  
	$sql_busca = " SELECT i.referencia_prod,sum(qtd_produto) as tota, p.Codigo,Descricao,grupo,marca,Estoque,custo,custo_medio,custo_anterior, m.nom_marca, g.nom_grupo FROM itens_pedido i, produtos p, marcas m, grupos g WHERE  ((p.marca = m.id) AND (p.grupo = g.id) AND (p.Codigo = i.referencia_prod)) GROUP BY p.Codigo  limit 30 ";
	$exe_busca= mysql_query($sql_busca);
	}
	
	// SQL PARA PEGAR POR CODIGO ####################################################################
	if (!empty ($codigo) ) { 
	
	$sql_busca = " SELECT i.referencia_prod,sum(qtd_produto) as tota, p.Codigo,Descricao,grupo,marca,Estoque,custo,valor_b,custo_medio,custo_anterior, m.nom_marca, g.nom_grupo FROM itens_pedido i, produtos p, marcas m, grupos g WHERE p.Codigo LIKE '%$codigo%' AND p.marca = m.id AND p.grupo = g.id AND p.Codigo = i.referencia_prod GROUP BY p.Codigo ";
	
	$exe_busca= mysql_query($sql_busca);
	}	
	########################################################################################################
	// PARA PEGAR POR DESCRICAO
	else if (!empty ($descricao) ) { //echo $descricao;
	$sql_cont =  " SELECT COUNT(descricao_prod) AS n_prod FROM itens_pedido where descricao_prod LIKE '%$descricao%' ";
	$exe_cont = mysql_query($sql_cont, $base) or die (mysql_error());
	$reg_cont = mysql_fetch_array($exe_cont, MYSQL_ASSOC);
	$reg_cont['n_prod'] ;
	if ($reg_cont['n_prod'] >0){
	$sql_busca = " SELECT i.referencia_prod,sum(qtd_produto) as tota, p.Codigo,Descricao,grupo,marca,Estoque,custo,valor_b,custo_medio,custo_anterior, m.nom_marca, g.nom_grupo FROM itens_pedido i, produtos p, marcas m, grupos g WHERE p.Descricao LIKE '%$descricao%' AND p.marca = m.id AND p.grupo = g.id AND p.Codigo = i.referencia_prod GROUP BY p.Codigo ";
	}
	else{
	$sql_busca = " SELECT i.referencia_prod,sum(qtd_produto) as tot, p.Codigo,Descricao,grupo,marca,Estoque,custo,valor_b,custo_medio,custo_anterior, m.nom_marca, g.nom_grupo FROM itens_pedido i, produtos p, marcas m, grupos g WHERE (p.Descricao LIKE '%$descricao%' AND p.marca = m.id AND p.grupo = g.id)   OR ((p.marca = m.id) AND (p.grupo = g.id) AND (p.Descricao LIKE '%$descricao%')) GROUP BY p.Codigo ";
	}
	$exe_busca= mysql_query($sql_busca);
	}	
	##########################################################################################################
	while ($reg_busca = mysql_fetch_array($exe_busca, $base)){
	if($pm != 1){
	$tota = $reg_busca['tota'];
	}
	else{
	$tota = $tota; }
    $tot = $tota;//}
	//echo $pm;
	$custo = $reg_busca['custo'];
	$estoque =  $reg_busca['Estoque'];
	$valor_b =  $reg_busca['valor_b'];
	$custo_anterior =  $reg_busca['custo_anterior'];
	$custo_medio =  $reg_busca['custo_medio'];
	
		
	$sql_custo = "SELECT it.referencia_prod,avg(prvenda) as total, pr.Codigo, p.data_car, cb.data,avg(vl_cambio) as cambial FROM itens_pedido it, produtos pr, pedido p, cambio_moeda cb WHERE p.data_car BETWEEN '$mydate' AND NOW() AND p.id = it.id_pedido AND it.referencia_prod = '".$reg_busca['Codigo']."' AND it.referencia_prod = pr.Codigo  AND cb.data BETWEEN '$mydata' AND NOW() AND cb.moeda_id = '3' group by it.referencia_prod ";
	$exe_custo = mysql_query($sql_custo,$base);
	$num_itens = mysql_num_rows($exe_custo);
	$i=0;
	while ($reg_custo = mysql_fetch_array($exe_custo, MYSQL_ASSOC)) {

	$cod = $reg_custo['Codigo'];
	$venda =  $reg_custo['total'];
	$desc = $reg_custo['descricao_prod']; 
	$cambio = $reg_custo['cambial'];	
	}
	
?>
    
  <tr>
    <td class="lina"><span class="Estilo17">
      <?=$reg_busca['Codigo']?>
    &nbsp;</span></td>
    <td class="lina"><span class="Estilo17">
      <?=substr($reg_busca['Descricao'],0,23)?>
    </span></td>
    <td class="lina"><span class="Estilo17">
      <?=substr($reg_busca['nom_grupo'],0,10)?>
    </span></td>
    <td class="lina"><span class="Estilo17">
      <?=substr($reg_busca['nom_marca'],0,10)?>
    </span></td>
    <td class="lina"><span class="Estilo17">
      <?=$estoque?>
    </span></td>
    <td class="lina"><span class="Estilo17">
    <? if ($cod == $reg_busca['Codigo']){ echo $tot;}?>
    </span></td>
    <td class="lina Estilo17 Estilo17 Estilo17"><div align="right"><span class="Estilo17">
      <?=$custo_anterior?>
    </span></div></td>
    <td class="lina Estilo17 Estilo17 Estilo17"><div align="right"><span class="Estilo17">
      <?=$custo_medio?>
    </span></div></td>
    <td class="lina Estilo17 Estilo17 Estilo17"><div align="right"><span class="lina"><span class="Estilo17">
      <?=$custo?>
    </span></span></div></td>
    <td class="lina Estilo17 Estilo17 Estilo17"><div align="right"><a href="proveedores_prod.php"></a>	 &nbsp;<span class="Estilo17">
      <? if ($cod == $reg_busca['Codigo']){ echo number_format($venda,0,",",".");}?>
    </span></div></td>
    <td class="lina Estilo17 Estilo17 Estilo17"><div align="right">
      <?  if ($cod == $reg_busca['Codigo']){$venda = $venda / $cambio;  $lucro = $venda - $custo; if ($custo != 0){ $media = 100 / $custo * $lucro; echo number_format($media,2,",",".");echo $perc   ;}}?>
    </div></td>
  </tr>

<? } ?>
</table>
<p>&nbsp;</p>
<script type='text/javascript'>
	</script>
<script type='text/javascript'>$("#marca").autocomplete("pesquisa_marca.php", {
		width: 260,
		selectFirst: false
	});	
	$("#grupo").autocomplete("pesquisa_grupo.php", {
		width: 260,
		selectFirst: false
	});		
	$("#codigo").autocomplete("pesquisa_codigo.php", {
		width: 260,
		selectFirst: false
	});		
	$("#descricao").autocomplete("pesquisa_descricao.php", {
		width: 260,
		selectFirst: false
	});		
</script>
</body>
</html>
