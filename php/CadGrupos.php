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
$campo = "nom_grupo";
}
$valor = $_POST['valor'];
$idGrupo = $_POST['idGrupo'];
	
	$sql_per = "UPDATE grupos SET $campo = UCASE('$valor') WHERE id = $idGrupo ";
	$exe_per = mysql_query($sql_per) or die (mysql_error()) ;

	
	}
	
if($acao == "novoGrupo"){	
$nome_grupo = $_POST['nome_grupo'];

	$sql_ins = "INSERT INTO grupos
	(nom_grupo, data)
	VALUES(UCASE('$nome_grupo'), NOW())";
	$exe_ins = mysql_query($sql_ins, $base)  or die (mysql_error());
	
	echo "{success:true, response: 'Nuevo Grupo Catastrado' }"; 
	exit();
}

if($acao == "excluir"){
$idGrupo = $_POST['idGrupo'];
	
	$rs    = mysql_query("SELECT grupo FROM produtos WHERE grupo = $idGrupo  ")or die (mysql_error().'-'.$rs);
	$totalGrupos = mysql_num_rows($rs);
	
	if($totalGrupos == 0){
	$sql_del = "DELETE FROM grupos WHERE id = $idGrupo ";
	$exe_del = mysql_query($sql_del, $base)or die (mysql_error().'-'.$sql_del);
	echo "{success:true, response: 'GrupoExcluido' }"; 
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
 $grupo = $_POST['idGrupo'];
 $operacao = $_POST['sitReajustaVal'];

$sql_val = "SELECT id,grupo,margen_a,margen_b,margen_c,custo,valor_a,valor_b,valor_c FROM produtos WHERE grupo = '$grupo' ";
$exe_val = mysql_query($sql_val, $base) or die (mysql_error());
while ($reg_val = mysql_fetch_array($exe_val, MYSQL_ASSOC)){

	$ma = $reg_val['margen_a'];
	$mb = $reg_val['margen_b'];
	$mc = $reg_val['margen_c'];
	$ct = $reg_val['custo'];
	$id = $reg_val['id'];
	
	$vla = $reg_val['valor_a'];
	$vlb = $reg_val['valor_b'];
	$vlc = $reg_val['valor_c'];
	
	
if($operacao == "Alta"){
	
	 if(!empty($custo)){
	 $custoA = $ct / 100 * $custo;
	 $ct =  $ct + $custoA;
	 $percentual_b = $ma / 100;
	 $valor_a = $ct + ($percentual_b * $ct);
	 }
	

	if(!empty($margen_a)){
	$aumentoa = $vla / 100 * $margen_a;
	$maa = $vla + $aumentoa;
	$percentual_a = $maa / 100;
	$valor_a = $maa;
	}
	else{
	$maa = $reg_val['margen_a'];
	$valor_a = $reg_val['valor_a'];
	}
	
	if(!empty($margen_b)){
	$aumentob = vlb / 100 * $margen_b;
	$mbb = $vlb + $aumentob;
	$percentual_b = $mbb / 100;
	$valor_b = $mbb;
	}
	else{
	$mbb = $reg_val['margen_b'];
	$valor_b = $reg_val['valor_b'];
	}
	
	if(!empty($margen_c)){
	$aumentoc = $vlc / 100 * $margen_c;
	$mcc = $vlc + $aumentoc;
	$percentual_c = $mcc / 100;
	$valor_c = $mcc;
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
	$aumentoa = $vla / 100 * $margen_a;
	$maa = $vla - $aumentoa;
	$percentual_a = $maa / 100;
	$valor_a = $maa;
	}
	else{
	$maa = $reg_val['margen_a'];
	$valor_a = $reg_val['valor_a'];
	}
	
	if(!empty($margen_b)){
	$aumentob = $vlb / 100 * $margen_b;
	$mbb = $vlb - $aumentob;
	$percentual_b = $mbb / 100;
	$valor_b = $mbb;
	}
	else{
	$mbb = $reg_val['margen_b'];
	$valor_b = $reg_val['valor_b'];
	}
	
	if(!empty($margen_c)){
	$aumentoc = $vlc / 100 * $margen_c;
	$mcc = $vlc - $aumentoc;
	$percentual_c = $mcc / 100;
	$valor_c = $mcc;
	}
	else{
	$mcc = $reg_val['margen_c'];
	$valor_c = $reg_val['valor_c'];
	}
}
$sql_grupo = "UPDATE produtos SET margen_a = '$maa', margen_b = '$mbb', margen_c = '$mcc', valor_a = '$valor_a', valor_b = '$valor_b', 
valor_c = '$valor_c', custo = '$ct' WHERE id = '$id' ";
$exe_grupo = mysql_query($sql_grupo) or die (mysql_error());

}

echo "{success:true, response: 'Reajuste efetuado com Sucesso' }"; 
exit();
}
	
}







$id = isset($_POST['id']) ? $_POST['id'] : '' ;

	$rs    = mysql_query("SELECT g.id, g.nom_grupo, date_format(g.data, '%d/%m/%Y') AS data, count(p.id) AS itens, 
			sum(p.Estoque * p.custo) AS ctatual, sum(p.Estoque * p.valor_a) AS vlatual,
			(SELECT count(p.id) AS itss FROM produtos p WHERE p.Estoque > '0' AND p.grupo = g.id) AS comstok
			FROM produtos p
			RIGHT JOIN grupos g ON g.id = p.grupo
			GROUP BY g.id ORDER BY g.nom_grupo ASC ")or die (mysql_error().'-'.$rs);
	$totalPlanos = mysql_num_rows($rs);
	
	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		
	}
	echo '({"totalGrupos":"'.$totalPlanos.'","Grupos":'.json_encode($arr).'})'; 
//} 
?>