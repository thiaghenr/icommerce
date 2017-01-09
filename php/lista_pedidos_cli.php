<?php
include "../config.php";
require_once("../biblioteca.php");
conexao();

$inicio = isset($_POST['start']) ? $_POST['start'] : 0;
$limite = isset($_POST['limit']) ? $_POST['limit'] : 20 ;
$acao   = isset($_POST['acao']) ? $_POST['acao'] : '';
$sort   = isset($_POST['sort']) ? $_POST['sort'] : '';
$idcliente   = isset($_POST['id']) ? $_POST['id'] : '';

if($idcliente > 0){
	$rs    = mysql_query("SELECT * FROM pedido WHERE controle_cli = '$idcliente' ");
	$total = mysql_num_rows($rs);
	$rs    = mysql_query("SELECT date_format(ct.data_car, '%d/%m/%Y') AS data_car, ct.controle_cli,ct.total_nota,ct.situacao,ct.vendedor_id,
                        ct.usuario_id,ct.id, us.id_usuario,us.nome_user FROM pedido ct, usuario us 
                        WHERE ct.controle_cli = '$idcliente' AND us.id_usuario = ct.usuario_id  
                        Order By ct.$sort DESC LIMIT $inicio, $limite  ")or die (mysql_error().'-'.$rs);	
	$arr = array();
	while($obj = mysql_fetch_object($rs))
	{
		$arr[] = $obj;
		

	}
	echo '({"totalPed":"'.$total.'","pedidos":'.json_encode($arr).'})'; 
} 

if($acao == 'UltimosPedidos'){
	$rs    = mysql_query("SELECT nome_cli,id,controle_cli,date_format(data_car, '%d-%m-%Y')AS data_car FROM pedido  order by id desc LIMIT 0,20 ");
	$arr = array();
	while($obj = mysql_fetch_object($rs)){
		$arr[] = $obj;
	}
	echo '({"totalPed":"'.$total.'","pedidos":'.json_encode($arr).'})'; 

}
?>