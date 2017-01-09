<?php
require_once ("../../config.php");
conexao();
require_once ("../../biblioteca.php");
include_once("../../php/json/JSON.php");
$json = new Services_JSON();

/*
$dbhost   = "WINSERVER";   #Nome do host
$db       = "SBO_SideragroNovateste";   #Nome do banco de dados
$user     = "sa"; #Nome do usuário
$password = "raposa28@09";   #Senha do usuário

$db_info = array('Database'=>$db, 'UID'=>$user, 'PWD'=>$password);   
$db_link = sqlsrv_connect($dbhost, $db_info);   
*/

$query = $_GET['query'];
$coluna = $_GET['coluna'];
if(empty($coluna) || $coluna == "ItemCode"){
$coluna = "Codigo";
}
if($coluna == "ItemName"){
$coluna = "Descricao";
}

// Dados da tabela
$tabela = "produtos";    #Nome da tabela
$campo1 = "Codigo";  #Nome do campo da tabela
$campo2 = "Descricao";  #Nome de outro campo da tabela

//$r = mysql_query ("SELECT ID,CODIGO,DESCR2 FROM produtos WHERE DESCR2 LIKE '$query%' ORDER BY DESCR2 ASC LIMIT 0,100");

$sql = "SELECT oi.id,oi.Codigo,oi.Descricao,oi.Estoque,oi.valor_a FROM produtos oi 
		WHERE 1=1 AND oi.$coluna LIKE '$query%' 
		ORDER BY oi.id DESC  ";
$exe = mysql_query($sql)or die(print_r(mysql_error()));
//$l = sqlsrv_num_rows ($r);

$arr = array();
while( $obj = mysql_fetch_array( $exe, MYSQL_ASSOC) ) {
		
		$valor = number_format($obj['valor_a'],0,".","");
		
		$arr[] = array('ItemCode'=>$obj['Codigo'], 'ItemName'=>$obj['Descricao'],'DocEntry'=>$obj['id'],
		'OnHand'=>number_format($obj['Estoque'],2,",","."), 'Price'=>guarani($valor));
	}
	
	echo '{ "resultados":'.json_encode($arr).'}'; 

//echo '{"resultados":[  '.$arr.']}';

?>