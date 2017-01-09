<?php
	require_once ("config.php");
    //require_once("biblioteca.php");
	conexao();
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
	
	$query = $_POST['query'];
	$acao_nome = $_GET['acao_nome'];
	$acao = $_POST['acao'];
	$CodForn = $_POST['CodForn'];
	$user = $_POST['user'];
/*
	$param = strtoupper($_GET['q']);
	
	$sql_grupo = "SELECT Codigo FROM produtos WHERE Codigo LIKE '%$param%'";
	$rs_grupo = mysql_query($sql_grupo);
	
	while ($linha_grupo=mysql_fetch_array($rs_grupo, MYSQL_ASSOC)){
		echo $linha_grupo['Codigo']."\n";
	}
	if(mysql_num_rows($rs_grupo) <=0){
		echo "Nao encontrado\n";
	}	
*/

	
if($acao_nome == "CodProd"){	
$r = mysql_query ( ("SELECT id,Codigo,Descricao FROM produtos where Codigo LIKE '$query%' ORDER BY Codigo ASC"));
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$idprod = mysql_result ($r,$i,"id");
	$codprod = mysql_result ($r,$i, "Codigo");
	$descprod = mysql_result ($r,$i, "Descricao");
	
	if($i == ($l-1)) {
		$nomes .= '{idprod:"'.$idprod.'", descprod:"'.$descprod.'",  "codprod":"'.$codprod.'"}';
	}else{
		$nomes .= '{idprod:"'.$idprod.'", descprod:"'.$descprod.'", "codprod":"'.$codprod.'"},';
	}
}

echo ('{resultados: [ '.$nomes.']}');
}

if($acao_nome == "DescProd"){	
$r = mysql_query (("SELECT id,Codigo,Descricao FROM produtos where Descricao LIKE '$query%' ORDER BY Descricao ASC"));
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$idprod = mysql_result ($r,$i,"id");
	$codprod = mysql_result ($r,$i, "Codigo");
	$descprod = mysql_result ($r,$i, "Descricao");
	
	if($i == ($l-1)) {
		$nomes .= '{idprod:"'.$idprod.'", "descprod":"'.$descprod.'",  codprod:"'.$codprod.'"}';
	}else{
		$nomes .= '{idprod:"'.$idprod.'", "descprod":"'.$descprod.'", codprod:"'.$codprod.'"},';
	}
}

echo ('{resultados: [ '.$nomes.']}');
}


if($acao_nome == "CodDesc"){	
$r = mysql_query (("SELECT id,Codigo,Descricao FROM produtos where Codigo LIKE '$query%' ORDER BY Descricao ASC"));
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$idprod = mysql_result ($r,$i,"id");
	$codprod = mysql_result ($r,$i, "Codigo");
	$descprod = mysql_result ($r,$i, "Descricao");
	$junto = $codprod." - ".$descprod;
	
	if($i == ($l-1)) {
		$nomes .= '{idprod:"'.$idprod.'", "junto":"'.$junto.'",  codprod:"'.$codprod.'"}';
	}else{
		$nomes .= '{idprod:"'.$idprod.'", "junto":"'.$junto.'", codprod:"'.$codprod.'"},';
	}
}

echo ('{resultados: [ '.$nomes.']}');
}

if($acao_nome == "CodDescUnidCust"){
$sql = "SELECT p.id,p.Codigo,p.Descricao,p.un_medida,custo, un.sigla_medida FROM produtos p
					LEFT JOIN unidade_medida un ON un.idunidade_medida = p.un_medida
					where p.Codigo LIKE '$query%' ORDER BY p.Descricao ASC";	
$r = mysql_query (($sql));
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$idprod = mysql_result ($r,$i,"id");
	$codprod = mysql_result ($r,$i, "Codigo");
	$descprod = mysql_result ($r,$i, "Descricao");
	$unid = mysql_result ($r,$i, "un_medida");
	$custo = mysql_result ($r,$i, "custo");
	$sigla_medida = mysql_result ($r,$i, "sigla_medida");
	$junto = $codprod." - ".$descprod;
	
	if($i == ($l-1)) {
		$nomes .= '{idprod:"'.$idprod.'", "junto":"'.$junto.'", "unid":"'.$unid.'", "custo":"'.$custo.'", "sigmed":"'.$sigla_medida.'", codprod:"'.$codprod.'"}';
	}else{
		$nomes .= '{idprod:"'.$idprod.'", "junto":"'.$junto.'", "unid":"'.$unid.'", "custo":"'.$custo.'", "sigmed":"'.$sigla_medida.'", codprod:"'.$codprod.'"},';
	}
}

echo ('{resultados: [ '.$nomes.']}');
}

?>