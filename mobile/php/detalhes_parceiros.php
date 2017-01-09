<?php
require_once ("config.php");
conexao();
require_once ("biblioteca.php");
include_once("json/JSON.php");
$json = new Services_JSON();


$query = $_GET['query'];
$coluna = $_GET['coluna'];
if(empty($coluna)){
$coluna = "nome";
}

// Dados da tabela
$tabela = "OCRD";    #Nome da tabela
$campo1 = "ItemCode";  #Nome do campo da tabela
$campo2 = "ItemName";  #Nome de outro campo da tabela

//$r = sqlsrv_query ("SELECT ID,CODIGO,DESCR2 FROM produtos WHERE DESCR2 LIKE '$query%' ORDER BY DESCR2 ASC LIMIT 0,100");

$sql = "SELECT TOP 15 oc.[CardCode], oc.[CardName], oc.[CardFName], oc.[Phone1], oc.[Password],
		(SELECT TOP 1 cr.[Street] FROM [CRD1] cr WHERE cr.CardCode = '$query' AND cr.LineNum = 1 ) AS Street,
		(SELECT TOP 1 cr.[City] FROM [CRD1] cr WHERE cr.CardCode = '$query' AND cr.LineNum = 1 ) AS City,
		(SELECT TOP 1 cr.[Block] FROM [CRD1] cr WHERE cr.CardCode = '$query' AND cr.LineNum = 1 ) AS Block,
		sl.[SlpName], oc.[ListNum] FROM [OCRD] oc
		LEFT JOIN [OSLP] sl ON sl.[SlpCode] = oc.[SlpCode]
		WHERE 1=1 AND oc.[CardCode] = '$query' ORDER BY oc.CardName DESC ";
$exe = sqlsrv_query($db_link, $sql)or die(print_r(sqlsrv_errors(), true));
//$l = sqlsrv_num_rows ($r);

$arr = array();
while( $obj = sqlsrv_fetch_array( $exe, SQLSRV_FETCH_ASSOC) ) {
		
		$valor = number_format($obj['Price'],0,".","");
		
		$arr[] = array('CardCode'=>$obj['CardCode'], 'telefonecom'=>$obj['Phone1'], 'CardFName'=>$obj['CardFName'], 
		'seq'=>'1', 'ruc'=>$obj['Password'],'title'=>$obj['CardName'], 'vendedor'=>$obj['SlpName'], 'lista_precos'=>$obj['ListNum'],
		'endereco'=>$obj['Street'], 'cidade'=>$obj['City'], 'bairro'=>$obj['Block']);
	
	}
	
	echo '{ "items":'.json_encode($arr).'}'; 

?>