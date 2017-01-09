<?php
	require_once ("config.php");
    require_once("biblioteca.php");
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
	$acao = $_POST['acao'];

	
if($acao == "ListaMoedas"){	
$r = mysql_query ("SELECT m.id AS idm,m.nm_moeda FROM banco where nome_banco LIKE '%$query%' ORDER BY nome_banco ASC");
$l = mysql_num_rows ($r);

for($i=0;$i<$l;$i++){
	$id_banco = mysql_result ($r,$i,"id_banco");
	$nome_banco = mysql_result ($r,$i, "nome_banco");

	
	if($i == ($l-1)) {
		$nomes .= '{id_banco:'.$id_banco.',  nome_banco:"'.$nome_banco.' "}';
	}else{
		$nomes .= '{id_banco:'.$id_banco.',  nome_banco:"'.$nome_banco.' "},';
	}
}

echo ('{resultados: [ '.$nomes.']}');
}

if($acao == "ListaMoedasCheque"){
$padrao = $_POST['padrao'];	
$padrao = isset($_POST['padrao']) ? $_POST['padrao'] : 'S';
	
	$rs    = mysql_query("SELECT m.id,m.nm_moeda FROM moeda m 
							WHERE m.oficial = 'S'
							ORDER BY m.id ASC ")or die (mysql_error().'-'.$rs);
	$arr = array();
	while($obj = mysql_fetch_array($rs, MYSQL_ASSOC)){
	$total = mysql_num_rows($rs);
	
	$arr[] = $obj;	

}
foreach ($arr as $id => $prc) {

$rs    = mysql_query("SELECT id AS idc,moeda_id,vl_cambio,vl_cambio_compra FROM cambio_moeda 
					WHERE moeda_id = '".$prc['id']."'  ORDER BY id DESC LIMIT 0,1 ")or die (mysql_error().'-'.$rs);

$objs = mysql_fetch_array($rs, MYSQL_ASSOC);

$arrr[] = array('idc'=>$objs['idc'],'nm_moeda'=>$prc['nm_moeda'],'vl_cambio'=>$objs['vl_cambio'],
				'moeda_id'=>$objs['moeda_id'],'vl_cambio_compra'=>$objs['vl_cambio_compra']);

}
echo '{"total":"'.$total.'","resultados":'.json_encode($arrr).'}'; 
}	
?>