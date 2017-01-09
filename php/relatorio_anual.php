<?php
require_once("../biblioteca.php");
include "../config.php";
conexao();

 	$sql = "SELECT EXTRACT(MONTH FROM p.data_car) AS MES,  EXTRACT(YEAR FROM p.data_car) AS ANO, 
	sum((p.total_nota)) AS total FROM  pedido p 
	WHERE p.status != 'C' AND p.situacao = 'F' 
	GROUP BY ANO,MES ORDER BY ANO,MES ASC";
		
	$arr = array();
	
$exe = mysql_query($sql);
$ano = "";
while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){
	if($ano !== $reg['ANO']){
		$arr[] = array('ANO'=>$reg['ANO'], $reg['MES'] => ($reg['total']));
		$ano = $reg['ANO'];
	}else{
		$arr[count($arr)-1][$reg['MES']] = ($reg['total']);
	}
}

echo '({"result":'.json_encode($arr).'})'; 

?>

<?
/* 
 	$sqlA = "SELECT EXTRACT(YEAR FROM data_car) AS ANO FROM cotacao GROUP BY ANO ORDER BY ANO DESC ";
	$exeA = mysql_query($sqlA);
	
	$arra = array();
	while ($regA = mysql_fetch_array($exeA, MYSQL_ASSOC)){
	
	 $arra[$regA['ANO']] =array('ano'=>$regA['ANO'],'1'=>'0','2'=>'0','3'=>'0','4'=>'0','5'=>'0','6'=>'0','7'=>'0','8'=>'0','9'=>'0','10'=>'0','11'=>'0','12'=>'0') ;

}

$sql = "SELECT EXTRACT(MONTH FROM data_car) AS MES,  EXTRACT(YEAR FROM data_car) AS ANO, sum(total_nota) AS total FROM cotacao WHERE 0=0 GROUP BY ANO,MES ORDER BY MES ASC";

$exe = mysql_query($sql);

while ($reg = mysql_fetch_array($exe, MYSQL_ASSOC)){

	 $arra[$reg['ANO']][$reg['MES']]=$reg['total'];
}

foreach ($arra as $chave => $valor) {
    $arr[]=$valor;
}
echo '({"result":'.json_encode($arr).'})'; 
*/

?>

