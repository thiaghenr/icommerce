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
    <td bgcolor="#B1C3D9" class="spece"><div align="center" class="style1">HISTORICO DE PRODUTO</div></td>
  </tr>
</table>
<p>&nbsp;</p>
<form id="form1" name="form1" method="post" action="">
<table width="75%" border="0">
  <tr>
    <td colspan="4">Buscar Produtos por: 
        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label></label></td>
  </tr>
  
  <tr>
    <td width="29%" height="48">Codigo:
    <input type="text" id="codigo" name="codigo" value="<?=$_POST['codigo']?>" /></td>
    <td width="28%">Descricao:
    <input type="text" size="30" id="descricao" name="descricao" /></td>
    <td width="23%"><span class="calendar_today">Data Inicial:
        <input type="text" id="data_ini" name="data_ini" value='<?=$_POST['data_ini']?>' />
    </span></td>
    <td width="20%"><span class="calendar_today">Data Final:
        <input type="text" id="data_fim" name="data_fim" value="<?=$_POST['data_fim']?>"  />
    </span></td>
  </tr>
</table>

  <label>
  <input type="submit" name="Submit" value="Buscar" />
  </label>
</form>
<table width="100%" border="0">
  <tr>
  	<td width="7%" bgcolor="#FFFF99" class="alt">Compra</td>
    <td width="9%" bgcolor="#FFFF99" class="alt">Fornecedor</td>
    <td width="30%" bgcolor="#FFFF99" class="alt">Nome</td>
    <td width="19%" bgcolor="#FFFF99" class="alt">Data Compra</td>
    <td width="19%" bgcolor="#FFFF99" class="alt">Qtd Comprada</td>
    <td width="16%" bgcolor="#FFFF99" class="alt">Custo do Produto</td>
  </tr>
  <?php
  		$tempo1 = "mes";
		$tempo2 = "meses";
		$perc = "%";
  		if (empty ($_POST['mes'])){ $mes = 3;}
		else{
  		$mes = $_POST['mes']; }
  		$mydate = gmdate("Y-m-d", strtotime("-$mes month "));
		//echo $mydate;
		
		$codigo = $_POST['codigo'];
		$descricao = $_POST['descricao'];
		$dt_ini = converte_data('2',$_POST['data_ini']);
	    $dt_fim = converte_data('2',$_POST['data_fim']);
	
	
	// SQL PARA PEGAR POR CODIGO ####################################################################
	if (!empty ($codigo) ) { 
	
	
	$sql_busca = " SELECT ic.*, c.*, p.nome FROM itens_compra ic, compras c, proveedor p WHERE p.id = c.fornecedor_id AND ic.referencia_prod = '$codigo' AND ic.compra_id = c.id_compra AND c.data_lancamento BETWEEN '$dt_ini' AND '$dt_fim'  group by c.id_compra ";
	$exe_busca= mysql_query($sql_busca) or die (mysql_error().'-'.$sql_busca);
	while ($reg_busca = mysql_fetch_array($exe_busca, MYSQL_ASSOC)){
	
	$qtd_comprada += $reg_busca['qtd_produto']; 
	
	$tota = $reg_busca['tota'];
	
	$custo = $reg_busca['custo'];
	$estoque =  $reg_busca['Estoque'];
	$valor_b =  $reg_busca['valor_b'];
	$custo_anterior =  $reg_busca['custo_anterior'];
	$custo_medio =  $reg_busca['custo_medio'];
	
	$data = $reg_busca['data_lancamento'];
	$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);		
	
	
?>
    
  <tr>
    <td class="lina"><span class="Estilo17">&nbsp;
      <?=$reg_busca['id']?>
    </span></td>
    <td class="lina"><span class="Estilo17">
      <?=$reg_busca['fornecedor_id']?>
    </span></td>
    <td class="lina"><span class="Estilo17">
      <?=substr($reg_busca['nome'],0,23)?>
    </span></td>
    <td class="lina"><span class="Estilo17">
      <?=$novadata?>
    </span></td>
    <td class="lina"><span class="Estilo17">
      <?=$reg_busca['qtd_produto']?>
    </span></td>
    <td class="lina"><span class="Estilo17"><?=number_format($reg_busca['prcompra'],2,",",".")?>
    </span></td>
  </tr>

<? } } ?>
</table>
<p>&nbsp;</p>
<table width="100%" border="0">
  <tr>
    <td width="7%" bgcolor="#FFFF99" class="alt">Venda</td>
    <td width="9%" bgcolor="#FFFF99" class="alt">Cliente</td>
    <td width="30%" bgcolor="#FFFF99" class="alt">Nome</td>
    <td width="19%" bgcolor="#FFFF99" class="alt">Data Venda</td>
    <td width="19%" bgcolor="#FFFF99" class="alt">Qtd Vendida</td>
    <td width="16%" bgcolor="#FFFF99" class="alt">Valor da Venda</td>
  </tr>
  <?php
  		
	
	$sql_buscap = " SELECT it.*, p.*, c.nome FROM itens_pedido it, pedido p, clientes c WHERE c.controle = p.controle_cli AND it.referencia_prod = '$codigo' AND it.id_pedido = p.id AND p.data_car BETWEEN '$dt_ini' AND '$dt_fim'  group by p.id ";
	$exe_buscap = mysql_query($sql_buscap) or die (mysql_error().'-'.$sql_buscap);
	$linhas = mysql_num_rows($exe_buscap);
	while ($reg_buscap = mysql_fetch_array($exe_buscap, MYSQL_ASSOC)){
	
	$qtd_vendida  += $reg_buscap['qtd_produto'];
	$montante_venda += $reg_buscap['prvenda'];
	
    
	$vl_medio_venda =  $montante_venda /  $linhas;
	
	$custo = $reg_busca['custo'];
	$estoque =  $reg_busca['Estoque'];
	$valor_b =  $reg_busca['valor_b'];
	$custo_anterior =  $reg_busca['custo_anterior'];
	$custo_medio =  $reg_busca['custo_medio'];
	
	$data2 = $reg_buscap['data_car'];
	$novadata2 = substr($data2,8,2) . "/" .substr($data2,5,2) . "/" . substr($data2,0,4);		
	
	
?>
  <tr>
    <td class="lina"><span class="Estilo17">
      <?=$reg_buscap['id']?>
      &nbsp;</span></td>
    <td class="lina"><span class="Estilo17">
      <?=$reg_buscap['controle_cli']?>
    </span></td>
    <td class="lina"><span class="Estilo17">
      <?=substr($reg_buscap['nome'],0,23)?>
    </span></td>
    <td class="lina"><span class="Estilo17">
      <?=$novadata2?>
    </span></td>
    <td class="lina"><span class="Estilo17">
      <?=$reg_buscap['qtd_produto']?>
    </span></td>
    <td class="lina"><span class="Estilo17">
      <?=number_format($reg_buscap['prvenda'],2,",",".")?>
    </span></td>
  </tr>
  <?  } ?>
</table>
<p>&nbsp;</p>
<table width="100%" border="0">
  <tr>
    <td width="10%" bgcolor="#FFFF99" class="alt">Codigo</td>
    <td width="11%" bgcolor="#FFFF99" class="alt">Descricao</td>
    <td width="9%" bgcolor="#FFFF99" class="alt">Em Estoque</td>
    <td width="10%" bgcolor="#FFFF99" class="alt">Qtd Comprada</td>
    <td width="9%" bgcolor="#FFFF99" class="alt">Qtd  Vendida</td>
    <td width="9%" bgcolor="#FFFF99" class="alt">Custo Anterior</td>
    <td width="10%" bgcolor="#FFFF99" class="alt">Custo Medio</td>
    <td width="10%" bgcolor="#FFFF99" class="alt">Custo Atual</td>
    <td width="13%" bgcolor="#FFFF99" class="alt">Valor Medio Vendido</td>
    <td width="9%" bgcolor="#FFFF99" class="alt">Lucro M&eacute;dio</td>
  </tr>
  <?php
  		
	
	$sql_buscam = " SELECT * FROM produtos WHERE Codigo = '$codigo'  ";
	$exe_buscam = mysql_query($sql_buscam);	
	while ($reg_buscam = mysql_fetch_array($exe_buscam, MYSQL_ASSOC)){
	
	
	//$valor_real = $vl_medio_venda / $vl_cambio; 
	
	if ($reg_buscam['custo_medio'] != 0) {
	$custo_medio = $reg_buscam['custo_medio'];}
	else {
	$custo_medio = $reg_buscam['custo_medio'];}
	
	if ($custo_medio == 0) {
	$custo_medio = 2;}	

	$lucro = $vl_medio_venda -  $custo_medio;
	$media = 100 / $custo_medio * $lucro;
	
	if ($media < 0){
	$media = 0;}
	else {
	$media; }
    number_format($media,2,",",".");
		
	
	
?>
  <tr>
    <td class="lina"><span class="Estilo17">
      <?=$reg_buscam['Codigo']?>
      &nbsp;</span></td>
    <td class="lina"><span class="Estilo17">
      <?=substr($reg_buscam['Descricao'],0,23)?>
    </span></td>
    <td class="lina"><span class="Estilo17">
      <?=$estoque?>
    </span></td>
    <td class="lina"><?=$qtd_comprada?></td>
    <td class="lina"><span class="Estilo17">
      <?=$qtd_vendida?>
    </span></td>
    <td class="lina Estilo17 Estilo17 Estilo17"><div align="right"><span class="Estilo17">
      <?=number_format($reg_buscam['custo_anterior'],2,",",".")?>
    </span></div></td>
    <td class="lina Estilo17 Estilo17 Estilo17"><div align="right"><span class="Estilo17">
      <?=number_format($reg_buscam['custo_medio'],2,",",".")?>
    </span></div></td>
    <td class="lina Estilo17 Estilo17 Estilo17"><div align="right"><span class="Estilo17">
      <?=number_format($reg_buscam['custo'],2,",",".")?>
    </span></div></td>
    <td class="lina Estilo17 Estilo17 Estilo17"><div align="right"><a href="proveedores_prod.php"></a> &nbsp;<span class="Estilo17">
      <?=number_format($vl_medio_venda,2,",",".")?>
    </span></div></td>
    <td class="lina Estilo17 Estilo17 Estilo17"><div align="right">
      <? echo number_format($media,2,",","."); echo $perc   ;?>
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
