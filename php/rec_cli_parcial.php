<?php
require_once("../verifica_login.php");
require_once("../biblioteca.php");
include "../config.php";
conexao();


if(isset($_POST['acao'])){
if($_POST['acao'] == 'listarDados'){
$id = $_POST['id'];

$rs    = mysql_query("SELECT crp.idctreceber, crp.contas_rec_id, crp.valorpg, 
					crp.usuarioid, date_format(crp.datapg, '%d/%m/%Y')AS datapg, cr.id, v.pedido_id  
					FROM contas_recparcial crp, contas_receber cr, venda v
					WHERE cr.id = '$id' AND cr.id = crp.idctreceber AND cr.venda_id = v.id ORDER BY crp.contas_rec_id DESC")or die (mysql_error().''. $rs);

$arr = array();
$total = mysql_num_rows($rs);
while($obj = mysql_fetch_object($rs))
{	
	$arr[] = $obj;
	
}

//echo $_GET['callback'].'({"result":'.json_encode($arr).'})'; 
echo '({"total":'.$total.',"result":'.json_encode($arr).'})'; 
}

if($_POST['acao'] == 'ListaPagos'){
$id = $_POST['idCli'];

$rs    = mysql_query("SELECT crp.idctreceber, crp.contas_rec_id, crp.valorpg, 
					crp.usuarioid, date_format(crp.datapg, '%d/%m/%Y')AS datapg, cr.id, v.pedido_id  
					FROM contas_recparcial crp, contas_receber cr, venda v
					WHERE cr.clientes_id = '$id' AND cr.id = crp.idctreceber AND cr.venda_id = v.id ORDER BY crp.contas_rec_id DESC")or die (mysql_error().''. $rs);

$arr = array();
$total = mysql_num_rows($rs);
while($obj = mysql_fetch_object($rs))
{	
	$arr[] = $obj;
	
}

//echo $_GET['callback'].'({"result":'.json_encode($arr).'})'; 
echo '({"total":'.$total.',"result":'.json_encode($arr).'})'; 
}

}
?>