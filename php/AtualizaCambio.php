<?php
include "../config.php";
require_once("../biblioteca.php");
conexao();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


$acao = $_POST['acao'];
$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 31;

if($acao == "ListaMoedas"){	
	
	$rs    = mysql_query("SELECT m.id,m.nm_moeda FROM moeda m 
							WHERE m.padrao != 'S'
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
	
	
if($acao == "ListaCotacoes"){	
	 $moeda = $_POST['moeda'];
	 
	  $rss = mysql_query("SELECT id FROM cambio_moeda WHERE moeda_id = '$moeda	' ");
	  $rs    = mysql_query("SELECT date_format(m.data, '%d/%m/%Y') AS data, date_format(m.data, '%H:%i:%s') AS hora, 
						m.moeda_id, m.vl_cambio, m.vl_cambio_compra, m.id, u.nome_user
						FROM cambio_moeda m
						LEFT JOIN usuario u ON u.id_usuario = m.user
						WHERE moeda_id = '$moeda'  ORDER BY id DESC LIMIT $inicio, $limite ")or die (mysql_error().'-'.$rs);
	 $totalCotacoes = mysql_num_rows($rss);
	 $arr = array();
	 while($obj = mysql_fetch_object($rs)){
	  
	  $arr[] = $obj;	
	  }
		echo '{"totalCotacoes":'.$totalCotacoes.',"resultados":'.json_encode($arr).'}'; 


	
}

if($acao == "NovaMoeda"){
	$nm_moeda = $_POST['nome_moeda'];
	$user = $_POST['user'];
	$compra = $_POST['compra'];
	$venda = $_POST['venda'];

	$sql_nova = "INSERT INTO moeda (nm_moeda,user,datacad)
								VALUES(UCASE('$nm_moeda'), '$user', NOW() ) ";
	$exe_nova = mysql_query($sql_nova, $base);
	$moedaid = mysql_insert_id();
	$rows_affected = mysql_affected_rows();			
			if ($rows_affected){
			
				$sql_cot = "INSERT INTO cambio_moeda (moeda_id, vl_cambio, data, vl_cambio_compra, user)
								VALUES('$moedaid', '$venda', NOW(), '$compra', '$user') ";
				$exe_cot = mysql_query($sql_cot, $base);
				$rows_affected = mysql_affected_rows();			
					if ($rows_affected){
						echo "{success:true, response: 'Catastro efectuado exitosamente' }"; 
					}
			
			}
			else{
				echo "{success:true, response: 'Verifique' }"; 
			}

}

if($acao == "AtCot"){

$user = $_POST['user'];
$atcompra = $_POST['atcompra'];
$atvenda = $_POST['atvenda'];
$moedaid = $_POST['moedaid'];

				$sql_cot = "INSERT INTO cambio_moeda (moeda_id, vl_cambio, data, vl_cambio_compra, user)
								VALUES('$moedaid', '$atvenda', NOW(), '$atcompra', '$user') ";
				$exe_cot = mysql_query($sql_cot, $base);
				$rows_affected = mysql_affected_rows();			
					if ($rows_affected){
						echo "{success:true, response: 'Cotizacion Actualizada' }"; 
					}
					else{
						echo "{success:true, response: 'Verifique' }"; 
					}
}		





?>

