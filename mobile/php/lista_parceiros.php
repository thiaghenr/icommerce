<?php
require_once ("../../config.php");
conexao();
require_once ("../../biblioteca.php");
include_once("../../json/JSON.php");
$json = new Services_JSON();


$query = $_GET['query'];
$coluna = $_GET['coluna'];
if(empty($coluna)){
$coluna = "CardCode";
}

// Dados da tabela
$tabela = "OCRD";    #Nome da tabela
$campo1 = "ItemCode";  #Nome do campo da tabela
$campo2 = "ItemName";  #Nome de outro campo da tabela

//$r = mysql_query ("SELECT ID,CODIGO,DESCR2 FROM produtos WHERE DESCR2 LIKE '$query%' ORDER BY DESCR2 ASC LIMIT 0,100");

echo $sql = "SELECT TOP 15 oc.[CardCode],oc.[CardFName],oc.[CardName] FROM [OCRD] oc
		WHERE 1=1 AND oc.$coluna LIKE '$query%' ORDER BY oc.CardName DESC  ";
$exe = sqlsrv_query($db_link, $sql)or die(print_r(sqlsrv_errors(), true));
//$l = sqlsrv_num_rows ($r);
$ar = array();
$arr = array();
while( $obj = sqlsrv_fetch_array( $exe, SQLSRV_FETCH_ASSOC) ) {
		
		$valor = number_format($obj['Price'],0,".","");
		
		$arr[] = array('CardCode'=>$obj['CardCode'], 'seq'=>'1', 'CardFName'=>$obj['CardFName'],'title'=>$obj['CardName'],
'items'=> array( array('title'=>'Catastro', 'seq'=>'2', 'key'=>'1','leaf'=>true), array('title'=>'Pedidos', 'seq'=>'3', 'key'=>'1','leaf'=>true), array('title'=>'Titulos', 'key'=>'1','leaf'=>true)));
	}
	
	echo '{ "items":'.json_encode($arr).'}'; 

?>