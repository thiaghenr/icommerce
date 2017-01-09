<?php
include "../config.php";
require_once("../biblioteca.php");
conexao();

echo $selectedRows = json_decode(stripslashes($_POST['id']));
$count        = 0;		

foreach($selectedRows as $row_id)
{
	$id  = (int) $row_id;
	$sql = "DELETE FROM contatos WHERE idcontatos = %d";	
	$sql = sprintf($sql, $id);
	mysql_query($sql);
	$rows_affected = mysql_affected_rows();			
	if ($rows_affected) $count++;
}

if ($count) {
	$response = array('success'=>'true', 'del_count'=>$count);			
	echo 'CONTATO ELIMINADO';
} else {
	echo '{failure: true}';
}
?>