<?php
 	require_once("../config.php");
    conexao();
	
	$ref = $_GET['ref'];
    $desc = $_GET['desc'];
	if($ref == '1lKx'){
		$ref = '';
		}
	if($desc == '2lKx'){
		$desc = '';
	}
	
	$descp = $_POST['desc']; // ORDER BY CAST(Codigo AS UNSIGNED) 
	$refp = $_POST['ref'];

	$cli = $_GET['cli'];
	$_SESSION['cliente'] = $cli;
	$acao = $_POST['acao'];
	
	
	if($acao == "pesquisa"){
    $sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio FROM cambio_moeda cm WHERE cm.moeda_id = 3 group by cm.id DESC";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
   
    $id_prod = addslashes(htmlentities($_GET['desc']));
    $sql =  "SELECT id,Codigo,Descricao,Estoque,qtd_bloq,valor_a,valor_b,valor_c FROM produtos 
			WHERE ((Descricao LIKE '$descp%') AND (Codigo LIKE '$refp%')) 
			OR ((cod_original2 LIKE '$refp%') AND (Descricao LIKE '$descp%') ) 
			OR ((cod_original LIKE '$refp%') AND (Descricao LIKE '$descp%')) 
			OR ((Codigo_Fabricante LIKE '$refp%') AND (Descricao LIKE '$descp%')) 
			OR ((Codigo_Fabricante2 LIKE '$refp%') AND (Descricao LIKE '$descp%')) 
			OR ((Codigo_Fabricante3 LIKE '$refp%') AND (Descricao LIKE '$descp%')) 
			ORDER BY Codigo ASC limit 0,20 ";
    $rs = mysql_query($sql) or die (mysql_error());
	
	$num_prod = mysql_num_rows($rs);
	
	//$arr = array();
    while($linha=mysql_fetch_array($rs)){
	
	
	$arr[] = $linha;
	}
	echo '{ "Produtos":'.json_encode($arr).'}'; 
	}
	
	if($acao == "ListaProd"){
	
	$sql_cambio = "SELECT max(cm.id) as cambio_id, cm.vl_cambio FROM cambio_moeda cm WHERE cm.moeda_id = 3 group by cm.id DESC";
    $rs_cambio = mysql_query($sql_cambio);
    $linha_cambio = mysql_fetch_array($rs_cambio);
    $vl_cambio_guarani = $linha_cambio['vl_cambio'];
   
    $id_prod = addslashes(htmlentities($_GET['desc']));
    $sql =  "SELECT id,Codigo,Descricao,Estoque,qtd_bloq,valor_a,valor_b,valor_c FROM produtos 
			WHERE ((Descricao LIKE '$desc%') AND (Codigo LIKE '$ref%')) 
			OR ((cod_original2 LIKE '$ref%') AND (Descricao LIKE '$desc%') ) 
			OR ((cod_original LIKE '$ref%') AND (Descricao LIKE '$desc%')) 
			OR ((Codigo_Fabricante LIKE '$ref%') AND (Descricao LIKE '$desc%')) 
			OR ((Codigo_Fabricante2 LIKE '$ref%') AND (Descricao LIKE '$desc%')) 
			OR ((Codigo_Fabricante3 LIKE '$ref%') AND (Descricao LIKE '$desc%')) 
			ORDER BY Codigo ASC limit 0,20 ";
    $rs = mysql_query($sql) or die (mysql_error());
	
	$num_prod = mysql_num_rows($rs);
	
	//$arr = array();
    while($linha=mysql_fetch_array($rs)){
	
	
	$arr[] = $linha;
	}
	echo '{ "Produtos":'.json_encode($arr).'}'; 
	}
	
	
	
?>