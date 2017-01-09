<?php
include "../config.php";
require_once("../biblioteca.php");
conexao();

 mysql_query("SET NAMES 'utf8'");
 mysql_query('SET character_set_connection=utf8');
 mysql_query('SET character_set_client=utf8');
 mysql_query('SET character_set_results=utf8');

if(isset($_POST['acao'])){
$acao = $_POST['acao'];
if($acao == "alterar"){
$campo = $_POST['campo'];
if($campo == "1"){
$campo = "nom_marca";
}
$valor = $_POST['valor'];
$idMarca = $_POST['idMarca'];
	
	$sql_per = "UPDATE marcas SET $campo = UCASE('$valor') WHERE id = $idMarca ";
	$exe_per = mysql_query($sql_per) or die (mysql_error()) ;

	
	}
	
if($acao == "novoMarca"){	
$nome_marca = $_POST['nome_marca'];

	$sql_ins = "INSERT INTO marcas
	(nom_marca, data)
	VALUES(UCASE('$nome_marca'), NOW())";
	$exe_ins = mysql_query($sql_ins, $base)  or die (mysql_error());
	
	echo "{success:true, response: 'Nova Marca Cadastrada' }"; 
	exit();
}

if($acao == "excluir"){
$idMarca = $_POST['idMarca'];
	
	$rs    = mysql_query("SELECT marca FROM produtos WHERE marca = $idMarca  ")or die (mysql_error().'-'.$rs);
	$totalMarcas = mysql_num_rows($rs);
	
	if($totalMarcas == 0){
	$sql_del = "DELETE FROM marcas WHERE id = $idMarca ";
	$exe_del = mysql_query($sql_del, $base)or die (mysql_error().'-'.$sql_del);
	echo "{success:true, response: 'MarcaExcluido' }"; 
	}
	else{
	echo "{success:true, response: 'LancamentoExistente' }"; 
	}
	exit();
}
////////////////////////////////////////////////////////////////////////////////
if($acao == "alteraPrecos"){	
 $margen_a = ajustaValor($_POST['AmargenReajuste']);	
 $margen_b = ajustaValor($_POST['BmargenReajuste']);	
 $margen_c = ajustaValor($_POST['CmargenReajuste']);
 $custo = ajustaValor($_POST['CustoReajuste']);
 $marca = $_POST['idMarca'];
 $operacao = $_POST['sitReajustaVal'];

$sql_val = "SELECT id,marca,margen_a,margen_b,margen_c,custo,valor_a,valor_b,valor_c FROM produtos WHERE marca = '$marca' ";
$exe_val = mysql_query($sql_val, $base) or die (mysql_error());
while ($reg_val = mysql_fetch_array($exe_val, MYSQL_ASSOC)){

	$ma = $reg_val['margen_a'];
	$mb = $reg_val['margen_b'];
	$mc = $reg_val['margen_c'];
	$ct = $reg_val['custo'];
	$id = $reg_val['id'];
	
	
if($operacao == "Alta"){
	
	 if(!empty($custo)){
	 $custoA = $ct / 100 * $custo;
	 $ct =  $ct + $custoA;
	 $percentual_b = $ma / 100;
	 $valor_a = $ct + ($percentual_b * $ct);
	 }
	

	if(!empty($margen_a)){
	$aumentoa = $ma / 100 * $margen_a;
	$maa = $ma + $aumentoa;
	$percentual_a = $maa / 100;
	$valor_a = $ct + ($percentual_a * $ct);
	}
	else{
	$maa = $reg_val['margen_a'];
	$valor_a = $reg_val['valor_a'];
	}
	
	if(!empty($margen_b)){
	$aumentob = $mb / 100 * $margen_b;
	$mbb = $mb + $aumentob;
	$percentual_b = $mbb / 100;
	$valor_b = $ct + ($percentual_b * $ct);
	}
	else{
	$mbb = $reg_val['margen_b'];
	$valor_b = $reg_val['valor_b'];
	}
	
	if(!empty($margen_c)){
	$aumentoc = $mc / 100 * $margen_c;
	$mcc = $mc + $aumentoc;
	$percentual_c = $mcc / 100;
	$valor_c = $ct + ($percentual_c * $ct);
	}
	else{
	$mcc = $reg_val['margen_c'];
	$valor_c = $reg_val['valor_c'];
	}
}

if($operacao == "Baixa"){

	if(!empty($custo)){
	 $custoA = $ct / 100 * $custo;
	 $ct =  $ct - $custoA;
	 }
	 
	if(!empty($margen_a)){
	$aumentoa = $ma / 100 * $margen_a;
	$maa = $ma - $aumentoa;
	$percentual_a = $maa / 100;
	$valor_a = $ct + ($percentual_a * $ct);
	}
	else{
	$maa = $reg_val['margen_a'];
	$valor_a = $reg_val['valor_a'];
	}
	
	if(!empty($margen_b)){
	$aumentob = $mb / 100 * $margen_b;
	$mbb = $mb - $aumentob;
	$percentual_b = $mbb / 100;
	$valor_b = $ct + ($percentual_b * $ct);
	}
	else{
	$mbb = $reg_val['margen_b'];
	$valor_b = $reg_val['valor_b'];
	}
	
	if(!empty($margen_c)){
	$aumentoc = $mc / 100 * $margen_c;
	$mcc = $mc - $aumentoc;
	$percentual_c = $mcc / 100;
	$valor_c = $ct + ($percentual_c * $ct);
	}
	else{
	$mcc = $reg_val['margen_c'];
	$valor_c = $reg_val['valor_c'];
	}
}
$sql_marca = "UPDATE produtos SET margen_a = '$maa', margen_b = '$mbb', margen_c = '$mcc', valor_a = '$valor_a', valor_b = '$valor_b', 
valor_c = '$valor_c', custo = '$ct' WHERE id = '$id' ";
$exe_marca = mysql_query($sql_marca) or die (mysql_error());

}

echo "{success:true, response: 'Reajuste efetuado com Sucesso' }"; 
exit();
}
	
}

$id = isset($_POST['id']) ? $_POST['id'] : '' ;

	$rs    = mysql_query("SELECT id, nom_marca, date_format(data, '%d/%m/%Y') AS data FROM marcas ORDER BY nom_marca ASC ")or die (mysql_error().'-'.$rs);
	$totalPlanos = mysql_num_rows($rs);
	
	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		
	}
	echo '({"totalMarcas":"'.$totalPlanos.'","Marcas":'.json_encode($arr).'})'; 
//} 
?>