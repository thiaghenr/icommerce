<?php
include "../config.php";
require_once("../biblioteca.php");
conexao();

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

$acao = $_POST['acao'];

if($acao == "listarNotas"){ 
	

$rs    = mysql_query("SELECT d.*, date_format(d.dtlcto, '%d/%m/%Y') AS dtlcto, e.nome, sum(na.valor_abat) AS devolvido
		FROM entidades e, nota_credito d
		LEFT JOIN nc_abatimento na ON d.idnota_credito = na.idntcredito
		WHERE 1=1 
		AND d.status = 'A' 
		AND e.controle = d.idcliente 
		GROUP BY d.idnota_credito ORDER BY d.idnota_credito DESC ")or die (mysql_error().'-'.$rs);
	
	$arr = array();
	$count = 0;
	while($obj = mysql_fetch_object($rs)){

		$arr[] = $obj;
		
	}
	echo '({"results":'.json_encode($arr).'})'; 

	
}

if($acao == 'listarItens'){
$query = isset($_POST['devid']) ? $_POST['devid'] : 1;
 
 $rs    = mysql_query("SELECT *
            FROM itens_ntcredito 
            WHERE  id_credito = '$query'
            ORDER BY id_credito DESC ")or die (mysql_error());
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
	}
	echo '{"results":'.json_encode($arr).'}'; 
} 


if($acao == "UsarCredito"){


}






?>